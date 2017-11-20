<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../conf/zend_smarty_conf.php');
include('../config.php');
include('../conf.php');
include('../function.php');
include('../time.php');

//START: validate users
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['agent_no'])) {
    echo '
	<script language="javascript">
		alert("Session expired...' . $_SESSION['admin_id'] . '");
		window.location="../index.php";
	</script>
	';
}
if ($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL") {
    echo "This page is for HR usage only.";
    exit;
}
//ENDED: validate users

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

//START: add to shortlisted staff
$userid = @$_GET["userid"];
if (@isset($_POST["shortlist"])) {
    $client_name = @$_POST["client_name"];
    $position = @$_POST["position"];
    $status = "Active";
    $date_endoesed = date("Y-m-d");

    $data = $db->fetchRow($db->select()->from(array("ss" => "tb_shortlist_history"), array("ss.userid"))->where("ss.userid = ?", $userid)->where("ss.position = ?", $position));
    if (!$data) {
        $data = array(
            'userid' => $userid,
            'position' => $position,
            'status' => $status,
            'date_listed' => date("Y-m-d"),
            'admin_id' => $_SESSION['admin_id']
        );
        $db->insert('tb_shortlist_history', $data);
        $shortlistId = $db->lastInsertId();


        $gs_job_titles_details_id = $db->fetchOne($db->select()->from("posting", array("job_order_id"))->where("id = ?", $position));
        if ($gs_job_titles_details_id) {
            require_once dirname(__FILE__) . "/../lib/JobOrderManager.php";
            try {

                if (TEST) {
                    $mongo = new MongoClient(MONGODB_TEST);
                    $database = $mongo->selectDB('prod');
                } else {
                    $mongo = new MongoClient(MONGODB_SERVER);
                    $database = $mongo->selectDB('prod');
                }

                $job_order_collection = $database->selectCollection("job_orders");

                $cursor = $job_order_collection->find(array("gs_job_titles_details_id" => intval($gs_job_titles_details_id)));
                $tracking_code = "";
                while ($cursor->hasNext()) {
                    $jo = $cursor->getNext();
                    $tracking_code = $jo["tracking_code"];
                    if ($tracking_code) {
                        break;
                    }
                }
                if ($tracking_code) {
                    $manager = new JobOrderManager($db);
                    $manager->hiringStatus($tracking_code, JobOrderManager::NEW_SHORTLIST);
                }
            } catch (Exception $e) {
                echo $e->__toString();

            }
        }

        $data = array(
            'status' => 'Shortlisted'
        );
        $where = "userid = " . $userid;
        $db->update('applicants', $data, $where);

        $sql = $db->select()
            ->from('personal')
            ->where('userid = ?', $userid);
        $n = $db->fetchRow($sql);
        $name = $n['fname'] . " " . $n['lname'];
        echo '<script language="javascript"> alert("' . $name . ' has been successfully added to shortlist."); top.opener.location.reload(); window.close(); </script>';

        //start: add status lookup or history
        $admin_id = $_SESSION['admin_id'];
        if ($status == "INACTIVE") {
            $status_to_use = $other;
        } else {
            $status_to_use = $status;
        }
        $data2 = array(
            'personal_id' => $userid,
            'admin_id' => $admin_id,
            'status' => 'SHORTLISTED',
            'date' => date("Y-m-d") . " " . date("H:i:s"),
            "link_id" => $shortlistId
        );
        $db->insert('applicant_status', $data2);
        //ended: add status lookup or history

        //update personal
        $AusTime = date("h:i:s");
        $AusDate = date("Y") . "-" . date("m") . "-" . date("d");
        $ATZ = $AusDate . " " . $AusTime;
        $date = $ATZ;
        mysql_query("UPDATE personal SET dateupdated = '" . $date . "' WHERE userid = " . $userid);

        //start: staff status
        include_once('../lib/staff_status.php');
        staff_status($db, $_SESSION['admin_id'], $userid, 'SHORTLISTED');
        //ended: staff status


        //start: insert staff history
        include('../lib/staff_history.php');
        staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'STAFF STATUS', 'INSERT', 'SHORTLISTED');


        //ended: insert staff history

        //sync: sync to job order page
        //force update job orders of the lead

        $posting = $db->fetchRow($db->select()->from("posting", "lead_id")->where("id = ?", $position));
        if ($posting) {
            $db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $posting["lead_id"]));
            try {
                if (TEST) {
                    $mongo = new MongoClient(MONGODB_TEST);
                    $database = $mongo->selectDB('prod');
                } else {
                    $mongo = new MongoClient(MONGODB_SERVER);
                    $database = $mongo->selectDB('prod');
                }


                $job_orders_collection = $database->selectCollection('job_orders');
                $job_orders_collection->remove(array("leads_id" => intval($posting["lead_id"])), array("justOne" => false));
            } catch (Exception $e) {
                echo $e->__toString();
            }
            global $curl;
            if (TEST) {
                $curl->get("http://devs.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
                $curl->get("http://devs.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
                $curl->get("http://devs.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
                $curl->get("http://devs.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
                $curl->get("http://devs.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
                $curl->get("http://devs.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");

            } else {
                $curl->get("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
                $curl->get("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
                $curl->get("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
                $curl->get("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
                $curl->get("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
                $curl->get("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");

            }
        }

    } else {
        $sql = $db->select()
            ->from('posting', array("jobposition"))
            ->where('id = ?', $position);
        $pos = $db->fetchRow($sql);
        $pos = $pos["jobposition"];

        $sql = $db->select()
            ->from('personal')
            ->where('userid = ?', $userid);
        $n = $db->fetchRow($sql);
        $name = $n['fname'] . " " . $n['lname'];

        echo '<script language="javascript"> alert("' . $name . ' has already been shortlisted for the ' . $pos . ' position."); </script>';
    }


}
//ENDED: add to shortlisted staff


//START: generate list of position
$output = "
<table width=100% cellspacing=1 cellpadding=2>
<tr>
	<td width='5%' class='td_info td_la'>#</td>
	<td width='17%' class='td_info td_la'><a href='#' class='sortable' data-column='jobposition' data-sorting=''>Job Position <span class='ui-icon'></span></a></td>
	<td width='21%' class='td_info td_la'><a href='#' class='sortable' data-column='companyname' data-sorting=''>Company Name</a></td>
	<td width='12%' class='td_info td_la'><a href='#' class='sortable' data-column='client' data-sorting=''>Client</a></td>
	<td width='12%' class='td_info td_la'><a href='#' class='sortable'  data-column='date' data-sorting=''>Date <span class='ui-icon'></span></a></td>
	<td width='14%' class='td_info td_la'>Outsourcing Model</td>
	<td width='10%' class='td_info td_la'>Status</td>
</tr>";

$query = "SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y') as date,p.outsourcing_model, p.companyname, p.jobposition,p.ads_title,p.sub_category_id,p.status,l.fname,l.lname,p.lead_id
FROM posting p JOIN leads l ON l.id = p.lead_id WHERE p.status='ACTIVE' ORDER BY p.date_created DESC;";
$result = $db->fetchAll($query);
$counter = 0;
foreach ($result as $r) {
    $ads_position = "";
    if ($r['ads_title']) {
        $ads_position = $r['ads_title'];
    } else {
        $ads_position = $r['jobposition'];
    }
    $counter++;
    $output .= "
	<tr>
		<td width='5%' class='td_info td_la'><font size='1'>" . $counter . ") <input type='radio' name='position' value='" . $r['id'] . "' onClick='fillAds(this.value)' /></font></td>
		<td width='17%' class='td_info'><font size='1'><a href='/portal/ads.php?id=" . $r['id'] . "' target='_blank' >" . $ads_position . "</a></font></td>
		<td width='21%' class='td_info'>" . $r['companyname'] . "</td>
		<td width='12%' class='td_info'><b><font size='1'>
			<a href='#'onClick=javascript:popup_win('./../leads_information.php?id=" . $r['lead_id'] . "',800,600);>" . $r['fname'] . "&nbsp;" . $r['lname'] . "</td>
		<td width='12%' class='td_info'>" . $r['date'] . "</td>
		<td width='14%' class='td_info'>" . $r['outsourcing_model'] . "</td>
		<td width='10%' class='td_info'>" . $r['status'] . "</td>
	</tr>";
}
if ($counter == 0) {
    $output .= "<tr><td colspan=7 height=100>This client has no Active or Current Job Advertisement. Create a Job Advertisement for this Client? Click <a href='admin_addadvertisement.php?client_id=$id' class='link10'>here</a> </td></tr>";
}
$output .= "</table>";
//ENDED: generate list of position

$smarty->assign('userid', $userid);
$smarty->assign('output', $output);
$smarty->display('shortlist_staff.tpl');
?>