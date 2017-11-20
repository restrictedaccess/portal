<?php
class RecruiterHomeLister{
	private $db;
	private $recruitment_collection;
	
	private $date_from, $date_to;
	
	private $recruiter_ids = array();
	
	private $count = 0;
	
	public function __construct($db){
		$this->db = $db;
		try{
			$retries = 0;
			while(true){
				try{
					if (TEST){
						$mongo = new MongoClient(MONGODB_TEST);
						$database = $mongo->selectDB('prod');
					}else{
						$mongo = new MongoClient(MONGODB_SERVER);
						$database = $mongo->selectDB('prod');
					}
					break;
				} catch(Exception $e){
					++$retries;
					
					if($retries >= 100){
						break;
					}
				}
			}
				
			$recruitment_collection = $database->selectCollection('recruitment');
			$this->recruitment_collection = $recruitment_collection;
			
		}catch(Exception $e){
			
		}
		$this->gatherInput();
	
		$this->init();
		
	}
	
	private function init(){
		$db = $this->db;
		$recruiters = $this->getRecruiters();
		foreach($recruiters as $recruiter){
			$this->recruiter_ids[] = intval($recruiter["admin_id"]);
		}
	}
	
	private function gatherInput(){
		if (isset($_REQUEST["date_from"])&&($_REQUEST["date_from"])){
			$this->date_from = $_REQUEST["date_from"];
		}
		if (isset($_REQUEST["date_to"])&&($_REQUEST["date_to"])){
			$this->date_to = $_REQUEST["date_to"];
			$this->date_to = date("Y-m-d", strtotime($this->date_to." +1 day"));
		}
		
	}
	
	public function getList(){
		$db = $this->db;
		$recruiters = $this->getRecruiters();
		
		foreach($recruiters as $key=>$recruiter){
			$recruiters[$key]["tnc"] = $this->getTotalNumberOfCandidates($recruiter["admin_id"]);
			$recruiters[$key]["unprocessed"] = $this->getUnprocessedCandidatesCount($recruiter["admin_id"]);
			$recruiters[$key]["prescreened"] = $this->getPrescreenedCandidatesCount($recruiter["admin_id"]);
			$recruiters[$key]["shortlisted"] = $this->getShortlistedCandidatesCount($recruiter["admin_id"]);
			$recruiters[$key]["endorsed"] = $this->getEndorsedCandidatesCount($recruiter["admin_id"]);
			$recruiters[$key]["categorized"] = $this->getCategorizedCandidatesCount($recruiter["admin_id"]);
			$recruiters[$key]["inactive"] = $this->getInactiveCandidatesCount($recruiter["admin_id"]);
			$recruiters[$key]["asl_booked"] = $this->getASLBookedCandidatesCount($recruiter["admin_id"]);
			$recruiters[$key]["custom_booked"] = $this->getCustomBookedCandidatesCount($recruiter["admin_id"]);
			
		}	
		
		return array("success"=>true, "result"=>$recruiters);
	}
	
	public function getUnprocessedCandidatesCount($recruiter_id){
		$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"unprocessed_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->find($filter);
		return $cursor->count();
	}
	
	
	public function getUnprocessedCandidates($recruiter_id){
		$db = $this->db;
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"unprocessed_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"unprocessed_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}	
		
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->find($filter);
		
		$candidates = array();
		while($cursor->hasNext()){
			$candi = $cursor->getNext();
			$sql = $db->select()->from(array("p"=>"personal"), array("p.fname", "p.lname","p.userid", "p.email", "p.datecreated AS date_created", "p.image"))->where("p.userid = ?", $candi["userid"]);
			$personal = $db->fetchRow($sql);
			$personal["date_created"] = date("F d, Y", $candi["date"]->sec);
			
			$candidates[] = $personal;
		}
		return $candidates;
	}
	
	
	public function getPrescreenedCandidatesCount($recruiter_id){
		$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"pre_screened_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->find($filter);
		return $cursor->count();
	}

	public function getPrescreenedCandidates($recruiter_id){
		$db = $this->db;
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"pre_screened_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"pre_screened_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));		
		}
		
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->find($filter);
		$candidates = array();
		while($cursor->hasNext()){
			$candi = $cursor->getNext();
			$sql = $db->select()->from(array("p"=>"personal"), array("p.fname", "p.lname", "p.userid", "p.email", "p.datecreated AS date_created", "p.image"))->where("p.userid = ?", $candi["userid"]);
			$personal = $db->fetchRow($sql);
			$personal["date_created"] = date("F d, Y", $candi["date"]->sec);
			$candidates[] = $personal;
		}
		return $candidates;
	}
	
	
	public function getShortlistedCandidatesCount($recruiter_id){
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"tb_shortlist_history", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));			
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"tb_shortlist_history", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));		
		}
		$group = array('_id'=>'$userid', 'shortlist_dates'=>array('$addToSet'=>'$date'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		return count($cursor["result"]);
	}
	public function getShortlistedCandidates($recruiter_id){
		$db = $this->db;
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"tb_shortlist_history", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));			
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"tb_shortlist_history", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));		
		}
		$group = array('_id'=>'$userid', 'shortlist_dates'=>array('$addToSet'=>'$date'), "keys"=>array('$addToSet'=>'$key'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		$result = $cursor["result"];
		
		$candidates = array();
		foreach($result as $candi){
			$sql = $db->select()->from(array("p"=>"personal"), array("p.fname", "p.lname", "p.userid", "p.email", "p.datecreated AS date_created", "p.image"))->where("p.userid = ?", $candi["_id"]);
			$personal = $db->fetchRow($sql);
			$shortlists = array();
			foreach($candi["keys"] as $key=>$shortlist_id){
				$sql = $db->select()->from(array("sh"=>"tb_shortlist_history"), array("sh.id AS shortlist_id", "sh.rejected", new Zend_Db_Expr("DATE(sh.date_listed) AS date_shortlist")))
						->joinLeft(array("p"=>"posting"), "p.id = sh.position", array("p.id AS posting_id", "p.jobposition"))
						->joinLeft(array("l"=>"leads"), "l.id = p.lead_id", array("l.fname AS lead_firstname", "l.lname AS lead_lastname", "l.id AS lead_id"))
						->where("sh.id = ?", $shortlist_id);
				$shortlist = $db->fetchRow($sql);
				if ($shortlist){
					$shortlist["date_shortlist"] = date("F d, Y", strtotime($shortlist["date_shortlist"]));
				}
				$shortlists[] = $shortlist;
			}
			$personal["shortlists"] = $shortlists;
			$candidates[] = $personal;
		}
		
		return $candidates;
	}
	public function getEndorsedCandidatesCount($recruiter_id){
		$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"tb_endorsement_history", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		$group = array('_id'=>'$userid', 'endorsed_dates'=>array('$addToSet'=>'$date'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		return count($cursor["result"]);
	}
	public function getEndorsedCandidates($recruiter_id){
		$db = $this->db;
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"tb_endorsement_history", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"tb_endorsement_history", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));		
		}
		$group = array('_id'=>'$userid', 'endorsed_dates'=>array('$addToSet'=>'$date'), 'keys'=>array('$addToSet'=>'$key'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		$result = $cursor["result"];
		
		$candidates = array();
		foreach($result as $candi){
			$sql = $db->select()->from(array("p"=>"personal"), array("p.fname", "p.lname", "p.userid", "p.email", "p.datecreated AS date_created", "p.image"))->where("p.userid = ?", $candi["_id"]);
			$personal = $db->fetchRow($sql);
			$endorsements = array();
			foreach($candi["keys"] as $key=>$endorsed_id){
				$sql = $db->select()->from(array("e"=>"tb_endorsement_history"), array("e.id AS endorsement_id", "e.rejected", new Zend_Db_Expr("DATE(e.date_endoesed) AS date_endorsed")))
						->joinLeft(array("l"=>"leads"), "l.id = e.client_name", array("l.fname AS lead_firstname", "l.lname AS lead_lastname", "l.id AS lead_id"))
						->where("e.id = ?", $endorsed_id);
				$endorsement = $db->fetchRow($sql);
				$endorsement["date_endorsed"] = date("F d, Y", strtotime($endorsement["date_endorsed"]));
				$endorsements[] = $endorsement;
			}
			$personal["endorsements"] = $endorsements;
			$candidates[] = $personal;
		}
		return $candidates;
		
	}
	public function getCategorizedCandidatesCount($recruiter_id){
		$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"job_sub_category_applicants", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		$group = array('_id'=>'$userid', 'categorized_dates'=>array('$addToSet'=>'$date'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		return count($cursor["result"]);
		
	}
	
	public function getCategorizedCandidates($recruiter_id){
		$db = $this->db;
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"job_sub_category_applicants", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"job_sub_category_applicants", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));		
		}
		$group = array('_id'=>'$userid', 'categorized_dates'=>array('$addToSet'=>'$date'), 'keys'=>array('$addToSet'=>'$key'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		$result = $cursor["result"];
		
		$candidates = array();
		foreach($result as $candi){
			$sql = $db->select()->from(array("p"=>"personal"), array("p.fname", "p.lname", "p.userid", "p.email", "p.datecreated AS date_created", "p.image"))->where("p.userid = ?", $candi["_id"]);
			$personal = $db->fetchRow($sql);
			$jscas = array();
			foreach($candi["keys"] as $key=>$jsca_id){
				$sql = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.id", "jsca.sub_category_applicants_date_created"))
						->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))
						->where("jsca.id = ?", $jsca_id);
				$jsca = $db->fetchRow($sql);	
				if ($jsca){
					$jsca["date_categorized"] =  date("F d, Y", strtotime($jsca["sub_category_applicants_date_created"]));
				}		
				$jscas[] = $jsca;
			}
			$personal["categorized"] = $jscas;
			$candidates[] = $personal;
		}
		return $candidates;
		
	}
	
	
	
	public function getInactiveCandidatesCount($recruiter_id){
		$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"inactive_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->find($filter);
		return $cursor->count();
		
	}
	
	public function getInactiveCandidates($recruiter_id){
		$db = $this->db;
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"inactive_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"inactive_staff", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}
		
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->find($filter);
		$candidates = array();
		while($cursor->hasNext()){
			$candi = $cursor->getNext();
			$sql = $db->select()->from(array("p"=>"personal"), array("p.fname", "p.lname", "p.userid", "p.email", "p.datecreated AS date_created", "p.image"))->where("p.userid = ?", $candi["userid"]);
			$personal = $db->fetchRow($sql);
			$personal["inactive_type"] = $candi["inactive_type"];
			$personal["date_created"] = date("F d, Y", $candi["date"]->sec);
			$candidates[] = $personal;
		}
		return $candidates;		
	}
	
	public function getASLBookedCandidatesCount($recruiter_id){
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"tb_request_for_interview", "interview_service_type"=>"ASL", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"tb_request_for_interview", "interview_service_type"=>"ASL", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}
		
		$group = array('_id'=>'$userid', 'interview_dates'=>array('$addToSet'=>'$date'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		return count($cursor["result"]);
	}
	
	public function getASLBookedCandidates($recruiter_id){
		$db = $this->db;
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"tb_request_for_interview", "interview_service_type"=>"ASL", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"tb_request_for_interview", "interview_service_type"=>"ASL", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}
		
		$group = array('_id'=>'$userid', 'interview_dates'=>array('$addToSet'=>'$date'), 'keys'=>array('$addToSet'=>'$key'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		$result = $cursor["result"];
		
		$candidates = array();
		foreach($result as $candi){
			$sql = $db->select()->from(array("p"=>"personal"), array("p.fname", "p.lname", "p.userid", "p.email", "p.datecreated AS date_created", "p.image"))->where("p.userid = ?", $candi["_id"]);
			$personal = $db->fetchRow($sql);
			
			$interviews = array();
			foreach($candi["keys"] as $key=>$id){
				$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.status"))
							->joinLeft(array("l"=>"leads"), "l.id = tbr.leads_id",array("l.fname AS lead_firstname", "l.lname AS lead_lastname", "l.id AS lead_id") )
							->where("tbr.id = ?", $id);
				$interview = $db->fetchRow($sql);
				if ($interview){
					$interview["date_added"] =  date("F d, Y", $candi["interview_dates"][$key]->sec);
				}
				$interviews[] = $interview;
			}
			
			$personal["interviews"] = $interviews;
			$candidates[] = $personal;
		}
		return $candidates;
	}
	
	public function getCustomBookedCandidatesCount($recruiter_id){
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"tb_request_for_interview", "interview_service_type"=>"CUSTOM", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"tb_request_for_interview", "interview_service_type"=>"CUSTOM", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}
		
		$group = array('_id'=>'$userid', 'interview_dates'=>array('$addToSet'=>'$date'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		return count($cursor["result"]);
	}
	
	
	public function getCustomBookedCandidates($recruiter_id){
		$db = $this->db;
		if ($recruiter_id=="all"){
			$filter = array("assigned_recruiter_id"=>array('$in'=>$this->recruiter_ids), "table"=>"tb_request_for_interview", "interview_service_type"=>"CUSTOM", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}else{
			$filter = array("assigned_recruiter_id"=>intval($recruiter_id), "table"=>"tb_request_for_interview", "interview_service_type"=>"CUSTOM", "date"=>array('$gte'=>new MongoDate(strtotime($this->date_from)), '$lte'=>new MongoDate(strtotime($this->date_to))));
		}
		
		$group = array('_id'=>'$userid', 'interview_dates'=>array('$addToSet'=>'$date'), 'keys'=>array('$addToSet'=>'$key'));
			
		$aggregate = array(
			array('$match'=>$filter),
			array('$group'=>$group)
		
		);
		$recruitment_collection = $this->recruitment_collection;
		$cursor = $recruitment_collection->aggregate($aggregate);
		$result = $cursor["result"];
		
		$candidates = array();
		foreach($result as $candi){
			$sql = $db->select()->from(array("p"=>"personal"), array("p.fname", "p.lname", "p.userid", "p.email", "p.datecreated AS date_created", "p.image"))->where("p.userid = ?", $candi["_id"]);
			$personal = $db->fetchRow($sql);
			
			$interviews = array();
			foreach($candi["keys"] as $key=>$id){
				$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.status"))
							->joinLeft(array("l"=>"leads"), "l.id = tbr.leads_id",array("l.fname AS lead_firstname", "l.lname AS lead_lastname", "l.id AS lead_id") )
							->where("tbr.id = ?", $id);
				$interview = $db->fetchRow($sql);
				if ($interview){
					$interview["date_added"] =  date("F d, Y", $candi["interview_dates"][$key]->sec);
				}
				$interviews[] = $interview;
			}
			
			$personal["interviews"] = $interviews;
			$candidates[] = $personal;
		}
		return $candidates;
	}
	
	
	public function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR' 
		OR admin_id='41'
		OR admin_id='67'
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81')   AND admin_id <> 161  
		AND status <> 'REMOVED'  AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
	
	public function getTotalNumberOfCandidates($recruiter_id){
		$db = $this->db;	
		return $db->fetchOne($db->select()
			->from(array("rs"=>"recruiter_staff"), array(new Zend_Db_Expr("COUNT(*) AS total")))
			->where("admin_id = ?", $recruiter_id)
			->where("DATE(rs.date) >= ?", $this->date_from)
			->where("DATE(rs.date) <= ?", $this->date_to));
	}
	
	public function getCandidates($recruiter_id){
		$db = $this->db;	
		$candidates = array();
		if ($recruiter_id=="all"){
			$candidates = $db->fetchAll($db->select()
				->from(array("rs"=>"recruiter_staff"), array("rs.userid AS userid", "rs.date AS date_recruited"))
				->joinLeft(array("p"=>"personal"), "p.userid = rs.userid", array("p.fname", "p.lname", "p.userid", "p.image", "p.email"))
				->where("admin_id IN (".implode(",", $this->recruiter_ids).")")
				->where("DATE(rs.date) >= ?", $this->date_from)
				->where("DATE(rs.date) <= ?", $this->date_to));			
		}else{
			$candidates = $db->fetchAll($db->select()
				->from(array("rs"=>"recruiter_staff"), array("rs.userid AS userid", "rs.date AS date_recruited"))
				->joinLeft(array("p"=>"personal"), "p.userid = rs.userid", array("p.fname", "p.lname", "p.userid", "p.image", "p.email"))
				->where("admin_id = ?", $recruiter_id)
				->where("DATE(rs.date) >= ?", $this->date_from)
				->where("DATE(rs.date) <= ?", $this->date_to));			
		}
		foreach($candidates as $key=>$candidate){
			$candidates[$key]["date_recruited"] = date("F d, Y", strtotime($candidates[$key]["date_recruited"]));
		}
		
		return $candidates;
	}
	
}
