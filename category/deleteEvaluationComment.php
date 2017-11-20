<?
include '../config.php';
include '../conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}

$admin_id = $_SESSION['admin_id'];
$userid =$_REQUEST['userid'];
$id = $_REQUEST['id'];

/*
SELECT * FROM evaluation_comments e;
id, comment_by, userid, comments, comment_date

*/
$query = "DELETE FROM evaluation_comments WHERE id = $id";
$result = mysql_query($query);			
if(!$result){
	die("MySQL Error : <br>" .$query."<br>".mysql_error());
}



?>

	<div style='border:#000000 outset 1px; font: 12px Arial; background:#CCCCCC '>
		<div style='float:left; width:30px; display:block;font: 12px Arial;'><strong>#</strong></div>
		<div style='float:left; width:450px; display:block;font: 12px Arial;text-align:center;border-left:#000000 solid 1px; border-right:#000000 solid 1px;'><strong>Comments / Notes</strong></div>
		<div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center;'><strong>Date</strong></div>
		<div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center; border-left:#000000 solid 1px;'><strong>Comment By</strong></div>
		<div style='clear:both;'></div>
	</div>
<?
$sql = "SELECT id, comments, DATE_FORMAT(comment_date,'%D %b %y'),a.admin_fname  FROM evaluation_comments e LEFT OUTER JOIN admin a ON a.admin_id = e.comment_by WHERE userid = $userid;";


//echo $sql;
$result = mysql_query($sql);
$counter = 0;
while(list($id, $comments, $date , $admin_fname)=mysql_fetch_array($result))
{
	$counter++;
 ?>
 
 	<div style='border:#CCCCCC  solid 1px; font: 12px Arial; background:#FFFFFF '>
		<div style='float:left; width:30px; display:block;font: 12px Arial;'><?=$counter?></div>
		<div style='float:left; width:450px; display:block;font: 11px Arial;text-align:center;border-left:#000000 solid 1px; border-right:#000000 solid 1px;'>
		<?=$comments;?>
		</div>
		<div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center;'><?=$date;?></div>
		<div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center; border-left:#000000 solid 1px;'><?=$admin_fname?></div>
		<div title="Delete this comment" onClick="deleteComment(<?=$id;?>);" style="float:left; width:20px; display:block;font: 12px Arial; color:#0000FF; cursor:pointer;">X</div>
		<div style='clear:both;'></div>
	</div>
 
 <?
}

?>

