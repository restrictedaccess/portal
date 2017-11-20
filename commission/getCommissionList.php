<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}

$leads_id = $_SESSION['client_id'];
?>


<table width="100%" cellpadding="2" cellspacing="0">

<?
$query = "SELECT commission_id, commission_title, commission_amount, commission_desc,  DATE_FORMAT(date_created,'%D %b %Y') FROM commission WHERE created_by = $leads_id AND  created_by_type = 'leads' ORDER BY commission_id DESC;";
//echo $query;
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);
if(mysql_num_rows($result) > 0 ){
$counter=0;
	while(list($commission_id, $commission_title, $commission_amount, $commission_desc, $date_created)=mysql_fetch_array($result))
	{
		$counter++;
		?>
			<tr onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick="viewCommissions(<?=$commission_id;?>)">
			<td width="10%"><?=$counter;?> ) </td>
			<td width="80%" title="<?=$commission_title;?>"><?=substr($commission_title,0,25);?></td>
			</tr>
			
		<?
	}	
}else{
	echo "<tr><td>You have not yet created a commission rule for your staff <br />
<a href='javascript:showForm(3)'>Create</a></td></tr>";
}

?>
</table>