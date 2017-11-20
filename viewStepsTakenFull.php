<?
include 'steps_taken.php';
$id = $_REQUEST['id'];

?>
<div style="font:12px Arial; padding:5px;">
<?php
leadsInfoDetails($id);
getClientStaff($id);
showAgentFrom($date_move,$agent_from);
getStepsTaken($id);
?>
</div>