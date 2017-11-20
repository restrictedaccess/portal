<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$query ="SELECT id,description,status,DATE_FORMAT(created_date,'%D %b %Y') FROM payments_invoice ;";
//echo $query;

$result =mysql_query($query);
$counter =0;
while(list($id,$description,$status,$created_date)=mysql_fetch_array($result))
{
	$counter++;
?>
		<div class="list_wrapper" onMouseOver="highlight(this);" onMouseOut="unhighlight(this);" onClick="showDetails(<?=$id;?>)" >
				<div class="item_no"><?=$counter;?></div>
				<div class="name"><?=$description;?></div>
				<div class="amount_peso"><?=$created_date;?></div>
				<div class="amount_dollar"><?=$status;?></div>
			</div>
<?
}
?>


