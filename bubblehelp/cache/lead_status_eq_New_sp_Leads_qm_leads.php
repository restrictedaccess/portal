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
																			            												            												            							<a href="index.php?lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" id="navselected">New Leads</a>
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
<input type="hidden" name="path" id="path" value="lead_status=New Leads" />
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
		        	    <option value="New Leads" selected="selected">New Leads</option>
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
          <option value="6"  >Rica Gil</option>
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
                <input type="submit" name="move" id="move" value="Move to Follow-Up" disabled="disabled" onclick="Move('Follow-Up')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Keep In-Touch" disabled="disabled" onclick="Move('Keep In-Touch')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Pending" disabled="disabled" onclick="Move('pending')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Asl" disabled="disabled" onclick="Move('asl')" class="button" />
	            <input type="submit" name="move" id="move" value="Move to Custom Recruitment" disabled="disabled" onclick="Move('custom recruitment')" class="button" />
	<input type="submit" name="remove" id="remove" disabled="disabled" value="Remove" class="button" ><input type="submit" name="transfer" id="transfer" disabled="disabled" value="Tranfer to" onClick="return CheckBP();"  class="button"> <select name="agent_id" id="agent_id" style="width:200px;" disabled="disabled" >
<option value="">Business Developer</option>
<option value='2'>Chris Jankulovski</option><option value='44'>Walter Fulmizi</option><option value='343'>Michael Burns</option><option value='402'>Kenneth Tubio</option><option value='426'>Rendall Young</option>
</select>
</p>
</fieldset></div>
<br clear="all" />
<h2 align="center">
    New Leads
</h2>

<p align="center">There are <strong>0</strong> <span style="text-transform:capitalize;">new leads</span> today October 30, 2012








</p>
<br clear="all" />

</div><div id="leads_list" counter="20" style="background:#BBCCFF;" >

<div style="clear:both;background:#BBCCFF; height:20px;">&nbsp;</div>

<div class="list_list_holder">

<span><a name="UNMARKED">UNMARKED LEADS</a> [ 27 Records ] <select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'  >
<option value="1"  selected="selected" >Page 1</option>
<option value="2" >Page 2</option>
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
<input type='checkbox' onClick='check_val()' name='users' value='8672' >
<div align="center">
<span id="mark_link_8672" class="mark_unmark_link" onclick="mark_unmark_lead(8672)" mode='mark' leads_name="#8672 Abdulaziz  Alhammad">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8672
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8672&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Abdulaziz  Alhammad </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">nusheer@gmail.com</span><br />
101HOMEPAGEENQUIRY<br />Mobile 966506461683</td>

<td class="sorted date_updated" >2012-10-30</td>

<td class="sorted timestamp">
<span >2012-10-29</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8672');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8672" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8672'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8672);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8672');">
</div>
<div id='8672_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='8667' >
<div align="center">
<span id="mark_link_8667" class="mark_unmark_link" onclick="mark_unmark_lead(8667)" mode='mark' leads_name="#8667 Will  McFarland">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8667
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8667&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Will  McFarland </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">will@wealthdesignconcepts.com.au</span><br />
101HOMEPAGEENQUIRY<br />Office No. 02 4927 1507<br />Mobile 0416 728 706 </td>

<td class="sorted date_updated" >2012-10-29</td>

<td class="sorted timestamp">
<span >2012-10-26</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8667');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8667" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8667'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8667);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8667');">
</div>
<div id='8667_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8667',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/29/2012  BP : Walter He will get back to me tomorrow</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='8665' >
<div align="center">
<span id="mark_link_8665" class="mark_unmark_link" onclick="mark_unmark_lead(8665)" mode='mark' leads_name="#8665 Jo  Guzman">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8665
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8665&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jo  Guzman </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">jozelle@707thinktank.com</span><br />
101HOMEPAGEENQUIRY<br />Office No. 09178441018<br /></td>

<td class="sorted date_updated" >2012-10-29</td>

<td class="sorted timestamp">
<span >2012-10-24</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8665');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8665" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8665'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8665);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8665');">
</div>
<div id='8665_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8665',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/29/2012  BP : Walter PJ looking at this one</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' onClick='check_val()' name='users' value='8661' >
<div align="center">
<span id="mark_link_8661" class="mark_unmark_link" onclick="mark_unmark_lead(8661)" mode='mark' leads_name="#8661 Lucy  Milekovic">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8661
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8661&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lucy  Milekovic </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">lucy@ultimatebusiness.com.au</span><br />
101<br />Mobile 0421 029 003</td>

<td class="sorted date_updated" >2012-10-29</td>

<td class="sorted timestamp">
<span >2012-10-23</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8661');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8661" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8661'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8661);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8661');">
</div>
<div id='8661_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8661',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/29/2012  BP : Walter LNN and sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
5
<input type='checkbox' onClick='check_val()' name='users' value='8658' >
<div align="center">
<span id="mark_link_8658" class="mark_unmark_link" onclick="mark_unmark_lead(8658)" mode='mark' leads_name="#8658 Tim  Green">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8658
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8658&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Tim  Green </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">timgst@gmail.com</span><br />
101HOMEPAGEENQUIRY<br />Office No. (81) 080-3867-3216<br />Mobile (81) 080-3867-3216</td>

<td class="sorted date_updated" >2012-10-22</td>

<td class="sorted timestamp">
<span >2012-10-22</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8658');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8658" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8658'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8658);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8658');">
</div>
<div id='8658_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8658',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/22/2012  BP : Walter phone failed emailed him</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
6
<input type='checkbox' onClick='check_val()' name='users' value='8656' >
<div align="center">
<span id="mark_link_8656" class="mark_unmark_link" onclick="mark_unmark_lead(8656)" mode='mark' leads_name="#8656 Christopher  Darge">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8656
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8656&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Christopher  Darge </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">admin@shireit.com.au</span><br />
101<br />Office No. none<br />Mobile none</td>

<td class="sorted date_updated" >2012-10-29</td>

<td class="sorted timestamp">
<span >2012-10-22</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8656');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8656" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8656'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8656);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8656');">
</div>
<div id='8656_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8656',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/29/2012  BP : Walter sent whats up email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
7
<input type='checkbox' onClick='check_val()' name='users' value='8647' >
<div align="center">
<span id="mark_link_8647" class="mark_unmark_link" onclick="mark_unmark_lead(8647)" mode='mark' leads_name="#8647 MR. Paul  Esty">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8647
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8647&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">MR. Paul  Esty </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">paul.esty@mectech.com</span><br />
101<br />Office No. 7325050308 / 001917325052125<br /></td>

<td class="sorted date_updated" >2012-10-23</td>

<td class="sorted timestamp">
<span >2012-10-19</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8647');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8647" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8647'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8647);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8647');">
</div>
<div id='8647_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8647',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/23/2012  BP : Rendall Left VM</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
8
<input type='checkbox' onClick='check_val()' name='users' value='8640' >
<div align="center">
<span id="mark_link_8640" class="mark_unmark_link" onclick="mark_unmark_lead(8640)" mode='mark' leads_name="#8640 Claire  Thomas">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8640
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8640&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Claire  Thomas </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">eclaire37@hotmail.co.uk</span><br />
101<br />Mobile 0061478266441</td>

<td class="sorted date_updated" >2012-10-19</td>

<td class="sorted timestamp">
<span >2012-10-17</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8640');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8640" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8640'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8640);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8640');">
</div>
<div id='8640_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8640',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/18/2012  BP : Walter revieiwng needs</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1602</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1143&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=1602',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
9
<input type='checkbox' onClick='check_val()' name='users' value='8633' >
<div align="center">
<span id="mark_link_8633" class="mark_unmark_link" onclick="mark_unmark_lead(8633)" mode='mark' leads_name="#8633 John  Browne">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8633
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8633&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">John  Browne </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">info1@syndicateleads.com</span><br />
101<br />Office No. 877-306-1952<br />Mobile 561-327-4098</td>

<td class="sorted date_updated" >2012-10-30</td>

<td class="sorted timestamp">
<span >2012-10-16</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8633');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8633" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8633'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8633);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8633');">
</div>
<div id='8633_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8633',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/30/2012  BP : Rendall Left VM</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
10
<input type='checkbox' onClick='check_val()' name='users' value='8614' >
<div align="center">
<span id="mark_link_8614" class="mark_unmark_link" onclick="mark_unmark_lead(8614)" mode='mark' leads_name="#8614 Nicson  White">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8614
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8614&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Nicson  White </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">nicson@healthybreathingcentre.com</span><br />
101<br />Mobile 0421 130 724</td>

<td class="sorted date_updated" >2012-10-29</td>

<td class="sorted timestamp">
<span >2012-10-10</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8614');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8614" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8614'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8614);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8614');">
</div>
<div id='8614_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8614',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/29/2012  BP : Walter LNN and sent whats up email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
11
<input type='checkbox' onClick='check_val()' name='users' value='8613' >
<div align="center">
<span id="mark_link_8613" class="mark_unmark_link" onclick="mark_unmark_lead(8613)" mode='mark' leads_name="#8613 Bryan  Shnider">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8613
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8613&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Bryan  Shnider </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">bryan.shnider@gmail.com</span><br />
101<br />Mobile 214-223-7138</td>

<td class="sorted date_updated" >2012-10-30</td>

<td class="sorted timestamp">
<span >2012-10-10</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8613');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8613" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8613'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8613);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8613');">
</div>
<div id='8613_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8613',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/30/2012  BP : Rendall Left VM</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
12
<input type='checkbox' onClick='check_val()' name='users' value='8599' >
<div align="center">
<span id="mark_link_8599" class="mark_unmark_link" onclick="mark_unmark_lead(8599)" mode='mark' leads_name="#8599 Samit  Jain">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8599
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8599&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Samit  Jain </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">jain.samit@gmail.com</span><br />
101<br />Office No. 2129828844<br /></td>

<td class="sorted date_updated" >2012-10-18</td>

<td class="sorted timestamp">
<span >2012-10-06</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8599');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8599" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8599'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8599);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8599');">
</div>
<div id='8599_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8599',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/18/2012  BP : Rendall Wrong number, sent TB email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
13
<input type='checkbox' onClick='check_val()' name='users' value='8596' >
<div align="center">
<span id="mark_link_8596" class="mark_unmark_link" onclick="mark_unmark_lead(8596)" mode='mark' leads_name="#8596 Vince  Bindi">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8596
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8596&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Vince  Bindi </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">vincebin@gmail.com</span><br />
477INBOUNDCALL<br />Mobile 949-297-2058</td>

<td class="sorted date_updated" >2012-10-30</td>

<td class="sorted timestamp">
<span >2012-10-06</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8596');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8596" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8596'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8596);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8596');">
</div>
<div id='8596_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8596',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/30/2012  BP : Rendall Spoke to Vince, was in a meeting, asked to call him back another </a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1541</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1088&jr_cat_id=4&jr_list_id=208&gs_job_role_selection_id=1541',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
14
<input type='checkbox' onClick='check_val()' name='users' value='8595' >
<div align="center">
<span id="mark_link_8595" class="mark_unmark_link" onclick="mark_unmark_lead(8595)" mode='mark' leads_name="#8595 Billy  Evans">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8595
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8595&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Billy  Evans </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">everlastroofing@sbcglobal.net</span><br />
477INBOUNDCALL<br />Mobile 7132082244</td>

<td class="sorted date_updated" >2012-10-11</td>

<td class="sorted timestamp">
<span >2012-10-05</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8595');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8595" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8595'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8595);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8595');">
</div>
<div id='8595_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8595',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/11/2012  BP : Rendall Will hold off for couple weeks to get organized on his end</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1533</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1082&jr_cat_id=4&jr_list_id=208&gs_job_role_selection_id=1533',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
15
<input type='checkbox' onClick='check_val()' name='users' value='8549' >
<div align="center">
<span id="mark_link_8549" class="mark_unmark_link" onclick="mark_unmark_lead(8549)" mode='mark' leads_name="#8549 Erick  Horton">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8549
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8549&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Erick  Horton </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">eveningglorygifts@yahoo.com</span><br />
101<br />Mobile 6317646049</td>

<td class="sorted date_updated" >2012-10-11</td>

<td class="sorted timestamp">
<span >2012-09-22</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8549');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8549" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8549'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8549);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8549');">
</div>
<div id='8549_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8549',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/11/2012  BP : Rendall hung up when answered</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
16
<input type='checkbox' onClick='check_val()' name='users' value='8537' >
<div align="center">
<span id="mark_link_8537" class="mark_unmark_link" onclick="mark_unmark_lead(8537)" mode='mark' leads_name="#8537 Shawn  Mostyn">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8537
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8537&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Shawn  Mostyn </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">shawn.mostyn@gmail.com</span><br />
101AVAILABLESTAFF<br />Mobile 302-467-8011</td>

<td class="sorted date_updated" >2012-10-12</td>

<td class="sorted timestamp">
<span >2012-09-19</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8537');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8537" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8537'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8537);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8537');">
</div>
<div id='8537_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8537',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/12/2012  BP : Rendall Sent TB email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
17
<input type='checkbox' onClick='check_val()' name='users' value='8517' >
<div align="center">
<span id="mark_link_8517" class="mark_unmark_link" onclick="mark_unmark_lead(8517)" mode='mark' leads_name="#8517 Kris  Sera">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8517
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8517&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kris  Sera </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ksera2009@gmail.com</span><br />
101HOMEPAGEENQUIRY<br />Office No. 415-269-5478<br /></td>

<td class="sorted date_updated" >2012-09-27</td>

<td class="sorted timestamp">
<span >2012-09-13</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8517');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8517" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8517'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8517);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8517');">
</div>
<div id='8517_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8517',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/27/2012  BP : Rendall Spoke to Kris... she is too busy to talk at the moment, but has m</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
18
<input type='checkbox' onClick='check_val()' name='users' value='8503' >
<div align="center">
<span id="mark_link_8503" class="mark_unmark_link" onclick="mark_unmark_lead(8503)" mode='mark' leads_name="#8503 Mlsruwrk  Vlomitgu">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8503
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8503&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Mlsruwrk  Vlomitgu </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">sample@email.tst</span><br />
F3cYEz2N<br />Office No. 1<br />Mobile 1</td>

<td class="sorted date_updated" >2012-09-12</td>

<td class="sorted timestamp">
<span >2012-09-10</span>
</td>


<td class="actions">
<div class="identical"></div>
New Leads<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>CUSTOM ORDER : NEW!!!<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8503');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8503" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8503'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8503);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8503');">
</div>
<div id='8503_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8503',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/12/2012  BP : Walter test record</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
19
<input type='checkbox' onClick='check_val()' name='users' value='8477' >
<div align="center">
<span id="mark_link_8477" class="mark_unmark_link" onclick="mark_unmark_lead(8477)" mode='mark' leads_name="#8477 Nikos  Kostopoulos">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8477
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8477&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Nikos  Kostopoulos </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">anelixi@ovi.com</span><br />
101HOMEPAGEENQUIRY<br />Mobile 00306946444583</td>

<td class="sorted date_updated" >2012-09-03</td>

<td class="sorted timestamp">
<span >2012-09-01</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8477');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8477" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8477'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8477);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8477');">
</div>
<div id='8477_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8477',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/3/2012  BP : Walter competitor trying to connect with candidates</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
20
<input type='checkbox' onClick='check_val()' name='users' value='8428' >
<div align="center">
<span id="mark_link_8428" class="mark_unmark_link" onclick="mark_unmark_lead(8428)" mode='mark' leads_name="#8428 Benjamin  Austin">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8428
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8428&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Benjamin  Austin </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">benaustin45@bigpond.com</span><br />
101<br />Office No. 49688190<br /></td>

<td class="sorted date_updated" >2012-09-28</td>

<td class="sorted timestamp">
<span >2012-08-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8428');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8428" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8428'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8428);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8428');">
</div>
<div id='8428_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8428',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/28/2012  BP : Walter sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
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