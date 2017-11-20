<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="verify-v1" content="LaxjipBphycGX3aaNPJVEJ4TawiiEs/3kDSe15OJ8D8=" />
<title>Remote Staff Service Agreement Online Form</title>
<meta name="description" content="{$meta_desc}" />
<meta name="keywords" content="outsource staff, hire offshore staff, offshore staff, online staff, virtual assistant, IT offshore, offshore outsourcing, outsourcing services, offshore services, remote staff, BPO company, BPO Australia, outsourced staff, offshore labour, offshore hire, offshore labour hire, IT offshore outsourcing, IT offshore staff, labour cost, offshore outsourcing services, outsource offshore, outsource services, IT outsourcing services">
<meta name="ROBOTS" content="NOODP">
<meta name="GOOGLEBOT" content="NOODP"> 
<meta name="title" content="Hire Offshore Staff from Remote Staff | Outsource Staff, Online Staff, Virtual Assistant and IT Offshore Outsourcing Services BPO Company">
<meta name="classification" content="Outsource staff, inexpensive offshore staff, online staff and Virtual assistant working for you at $4 to $8 per hr, and you don't pay for holidays and sick pay. Save up to 70% off your labour cost with our IT Offshore Outsourcing Services we offer">
<meta name="author" content="Remote Staff | Chris J">
<meta name="robots" content="NOYDIR">
<meta name="slurp" content="NOYDIR">
<meta name="robots" content="index all,follow all">
<meta name="revisit-after" content="7 days">
<meta http-equiv="Content-Language" content="en-gb">
<link type="text/css" rel="stylesheet" media="screen" href="/portal/assets/inspinia/css/bootstrap.min.css">
<link rel=stylesheet type=text/css href="./media/css/service_agreement_online_form.css">
<script type="text/javascript" src="./../../js/MochiKit.js"></script>
<script type="text/javascript" src="./media/js/acrobat_detection.js"></script>

<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="/portal/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="/portal/css/gold/gold.css" />

</head>
<body style="margin:0; background:#eeeeee;">
<form name="form" id="online-service-agreement" method="post" action="service_agreement_online_form.php?ran={$ran}">
<div id="sa_holder">
<div style="float:right; color:#CCCCCC; font-size:10px;">SA:{$service_agreement.service_agreement_id}</div>
<table width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
<td valign="top" width="50%" ><img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='289' height='91' /><br />
104 / 529 Old South Head Road, Rose Bay, NSW 2029<br />
USA Phone: +1(415) 376 1472<br />
AUS Phone: +61(2) 8005 0569<br />
UK Phone: +44(020) 3286 9010<br />
</td>
<td valign="top" width="50%" >
<img src='http://remotestaff.com.au/portal/images/think_innovations_logo.png' width='267' height='102' /><br />
Think Innovations Pty. Ltd. ABN 37 094 364 511<br />
Website: www.remotestaff.com.au, www.remotestaff.co.uk, www.remotestaff.biz
</td>
</tr>
<tr>
<td colspan="2">
<p style=" margin-top:10px;">EMAIL : {$creator.name} {$creator.email}</p>
</td>
</tr>

<tr>
<td colspan="2" >
<h3 align="center" style="margin-top:10px;">PRO FORMA REQUEST FOR SERVICE</h3>

<div class="sa_par">
<p>Date : {$service_agreement.date_created|date_format:"%B %e, %Y"}</p>
<p style="text-transform:capitalize">From : {$service_agreement.fname} {$service_agreement.lname}</p>
<p>Company : {$service_agreement.company_name}</p>
<!--
<p>ACN : </p>
<p>ABN : </p>
-->
<p>Address : {$service_agreement.company_address}</p>
<p>Telephone : {$service_agreement.officenumber}</p>
<p>Mobile : {$service_agreement.mobile}</p>
<p>Facsimile : </p>
<p>Email : {$service_agreement.email}</p>
</div>

<div class="sa_par">
<p>TO: Think Innovations- Remote Staff</p>
<p>ABN: 37-094-364-511</p>
<p>Phone nos: (AUS) 1300 733 430 , +61 2 8090 3458 (UK) +44 208 816 7802 (USA) +1 415 376 1472</p>
<p>Facsimile:+61 2 8088 7247</p>
<p>US Fax : (650) 745 1088</p>
<p>Email: contracts@remotestaff.com.au</p>
</div>

<div class="sa_par">
<p>SERVICES:</p>
<p>Recruitment and compliance management of the following staff:</p>
<ol>
{foreach from= $details_str item= d name=d}
<li>{$d}</li>
{/foreach}
</ol>
</div>
<!--
<p><span style="color:#999999; font-size:10px;">{$pdf_path}</span></p>
-->
<p>Service Agreement cannot be viewed? Try this <a href="https://docs.google.com/viewer?url={$pdf_path}">link</a> or try to download the file <a href="{$pdf_path}">here</a></p>
<div id="sa_object">
<object data="{$pdf_path}" type="application/pdf" width="100%" height="700" style="border:#000000 solid 1px; margin-bottom:20px;">
click to download : <a href="{$pdf_path}">Service Contract</a>
</object>
</div>
{if $service_agreement.accepted eq 'no'}
<p align="center"><input type="button" class="btn btn-primary btn-lg" id="accept-btn" name="accept" value="I Accept the Remote Staff Service Agreement and would like to continue with the service" /></p>
{else}
<p align="center">Remote Staff Service Agreement has been acknowledged and accepted {$service_agreement.date_accepted|date_format:"%B %e, %Y %I:%M:%S %p"}</p>
{/if}
{if $service_agreement.date_opened}
<p style="color:#999999;">Last Opended Date : {$service_agreement.date_opened|date_format:"%B %e, %Y %I:%M:%S %p"}</p>
{else}
<p>&nbsp;</p>
{/if}
</td>
</tr>
</table>
</div>


{literal}
<script>
var browser_info = perform_acrobat_detection();
//alert(browser_info.name + " "+browser_info.acrobat + " " + browser_info.acrobat_ver);
if(browser_info.acrobat_ver == null){
    alert("Your browser has no PDF Reader. Please download and install the latest Adobe Acrobat Reader to view the Remote Staff Service Agreement.");
	$('sa_object').innerHTML="Your browser has no PDF Reader. Please download and install the latest Adobe Acrobat Reader to view the Remote Staff Service Agreement.";
}
</script>
{/literal}


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
  	
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Accept Service Agreement</h4>
        </div>
        <div class="modal-body">
        	
			<input type="hidden" name="service_agreement_id" value="{$service_agreement.service_agreement_id}" />

          <p>
          	
          	<strong>Specify Start Date of Staff</strong><br>
          	<div id="btn-cal" class="input-group input-group" style="cursor: pointer;"> <span id="sizing-addon3" class="glyphicon glyphicon-calendar input-group-addon" style="top: 0px !important;"></span> 
          		<input type="text" id="starting_date" name="starting_date" aria-describedby="sizing-addon3" class="form-control"> 
          		</div>
          	
          </p>
          
          <div id="myalert" class="alert alert-danger hide" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Error:</span>
			  Please specify starting date of staff
			</div>
			
							

        </div>
        <div class="modal-footer">
        	<button id="submit-btn" type="submit" class="btn btn-primary" data-loading-text="Submitting..." autocomplete="off">Accept and Submit</button>
          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
    
  </div>



</form>
<script src="/portal/assets/inspinia/js/jquery-2.1.1.js" type="text/javascript"></script>
<script src="/portal/assets/inspinia/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./media/js/accepted-sa.js"></script>
</body>
</html>
