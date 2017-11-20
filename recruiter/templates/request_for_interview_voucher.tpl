{*
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
2010-04-07  Roy Pepito <roy.pepito@remotestaff.com.au>
*}

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

<script type="text/javascript" src="category/category.js"></script>
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="../js/functions.js"></script>

<!--calendar picker - setup-->
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<script language=javascript src="js/staff_public_functions.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="js/request_for_interview_voucher.js"></script>
</head>

<body style="margin-top:0; margin-left:0">

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
<h1 align="left">&nbsp;&nbsp;Voucher Manager</h1>
<!--ENDED: sub title-->            
            

<!--START: search function-->
            <div style="background:#FFFFFF; padding:5px; text-align:center; ">
            <center>
                <table width="80%">
                    <tr>
                        <td>
                            <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                <table width="100%">
                                    <tr>
                                        <td><span><strong>Voucher Advance Search / Create Voucher</strong></span></td>
                                        <td align="right"><span style='width:150px;color:#ff0000;text-align:right;cursor:pointer;' id='label_str' onClick="show_hide_search('search_box','label_str');">[Show]</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                <table width="100%" style='display:none;' id='search_box' border="0" bgcolor="#FFFFFF">
                                <!--<table width="100%" id='search_box'>-->                            
										<tr>
											<td align="left" valign="top" bgcolor="#ffffff" colspan="3">
                                            
                                                <table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="10" cellspacing="1">
                                                  <tr>
                                                        <td align="left" valign="top" bgcolor="#ffffff"> <font color="#000000"><strong>
                                                            <form action="?" method="post" name="formtable">
                                                            <table width="0%"  border="0" cellspacing="3" cellpadding="3">
                                                                <tr>
                                                                    <td>	  
                                                                        <strong>Voucher</strong><em>(optional)</em>
                                                                    </td>
                                                                    <td><input type="text" id="f_code_number_id" name="f_code_number" value="{ if $f_code_number eq '' } Any { /if } { if $f_code_number neq '' } { $f_code_number } { /if }" class="select" /></td>							  
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row"><font color="#000000"><strong>Date&nbsp;Created</strong></font></td>
                                                                    <td>
                                                                                <table>
                                                                                    <tr>
                                                                                        <td><img align="absmiddle" src="../../images/date-picker.gif" id="id_f_date_created_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                        <td>
                                                                                        <input type="text" name="f_date_created" id="id_f_date_created" class="text" value="{ if $f_date_created eq '' } Any { /if } { if $f_date_created neq '' } { $f_date_created } { /if }">
                                                                                        { $id_f_date_created }
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row"><font color="#000000"><strong>Date&nbsp;Expire</strong></font></td>
                                                                    <td>
                                                                    
                                                                                <table>
                                                                                    <tr>
                                                                                        <td><img align="absmiddle" src="../../images/date-picker.gif" id="id_f_date_expire_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                        <td>
                                                                                        <input type="text" name="f_date_expire" id="id_f_date_expire" class="text" value="{ if $f_date_expire eq '' } Any { /if } { if $f_date_expire neq '' } { $f_date_expire } { /if }">
                                                                                        { $id_f_date_expire }                                        
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>                                        
                                                                    </td>
                                                                </tr>									
                                                                <tr>
                                                                    <td scope="row"><font color="#000000"><strong>Source</strong></font></td>
                                                                    <td>
                                                                          <select size="1" class="text" name="f_admin_id">
                                                                          { $admin_search_options }
                                                                          </select>
                                                                    </td>							
                                                                </tr>
                                                                <tr>
                                                                    <td></td><td valign="top"><font color="#000000"><input type="submit" value="Search" name="submit" class="button">									
                                                                </tr>
                                                            </table>
                                                            </form>
                                                        </td>
                                                    <tr />
                                                </table>
                                                
                                        </td>
                                        <td align="center" valign="middle" bgcolor="#FFFFFF" colspan="3">
                                        
                                                <table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="10" cellspacing="1">
                                                    <tr>
                                                        <td align="left" valign="top" bgcolor="#ffffff"> <font color="#000000"><strong>
                                                            <form action="?" method="post" name="formtable">
                                                            <table width="0%"  border="0" cellspacing="3" cellpadding="3">
                                                                <tr>
                                                                    <td>	  
                                                                        <strong>Voucher</strong>
                                                                    </td>
                                                                    <td><input type="text" id="f_code_number_id" name="f_code_number" value="{ $gen_f_code_number }" class="select" /></td>							  
                                                                    <td rowspan="1" align="center"><strong>Notes</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row"><font color="#000000"><strong>Date&nbsp;Created</strong></font></td>
                                                                    <td>
                                                                          
                                                                                <table>
                                                                                    <tr>
                                                                                        <td><img align="absmiddle" src="../../images/date-picker.gif" id="id_f_date_created_c_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                        <td>
                                                                                        <input type="text" name="f_date_created" id="id_f_date_created_c" class="text" value="{ $date_today }">
                                                                                        { $id_f_date_created_c }                                         
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>                                               
                                                                    </td>
                                                                    <td rowspan="4" align="center" valign="top">
                                                                        <textarea name="f_comment" rows="4" class="text" id="id_f_comment">{ $gen_f_comment }</textarea>										
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row"><font color="#000000"><strong>Date&nbsp;Expire</strong></font></td>
                                                                    <td>
                                                                    
                                                                                <table>
                                                                                    <tr>
                                                                                        <td><img align="absmiddle" src="../../images/date-picker.gif" id="id_f_date_expire_c_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                        <td>
                                                                                        <input type="text" name="f_date_expire" id="id_f_date_expire_c" class="text" value="{ $date_today_advance }">
                                                                                        { $id_f_date_expire_c }                                        
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>                                        
                                                                    </td>
                                                                </tr>	
                                                                <tr>
                                                                    <td scope="row"><font color="#000000"><strong>Limit</strong></font></td>
                                                                    <td><input type="text" name="f_limit_of_use" id="id_f_limit_of_use" class="text" value="{ $f_limit_of_use }" size="5" maxlength="5"></td>
                                                                </tr>                                    								
                                                                <tr>
                                                                    <td scope="row"><font color="#000000"><strong>Source</strong></font></td>
                                                                  <td>
                                                                          <select size="1" class="text" name="f_admin_id" id="id_f_admin_id">
                                                                          { $admin_create_options }
                                                                          </select>
                                                                    </td>							
                                                                </tr>
                                                                <tr>
                                                                    <td></td><td valign="top"><font color="#000000"><input type="submit" value="Create" name="create" class="button">									
                                                                </tr>
                                                            </table>
                                                            </form>
                                                        </td>
                                                    <tr />
                                                </table>
                                        
                                        </td>
                                      </tr>                                    
                                </table>
                            </div>
						</td>
                    </tr>
                </table>
			</center>
            </div>
<!--ENDED: search function-->            
            

<!--START: listings-->
            <div align="center">
				<table width=98% cellpadding=3 cellspacing="3" border=0>
                	<tr>
                    	<td align="center">
                            <table width=100% cellpadding=3 cellspacing="0" border=0 bgcolor="#006699">
                            
                                <tr bgcolor="#FFFFFF">
                                	<td></td>
                                    <td align="right" colspan="6"> { $pages } </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#FFFFFF" style="border-right: #006699 2px solid;"></td>
                                    <td align="left"><font color="#FFFFFF" size="1"><strong>VOUCHER&nbsp;NUMBER</strong></font></td>
                                    <td align="left"><font color="#FFFFFF" size="1"><strong>DATE&nbsp;EXPIRE</strong></font></td>
                                    <td align="left"><font color="#FFFFFF" size="1"><strong>DATE&nbsp;CREATED</strong></font></td>
                                    <td align="left"><font color="#FFFFFF" size="1"><strong>LIMIT/TOTAL&nbsp;USED</strong></font></td>
                                    <td align="left"><font color="#FFFFFF" size="1"><strong>NOTES</strong></font></td>
                                </tr>

								{ $searched_result_listings }
                                	
                                <tr bgcolor="#FFFFFF">
                                	<td></td>
                                    <td align="right" colspan="6"> { $pages } </td>
                                </tr>   
                            </table>
                        </td>
                    </tr>
				</table>
            </div>
            
        </td>
	</tr>
</table>
<!--ENDED: listings-->


</td>
</tr>
</table>

{php} include("footer.php") {/php}

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

{php} include("applicationsleftnav.php") {/php}

</DIV>
<!--ENDED: left nav. container -->


</body>
</html>
