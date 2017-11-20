<?
include 'config.php';
include 'conf.php';
include 'conf/zend_smarty_conf.php';
//$userid=$_SESSION['userid'];
$userid = @$_GET["userid"];
//$userid=$_REQUEST['userid'];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];

if(!$_SESSION['admin_id'])
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:/portal/");
}


$language="";
$languageoptions="";
$languageArray=array("Arabic","Bahasa Indonesia","Bahasa Malaysia","Bengali","Chinese","Dutch","English","Filipino","French","German","Hebrew","Hindi","Italian","Japanese","Korean","Portuguese","Russian","Spanish","Tamil","Thai","Vietnamese");
for ($i = 0; $i < count($languageArray); $i++)
{
  if($language == $languageArray[$i])
  {
 $languageoptions .= "<option selected value=\"$languageArray[$i]\">$languageArray[$i]</option>\n";
  }
  else
  {
 $languageoptions .= "<option value=\"$languageArray[$i]\">$languageArray[$i]</option>\n";
  }
}



?>
<html>
<head>
<title>MyProfile &copy; RemoteStaff.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript">
<!--
function checkFields()
{
	//if (confirm("Are you sure"))
	//{
	//	return true;
	//}
	//else return false;		
	//alert (document.frmSkills.skill.value);
	
	missinginfo = "";
	if (document.frmLang.language.selectedIndex ==0)
	{
		missinginfo += "\n     -  Please enter a Language";
	}
	//
	if (document.frmLang.spoken.selectedIndex ==0)
	{
		missinginfo += "\n     -  Please rate your language(Spoken) proficiency";
	}
	
	// written
	if (document.frmLang.written.selectedIndex ==0)
	{
		missinginfo += "\n     -  Please rate your language(Written) proficiency";
	}
	
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	else return true;

	
}
-->
</script>	
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>


<center>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="100%" bgcolor="#ffffff" align="center">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>

</td></tr>
<tr>
<td width=100% valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" id="communication" action="/portal/recruiter/update_english_communication.php">
	<?php
		$english_comm_skill = $db->fetchOne($db->select()->from("personal", array("english_communication_skill"))->where("userid = ?", $userid));
	?>
	<input type="hidden" name="userid" value="<?php echo $userid?>"/>
	<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
		<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>English Communication Skill</b></td></tr>
		<tr><td align=right width=30% >Spoken :</td>
			<td align=left width=70% >
				<select name="english_communication">
					<option value=""></option>
					<?php
						for($i=1;$i<=10;$i++){
							$selected = "";	
							if ($i==$english_comm_skill){
								$selected="selected='selected'";
							}
							?>
							<option value="<?php echo $i?>" <?php echo $selected?>><?php echo $i?></option>
							<?php
						}
					?>
				</select><button type="submit">Save</button>
			</td>
		</tr>
	</table>
</form>	
	
	
<form method="POST" name="frmLang" action="admin_updatelanguagesphp.php?userid=<?php echo $userid; ?>"  onsubmit="">
<input type="hidden" name="userid" value="<? echo $userid;?>">

<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Add a Language (OPTIONAL)</b></td></tr>
<tr><td colspan=2 >Select only languages you are fluent in and rate your proficiency (0=Poor - 10=Excellent).</td></tr>
<tr><td align=right width=30% >Language :</td><td><select name="language" style="font:8pt, Verdana" >
<option value="-">-</option>
<? echo $languageoptions;?>
</select>
</td></tr>
<tr><td align=right width=30% >Spoken :</td>
<td>
<select name="spoken"  style="font:8pt, Verdana">
<option value=0>0</option>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
<option value=6>6</option>
<option value=7>7</option>
<option value=8>8</option>
<option value=9>9</option>
<option value=10>10</option>
</select>
</td></tr>
<tr><td align=right width=30% >Written :</td>
<td><select name="written"  style="font:8pt, Verdana">
<option value=0>0</option>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
<option value=6>6</option>
<option value=7>7</option>
<option value=8>8</option>
<option value=9>9</option>
<option value=10>10</option>
</select>
</td></tr>
<tr><td colspan=2>
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
<INPUT type="submit" value="Save and add more" name="Add" class="button" style="width:240px">
</td></tr></table>
</td></tr>
</table>
<!-- skills list -->
<br clear=all><br>

<?
$counter = 0;
//$query="SELECT id,language,spoken,written FROM language WHERE userid=$userid;";
//echo $query;
//$result=mysql_query($query);
//echo @mysql_num_rows($result);
//$ctr=@mysql_num_rows($result);
$ctr=$db->fetchAll("SELECT id,language,spoken,written FROM language WHERE userid=$userid;");
if ($ctr)
{
 echo "<table width=98% cellspacing=0 cellpadding=0 align=center>
<tr><td><br><b>Languages Added to Your Resume (Maximum of 5 Languages)</b><br><br></td></tr>
<tr><td bgcolor=#333366 height=1>
<img src='images/space.gif' height=1 width=1>
</td></tr>
<tr><td>


<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='6%' align=center>#</td>
<td width='33%' align=left><b><font size='1'>Language</font></b></td>
<td width='26%' align=center><b><font size='1'>Spoken</font></b></td>
<td width='35%' align=center><b><font size='1'>Written</font></b></td>
<td width='26%' align=center><b><font size='1'>Action</font></b></td>
</tr>";


	$bgcolor="#f5f5f5";
	
	
	foreach($ctr as $language_item){
		$counter=$counter+1;
		$id = $language_item["id"];
		$language = $language_item["language"];
		$spoken = $language_item["spoken"];
		$written = $language_item["written"];
		
		$counter=$counter+1;
		
			
		echo "<tr bgcolor=$bgcolor>
			  <td width='6%' align=center><font size='1'>".$counter.".</font></td>
			  <td width='33%' align=left><font size='1'>".$language."</font></td>
			  <td width='26%' align=center><font size='1'>".$spoken."</font></td>
			  <td width='35%' align=center><font size='1'>".$written."</font></td>
			  <td width='26%' align=center><font size='1'><a href='#' onclick ='go($id); return false;'>delete</a></font></td>
			 </tr>";
			  if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
	}
		
echo "</table>
	</td></tr>
	<tr><td bgcolor=#333366 height=1>
	<img src='images/space.gif' height=1 width=1></td></tr></table>";
	
	
}
?>

<!-- --->
<br><input type=hidden name=mode value="update"></form>
<script language=javascript>
<!--
	function go(id) 
	{
		
			if (confirm("Are you sure you want to delete this skill?")) {
				location.href = "admin_deletelanguage2.php?id="+id+"&userid="+<? echo $userid;?>;
				//alert(id);
			}
	}
//-->
</script>
</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
</center>

</body>
</html>
