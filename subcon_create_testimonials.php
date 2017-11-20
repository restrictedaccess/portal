<?php
include 'config.php';
include 'conf.php';
include 'time.php';

if($_SESSION['userid']=="")
{
	header("location:index.php");
}

$userid = $_SESSION['userid'];
$code=$_REQUEST['code'];
$testimony_id = $_REQUEST['testimony_id'];

if($testimony_id!=NULL){
	
	$query="SELECT recipient_id, title, testimony FROM testimonials t WHERE testimony_id = $testimony_id;";
	$result = mysql_query($query);
	list($recipient_id, $title, $testimony)=mysql_fetch_array($result);
	
}


$query="SELECT * FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name =$row['fname']."  ".$row['lname'];
}


$sqlClient="SELECT l.id, l.fname, l.lname, l.company_name
FROM subcontractors as s
left join leads as l on s.leads_id = l.id
where userid=$userid  and s.status = 'ACTIVE' order by s.date_contracted";

$resulta=mysql_query($sqlClient);
while(list($lead_id,$lead_fname,$lead_lname,$lead_company)=mysql_fetch_array($resulta))
{
	if($recipient_id == $lead_id)
      {
	 $clientoptions .= "<option selected value=\"$lead_id\">$lead_fname&nbsp;$lead_lname&nbsp;($lead_company)</option>\n";
      }
      else
      {
	 $clientoptions .= "<option value=\"$lead_id\">$lead_fname&nbsp;$lead_lname&nbsp;($lead_company)</option>\n";
      }
}




?>

<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="testimonials/testi.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript">
<!--
function validateInputs(){
	if(document.getElementById("testimony").value==""){
		alert("Please type a message!");
		return false;
	}
	return true;
}
-->
</script>


</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="subcon_create_testimonialsphp.php" onSubmit="return validateInputs();">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<input type="hidden" name="testimony_id" id="testimony_id" value="<?=$testimony_id;?>">
<!-- HEADER -->
<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" height="502" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="170" height="502" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <? include 'subconleftnav.php';?></td>
<td width="1064" valign="top" style=" font:12px Arial;">
<div style="padding:5px; background:#333333; color:#FFFFFF;">
	<div style="float:left;">
		<b>Create Testimonials</b>
	</div>
	<div style="float:right;"><input type="button" value="Back" onClick="self.location='mytestimonials.php'" style="font:11px tahoma;"></div>
	<div style="clear:both;"></div>
</div>

<table id="create_testi" width="100%" cellpadding="0" cellspacing="0">
<tr><td colspan="2" align="center" bgcolor="#FFFFCC"><b>
<? if($code==1) { echo "New Testimonial has been Saved! <input type='button' value='View' onClick=self.location='mytestimonials.php' style='font:11px tahoma; margin-left:20px;'>"; } 
if($code==2) { echo "Testimonial has been Updated! <input type='button' value='View' onClick=self.location='mytestimonials.php' style='font:11px tahoma; margin-left:20px;'>"; }
?></b></td></tr>
	<tr>
		<td width="21%" valign="top">Choose Client</td>
		<td width="79%" valign="top">
		<select name="leads_id"  id="leads_id" class="select" style="width:500px;" >
			<?=$clientoptions;?>
		</select>
		</td>
	</tr>
	<tr>
		<td width="21%" valign="top">Title</td>
		<td width="79%" valign="top">
		<input type="text" name="title" id="title" class="select" style="width:500px;" value="<?=$title;?>">
		</td>
	</tr>
	<tr>
		<td width="21%" valign="top">Testimonials</td>
		<td width="79%" valign="top">
		<textarea name="testimony" id="testimony" style="width:800px; height:350px; font:11px tahoma;"><?=$testimony;?></textarea>
		</td>
	</tr>
	
	<tr>
		<td width="21%" valign="top" colspan="2">
		<? if($testimony_id=="") {?>
		<input type="submit" value="Submit" name="save" id="save">
		<? }else {?>
		<input type="submit" value="Update" name="update" id="update">
		<? }?>
		<input type="reset" value="Cancel">
		</td>
	</tr>
</table>


</td>
</tr>
</table>
<? include 'footer.php';?>
</form>
</body>
</html>
