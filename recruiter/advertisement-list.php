<?php 
if($need_attention > 0) 
{ 
	$advertisement_list .= '<div id="need_attention_div" style="background:#FFFF00; text-align:center; padding:5px; font-weight:bold;">There are '.$need_attention.' Job '.$available_status.' Advertisements that doesn\'t belong to any category.
	<p>Fix this issue. Click <a href="javascript:toggle(\'incomplete_ads\'); toggle(\'active_ads\'); toggle(\'need_attention_div\');">here</a></p>
	</div>';

	$advertisement_list .= '<!--<div style="padding:5px; font-weight:bold;">INCOMPLETE DETAILS JOB ADVERTISEMENTS</div>-->
	<div id="incomplete_ads" style="padding:10px; display:none;" >
	<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">';

	$counter=0;
	$i=0;
	foreach($result as $results)
	{
		if($results['category_id'] == "")
		{
			$counter++;
			$advertisement_list .= '<tr bgcolor="#FFFFFF" >
			<td width="4%" >'.$counter.'</td>
			<td width="43%" >'.$results['jobposition'].'</td>
			<td width="53%"><input type="hidden" name="counter2['.$i.']" value="'.$results['id'].'" /><select name="category_id2['.$i.']" id="category_id['.$i.']"><option value="">Please Select</option>'.SetUpSelectElement($results['category_id']).'<option value="ARCHIVE">**REMOVED**</option></select></td>
			</tr>';
			$i++; 
		} 
	}

	$advertisement_list .= '<tr bgcolor="#FFFFFF" >
	<td colspan="3" align="left" ><input type="submit" name="allocate" value="Allocate" /><input type="button" value="Close" onClick="javascript:toggle(\'incomplete_ads\'); toggle(\'active_ads\'); toggle(\'need_attention_div\');" /></td>
	</tr>
	</table>
	</div>';
}


$advertisement_list .= '<div id="active_ads" style=" padding:10px;">
<h4>'.$available_status.' ADVERTISEMENTS</h4>';

$sql = $db->select()
->from('job_role_category');
$categories = $db->fetchAll($sql);	
$i=0;
foreach($categories as $category)
{
		$advertisement_list .= '<span class="toggle-btn" onClick="toggle(\''.$category['jr_cat_id'].'_box\')">SHOW / HIDE</span>
		<h2>'.$category['cat_name'].'</h2>
		<div id="'.$category['jr_cat_id'].'_box"  style="margin-bottom:20px;">
		<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">';
		
		$query = $db->select()
			->from('job_category')
			->where('job_role_category_id =?' , $category['jr_cat_id'])
			->where('status != ?','removed');
		$sub_cats = $db->fetchAll($query);
		foreach($sub_cats as $sub_cat)
		{
			if($bgcolor == '#EEEEEE')
			{
				$bgcolor = '#E4E4E4';
			}
			else
			{
				$bgcolor = '#EEEEEE';
			}

			$advertisement_list .= '<tr bgcolor=\''.$bgcolor.'\'><td width=\'100%\' align=\'left\' >
			<div style="color:#FF0000; font-weight:bold; font-size:14px; cursor:pointer;" onClick="toggle(\''.$sub_cat['category_id'].'\');">'.$sub_cat['category_name'].'</div>
			<div id="'.$sub_cat['category_id'].'">
				<table width="100%" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">';
				
					$query2 = $db->select()
						->from(array('p' => 'posting') , Array('p.id' , 'companyname' , 'jobposition' , 'outsourcing_model' , 'date_created' , 'lead_id' , 'category_id' , 'status' , 'show_status' ))
						->join(array('l' => 'leads'), 'l.id = p.lead_id' , Array('fname' ,'lname'))
						->where('category_id =?' ,$sub_cat['category_id'])
						->where('p.status =?' ,$available_status)
						->order('p.id DESC');
					$ads = $db->fetchAll($query2);	
					
					if(count($ads) > 0)
					{
						$counter =0;
						foreach($ads as $ad)
						{
							$counter++;
							//$date_created="";
							if($ad['date_created'])
							{
								$det = new DateTime($ad['date_created']);
								$date_created = $det->format("F j, Y");
							}
							else
							{
								$date_created="<span style='background:#FFFF00; color:#000000;'>DATE CREATED IS MISSING</span>";
							}	

                            $advertisement_list .= '
							 <tr bgcolor="#FFFFFF" >
								<td width="3%" >'.$counter.'</td>
								<td width="43%" >
								<div style="font-weight:bold;"><a href="Ad.php?id='.$ad['id'].'" target="_blank">'.$ad['jobposition'].'</a></div>
								<div style="color:#999999; ">'.$ad['fname'].' '.$ad['lname'].'<br />
								<small>Date Created : '.$date_created.'</small></div></td>
								<td class="statuses" width="54%"><div> Status : 
								    <select class="status_select" name="status['.$i.']" id="status['.$i.']"><option value="">Please Select</option>'.AdsStatus($ad['status']).'</select> Show : <select class="status_select" name="show['.$i.']" id="show['.$i.']"><option value="">Please Select</option>'.AdsShowStatus($ad['show_status']).'</select> <input type="hidden" name="counter['.$i.']" value="'.$ad['id'].'" /> <!--<select class="status_select" name="category_id['.$i.']" id="category_id['.$i.']"></select>--> <a style="float:right;" href="admineditads.php?id='.$ad['id'].'">Edit</a></div><span style="color:#999999;">Ad ID :#'.$ad['id'].'</span>
								</td>
							</tr>';

							$i++;	  
						}
					}
					else
					{
						$advertisement_list .= "No Job Advertisement to be shown.";
					}

				$advertisement_list .= '</table>
			</div>
			</td></tr>';
		}  
		
		$advertisement_list .= '</table>
		</div>';
}
$advertisement_list .= '<div><input type="submit" name="update" value="Update" /></div>
</div>';
?>