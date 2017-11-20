<?php
//echo LOCATION_ID;
if(LOCATION_ID != ""){
	$qs = $_SERVER['QUERY_STRING'];
	if($qs!=""){
		$qs = "?".$qs;
	}
	
	$location_id = (LOCATION_ID - 1);
	$country_domain = array('www.remotestaff.com.au' , 'www.remotestaff.co.uk' , 'www.remotestaff.biz');
	
	$active_image_array = array('remote-staff-country-active-AUS.jpg' , 'remote-staff-country-active-UK.jpg' , 'remote-staff-country-active-US.jpg');
	$inactive_image_array = array('remote-staff-country-inactive-AUS.jpg' , 'remote-staff-country-inactive-UK.jpg' , 'remote-staff-country-inactive-US.jpg');
	
	for($i=0; $i<count($country_domain); $i++){
		if($location_id == $i){
			$img_result.="<img src='../images/".$active_image_array[$i]."' border='0'>";
		}else{
		
			$img_result.='<a href="http://'.$country_domain[$i].'/portal/'.basename($_SERVER['SCRIPT_FILENAME']).$qs.'"><img border="0" onmouseout=this.src="../images/'.$inactive_image_array[$i].'" onmouseover=this.src="../images/'.$active_image_array[$i].'" src="../images/'.$inactive_image_array[$i].'"></a>';
		}	
	}
	echo $img_result;
}
?>

