<?php
function ShowFilledBy($id, $table, $field){
    global $db;
	if($table == 'admin'){
	    $sql = $db->select()
		    ->from('admin')
			->where('admin_id =?', $id);
		$admin = $db->fetchRow($sql);
		if($field == 'email'){
		    return $admin['admin_email'];
		}else{
		    return sprintf('Admin %s', $admin['admin_fname']);
		}		
	}
	if($table == 'agent'){
	    $sql = $db->select()
		    ->from('agent')
			->where('agent_no =?', $id);
		$agent = $db->fetchRow($sql);
		if($field == 'email'){
		    return $agent['email'];
		}else{
		    return sprintf('BD %s', $agent['fname']);
		}	
	}
	if($table == 'leads'){
	    $sql = $db->select()
		    ->from('leads')
			->where('id =?', $id);
		$lead = $db->fetchRow($sql);
		if($field == 'email'){
		    return $lead['email'];
		}else{
		    return sprintf('%s %s', $lead['fname'], $lead['lname']);
		}	
	}
}
function ExistingLeadRecordOrder($mode, $new_leads_id, $leads_id, $column_name, $column_value, $table){
    global $db;
	$AusTime = date("H:i:s"); 
    $AusDate = date("Y")."-".date("m")."-".date("d");
    $ATZ = $AusDate." ".$AusTime;

	if($mode == 'email'){
	    
	    //Record the order of this existing lead who fill up again in the inquiry form
		$sql = $db->select()
	        ->from('leads_new_info', 'id')
		    ->where('id =?', $new_leads_id);
	    $leads_new_info_id = $db->fetchOne($sql);
		if($leads_new_info_id){
		    $data = array(
			    'leads_id' => $leads_id, 
				'leads_new_info_id' => $new_leads_id, 
				'reference_column_name' => $column_name,
				'reference_no' => $column_value, 
				'reference_table' => $table, 
				'date_added' => $ATZ
			);
			$db->insert('leads_transactions' , $data);
		}
	}
	
	if($mode == 'name'){
	    $data = array(
		    'leads_id' => $leads_id, 
			'leads_new_info_id' => $new_leads_id, 
			'reference_column_name' => $column_name,
			'reference_no' => $column_value, 
			'reference_table' => $table, 
			'date_added' => $ATZ
	   );
	   $db->insert('leads_transactions' , $data);
	}
	
	
}

function ShowImageResult($location_id){
	//$page = basename($_SERVER['SCRIPT_FILENAME']);
	//$location_id = LOCATION_ID;
	//echo $location_id;
	global $db;
	if($location_id !=""){
		
		$active_image_array = array(
				'1' => 'remote-staff-country-active-AUS.jpg' , 
				'2' => 'remote-staff-country-active-UK.jpg' , 
				'3' =>'remote-staff-country-active-US.jpg',
				'4' =>'remote-staff-country-active-PH.jpg',
				'5' =>'remote-staff-country-active-IN.jpg'
				);
	
		$inactive_image_array = array(
				'1' => 'remote-staff-country-inactive-AUS.jpg' , 
				'2' => 'remote-staff-country-inactive-UK.jpg' , 
				'3' =>'remote-staff-country-inactive-US.jpg',
				'4' =>'remote-staff-country-inactive-PH.jpg',
				'5' =>'remote-staff-country-inactive-IN.jpg'
			);		
		
		$sql = $db->select()
			->from('leads_location_lookup');
		$urls = $db->fetchAll($sql);	
		
		foreach($urls as $url){
		    if($url['id'] == $location_id){
			    $img_result.="<img src='media/images/".$active_image_array[$url['id']]."' border='0'>";
		    }else{
				$img_result.='<a href="http://'.$url['location'].'/"><img border="0" onmouseout=this.src="media/images/'.$inactive_image_array[$url['id']].'" onmouseover=this.src="media/images/'.$active_image_array[$url['id']].'" src="media/images/'.$inactive_image_array[$url['id']].'"></a>';
		    }
	    }
		
	}else{
		$img_result = '<img src="media/images/remote-staff-country-inactive-AUS.jpg" /><img src="media/images/remote-staff-country-inactive-US.jpg" /><img src="media/images/remote-staff-country-inactive-UK.jpg" /><img src="media/images/remote-staff-country-inactive-PH.jpg" />
	';
	}
	
	if($location_id == 1){
		$phone ='Phone: 1300 733 430<br />Phone: 02 8090 3458';
	}else if(LOCATION_ID == 2) {
		$phone ='';
	}else if(LOCATION_ID == 3 || LOCATION_ID == 6) {
		$phone ='Phone: +1 415 992 5644 ';
	}else{
		$phone ='Phone: 1300 733 430';
	}
	//return $img_result;
	$link = $img_result;
	$link .= '<p style="line-height:16px; padding-top:4px;"><a href="../contactus.php"><img src="../images/icon-contact3.png" border="0" /></a><br />';
	$link .= $phone;
	$link .= '</p>';
	
	return $link;
	
	
}
function rand_str($length = 45, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
    // Length of character list
    $chars_length = strlen($chars);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
   
    // Generate random string
    for ($i = 1; $i < $length; $i++) {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        $string = $string . $r;
    }
   
    // Return the string
    return $string;
}

function formatPrice($price){
	$price = number_format($price,2,".",",");
	return $price;
	
}
function strip_spaces($string){
	$sPattern = '/\s*/m';
	$sReplace = '';
	return preg_replace( $sPattern, $sReplace, $string );
}


function CSS($location_id){
    $home_page_css =array(
		'1' => 'AU-custom-recruitment-style.css' ,
		'2' => 'UK-custom-recruitment-style.css' ,
		'3' => 'US-custom-recruitment-style.css',
		'4' => 'AU-custom-recruitment-style.css',
		'5' => 'AU-custom-recruitment-style.css',
		'6' => 'US-custom-recruitment-style.css'
	);
	
	return $home_page_css[$location_id];
}
?>