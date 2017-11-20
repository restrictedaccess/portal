{* based from recruiterHome template by the original devs *}
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

<!--calendar picker - setup-->
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<script type="text/javascript" src="../js/ajax.js"></script>
<script language=javascript src="js/staff_public_functions.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="js/RecruiterHome.js"></script>
<script type="text/javascript" src="../leads_information/media/js/tabber.js"></script>
<script type="text/javascript">
{literal}
function calcHeight() {
  var _firefox = /Firefox/i.test(navigator.userAgent);

  var iframewin = document.getElementById('iFrameWin');
  var innerDoc = iframewin.document;

  if (iframewin.contentDocument)
    innerDoc = iframewin.contentDocument; // For NS6
  if (iframewin.contentWindow)
    innerDoc = iframewin.contentWindow.document; // For IE5.5 and IE6
  
  var docElHeight = innerDoc.documentElement.scrollHeight;
  if( innerDoc.body )
	var docBoHeight = innerDoc.body.scrollHeight;
  //if( innerDoc.documentElement.scrollHeight )
  if (_firefox)	{
	 if (docElHeight > docBoHeight) iframewin.height = docElHeight;
	 else iframewin.height = docBoHeight;
  }
  else iframewin.height = innerDoc.body.scrollHeight;

}
{/literal}
</script>
</head>

<body style="margin-top:0; margin-left:0">

{php}include("header.php"){/php}
{php}include("recruiter_top_menu.php"){/php}
<input type="hidden" id="reload" value="">
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
        
        	<!--<div align="right">Welcome Recruiter <?php echo $admin['admin_fname']." ".$admin['admin_lname'];?></div>-->
            
            <!--START: sub title-->
            <h1 align="left">&nbsp;Test Takers</h1>
            <!--ENDED: sub title-->            
            
            
            
            <br />            
            
            <div align="center">
				<table width=98% cellpadding=3 cellspacing="3" border=0>
                	<tr>
                    	<td align="left">
                            <div class="tabber">
                                <div ID='popup_report' align="center" style='POSITION: Absolute; border: dashed ; overflow:hidden; background: #FFF; height:330px; width: 740px; VISIBILITY: HIDDEN '></DIV>
                                
                                
                                <iframe id='iFrameWin' name='iFrameWin' frameborder='0' src='/skills_test/?/reports/&nl=1' onLoad="calcHeight();" height='380px'
								scrolling="auto" style='width:100%;padding:1px;margin:1px;float:left;overflow:hidden;'>
								</iframe>
                                
                               
                                
                            </div>
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
