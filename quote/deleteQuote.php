<?
include '../config.php';
include '../conf.php';

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

$quote_id = $_REQUEST['id'];

if($quote_id==""){
	die("Quote ID is Missing!");
}

$query = "SELECT q.quote_no, DATE_FORMAT(date_quoted,'%D %b %Y'),CONCAT(l.fname,' ',l.lname) , l.email,l.company_name, salary, client_timezone, client_start_work_hour, client_finish_work_hour, lunch_start, lunch_out, lunch_hour, work_start, work_finish, working_hours, days, quoted_price
		   FROM quote q 
		   LEFT JOIN leads l ON l.id = q.leads_id 
		   LEFT JOIN quote_details d ON d.quote_id = q.id
		   WHERE q.id = $quote_id;";
$result = mysql_query($query);
list($quote_no,$date,$leads_name,$email,$company_name, $salary, $client_timezone, $client_start_work_hour, $client_finish_work_hour, $lunch_start, $lunch_out, $lunch_hour, $work_start, $work_finish, $working_hours, $days, $quoted_price)=mysql_fetch_array($result);


////
$query ="DELETE FROM quote  WHERE id = $quote_id;";
mysql_query($query);
$query2 = "DELETE FROM quote_details  WHERE quote_id = $quote_id;";
mysql_query($query2);
$query3 = "DELETE FROM quote_notes  WHERE quote_id = $quote_id;";
mysql_query($query3);

//echo $query."<br>".$query2."<br>".$query3."<br>";


?>

<div style="font:12px Arial; padding:10px;">
<p>Quote No. <?=$quote_no;?> has been deleted permanently!</p>
<p><b>Quote Detail</b></p>
<p><label>Quote Date :</label> <?=$date;?></p>
<p><label>Leads :</label> <?=$leads_name;?></p>
<p><label>Email :</label> <?=$email;?></p>
<p><label>Company Name :</label> <?=$company_name;?></p>
</div>



