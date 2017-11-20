<?php
	putenv("TZ=Australia/Sydney");
	session_start();
	@$agent_no = $_SESSION['agent_no'];
	
	if(@isset($_POST["submit_notes"]))
	{
		require_once("conf/connect.php");         
		$user_id = $agent_no;
		$name = $_POST["name"];
		$type = $_POST["type"];
		$category = $_POST["category"];
		$notes = $_POST["notes"];
		$date_posted = date("Ymd");
		$db=connsql();
		mysql_query("INSERT INTO tb_calendar_notes(user_id, category, type, notes, status, date_posted) VALUES('$name', '$category', '$type', '$notes', '0', '$date_posted')");
		dieSql($db);	
?>
		<script language="javascript"> alert("Your notes has been added."); </script>
<?php		
	}
?>


<script language="javascript">
	function validate(form) 
	{
		if (form.name.value == '') { alert("You forgot to enter your name."); form.name.focus(); return false; }	
		if (form.notes.value == '') { alert("You forgot to enter your notes."); form.notes.focus(); return false; }	
		return true
	}
</script>


<form method="POST" name="form" action="?" onSubmit="return validate(this)">
<table border="0" cellspacing="3" cellpadding="0" width="100%">
  <tr>
    <td colspan="2" align="right"><font size="1" face="Arial, Helvetica, sans-serif" color="#999999"><strong>Note Down Any Issues or Problems you may be having</strong></font></td>
  </tr>
  <tr>
    <td colspan="2" align="right">
		<input type="text" name="name" value="Enter Your Name" onClick="javascript: this.value=''; " style='width:100px; color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
		<select name="type" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
			<option value="" selected>Select Type</option>
			<option value="High">High</option>
			<option value="Medium">Medium</option>
			<option value="Low">Low</option>
    	</select>		
		<select name="category" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
			<option value="" selected>Select Category</option>
			<option value='Affiliate Issue'>Affiliate issues</option>
			<option value='Business Partner Issue'>Business Partner issues</option>
			<option value="RSSC IT System">RSSC IT System</option>
			<option value="Customer Care Issue">Customer Care Issue</option>
			<option value="Sub Contractor Issue">Sub Contractor Issue</option>
			<option value="Client Tax Invoice Issue">Client Tax Invoice Issue</option>
			<option value="Sub Con Invoice Issue">Sub Con Invoice Issue</option>
			<option value="Commission Issue">Commission Issue</option>
			<option value="Staff Replacement Issue">Staff Replacement Issue</option>
			<option value="Internet Connection Issue">Internet Connection Issue</option>
			<option value="VOIP Phone Issues">VOIP Phone Issues</option>
			<option value="Other">Other</option>
    	</select>
	</td>
  </tr>
  <tr>
    <td colspan="2" align="right"><textarea onClick="javascript: this.value=''; " name="notes" style='width:330px; height:50px; color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>Notes</textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="submit" name="submit_notes" value="Submit" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
  </tr>
</table>
</form>