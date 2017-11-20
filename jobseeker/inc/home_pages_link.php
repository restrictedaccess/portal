<?php 
include('../conf/zend_smarty_conf.php');
//$page = basename($_SERVER['SCRIPT_FILENAME']);
$location_id = LOCATION_ID;
if($location_id !=""){
	
	$active_image_array = array(
				'1' => 'remote-staff-country-active-AUS.jpg' , 
				'2' => 'remote-staff-country-active-UK.jpg' , 
				'6' =>'remote-staff-country-active-US.jpg',
				'4' =>'remote-staff-country-active-PH.jpg',
				'5' =>'remote-staff-country-active-IN.jpg'
			);

	$inactive_image_array = array(
			'1' => 'remote-staff-country-inactive-AUS.jpg' , 
			'2' => 'remote-staff-country-inactive-UK.jpg' , 
			'6' =>'remote-staff-country-inactive-US.jpg',
			'4' =>'remote-staff-country-inactive-PH.jpg',
			'5' =>'remote-staff-country-inactive-IN.jpg'
		);		
	
	$sql = $db->select()
		->from('leads_location_lookup');
	$urls = $db->fetchAll($sql);	
	
	foreach($urls as $url){
		if( empty($active_image_array[$url['id']]) ) continue;
		if($url['id'] == $location_id){
			$img_result.="<img src='http://remotestaff.com.ph/images/".$active_image_array[$url['id']]."' border='0'>";
		}else{
			
			$img_result.='<a href="http://'.$url['location'].'/"><img border="0" onmouseout=this.src="http://remotestaff.com.ph/images/'.$inactive_image_array[$url['id']].'" onmouseover=this.src="http://remotestaff.com.ph/images/'.$active_image_array[$url['id']].'" src="http://remotestaff.com.ph/images/'.$inactive_image_array[$url['id']].'"></a>';
		}
	}
	echo $img_result;	
}else{
	echo '<img src="http://remotestaff.com.ph/images/remote-staff-country-inactive-AUS.jpg" /><img src="http://remotestaff.com.ph/images/remote-staff-country-inactive-US.jpg" /><img src="http://remotestaff.com.ph/images/remote-staff-country-inactive-UK.jpg" /><img src="http://remotestaff.com.ph/images/remote-staff-country-inactive-PH.jpg" /><img src="http://remotestaff.com.ph/images/remote-staff-country-inactive-IN.jpg" />';
}
?>

