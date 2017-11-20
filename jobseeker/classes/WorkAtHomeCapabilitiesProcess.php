<?php
/**
 * Class responsible for updating work at home capabilities
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
require_once dirname(__FILE__)."/../forms/UpdateWorkAtHomeForm.php";
require_once dirname(__FILE__)."/../../conf/zend_smarty_conf.php";

class WorkAtHomeCapabilitiesProcess extends EditProcess{
	public function process(){
		if (!empty($_POST)){
			$db = $this->db;
			$form = new UpdateWorkAtHomeForm();
			if ($form->isValid($_POST)){
				$data =  $form->getValues();
				$start_worked_from_home=$data["start_worked_from_home_year"]."years and ".$data["start_worked_from_home_month"]."months";
				$data["start_worked_from_home"] = $start_worked_from_home;
				unset($data["start_worked_from_home_year"]);
				unset($data["start_worked_from_home_month"]);
				$desktop_specs = "";
				$laptop_specs = "";
				$other_specs = "";
				$desktop_specs = "desktop,".$data["desktop_os"].",".$data["desktop_processor"].",".$data["desktop_ram"]."\n";
				
				$laptop_specs = "laptop,".$data["loptop_os"].",".$data["loptop_processor"].",".$data["loptop_ram"]."\n";
				unset($data["desktop_computer"]);
				unset($data["desktop_os"]);
				unset($data["desktop_processor"]);
				unset($data["desktop_ram"]);
				
				unset($data["loptop_computer"]);
				unset($data["loptop_os"]);
				unset($data["loptop_processor"]);
				unset($data["loptop_ram"]);
				
				$other_specs.=$data["headset"]."\n";
				$other_specs.=$data["headphone"]."\n";
				$other_specs.=$data["printer"]."\n";
				$other_specs.=$data["scanner"]."\n";
				$other_specs.=$data["tablet"]."\n";
				$other_specs.=$data["pen_tablet"]."\n";
				
				unset($data["headset"]);
				unset($data["headphone"]);
				unset($data["printer"]);
				unset($data["scanner"]);
				unset($data["tablet"]);
				unset($data["pen_tablet"]);
				if (!empty($data["noise_level"])){
					$data["noise_level"] = implode(",", $data["noise_level"]);
				}else{
					$data["noise_level"] = "";
				}
				$data["computer_hardware"]=$desktop_specs.$laptop_specs.$other_specs;
					
				$db->update("personal", $data, $db->quoteInto("personal.userid = ?", $_SESSION["userid"]));
				$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$_SESSION["userid"]));
				global $base_api_url;
				
				file_get_contents($base_api_url . "/solr-index/sync-candidates/");
				
				file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $_SESSION["userid"]);
				
				
				return array("success"=>true);
			}else{
				return array("success"=>false, "error"=>$form->getErrors());
			}
		}else{
			return array("success"=>false);
		}
	}
	
	
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION["userid"];		
		$personal = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $userid));
		$form = new UpdateWorkAtHomeForm();
		$start_worked_from_home=$personal['start_worked_from_home'];
		$date=explode("and",$start_worked_from_home);
		$personal["start_worked_from_home_year"] = trim(str_replace('years','',$date[0]));
		$personal["start_worked_from_home_month"] = trim(str_replace('months','',$date[1]));
		
		$computer_hardware=$personal['computer_hardware'];
	
		$tools=explode("\n",$computer_hardware);
		$desktop=str_replace("desktop ","",$tools[0]);
		if($desktop!=""){
			$personal["desktop_computer"]="yes";
			$desktop_specs=explode(",",$desktop);
			$personal["desktop_os"]=$desktop_specs[1];
			$personal["desktop_processor"]=$desktop_specs[2];
			$personal["desktop_ram"]=$desktop_specs[3];
			if (trim($personal["desktop_os"])==""&&trim($personal["desktop_processor"])==""&&trim($personal["desktop_ram"])==""){
				$personal["desktop_computer"]="no";
			}
		}

		$laptop=str_replace("laptop ","",$tools[1]);
		if($laptop!=""){
			$personal["loptop_computer"]="yes";
			$laptop_specs=explode(",",$laptop);
			$personal["loptop_os"]=$laptop_specs[1];
			$personal["loptop_processor"]=$laptop_specs[2];
			$personal["loptop_ram"]=$laptop_specs[3];
			if (trim($personal["loptop_os"])==""&&trim($personal["loptop_processor"])==""&&trim($personal["loptop_ram"])==""){
				$personal["loptop_computer"]="no";
			}
		}
		
		$personal["headset"] = $tools[2];
		$personal["headphone"] = $tools[3];
		$personal["printer"] = $tools[4];
		$personal["scanner"] = $tools[5];
		$personal["tablet"] = $tools[6];
		$personal["pen_tablet"] = $tools[7];
		
		foreach($personal as $key=>$value){
			try{
				if ($form->getElement($key)){
					$form->getElement($key)->setValue($value);						
				}
			}catch(Exception $e){
				
			}	
		}
		$form->getElement("noise_level")->setValue(explode(",", $personal["noise_level"]));
		
		
		$smarty->assign_by_ref("form", $form);
		$this->syncUserInfo();
		$this->setActive("work_at_home_active");
		$this->setActive("resume_active");
		
		$smarty->display("work_at_home.tpl");
	}
}
