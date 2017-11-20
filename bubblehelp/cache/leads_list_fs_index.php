<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
.btspot {color:#900; padding-bottom:1px; border-bottom:1px dotted #900; cursor:pointer}
#bt {position:absolute; display:block; background:url(/portal/bubblehelp/images/bt_left.gif) top left no-repeat}
#bttop {display:block; height:5px; margin-left:5px; background:url(/portal/bubblehelp/images/bt_top.gif) top right no-repeat; overflow:hidden}
#btcont {display:block; padding:2px 12px 3px 7px; margin-left:5px; background:#FF8301; color:#FFF;}
#btbot {display:block; height:5px; margin-left:5px; background:url(/portal/bubblehelp/images/bt_bottom.gif) top right no-repeat; overflow:hidden}
#task-status {  position:fixed;  width:300px;  height: auto;  top:0;  margin-left:-150px; z-index: 999;  font-size:12px; font-weight:bold;
  background:#ffff00;  padding-left:5px;  text-align:center;  display:none;  left:50%;}
</style><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remote Staff Leads List</title>

<link rel="stylesheet" type="text/css" href="./media/css/overlay.css" />
<link rel="stylesheet" type="text/css" href="./media/css/admin.css" />

<link rel="icon" href="../favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />



    <script src="../js/MochiKit.js" type="text/javascript"></script>
    <script src="../js/functions.js" type="text/javascript"></script>
    <script src="media/js/leads_list.js" type="text/javascript"></script>
    <script src="media/js/overlay.js" type="text/javascript"></script>
    <script src="media/js/dropdown.js" type="text/javascript"></script>

</head>
<body id='navselected' onload="placeIt()">
<link rel=stylesheet type="text/css" href="/portal/bubblehelp/pullmenu.css" />
<link rel=stylesheet type="text/css" href="/portal/ticketmgmt/css/overlay.css" />
<iframe id='ajaxframe' name='ajaxframe' style='display:none;' src='javascript:false;'></iframe>
<div id='boxdiv' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:390px;padding:3px;border:1px solid #011a39;'>
	<div class='title'>Edit Help Content - <span id='blink'></span></div>
		
		<form name='regform' method='POST' target='ajaxframe' action='/portal/bubblehelp/bhelp.php?/set_data/' style='padding:0;margin:0;'>
			<input type='hidden' name='link_id' id='link_id' />
            <input type='hidden' name='item' id='item' value='new'/>
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			<!--<tr><td class='form1'>Subject:</td>
				<td class='form2'><input type="text" id="email_subject" name="email_subject" value="Remotestaff: Client-Staff Support" class="inputbox2"/></td>
			</tr>-->
			  
			  <tr><td class='form2'>Enter text here:</td></tr>
			<tr><td class='form2'><textarea id="help_content" name='help_content' class='text' rows='5' style='width:95%;float:left;'></textarea></td></tr>
			   
			 <tr>
			<td colspan="2" align='center'>
			<input type='submit' class='button' id='createbutton' value='Edit'> <input type='button' class='button' value='Cancel' onClick="$('boxdiv').style.display='none';">
			</tr>
		  </table>
		</form>
	</div>
	
</div>
<div id="overlay">
<div>
<p>Mark Lead <span id="mark_leads_name"></span> For : </p>
<ul>
<li><input type="radio" name="mark_lead_for" value="Replacement Requests" />Replacement Requests</li>
<li><input type="radio" name="mark_lead_for" value="CSR Concerns" />CSR Concerns</li>
<li><input type="radio" name="mark_lead_for" value="Sales Follow Up" />Sales Follow Up</li>
<input type="button" id="mark_btn" leads_id="" value="mark" onclick="MarkLead()" /> <input type="button" value="close" onclick="fade('overlay')" />
</ul>
</div>
</div>
<div id="nav">
    <img src="./media/images/remote_staff_logo.png" />
	    <span>Admin: <a href="../admin_profile.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">#43 Anne Charise Mancenido</a><br />
		<a href="/portal/bubblehelp/bhelp.php?/create_page/&curl=leads_list/index.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" title="Open Help Page" >Help Page</a>
		    <a style="float:right;" href="../logout.php" >Logout</a>
			
		</span>
	<div id="navholder">
        <div id="navbox">
            <ul>
		        <li>&nbsp;</li>
				                    <li><a href="../adminHome.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" id="navadminhome">Home</a></li>
										    <li><a href="../recruiter/RecruiterHome.php' " style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recruitment</a></li>
													
								    					                                <li>
																			            												            												            																    <img src='images/star.png' border='0'  >
												            
							<a href="index.php?lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >New Leads</a>
							</li>
												
								    					                                <li>
																			            												            												            												            
							<a href="index.php?lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Follow-Up</a>
							</li>
												
								    					                                <li>
																			            												            												            												            
							<a href="index.php?lead_status=asl" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Asl</a>
							</li>
												
								    					                                <li>
																			            																    <img src='images/star.png' border='0'  >
												            												            												            
							<a href="index.php?lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Custom Recruitment</a>
							</li>
												
								    					                                <li>
																			            												            																    <img src='images/star.png' border='0'  >
												            												            
							<a href="index.php?lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Keep In-Touch</a>
							</li>
												
								    					                                <li>
																			            												            												            												            
							<a href="index.php?lead_status=pending" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Pending</a>
							</li>
												
								    					    						    <li id="sample_attach_menu_parent">
																							    <img src='images/star.png' border='0'  >
												            												            												            												            							<a href="index.php?lead_status=Client" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"   >Client</a>
							</li>
												
								
									<li><a href="../adminscm.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"> Sub Contractor Management</a></li>
                    <li><a href="../subconlist.php'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">List of Sub Contractors</a></li>
				                
            </ul>
		</div>	
    </div>
</div>
<div id="sample_attach_menu_child">
<a class="sample_attach" href="index.php?lead_status=Client&filter=ACTIVE">Active Clients</a>
<a class="sample_attach" href="index.php?lead_status=Client&filter=INACTIVE">Inactive Clients</a>
<a class="sample_attach" href="index.php?lead_status=Client">All Clients</a>
</div>

<script type="text/javascript">
at_attach("sample_attach_menu_parent", "sample_attach_menu_child", "hover", "y", "pointer");
</script>
<div id="container">
<!-- Content Starts Here -->
<form name="form" method="post" >

<div id="users_search_form">
<input type="hidden" name="page" id="page" value="1" />
<input type="hidden" name="agent_no" id="agent_no" />
<input type="hidden" name="path" id="path" value="lead_status=" />
<input type="hidden" name="applicants" id="applicants">
<input type="hidden" name="status" id="status" >
<div class="form_filters">
<fieldset><legend>SEARCH FILTERS</legend>
<p >Search Leads : 
<select name="lead_status" id="lead_status" style="width:120px;">
    <option value="All">All</option>        	    <option value="Keep In-Touch" >Keep In-Touch</option>
		        	    <option value="Client" >Client</option>
		        	    <option value="Inactive" >Inactive</option>
		        	    <option value="REMOVED" >REMOVED</option>
		        	    <option value="Contacted Lead" >Contacted Lead</option>
		        	    <option value="Follow-Up" >Follow-Up</option>
		        	    <option value="New Leads" >New Leads</option>
		            	    <option value="transferred" >Transferred</option>
		        	    <option value="pending" >Pending</option>
		        	    <option value="Interview Bookings" >Interview Bookings</option>
		        	    <option value="custom recruitment" >Custom Recruitment</option>
		        	    <option value="asl" >Asl</option>
		        	    <option value="deleted" >Deleted</option>
		</select>

Business Developer : 

    <select name="business_developer_id" id="business_developer_id" style="width:130px;" 
			 >
	<option value="all">All</option>
		    		    <option value="2" >Chris Jankulovski</option>
				    		    <option value="402" >Kenneth Tubio</option>
				    		    <option value="231" >Lance Harvie</option>
				    		    <option value="342" >Methany Medina</option>
				    		    <option value="343" >Michael Burns</option>
				    		    <option value="1" >Normaneil Macutay</option>
				    		    <option value="139" >Paul De Leon</option>
				    		    <option value="334" >Ralyn Silva</option>
				    		    <option value="426" >Rendall Young</option>
				    		    <option value="9" >Rica Lalanie Gil</option>
				    		    <option value="44" >Walter Fulmizi</option>
				</select>
	     Hiring Coordinator : <select name="hiring_coordinator_id" id="hiring_coordinator_id" style="width:130px;">
   <option value="">-</option>
          <option value="16"  >PJ Boromeo</option>
          <option value="83"  >Michelle Borras</option>
          <option value="92"  >Ryan  Torres</option>
          <option value="134"  >Former  Hiring Managers </option>
          <option value="151"  >Simon Pardo</option>
   </select>
Pin : 
<select name="pin" id="pin" style="width:150px;">
   <option value="">-</option>
          <option value="Replacement Requests" >Replacement Requests</option>
          <option value="CSR Concerns" >CSR Concerns</option>
          <option value="Sales Follow Up" >Sales Follow Up</option>
   </select>
<span >
Search By: 
<select name="field" id="field">
    <option value="keyword">Keyword</option>
    	    <option value="l.id" >Id</option>
	    	    <option value="email" >Email</option>
	    	    <option value="fname" >First Name</option>
	    	    <option value="lname" >Last Name</option>
	</select>
<input type="text" name="keyword" id="keyword" value="" size="30" />
</span>
<input type="submit" name="search" id="search" value="Search" class="button"  />
</p>
</fieldset>
</div>

<div class="form_filters" style="margin-top:20px;">
<fieldset><legend>ACTION BUTTONS</legend>
<p> <input  type="button" value="Add New Lead" class="button" onClick="self.location='../AddUpdateLeads.php'" />
            <input type="submit" name="move" id="move" value="Move to New Leads" disabled="disabled" onclick="Move('New Leads')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Follow-Up" disabled="disabled" onclick="Move('Follow-Up')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Keep In-Touch" disabled="disabled" onclick="Move('Keep In-Touch')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Pending" disabled="disabled" onclick="Move('pending')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Asl" disabled="disabled" onclick="Move('asl')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Custom Recruitment" disabled="disabled" onclick="Move('custom recruitment')" class="button" />
	<input type="submit" name="transfer" id="transfer" disabled="disabled" value="Tranfer to" onClick="return CheckBP();"  class="button"> <select name="agent_id" id="agent_id" style="width:200px;" disabled="disabled" >
<option value="">Business Developer</option>
<option value='2'>Chris Jankulovski</option><option value='44'>Walter Fulmizi</option><option value='343'>Michael Burns</option><option value='402'>Kenneth Tubio</option><option value='426'>Rendall Young</option>
</select>
</p>
</fieldset></div>
<br clear="all" />
<h2 align="center">
    
</h2>

<p align="center">There are <strong>0</strong> <span style="text-transform:capitalize;"></span> today December 20, 2012








</p>
<br clear="all" />

</div><div id="leads_list" counter="20" style="background:#BBCCFF;" >
<div class="list_list_holder"><span style="background:#009900; cursor:pointer;" onclick="toggle('marked_leads_list_div')" title="show/hide">MARKED LEADS</span></div>
<div id="marked_leads_list_div" >
<table id="marked_leads_list_tb" class="leads_list" width="100%" cellpadding="0" cellspacing="1" bgcolor="#cccccc" >

<thead>
<tr >
<th class="sort" mochi:format="number" style="cursor:pointer;">#</th>
<th>ID</th>
<th class="sort" mochi:format="str" style="cursor:pointer;">NAME</th>
<th >INFO</th>
<th class="sort" mochi:format="isodate" style="cursor:pointer;">DATE UPDATED</th>
<th class="sort" mochi:format="isodate" style="cursor:pointer;">REGISTERED DATE</th>
<th >&nbsp;</th>
<th >26 Marked leads found..</th>
</tr>
</thead>
<tfoot class="invisible">
<tr>
<td colspan="0"></td>
</tr>
</tfoot>
<tbody>
<tr bgcolor="#ffffff">



<td class="sorted item" >
1
<input type='checkbox' onClick='check_val()' name='users' value='8825' >
<div align="center">
<span id="mark_link_8825" class="mark_unmark_link" onclick="mark_unmark_lead(8825)" mode='mark' leads_name="#8825 Consuelo  Sambrano">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8825
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8825&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Consuelo  Sambrano </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">convince514_69@yahoo.com</span><br />
101AVAILABLESTAFF<br />Mobile 09082665700</td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-19</span>
</td>


<td class="actions">
<div class="identical"></div>
New Leads<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8825');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8825" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8825'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8825);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8825');">
</div>
<div id='8825_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='8814' >
<div align="center">
<span id="mark_link_8814" class="mark_unmark_link" onclick="mark_unmark_lead(8814)" mode='mark' leads_name="#8814 Imelda  Lim">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8814
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8814&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Imelda  Lim </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">test@crashtestdummy.com</span><br />
101AVAILABLESTAFF<br />Mobile 0917 8663562</td>

<td class="sorted date_updated" >2012-12-14</td>

<td class="sorted timestamp">
<span >2012-12-14</span>
</td>


<td class="actions">
<div class="identical"></div>
New Leads<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8814');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8814" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8814'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8814);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8814');">
</div>
<div id='8814_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='8688' >
<div align="center">
<span id="mark_link_8688" class="mark_unmark_link" onclick="mark_unmark_lead(8688)" mode='mark' leads_name="#8688 Jeremy  Dawes">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8688
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8688&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jeremy  Dawes </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">mail@jezweb.com.au</span><br />
101RECRUITMENTSERVICE<br />Office No. 02 4951 5267<br />Mobile 0411056876</td>

<td class="sorted date_updated" >2012-11-26</td>

<td class="sorted timestamp">
<span >2012-11-02</span>
</td>


<td class="actions">
<div class="identical"></div>
Keep In-Touch<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8688');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8688" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8688'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8688);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8688');">
</div>
<div id='8688_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8688',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11/26/2012  ADMIN : Ryan  Lead hired through Odesk. Will keep in touch for additional staff</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1698</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1226&jr_cat_id=2&jr_list_id=6&gs_job_role_selection_id=1698',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">PHP Developer</a></li></ol></div><div><strong>Custom Recruitment Order #1710</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1237&jr_cat_id=2&jr_list_id=6&gs_job_role_selection_id=1710',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">PHP Developer</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1238&jr_cat_id=2&jr_list_id=8&gs_job_role_selection_id=1710',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Web Designer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' onClick='check_val()' name='users' value='8594' >
<div align="center">
<span id="mark_link_8594" class="mark_unmark_link" onclick="mark_unmark_lead(8594)" mode='mark' leads_name="#8594 Steve  Roberts">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
8594
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8594&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Steve  Roberts </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">yourmideals@gmail.com</span><br />
101HOMEPAGEENQUIRY<br />Office No. 6168862804<br />Mobile 6168862804</td>

<td class="sorted date_updated" >2012-12-18</td>

<td class="sorted timestamp">
<span >2012-10-05</span>
</td>


<td class="actions">
<div class="identical"><div>Identical Name to : <br><a href="../leads_information.php?id=8595&lead_status=New Leads&url=leads_list/index.php?'" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">#8595 Billy Evans [New Leads]</a></div></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8594');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8594" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8594'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8594);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8594');">
</div>
<div id='8594_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1532</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1081&jr_cat_id=1&jr_list_id=12&gs_job_role_selection_id=1532',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
5
<input type='checkbox' onClick='check_val()' name='users' value='8585' >
<div align="center">
<span id="mark_link_8585" class="mark_unmark_link" onclick="mark_unmark_lead(8585)" mode='mark' leads_name="#8585 Andy  Sharpe">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8585
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8585&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andy  Sharpe </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">Andy@songdivision.com</span><br />
101AVAILABLESTAFF<br />Mobile +1 347 768 3343</td>

<td class="sorted date_updated" >2012-12-18</td>

<td class="sorted timestamp">
<span >2012-10-02</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8585');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8585" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8585'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8585);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8585');">
</div>
<div id='8585_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8585',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/3/2012  BP : Rendall Left VM</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1525</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1076&jr_cat_id=1&jr_list_id=13&gs_job_role_selection_id=1525',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
6
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_8552" class="mark_unmark_link" onclick="mark_unmark_lead(8552)" mode='mark' leads_name="#8552 TEST  Test">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8552
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8552&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">TEST  Test </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">charisse.vm@remotestaff.com.au.REMOVED</span><br />
101HOMEPAGEENQUIRY<br />Office No. 09-24-2012<br />Mobile 09-24-2012</td>

<td class="sorted date_updated" >2012-10-05</td>

<td class="sorted timestamp">
<span >2012-09-24</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.net</div>
<div></div>
<!--
<div>
 <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p></div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8552');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8552" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8552'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8552);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8552');">
</div>
<div id='8552_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1539</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1087&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=1539',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
7
<input type='checkbox' onClick='check_val()' name='users' value='8346' >
<div align="center">
<span id="mark_link_8346" class="mark_unmark_link" onclick="mark_unmark_lead(8346)" mode='mark' leads_name="#8346 Raheel  Khan">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8346
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8346&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Raheel  Khan </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">raheelkhan35@Gmail.com</span><br />
101<br />Office No. 713.800.6000   and   713.800.6001         <br /></td>

<td class="sorted date_updated" >2012-12-20</td>

<td class="sorted timestamp">
<span >2012-08-01</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8346');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8346" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8346'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8346);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8346');">
</div>
<div id='8346_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
8
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_8177" class="mark_unmark_link" onclick="mark_unmark_lead(8177)" mode='mark' leads_name="#8177 Elizabeth  De Leon">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8177
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8177&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Elizabeth  De Leon </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">annejandelossantos@yahoo.com.REMOVED</span><br />
101AVAILABLESTAFF<br />Mobile 09294595275</td>

<td class="sorted date_updated" >2012-07-02</td>

<td class="sorted timestamp">
<span >2012-07-01</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8177');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8177" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8177'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8177);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8177');">
</div>
<div id='8177_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
9
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_8142" class="mark_unmark_link" onclick="mark_unmark_lead(8142)" mode='mark' leads_name="#8142 Maricar  Laygo">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8142
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8142&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Maricar  Laygo </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">swirls_mar08@yahoo.com.REMOVED</span><br />
101AVAILABLESTAFF<br />Mobile 09197318565</td>

<td class="sorted date_updated" >2012-06-26</td>

<td class="sorted timestamp">
<span >2012-06-25</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8142');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8142" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8142'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8142);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8142');">
</div>
<div id='8142_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
10
<input type='checkbox' onClick='check_val()' name='users' value='7994' >
<div align="center">
<span id="mark_link_7994" class="mark_unmark_link" onclick="mark_unmark_lead(7994)" mode='mark' leads_name="#7994 Tina  Bisaccio">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
7994
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=7994&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Tina  Bisaccio </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">tina.bisaccio@specialized.com</span><br />
101<br />Office No. 408-782-7232<br /></td>

<td class="sorted date_updated" >2012-07-17</td>

<td class="sorted timestamp">
<span >2012-06-01</span>
</td>


<td class="actions">
<div class="identical"></div>
Keep In-Touch<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_7994');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_7994" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_7994'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(7994);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_7994');">
</div>
<div id='7994_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
11
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_7915" class="mark_unmark_link" onclick="mark_unmark_lead(7915)" mode='mark' leads_name="#7915 Devs  Dummy">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
7915
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=7915&lead_status=Client" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Devs  Dummy </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">devs@remotestaff.com.au</span><br />
101INBOUNDCALL<br />Office No. 05232012 / 08292012<br />Mobile 05232012 / 08292012</td>

<td class="sorted date_updated" >2012-12-06</td>

<td class="sorted timestamp">
<span >2012-05-16</span>
</td>


<td class="actions">
<div class="identical"></div>
Client<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>ASL ORDER : NEW!!!<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_7915');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_7915" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_7915'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(7915);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_7915');">
</div>
<div id='7915_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=7915',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">07/19/2012  ADMIN : Nena Feline  zz</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #794</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=641&jr_cat_id=3&jr_list_id=11&gs_job_role_selection_id=794',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Accountant</a></li></ol></div><div><strong>Custom Recruitment Order #820</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=656&jr_cat_id=1&jr_list_id=3&gs_job_role_selection_id=820',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Graphic Designer</a></li></ol></div><div><strong>Custom Recruitment Order #1495</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1064&jr_cat_id=2&jr_list_id=82&gs_job_role_selection_id=1495',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Front end Developer</a></li></ol></div><div><strong>Custom Recruitment Order #1661</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1196&jr_cat_id=2&jr_list_id=6&gs_job_role_selection_id=1661',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">PHP Developer</a></li></ol></div><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=4AGTKXRY7KZ4EIR7bRVNCZ8T2YTUc73F73U4LPOS1HDNS' target='_blank'> - 5th Nov 12 07:38 AM quote given Full-Time TEST Job Position :  $ AUD 400.00</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2012-11-05<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=PHZB93T84K95Rc0LCLUB7aR5aB0bNLY00WJDa3SM5M6F4' target='_blank' class=''>- 07:38 AM Service Agreement # 1809</a><br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
12
<input type='checkbox' onClick='check_val()' name='users' value='7702' >
<div align="center">
<span id="mark_link_7702" class="mark_unmark_link" onclick="mark_unmark_lead(7702)" mode='unmark' leads_name="#7702 Darren  Kane">Remove Pin</span>
</div>
<!---->
</td>

<td class="ids">
7702
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=7702&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Darren  Kane </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">darren.kane@missioncriticalservices.com</span><br />
101<br />Office No. 212-734-0322<br />Mobile 2126346318</td>

<td class="sorted date_updated" >2012-08-13</td>

<td class="sorted timestamp">
<span >2012-04-06</span>
</td>


<td class="actions">
<div class="identical"></div>
Keep In-Touch<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>ASL ORDER : IN PROGRESS<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">


<img src="./images/pin_blue.png" title="Sales Follow Up" align="texttop" />
<span>Sales Follow Up</span>

</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_7702');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_7702" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_7702'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(7702);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_7702');">
</div>
<div id='7702_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=7702',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">05/11/2012  ADMIN : Recruiters sent another email on admin@remotestaff.com.au today. See notes i</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
13
<input type='checkbox' onClick='check_val()' name='users' value='7649' >
<div align="center">
<span id="mark_link_7649" class="mark_unmark_link" onclick="mark_unmark_lead(7649)" mode='mark' leads_name="#7649 Raquel  Lanting">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
7649
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=7649&lead_status=Inactive" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Raquel  Lanting </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">raquel0571@yahoo.com</span><br />
101HOMEPAGEENQUIRY<br />Mobile 0939 5968256 / 0939 5968256</td>

<td class="sorted date_updated" >2012-04-05</td>

<td class="sorted timestamp">
<span >2012-03-28</span>
</td>


<td class="actions">
<div class="identical"></div>
Inactive<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_7649');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_7649" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_7649'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(7649);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_7649');">
</div>
<div id='7649_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=7649',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/28/2012  BP : Walter sent an email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
14
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_7547" class="mark_unmark_link" onclick="mark_unmark_lead(7547)" mode='mark' leads_name="#7547 Shraddha  Mishra">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
7547
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=7547&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Shraddha  Mishra </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">omharinand@gmail.com.REMOVED</span><br />
101AVAILABLESTAFF<br />Office No. 0120-9999717950<br />Mobile 9999717950</td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2012-03-11</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_7547');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_7547" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_7547'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(7547);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_7547');">
</div>
<div id='7547_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
15
<input type='checkbox' onClick='check_val()' name='users' value='7208' >
<div align="center">
<span id="mark_link_7208" class="mark_unmark_link" onclick="mark_unmark_lead(7208)" mode='mark' leads_name="#7208 Al  Se">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
7208
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=7208&lead_status=Inactive" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Al  Se </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ali_mr.2857@yahoo.com.ph</span><br />
101AVAILABLESTAFF<br />Office No. 11009911002<br />Mobile 2299199</td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2012-01-05</span>
</td>


<td class="actions">
<div class="identical"></div>
Inactive<br />
<div align="center">www.remotestaff.biz</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_7208');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_7208" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_7208'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(7208);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_7208');">
</div>
<div id='7208_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
16
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_7197" class="mark_unmark_link" onclick="mark_unmark_lead(7197)" mode='mark' leads_name="#7197 Darlene  Tupas">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
7197
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=7197&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Darlene  Tupas </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">shineeshwenky@yahoo.com.REMOVED</span><br />
210ChrisFacebook<br />Office No. 09235917199<br />Mobile 09235917199</td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2012-01-02</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_7197');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_7197" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_7197'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(7197);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_7197');">
</div>
<div id='7197_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
17
<input type='checkbox' onClick='check_val()' name='users' value='7027' >
<div align="center">
<span id="mark_link_7027" class="mark_unmark_link" onclick="mark_unmark_lead(7027)" mode='unmark' leads_name="#7027 Douglas  Stern">Remove Pin</span>
</div>
<!---->
</td>

<td class="ids">
7027
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=7027&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Douglas  Stern </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">douglas@sternenvironmental.com</span><br />
398AddedManually<br />Office No. 201-319-9620 Ext. 112<br />Mobile 917-362-5000</td>

<td class="sorted date_updated" >2012-09-24</td>

<td class="sorted timestamp">
<span >2011-11-12</span>
</td>


<td class="actions">
<div class="identical"></div>
Keep In-Touch<br />
<div align="center">www.remotestaff.biz</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">
<img src="./images/pin_red.png" title="Replacement Requests" align="texttop" />
<span>Replacement Requests</span>



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_7027');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_7027" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_7027'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(7027);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_7027');">
</div>
<div id='7027_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=7027',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/1/2011  ADMIN : Elaine Sent Information Update email. Waiting for response before I send</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1110</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=863&jr_cat_id=1&jr_list_id=12&gs_job_role_selection_id=1110',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div><div style='margin-bottom:8px;'><b>4 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=UAVFT77BcW1MLXPK5bMN7V4R8aZW3NVCA35HI37RMBJYA' target='_blank'> - 15th Dec 11 01:38 AM quote given Part-Time Part Time - Telemarketer - Geraldine - 36692 :  $ USD 458.00</a></div><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=TAFIFJZV6YPV8K0EGVVRWF1TI85RbS91SYaa2EIENOS9B' target='_blank'> - 28th Dec 11 03:52 PM quote given Part-Time PT Telemarketer - Maripet - 36336 :  $ USD 592.00</a></div><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=7MDKbN2YDCEcPKXGUH2VBaaUUbH8F7MCBM7OUFOS2aS66' target='_blank'> - 17th Jan 12 07:37 AM quote given Full-Time 23300 Candidate ID Winston :  $ AUD 1057.89</a></div><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=KBMDC1KS3981YAN3WTRGNC15GFLD2Oc6EN2PBW9A8Z0C9' target='_blank'> - 13th Mar 12 07:41 AM quote given Part-Time Telemarketer - Ricci 38180 :  $ USD 473.68</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>2 Service Agreement given</b></div>2011-12-15<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=3NJ8VNaCIXS40ZBBJEXVH3cOD2WVZMCXPEPVOWCHGYLSW' target='_blank' class=''>- 01:38 AM Service Agreement # 1480</a><br>2012-03-13<br><a style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=VJJPN0FFSN6aKB0N1RDb4RW1JVZbZ2aFREBS82cF1YS3P' target='_blank' class=''>- 07:41 AM Service Agreement # 1576</a><br></div><div style='margin-bottom:8px;'><div style='margin-bottom:3px;'><b>1 Job Specification Form given</b></div>2011-11-30<br> - 03:54 AM (<img src='../images/action_check.gif' align='absmiddle' /><a class='link15' href='../pdf_report/job_order_form/?ran=PJ4RCbcDP8W8LXC8F1HV7V08I5BBJSP2TGR373YJUXUCS' target='_blank' class=''>#1968 Job Specification Form filled up 19th Mar 12 10:57 AM</a> )<br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
18
<input type='checkbox' onClick='check_val()' name='users' value='6945' >
<div align="center">
<span id="mark_link_6945" class="mark_unmark_link" onclick="mark_unmark_lead(6945)" mode='mark' leads_name="#6945 Diya  Tapar">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
6945
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=6945&lead_status=Inactive" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Diya  Tapar </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">diya_thapar@msn.com</span><br />
101<br />Office No. 416 577 6585<br />Mobile 9810097663</td>

<td class="sorted date_updated" >2012-10-25</td>

<td class="sorted timestamp">
<span >2011-10-22</span>
</td>


<td class="actions">
<div class="identical"></div>
Inactive<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_6945');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_6945" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_6945'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(6945);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_6945');">
</div>
<div id='6945_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=6945',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/25/2012  BP : Rendall JOBSEEKER</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
19
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_6128" class="mark_unmark_link" onclick="mark_unmark_lead(6128)" mode='unmark' leads_name="#6128 David  Easton">Remove Pin</span>
</div>
<!---->
</td>

<td class="ids">
6128
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=6128&lead_status=Client" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">David  Easton </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">david@reborn.com.au</span><br />
101<br />Office No. 02 8507 6892<br />Mobile 0408 227 816</td>

<td class="sorted date_updated" >2012-08-06</td>

<td class="sorted timestamp">
<span >2011-04-05</span>
</td>


<td class="actions">
<div class="identical"></div>
Client<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">
<img src="./images/pin_red.png" title="Replacement Requests" align="texttop" />
<span>Replacement Requests</span>



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_6128');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_6128" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_6128'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(6128);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_6128');">
</div>
<div id='6128_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=6128',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">07/3/2012  BP : Walter sent whats up email</a></div>
<div></div>
<div class='steps_list_section'><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=c1NKBN957A39F3Saa9YMJ9MRAESOS3BPSAcHY0a73RUTc' target='_blank'> - 11th Apr 11 09:16 AM quote given Full-Time 3925 Candidate ID :  $ AUD 1350.00</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2011-04-11<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=W3UGGRUDYC5IRY0XFKNIYD6V6AbFMIFY5VM9cKCWZT8Z9' target='_blank' class=''>- 09:16 AM Service Agreement # 1205</a><br></div><div style='margin-bottom:8px;'><div style='margin-bottom:3px;'><b>1 Job Specification Form given</b></div>2011-04-07<br> - 04:23 PM (<img src='../images/action_check.gif' align='absmiddle' /><a class='link15' href='../pdf_report/job_order_form/?ran=X8TJOVA4LPU1KUTZUFCLN0927FXXP9JMEcFSJYIDNRUbX' target='_blank' class=''>#1643 Job Specification Form filled up 18th Jul 11 08:01 AM</a> )<br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
20
<input type='checkbox' onClick='check_val()' name='users' value='5886' >
<div align="center">
<span id="mark_link_5886" class="mark_unmark_link" onclick="mark_unmark_lead(5886)" mode='mark' leads_name="#5886 Anjali  Daryanani">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
5886
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=5886&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Anjali  Daryanani </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">anjali@oneworldyouthproject.org</span><br />
101HOMEPAGEINQUIRY<br />Mobile 202-550-1855</td>

<td class="sorted date_updated" >2012-06-22</td>

<td class="sorted timestamp">
<span >2011-02-14</span>
</td>


<td class="actions">
<div class="identical"></div>
Keep In-Touch<br />
<div align="center">www.remotestaff.biz</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_5886');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_5886" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_5886'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(5886);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_5886');">
</div>
<div id='5886_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
21
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_4826" class="mark_unmark_link" onclick="mark_unmark_lead(4826)" mode='mark' leads_name="#4826 Anne  Villarama">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
4826
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=4826&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Anne  Villarama </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">charisevillarama@gmail.com</span><br />
101AVAILABLESTAFF<br /></td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2010-07-19</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_4826');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_4826" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_4826'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(4826);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_4826');">
</div>
<div id='4826_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
22
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_4814" class="mark_unmark_link" onclick="mark_unmark_lead(4814)" mode='mark' leads_name="#4814 Anne Charuse  Villarama">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
4814
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=4814&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Anne Charuse  Villarama </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">rs.annevillarama@gmail.com</span><br />
101AVAILABLESTAFF<br />Office No. 07162010<br />Mobile 07162010</td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2010-07-16</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>ASL ORDER : NEW!!!<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_4814');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_4814" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_4814'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(4814);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_4814');">
</div>
<div id='4814_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #15</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=19&jr_cat_id=2&jr_list_id=57&gs_job_role_selection_id=15',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">SEM</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=20&jr_cat_id=2&jr_list_id=57&gs_job_role_selection_id=15',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">SEM</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
23
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_4208" class="mark_unmark_link" onclick="mark_unmark_lead(4208)" mode='unmark' leads_name="#4208 Igor  Zvezdakoski">Remove Pin</span>
</div>
<!---->
</td>

<td class="ids">
4208
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=4208&lead_status=Client" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Igor  Zvezdakoski </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">igor@smsc.com.au</span><br />
139sig<br />Office No. 1300 00 SMSC (7672)<br />Mobile 0412 336 425 - David Freeland's mobile number</td>

<td class="sorted date_updated" >2012-12-14</td>

<td class="sorted timestamp">
<span >2010-04-01</span>
</td>


<td class="actions">
<div class="identical"></div>
Client<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">
<img src="./images/pin_red.png" title="Replacement Requests" align="texttop" />
<span>Replacement Requests</span>



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_4208');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_4208" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_4208'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(4208);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_4208');">
</div>
<div id='4208_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=4208',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">04/6/2010  BP : Walter 6/4 LNN and sent email</a></div>
<div>3 <img src='../images/groupofusers16.png' align='absmiddle' border='0' > <a href="javascript:popup_win('../viewClientStaff.php?id=4208',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Active Staff Member(s)</a></div>
<div class='steps_list_section'><div style='margin-bottom:8px;'><b>2 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=XKC8cWPUKC6KGR699UTS8bV661RTK00EKCMJ69BSMH906' target='_blank'> - 7th Apr 10 01:53 PM quote given Full-Time Advanced PHP Developer :  $ AUD 1800.00</a></div><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=HA7EaX0F02LSKOD1Yc8AR5X34ELVCCLVMT6JM7aM9IBV5' target='_blank'> - 12th May 10 03:07 PM quote given Full-Time Technical Support  :  $ AUD 1100.00</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2011-06-17<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=FAF615FcaL6cAaJAaYVAICHTN6C3FC9WMPcOWFOUcVTAS' target='_blank' class=''>- 11:22 AM Service Agreement # 656</a><br></div><div style='margin-bottom:8px;'><b>4 Set-up Fee Tax Invoice(s)</b><br>2010-04-07<br> <a style='color:#6600FF;' href='../pdf_report/spf/?ran=F2BE36LIM66EHJ4563ZPPEPbFF7UE23V4F78LTR6aXKED' target='_blank'> - 11:05 AM # 1619 Set-up Fee Invoice  <img src='../images/action_check.gif' align='absmiddle' border=0 /> Paid . ( 8th Apr 10 09:57 AM )</a><br>2010-05-12<br> <a style='color:#6600FF;' href='../pdf_report/spf/?ran=FH0P7ZEPLPMcN9UXELE3YT4249URESIV6JIEGX1cKOc5Z' target='_blank'> - 03:07 PM # 1696 Set-up Fee Invoice </a><br>2010-05-27<br> <a style='color:#6600FF;' href='../pdf_report/spf/?ran=ZIAXN009A16DRJZA3OKZbIKK5W3c8bR5Gbc1b0B91HNSc' target='_blank'> - 11:19 AM # 1720 Set-up Fee Invoice  <img src='../images/action_check.gif' align='absmiddle' border=0 /> Paid . ( 10th Jun 10 10:39 AM )</a><br>2010-05-31<br> <a style='color:#6600FF;' href='../pdf_report/spf/?ran=EWROPRU34GR8aWG6G7AVWORS2XbZG8GV14HSV8VaPI6MB' target='_blank'> - 01:10 PM # 1727 Set-up Fee Invoice  <img src='../images/action_check.gif' align='absmiddle' border=0 /> Paid . ( 10th Jun 10 10:39 AM )</a><br></div><div style='margin-bottom:8px;'><div style='margin-bottom:3px;'><b>3 Job Specification Form given</b></div>2010-04-06<br> - 01:26 PM (<img src='../images/action_check.gif' align='absmiddle' /><a class='link15' href='../pdf_report/job_order_form/?ran=ZOU3LI743212caE2JKKcUP2KBGAbKUBHG3KcMT4RV5TU3' target='_blank' class=''>#1008 Job Specification Form filled up 12th Apr 10 09:38 AM</a> )<br><b>2010-05-12</b> - 03:07 PM (<img src='../images/action_check.gif' align='absmiddle' /><a class='link15' href='../pdf_report/job_order_form/?ran=7cCFZAYXLc3D4a6AKZUO8KPccP8HAAYIA7Y6HT00S4EW1' target='_blank' class=''>#1093 Job Specification Form filled up 17th May 10 05:36 PM</a> )<br><b>2010-05-25</b> - 03:46 PM (<img src='../images/action_check.gif' align='absmiddle' /><a class='link15' href='../pdf_report/job_order_form/?ran=33LWM4YEa3OZ1bUTCWPMXWa4OPSEKUYNYHHILCXJGJGHI' target='_blank' class=''>#1123 Job Specification Form filled up 27th May 10 11:59 AM</a> )<br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
24
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_3223" class="mark_unmark_link" onclick="mark_unmark_lead(3223)" mode='mark' leads_name="#3223 TESTNormaneil  TEST ACCOUNT">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
3223
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=3223&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">TESTNormaneil  TEST ACCOUNT </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">normaneil.macutay@gmail.com</span><br />
123Test<br />Office No. 123<br />Mobile 123 / 456 / 456</td>

<td class="sorted date_updated" >2012-09-25</td>

<td class="sorted timestamp">
<span >2009-11-23</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>ASL ORDER : NEW!!!<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_3223');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_3223" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_3223'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(3223);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_3223');">
</div>
<div id='3223_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
25
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_1454" class="mark_unmark_link" onclick="mark_unmark_lead(1454)" mode='mark' leads_name="#1454 Nick  Bell">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
1454
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=1454&lead_status=Client" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Nick  Bell </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">nick@webmarketingexperts.com.au</span><br />
101OUTBOUNDCALL<br />Office No.  61 3 9600 1008<br />Mobile  61 420 244 738</td>

<td class="sorted date_updated" >2012-09-25</td>

<td class="sorted timestamp">
<span >2009-02-27</span>
</td>


<td class="actions">
<div class="identical"></div>
Client<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_1454');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_1454" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_1454'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(1454);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_1454');">
</div>
<div id='1454_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=1454',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/16/2009  ADMIN : Rica Endorsed 4, he didnt like the first 2., Has not responded on the </a></div>
<div></div>
<div class='steps_list_section'><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=R80Uc8HXGH9IMLSCZY6UH3UI2OOaVZRJ5SA4aTcE78YUV' target='_blank'> - 15th Sep 09 07:42 PM quote given  Content Writer :  $ AUD 1200.00</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2009-09-15<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=ObXacFM7HD1PUU3bPNUURXY5VWZHIV85T22TIPba0cNVU' target='_blank' class=''>- 07:42 PM Service Agreement # 262</a><br></div><div style='margin-bottom:8px;'><b>1 Set-up Fee Tax Invoice(s)</b><br>2009-09-15<br> <a style='color:#6600FF;' href='../pdf_report/spf/?ran=MSL2XUIKK3K35EF8a9XOK449Y9URW2VGVDIO5c7P2ST74' target='_blank'> - 07:42 PM # 1258 Set-up Fee Invoice  <img src='../images/action_check.gif' align='absmiddle' border=0 /> Paid . ( 21st Sep 09 03:21 PM )</a><br></div><div style='margin-bottom:8px;'><div style='margin-bottom:3px;'><b>2 Job Specification Form given</b></div>2009-09-14<br> - 04:00 PM<br><b>2009-09-15</b> - 03:49 PM (<img src='../images/action_check.gif' align='absmiddle' /><a class='link15' href='../pdf_report/job_order_form/?ran=4cU4KUDJGFOD5Kb8bWT4ECRZPUACLEVRDMVYD6FVL25SM' target='_blank' class=''>#235 Job Specification Form filled up 15th Sep 09 03:57 PM</a> )<br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
26
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_45" class="mark_unmark_link" onclick="mark_unmark_lead(45)" mode='mark' leads_name="#45 Christine TEST   Test">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
45
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=45&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Christine TEST   Test </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">chrisjchrisj@yahoo.com</span><br />
100christine<br />Mobile 000000000</td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2008-06-23</span>
</td>


<td class="actions">
<div class="identical"></div>
<img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><br />REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_45');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_45" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_45'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(45);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_45');">
</div>
<div id='45_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #79</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=110&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=79',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div><div><strong>Custom Recruitment Order #370</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=340&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=370',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=341&jr_cat_id=2&jr_list_id=85&gs_job_role_selection_id=370',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Flash Designer</a></li></ol></div></div>
</div>
</td>
</tr>
</tbody>
</table>

</div>

<div style="clear:both;background:#BBCCFF; height:20px;">&nbsp;</div>

<div class="list_list_holder">

<span><a name="UNMARKED">UNMARKED LEADS</a> [ 7041 Records ] <select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'  >
<option value="1"  selected="selected" >Page 1</option>
<option value="2" >Page 2</option>
<option value="3" >Page 3</option>
<option value="4" >Page 4</option>
<option value="5" >Page 5</option>
<option value="6" >Page 6</option>
<option value="7" >Page 7</option>
<option value="8" >Page 8</option>
<option value="9" >Page 9</option>
<option value="10" >Page 10</option>
<option value="11" >Page 11</option>
<option value="12" >Page 12</option>
<option value="13" >Page 13</option>
<option value="14" >Page 14</option>
<option value="15" >Page 15</option>
<option value="16" >Page 16</option>
<option value="17" >Page 17</option>
<option value="18" >Page 18</option>
<option value="19" >Page 19</option>
<option value="20" >Page 20</option>
<option value="21" >Page 21</option>
<option value="22" >Page 22</option>
<option value="23" >Page 23</option>
<option value="24" >Page 24</option>
<option value="25" >Page 25</option>
<option value="26" >Page 26</option>
<option value="27" >Page 27</option>
<option value="28" >Page 28</option>
<option value="29" >Page 29</option>
<option value="30" >Page 30</option>
<option value="31" >Page 31</option>
<option value="32" >Page 32</option>
<option value="33" >Page 33</option>
<option value="34" >Page 34</option>
<option value="35" >Page 35</option>
<option value="36" >Page 36</option>
<option value="37" >Page 37</option>
<option value="38" >Page 38</option>
<option value="39" >Page 39</option>
<option value="40" >Page 40</option>
<option value="41" >Page 41</option>
<option value="42" >Page 42</option>
<option value="43" >Page 43</option>
<option value="44" >Page 44</option>
<option value="45" >Page 45</option>
<option value="46" >Page 46</option>
<option value="47" >Page 47</option>
<option value="48" >Page 48</option>
<option value="49" >Page 49</option>
<option value="50" >Page 50</option>
<option value="51" >Page 51</option>
<option value="52" >Page 52</option>
<option value="53" >Page 53</option>
<option value="54" >Page 54</option>
<option value="55" >Page 55</option>
<option value="56" >Page 56</option>
<option value="57" >Page 57</option>
<option value="58" >Page 58</option>
<option value="59" >Page 59</option>
<option value="60" >Page 60</option>
<option value="61" >Page 61</option>
<option value="62" >Page 62</option>
<option value="63" >Page 63</option>
<option value="64" >Page 64</option>
<option value="65" >Page 65</option>
<option value="66" >Page 66</option>
<option value="67" >Page 67</option>
<option value="68" >Page 68</option>
<option value="69" >Page 69</option>
<option value="70" >Page 70</option>
<option value="71" >Page 71</option>
<option value="72" >Page 72</option>
<option value="73" >Page 73</option>
<option value="74" >Page 74</option>
<option value="75" >Page 75</option>
<option value="76" >Page 76</option>
<option value="77" >Page 77</option>
<option value="78" >Page 78</option>
<option value="79" >Page 79</option>
<option value="80" >Page 80</option>
<option value="81" >Page 81</option>
<option value="82" >Page 82</option>
<option value="83" >Page 83</option>
<option value="84" >Page 84</option>
<option value="85" >Page 85</option>
<option value="86" >Page 86</option>
<option value="87" >Page 87</option>
<option value="88" >Page 88</option>
<option value="89" >Page 89</option>
<option value="90" >Page 90</option>
<option value="91" >Page 91</option>
<option value="92" >Page 92</option>
<option value="93" >Page 93</option>
<option value="94" >Page 94</option>
<option value="95" >Page 95</option>
<option value="96" >Page 96</option>
<option value="97" >Page 97</option>
<option value="98" >Page 98</option>
<option value="99" >Page 99</option>
<option value="100" >Page 100</option>
<option value="101" >Page 101</option>
<option value="102" >Page 102</option>
<option value="103" >Page 103</option>
<option value="104" >Page 104</option>
<option value="105" >Page 105</option>
<option value="106" >Page 106</option>
<option value="107" >Page 107</option>
<option value="108" >Page 108</option>
<option value="109" >Page 109</option>
<option value="110" >Page 110</option>
<option value="111" >Page 111</option>
<option value="112" >Page 112</option>
<option value="113" >Page 113</option>
<option value="114" >Page 114</option>
<option value="115" >Page 115</option>
<option value="116" >Page 116</option>
<option value="117" >Page 117</option>
<option value="118" >Page 118</option>
<option value="119" >Page 119</option>
<option value="120" >Page 120</option>
<option value="121" >Page 121</option>
<option value="122" >Page 122</option>
<option value="123" >Page 123</option>
<option value="124" >Page 124</option>
<option value="125" >Page 125</option>
<option value="126" >Page 126</option>
<option value="127" >Page 127</option>
<option value="128" >Page 128</option>
<option value="129" >Page 129</option>
<option value="130" >Page 130</option>
<option value="131" >Page 131</option>
<option value="132" >Page 132</option>
<option value="133" >Page 133</option>
<option value="134" >Page 134</option>
<option value="135" >Page 135</option>
<option value="136" >Page 136</option>
<option value="137" >Page 137</option>
<option value="138" >Page 138</option>
<option value="139" >Page 139</option>
<option value="140" >Page 140</option>
<option value="141" >Page 141</option>
<option value="142" >Page 142</option>
<option value="143" >Page 143</option>
<option value="144" >Page 144</option>
<option value="145" >Page 145</option>
<option value="146" >Page 146</option>
<option value="147" >Page 147</option>
<option value="148" >Page 148</option>
<option value="149" >Page 149</option>
<option value="150" >Page 150</option>
<option value="151" >Page 151</option>
<option value="152" >Page 152</option>
<option value="153" >Page 153</option>
<option value="154" >Page 154</option>
<option value="155" >Page 155</option>
<option value="156" >Page 156</option>
<option value="157" >Page 157</option>
<option value="158" >Page 158</option>
<option value="159" >Page 159</option>
<option value="160" >Page 160</option>
<option value="161" >Page 161</option>
<option value="162" >Page 162</option>
<option value="163" >Page 163</option>
<option value="164" >Page 164</option>
<option value="165" >Page 165</option>
<option value="166" >Page 166</option>
<option value="167" >Page 167</option>
<option value="168" >Page 168</option>
<option value="169" >Page 169</option>
<option value="170" >Page 170</option>
<option value="171" >Page 171</option>
<option value="172" >Page 172</option>
<option value="173" >Page 173</option>
<option value="174" >Page 174</option>
<option value="175" >Page 175</option>
<option value="176" >Page 176</option>
<option value="177" >Page 177</option>
<option value="178" >Page 178</option>
<option value="179" >Page 179</option>
<option value="180" >Page 180</option>
<option value="181" >Page 181</option>
<option value="182" >Page 182</option>
<option value="183" >Page 183</option>
<option value="184" >Page 184</option>
<option value="185" >Page 185</option>
<option value="186" >Page 186</option>
<option value="187" >Page 187</option>
<option value="188" >Page 188</option>
<option value="189" >Page 189</option>
<option value="190" >Page 190</option>
<option value="191" >Page 191</option>
<option value="192" >Page 192</option>
<option value="193" >Page 193</option>
<option value="194" >Page 194</option>
<option value="195" >Page 195</option>
<option value="196" >Page 196</option>
<option value="197" >Page 197</option>
<option value="198" >Page 198</option>
<option value="199" >Page 199</option>
<option value="200" >Page 200</option>
<option value="201" >Page 201</option>
<option value="202" >Page 202</option>
<option value="203" >Page 203</option>
<option value="204" >Page 204</option>
<option value="205" >Page 205</option>
<option value="206" >Page 206</option>
<option value="207" >Page 207</option>
<option value="208" >Page 208</option>
<option value="209" >Page 209</option>
<option value="210" >Page 210</option>
<option value="211" >Page 211</option>
<option value="212" >Page 212</option>
<option value="213" >Page 213</option>
<option value="214" >Page 214</option>
<option value="215" >Page 215</option>
<option value="216" >Page 216</option>
<option value="217" >Page 217</option>
<option value="218" >Page 218</option>
<option value="219" >Page 219</option>
<option value="220" >Page 220</option>
<option value="221" >Page 221</option>
<option value="222" >Page 222</option>
<option value="223" >Page 223</option>
<option value="224" >Page 224</option>
<option value="225" >Page 225</option>
<option value="226" >Page 226</option>
<option value="227" >Page 227</option>
<option value="228" >Page 228</option>
<option value="229" >Page 229</option>
<option value="230" >Page 230</option>
<option value="231" >Page 231</option>
<option value="232" >Page 232</option>
<option value="233" >Page 233</option>
<option value="234" >Page 234</option>
<option value="235" >Page 235</option>
<option value="236" >Page 236</option>
<option value="237" >Page 237</option>
<option value="238" >Page 238</option>
<option value="239" >Page 239</option>
<option value="240" >Page 240</option>
<option value="241" >Page 241</option>
<option value="242" >Page 242</option>
<option value="243" >Page 243</option>
<option value="244" >Page 244</option>
<option value="245" >Page 245</option>
<option value="246" >Page 246</option>
<option value="247" >Page 247</option>
<option value="248" >Page 248</option>
<option value="249" >Page 249</option>
<option value="250" >Page 250</option>
<option value="251" >Page 251</option>
<option value="252" >Page 252</option>
<option value="253" >Page 253</option>
<option value="254" >Page 254</option>
<option value="255" >Page 255</option>
<option value="256" >Page 256</option>
<option value="257" >Page 257</option>
<option value="258" >Page 258</option>
<option value="259" >Page 259</option>
<option value="260" >Page 260</option>
<option value="261" >Page 261</option>
<option value="262" >Page 262</option>
<option value="263" >Page 263</option>
<option value="264" >Page 264</option>
<option value="265" >Page 265</option>
<option value="266" >Page 266</option>
<option value="267" >Page 267</option>
<option value="268" >Page 268</option>
<option value="269" >Page 269</option>
<option value="270" >Page 270</option>
<option value="271" >Page 271</option>
<option value="272" >Page 272</option>
<option value="273" >Page 273</option>
<option value="274" >Page 274</option>
<option value="275" >Page 275</option>
<option value="276" >Page 276</option>
<option value="277" >Page 277</option>
<option value="278" >Page 278</option>
<option value="279" >Page 279</option>
<option value="280" >Page 280</option>
<option value="281" >Page 281</option>
<option value="282" >Page 282</option>
<option value="283" >Page 283</option>
<option value="284" >Page 284</option>
<option value="285" >Page 285</option>
<option value="286" >Page 286</option>
<option value="287" >Page 287</option>
<option value="288" >Page 288</option>
<option value="289" >Page 289</option>
<option value="290" >Page 290</option>
<option value="291" >Page 291</option>
<option value="292" >Page 292</option>
<option value="293" >Page 293</option>
<option value="294" >Page 294</option>
<option value="295" >Page 295</option>
<option value="296" >Page 296</option>
<option value="297" >Page 297</option>
<option value="298" >Page 298</option>
<option value="299" >Page 299</option>
<option value="300" >Page 300</option>
<option value="301" >Page 301</option>
<option value="302" >Page 302</option>
<option value="303" >Page 303</option>
<option value="304" >Page 304</option>
<option value="305" >Page 305</option>
<option value="306" >Page 306</option>
<option value="307" >Page 307</option>
<option value="308" >Page 308</option>
<option value="309" >Page 309</option>
<option value="310" >Page 310</option>
<option value="311" >Page 311</option>
<option value="312" >Page 312</option>
<option value="313" >Page 313</option>
<option value="314" >Page 314</option>
<option value="315" >Page 315</option>
<option value="316" >Page 316</option>
<option value="317" >Page 317</option>
<option value="318" >Page 318</option>
<option value="319" >Page 319</option>
<option value="320" >Page 320</option>
<option value="321" >Page 321</option>
<option value="322" >Page 322</option>
<option value="323" >Page 323</option>
<option value="324" >Page 324</option>
<option value="325" >Page 325</option>
<option value="326" >Page 326</option>
<option value="327" >Page 327</option>
<option value="328" >Page 328</option>
<option value="329" >Page 329</option>
<option value="330" >Page 330</option>
<option value="331" >Page 331</option>
<option value="332" >Page 332</option>
<option value="333" >Page 333</option>
<option value="334" >Page 334</option>
<option value="335" >Page 335</option>
<option value="336" >Page 336</option>
<option value="337" >Page 337</option>
<option value="338" >Page 338</option>
<option value="339" >Page 339</option>
<option value="340" >Page 340</option>
<option value="341" >Page 341</option>
<option value="342" >Page 342</option>
<option value="343" >Page 343</option>
<option value="344" >Page 344</option>
<option value="345" >Page 345</option>
<option value="346" >Page 346</option>
<option value="347" >Page 347</option>
<option value="348" >Page 348</option>
<option value="349" >Page 349</option>
<option value="350" >Page 350</option>
<option value="351" >Page 351</option>
<option value="352" >Page 352</option>
<option value="353" >Page 353</option>
</select>
</span>


</div>
<table id="leads_list_tb" class="leads_list" width="100%" cellpadding="0" cellspacing="1" bgcolor="#cccccc" >

<thead>
<tr >
<th class="sort" mochi:format="number" style="cursor:pointer;">#</th>
<th>ID</th>
<th class="sort" mochi:format="str" style="cursor:pointer;">NAME</th>
<th >INFO</th>
<th class="sort" mochi:format="isodate" style="cursor:pointer;">DATE UPDATED</th>
<th class="sort" mochi:format="isodate" style="cursor:pointer;">REGISTERED DATE</th>
<th >&nbsp;</th>
<th >&nbsp;</th>
</tr>
</thead>
<tfoot class="invisible">
<tr>
<td colspan="0"></td>
</tr>
</tfoot>
<tbody>
<tr bgcolor="#ffffff">



<td class="sorted item" >
1
<input type='checkbox' onClick='check_val()' name='users' value='8824' >
<div align="center">
<span id="mark_link_8824" class="mark_unmark_link" onclick="mark_unmark_lead(8824)" mode='mark' leads_name="#8824 Lex  Stewart">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8824
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8824&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lex  Stewart </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">lex@lexstewart.com</span><br />
139INBOUNDCALL<br />Mobile 0407 738 714</td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-19</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8824');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8824" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8824'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8824);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8824');">
</div>
<div id='8824_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8824',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/19/2012  BP : Walter Assisting Angela Elia</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='8823' >
<div align="center">
<span id="mark_link_8823" class="mark_unmark_link" onclick="mark_unmark_lead(8823)" mode='mark' leads_name="#8823 Analiza  Consimino">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8823
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8823&lead_status=Inactive" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Analiza  Consimino </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">amaliaconsimino@yahoo.com</span><br />
101<br />Mobile 09323320188</td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-18</span>
</td>


<td class="actions">
<div class="identical"></div>
Inactive<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8823');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8823" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8823'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8823);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8823');">
</div>
<div id='8823_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8823',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/19/2012  BP : Walter possible job seeker</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='8822' >
<div align="center">
<span id="mark_link_8822" class="mark_unmark_link" onclick="mark_unmark_lead(8822)" mode='mark' leads_name="#8822 Katherine  Watkins">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8822
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8822&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Katherine  Watkins </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">katherinehelenwatkins@gmail.com</span><br />
101<br />Mobile 0405 442 493</td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-18</span>
</td>


<td class="actions">
<div class="identical"></div>
New Leads<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8822');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8822" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8822'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8822);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8822');">
</div>
<div id='8822_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8822',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/19/2012  BP : Walter APT set for Thur 27 at 3 pm to meet</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_8821" class="mark_unmark_link" onclick="mark_unmark_lead(8821)" mode='mark' leads_name="#8821 Troy  Eadie">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8821
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8821&lead_status=REMOVED" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Troy  Eadie </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">troy@businesssuccesssystems.com.au.MERGED</span><br />
139INBOUNDCALL<br />Office No. 0433 223 855<br /></td>

<td class="sorted date_updated" >2012-12-18</td>

<td class="sorted timestamp">
<span >2012-12-18</span>
</td>


<td class="actions">
<div class="identical"></div>
REMOVED<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8821');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8821" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8821'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8821);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8821');">
</div>
<div id='8821_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
5
<input type='checkbox' onClick='check_val()' name='users' value='8820' >
<div align="center">
<span id="mark_link_8820" class="mark_unmark_link" onclick="mark_unmark_lead(8820)" mode='mark' leads_name="#8820 Lucas  Meadowcroft">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8820
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8820&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lucas  Meadowcroft </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">lucas@tse.com.au</span><br />
139LiveChatRS<br />Mobile 0410 414 828</td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-18</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8820');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8820" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8820'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8820);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8820');">
</div>
<div id='8820_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8820',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/19/2012  BP : Walter Have asked Simon to source some candidates</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
6
<input type='checkbox' onClick='check_val()' name='users' value='8819' >
<div align="center">
<span id="mark_link_8819" class="mark_unmark_link" onclick="mark_unmark_lead(8819)" mode='mark' leads_name="#8819 Peter  Ryan">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8819
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8819&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Peter  Ryan </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">pete@mrresults.com.au</span><br />
101<br />Mobile 0418 122 619</td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-18</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>CUSTOM ORDER : NEW!!!<br></div></div>
<!--
<div>
 <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p></div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8819');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8819" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8819'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8819);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8819');">
</div>
<div id='8819_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8819',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/18/2012  BP : Walter Job start Michelle</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1844</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1362&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=1844',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
7
<input type='checkbox' onClick='check_val()' name='users' value='8818' >
<div align="center">
<span id="mark_link_8818" class="mark_unmark_link" onclick="mark_unmark_lead(8818)" mode='mark' leads_name="#8818 Pearl  Heke">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8818
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8818&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Pearl  Heke </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">pearlheke@bigpond.com</span><br />
101HOMEPAGEENQUIRY<br />Mobile 0477 196 409</td>

<td class="sorted date_updated" >2012-12-18</td>

<td class="sorted timestamp">
<span >2012-12-16</span>
</td>


<td class="actions">
<div class="identical"></div>
Keep In-Touch<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8818');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8818" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8818'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8818);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8818');">
</div>
<div id='8818_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8818',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/18/2012  BP : Walter maybe not enough work</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
8
<input type='checkbox' onClick='check_val()' name='users' value='8817' >
<div align="center">
<span id="mark_link_8817" class="mark_unmark_link" onclick="mark_unmark_lead(8817)" mode='mark' leads_name="#8817 Roupen  Egulian">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8817
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8817&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Roupen  Egulian </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">roupen@atccorp.biz</span><br />
101HOMEPAGEENQUIRY<br />Office No. 02 9017 6780<br /></td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-15</span>
</td>


<td class="actions">
<div class="identical"></div>
New Leads<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8817');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8817" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8817'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8817);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8817');">
</div>
<div id='8817_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8817',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/19/2012  BP : Walter LNN</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
9
<input type='checkbox' onClick='check_val()' name='users' value='8816' >
<div align="center">
<span id="mark_link_8816" class="mark_unmark_link" onclick="mark_unmark_lead(8816)" mode='mark' leads_name="#8816 Ahmad  Abu Yahia">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8816
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8816&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Ahmad  Abu Yahia </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ahmadabuyhya@yahoo.com</span><br />
101<br />Mobile 0403384659</td>

<td class="sorted date_updated" >2012-12-17</td>

<td class="sorted timestamp">
<span >2012-12-14</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
 <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p></div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8816');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8816" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8816'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8816);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8816');">
</div>
<div id='8816_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1840</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1359&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=1840',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
10
<input type='checkbox' onClick='check_val()' name='users' value='8815' >
<div align="center">
<span id="mark_link_8815" class="mark_unmark_link" onclick="mark_unmark_lead(8815)" mode='mark' leads_name="#8815 Mathew  Smith">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8815
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8815&lead_status=asl" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Mathew  Smith </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">matt@mercatorium.com.au</span><br />
101<br />Office No. 0419955730<br />Mobile 0419955730</td>

<td class="sorted date_updated" >2012-12-18</td>

<td class="sorted timestamp">
<span >2012-12-14</span>
</td>


<td class="actions">
<div class="identical"></div>
asl<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>ASL ORDER : NEW!!!<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8815');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8815" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8815'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8815);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8815');">
</div>
<div id='8815_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
11
<input type='checkbox' onClick='check_val()' name='users' value='8813' >
<div align="center">
<span id="mark_link_8813" class="mark_unmark_link" onclick="mark_unmark_lead(8813)" mode='mark' leads_name="#8813 Keenan  Vidler">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8813
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8813&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Keenan  Vidler </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">keenan@pgl.com.au</span><br />
101INBOUNDCALL<br />Office No. 2 93172749<br />Mobile (0)416 259 002</td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-14</span>
</td>


<td class="actions">
<div class="identical"></div>
New Leads<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
 <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p></div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8813');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8813" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8813'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8813);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8813');">
</div>
<div id='8813_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8813',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/17/2012  BP : Walter job start Simon</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1836</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1360&jr_cat_id=4&jr_list_id=186&gs_job_role_selection_id=1836',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Customer Service</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
12
<input type='checkbox' onClick='check_val()' name='users' value='8812' >
<div align="center">
<span id="mark_link_8812" class="mark_unmark_link" onclick="mark_unmark_lead(8812)" mode='mark' leads_name="#8812 Scott  Dunlop">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8812
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8812&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Scott  Dunlop </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">scott.dunlop@sunacommunications.com</span><br />
101<br />Office No. 07 3841 7111<br /></td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-14</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8812');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8812" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8812'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8812);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8812');">
</div>
<div id='8812_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8812',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/19/2012  BP : Walter LNN and sent call me email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
13
<input type='checkbox' onClick='check_val()' name='users' value='8811' >
<div align="center">
<span id="mark_link_8811" class="mark_unmark_link" onclick="mark_unmark_lead(8811)" mode='mark' leads_name="#8811 Ben  Porter">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8811
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8811&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Ben  Porter </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ben@cre8ive.co</span><br />
139WalterLeads<br /></td>

<td class="sorted date_updated" >2012-12-14</td>

<td class="sorted timestamp">
<span >2012-12-13</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8811');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8811" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8811'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8811);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8811');">
</div>
<div id='8811_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8811',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/13/2012  BP : Walter reconnect in mid jan</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
14
<input type='checkbox' onClick='check_val()' name='users' value='8810' >
<div align="center">
<span id="mark_link_8810" class="mark_unmark_link" onclick="mark_unmark_lead(8810)" mode='mark' leads_name="#8810 Esther  Nilson">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8810
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8810&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Esther  Nilson </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">esther@rentwest.com.au</span><br />
139ClientReferral<br />Office No. 08 9314 9888<br />Mobile 0420 847 667</td>

<td class="sorted date_updated" >2012-12-13</td>

<td class="sorted timestamp">
<span >2012-12-12</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8810');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8810" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8810'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8810);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8810');">
</div>
<div id='8810_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8810',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/12/2012  BP : Walter job start Simon</a></div>
<div></div>
<div class='steps_list_section'><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=aHH678C87CV4TaFF77Ca6aOVJP1PZMLc631S9CLA9ZH6N' target='_blank'> - 12th Dec 12 02:19 PM quote given Part-Time Virtual Assistant  :  $ AUD 469.51</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2012-12-12<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=M7Tb0WEObL6WEBU1FLT94XT46LJLSWPY9CY5WC55588C0' target='_blank' class=''>- 02:19 PM Service Agreement # 2030</a><br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
15
<input type='checkbox' onClick='check_val()' name='users' value='8809' >
<div align="center">
<span id="mark_link_8809" class="mark_unmark_link" onclick="mark_unmark_lead(8809)" mode='mark' leads_name="#8809 Julian  Smith">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8809
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8809&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Julian  Smith </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">jsmith@telefieldsales.com.au</span><br />
139WalterLeads<br />Office No. 03 9329 7773<br />Mobile 0434 724 511</td>

<td class="sorted date_updated" >2012-12-12</td>

<td class="sorted timestamp">
<span >2012-12-12</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8809');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8809" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8809'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8809);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8809');">
</div>
<div id='8809_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8809',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/12/2012  BP : Walter reviewing options</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
16
<input type='checkbox' disabled="disabled" >
<div align="center">
<span id="mark_link_8808" class="mark_unmark_link" onclick="mark_unmark_lead(8808)" mode='mark' leads_name="#8808 Mark  Van Der Meulen">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8808
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8808&lead_status=Client" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Mark  Van Der Meulen </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">mark@fivenynes.com</span><br />
101INBOUNDCALL<br />Office No. 02 8355 6787<br /></td>

<td class="sorted date_updated" >2012-12-18</td>

<td class="sorted timestamp">
<span >2012-12-12</span>
</td>


<td class="actions">
<div class="identical"></div>
Client<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
 <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p></div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8808');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8808" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8808'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8808);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8808');">
</div>
<div id='8808_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1827</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1351&jr_cat_id=4&jr_list_id=201&gs_job_role_selection_id=1827',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Technical Support</a></li></ol></div><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=aH0XD4YOWK3FUL70694F2BEZEENEE2GYMRScOOKYXMUFW' target='_blank'> - 17th Dec 12 07:08 AM quote given Full-Time Tech Support | Help Desk :  $ AUD 1302.44</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2012-12-17<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=TTM041DJCDRYbc9UCYA1R9ZVcP8RG4EL0NI8RNFONI558' target='_blank' class=''>- 07:08 AM Service Agreement # 2032</a><br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
17
<input type='checkbox' onClick='check_val()' name='users' value='8807' >
<div align="center">
<span id="mark_link_8807" class="mark_unmark_link" onclick="mark_unmark_lead(8807)" mode='mark' leads_name="#8807 Emma  Perrow">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8807
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8807&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Emma  Perrow </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">emmaperrow@gmail.com</span><br />
101<br />Mobile 0406 940 780</td>

<td class="sorted date_updated" >2012-12-13</td>

<td class="sorted timestamp">
<span >2012-12-12</span>
</td>


<td class="actions">
<div class="identical"></div>
Keep In-Touch<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8807');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8807" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8807'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8807);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8807');">
</div>
<div id='8807_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8807',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/13/2012  BP : Walter one off req</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
18
<input type='checkbox' onClick='check_val()' name='users' value='8806' >
<div align="center">
<span id="mark_link_8806" class="mark_unmark_link" onclick="mark_unmark_lead(8806)" mode='mark' leads_name="#8806 Marlene  Eadie">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8806
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8806&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marlene  Eadie </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">marlene@platinumbookkeepingplus.com.au</span><br />
101HOMEPAGEENQUIRY<br />Mobile 0433 102 283</td>

<td class="sorted date_updated" >2012-12-12</td>

<td class="sorted timestamp">
<span >2012-12-12</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8806');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8806" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8806'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8806);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8806');">
</div>
<div id='8806_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8806',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/12/2012  BP : Walter Not enough work yet</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
19
<input type='checkbox' onClick='check_val()' name='users' value='8805' >
<div align="center">
<span id="mark_link_8805" class="mark_unmark_link" onclick="mark_unmark_lead(8805)" mode='mark' leads_name="#8805 Troy  Eadie">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8805
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8805&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Troy  Eadie </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">troy@businesssuccesssystems.com.au</span><br />
101HOMEPAGEENQUIRY<br />Mobile 0433 223 855</td>

<td class="sorted date_updated" >2012-12-19</td>

<td class="sorted timestamp">
<span >2012-12-12</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8805');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8805" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8805'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8805);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8805');">
</div>
<div id='8805_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8805',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/19/2012  BP : Walter call back Feb 2013</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1826</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1350&jr_cat_id=1&jr_list_id=1&gs_job_role_selection_id=1826',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
20
<input type='checkbox' onClick='check_val()' name='users' value='8804' >
<div align="center">
<span id="mark_link_8804" class="mark_unmark_link" onclick="mark_unmark_lead(8804)" mode='mark' leads_name="#8804 Steve  Saad">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8804
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8804&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Steve  Saad </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ssaad@tigerit.com.au</span><br />
139ClientReferral<br />Office No. 02 8019 7243<br />Mobile 0410 655 039</td>

<td class="sorted date_updated" >2012-12-11</td>

<td class="sorted timestamp">
<span >2012-12-11</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
<div align="center">www.remotestaff.com.au</div>
<div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8804');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8804" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8804'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8804);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8804');">
</div>
<div id='8804_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8804',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">12/11/2012  BP : Walter will be submitting js form</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1822</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1345&jr_cat_id=1&jr_list_id=1&gs_job_role_selection_id=1822',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>



<script src="./media/js/sortable_tables.js"></script>
<script src="./media/js/sortable_tables2.js"></script>
<script>
CheckFocus();
if($('marked_leads_list_tb')){
    sortableManager2.initWithTable('marked_leads_list_tb');
}
sortableManager.initWithTable('leads_list_tb');
connect('search', 'onclick', ClearQueryString);
</script>

</form>
<!-- Content Ends Here -->
</div>
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/script.js"></script>
<script type="text/javascript" language="javascript" src="/portal/bubblehelp/js/pullmenu.js"></script>
</body>
</html>