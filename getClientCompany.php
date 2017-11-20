<?
$id=$_GET['id'];
include 'config.php'; 

$query="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y'),p.outsourcing_model, p.companyname, p.jobposition,p.status,l.fname,l.lname,p.lead_id
FROM posting p JOIN leads l ON l.id = p.lead_id WHERE p.lead_id= $id  AND p.status='ACTIVE' ORDER BY p.date_created DESC;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);


$output="
<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor='#666666'>
<td width='5%' align=LEFT><b><font size='1' color='#FFFFFF'>#</font></b></td>
<td width='17%' align=left><b><font size='1' color='#FFFFFF'>Job Position </font></b></td>
<td width='21%' align=left><b><font size='1' color='#FFFFFF'>Company Name</font></b></td>
<td width='12%' align=left><b><font size='1' color='#FFFFFF'>Client</font></b></td>
<td width='12%' align=left><b><font size='1' color='#FFFFFF'>Date</font></b></td>
<td width='14%' align=left><b><font size='1' color='#FFFFFF'>Outsourcing Model</font></b></td>
<td width='10%' align=left><b><font size='1' color='#FFFFFF'>Status</font></b></td>
</tr>";

if ($ctr >0 )
{
	$bgcolor="#f5f5f5";
	while(list($id,$date,$model,$companyname,$position,$status,$fname,$lname,$lead_id) = mysql_fetch_array($result))
	{
		$counter=@$counter+1;
	

	$output.="
		<tr bgcolor=$bgcolor>
			<td width='5%' align=left><font size='1'>$counter) <input type='radio' name='ads' value='$id' onClick=\"javascript: document.getElementById('subject_id').value=sub_value+' (".$position.")'; fillAds(this.value); \" /> </font></td>
			   <td width='17%' align=left><font size='1'>
			  <a href='ads.php?id=$id' target='_blank' >$position</a></font></td>
			  	  <td width='21%' align=left><font size='1'>$companyname</font></td>
			  <td width='12%' align=left><b><font size='1'>
			  <a href='#'onClick=javascript:popup_win('./viewLead.php?id=$lead_id',600,600);>$fname &nbsp; $lname</a></font></b></td>
			   <td width='12%' align=left><font size='1'>$date</font></td>
			  <td width='14%' align=left><font size='1'>$model</font></td>
				  <td width='10%' align=left><font size='1'>$status</font></td></tr>";
		 
			  if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
	}	
	//javascript:popup_win(./viewTrack.php?id=$id,500,400);


}
else
{
	$output.="<tr><td colspan=7 height=100>This client has no Active or Current Job Advertisement. Create a Job Advertisement for this Client? Click <a href='admin_addadvertisement.php?client_id=$id' class='link10'>here</a> </td></tr>";
}
$output.="</table>";
echo $output;

?>