<?
include 'config.php';
$id=$_GET['q'];
if($id==1)
{
echo "<table width='100%'><tr><td width='11%'>First Name</td><td width='1%'>:</td><td width='88%'><input type='text' name='fname' class='text' size=40 ></td></tr>
<tr><td width='11%'>Last Name</td><td width='1%'>:</td><td width='88%'><input type='text' name='lname' class='text' size=40></td></tr>	
<tr><td width='11%'>Email</td><td width='1%'>:</td><td width='88%'><input type='text' name='email' class='text' size=40 ></td></tr>
<tr><td width='11%'>Skype</td><td width='1%'>:</td><td width='88%'><input type='text' name='skype' class='text' size=40 ></td></tr>
<tr><td width='11%'>Contact No/s.</td><td width='1%'>:</td><td width='88%'><input type='text' name='phone' class='text' size=40 ></td></tr>
</table>";
}

if($id==2)
{
echo "&nbsp;";
}

?>