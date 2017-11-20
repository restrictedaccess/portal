{*
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
2011-03-08  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Portal Administrator Home</title>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./system_wide_reporting/media/css/system_wide_reporting.css">
<link rel=stylesheet type=text/css href="./system_wide_reporting/media/css/tabber.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script language=javascript src="./js/MochiKit.js"></script>
<script language=javascript src="./js/functions.js"></script>

<script type="text/javascript" src="./system_wide_reporting/media/js/system_wide_reporting.js"></script>
<script type="text/javascript" src="./system_wide_reporting/media/js/tabber.js"></script>


<script type="text/javascript" src="./js/calendar.js"></script> 
<script type="text/javascript" src="./lang/calendar-en.js"></script> 
<script type="text/javascript" src="./js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="./css/calendar-blue.css" title="win2k-1" />
{* added by msl 10/24/11 *}
<link rel=stylesheet type=text/css href="css/overlay.css">
</head>
<body style="margin-top:0; margin-left:0">
	<div id="overlay"> <div> <p>You will be logged in to RemoteStaff Chat.</p>
	<input type='button' name='submit' value='&nbsp; OK &nbsp;' onclick='alertchat(1);' /></div> </div>
	
<FORM NAME="parentForm" method="post">
{php}include("header.php"){/php}
{php}include("admin_header_menu.php"){/php}

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<tr><td width="18%" valign="top" style="border-right: #006699 2px solid;">
{php}include("adminleftnav.php"){/php}
</td>
<td valign="top">
<div align="right">Welcome #{$admin.admin_id} {$admin.admin_fname} {$admin.admin_lname}</div>

<div id="admin_tab" style="display:block; padding:20px; ">
<div class="tabber">

	<div class="tabbertab">
		  <h2>Admin</h2>
	</div>
	
	<div class="tabbertab">
		  <h2>Sales</h2>
	</div>
	
	<!--
	<div class="tabbertab">
		  <h2>Accounts</h2>
	</div>
	
	<div class="tabbertab">
		  <h2>Recruitment</h2>
	</div>
	
	<div class="tabbertab">
		  <h2>ASL</h2>
	</div>
    -->

</div>
</div>















</td>
</tr>
</table>
<!--ASL ALARM--> <DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV> <!--ENDED-->
{php}include("footer.php"){/php}
{literal}
<script language="javascript">

		var chck = 0;
		var temp = '';
		var curSubMenu = '';	
		//var curSubMenu='';
		function showSubMenu(menuId){
				if (curSubMenu!='') hideSubMenu();
				eval('document.all.'+menuId).style.visibility='visible';
				curSubMenu=menuId;
		}
		function hideSubMenu(){
				eval('document.all.'+curSubMenu).style.visibility='hidden';
				curSubMenu='';
		}
		function alertchat(clicked) {
			el = document.getElementById("overlay");
			//el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
			el.style.display = (!el.style.display || el.style.display == "none") ? "block" : "none";
			if (clicked == 1) {
				popup_win8('./rschat.php?portal=1&email={/literal}{$emailaddr}&hash={$hash}{literal}',800,600);
			}
			return false;
		}
		{/literal}
		{if $session_exists == 1}
		{literal}connect(window, 'onload', function() { //alertchat(0); });{/literal}
		{/if}{literal}
		
		
</script>
{/literal}
</form>
</body>
<script language="javascript" src="./site_media/system_wide_reporting/js/admin_home_quick_view.js"></script>
</html>
