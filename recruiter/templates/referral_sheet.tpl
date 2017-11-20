<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Referral Sheet</title>
		 
		<link rel=stylesheet type=text/css href="../css/font.css">
		<link rel=stylesheet type=text/css href="../menu.css">
		<link rel=stylesheet type=text/css href="../adminmenu.css">
		<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
		<link rel=stylesheet type=text/css href="../category/category.css">
		<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">
		
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/ui.jqgrid.css">
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/themes/rs/jquery-ui-1.8.18.custom.css">
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/referrals.css">
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_sheet.css">
	
		<script language=javascript src="../js/MochiKit.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/grid.locale-en.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery.jqGrid.min.js"></script>
		<script type="text/javascript">
			jQuery.jgrid.no_legacy_api = true;
			jQuery.jgrid.useJSON = true;
		</script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.18.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/referral_sheet.js"></script>
		<script language=javascript src="../js/functions.js"></script>
		<script language=javascript src="js/staff_public_functions.js"></script>
		<script type="text/javascript" src="../js/ajax.js"></script>
		<script type="text/javascript" src="js/staff.js"></script>
	</head>
	<body>
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
		        <td valign="top" width="100%" class="content">
		<!--ENDED: left nav.-->
					<!--START: sub title-->
					<h1 align="left">&nbsp;&nbsp;Referral Sheet</h1>
					<!--ENDED: sub title-->            
					            
					
					<!--START: content for Referral Sheet-->
					<div class="main" style="border:none;width:90%;">
						<div class="referral-sheet-search">
							<dl>
								<dt>
									Filter:
								</dt>
								<dd>
									<span id="filter-container"></span>
									<select id="filter-type" name="filter_type">
										<option value="">-</option>
										<option value="1">Date Referred</option>
									</select>
								</dd>
								<dt>
									Search:
								</dt>
								<dd>
									<input type="text" name="search" id="text-search" width="600" placeholder="Enter First Name, Last Name, Phone Number, Position, Email or Referee"/>
								</dd>
								<dt>
									Type:
								</dt>
								<dd>
									<select id="refer_type" name="type">
										<option value="">All</option>
										<option value="referred" selected>Referred</option>
										<option value="promo_code">Promo Code</option>
										
									</select>
								</dd>
							</dl>
							<button type="submit" id="searchButton">Search</button>
						</div>	
						<div class="referral-sheet-container">
							<table id="referral-sheet" class="clear">
							</table>
							<div id="pager"></div>
							
						</div>
						
					</div>
				</td>
			</tr>
		</table>
		<!--START: left nav. container -->
		<div ID='applicationsleftnav_container' STYLE='POSITION: Absolute; RIGHT: 50px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
		<table width="100%">
			<tr>
				<td align="right" background="images/close_left_menu_bg.gif">
		        	<a href="javascript: applicationsleftnav_hide(); "><img src="images/close_left_menu.gif" border="0" /></a>
				</td>
			</tr>
		</table>
		
		{php} include("applicationsleftnav.php") {/php}
		
		</div>
		<!--ENDED: left nav. container -->
		{php} include("footer.php") {/php}
		
	</body>
</html>