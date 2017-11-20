<?
include '../config.php';
include '../conf.php';
$id =$_REQUEST['id'];
if($id==""){
	die("History ID is Missing..");
}
$query ="SELECT history, DATE_FORMAT(date_created,'%D %b %Y'),subject,actions FROM history WHERE id = $id;";
$result=mysql_query($query);
list($desc,$date,$subject,$actions)= mysql_fetch_array($result);



$sql = "DELETE FROM history WHERE id = $id;";
$res = mysql_query($sql);
if($res){
	echo $date." - ".$subject ." has been deleted!";
}else{
	echo "There was an error in deleting data . " .$date." - ".$subject ;
}

?>