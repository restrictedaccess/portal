<?php
    include("../conf.php");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    date_default_timezone_set("Asia/Manila");

// $query = "SELECT distinct(s.userid), p.lname, p.fname, p.email from subcontractors as s left join personal as p on s.userid = p.userid order by p.lname, p.fname";
  $query = "SELECT distinct(s.userid), p.lname, p.fname, p.email from subcontractors as s left join personal as p on s.userid = p.userid where s.status ='ACTIVE' order by p.fname ASC;";
 
    $return_data = $dbh->query($query);

    $output = json_encode($return_data->fetchAll());
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    echo $output;
?>
