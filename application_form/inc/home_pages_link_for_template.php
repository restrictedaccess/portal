<?php 
function ShowActiveInactiveImages($location_id){
	global $db;
	if($location_id !=""){
			$active_image_array = array(
						'1' => 'remote-staff-country-active-AUS.jpg' , 
						'2' => 'remote-staff-country-active-UK.jpg' , 
						'6' =>'remote-staff-country-active-US.jpg',
						'4' =>'remote-staff-country-active-PH.jpg'
					);
		
			$inactive_image_array = array(
					'1' => 'remote-staff-country-inactive-AUS.jpg' , 
					'2' => 'remote-staff-country-inactive-UK.jpg' , 
					'6' =>'remote-staff-country-inactive-US.jpg',
					'4' =>'remote-staff-country-inactive-PH.jpg'
				);		
			
			$sql = $db->select()
				->from('leads_location_lookup');
			$urls = $db->fetchAll($sql);	
			
			foreach($urls as $url){
				if( empty($active_image_array[ $url['id'] ] ) ) continue;
				if($url['id'] != 5){
					if($url['id'] == $location_id){
						$img_result.="<img src='/portal/images/".$active_image_array[$url['id']]."' border='0'>";
					}else{
						if($url['id'] == 4){
							$img_result.='<a href="http://'.$url['location'].'/"><img border="0" onmouseout=this.src="/portal/images/'.$inactive_image_array[$url['id']].'" onmouseover=this.src="/portal/images/'.$active_image_array[$url['id']].'" src="/portal/images/'.$inactive_image_array[$url['id']].'"></a>';
						}else{
							$img_result.='<a href="http://'.$url['location'].'/'.$page.'"><img border="0" onmouseout=this.src="/portal/images/'.$inactive_image_array[$url['id']].'" onmouseover=this.src="/portal/images/'.$active_image_array[$url['id']].'" src="/portal/images/'.$inactive_image_array[$url['id']].'"></a>';
			
						}
					}
				}
			}
			
		}else{
			$img_result = '<img src="/portal/images/remote-staff-country-inactive-AUS.jpg" /><img src="/portal/images/remote-staff-country-inactive-US.jpg" /><img src="/portal/images/remote-staff-country-inactive-UK.jpg" /><img src="/portal/images/remote-staff-country-inactive-PH.jpg" />
		';
		}
		
		return $img_result;
}

