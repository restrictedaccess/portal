<?php
include ('../conf/zend_smarty_conf.php');
if (!isset($_SESSION["admin_id"])&&!isset($_SESSION['agent_no'])){
    header("Location:/portal/");
    exit;
}else{
   if(isset($_SESSION['admin_id'])){
	   $_SESSION["filled_up_by_id"] = $_SESSION["admin_id"];
	   $_SESSION["filled_up_by_type"] = "admin";
  }else{
	   $_SESSION["filled_up_by_id"] = $_SESSION["agent_no"];
	   $_SESSION["filled_up_by_type"] = "agent";
  }
}
$leads_id = $_GET["leads_id"];
$_SESSION["client_id"] = $leads_id;
$_SESSION["leads_id"] = $leads_id;
if (isset($_GET["from"])){
    header("Location:/portal/custom_get_started/step2_leads.php?from={$_GET["from"]}");
}else{
    header("Location:/portal/custom_get_started/step2_leads.php?from=portal");
}
