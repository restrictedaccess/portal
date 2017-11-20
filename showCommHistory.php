<?php
include 'config.php';


$leads_id = $_REQUEST['leads_id'];
$created_by_type =$_REQUEST['created_by_type'];
//echo $created_by_type;
function getCreator($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT fname FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Agent ".$row[0];
	}
	else if($created_by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT admin_fname FROM admin a WHERE admin_id = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Admin ".$row[0];
	}
	else{
		$name="";
	}
	return $name;
}

function getAttachment($id,$type,$mode){
	if($mode == "history"){
		if($type=="Quote"){
			$sql = "SELECT * FROM quote WHERE id = $id;";
			$data = mysql_query($sql);
			$row = mysql_fetch_array($data);
			$str = " <a href='./pdf_report/quote/?ran=".$row['ran']."' target='_blank' class='link10'>Quote #".$row['quote_no']."</a>";
		}
		if($type=="Set-Up Fee Invoice"){
			$sql = "SELECT * FROM set_up_fee_invoice WHERE id = $id;";
			$data = mysql_query($sql);
			$row = mysql_fetch_array($data);
			$str = " <a href=./pdf_report/spf/?ran=".$row['ran']."$id target='_blank' class='link10'>Invoice #".$row['invoice_number']."</a>";
		}
		if($type=="Service Agreement"){
			$sql = "SELECT * FROM service_agreement WHERE service_agreement_id = $id;";
			$data = mysql_query($sql);
			$row = mysql_fetch_array($data);
			$str = " <a href='./pdf_report/service_agreement/?ran=".$row['ran']."' target='_blank' class='link10'>Service Agreement #".$id."</a>";
		}
		return $str;
	}
	if($mode == "details"){
		$sql = "SELECT DATE_FORMAT(date_attach,'%D %b %y') FROM history_attachments WHERE attachment = $id AND attachment_type = '$type';";
		$data = mysql_query($sql);
		list($date_sent) = mysql_fetch_array($data);
		if($date_sent!=NULL){
			$str = "Date Sent  ".$date_sent;
		}else{
			$str ="&nbsp;";
		}
		return $str;
	}
}
//Communication history
$sql="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y %h:%i %p ')AS date_created ,agent_no, created_by_type , actions FROM history WHERE leads_id = $leads_id AND created_by_type = '$created_by_type' ORDER BY date_created DESC;";
/*
$results = $db->fetchAll($sql);
foreach($results as $result){
	$data = array(
		'id' => $result['id'],
		'history' => $history , 
		'creator' => getCreator($result['agent_no'] , $result['created_by_type']) ,
		'date' => $result['date_created'] ,
		'actions' => $result['actions']
	);
}
*/

$result=mysql_query($sql);
$email_count = 0;
$call_count = 0;
$notes_count = 0;
$meeting_count = 0;
while(list($id,$history,$date ,$created_by , $created_by_type , $actions) = mysql_fetch_array($result))
{
	$creator = getCreator($created_by , $created_by_type);
	$hist=$history;
	$history=substr($history,0,200);

	if($actions == 'EMAIL'){
		$email_count++;
		$sqlAttachments = "SELECT attachment,attachment_type FROM history_attachments WHERE history_id = $id;";
		$data=mysql_query($sqlAttachments);
		$att="";
		while(list($attachment,$attachment_type)=mysql_fetch_array($data))
		{
			$att.= getAttachment($attachment,$attachment_type,'history');
		}
		$txt.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
				<div><b>".$counter.")  ".$date."</b><span style='margin-left:100px; FONT: bold 7.5pt verdana;
    COLOR: #676767;'>Sent the FF :".$att."</span></div>
		<div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./viewHistory.php?id=$id',500,400); title='$hist'>".stripslashes($history)."</a>
.</div>
		<div style='color:#999999;'>-- ".$creator."</div>
</div>";

	}
	
	if($actions == 'CALL'){
		$call_count++;
		$txt2.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
		<div ><b>".$counter.")  ".$date."</b></div>
<div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./viewHistory.php?id=$id',500,400); title='$hist'>".stripslashes($history)."</a></div>
		<div style='color:#999999;'>-- ".$creator."</div>
		</div>";
	}
	
	if($actions == 'MAIL'){
		$notes_count++;
		$txt3.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
		<div><b>".$counter.")  ".$date."</b></div>
		<div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./viewHistory.php?id=$id',500,400); title='$hist'>".stripslashes($history)."</a>
		</div>
		<div style='color:#999999;'>-- ".$creator."</div>
		</div>";
	}
	
	if($actions == 'MEETING FACE TO FACE'){
		$meeting_count++;
		$txt4.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
		<div><b>".$counter.")  ".$date."</b></div>
		<div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./viewHistory.php?id=$id',500,400); title='$hist'>".stripslashes($history)."</a>
		</div>
		<div style='color:#999999;'>-- ".$creator."</div>
		</div>";
	}

	
}


if($email_count > 0) {
	echo "<p>Email <img src='images/email.gif' alt='Email' width='16' height='10'>";
	echo "<div class='scroll'>".$txt."</div></p>";
}

if($call_count > 0) {
	echo "<p>Call <img src='images/icon-telephone.jpg' alt='Call'>";
	echo "<div class='scroll'>".$txt2."</div></p>";
}

if($notes_count > 0) {
	echo "<p>Notes  <img src='images/textfile16.png' alt='Mail' >";
	echo "<div class='scroll'>".$txt3."</div></p>";
}

if($meeting_count > 0) {
	echo "<p>Meeting face to face <img src='images/icon-person.jpg' alt='Meet personally'>";
	echo "<div class='scroll'>".$txt4."</div></p>";
}
?>