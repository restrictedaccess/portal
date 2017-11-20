<?php
require('../conf/zend_smarty_conf.php');
$personal = $db->fetchRow($db->select()->from("personal", array("userid", "fname", "lname"))->where("userid = ?", $_REQUEST["userid"]));
echo json_encode(array("personal"=>$personal, "date"=>date("F j, Y", strtotime($_REQUEST["date"]))));
