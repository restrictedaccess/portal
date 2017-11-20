<?php
abstract class AbstractProcess{
	protected $db, $smarty;
	protected $skipFields = array();
	
	public function __construct($db){
		session_start();
		$this->db = $db;
		$this->smarty = new Smarty();
		$this->authCheck();
	}
	
	protected function authCheck(){
		//$_SESSION["userid"] = 30;
		session_start();
		if(!isset($_SESSION['userid']))
		{
			header("location:/portal/index.php");
		}
				
	}
	
	protected function getPostData(){
		$data = array();
		foreach($_POST as $key=>$value){
			if (!in_array($key, $this->skipFields)){
				$data[$key] = $value;
			}
		}
		return $data;
	}
	
	protected function filterfield($fieldname){
		$fieldname = str_replace("'", "",$fieldname);
		$fieldname = str_replace("�", 'n',$fieldname);
		$fieldname = stripslashes($fieldname);
		if(get_magic_quotes_gpc())  // prevents duplicate backslashes
		{
			$fieldname = stripslashes($fieldname);
		}
		if (phpversion() >= '4.3.0'){
			$fieldname = addslashes($fieldname);
		}else{
			$fieldname = addslashes($fieldname);
		}
	  
		//return the filtered data
		return $fieldname;

	}
	protected function filterfield2($str){

		$str = str_replace(",", "&nbsp;",$str);
	}
	

	protected function renderMonthOptions($user, $field){
		$month_array = array("Month","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		$options = "";
		$i = 0;
		foreach($month_array as $month){
			if($i == $user[$field]){
				$options.="<option value='$i' selected>{$month}</option>";
			}else{
				$options.="<option value='$i'>{$month}</option>";
			}
			$i++;
		}
		return $options;
	}
	
	protected function renderDayOptions($user, $field){
		$options = "";
		for ($i=1;$i<=31;$i++){
			if($user[$field] == $i){
				$options .="<option value='".$i."' selected>".$i."</option>";
			}else{
				$options .="<option value='".$i."'>".$i."</option>";
			}
		}
		return $options;
	}
	
	protected function renderOptions($options, $user, $field, $key=false, $default=false){
		$opt = "";
		if (!empty($options)){
			$i=0;
			$found = false;
		
			foreach($options as $option){
				if (!$key){
					if ($user[$field]==$option){
						$found = true;
						$opt.="<option value='".$i."' selected>".$option."</option>";
					}else{
						$opt.="<option value='".$i."'>".$option."</option>";
					}
				}else{
					if ($user[$field]==$i){
						$found = true;
						$opt.="<option value='".$i."' selected>".$option."</option>";
					}else{
						$opt.="<option value='".$i."'>".$option."</option>";
					}
				}
				$i++;
			}
			if ($default){
				if (!$found){
					$opt = "<option value='' selected>-</option>".$opt;
				}else{
					$opt = "<option value=''>-</option>".$opt;
				}
			}
		}
		return $opt;
	}
	
	protected function renderCheckbox($options, $user, $field){
		$i = 0;
		
	}
	
	
	protected function getUser(){
		$db = $this->db;
		$userid = $_SESSION['userid'];
		try{
			//load user from db
			$user = $db->fetchRow("SELECT * FROM personal WHERE userid = ".$userid);
			
			return $user;
		}catch(Exception $e){
			return array();
		}
		
	}
}