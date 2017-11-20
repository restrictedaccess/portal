<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependency on rowCount
    include("../conf.php");
	$agent_no = $_SESSION['agent_no']; 
    if (($agent_no == null) or ($agent_no == '')){
        die('Invalid agent');
    }

    $userid = $_GET['userid'];
    if (($userid == null) or ($userid == '')){
        die('Invalid user id');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    //verify if user is under the agent
    $query = "select id from subcontractors where agent_id = $agent_no and userid = $userid";
    $result = $dbh->query($query)->fetchAll();
    if (count($result) == 0) {
        die("Security breach! Subcontractor is not under the Agent.");
    }
?>
