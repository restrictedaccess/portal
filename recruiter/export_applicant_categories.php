<?php
include '../conf/zend_smarty_conf.php';
include 'categories_functions.php';

function printCategories($categories,$handle,$on_asl){

foreach($categories as $category){
	fputcsv($handle,array($category['category']['name']));
	foreach($category['subcategories'] as $subcategory){
		fputcsv($handle,array(''));
		fputcsv($handle,array('',$subcategory['category_name']));
		fputcsv($handle,array(
			'',
			'Applicant',
			'Skills',
			'Work Availability',
			'Time Zone Availability',
			'Advertized Rate',	
			'On ASL',
			'Shortlisted',	
			'Endorsed',	
			'RS Employment History'
			));
		foreach($subcategory['applicants'] as $userid=>$applicant){
		
			$applicant_cell = '#'.$userid.' '.$applicant['fname'].' '.$applicant['lname']."\n".
				$applicant['recruiter']."\n".
				$applicant['email']."\n".
				$applicant['current_job'];
			
			$i = 1;
			$skills_cell = '';
			if (isset($applicant["skills"])&&(!empty($applicant["skills"]))){
				foreach($applicant['skills'] as $skill){
					if($skill != ''){
						$skills_cell .= $skill;
						if($i < count($applicant['skills'])){
							$skills_cell .= ', ';
						}
						$i++;
					}
				}	
			}
			
			
			$adv_rate_cell = '';
			if($applicant.availability_parttime == 'yes'){
				$adv_rate_cell .= "Part-time Rate:\n";
				foreach ($applicant['part_time_rate'] as $key=>$rate){
					$adv_rate_cell .= $key.' '.$rate."\n";
				}
				$adv_rate_cell .= "\n";
			}
			if($applicant['availability_fulltime'] == 'yes'){
				$adv_rate_cell .= "Full -time Rate:\n";
				foreach ($applicant['full_time_rate'] as $key=>$rate){
					$adv_rate_cell .= $key.' '.$rate."\n";
				}
			}
			
			$emp_histo_cell = '';
			if (isset($applicant["rs_employment_history"])&&!empty($applicant["rs_employment_history"])){
				foreach($applicant['rs_employment_history'] as $rse_history){
					$emp_histo_cell .= $rse_history['client']."\n".str_replace('<br>',"\n",$rse_history['status'])."\n\n";
				}	
			}
			
				
			if($applicant['ratings'] == $on_asl){
			fputcsv($handle,array(
				'',
				$applicant_cell,
				$skills_cell,
				$applicant['availability'],
				str_replace('<br>',"\n",$applicant['time_zone']),
				$adv_rate_cell,
				$applicant['ratings'],
				$applicant['shortlisted'],
				$applicant['endorsement_num'],
				$emp_histo_cell
				));
			}
		}
	}
}

}

$select = "SELECT date(sub_category_applicants_date_created) 
	FROM job_sub_category_applicants
	order by sub_category_applicants_date_created asc
	limit 1";
$date_start = $_REQUEST["date_start"];  

$date_end = $_REQUEST["date_end"];

$recruiter = $_REQUEST["recruiter"];

$categories = getCategories();

//applicants on asl
foreach($categories as $key=>$category){
	$categories[$key]['subcategories'] = getSubCategories($category['category']['id']);
	foreach($categories[$key]['subcategories'] as $key2=>$subcategory){
		$applicants = getApplicants($key2,$date_start,$date_end,null,null,$recruiter,0,'hourly');		
		$categories[$key]['subcategories'][$key2]['applicants'] = $applicants["applicants"];
	}
}
$tmpfname = tempnam(null, null);
$handle = fopen($tmpfname, "w");


fputcsv($handle,array(''));
fputcsv($handle,array('Date Start:',$date_start));
fputcsv($handle,array('Date End:',$date_end));
fputcsv($handle,array(''));
fputcsv($handle,array('APPLICANTS ON ASL'));
fputcsv($handle,array(''));
printCategories($categories,$handle,'Yes');


//applicants not on asl
foreach($categories as $key=>$category){
	$categories[$key]['subcategories'] = getSubCategories($category['category']['id']);
	foreach($categories[$key]['subcategories'] as $key2=>$subcategory){		
		unset($categories[$key]['subcategories'][$key2]['applicants']);
		$applicants = getApplicants($key2,$date_start,$date_end,null,null,$recruiter,1,'hourly');		
		$categories[$key]['subcategories'][$key2]['applicants'] = $applicants["applicants"];
	}
}

fputcsv($handle,array(''));
fputcsv($handle,array(''));
fputcsv($handle,array('APPLICANTS NOT ON ASL'));
fputcsv($handle,array(''));
printCategories($categories,$handle,'No');

$filename = "CATEGORIES_".basename($tmpfname . ".csv");

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
//header('Content-Disposition: attachment; filename=STAFF_SHIFT_DETAILS'.$tmpfname . ".csv");
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));

ob_clean();
flush(); 
readfile($tmpfname);
unlink($tmpfname);

