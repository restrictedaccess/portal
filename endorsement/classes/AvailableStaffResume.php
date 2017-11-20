<?php
/**
 *
 * Object to retrieve html content of the approved resume
 *
 * @author		Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au
 *
 * 2011-11-15    Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
 * -   fname fix
 * -   gender, nationality fix
 * 2011-09-21    Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
 * -   fixed sorting of evaluation comments
 * 2011-09-20    Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
 * -   sorted evaluation_comments
 * 2011-05-12    Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
 * -   hide the price instead of redirecting
 */
class AvailableStaffResume {
    /**
    *
    * Initialize object
    */
    function __construct ($db) {
        include('/conf/zend_smarty_conf.php');
        include_once('/portal/lib/AvailableStaffCheckSum.php');
        $this->db = $db;
        $this->logger = $logger;
        $this->show_currency_code = Array('AUD', 'GBP', 'USD');
    }

    private function GetValidVoice() {
        $voice_md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'voice', '');
        $voice_md5->portal_path = 'portal/';
        if(!$voice_md5->Valid()) {
            $voice = '';
            $voice_type = '';
        }
        else {
            //get voice from personal table
            $sql = $this->db->select()
                    ->from('personal', 'voice_path')
                    ->where('userid = ?', $this->userid);
            $this->voice = $this->db->fetchOne($sql);

            if (!$this->voice) {
                $this->voice_type = '';
            }
            if (!file_exists("portal/".$this->voice)) {
                $this->voice_type = '';
            }

            $voice_path_array = str_split($this->voice);
            $this->voice_type = join(array_slice($voice_path_array, -3, 3));
        }
    }


    private function GetValidEducation() {
        $sql = $this->db->select()
                ->from('education')
                ->where('userid = ?', $this->userid);
        $education = $this->db->fetchRow($sql);
        if ($education) {
            try {
                $graduation_date = new DateTime(sprintf('%s-%s-01', $education['graduate_year'], $education['graduate_month']));
                $education['graduation_date'] = $graduation_date->format('M Y');
            }
            catch (Exception $e){
                $education['graduation_date'] = '';
            }
        }
        else {
            $education['educationallevel'] = '';
            $education['fieldstudy'] = '';
            $education['major'] = '';
            $education['college_name'] = '';
            $education['college_country'] = '';
            $education['college_country'] = '';
            $education['graduation_date'] = '';
            $education['gpascore'] = '';
            return $education;
        }

        $fields = Array('educationallevel', 'fieldstudy', 'major', 'college_name', 'college_country', 'graduate_year', 'graduate_month', 'graduation_date', 'gpascore');

        $return_data = Array();
        foreach ($fields as $field) {
            $md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'education', $field);
            if ($md5->Valid()) {
                $return_data[$field] = $education[$field];
            }
            else {
                $return_data[$field] = '';
            }
        }
        return $return_data;
    }


    private function GetHourlyRate($monthly_rate, $full_time = True) {
        $yearly_rate = $monthly_rate * 12;
        $weekly_rate = $yearly_rate / 52;
        $daily_rate = $weekly_rate / 5;
        if ($full_time) {
            $hourly_rate = $daily_rate / 8;
        }
        else {
            $hourly_rate = $daily_rate / 4;
        }

        return $hourly_rate;
    }


    public function GetHtmlResume($userid, $template = False, $show_price = False) {
    	global $couch_dsn, $couch_resume_db;
        $this->userid = $userid;

        if ($userid == '') {
            die('userid expected');
        }

        $sql = $this->db->select()
                ->from('personal')
                ->where('userid = ?', $this->userid);

        $personal = $this->db->fetchRow($sql);

        if (!$personal) {
            die('userid not found!');
        }

        //validate voice
        $this->GetValidVoice();


        //evaluation
        $sql = $this->db->select()
                ->from('evaluation_comments')
                ->where('userid = ?', $this->userid);
        $evaluation_comments = $this->db->fetchAll($sql);

        /*$valid_evaluation_comments = Array();
        foreach ($evaluation_comments as $evaluation_comment) {
            $id = $evaluation_comment['id'];
            $md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'evaluation_comments', $id);
            if ($md5->Valid()) {
                $valid_evaluation_comments[] = $evaluation_comment['comments'];
            }
        }*/

        //get birthday
        try {
            $date_of_birth = new DateTime(sprintf('%s-%s-%s', $personal['byear'], $personal['bmonth'], $personal['bday']));
        }
        catch (Exception $e) {
            $date_of_birth = new DateTime();
        }

        //age computation
        $now = new DateTime();
        $age = $now->format('Y') - $date_of_birth->format('Y');
        $x_now = new DateTime(sprintf('2010-%s-%s', $now->format('m'), $now->format('d')));
        $x_date_of_birth = new DateTime(sprintf('2010-%s-%s', $date_of_birth->format('m'), $date_of_birth->format('d')));
        if ($x_now->format('U') < $x_date_of_birth->format('U')) {
            $age -= 1;
        }

        $home_working_environment_md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'personal', 'home_working_environment');
        if ($home_working_environment_md5->Valid()){
            $home_working_environment = $personal['home_working_environment'];
        }

        $internet_connection_md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'personal', 'internet_connection');
        if ($internet_connection_md5->Valid()) {
            $internet_connection = $personal['internet_connection'];
        }

        $computer_hardware_md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'personal', 'computer_hardware');
        if ($computer_hardware_md5->Valid()) {
            $computer_hardware = $personal['computer_hardware'];
        }

        $headset_quality_md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'personal', 'headset_quality');
        if ($headset_quality_md5->Valid()) {
            $headset_quality = $personal['headset_quality'];
        }

        //get currencies and select from session
        $sql = $this->db->select()
                ->from('currency_lookup')
                ->where('code IN (?)', $this->show_currency_code);
        $currency_lookups = $this->db->fetchAll($sql);

        $currency_id = $_SESSION['selected_currency_id'];
        if ($currency_id == '') {
            //$selected_currency_code = 'AUD';
			switch(LOCATION_ID) {
				case 1:
					$selected_currency_code = 'AUD';
					break;
				case 2:
					$selected_currency_code = 'GBP';
					break;
				case 3:
					$selected_currency_code = 'USD';
					break;
				case 4:
					$selected_currency_code = 'PHP';
					break;
			}
        }
        else {
            $sql = $this->db->select()
                    ->from('currency_lookup', 'code')
                    ->where('id = ?', $currency_id);
            $selected_currency_code = $this->db->fetchOne($sql);
            if (!$selected_currency_code) {
                $selected_currency_code = 'AUD';
            }
        }

        //get fulltime/part time rates
        $sql = $this->db->select()
                ->from('staff_rate', Array('full_time_product_id' => 'product_id', 'part_time_product_id' => 'part_time_product_id'))
                ->where('userid = ?', $this->userid)
                ->order('date_updated DESC')
                ->limit(1);
        $products = $this->db->fetchRow($sql);

        $staff_prices = Array();

        if ($products) {
            //get the amount
            foreach($this->show_currency_code as $currency_code) { 
                //get currency_id for the selected code
                $sql = $this->db->select()
                        ->from('currency_lookup', Array('id', 'sign'))
                        ->where('code = ?', $currency_code);
                $data = $this->db->fetchRow($sql);
                $cid = $data['id'];
                $currency_sign = $data['sign'];

                //fulltime rate
                $sql = $this->db->select()
                        ->from('product_price_history', 'amount')
                        ->where('product_id = ?', $products['full_time_product_id'])
                        ->where('currency_id = ?', $cid)
                        ->order('date DESC')
                        ->limit(1);
                $full_time_rate = $this->db->fetchOne($sql);
                $full_time_hourly_rate = $this->GetHourlyRate($full_time_rate);

                //parttime rate
                $sql = $this->db->select()
                        ->from('product_price_history', 'amount')
                        ->where('product_id = ?', $products['part_time_product_id'])
                        ->where('currency_id = ?', $cid)
                        ->order('date DESC')
                        ->limit(1);
                $part_time_rate = $this->db->fetchOne($sql);
                $part_time_hourly_rate = $this->GetHourlyRate($part_time_rate, $full_time = False);

                $staff_prices[] = Array(
                    'currency_code' => $currency_code,
                    'currency_sign' => $currency_sign,
                    'full_time_rate' => $full_time_rate,
                    'full_time_hourly_rate' => $full_time_hourly_rate,
                    'part_time_rate' => $part_time_rate,
                    'part_time_hourly_rate' => $part_time_hourly_rate
                );
            }
        }
		
		/****COUCH DATA*****/
		include('conf/zend_smarty_conf.php');
		
		switch(LOCATION_ID) {
			case 1:
				$currency_id = 3;
				break;
			case 2:
				$currency_id = 4;
				break;
			case 3:
				$currency_id = 5;
				break;
			case 4:
				$currency_id = 6;
				break;
		}
		
		try{
			if (!isset($couch_resume_db)){
				$couch_resume_db = 'resume';
			}
			$couch_resume = new couchClient($couch_dsn, $couch_resume_db);
			$resume=$couch_resume->getDoc($userid);
		} catch ( Exception $e ) {
			die(" Viewing of this document is restricted ");
		}
		$valid_evaluation_comments = Array();
		if($resume->evaluation_comments!=NULL){
            $evaluation_comments = Array();
            foreach($resume->evaluation_comments as $key => $comment){
                $evaluation_comments[$key] = $comment;
            }                            
            ksort($evaluation_comments);
            foreach($evaluation_comments as $comment){
					$valid_evaluation_comments[] ='<div class="evaluation_comment">'.$comment->comment.'</div>';
			}
		}
		
		//echo "<pre>";
		//var_dump($resume);
		//echo "</pre>"; 
		
		$education = Array();
		$education['educationallevel'] = $resume->education->educationallevel;
        $education['fieldstudy'] = $resume->education->fieldstudy;
        $education['major'] = $resume->education->major;
        $education['college_name'] = $resume->education->college_name;
        $education['college_country'] = $resume->education->college_country;
        $education['graduation_date'] = $resume->education->graduate_year."-".$resume->education->graduate_month;
		
		$employment_history = Array();
		if($resume->currentjob!=NULL){
			foreach($resume->currentjob as $job){
				$company[ 'employment_period'] = $job->monthfrom." ".$job->yearfrom."to".$job->monthto." ".$job->yearto;
				$company['companyname']=$job->companyname;
				$company['position']=$job->position;
				$company['duties']=$job->duties;
				$employment_history[]=$company;
			}
		}
		
		$language_set = Array();
		if($resume->language!=NULL){
			foreach($resume->language as $language){
				$languages['language']=$language->language;
				$languages['spoken']=$language->spoken;
				$languages['written']=$language->written;
				$languages_set[]=$languages;
			}
		}
		
		$skill_set = Array();
		if($resume->skills!=NULL){
			foreach($resume->skills as $skill){
				$skills['skill']=$skill->skill;
				$skills['experience']=$skill->experience;
				$skills['proficiency']=$skill->proficiency;
				$skill_set[]=$skills;
			}
		}
		
		//sample files
		$sample_set = Array();
		if($resume->tb_applicant_files!=NULL){
			foreach($resume->tb_applicant_files as $key=>$file){
				//$sample['id']=$key;
				$sample['description']=$file->file_description;
				$sample['name']=$key;	
				$sample_set[]=$sample;
			}
		}

		if($resume->_attachments!=NULL){
			foreach($resume->_attachments as $key=>$attachment){
				if((strpos($key,'.mp3')!==false)||(strpos($key,'.wav')!==false)){
					$voice = $key;
					$voice_type=$attachment->content_type;
				}
			}
		}
		
		include_once('ShowPrice.php');
		$show_price = ShowPrice::Show();

        $smarty = new Smarty;
        $smarty->assign('userid', $this->userid);
        $smarty->assign('fname', $resume->fname);
        $smarty->assign('valid_evaluation_comments', $valid_evaluation_comments);
        $smarty->assign('age', $age);
        $smarty->assign('nationality', $resume->nationality);
        $smarty->assign('date_of_birth', $date_of_birth->format('M d, Y'));
        $smarty->assign('gender', $resume->gender);
        $smarty->assign('country_id', $personal['country_id']);
        $smarty->assign('home_working_environment', $resume->home_working_environment);
        $smarty->assign('internet_connection', $resume->internet_connection);
        $smarty->assign('computer_hardware', $resume->computer_hardware);
        $smarty->assign('headset_quality', $resume->headset_quality);
        //$smarty->assign('education', $this->GetValidEducation());
        $smarty->assign('education', $education);
        //$smarty->assign('currentjob', $this->GetValidCurrentJob());
        $smarty->assign('currentjob', $employment_history);
        $smarty->assign('availability', $this->GetAvailability());
        $smarty->assign('timezone_availability', $this->GetTimeZoneAvailability());
        //$smarty->assign('language', $this->GetValidLanguage());
        $smarty->assign('language',$languages_set);
        //$smarty->assign('skills', $this->GetValidSkills());
        $smarty->assign('skills', $skill_set);
        //$smarty->assign('voice', $this->voice);
        $smarty->assign('voice', $voice);
        //$smarty->assign('voice_type', $this->voice_type);
        $smarty->assign('voice_type', $voice_type);
        //$smarty->assign('applicant_files', $this->GetValidApplicantFiles());
        $smarty->assign('applicant_files', $sample_set);
        $smarty->assign('PERMALINK', $_SERVER["HTTP_HOST"]);
        $smarty->assign('selected_currency_code', $selected_currency_code);
        $smarty->assign('currency_codes', $this->show_currency_code);
        $smarty->assign('staff_prices', $staff_prices);
        $smarty->assign('show_price', $show_price);
        return $smarty->fetch($template);
    }

    private function GetTimeZoneAvailability() {
        $sql = $this->db->select()
                ->from("staff_timezone", array("time_zone"))
                ->where("userid = ?", $this->userid);
        $availability = '';
        $time_zone = $this->db->fetchOne($sql);
        $availability_array = explode(",", $time_zone);
        if (in_array('ANY', $availability_array)) {
            $availability = "Can work AU, UK and US Business Hours";
        }
        else {
            if ($availability_array[0] != '') {
                if (count($availability_array) == 1) {
                    $availability = sprintf("Can work %s Business Hours", $availability_array[0]);
                }
                else {
                    $tz = '';
                    for ($i = 0; $i < (count($availability_array) - 1); $i++) {
                        $tz .= $availability_array[$i];
                        if ($i < count($availability_array) - 2) {
                            $tz .= ", ";
                        }
                        else {
                            $tz .= sprintf(" and %s", $availability_array[$i + 1]);
                        }
                    }
                    $availability = sprintf("Can work %s Business Hours", $tz);
                }
            }
        }
        return $availability;
    }


    private function GetAvailability() {
        $sql = $this->db->select()
                ->from('currentjob', Array('available_status', 
                    'available_notice',
                    'aday',
                    'amonth',
                    'ayear'
                    ))
                ->where('userid = ?', $this->userid);
        return $this->db->fetchRow($sql);
    }


    private function GetValidCurrentJob() {
        $sql = $this->db->select()
                ->from('currentjob')
                ->where('userid = ?', $this->userid);
        $currentjob = $this->db->fetchRow($sql);

        $counter = Array('', '2', '3', '4', '5', '6', '7', '8', '9', '10');

        $return_data = Array();
        foreach ($counter as $x) {
            $company = Array();
            foreach (Array('companyname', 'position', 'employment_period', 'duties') as $resource) {
                $resource_x = sprintf('%s%s', $resource, $x);
                $md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'currentjob', $resource_x);
                if($md5->Valid()) {
                    if ($resource == 'employment_period') {
                        $company[$resource] = sprintf ('%s %s to %s %s',
                            $currentjob['monthfrom'.$x],
                            $currentjob['yearfrom'.$x],
                            $currentjob['monthto'.$x],
                            $currentjob['yearto'.$x]
                            );
                    }
                    else {
                        $company[$resource] = $currentjob[$resource_x];
                    }
                }
                else {
                    $company[$resource] = '';
                }
            }
            if (!$currentjob['companyname'.$x]) {
                continue;
            }
            $return_data[] = $company;
        }

        return $return_data;
    }


    private function GetValidLanguage() {
        $return_data = Array();
        $sql = $this->db->select()
                ->from('language')
                ->where('userid = ?', $this->userid);
        $data = $this->db->fetchAll($sql);

        foreach ($data as $language) {
            $md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'language', $language['id']);
            if ($md5->Valid()) {
                $return_data[] = $language;
            }
        }

        return $return_data;
    }

    private function GetValidSkills() {
        $return_data = Array();

        $sql = $this->db->select()
                ->from('skills')
                ->where('userid = ?', $this->userid);
        $data = $this->db->fetchAll($sql);

        foreach ($data as $skill) {
            $md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'skills', $skill['id']);
            if ($md5->Valid()) {
                $return_data[] = $skill;
            }
        }
        return $return_data;
    }

    private function GetValidApplicantFiles() {
        $sql = $this->db->select()
                ->from('tb_applicant_files')
                ->where('userid = ?', $this->userid);

        $return_data = Array();
        $data = $this->db->fetchAll($sql);
        
        foreach ($data as $file) {
            $md5 = new AvailableStaffCheckSum($this->userid, $this->db, 'tb_applicant_files', $file['id']);
            $md5->portal_path = 'portal/';  //variable to locate path
            if ($md5->Valid()) {
                $return_data[] = $file;
            }
        }

        return $return_data;
    }

}