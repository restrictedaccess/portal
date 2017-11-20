{*
2011-04-24  Roy Pepito <roy.pepito@remotestaff.com.au>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Recruiter Category Manager - { $recruiter_full_name }</title>

<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">

<script type="text/javascript" src="../js/ajax.js"></script>
<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="category/category.js"></script>
<script type="text/javascript" src="../js/tooltip.js"></script>

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
            <h1 align="left">&nbsp;Recruiter ASL Category Manager</h1>
            <!--ENDED: sub title-->            
            
            <div align="center">
            <table width="80%" cellpadding="0" cellspacing="0">
                <tr>
                <td valign="top" >
                <div id="create_category_form" ><img src="../images/ajax-loader.gif"> Loading Create Category Form....</div>
                <div style="margin-top:20px; font:12px Arial;">
                    <div style="padding:5px;"><B>CATEGORIES</b> <font size="1">( <a href="javascript: show_hide('create_category_form');getCreateCategoryForm();"><em>Add Category</em></a> )</font></div>
                    <div id="category_list"></div>
                    <div style="margin:10px;"></div>
                </td>
                </tr>
            </table>
            </div>
            <br />
			<input type='hidden' id='applicants' name="applicants" >
            
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

<script language=javascript src="js/staff_category_manager.js"></script>

</body>
</html>
