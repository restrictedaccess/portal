{*
<!--version 0.0.1 -->
2010-04-07  Roy Pepito <roy.pepito@remotestaff.com.au>
*}
<!--version 0.0.2: Changelogs - Author: Marlon Peralta
	- Remove Delete Functionality	
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Recruiter View</title>
 
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">
<link rel="stylesheet" type="text/css" href="css/recruiter_search.css"/>
<script type="text/javascript" src="category/category.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="../js/jquery.js"></script>
<script language=javascript src="../js/functions.js"></script>
<script language=javascript src="js/recruiter_search.js"></script>


<style type="text/css">
{literal}
.main{
	width: 90%;
	margin: 20px auto 0 auto;
	background: white;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
	padding: 30px;
	border: 1px solid #adaa9f;
	-moz-box-shadow: 0 2px 2px #9c9c9c;
	-webkit-box-shadow: 0 2px 2px #9c9c9c;
}

/*Features table------------------------------------------------------------*/

.features-table{
  width: 100%;
  margin: 0 auto;
  border-collapse: separate;
  border-spacing: 0;
  text-shadow: 0 1px 0 #fff;
  color: #2a2a2a;
  background: #fafafa;  
  background-image: -moz-linear-gradient(top, #fff, #eaeaea, #fff); /* Firefox 3.6 */
  background-image: -webkit-gradient(linear,center bottom,center top,from(#fff),color-stop(0.5, #eaeaea),to(#fff)); 
}

.features-table td{
  line-height: 50px;
  padding: 10 20px;
  border-bottom: 1px solid #cdcdcd;
  box-shadow: 0 1px 0 white;
  -moz-box-shadow: 0 1px 0 white;
  -webkit-box-shadow: 0 1px 0 white;
  text-left: center;
  vertical-align:top;
}

/*Body*/

.features-table tbody td{
  text-align: left;
  font: normal 12px Verdana, Arial, Helvetica;
  width: 25%px;
}

.features-table tbody td:first-child{
  width: auto;
  text-align: left;
}

.features-table td:nth-child(2), .features-table td:nth-child(3), .features-table td:nth-child(4){
  background: #efefef;
  background: rgba(144,144,144,0.15);
  border-right: 1px solid white;
}

.features-table td:nth-child(5){ 
  background: #e7f3d4;  
  background: rgba(184,243,85,0.3);
}

/*Header*/

.features-table thead td{
  font: bold 1.3em 'trebuchet MS', 'Lucida Sans', Arial;  
  -moz-border-radius-topright: 10px;
  -moz-border-radius-topleft: 10px; 
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  border-top: 1px solid #eaeaea; 
}

.features-table thead td:first-child{
  border-top: none;
}

/*Footer*/

.features-table tfoot td{
  font: bold 1.4em Georgia;  
  -moz-border-radius-bottomright: 10px;
  -moz-border-radius-bottomleft: 10px; 
  border-bottom-right-radius: 10px;
  border-bottom-left-radius: 10px;
  border-bottom: 1px solid #dadada;
}

.features-table tfoot td:first-child{
  border-bottom: none;
}
.fadePage{display:none;z-index:98;position:fixed;height:100%;width:100%;background:#000000;opacity:.6;filter:alpha(opacity=60);margin:0px;padding:0px;top:0;left:0;} 
.login_container{margin:auto;z-index:99;display:none;margin:auto;top:30%;left:35%;position:fixed;}
.sprite-closebutton{background:url(images/sprite2.png) no-repeat top left;background-position:0 0;width:26px;height:26px;float:right;}
.login_popup{width:350px;height:225px;overflow:hidden;position:absolute;left:23px;top:30px;} 
.login{background:url('images/popupbg.png');width:400px;height:290px;}
.formNotes{font-style:italic;font-size:10px;}
.buttonLeft{background:url(images/sprite4.png) no-repeat left;background-position:0 -63px;width:8px;height:28px;float:left;margin-top:1px;}
.buttonRight{background:url(images/sprite4.png) no-repeat left;background-position:0 -92px;width:8px;height:28px;float:left;margin-top:1px;}
.buttonContent{float:left;background:url(images/button.png) repeat-x;text-align:center;margin-top:1px;font-weight:bold;padding-top:8px;width:90px;height:28px;color:#ffffff;cursor:pointer;}
{/literal}
</style>
<!-- datepicker -->
<link rel="stylesheet" type="text/css" media="all" href="/portal/date_picker/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="/portal/date_picker/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	{literal}
	window.onload = function(){
		g_globalObject = new JsDatePick({
			useMode:2,
			target:"updated_date_start",
			dateFormat:"%Y-%m-%d"
		});

		g_globalObject2 = new JsDatePick({
			useMode:2,
			target:"updated_date_end",
			dateFormat:"%Y-%m-%d"
		});
		g_globalObject3 = new JsDatePick({
			useMode:2,
			target:"date_start",
			dateFormat:"%Y-%m-%d"
		});

		g_globalObject4 = new JsDatePick({
			useMode:2,
			target:"date_end",
			dateFormat:"%Y-%m-%d" 
		});	
		
		var g_globalObject6 = new JsDatePick({
			useMode:2,
			target:"available_date",
			dateFormat:"%Y-%m-%d" 
		});	
		
		
		g_globalObject9 = new JsDatePick({
			useMode:2,
			target:"date_last_login_start",
			dateFormat:"%Y-%m-%d" 
		});	
		
		g_globalObject10 = new JsDatePick({
			useMode:2,
			target:"date_last_login_end",
			dateFormat:"%Y-%m-%d" 
		});
		
		//Injected by Josef Balisalisa START
		try{
			g_globalObject5 = new JsDatePick({
				useMode:2,
				target:"date_progress_start",
				dateFormat:"%Y-%m-%d" 
			});
			
		}catch(err){
			console.log(err);
		}
		
		
		try{
			g_globalObject5 = new JsDatePick({
				useMode:2,
				target:"date_progress_end",
				dateFormat:"%Y-%m-%d" 
			});	
			
		}catch(err){
			console.log(err);
		}
		
		
		try{
			g_globalObject5 = new JsDatePick({
				useMode:2,
				target:"date_progress_tagged_start",
				dateFormat:"%Y-%m-%d" 
			});
			
		}catch(err){
			console.log(err);
		}
		
		
		try{
			g_globalObject5 = new JsDatePick({
				useMode:2,
				target:"date_progress_tagged_end",
				dateFormat:"%Y-%m-%d" 
			});
		}catch(err){
			console.log(err);
		}
		
		
		//Injected by Josef Balisalisa END
		
	};
	{/literal}
</script>
<!-- end date picker -->

<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="js/staff.js"></script>
</head>
 
<body style="margin-top:0; margin-left:0">

<div id="main" class="fadePage">&nbsp;</div>

<div id="popup" class="login_container">
<div  class="login" >
	<div class="sprite-closebutton" onclick="hidepopup('popup')" ></div>
	<div id="login_popup" class="login_popup">
		<div id="uploadPicture" >
			<form enctype="multipart/form-data" name="change_recruiter" method="post" >
				<div style="margin:0 auto;font:Arial 14px;font-weight:bold;width:300px;margin-top:50px;text-align:center;"> 
				<input type="hidden" name="assign_recruiter_userid" value="" id="assign_recruiter_userid">
				Please select a recruiter to assign staff:<br/><br/> 
				<select name="assign_recruiter" id="assign_recruiter" >{$recruiter_options_no_former}</select><br/><br/>
				<input type="button" value="Submit" onclick="assignRecruiter()">
				
				</div>
			</form>
		</div>
	</div>
</div>
</div>

{php} include("header.php") {/php}
{php} include("recruiter_top_menu.php") {/php}

<!--START: left nav.-->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  >
	<tr>
        <td valign="top" style="border-right: #006699 2px solid;">
            <div id='applicationsleftnav'>
                <table>
                    <tr>
                        <td background="images/open_left_menu_bg.gif">
                            <a href="javascript: applicationsleftnav_show(); "><img src="images/open_left_menu.gif" border="0" /></a>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td valign="top" width="100%">
<!--ENDED: left nav.-->

            
<!--START: sub title-->
<h1 align="left">&nbsp;&nbsp;Recruiter View {if $staff_status neq ''} <span class="leads_id">{ $staff_status }</span> {/if}</h1>
<!--ENDED: sub title-->            
            

<!--START: search function-->
<div class="main" style="background: #DCEEBE; width:80%;">
<form method="get" id="search-form">
<input type='hidden' name='page' id='page' value='{$page}'/>
<input type='hidden' name='result_per_page' id='result_per_page' value='{$result_per_page}'/>
<input type='hidden' id='searched' name='searched' value='0'/>
<input type='hidden' id='staff_status' name='staff_status' value='{$staff_status}'/>
<table border="0" style="margin:0 auto;">
<tr>
	<td colspan="2">
		<span style="font-weight:bold;font-size:16px;">Advanced Search:</span>
	</td>
</tr>
<tr>
	<td style="width:600px;" >
		<br/>Positions advertized: <br/>
		<select name="posting" id="posting" style="width:500px;">{$positions_advertized_options}</select>
	</td>
	<td >
		<br/>Country: <br/>
		<select name="country" id="country" >{$country_options}</select>
	</td>
</tr>
<tr>
	<td style="width:400px;" >
		Date Registered:<br/>
		From <input type="text" name="date_start" id="date_start" value="{$date_start}">
		To <input type="text" name="date_end" id="date_end" value="{$date_end}">
	</td>
	<td style="width:400px;">
		Date Updated:<br/>
		From <input type="text" name="updated_date_start" id="updated_date_start" value="{$updated_date_start}">
		To <input type="text" name="updated_date_end" id="updated_date_end" value="{$updated_date_end}">
	</td>
</tr>
<tr>
	<td style="width:400px;" >
		Date Last Login:<br/>
		From <input type="text" name="date_last_login_start" id="date_last_login_start" value="{$get.date_last_login_start}">
		To <input type="text" name="date_last_login_end" id="date_last_login_end" value="{$get.date_last_login_end}">
	</td>
	{* Injected by josef Balisalisa START *}
	{if $staff_status ne "UNPROCESSED" and $staff_status ne "REMOTEREADY"}
		<td style="width:400px;" >
			{if $staff_status eq "PRESCREENED"}
				Pre-screened Date:<br/>
			{elseif $staff_status eq "SHORTLISTED"}
				Shortlisted Date:<br/>
			{elseif $staff_status eq "ENDORSED"}
				Endorsed Date:<br/>
			{elseif $staff_status eq "INACTIVE"}
				Inactive Date:<br/>
			{/if}
			From <input type="text" name="date_progress_start" id="date_progress_start" value="{$get.date_progress_start}">
			To <input type="text" name="date_progress_end" id="date_progress_end" value="{$get.date_progress_end}">
		</td>
	{else}
		<td style="width:400px;" >
			Date Tagged:<br/>
			From <input type="text" name="date_progress_tagged_start" id="date_progress_tagged_start" value="{$get.date_progress_tagged_start}">
			To <input type="text" name="date_progress_tagged_end" id="date_progress_tagged_end" value="{$get.date_progress_tagged_end}">
		</td>
	{/if}
	{* Injected by josef Balisalisa END *}
</tr>

<tr>
	<td>
		Recruiter: <select name="recruiter" id="recruiter" >{$recruiters_option}</select>
		Recruitment Team: <select name="recruiter_team" id="recruiter_team" >{$recruitment_team_options}</select>
	</td>
	<td>
		Keyword:<br/>
		<input type="text" name="keyword" id="keyword" value="{$get.keyword}">
		<select name="keyword_type" id="keyword_type">
			<option value="id" {if $get.keyword_type eq 'id'}selected{/if}>ID</option>
			<option value="first_name" {if $get.keyword_type eq 'first_name'}selected{/if}>First Name</option>
			<option value="last_name"  {if $get.keyword_type eq 'last_name'}selected{/if}>Last Name</option>
			<option value="email" {if $get.keyword_type eq 'email'}selected{/if}>Email</option>
			<option value="mobile" {if $get.keyword_type eq 'mobile'}selected{/if}>Mobile No.</option>
			<option value="evaluation_notes" {if $get.keyword_type eq 'evaluation_notes'}selected{/if}>Evaluation Notes</option>
			<option value="skills" {if $get.keyword_type eq 'skills'}selected{/if}>Skills</option>
			<option value="notes" {if $get.keyword_type eq 'notes'}selected{/if}>Notes</option>
			<option value="resume_body" {if $get.keyword_type eq 'resume_body'}selected{/if}>Resume body</option>
		</select>
	</td>
</tr>
<tr>
	<td style="width:400px">
		Availability:<br/>
		<div class="availability">
			<dl>
				<dt>
					<input type="radio" name="available_status" value="a" {$a_selected}/>
				</dt>
				<dd>
					Can work <select name="available_notice">{$available_notice_options}</select> week(s) of notice period
				</dd>
				<dt>
					<input type="radio" name="available_status" value="b" {$b_selected}/>
				</dt>
				<dd>
					Can work after <input type="text" name="available_date" id="available_date"  value="{$get.available_date}"/>
				</dd>
				<dt>
					<input type="radio" name="available_status" value="p" {$p_selected}/>
				</dt>
				<dd>
					Currently Inactive in Looking for Work
				</dd>
				<dt>
					<input type="radio" name="available_status" value="Work Immediately" {$w_selected}/>
				</dt>
				<dd>
					Work Immediately
				</dd>
			</dl>
			
		</div>	
		
	</td>
	{if $staff_status eq "INACTIVE"}
		<td>
			City:<br/>
			<input type="text" name="selected_city" value="{$selected_city}"/><br/>
			Region:<br/>
			<select name="selected_region">
				{$ph_state_options}
			</select><br/>
			Inactive:<br/>
			<select name="inactive" id="inactive-select">
				<option value="">ALL</option>
				{$inactiveSelect}
			</select>
		</td>
	{else}
		<td>
			City:<br/>
			<input type="text" name="selected_city" value="{$selected_city}"/><br/>
			Region:<br/>
			<select name="selected_region">
				{$ph_state_options}
			</select><br/>
		</td>
	{/if}
</tr>



<tr>
	<td>
		<input type="submit" value="search"  style="float:left;margin-right:1em;"/>&nbsp;
			<span id="mass_email_option" style="float:left;width:500px;">
				<div style="display:inline-block;"><input type="checkbox" name="mass_email" class="mass_email"/>Apply Result to Mass Emailing list</div>
			</span>
	</td>
	<td>
		{if $staff_status eq '' || $staff_status eq 'ALL'}
			
			<table border=0>
				<tr>
					<td>
						<a href="/portal/recruiter/exportcsv.php?export{$params}" class='export'>Export</a>
					</td>
	
					<td>
						<input type="radio" value="limitby" name="limitby" id="limitby" checked="checked"/>Limit By: <input type="text" value="{$limitedTotal}" name="limit" id="limit" size="6" maxlength="6"> 
					</td>
		 			<td>
						<input type="radio" value="all" name="limitby" id="all"/>All 
					</td>
					<td>
						&nbsp;Sorted by:
						<select name="order_by_export">
							<option value="DESC">Descending</option>
							<option value="ASC">Ascending</option>
						</select>					
					</td>
					
				</tr>
			</table>
			
		{/if}
		{if $staff_status eq 'CATEGORIZED'}
			ASL Displayed: 
			<select name="display">
				<option value="">All</option>
				{if $get.display eq "0"}
					<option value="0" selected>Yes</option>
					<option value="1">No</option>
				{/if}
				{if $get.display eq "1"}
				
					<option value="0">Yes</option>
					<option value="1" selected>No</option>
				{/if}
				{if $get.display eq ""}
					<option value="0">Yes</option>
					<option value="1">No</option>
				{/if}
			</select>		
		{/if}
		{if $staff_status eq 'UNPROCESSED'}
			<label>
				<input type="checkbox" name="remove_remote_ready" {if $remote_ready_checked=='on'}checked{/if}/> Remove Remote Ready	
			</label>
			<label>
				<input type="checkbox" name="over_30" {if $over_30=='on'}checked{/if}/> Over 30 days
			</label>
		{/if}
		
		
		
	</td>
</tr>
</table>

</div>
<!--ENDED: search function-->            
<div width="80%" class="main">
<div class="hiresteps">
<table width="100%">
	<tr>
		<td><strong>Custom Booking</strong></td>
		<td align="right"><a href="#" class='book-interview'>Click to Book Interview Now</a></td>
	</tr>
</table>
</div>
<div id="listings"><table width="100%" cellpadding="3" cellspacing="3">{ $return_output }</table></div>
</div>     
{if $staff_status eq 'SHORTLISTED' || $staff_status eq 'ENDORSED' ||  $staff_status eq 'PRESCREENED' || $staff_status eq 'CATEGORIZED' || $staff_status eq '' || $staff_status eq 'ALL'}
<div width="80%" class="main">
<div class="hiresteps">
	<table width="100%">
		<tr>
			<td><strong>Endorsed to Client</strong></td>
			<td align="right"><a href="#" class='endorse-client-link'>Click to Endorsed Now</a></td>
		</tr>
	</table>
</div>

<div id="endorse-listings"><table width="100%" cellpadding="3" cellspacing="3"></table></div>
</div>        
{/if}

<!--START: listings-->
    <div id="listings-main" class="main">
		{if $total gt 0}		
		<div align="right" style="padding-bottom:10px;"> 
			<span style="float:left;">{$pagination_sliding}&nbsp;&nbsp;<div class='pageresult' style='display:inline-block'>{$pageStart+1} - {$pageEnd} of {$total}</div></span>
			Results per page:
			<select class='result_per_pager'>
				{$result_per_page_option}
			</select>&nbsp;&nbsp; 
			Select Page:
			<select class='pager'>
				{$pagination}
			</select>
			
		</div> 
		<table class="features-table" cellpadding="15">
			<thead>
				<tr>
					<td>&nbsp;</td>
					<td style="text-align:center">Skills</td>
					<td style="text-align:center">
					{if $staff_status eq "SHORTLISTED"}
						Date Shortlisted
					{else}
						Date Registered
					{/if}
					
					</td>
					<td style="text-align:center">Book</td>
					{if $staff_status eq 'SHORTLISTED' || $staff_status eq 'ENDORSED' ||  $staff_status eq 'PRESCREENED' || $staff_status eq 'CATEGORIZED' || $staff_status eq '' || $staff_status eq 'ALL'}
						<td style="text-align:center;background: #efefef;background: rgba(144,144,144,0.15);border-right: 1px solid white;">Endorse</td>
						<td style="text-align:center;background: #e7f3d4;background: rgba(184,243,85,0.3);">Action</td>
					{else}
						<td style="text-align:center">Action</td>
					{/if}	
				</tr>
			</thead>				
			<tbody> 
				{foreach from=$result item=applicant key=userid} 
				<tr>
					<td width="25%" valign="top">
						<span style="font-weight:bold;cursor:pointer;color:#1831EA;" onclick="window.open('/portal/recruiter/staff_information.php?userid={$applicant.userid}&page_type=popup','Staff Information {$applicant.userid}',
'menubar=no,width=1000,height=500,toolbar=no,scrollbars=yes')">
						#{$applicant.userid} {$applicant.fname} {$applicant.lname}</span>
						{if $applicant.hot}
						<img src="images/hot.png" >
						{/if}
						{if $applicant.exp}
						<img src="images/experienced.png" >
						{/if}
						<br>	
						Job Title:{$applicant.latest_job_title}<br>							
						Email:{$applicant.email}<br>				
						Recruiter:<span style="color:red">{$applicant.admin_fname} {$applicant.admin_lname}</span><br>		
						Skype ID:{$applicant.skype_id}<br>		
						{if $staff_status eq "ALL" || $staff_status eq ""}
							{if $applicant.status eq "Inactive"}
								Status:<span style="color:red;font-weight: bolder">{$applicant.status}</span><br>
							{else}
								Status:<span style="color:blue">{$applicant.status}</span><br>
							{/if}
						
						{/if}
						{if $staff_status eq "ENDORSED"}
						Date Endorsed:{$applicant.date_endorse}<br>
						{/if}
						{if $staff_status eq "SHORTLISTED"}
						Date Registered:{$applicant.datecreated}<br>
						{/if}
						{if $staff_status eq "INACTIVE"}
						Inactive:{$applicant.inactive_type}<br>
						{/if}
						
							
						{if $applicant.voice_path neq ''}					 	
						<object type="application/x-shockwave-flash" wmode="transparent" data="../../audio_player/player_mp3_maxi.swf" width="128" height="18">
							<param name="movie" value="../../audio_player/player_mp3_maxi.swf" />
							<param name="FlashVars" value="mp3=../{$applicant.voice_path}" />
						</object>
						{/if}
					</td>
					<td width="43%" valign="top" >
						{foreach from=$applicant.skills item=skill}
							{$skill},
						{/foreach} 
						&nbsp;
					</td>
					<td width="15%" valign="top" style="text-align:center">
						{if $staff_status eq "SHORTLISTED"}
							{$applicant.date_listed}
						{else}
							{$applicant.datecreated}
						{/if}
					</td>
					<td width="5%" style="text-align:center">
						<input id="app_id{$applicant.userid}" type="checkbox" onchange="javascript: order({$applicant.userid});" >
					</td>	
					{if $staff_status eq 'SHORTLISTED' || $staff_status eq 'ENDORSED' || $staff_status eq 'PRESCREENED' || $staff_status eq 'CATEGORIZED' || $staff_status eq '' || $staff_status eq 'ALL'}
						{if $add_endorse == ''}
							<td width="5%" style="text-align:center;background: #efefef;background: rgba(144,144,144,0.15);border-right: 1px solid white;">
								<input id="endorse_{$applicant.userid}" type="checkbox" class="endorse_checkbox"/>
							</td>
						{else}
							<td width="5%" style="text-align:center;background: #efefef;background: rgba(144,144,144,0.15);border-right: 1px solid white;">
								<input id="endorse_{$applicant.userid}" type="checkbox" class="endorse_checkbox add_endorse"/>
							</td>
						{/if}
					
						<td width="12%" style="text-align:center; background: #e7f3d4; background: rgba(184,243,85,0.3);">
							<img style="height:25px;width:25px;cursor:pointer;" src="/portal/recruiter/images/view.png" title="view" onclick="window.open('/portal/recruiter/staff_information.php?userid={$applicant.userid}&page_type=popup','Staff Information {$applicant.userid}',
	'menubar=no,width=1000,height=500,toolbar=no,scrollbars=yes')">
	<img style="height:25px;width:25px;cursor:pointer;" src="/portal/recruiter/images/change.png" title="change/assign recruiter" onclick="assignRecruiterPopup({$applicant.userid});" >
							<!-- {if $staff_status eq 'SHORTLISTED'}
								{if $admin_id eq '257' || $admin_id eq '256'}
								<img style="height:25px;width:25px;cursor:pointer;" src="/portal/recruiter/images/delete.png" title="" class="" data-userid="{$applicant.userid}">
								<input type='hidden' name='special_id' value='{$applicant.special_id}' class='special_id'>
								{else}
								<img style="height:25px;width:25px;cursor:pointer;visibility: hidden;" src="/portal/recruiter/images/delete.png" title="" class="" data-userid="{$applicant.userid}">
								<input type='hidden' name='special_id' value='{$applicant.special_id}' class='special_id'>
								{/if}
							{/if}
							{if $staff_status eq 'ALL'}
								{if $admin_id eq '257' || $admin_id eq '256'}
									<img style="height:25px;width:25px;cursor:pointer;" src="/portal/recruiter/images/delete.png" title="" onclick="confirmDeleteStaffFromList({$applicant.userid})">
									{else}
									<img style="height:25px;width:25px;cursor:pointer;visibility: hidden;" src="/portal/recruiter/images/delete.png" title="" onclick="confirmDeleteStaffFromList({$applicant.userid})">
									{/if}
							{/if}
							{if $staff_status eq 'UNPROCESSED'}
							
							{/if} -->
						</td>	
					{else}
						<td width="12%" style="text-align:center; ">
							<img style="height:25px;width:25px;cursor:pointer;" src="/portal/recruiter/images/view.png" title="view" onclick="window.open('/portal/recruiter/staff_information.php?userid={$applicant.userid}&page_type=popup','Staff Information {$applicant.userid}',
	'menubar=no,width=1000,height=500,toolbar=no,scrollbars=yes')">
							<!-- {if $staff_status eq 'SHORTLISTED'}
								<img style="height:25px;width:25px;cursor:pointer;" src="/portal/recruiter/images/delete.png" title="delete" class="delete"  data-userid="{$applicant.userid}">
								<input type='hidden' name='special_id' value='{$applicant.special_id}' class='special_id'>
							{elseif $staff_status eq 'ALL'}
								<img style="height:25px;width:25px;cursor:pointer;" src="/portal/recruiter/images/delete.png" title="delete" onclick="confirmDeleteStaffFromList({$applicant.userid})">
							{/if} -->
							<img style="height:25px;width:25px;cursor:pointer;" src="/portal/recruiter/images/change.png" title="change/assign recruiter" onclick="assignRecruiterPopup({$applicant.userid});" >
						</td>	
					{/if}	
					
				</tr>
				{/foreach}
			</tbody>
		</table>
		<div align="right" style="padding-top:10px;"> 
			<span style="float:left;">{$pagination_sliding}&nbsp;&nbsp;<div class='pageresult' style='display:inline-block'>{$pageStart+1} - {$pageEnd} of {$total}</div></span>
			Results per page:
			<select class="result_per_pager">
				{$result_per_page_option}
			</select>&nbsp;&nbsp; 
			Select Page:
			<select class="pager">
				{$pagination}
			</select>
			
		</div> 
		{else}
			<div align="center" style="padding-top:10px;">
				<span align="center" style="font-weight:bold;font-size: 16px;">Sorry, No results found</span>
			</div>
		{/if}
	</div>

<!--ENDED: listings-->


</td>
</tr>
</table>
</form>
{php} include("footer.php") {/php}

<!--START: assign recruiter -->
<DIV ID='staff_recruiter_stamp_div' STYLE='POSITION: Absolute; LEFT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table bgcolor="#FFFFCC" cellpadding="4" cellspacing="4" width="100%">
<tr>
	<td><b>Replace&nbsp;or&nbsp;assign&nbsp;new&nbsp;recruiter</b></td>
	<td>
		<select id="staff_recruiter_stamp_assign" style="font:11px tahoma;">
			{ $search_recruiter_assign_options }
		</select>
	</td>
	<td><input type="submit" name="registered_advance_search" onclick="javascript: staff_recruiter_stamp_update(); " style="font:11px tahoma;" value="Assign Recruiter"></td>
	<td width="100%" align="right"><a href="javascript: close_popup(); "><img src="../images/closelabel.gif" border="0" /></a></td>
</tr>
</table>
</DIV>
<!--ENDED: assign recruiter -->

<!--START: asl alarm-->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!--ENDED: asl alarm-->

<!--START: delete staff -->
<DIV ID='delete_staff_div' STYLE='POSITION: Absolute; LEFT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table bgcolor="#FFFFCC" cellpadding="4" cellspacing="4" width="100%">
<tr>
	<td><img src="../images/delete.png" /></td>
	<td><font color="#FF0000"><b>You&nbsp;are&nbsp;about&nbsp;to&nbsp;<strong>REMOVE</strong>&nbsp;this&nbsp;staff&nbsp;from&nbsp;the&nbsp;list. Click <strong>REMOVE</strong> to continue.</b></font></td>
	<td><input type="submit" name="registered_advance_search" onclick="javascript: execute_delete_staff(); " style="font:11px tahoma;" value="Remove"></td>
	<td width="100%" align="right"><a href="javascript: close_popup(); "><img src="../images/closelabel.gif" border="0" /></a></td>
</tr>
</table>
</DIV>
<!--ENDED: delete staff -->


<!--START: left nav. container -->
<DIV ID='applicationsleftnav_container' STYLE='POSITION: Absolute; RIGHT: 50px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
<table width="100%">
	<tr>
		<td align="right" background="images/close_left_menu_bg.gif">
        	<a href="javascript: applicationsleftnav_hide(); "><img src="images/close_left_menu.gif" border="0" /></a>
		</td>
	</tr>
</table>

{php} include("applicationsleftnav.php") {/php}

</DIV>
<!--ENDED: left nav. container -->

</body>
</html>
