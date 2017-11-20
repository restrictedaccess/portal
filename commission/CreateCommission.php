<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}

$leads_id = $_SESSION['client_id'];

$commission_title = $_REQUEST['commission_title'];
$commission_amount = $_REQUEST['commission_amount'];
$commission_desc = $_REQUEST['commission_desc'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

/*
SELECT * FROM commission c;
commission_id, leads_id, created_by, created_by_type, commission_title, commission_amount, commission_desc, commission_status, date_created, date_approved, date_cancelled, response_by_id, response_by_type
*/
$query = "INSERT INTO commission SET leads_id = $leads_id, created_by = $leads_id, created_by_type = 'leads', commission_title = '$commission_title', commission_amount = '$commission_amount', commission_desc = '$commission_desc', date_created = '$ATZ';";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);
$commission_id = mysql_insert_id();



$queryStaff="SELECT DISTINCT(u.userid), CONCAT(u.fname,' ',u.lname),u.image
		FROM personal u
		JOIN subcontractors s ON s.userid = u.userid
		WHERE s.leads_id = $leads_id AND s.status='ACTIVE' ORDER BY u.fname ASC;";
$result=mysql_query($queryStaff);
if(!$result) die ("Error in Script.<br>".$queryStaff);
$counter = 0;
while(list($userid, $staff_name, $image  )=mysql_fetch_array($result))
{
	$counter++;
	$staff_list .= "<div class='dragableBox' id='box$counter' onmouseover='highlight(this)' onmouseout='unhighlight(this)' title='Drag and Drop $staff_name' >".$staff_name."<input type='hidden' id='staffbox$counter' value='$userid' /></div>";
	
}

$query = "SELECT commission_title, commission_amount, commission_desc FROM commission WHERE commission_id = $commission_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);
list($commission_title, $commission_amount, $commission_desc)=mysql_fetch_array($result);
?>
<input type="hidden" id="total_no_of_staff" value="<?=$counter;?>" />
<input type="hidden" id="commission_id" value="<?=$commission_id;?>" />
<div style="width:800px; padding:10px;"  >

<div id="commission_view_description">
	<div style="background:#F4F4F4; border:#999999 solid 1px; padding:5px;">
		<table width="100%">
			<tr>
				<td width="15%" valign="top"><b>Title : </b></td>
				<td width="85%" valign="top"><?=$commission_title;?></td>
			</tr>
			<tr>
				<td valign="top"><b>Amount : </b></td>
				<td valign="top"><?=$commission_amount;?></td>
			</tr>
			<tr>
				<td valign="top"><b>Description : </b></td>
				<td valign="top"><?=$commission_desc;?></td>
			</tr>
		
		</table>
	</div>
</div>
<div style="padding:5px;">
<input type="button" value="Finish" onclick="showForm(2);"  />
</div>
	<div class="left">
	<div class="hdr">Staff List</div>
	<div id="leftColumn">
		<div id="dropContent"><?=$staff_list;?></div>	
	</div>
	</div>
	<div id="add_delete_result">Move and Drop Staff to right panel</div>
	<div class="right">
		<div class="hdr">Selected Staff</div>
		<div id="rightColumn">
			<div id="dropBox" >
				<div id="dropContent2" ></div>
			</div>
		
		</div>
	</div>
	<div style="clear:both;"></div>
	
	
</div>







