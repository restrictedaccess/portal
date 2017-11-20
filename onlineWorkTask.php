<?

include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';

$client_id = $_SESSION['client_id'];
$userid=$_REQUEST['userid'];

$sql="SELECT id, date_start, date_finished, date_created, work_details, notes, percentage 
		FROM workflow WHERE client_id = $client_id AND userid = $userid ORDER BY date_start DESC";
//		echo $sql;
$result=mysql_query($sql);
$output="<table width='100%' border='0'>
  <tr>
    <td>#</td>
    <td>JOB DATE</td>
    <td>FINISHED DATE</td>
    <td>WORK DETAILS</td>
    <td>PROGRESS</td>
    <td>DATE CREATED</td>
    <td>NOTES</td>
  </tr>

";
while(list($id, $date_start, $date_finished, $date_created, $work_details, $notes, $percentage)=mysql_fetch_array($result))	
{
	$output.="<tr>
    <td>$id</td>
    <td>$date_start</td>
    <td>$date_finished</td>
    <td>$work_details</td>
    <td>$percentage</td>
    <td>$date_created</td>
    <td>$notes</td>
  </tr>";
  
}


$output.="</table>";
//$output = json_encode($return_data);
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
//header('Content-type: text/plain');
echo $output;

?>