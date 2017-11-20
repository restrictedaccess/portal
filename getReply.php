<?
include 'conf.php';
include 'config.php';

$id=$_REQUEST['q'];
//id, client_id, comments, date_posted, status, admin_reply, admin_reply_date
$query="SELECT * FROM client_comments c WHERE id = $id;";
$result=mysql_query($query);
$row = mysql_fetch_array ($result); 
$admin_reply = $row['admin_reply'];
echo "<p><textarea id='comments' name='comments' rows='5' >".$admin_reply."</textarea></p>";
?>