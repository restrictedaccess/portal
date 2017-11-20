<?php
//roy session variables
$_SESSION['l_id'] = @$_GET["id"];
$query ="SELECT fname, lname FROM leads WHERE id = '".$_SESSION['l_id']."'";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$_SESSION['s_name'] = $row['fname']." ".$row['lname'];
}	
//ended
?>