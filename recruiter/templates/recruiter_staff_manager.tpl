{*
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
2010-04-07  Roy Pepito <roy.pepito@remotestaff.com.au>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Recruiter Home { $recruiter_full_name }</title>

<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">

<script language=javascript src="../js/jquery.js"></script>
<script type="text/javascript" src="js/recruiter_staff_manager.js"></script>

<!--calendar picker - setup-->
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<!-- datepicker -->
<link rel="stylesheet" type="text/css" media="all" href="/portal/date_picker/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="/portal/date_picker/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	{literal}
	window.onload = function(){
		g_globalObject = new JsDatePick({
			useMode:2,
			target:"date_start",
			dateFormat:"%Y-%m-%d"
		});

		g_globalObject2 = new JsDatePick({
			useMode:2,
			target:"date_end",
			dateFormat:"%Y-%m-%d"
		});	
		g_globalObject3 = new JsDatePick({
			useMode:2,
			target:"date_updated_start",
			dateFormat:"%Y-%m-%d"
		});

		g_globalObject4 = new JsDatePick({
			useMode:2,
			target:"date_updated_end",
			dateFormat:"%Y-%m-%d"
		});	
		
		
		g_globalObject5 = new JsDatePick({
			useMode:2,
			target:"available_date",
			dateFormat:"%Y-%m-%d" 
		});	
		
		
		g_globalObject6 = new JsDatePick({
			useMode:2,
			target:"date_registered_start",
			dateFormat:"%Y-%m-%d"
		});

		g_globalObject7 = new JsDatePick({
			useMode:2,
			target:"date_registered_end",
			dateFormat:"%Y-%m-%d"
		});	
		
		
	};
	{/literal}
</script>
<!-- end date picker -->

<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script language=javascript src="js/staff_public_functions.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>
<style type="text/css">
{literal}
	.availability dl dd, .availability dl dt{
		float:left;
	}
	.availability dl dt{
		clear:both;
	}
	.availability dl dd{
		margin-left:5px;
		margin-bottom:5px;
	}
{/literal}
</style>

<script type="text/css">
{literal}
table{
}
tr{
}
td{
	vertical-align:top;
	padding:3px 5px;
}

{/literal}
</script>
</head>
<body style="margin-top:0; margin-left:0">

{php}include("header.php"){/php}
{php}include("recruiter_top_menu.php"){/php}

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
        
           
            <!--START: sub title-->
            <h1 align="left">&nbsp;Recruiter Staff Manager</h1>
            <!--ENDED: sub title-->            
            
			<!-- filter start-->
			<div style="margin:20px;height:350px">
			<img src="/portal/recruiter/images/export_to_csv.png" style="float:right" id="recruiter_export">
			<b>SEARCH FILTERS:</b><br/><br/>
			<form name="appplicant_filter" id="appplicant_filter" method="get">
				
				<div style="float:left;height:100%">
					Recruiter: <select name="recruiter" id="recruiter" >{$recruiters_option}</select><br/><br/>
					Job-Position: <select name="subcategory" id="subcategory" >{$subcategories_option}</select><br/><br/>
					On ASL: <select name="on_asl" id="on_asl" >{$on_asl_option}</select><br/><br/>
					Advertised Rate:  <select name="adv_rate" id="adv_rate" >{$adv_rate_option}</select><br/><br/>
					Work Status:  <select name="work_availability" id="work_availability" ><option value=""></option>{$work_availability_options}</select><br/><br/>
					Timezone Availability:  <select name="time_availability" id="work_availability" >{$time_availability_options}</select>
				</div>
				
				<div style="float:left;height:100%;margin-left:150px;">
					Date Added on ASL:<br/>
						From <input type="text" name="date_start" id="date_start" value="{$date_start}">
						To <input type="text" name="date_end" id="date_end" value="{$date_end}"><br/><br/>
					Date Updated Resume:<br/>
						From <input type="text" name="date_updated_start" id="date_updated_start" value="{$date_updated_start}">
						To <input type="text" name="date_updated_end" id="date_updated_end" value="{$date_updated_end}"><br/><br/>					
					Date Registered:<br/>
						From <input type="text" name="date_registered_start" id="date_registered_start" value="{$date_registered_start}">
						To <input type="text" name="date_registered_end" id="date_registered_end" value="{$date_registered_end}"><br/><br/>
					Keyword / Keyword Type:<input type="text" name="keyword" id="keyword" value="{$get.keyword}">
						<select name="keyword_type" id="keyword_type">
							<option value="id" {if $get.keyword_type eq 'id'}selected{/if}>ID</option>
							<option value="first_name" {if $get.keyword_type eq 'first_name'}selected{/if}>First Name</option>
							<option value="last_name"  {if $get.keyword_type eq 'last_name'}selected{/if}>Last Name</option>
							<option value="email" {if $get.keyword_type eq 'email'}selected{/if}>Email</option>
							<!--<option value="mobile" {if $get.keyword_type eq 'mobile'}selected{/if}>Mobile No.</option>-->
							<option value="evaluation_notes" {if $get.keyword_type eq 'evaluation_notes'}selected{/if}>Evaluation Notes</option>
							<option value="skills" {if $get.keyword_type eq 'skills'}selected{/if}>Skills</option>
							<option value="notes" {if $get.keyword_type eq 'notes'}selected{/if}>Notes</option>
						</select><br/><br/>
				</div>
				
				<div style="float:left;height:100%; clear:both">
					Availability:<br/>
						<div class="availability">
							<dl>
								<dt><input type="radio" name="available_status" value="a" {$a_selected}/></dt>
								<dd>Can work <select name="available_notice">{$available_notice_options}</select> week(s) of notice period</dd>
								<dt><input type="radio" name="available_status" value="b" {$b_selected}/></dt>
								<dd>Can work after <input type="text" name="available_date" id="available_date"  value="{$get.available_date}"/></dd>
								<dt><input type="radio" name="available_status" value="p" {$p_selected}/></dt>
								<dd>Currently Inactive in Looking for Work</dd>
								<dt><input type="radio" name="available_status" value="Work Immediately" {$w_selected}/></dt>
								<dd>Work Immediately</dd>
							</dl>
						</div>	
				</div>
				
				<div style="float:left;height:100%;margin-left:220px;">
					Inactive: <select name="inactive"><option value=""></option>{$inactive_options}</select><br/><br/>
					City: <input type="text" name="city" value="{$city}"/> 
					Region: <select name="region"><option value=""></option>{$region_options}</select><br/><br/>
					Gender: <select name="gender"><option value=""></option>{$gender_options}</select> 
					Marital Status: <select name="marital_status"><option value=""></option>{$marital_status_options}</select>
					<input type="submit" value="Search">
				</div>
				
			</form>
			
			<p style="clear:both;margin-top:10px;font-size:16px;text-align:right">
				{$total_count}
			</p>
			
			
			</div>
			<!-- filter end -->
			{if $total_applicants gt 0}
			{foreach from=$categories item=category}
			
				{if $category.total_applicants neq 0}
				<h2>{$category.category_name}</h2>
				{foreach from=$category.subcategories item=subcategory}
				
				{if $subcategory.applicants neq NULL}
				
				<table align="center" class='sortable' cellspacing="0" style="width:98%;border:2px solid #000000;margin:10px 10px 0px 10px;">
					<tr style="text-align:left;background:#2C66A5;padding:5px 0px;">
						<th colspan='9' style="font:Arial;font-size:15px;color:#ffffff;padding:10px;font-weight:bold;">{$subcategory.category_name}</th>
					</tr>
					<tr style="text-align:left;background:#AAAAFF;padding:5px 0px;">
						<th width="15%" >Applicant</th>
						<th width="15%" >Skills</th>
						<th width="10%" >Work Availability</th>
						<th width="10%" >Time Zone Availability</th>
						<th width="10%" >Advertized Rate</th>
						<th width="10%" >On ASL</th>
						<th width="10%" >Shortlisted</th>
						<th width="10%" >Endorsed</th>
						<th width="10%" >RS Employment History</th>
					</tr>
				</table>

					<table style="width:98%;margin: 0px 10px;">	
						{foreach from=$subcategory.applicants item=applicant key=userid}
						<tr  style="vertical-align:top;background:{cycle values='#DDDDFF,#FFFFFF'};" > 
							<td width="15%" ><span style="color:#1831EA;font-weight:bold;" >#{$userid}</span> <span style="font-weight:bold;cursor:pointer;color:#1831EA;" onclick="window.open('/portal/recruiter/staff_information.php?userid={$userid}&page_type=popup','Staff Information',
'menubar=no,width=900,height=500,toolbar=no,scrollbars=yes')">
								{$applicant.fname} {$applicant.lname}</span><br/>
								<span style="color:#ff0000;" >{$applicant.recruiter}</span><br/>
								{$applicant.email}<br/>
								{$applicant.current_job}
							</td>
							<td width="15%" >
								{foreach from=$applicant.skills item=skill}
									{$skill}, 
								{/foreach}
								&nbsp;
							</td width="10%" >
							<td>{$applicant.availability}&nbsp;</td>
							<td width="10%" >{$applicant.time_zone}&nbsp;</td>
							<td width="10%" >
								{if $applicant.availability_parttime eq 'yes'}
									Part-time Rate:<br/>
									{foreach from=$applicant.part_time_rate key=currency item=rate}
										{$currency} {$rate}<br/>
									{/foreach}
									<br/>
								{/if}
								{if $applicant.availability_fulltime eq 'yes'}
									Full -time Rate:<br/>
									{foreach from=$applicant.full_time_rate key=currency item=rate}
										{$currency} {$rate}<br/>
									{/foreach}
								{/if}
								&nbsp;
							</td>
							<td width="10%" >{$applicant.ratings}&nbsp;</td>
							<td width="10%" ><span style="text-decoration:underline;cursor:pointer;color:#ff0000;font-weight:bold;" onclick="window.open('status_list.php?userid={$userid}&status=shortlisted','Shortlistings',
'menubar=no,width=600,height=250,toolbar=no')">{$applicant.shortlisted}</span></td>
							<td width="10%" ><span style="text-decoration:underline;cursor:pointer;color:#ff0000;font-weight:bold;" onclick="window.open('status_list.php?userid={$userid}&status=endorsed','Endorsement listings',
'menubar=no,width=600,height=250,toolbar=no')">{$applicant.endorsement_num}</span></td>
							<td width="10%" >
								{foreach from=$applicant.rs_employment_history item=rse_history}
									<span onclick="window.open('/portal/leads_information.php?id={$rse_history.lead_id}','Client Information',
'menubar=no,width=900,height=600,toolbar=no')" style="color:#1831EA;font-weight:bold;cursor:pointer;" >{$rse_history.client}</span><br>
									{$rse_history.status}<br><br>
								{/foreach}
								&nbsp;
							</td>
						</tr>
						{/foreach}
					</table>
				{/if}
				{/foreach}'
				{/if}
            {/foreach}
            {else}
				<h1>&nbsp;&nbsp;&nbsp;Sorry, No results found</h1>
			{/if}
                        
            <div align="center">
				<table width=98% cellpadding=3 cellspacing="3" border=0>
                	<tr>
                    	<td align="center">
                            <table width=100% cellpadding=3 cellspacing="0" border=0 bgcolor="#006699">
                                { $recruitment_performance_summary_report }
                            </table>
                        </td>
                    </tr>
				</table>
            </div>
            
        </td>
	</tr>
</table>

{php}include("footer.php"){/php}

<!--START: asl alarm-->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!--ENDED: asl alarm-->

<!--START: left nav. container -->
<DIV ID='applicationsleftnav_container' STYLE='POSITION: Absolute; RIGHT: 50px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
    	<table width="100%">
        	<tr>
            	<td align="right" background="images/close_left_menu_bg.gif">
					<a href="javascript: applicationsleftnav_hide(); "><img src="images/close_left_menu.gif" border="0" /></a>
				</td>
			</tr>
		</table>
        
        {php}include("applicationsleftnav.php"){/php}
        
</DIV>
<!--ENDED: left nav. container -->

</DIV>
</body>
</html>
