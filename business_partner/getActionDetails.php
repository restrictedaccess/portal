<?
include '../config.php';
include '../conf.php';
if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}
$agent_no = $_SESSION['agent_no'];
$id = $_REQUEST['id'];
if($id=="")
{
	die("Lead ID is missing..!");
}

$query ="SELECT history, DATE_FORMAT(date_created,'%D %b %Y'),subject,actions FROM history WHERE id = $id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0)
{
	list($desc,$date,$subject,$actions)= mysql_fetch_array($result);
	$desc= str_replace("\n\r","<br>",$desc);

}

?>

<div style="padding:10px; text-align:justify; border:#CCCCCC dashed 1px;">
<div style="padding:5px; margin-bottom:10px; background:#E1E4F0; border:#000000 solid 1px;">
	<div style="margin:3px;"><b>Subject : </b><span style="margin-left:20px;"><?=$subject ? $subject : '[ No Subject ]';?></span></div>
	<div style="margin:3px;"><b>Action : </b><span style="margin-left:20px;"><?=$actions ? $actions : '&nbsp;';?></span></div>
	<div style="margin:3px;"><b>Date Created : </b><span style="margin-left:20px;"><?=$date;?></span></div>
	<div style="margin:5px;"><input type="button" class="new_button" name="edit" value="Edit" onClick="editActionDetails(<?=$id;?>);" >&nbsp;<input type="button" class="new_button" name="delete" value="Delete" onClick="deleteActionRecords(<?=$id;?>);" ></div>
</div>
<?=$desc;?>
</div>