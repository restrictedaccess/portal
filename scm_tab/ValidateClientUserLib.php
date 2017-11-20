<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependency on rowCount
    include("../conf.php");
    session_start();
	$client_id = $_SESSION['client_id']; 
    if ($client_id == null){
        die('Invalid Client');
    }

    $userid = $_GET['userid'];
    if ($userid == null){
        die('Invalid user id');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    //verify if user is under the agent
    $query = "select id from subcontractors where leads_id = $client_id and userid = $userid";
    $result = $dbh->query($query)->fetchAll();
    if (count($result) == 0) {
        die("Security breach! Subcontractor is not under the Agent.");
    }
?>
