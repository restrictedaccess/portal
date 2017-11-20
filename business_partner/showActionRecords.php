<?
include '../config.php';
include '../conf.php';
if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}
$agent_no = $_SESSION['agent_no'];
$leads_id = $_REQUEST['leads_id'];
if($leads_id=="")
{
	die("Lead ID is missing..!");
}
$queryLeads ="SELECT * FROM leads WHERE id = $leads_id;";
$resultLeads=mysql_query($queryLeads);
$rows = mysql_fetch_array($resultLeads);
$lname =$rows['lname'];
$fname =$rows['fname'];
$status =$rows['status'];

?>

<table width="100%" border="1">
	<tr>
	  <td width="35%" valign="top">
	  	<div id="action_wrapper">
		  <div style="padding:3px;">
		  <p><b>Add Record </b></p>
		  <p><label>Lead Name : </label><b style="color:#FF0000;"><?=$fname." ".$lname ? strtoupper($fname." ".$lname) : '&nbsp;&nbsp;';?> </b></p>
		   <p><label>Status : </label><?=$status ? $status : '&nbsp;';?></p>
		  <p><label>Action Options :</label>
		  <select id="action" name="action">
		  <option value="">---- Please Select ----</option>
		  <option value="EMAIL">EMAIL</option>
		  <option value="CALL">CALL</option>
		  <option value="MAIL">NOTES</option>
		  <option value="MEETING FACE TO FACE">MEETING FACE TO FACE</option>
		  </select>
		  <input type="button" value="Add" class="new_button" onClick="showActionRecordForm();" ></p>
		  <hr>
		  </div>
		  <div id="action_record_list"></div>
		</div>
      </td>
	  <td width="65%" valign="top">
		  <div id="action_history">
			<p>To add a record, Choose one of the Action Options then click the "Go" button then a form will shows up.</p>
			<p>Select from List of current record to view its details.</p>
		  </div>
	  
	  </td>
	</tr>
</table>

