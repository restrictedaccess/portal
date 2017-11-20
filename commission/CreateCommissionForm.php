<?php
include '../conf/zend_smarty_conf.php';
$leads_id = $_SESSION['client_id'];
if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}

$query="SELECT lname, fname,DATE_FORMAT(timestamp,'%D %b %Y'),email,mobile,officenumber FROM leads WHERE id = $leads_id";
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];

if(LOCATION_ID == 2){
    $contact_email = 'clientsupport@remotestaff.co.uk';
}else if(LOCATION_ID == 3){
    $contact_email = 'clientsupport@remotestaff.biz';
}else{
    $contact_email = 'clientsupport@remotestaff.com.au';
}


?>
<p><label>Commission Title : </label><input type="text" id="commission_title" name="commission_title" class="select" value="" /></p>
<p><label>Commission Amount  : </label><input type="text" id="commission_amount" name="commission_amount" class="select" value="" style="width:100px;" onkeyup="doCheck(this.value)" /><span style="color:#666666; margin-left:10px;">Valid Numbers Only</span></p>
<p><label>Commission Description :</label><textarea id="commission_desc" name="commission_desc" class="select" rows="5" style="width:400px;"></textarea></p>
<p><input type="button" value="Create" onclick="javascript:CreateCommission();" /><input type="button" value="Cancel" /></p>

<p>Dear <?=$name;?>,</p>
<p>
Giving a commission to your staff member for business generated is a good way to reward 
and motivate them to do better. This will be a win-win situation between you and your staff member that will lead
to a longer and healthier work relationship. 
</p>

<p>Please remember: </p>
<ol>
<li> When creating or adding a new commission, please be detailed with your commission scheme and make sure that 
your staff member is already aware of this and this scheme is already agreed on. 
</li>

<li>Once commission is made and approved, you will receive an invoice from Think Innovations/RemoteStaff together with your current monthly invoice. </li>

<li>Commission is paid at the end of the month following the month it is created and approved to the staff member. If commission is made June, the pay is made to the staff member end of July using the applicable market exchange rate.</li>
</ol>

<p>Should you have any questions, please don't hesitate to contact <?php echo $contact_email;?>  </p>

