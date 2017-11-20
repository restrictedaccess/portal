<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';


//print( date("g:i a", strtotime("13:30:30")) ); 

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$userid=$_REQUEST['userid'];
$leads_id=$_REQUEST['lid'];
$sid=$_REQUEST['sid'];
$posting_id=$_REQUEST['pid'];

// Get the Subcontractors Basic Information
$query="SELECT  u.fname, u.lname,u.nationality,u.email,u.skype_id,image FROM personal u WHERE u.userid =$userid";
$result=mysql_query($query);
list($fname,$lname,$nationality,$email,$skype,$image) = mysql_fetch_array($result);
//echo $query;



// Get the Subcontractors Clients
$sql="SELECT l.id,l.fname, l.lname ,s.id ,DATE_FORMAT(date_contracted,'%D %b %Y'),client_price, s.starting_hours, s.ending_hours ,s.currency_rate , s.client_timezone , s.client_start_work_hour, s.client_finish_work_hour
	  FROM subcontractors s 
	  LEFT JOIN personal u ON u.userid = s.userid
	  LEFT JOIN leads l ON l.id = s.leads_id 
	  WHERE s.userid = $userid AND s.status = 'ACTIVE' ORDER BY s.id ASC;";
$result = mysql_query($sql);
while(list($lead_id,$l_fname,$l_lname,$subcon_id,$date,$client_price,$starting_hours, $ending_hours, $currency_rate , $timezone , $client_start_hour , $client_finsh_hour )=mysql_fetch_array($result))
{
	 $client_fullname =$l_fname." ".$l_lname;
	 if ($sid==$subcon_id)
	 {
	 	$clientOptions .="<option selected value= ".$subcon_id.">".$client_fullname."</option>";
	 }
	 else
	 {
	 	$clientOptions .="<option value= ".$subcon_id.">".$client_fullname."</option>";
	 }
	 $date = $date ? $date : '&nbsp;';
	
	 
	$staff_working_hours = setConvertTimezones($timezone, 'Asia/Manila' , $client_start_hour, $client_finsh_hour);
	
		
	//echo $starting_hours." - " .$ending_hours;

	$currency_rate ? $currency_rate : '-';
	$clients.="<p onClick='gotoEditContractForm($subcon_id,$lead_id);' onMouseOver='highlight(this)' onMouseOut='unhighlight(this)' >
				<label>".strtoupper($client_fullname)."</label>
				<span style='width:120px; '>".$staff_working_hours."</span>
				<span style='width:120px; margin-left:20px;'>".number_format($client_price,2,'.',',')." ".$currency_rate."</span>
				</p>";	
	
			
}
	  
	  


?>
<html>
<head>
<title>Sub-Contractors Details</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<script type="text/javascript" src="js/payment.js"></script>
<link rel=stylesheet type=text/css href="css/payment.css">

<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="">
<form name='form' action='editcontractphp.php' method='post' >
<input type='hidden' name='userid' id='userid' value="<? echo $userid;?>">

<script language=javascript src="js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'adminleftnav.php';?></td>
<td width=100% valign=top >
	<table width="100%" border="1" cellpadding="5" cellspacing="1">
      <tr>
        <td width="49%" valign="top"><div style="border:#333333 solid 1px; ">
            <div class="picture_box" ><img src='<? echo $image;?>' width='155' height='160' /></div>
          <div class="subcon_details2">
              <div class="subcon_name">
			  <a href='#'   class='link5' onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);">
			  <? echo $fname." ".$lname;?>
			  </a>
			  </div>
            <div class ="subcon_email"><? echo $email;?></div>
            <div class ="subcon_skype">Skype : <? echo $skype;?></div>
          </div>
          <div style="clear:both;"></div>
        </div>
            <div style="padding:5px; background:#CCCCCC; border:#666666 outset 1px; margin-top:20px;"><b>Remote Staff Working History</b></div>
			<div id="contract_details" >
			<div style="padding:5px; margin-bottom:5px; font-weight:bold; border-bottom:#CCCCCC dashed 1px;">
			Previously Worked for
			</div>
		<?
		//Check the subcontractors remotestaff work history if there's any....
		$query="SELECT CONCAT(l.fname,' ',l.lname) ,CONCAT(a.fname,' ',a.lname),a.work_status , s.status , DATE_FORMAT(s.starting_date,'%D %b %Y') , DATE_FORMAT(resignation_date,'%D %b %Y'), client_price , 
				php_monthly , starting_hours, ending_hours
				FROM subcontractors s
				LEFT JOIN leads l ON l.id = s.leads_id
				LEFT JOIN agent a ON a.agent_no = s.agent_id
				WHERE s.userid = $userid
				AND s.status !='ACTIVE';";
		//echo $query;		
		$result = mysql_query($query);
		$counter=0;
		while(list($client,$agent,$work_status, $status, $starting_date , $resignation_date, $client_price , $php_monthly , $starting_date, $resignation_date)=mysql_fetch_array($result))
		{
			$counter++;
			$client_price ? $client_price : '0';
			$php_monthly ? $php_monthly : '0';
		?>	
		<p><b><?=$counter;?>)</b></p>
		<div style="margin-left:20px;">
			<p><label>Client : </label><?=strtoupper($client);?></p>
			<p><label>Client Price : </label>$ <?=number_format($client_price,2,'.',',');?></p>
			<p><label>Monthly Peso : </label>P <?=number_format($php_monthly,2,'.',',');?></p>
			<p><label>Date Duration : </label><?=$starting_date." - ".$resignation_date;?></p>
		</div>	
		<? } ?>	
		</div>
         </td>
        <td width="51%" valign="top">
		
		
              <div style="padding:5px; background:#CCCCCC; border:#666666 outset 1px; "><b>Currently Sub-Contracted to the following Client(s) :</b></div> <div  id="work_history">
            <?=$clients;?>
			
          </div>
		</td>
      </tr>
    </table></td>
</tr>
</table>

<? include 'footer.php';?>
</form>
</body>
</html>
