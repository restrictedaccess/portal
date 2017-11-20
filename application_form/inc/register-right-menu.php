<?php 
function RightMenus($form ,$userid){
	global $db;
	
	//configure the register left menu
	//get all the forms that the user completed
	
	$right_link = array (
		'1' => 'registernow-step1-personal-details.php',
		'2' => 'registernow-step2-working-at-home-capabilities.php',
		'3' => 'registernow-step3-educational-details.php',
		'4' => 'registernow-step4-work-history-details.php',
		'5' => 'registernow-step5-skills-details.php',
		'6' => 'registernow-step6-languages-details.php',
		'7' => 'registernow-step7-upload-voice-recording.php',
		'8' => 'registernow-step8-uploadphoto.php'
	);
	
	
	$right_menus = array (
		'1' => 'Personal Details',
		'2' => 'Working at Home Capabilities',
		'3' => 'Educational Details',
		'4' => 'Work Experience &amp; Position desired',
		'5' => 'Skills Details',
		'6' => 'Languages Details',
		'7' => 'Upload Voice Recording',
		'8' => 'Upload Photo'
	);
		
	for($i=1 ; $i<=count($right_menus); $i++){
		
			if($i == $form){
					if($userid!=""){
						$sql = $db->select()
							->from('applicants_form' , 'id')
							->where('userid = ?' ,$userid)
							->where('form = ?' , $form);
						$form_id = $db->fetchOne($sql);
					}
					if($form_id){
						$class="stepdone";
					}else{
						$class="stepcurrent";
					}
	
			}else{
					if($userid!=""){
						$sql = $db->select()
							->from('applicants_form' , 'id')
							->where('userid = ?' ,$userid)
							->where('form = ?' , $i);
						$form_id = $db->fetchOne($sql);
					}
					if($form_id){
						$class="stepdone";
					}else{
						$class="";
					}
			}
			
			$right_menu .= "<li><a href=".$right_link[$i]." class=".$class.">".$right_menus[$i]."</a></li>";
	}
	
	return $right_menu;
}


