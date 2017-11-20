<?php if($need_attention > 0) { ?>
<div id="need_attention_div" style="background:#FFFF00; text-align:center; padding:5px; font-weight:bold;">There are <?php echo $need_attention;?> Job <?php echo $available_status;?> Advertisements that doesn't belong to any category.
<p>Fix this issue. Click <a href="javascript:toggle('incomplete_ads'); toggle('active_ads'); toggle('need_attention_div');">here</a></p>
</div>


<!--<div style="padding:5px; font-weight:bold;">INCOMPLETE DETAILS JOB ADVERTISEMENTS</div>-->
<div id="incomplete_ads" style="padding:10px; display:none;" >
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">

<?php
$counter=0;
$i=0;
foreach($result as $results){
	if($results['category_id'] == ""){
		$counter++;
?>

<tr bgcolor="#FFFFFF" >
<td width="4%" ><?php echo $counter;?></td>
<td width="43%" ><?php echo $results['jobposition'];?></td>
<td width="53%"><input type="hidden" name="counter2[<?php echo $i;?>]" value="<?php echo $results['id'];?>" /><select name="category_id2[<?php echo $i;?>]" id="category_id[<?php echo $i;?>]"><option value="">Please Select</option><?php echo SetUpSelectElement($results['category_id']);?><option value="ARCHIVE">**REMOVED**</option></select></td>
</tr>

<?php $i++; 
	} 

}
?>
<tr bgcolor="#FFFFFF" >
<td colspan="3" align="left" ><input type="submit" name="allocate" value="Allocate" /><input type="button" value="Close" onClick="javascript:toggle('incomplete_ads'); toggle('active_ads'); toggle('need_attention_div');" /></td>
</tr>

</table>
</div>


<?php } ?>


<div id="active_ads" style=" padding:10px;">
<h4><?php echo $available_status;?> ADVERTISEMENTS</h4>
<?php
$sql = $db->select()
	->from('job_role_category');
$categories = $db->fetchAll($sql);	
$i=0;
foreach($categories as $category){
?>
		<span class="toggle-btn" onClick="toggle('<?php echo $category['jr_cat_id'];?>_box')">SHOW / HIDE</span>
		<h2><?php echo $category['cat_name'];?></h2>
		<div id="<?php echo $category['jr_cat_id'];?>_box"  style="margin-bottom:20px;">
		<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
		<?php
		
		//SELECT * FROM job_category j;
		//category_id, job_role_category_id, category_name, created_by, category_date_created
		$query = $db->select()
			->from('job_category')
			->where('job_role_category_id =?' , $category['jr_cat_id'])
			->where('status != ?','removed');
		$sub_cats = $db->fetchAll($query);
		foreach($sub_cats as $sub_cat){
			
			if($bgcolor == '#EEEEEE'){
				$bgcolor = '#E4E4E4';
			}else{
				$bgcolor = '#EEEEEE';
			}
			
		?>	
			<tr bgcolor='<?php echo $bgcolor;?>'><td width='100%' align='left' >
			<div style="color:#FF0000; font-weight:bold; font-size:14px; cursor:pointer;" onClick="toggle('<?php echo $sub_cat['category_id'];?>');"><?php echo $sub_cat['category_name'];?></div>
			<div id="<?php echo $sub_cat['category_id'];?>">
				<table width="100%" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
				<?php
					//parse all Advertisement Category sub-categories
					//id, agent_id, created_by_type, lead_id, category_id, date_created, outsourcing_model, companyname, jobposition, jobvacancy_no, skill, responsibility, status, heading, show_status
					$query2 = $db->select()
						->from(array('p' => 'posting') , Array('p.id' , 'companyname' , 'jobposition' , 'outsourcing_model' , 'date_created' , 'lead_id' , 'category_id' , 'status' , 'show_status' ))
						->join(array('l' => 'leads'), 'l.id = p.lead_id' , Array('fname' ,'lname'))
						->joinLeft(array("a"=>"admin"), "a.admin_id = l.hiring_coordinator_id", array("a.admin_fname AS hm_fname", "a.admin_lname AS hm_lname"))
						->where('category_id =?' ,$sub_cat['category_id'])
						->where('p.status =?' ,$available_status)
						->order('p.id DESC');
					$ads = $db->fetchAll($query2);	
					
					if(count($ads) > 0){
						$counter =0;
						
						foreach($ads as $ad){
							$counter++;
							//$date_created="";
							if($ad['date_created']){
								$det = new DateTime($ad['date_created']);
								$date_created = $det->format("F j, Y");
							}else{
								$date_created="<span style='background:#FFFF00; color:#000000;'>DATE CREATED IS MISSING</span>";
							}	
							?>
							 <tr bgcolor="#FFFFFF" >
								<td width="3%" ><?php echo $counter;?></td>
								<td width="43%" >
			<div style="font-weight:bold;"><a href="Ad.php?id=<?php echo $ad['id'];?>" target="_blank"><?php echo $ad['jobposition'];?></a></div>
								<div style="color:#999999; "><?php echo $ad['fname']." ".$ad['lname'];?><br />
								<small>Date Created : <?php echo $date_created;?><?php if ($ad["hm_fname"]) { echo " | Hiring Coordinator : ".$ad["hm_fname"]." ".$ad["hm_lname"] ; } ?></small>								</div>								</td>
								<td class="statuses" width="54%"><div> Status : 
								    <select class="status_select" name="status[<?php echo $i;?>]" id="status[<?php echo $i;?>]"><option value="">Please Select</option><?php echo AdsStatus($ad['status']);?></select> Show : <select class="status_select" name="show[<?php echo $i;?>]" id="show[<?php echo $i;?>]"><option value="">Please Select</option><?php echo AdsShowStatus($ad['show_status']);?></select> <input type="hidden" name="counter[<?php echo $i;?>]" value="<?php echo $ad['id'];?>" /> <!--<select class="status_select" name="category_id[<?php //echo $i;?>]" id="category_id[<?php e//cho $i;?>]"><?php //echo SetUpSelectElement($ad['category_id']);?></select>--> <a style="float:right;" href="admineditads.php?id=<?php echo $ad['id'];?>">Edit</a></div><span style="color:#999999;">Ad ID :#<?php echo $ad['id'];?></span>
</td>
							</tr>

							<?php $i++;	  
						}
					}else{
						echo "No Job Advertisement to be shown.";
					}
				?>
				</table>
			</div>
			</td></tr>

		<?php	  
		}  
		?>
		
		</table>
		</div>

<?php	

}

?>
<div><input type="submit" name="update" value="Update" /></div>
</div>