<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include 'steps_taken.php';
include 'function.php';


if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$agent_id = $_REQUEST['agent_id'];

$delete = $_REQUEST['delete'];
$leads_id = $_REQUEST['leads_id'];

//$lead_status = "Client";
$lead_status = $_REQUEST['lead_status'];
//echo $lead_status."<br>";
if($lead_status!=""){
	if($lead_status == "all"){
		//$folder = "Inactive"; 
		$lead_status = " l.status != 'Inactive' ";
	}else{
		$folder = $lead_status; 
		$lead_status = " l.status = '$lead_status' ";
	}
}else{
	$lead_status = " l.status = 'Client' ";
	$folder = "Client"; 
}

$sql = $db->select()
	->from('admin')
	->where('admin_id = ?' , $admin_id);
$row = $db->fetchRow($sql);	
$admin_name = "Welcome Admin :".$row['admin_fname']." ".$row['admin_lname'];


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$keyword=$_REQUEST['keyword'];
$event_date=$_REQUEST['event_date'];
$ratings=$_REQUEST['ratings'];
$month=$_REQUEST['month'];

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
$rowsPerPage = 50;
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
	$BPOptions.="<option value='".$agent['agent_no']."'>".$agent['agent_name']."</option>";
}
$remark_id = $_REQUEST['remark_id'];
if($remark_id!=NULL){
	//DELETE RECORD
	$where = "id = ".$remark_id;	
	$db->delete('leads_remarks' , $where);
}




$monthArray=array("","01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
}



if ($delete!=NULL and $delete=="TRUE"){
	$data = array('status' => 'REMOVED');
	addLeadsInfoHistoryChanges($data , $leads_id , $admin_id , 'admin');
	$where = "id = ".$leads_id;	
	$db->update('leads' ,  $data , $where);

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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<head>
<title>Admin Leads List - Beta version</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="css/leads_tab.css">
<link rel="stylesheet" type="text/css" media="all" href="css/leads_list.css"  />

<script type="text/javascript" src="js/tooltip.js"></script>	
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.cursor='pointer';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
}
function goto(id) 
{
	location.href = "admin_apply_action.php?id="+id+"&page=client";
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
function check_val2()
{
	userval =new Array();
	var userlen = document.getElementsByName("userss").length;
	
	var counter=0;
	for(i=0; i<userlen; i++)
	{
		if(document.getElementsByName("userss")[i].checked==true)
		{	
			userval.push(document.getElementsByName("userss")[i].value);
			counter++;
		}
	}
	if(counter<6)
	{
		document.getElementById("leads").value=(userval);
	}else
	{
		alert("Maximum of 5 records is allowed to Delete !");
	}

}

-->
</script>
<style>
<!--
.pagination{
padding: 5px;
text-align:right;
}

.pagination ul{
margin: 0;
padding: 0;
/*text-align: center; Set to "right" to right align pagination interface*/
font-family: tahoma; font-size: 10px;
}

.pagination li{
list-style-type: none;
display: inline;
padding-bottom: 1px;
}

.pagination a, .pagination a:visited{
padding: 0 5px;
border: 1px solid #9aafe5;
text-decoration: none; 
color: #2e6ab1;
}

.pagination a:hover, .pagination a:active{
border: 1px solid #2b66a5;
color: #000;
background-color: #FFFF80;
}

.pagination a.currentpage{
background-color: #2e6ab1;
color: #FFF !important;
border-color: #2b66a5;
font-weight: bold;
cursor: default;
}

.pagination a.disablelink, .pagination a.disablelink:hover{
background-color: white;
cursor: default;
color: #929292;
border-color: #929292;
font-weight: normal !important;
}

.pagination a.prevnext{
font-weight: bold;
}

.add_note{
 font:10px tahoma;
 width:40px;
}

#dhtmltooltip{
position: absolute;
font-family:Verdana;
font-size:11px;
left: -300px;
width: 350px;
border: 1px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}
-->
</style>
</head>
<body style="background:#ffffff; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>
<form name="form" method="post" action="<?php echo  basename($_SERVER['SCRIPT_FILENAME']);?>" >
<input type="hidden" name="applicants" value="">
<div style="padding-right:20px; FONT: bold 7.5pt verdana; COLOR: #676767; margin:5px;"><?php echo  $admin_name;?></div>
<div id="leads_search_form" style="background:#DEE5EB; border:#DEE5EB ridge 2px;">
<b>ADVANCED SEARCH</b>
<p><label ><b>Search Leads in :</b></label><select name="lead_status" class="select" onchange="javascript:document.form.submit();" >
<option value="all">Search all folders</option>
  <?php echo $searchoptions;?> 
</select><span style="margin-left:20px; margin-right:10px;">Keyword</span><input type="text" name="keyword" class="select" id="keyword" value="<?php echo  $keyword;?>" style=" width:300px;" ></p>
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
<p><label><b>Actions :</b></label><input type="submit" name="search" value="Search"> &nbsp;<input type="button" name="add" value="Add New Lead" onClick="self.location='adminaddnewlead.php'"/> &nbsp;<input type="button" value="Export to Excel" onclick="self.location='admin_export_excel_client_listing.php'" /></p>
<div style="clear:both;"></div>
</div>
</form>
<?php include 'leads_list_admin.php';?>
<?php include 'footer.php';?>	
</body>
</html>