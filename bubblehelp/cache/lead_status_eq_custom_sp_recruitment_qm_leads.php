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
												            												            												            							<a href="index.php?lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" id="navselected">Custom Recruitment</a>
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
<input type="hidden" name="path" id="path" value="lead_status=custom recruitment" />
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
		        	    <option value="custom recruitment" selected="selected">Custom Recruitment</option>
		        	    <option value="Interview Bookings" >Interview Bookings</option>
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
          <option value="6"  >Rica Gil</option>
          <option value="16"  >PJ Boromeo</option>
          <option value="83"  >Michelle Borras</option>
          <option value="92"  >Ryan  Torres</option>
          <option value="134"  >Former  Hiring Managers </option>
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
	    <input type="submit" name="transfer" id="transfer" disabled="disabled" value="Tranfer to" onClick="return CheckBP();"  class="button"> <select name="agent_id" id="agent_id" style="width:200px;" disabled="disabled" >
<option value="">Business Developer</option>
<option value='2'>Chris Jankulovski</option><option value='44'>Walter Fulmizi</option><option value='343'>Michael Burns</option><option value='402'>Kenneth Tubio</option><option value='426'>Rendall Young</option>
</select>
</p>
</fieldset></div>
<br clear="all" />
<h2 align="center">
    custom recruitment
</h2>

<p align="center">There are <strong>0</strong> <span style="text-transform:capitalize;">custom recruitment</span> today October  4, 2012








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
<th >1 Marked leads found..</th>
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
<input type='checkbox' onClick='check_val()' name='users' value='8479' >
<div align="center">
<span id="mark_link_8479" class="mark_unmark_link" onclick="mark_unmark_lead(8479)" mode='mark' leads_name="#8479 Richard  Martinez">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
8479
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8479&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Richard  Martinez </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">seniorleads@live.com</span><br />
101RECRUITMENTSERVICE<br />Office No. 602-288-9092<br />Mobile 602-769-8852</td>

<td class="sorted date_updated" >2012-09-02</td>

<td class="sorted timestamp">
<span >2012-09-02</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8479');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8479" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8479'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8479);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8479');">
</div>
<div id='8479_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1334</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=993&jr_cat_id=1&jr_list_id=12&gs_job_role_selection_id=1334',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div></div>
</div>
</td>
</tr>
</tbody>
</table>

</div>

<div style="clear:both;background:#BBCCFF; height:20px;">&nbsp;</div>

<div class="list_list_holder">

<span><a name="UNMARKED">UNMARKED LEADS</a> [ 81 Records ] <select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'  >
<option value="1"  selected="selected" >Page 1</option>
<option value="2" >Page 2</option>
<option value="3" >Page 3</option>
<option value="4" >Page 4</option>
<option value="5" >Page 5</option>
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
<input type='checkbox' onClick='check_val()' name='users' value='8583' >
<div align="center">
<span id="mark_link_8583" class="mark_unmark_link" onclick="mark_unmark_lead(8583)" mode='mark' leads_name="#8583 Rina Diza  Montecillo">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8583
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8583&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Rina Diza  Montecillo </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">mrinadiza@yahoo.com</span><br />
101RECRUITMENTSERVICE<br />Office No. 639164313999<br />Mobile 639164313999</td>

<td class="sorted date_updated" ></td>

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
<div align='right' ><a href="javascript: toggle('note_form_8583');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8583" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8583'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8583);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8583');">
</div>
<div id='8583_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='8579' >
<div align="center">
<span id="mark_link_8579" class="mark_unmark_link" onclick="mark_unmark_lead(8579)" mode='mark' leads_name="#8579 Alex  Cleanthous">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8579
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8579&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Alex  Cleanthous </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">alex.c@webprofits.com.au</span><br />
101HOMEPAGEENQUIRY<br />Office No. 02 8806 6800<br />Mobile 0403 533 273</td>

<td class="sorted date_updated" >2012-10-03</td>

<td class="sorted timestamp">
<span >2012-09-29</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8579');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8579" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8579'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8579);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8579');">
</div>
<div id='8579_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='8578' >
<div align="center">
<span id="mark_link_8578" class="mark_unmark_link" onclick="mark_unmark_lead(8578)" mode='mark' leads_name="#8578 Kim  Kyloe">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8578
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8578&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kim  Kyloe </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">kim@worldcupcheer.com.au</span><br />
101<br />Office No. +61733719324<br />Mobile +61405798045</td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2012-09-29</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8578');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8578" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8578'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8578);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8578');">
</div>
<div id='8578_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1506</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1067&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=1506',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' onClick='check_val()' name='users' value='8574' >
<div align="center">
<span id="mark_link_8574" class="mark_unmark_link" onclick="mark_unmark_lead(8574)" mode='mark' leads_name="#8574 Joel  Waters">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8574
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8574&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Joel  Waters </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">joelw@backsafe-australia.com.au</span><br />
101HOMEPAGEENQUIRY<br />Office No. 08 6258 1800<br />Mobile 0437 202 306</td>

<td class="sorted date_updated" >2012-10-03</td>

<td class="sorted timestamp">
<span >2012-09-28</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8574');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8574" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8574'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8574);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8574');">
</div>
<div id='8574_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
5
<input type='checkbox' onClick='check_val()' name='users' value='8571' >
<div align="center">
<span id="mark_link_8571" class="mark_unmark_link" onclick="mark_unmark_lead(8571)" mode='mark' leads_name="#8571 Ben  Liu">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8571
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8571&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Ben  Liu </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ben.liu@firstclass.com.au</span><br />
101<br />Office No. 92990088<br /></td>

<td class="sorted date_updated" >2012-10-02</td>

<td class="sorted timestamp">
<span >2012-09-28</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8571');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8571" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8571'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8571);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8571');">
</div>
<div id='8571_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1504</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1066&jr_cat_id=1&jr_list_id=5&gs_job_role_selection_id=1504',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Writer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
6
<input type='checkbox' onClick='check_val()' name='users' value='8569' >
<div align="center">
<span id="mark_link_8569" class="mark_unmark_link" onclick="mark_unmark_lead(8569)" mode='mark' leads_name="#8569 Tom  White">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8569
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8569&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Tom  White </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">kangaroo_number2@hotmail.com</span><br />
101HOMEPAGEENQUIRY<br />Mobile 0447 805 580</td>

<td class="sorted date_updated" >2012-10-04</td>

<td class="sorted timestamp">
<span >2012-09-27</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8569');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8569" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8569'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8569);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8569');">
</div>
<div id='8569_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8569',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/3/2012  BP : Walter No pressing need</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1501</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1075&jr_cat_id=2&jr_list_id=6&gs_job_role_selection_id=1501',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">PHP Developer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
7
<input type='checkbox' onClick='check_val()' name='users' value='8563' >
<div align="center">
<span id="mark_link_8563" class="mark_unmark_link" onclick="mark_unmark_lead(8563)" mode='mark' leads_name="#8563 Manny  Alvarado">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8563
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8563&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Manny  Alvarado </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">manny@plasmaproinstallations.com</span><br />
139INBOUNDCALL<br />Office No. 954 934 7829<br />Mobile 954-850-4116</td>

<td class="sorted date_updated" >2012-10-02</td>

<td class="sorted timestamp">
<span >2012-09-26</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8563');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8563" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8563'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8563);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8563');">
</div>
<div id='8563_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8563',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/27/2012  BP : Rendall Spoke to Manny...will talk again tomorrow when he has finished wo</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1511</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1070&jr_cat_id=4&jr_list_id=208&gs_job_role_selection_id=1511',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
8
<input type='checkbox' onClick='check_val()' name='users' value='8555' >
<div align="center">
<span id="mark_link_8555" class="mark_unmark_link" onclick="mark_unmark_lead(8555)" mode='mark' leads_name="#8555 David  Frenkel">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8555
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8555&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">David  Frenkel </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">david@frenkeltextiles.com.au</span><br />
139INBOUNDCALL<br />Office No. 02 9317 3166<br />Mobile 0411 591 116</td>

<td class="sorted date_updated" >2012-10-03</td>

<td class="sorted timestamp">
<span >2012-09-24</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8555');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8555" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8555'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8555);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8555');">
</div>
<div id='8555_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8555',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/24/2012  BP : Walter job start Michelle</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1472</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1046&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=1472',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
9
<input type='checkbox' onClick='check_val()' name='users' value='8550' >
<div align="center">
<span id="mark_link_8550" class="mark_unmark_link" onclick="mark_unmark_lead(8550)" mode='mark' leads_name="#8550 David  Hayden">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8550
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8550&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">David  Hayden </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">davidhayden@cox.net</span><br />
101<br />Office No. 310 265-0591<br />Mobile 310 748-9915</td>

<td class="sorted date_updated" >2012-09-27</td>

<td class="sorted timestamp">
<span >2012-09-23</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8550');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8550" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8550'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8550);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8550');">
</div>
<div id='8550_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1475</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1050&jr_cat_id=4&jr_list_id=208&gs_job_role_selection_id=1475',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
10
<input type='checkbox' onClick='check_val()' name='users' value='8547' >
<div align="center">
<span id="mark_link_8547" class="mark_unmark_link" onclick="mark_unmark_lead(8547)" mode='mark' leads_name="#8547 Kris  Colley">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8547
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8547&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kris  Colley </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">dawnremodeling@gmail.com</span><br />
101<br />Office No. 267 388 0888<br />Mobile 267 388 0888</td>

<td class="sorted date_updated" >2012-09-30</td>

<td class="sorted timestamp">
<span >2012-09-22</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8547');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8547" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8547'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8547);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8547');">
</div>
<div id='8547_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1483</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1055&jr_cat_id=4&jr_list_id=208&gs_job_role_selection_id=1483',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div><div><strong>Custom Recruitment Order #1484</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1056&jr_cat_id=4&jr_list_id=208&gs_job_role_selection_id=1484',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
11
<input type='checkbox' onClick='check_val()' name='users' value='8546' >
<div align="center">
<span id="mark_link_8546" class="mark_unmark_link" onclick="mark_unmark_lead(8546)" mode='mark' leads_name="#8546 Leland  Core">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8546
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8546&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Leland  Core </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">leland@acscommunications.com</span><br />
101INBOUNDCALL<br />Office No. 2022360886<br /></td>

<td class="sorted date_updated" >2012-09-28</td>

<td class="sorted timestamp">
<span >2012-09-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8546');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8546" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8546'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8546);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8546');">
</div>
<div id='8546_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8546',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/21/2012  ADMIN : Ryan  Lead called in asking for assistance with a VA post. will send Jo</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1449</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1044&jr_cat_id=4&jr_list_id=183&gs_job_role_selection_id=1449',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Back Office Admin</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
12
<input type='checkbox' onClick='check_val()' name='users' value='8544' >
<div align="center">
<span id="mark_link_8544" class="mark_unmark_link" onclick="mark_unmark_lead(8544)" mode='mark' leads_name="#8544 Keith  House">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8544
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8544&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Keith  House </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">kahouse@logichouse.com</span><br />
101<br />Office No. 310 871 2790<br />Mobile 310 871 2790</td>

<td class="sorted date_updated" >2012-10-02</td>

<td class="sorted timestamp">
<span >2012-09-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8544');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8544" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8544'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8544);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8544');">
</div>
<div id='8544_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1458</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1045&jr_cat_id=4&jr_list_id=266&gs_job_role_selection_id=1458',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recruitment Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
13
<input type='checkbox' onClick='check_val()' name='users' value='8527' >
<div align="center">
<span id="mark_link_8527" class="mark_unmark_link" onclick="mark_unmark_lead(8527)" mode='mark' leads_name="#8527 Ian  Crawley">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8527
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8527&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Ian  Crawley </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">icrawley@ianthompsonproperties.com.au</span><br />
139ClientReferral<br />Office No. 1300 228 963<br />Mobile 0416 420 000</td>

<td class="sorted date_updated" >2012-10-03</td>

<td class="sorted timestamp">
<span >2012-09-15</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8527');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8527" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8527'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8527);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8527');">
</div>
<div id='8527_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8527',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/1/2012  BP : Walter Job start Michelle</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1421</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1058&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=1421',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
14
<input type='checkbox' onClick='check_val()' name='users' value='8518' >
<div align="center">
<span id="mark_link_8518" class="mark_unmark_link" onclick="mark_unmark_lead(8518)" mode='mark' leads_name="#8518 David  Barling">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8518
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8518&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">David  Barling </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">david@heccater.com.au</span><br />
101<br />Office No. 03 9543 3333<br /></td>

<td class="sorted date_updated" >2012-10-02</td>

<td class="sorted timestamp">
<span >2012-09-13</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8518');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8518" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8518'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8518);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8518');">
</div>
<div id='8518_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8518',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/28/2012  BP : Walter Job started - Michelle</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
15
<input type='checkbox' onClick='check_val()' name='users' value='8514' >
<div align="center">
<span id="mark_link_8514" class="mark_unmark_link" onclick="mark_unmark_lead(8514)" mode='mark' leads_name="#8514 Craig  Hewett">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8514
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8514&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Craig  Hewett </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">chewett@sequelstaffing.co.nz</span><br />
101INBOUNDCALL<br />Office No. +64 9 4736063<br />Mobile +64 274736004</td>

<td class="sorted date_updated" >2012-10-01</td>

<td class="sorted timestamp">
<span >2012-09-12</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>ASL ORDER : IN PROGRESS<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8514');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8514" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8514'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8514);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8514');">
</div>
<div id='8514_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1405</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1017&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=1405',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=B6a6NM51NEZUVcP97V14b8GD3b5XcEX4bWFXB6X34XON0' target='_blank'> - 28th Sep 12 12:36 PM quote given Part-Time Candidate ID Ma. Sheryl 55720 :  $ AUD 493.90</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2012-09-28<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=BDGWNGZHZU1cENIM4CC9ECOJXRZBYRRI720OMLUP6Uc93' target='_blank' class=''>- 12:36 PM Service Agreement # 1927</a><br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
16
<input type='checkbox' onClick='check_val()' name='users' value='8501' >
<div align="center">
<span id="mark_link_8501" class="mark_unmark_link" onclick="mark_unmark_lead(8501)" mode='mark' leads_name="#8501 Aaron  Huang">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8501
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8501&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Aaron  Huang </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">aaron@mobileciti.com.au</span><br />
101AVAILABLESTAFF<br />Office No. 02 9893 8886<br /></td>

<td class="sorted date_updated" >2012-10-03</td>

<td class="sorted timestamp">
<span >2012-09-09</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8501');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8501" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8501'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8501);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8501');">
</div>
<div id='8501_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8501',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/25/2012  BP : Walter Job Start PJ</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1413</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1049&jr_cat_id=4&jr_list_id=258&gs_job_role_selection_id=1413',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Writer, Webdesigner</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
17
<input type='checkbox' onClick='check_val()' name='users' value='8498' >
<div align="center">
<span id="mark_link_8498" class="mark_unmark_link" onclick="mark_unmark_lead(8498)" mode='mark' leads_name="#8498 Lyall  Mercer">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8498
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8498&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lyall  Mercer </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">lyall@mercerpr.com</span><br />
101<br />Mobile 0413 749 830</td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2012-09-07</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8498');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8498" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8498'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8498);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8498');">
</div>
<div id='8498_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1374</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1008&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=1374',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
18
<input type='checkbox' onClick='check_val()' name='users' value='8475' >
<div align="center">
<span id="mark_link_8475" class="mark_unmark_link" onclick="mark_unmark_lead(8475)" mode='mark' leads_name="#8475 Zaff  Bozkurt">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8475
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8475&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Zaff  Bozkurt </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">zaff@caimes.com</span><br />
101<br />Mobile 0407 733 432</td>

<td class="sorted date_updated" >2012-09-14</td>

<td class="sorted timestamp">
<span >2012-08-31</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8475');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8475" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8475'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8475);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8475');">
</div>
<div id='8475_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8475',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/14/2012  BP : Walter call back early Oct</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
19
<input type='checkbox' onClick='check_val()' name='users' value='8468' >
<div align="center">
<span id="mark_link_8468" class="mark_unmark_link" onclick="mark_unmark_lead(8468)" mode='mark' leads_name="#8468 Angus  Noakes">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8468
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8468&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Angus  Noakes </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">angus@civil72.com.au</span><br />
101<br />Office No. 07 5443 2400<br /></td>

<td class="sorted date_updated" >2012-09-28</td>

<td class="sorted timestamp">
<span >2012-08-30</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8468');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8468" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8468'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8468);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8468');">
</div>
<div id='8468_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8468',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/28/2012  BP : Walter sent whats up email</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1358</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1002&jr_cat_id=4&jr_list_id=109&gs_job_role_selection_id=1358',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Civil Engineer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
20
<input type='checkbox' onClick='check_val()' name='users' value='8457' >
<div align="center">
<span id="mark_link_8457" class="mark_unmark_link" onclick="mark_unmark_lead(8457)" mode='mark' leads_name="#8457 Chris  Klinefelter">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8457
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8457&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Chris  Klinefelter </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">chris@eppsinteractive.com</span><br />
101HOMEPAGEENQUIRY<br />Office No. Michael : 615-429-2152<br />Mobile 717-580-9163</td>

<td class="sorted date_updated" >2012-09-12</td>

<td class="sorted timestamp">
<span >2012-08-29</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>ASL ORDER : NEW!!!<br></div></div>
<!--
<div>
 <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p></div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8457');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8457" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8457'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8457);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8457');">
</div>
<div id='8457_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1323</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=988&jr_cat_id=4&jr_list_id=178&gs_job_role_selection_id=1323',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">SEO</a></li></ol></div></div>
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