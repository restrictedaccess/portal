<?php
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}


$keyword=$_REQUEST['keyword'];
$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
# create a MySQL REGEXP for the search: 
$regexp = "REGEXP '^.*($search).*\$'"; 
$keyword_search = " AND (
				UPPER(leads_name) $regexp 
				OR UPPER(leads_email) $regexp 
				OR UPPER(leads_company) $regexp 
				OR UPPER(leads_address) $regexp 
				OR UPPER(invoice_number) $regexp 
				) ";
//id, leads_id, leads_name, leads_email, leads_company, leads_address, description, drafted_by, drafted_by_type, status, invoice_date, draft_date, post_date, paid_date, sub_total, gst, total_amount, invoice_number, currency, gst_flag, ran



if($admin_id!=NULL){
	$drafted_by = $admin_id;
	$drafted_by_type = 'admin';
$query = "SELECT id, leads_name, leads_email, description FROM set_up_fee_invoice WHERE  status = 'draft' $keyword_search ;";
$result=mysql_query($query);
$counter=0;
while(list($id, $leads_name, $leads_email, $description)=mysql_fetch_array($result))
{
	$counter++;
	$draft_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showRightPanelDisplay($id);' >".$counter.") ".$description." ".$leads_name."</div>";
}


$query = "SELECT id, leads_name, leads_email, description FROM set_up_fee_invoice WHERE  status = 'posted' $keyword_search ;";
$result=mysql_query($query);
$counter=0;
while(list($id, $leads_name, $leads_email, $description)=mysql_fetch_array($result))
{
	$counter++;
	$posted_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showRightPanelDisplay($id);' >".$counter.") ".$description." ".$leads_name."</div>";
}

$query = "SELECT id, leads_name, leads_email, description FROM set_up_fee_invoice WHERE  status = 'paid' $keyword_search;";
$result=mysql_query($query);
$counter=0;
while(list($id, $leads_name, $leads_email, $description)=mysql_fetch_array($result))
{
	$counter++;
	$paid_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showRightPanelDisplay($id);' >".$counter.") ".$description." ".$leads_name."</div>";
}

}
if($agent_no!=NULL){
	$drafted_by = $agent_no;
	$drafted_by_type = 'agent';
	

$query = "SELECT id, leads_name, leads_email, description FROM set_up_fee_invoice WHERE drafted_by = $drafted_by AND drafted_by_type = '$drafted_by_type' AND status = 'draft' $keyword_search ;";
$result=mysql_query($query);
$counter=0;
while(list($id, $leads_name, $leads_email, $description)=mysql_fetch_array($result))
{
	$counter++;
	$draft_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showRightPanelDisplay($id);' >".$counter.") ".$description." ".$leads_name."</div>";
}


$query = "SELECT id, leads_name, leads_email, description FROM set_up_fee_invoice WHERE drafted_by = $drafted_by AND drafted_by_type = '$drafted_by_type' AND status = 'posted' $keyword_search ;";
$result=mysql_query($query);
$counter=0;
while(list($id, $leads_name, $leads_email, $description)=mysql_fetch_array($result))
{
	$counter++;
	$posted_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showRightPanelDisplay($id);' >".$counter.") ".$description." ".$leads_name."</div>";
}

$query = "SELECT id, leads_name, leads_email, description FROM set_up_fee_invoice WHERE drafted_by = $drafted_by AND drafted_by_type = '$drafted_by_type' AND status = 'paid' $keyword_search;";
$result=mysql_query($query);
$counter=0;
while(list($id, $leads_name, $leads_email, $description)=mysql_fetch_array($result))
{
	$counter++;
	$paid_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showRightPanelDisplay($id);' >".$counter.") ".$description." ".$leads_name."</div>";
}


}


?>
<div  class="invoice_list_title">Draft</div>
<div class="scroll" >
	<?php echo $draft_data;?>
</div>

<div class="invoice_list_title">Sent Email</div>
<div class="scroll" >
	<?php echo $posted_data;?>
</div>

<div class="invoice_list_title">Paid</div>
<div class="scroll" >
	<?php echo $paid_data;?>
</div>


