<?php
include './conf/zend_smarty_conf_root.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$leads_id=$_REQUEST['leads_id'];
$created_by_id=$_REQUEST['created_by_id'];
$remark_created_by=$_REQUEST['remark_created_by'];
$remarks =$_REQUEST['remarks'];



if($remark_created_by=="BP" or $remark_created_by=="AFF")
{
	$sql ="SELECT * FROM agent WHERE agent_no = $created_by_id;";
	$row = $db->fetchRow($sql);
	$name =$remark_created_by." : ".$row['fname'];
}
if($remark_created_by=="ADMIN")
{
	$sql ="SELECT * FROM admin WHERE admin_id = $created_by_id;";
	$row = $db->fetchRow($sql);
	$name =$remark_created_by." : ".$row['admin_fname'];
}

$remark_created_by =$name;
$data = array('leads_id' => $leads_id, 
			  'remark_creted_by' => $remark_created_by, 
			  'created_by_id' => $created_by_id, 
			  'remark_created_on' => $ATZ,
 			  'remarks' => $remarks
			  );
$db->insert('leads_remarks', $data);
$id = $db->lastInsertId();			  


$sqlCheckRemark="SELECT * FROM leads_remarks WHERE id = $id;";
$result = $db->fetchRow($sqlCheckRemark);
echo "<a href='javascript: show_hide(\"leads$leads_id\");'>".substr($result['remarks'],0,90)."</a>";

?>

<div id="leads<?php echo $leads_id;?>" class="notes_list">
<div style="border-bottom:#333333 solid 1px; padding-bottom:5px;">
<div style="float:left;"><b>Remarks/Notes</b></div>
<div style="float:right;"><b><a href="javascript:show_hide('leads<?php echo $leads_id;?>')">[x]</a></b></div>
<div style="clear:both;"></div>
</div>
<?
	  $sqlGetAllRemarks="SELECT id, remark_creted_by,remarks ,DATE_FORMAT(remark_created_on,'%D %b %Y %h:%i %p')AS remarks_date FROM leads_remarks WHERE leads_id = $leads_id ORDER BY id DESC;";
	  $get_all_result=$db->fetchAll($sqlGetAllRemarks);
	  foreach($get_all_result as $line)
	  {
		$remark_id = $line['id'];
		$remark_creted_by = $line['remark_creted_by'];
		$remarks = $line['remarks'];
		$remarks_date = $line['remarks_date'];
		$str1 = "ADMIN";
		$str2 = $remark_creted_by;
		if (preg_match("/\bADMIN\b/i", $str2)) {
			$delete_link ="&nbsp;";
		} else {
			$delete_link ="&nbsp;";
			//$delete_link = "<a href=".$_SERVER['PHP_SELF']."?remark_id=$remark_id"." title='Delete'>delete</a>";
		}	
	
		echo "<div style='margin-top:2px;margin-bottom:2px; border-bottom:#999999 dashed 1px;padding-bottom:5px; padding-top:5px;'>
				<div>
				<div style='float:left;'>- ".$remark_creted_by."</div>
				<div style='float:right;'>".$delete_link."</div>
				<div style='clear:both;'></div>
				</div>
				<div>&quot;".$remarks."&quot;</div>
				<div><i>".$remarks_date."</i></div>
			  </div>";
	  }
	
  ?>
</div>