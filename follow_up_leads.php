<?php
include './conf/zend_smarty_conf_root.php';
include './lib/addLeadsInfoHistoryChanges.php';
include 'config.php';
include 'conf.php';
include 'time.php';
include 'steps_taken.php';

if($_SESSION['agent_no']==""){
	header("location:index.php");
}

$agent_no = $_SESSION['agent_no'];
$agent_id = $_REQUEST['agent_id'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$keyword=$_REQUEST['keyword'];
$event_date=$_REQUEST['event_date'];
$ratings=$_REQUEST['ratings'];
$month=$_REQUEST['month'];

//$lead_status = "Follow-Up";
$lead_status = $_REQUEST['folder'];
if($lead_status!=""){
	if($lead_status == "all"){
		//$folder = "Inactive"; 
		$lead_status = " AND l.status != 'Inactive' AND  l.status != 'REMOVED' ";
	}else{
		$folder = $lead_status; 
		$lead_status = " AND l.status = '$lead_status' ";
	}
}else{
	$lead_status = " AND l.status = 'Follow-Up' ";
	$folder = "Follow-Up"; 
}


if($keyword!=NULL){
	# convert to upper case, trim it, and replace spaces with "|": 
	$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
	# create a MySQL REGEXP for the search: 
	$regexp = "REGEXP '^.*($search).*\$'"; 
	$keyword_search = " AND (
				UPPER(tracking_no) $regexp 
				OR UPPER(l.lname) $regexp 
				OR UPPER(l.fname) $regexp 
				OR UPPER(company_position) $regexp 
				OR UPPER(company_name) $regexp 
				OR UPPER(company_address) $regexp 
				OR UPPER(l.email) $regexp 
				OR UPPER(company_turnover) $regexp 
				OR UPPER(officenumber) $regexp 
				OR UPPER(mobile) $regexp 
				) ";

}else{
	$keyword_search = " ";
}

if ($event_date!=NULL){
	$event_date_search = " AND DATE(timestamp) = '$event_date' ";
}else{
	$event_date_search =" ";
}


if($ratings!=NULL){
	$ratings_search = "AND rating='$ratings' ";
}else{
	$ratings_search = " ";
}

if($month!=NULL){
	$month_search = " AND (DATE_FORMAT(l.timestamp,'%m') = '$month') ";
}else{
	$month_search = " ";
}
//echo $keyword_search;


//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = 20;
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
	$pageNum = $_GET['page'];
}
// counting the offset
//echo $pageNum ;

if($pageNum!=NULL and $agent_id!=NULL){
	$offset2 = ($pageNum - 1) * $rowsPerPage;
	//echo "offset2 ( ".$offset2." )<br>";
}
$offset = 0;


$sqlBBTransferLeads = "SELECT t.agent_no,CONCAT(a.fname,' ',a.lname)AS agent_name FROM agent_transfer_leads t LEFT JOIN agent a ON a.agent_no = t.agent_no;";
$result = $db->fetchAll($sqlBBTransferLeads);
foreach($result as $agent){
	if($agent['agent_no'] != $agent_no){
		$BPOptions.="<option value='".$agent['agent_no']."'>".$agent['agent_name']."</option>";
	}
}
$remark_id = $_REQUEST['remark_id'];
if($remark_id!=NULL){
	//DELETE RECORD
	$where = "id = ".$remark_id;	
	$db->delete('leads_remarks' , $where);
}



$transfer_message = "";
if(isset($_POST['transfer']))
{
	//echo "transfer";
	$keyword="";
	$applicants =$_REQUEST['applicants'];
	$agent_id=$_REQUEST['agent_id'];
	$users=explode(",",$applicants);
	for ($i=0; $i<count($users);$i++)
	{
		
		$sql = $db->select()
			->from('leads' , 'agent_id')
			->where('id =?' ,$users[$i]);
		$agent = $db->fetchOne($sql);	
		
		$sql = $db->select()
			->from('agent' , 'work_status')
			->where('agent_no =?' ,$agent);
		$work_status = $db->fetchOne($sql);	
		
		
		if($work_status!=""){
			if($work_status == "AFF"){
				$data = array(
							'business_partner_id' => $agent_id,
							'date_move' => $ATZ ,
							'agent_from' => $agent_no	
						);
				addLeadsInfoHistoryChanges($data , $users[$i] , $agent_no , 'bp');
				$where = "id = ".$users[$i];	
				$db->update('leads' ,  $data , $where);		
			}
			if($work_status == "BP"){
				$data = array(
							'agent_id' => $agent_id ,
							'business_partner_id' => $agent_id,
							'date_move' => $ATZ ,
							'agent_from' => $agent_no	
						);
				addLeadsInfoHistoryChanges($data , $users[$i] , $agent_no , 'bp');
				$where = "id = ".$users[$i];	
				$db->update('leads' ,  $data , $where);						
			}
			$transfer_message = " <b>Successfully Transferred!</b>";
		}
		
		
	}
	$query="";
	$month="";
}

$monthArray=array("","01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
}

$sql = $db->select()
	->from('leads' , 'status')
	->group('status');
//echo $sql;	
$status_array = $db->fetchAll($sql);	
foreach($status_array as $stats){
	if($stats['status']!=""){
		if($folder == $stats['status']){
			$searchoptions .= "<option selected value='".$stats['status']."'>".$stats['status']."</option>\n";
		}else{
			$searchoptions .= "<option value='".$stats['status']."'>".$stats['status']."</option>\n";
		}
	}
}


if(isset($_POST['move'])){
	$move_str = "";
	$applicants =$_REQUEST['applicants'];
	if($applicants != ""){
		$users=explode(",",$applicants);
		for ($i=0; $i<count($users);$i++)
		{
			if($users[$i] > 0 or $users[$i]!=""){
				$data = array('status' => 'New Leads');
				addLeadsInfoHistoryChanges($data , $users[$i] , $agent_no , 'bp');
				$where = "id = ".$users[$i];	
				//echo $where."<br>";
				$db->update('leads' ,  $data , $where);
			}	
		}
		$move_str = "Transferred to New Leads Folder";	
	}
	
}

if(isset($_POST['move2'])){
	$move_str = "";
	$applicants =$_REQUEST['applicants'];
	if($applicants != ""){
		$users=explode(",",$applicants);
		for ($i=0; $i<count($users);$i++)
		{
			if($users[$i] > 0 or $users[$i]!=""){
				$data = array('status' => 'Keep In-Touch');
				addLeadsInfoHistoryChanges($data , $users[$i] , $agent_no , 'bp');
				$where = "id = ".$users[$i];	
				//echo $where."<br>";
				$db->update('leads' ,  $data , $where);
			}	
		}
		$move_str = "Transferred to Keep in Touch Folder";	
	}
	
}

if(isset($_POST['move3'])){
	$move_str = "";
	$applicants =$_REQUEST['applicants'];
	if($applicants != ""){
		$users=explode(",",$applicants);
		for ($i=0; $i<count($users);$i++)
		{
			if($users[$i] > 0 or $users[$i]!=""){
				$data = array('status' => 'pending');
				addLeadsInfoHistoryChanges($data , $users[$i] , $agent_no , 'bp');
				$where = "id = ".$users[$i];	
				//echo $where."<br>";
				$db->update('leads' ,  $data , $where);
			}	
		}
		$move_str = "Transferred to Pending Folder";	
	}
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<head>
<title>Leads List - Beta version</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/leads_tab.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<link rel="stylesheet" type="text/css" media="all" href="css/leads_list.css"  />
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}

function goto(id) 
{
	location.href = "apply_action2.php?id="+id+"&tab=follow_up";
}
function check_val()
{
	var ins = document.getElementsByName('users')
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
		vals[j]=ins[i].value;
		j++;
		}
	}
	document.form.applicants.value=(vals);
}


-->
</script>

</head>
<body style="background:#ffffff; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<?php include 'header.php';?>
<?php include 'BP_header.php';?>
<form name="form" method="post" action="<?php echo basename($_SERVER['SCRIPT_FILENAME']);?>" >
<input type="hidden" name="applicants" value="">
<div id="leads_search_form" style="background:#DEE5EB; border:#DEE5EB ridge 2px;">
<b>ADVANCED SEARCH</b>
<p><label ><b>Search Leads in :</b></label><select name="folder" class="select"  >
<option value="all">Search all folders</option>
  <?php echo $searchoptions;?> 
</select><span style="margin-left:20px; margin-right:10px;">Keyword</span><input type="text" name="keyword" class="select" id="keyword" value="<?php echo $keyword;?>" style=" width:300px;" ></p>
<p>
<label> 
<b>Date Registered :</b></label><input type="text" name="event_date" id="event_date"  size="15" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
<script type="text/javascript">
Calendar.setup({
   inputField     :    "event_date",     // id of the input field
				ifFormat       :    "%Y-%m-%d",      // format of the input field
				button         :    "bd",          // trigger for the calendar (button ID)
				align          :    "Tl",           // alignment (defaults to "Bl")
				showsTime	   :    false, 
				singleClick    :    true
			});                     
 </script>
&nbsp;&nbsp;<b>Ratings :</b>&nbsp;&nbsp;<select name="ratings" class="text" onChange="setStar(this.value);" >
<option value="">-</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select>
<span id="star" ></span>
<script>
<!--
function setStar(s)
{
	if (s==1)
	{
	newitem1="<img src='images/star.png' align='top'>";
	}
	if (s==2)
	{
	newitem1="<img src='images/star.png' align='top'><img src='images/star.png' align='top'>";
	}
	if (s==3)
	{
	newitem1="<img src='images/star.png' align='top'><img src='images/star.png' align='top'><img src='images/star.png' align='top'>";
	}
	if (s==4)
	{
	newitem1="<img src='images/star.png' align='top'><img src='images/star.png' align='top'><img src='images/star.png' align='top'><img src='images/star.png' align='top'>";
	}
	if (s==5)
	{
	newitem1="<img src='images/star.png' align='top'><img src='images/star.png' align='top'><img src='images/star.png' align='top'><img src='images/star.png' align='top'><img src='images/star.png' align='top'>";
	}	
	if (s=="")
	{
	newitem1="";
	}
	document.getElementById("star").innerHTML=newitem1;
}
-->
</script>
&nbsp;&nbsp;<b>Month :</b> &nbsp;&nbsp;
<select name="month"  style="font-size: 12px;" >
<?php echo $monthoptions;?>
</select>
</span>
</p>
<p><label><b>Actions :</b></label><input type="submit" name="search" value="Search"> &nbsp;<input type="button" name="add" value="Add New Lead" onClick="self.location='addnewlead.php'"/> &nbsp;<input type="submit" name="transfer" value="Begin Tranfer to" >&nbsp;&nbsp;
<select name="agent_id" class="select">
<?php echo $BPOptions;?>
</select> <?php echo $transfer_message;?></p>

<p><label><b>Move :</b></label> <input type="submit" name="move" value="New Leads" /> <input type="submit" name="move2" value="Keep in Touch" /> <input type="submit" name="move3" value="Pending" /></p>

<div style="clear:both;"></div>
</div>
</form>
<div align="center"><?php echo $move_str;?></div>
<?php include 'leads_list.php';?>




<?php include 'footer.php';?>	

</body>
</html>
