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
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" id="mark_btn" leads_id="" value="mark" onclick="MarkLead()" /> <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" value="close" onclick="fade('overlay')" />
</ul>
</div>
</div>
<div id="nav">
    <img src="./media/images/remote_staff_logo.png" />
	    <span>Admin: <a href="../admin_profile.php" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">#43 Anne Charise Mancenido</a><br />
		<a href="/portal/bubblehelp/bhelp.php?/create_page/&curl=leads_list/index.php?lead_status=New" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"+Leads" title="Open Help Page" >Help Page</a>
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
												            							<a href="index.php?lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" id="navselected">New Leads</a>
							</li>
												
								    					                                <li>
																			            												            												            												            												            
							<a href="index.php?lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" >Follow-Up</a>
							</li>
												
								    					                                <li>
																							    <img src='images/star.png' border='0'  >
												            												            												            												            												            
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
		        	    <option value="custom recruitment" >Custom Recruitment</option>
		            	    <option value="transferred" >Transferred</option>
		        	    <option value="pending" >Pending</option>
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
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="search" id="search" value="Search" class="button"  />
</p>
</fieldset>
</div>

<div class="form_filters" style="margin-top:20px;">
<fieldset><legend>ACTION BUTTONS</legend>
<p> <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" value="Add New Lead" class="button" onClick="self.location='../AddUpdateLeads.php'" />
                <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Follow-Up" disabled="disabled" onclick="Move('Follow-Up')" class="button" />
	            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Keep In-Touch" disabled="disabled" onclick="Move('Keep In-Touch')" class="button" />
	            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Pending" disabled="disabled" onclick="Move('pending')" class="button" />
	            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Asl" disabled="disabled" onclick="Move('asl')" class="button" />
	            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Custom Recruitment" disabled="disabled" onclick="Move('custom recruitment')" class="button" />
	<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="remove" id="remove" disabled="disabled" value="Remove" class="button" ><input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="transfer" id="transfer" disabled="disabled" value="Tranfer to" onClick="return CheckBP();"  class="button"> <select name="agent_id" id="agent_id" style="width:200px;" disabled="disabled" >
<option value="">Business Developer</option>
<option value='2'>Chris Jankulovski</option><option value='44'>Walter Fulmizi</option><option value='343'>Michael Burns</option><option value='402'>Kenneth Tubio</option><option value='426'>Rendall Young</option>
</select>
</p>
</fieldset></div>
<br clear="all" />
<h2 align="center">
    New Leads
</h2>

<p align="center">There are <strong>4</strong> <span style="text-transform:capitalize;">new leads</span> today March 21, 2013








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
<th >4 Marked leads found..</th>
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
<input type='checkbox' onClick='check_val()' name='users' value='9137' >
<div align="center">
<span id="mark_link_9137" class="mark_unmark_link" onclick="mark_unmark_lead(9137)" mode='mark' leads_name="#9137 May  Huang">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
9137
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9137&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">May  Huang </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">mayh722@yahoo.com</span><br />
101<br />Mobile 0421894976</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span  style="font-weight:bold" >2013-03-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9137');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9137" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9137'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9137);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9137');">
</div>
<div id='9137_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='9133' >
<div align="center">
<span id="mark_link_9133" class="mark_unmark_link" onclick="mark_unmark_lead(9133)" mode='mark' leads_name="#9133 Roy  Arellano">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
9133
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9133&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Roy  Arellano </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">roy@bywave.com.au</span><br />
101AVAILABLESTAFF<br />Office No. 02 8022 8391<br />Mobile 0450 781 041</td>

<td class="sorted date_updated" >2013-03-20</td>

<td class="sorted timestamp">
<span >2013-03-20</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9133');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9133" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9133'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9133);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9133');">
</div>
<div id='9133_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9133',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/20/2013  BP : Walter will complete JS form</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='9088' >
<div align="center">
<span id="mark_link_9088" class="mark_unmark_link" onclick="mark_unmark_lead(9088)" mode='mark' leads_name="#9088 Andrew  Odusanya">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
9088
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9088&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Andrew  Odusanya </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">fiveseasonsproperties@gmail.com</span><br />
101HOMEPAGEENQUIRY<br />Mobile +44 7508 300097</td>

<td class="sorted date_updated" >2013-03-20</td>

<td class="sorted timestamp">
<span >2013-03-08</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9088');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9088" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9088'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9088);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9088');">
</div>
<div id='9088_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9088',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/11/2013  BP : Walter start up still organising himself</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' onClick='check_val()' name='users' value='9077' >
<div align="center">
<span id="mark_link_9077" class="mark_unmark_link" onclick="mark_unmark_lead(9077)" mode='mark' leads_name="#9077 Will  Riverall">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
9077
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9077&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Will  Riverall </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">angbusiness@consultant.com</span><br />
101<br />Office No. +61428180339<br />Mobile +61428180339</td>

<td class="sorted date_updated" >2013-03-07</td>

<td class="sorted timestamp">
<span >2013-03-06</span>
</td>


<td class="actions">
<div class="identical"><div>Identical Name to : <br><a href="../leads_information.php?id=8981&lead_status=asl&url=leads_list/index.php?lead_status=New" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"+Leads'>#8981 Will Riverall [asl]</a></div></div>
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
<div align='right' ><a href="javascript: toggle('note_form_9077');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9077" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9077'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9077);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9077');">
</div>
<div id='9077_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr>
</tbody>
</table>

</div>

<div style="clear:both;background:#BBCCFF; height:20px;">&nbsp;</div>

<div class="list_list_holder">

<span><a name="UNMARKED">UNMARKED LEADS</a> [ 32 Records ] <select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'  >
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
<input type='checkbox' onClick='check_val()' name='users' value='9138' >
<div align="center">
<span id="mark_link_9138" class="mark_unmark_link" onclick="mark_unmark_lead(9138)" mode='mark' leads_name="#9138 Miranda  Dunn">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9138
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9138&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Miranda  Dunn </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">miranda@franchiseforsuccess.com.au</span><br />
101AddedManually<br />Mobile 0466 37 33 00</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span  style="font-weight:bold" >2013-03-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9138');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9138" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9138'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9138);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9138');">
</div>
<div id='9138_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9138',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/21/2013  BP : Walter affiliate: lnn AND SENT EMAIL</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='9136' >
<div align="center">
<span id="mark_link_9136" class="mark_unmark_link" onclick="mark_unmark_lead(9136)" mode='mark' leads_name="#9136 Evelyn  Szumski">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9136
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9136&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Evelyn  Szumski </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">evelyn@leadingtrainingsolutions.com</span><br />
139INBOUNDCALL<br />Mobile 0428 553 900</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span  style="font-weight:bold" >2013-03-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9136');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9136" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9136'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9136);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9136');">
</div>
<div id='9136_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9136',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/21/2013  BP : Walter LNN ands sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='9135' >
<div align="center">
<span id="mark_link_9135" class="mark_unmark_link" onclick="mark_unmark_lead(9135)" mode='mark' leads_name="#9135 Ian  Bush">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9135
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9135&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Ian  Bush </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ian@artistguitars.com.au</span><br />
101HOMEPAGEENQUIRY<br />Office No. 02 8065 6837<br />Mobile 0450 287 837</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span  style="font-weight:bold" >2013-03-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9135');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9135" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9135'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9135);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9135');">
</div>
<div id='9135_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' onClick='check_val()' name='users' value='9131' >
<div align="center">
<span id="mark_link_9131" class="mark_unmark_link" onclick="mark_unmark_lead(9131)" mode='mark' leads_name="#9131 James  Philip">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9131
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9131&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">James  Philip </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">james@firstautoparts.com.au</span><br />
101HOMEPAGEENQUIRY<br />Office No. 03 9785 3333<br />Mobile 0414 888 003</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span >2013-03-20</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9131');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9131" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9131'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9131);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9131');">
</div>
<div id='9131_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9131',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/21/2013  BP : Walter LNN and sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
5
<input type='checkbox' onClick='check_val()' name='users' value='9129' >
<div align="center">
<span id="mark_link_9129" class="mark_unmark_link" onclick="mark_unmark_lead(9129)" mode='mark' leads_name="#9129 Lora  Zamoras">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9129
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9129&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lora  Zamoras </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">lora@dqt.co.uk</span><br />
101AVAILABLESTAFF<br />Mobile 09228920270</td>

<td class="sorted date_updated" >2013-03-20</td>

<td class="sorted timestamp">
<span >2013-03-19</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9129');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9129" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9129'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9129);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9129');">
</div>
<div id='9129_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9129',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/20/2013  BP : Walter sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
6
<input type='checkbox' onClick='check_val()' name='users' value='9127' >
<div align="center">
<span id="mark_link_9127" class="mark_unmark_link" onclick="mark_unmark_lead(9127)" mode='mark' leads_name="#9127 Md Harun Or  Rashid">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9127
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9127&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Md Harun Or  Rashid </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">mdharun_1@yahoo.com</span><br />
101<br />Office No. 088-031-714747<br />Mobile 01816308789</td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-03-18</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9127');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9127" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9127'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9127);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9127');">
</div>
<div id='9127_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9127',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/19/2013  BP : Walter sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
7
<input type='checkbox' onClick='check_val()' name='users' value='9120' >
<div align="center">
<span id="mark_link_9120" class="mark_unmark_link" onclick="mark_unmark_lead(9120)" mode='mark' leads_name="#9120 Robyn  Bourne">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9120
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9120&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Robyn  Bourne </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">robynbourne@hotmail.com</span><br />
101<br />Mobile 0438109238</td>

<td class="sorted date_updated" >2013-03-18</td>

<td class="sorted timestamp">
<span >2013-03-18</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9120');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9120" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9120'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9120);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9120');">
</div>
<div id='9120_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9120',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/18/2013  BP : Walter LNN and sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
8
<input type='checkbox' onClick='check_val()' name='users' value='9113' >
<div align="center">
<span id="mark_link_9113" class="mark_unmark_link" onclick="mark_unmark_lead(9113)" mode='mark' leads_name="#9113 Alen  Pasalic">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9113
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9113&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Alen  Pasalic </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">info@arypainting.com.au</span><br />
101<br />Office No. 0419483597<br /></td>

<td class="sorted date_updated" >2013-03-15</td>

<td class="sorted timestamp">
<span >2013-03-15</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9113');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9113" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9113'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9113);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9113');">
</div>
<div id='9113_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9113',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/15/2013  BP : Walter he will call me back</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
9
<input type='checkbox' onClick='check_val()' name='users' value='9106' >
<div align="center">
<span id="mark_link_9106" class="mark_unmark_link" onclick="mark_unmark_lead(9106)" mode='mark' leads_name="#9106 Jordan  Clark">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9106
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9106&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jordan  Clark </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">Jordan@Dealburglar.com</span><br />
101HOMEPAGEENQUIRY<br />Office No. 3072004505<br /></td>

<td class="sorted date_updated" >2013-03-18</td>

<td class="sorted timestamp">
<span >2013-03-14</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9106');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9106" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9106'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9106);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9106');">
</div>
<div id='9106_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9106',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/14/2013  BP : Walter number failed sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
10
<input type='checkbox' onClick='check_val()' name='users' value='9104' >
<div align="center">
<span id="mark_link_9104" class="mark_unmark_link" onclick="mark_unmark_lead(9104)" mode='mark' leads_name="#9104 ERIC  ANTHONY">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9104
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9104&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">ERIC  ANTHONY </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ERICANTHONY500@GMAIL.COM</span><br />
101AVAILABLESTAFF<br />Office No. 702.430.6889<br /></td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span >2013-03-14</span>
</td>


<td class="actions">
<div class="identical"></div>
New Leads<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>ASL ORDER : NEW!!!<br>CUSTOM ORDER : NEW!!!<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_9104');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9104" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9104'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9104);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9104');">
</div>
<div id='9104_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9104',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/19/2013  BP : Walter Job start PJ</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
11
<input type='checkbox' onClick='check_val()' name='users' value='9103' >
<div align="center">
<span id="mark_link_9103" class="mark_unmark_link" onclick="mark_unmark_lead(9103)" mode='mark' leads_name="#9103 Melissa  Mataic">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9103
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9103&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Melissa  Mataic </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">melissa@redmusiccentre.com.au</span><br />
139ClientReferral<br />Mobile 0419 698 411 </td>

<td class="sorted date_updated" >2013-03-13</td>

<td class="sorted timestamp">
<span >2013-03-13</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9103');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9103" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9103'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9103);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9103');">
</div>
<div id='9103_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9103',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/13/2013  BP : Walter Sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
12
<input type='checkbox' onClick='check_val()' name='users' value='9097' >
<div align="center">
<span id="mark_link_9097" class="mark_unmark_link" onclick="mark_unmark_lead(9097)" mode='mark' leads_name="#9097 Vanessa  Richardson">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9097
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9097&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Vanessa  Richardson </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">vanessarichardson@me.com</span><br />
101<br />Office No. 0408 345 054<br /></td>

<td class="sorted date_updated" >2013-03-13</td>

<td class="sorted timestamp">
<span >2013-03-12</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9097');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9097" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9097'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9097);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9097');">
</div>
<div id='9097_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9097',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/13/2013  BP : Walter WIll complete JS form</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
13
<input type='checkbox' onClick='check_val()' name='users' value='9089' >
<div align="center">
<span id="mark_link_9089" class="mark_unmark_link" onclick="mark_unmark_lead(9089)" mode='mark' leads_name="#9089 Evan  Hill">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9089
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9089&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Evan  Hill </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">evanh@hsafinancial.com.au</span><br />
139ClientReferral<br /></td>

<td class="sorted date_updated" >2013-03-08</td>

<td class="sorted timestamp">
<span >2013-03-08</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9089');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9089" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9089'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9089);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9089');">
</div>
<div id='9089_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9089',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/8/2013  BP : Walter sent an email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
14
<input type='checkbox' onClick='check_val()' name='users' value='8954' >
<div align="center">
<span id="mark_link_8954" class="mark_unmark_link" onclick="mark_unmark_lead(8954)" mode='mark' leads_name="#8954 Anthony  Ross">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8954
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8954&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Anthony  Ross </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">anthony@visacorp.com.au</span><br />
101<br />Office No. 02 9221 0370<br /></td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-02-07</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8954');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8954" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8954'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8954);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8954');">
</div>
<div id='8954_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8954',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/19/2013  BP : Walter LNN</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
15
<input type='checkbox' onClick='check_val()' name='users' value='8915' >
<div align="center">
<span id="mark_link_8915" class="mark_unmark_link" onclick="mark_unmark_lead(8915)" mode='mark' leads_name="#8915 Ed  Test">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8915
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8915&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Ed  Test </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ed.canape@gmail.com</span><br />
101HOMEPAGEENQUIRY<br />Office No. 0928 293 6838<br /></td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2013-01-29</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8915');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8915" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8915'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8915);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8915');">
</div>
<div id='8915_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
16
<input type='checkbox' onClick='check_val()' name='users' value='8814' >
<div align="center">
<span id="mark_link_8814" class="mark_unmark_link" onclick="mark_unmark_lead(8814)" mode='mark' leads_name="#8814 Imelda  Lim">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8814
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8814&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Imelda  Lim </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">test@crashtestdummy.com</span><br />
101AVAILABLESTAFF<br />Mobile 0917 8663562</td>

<td class="sorted date_updated" >2013-01-30</td>

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
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8814);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8814');">
</div>
<div id='8814_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
17
<input type='checkbox' onClick='check_val()' name='users' value='8748' >
<div align="center">
<span id="mark_link_8748" class="mark_unmark_link" onclick="mark_unmark_lead(8748)" mode='mark' leads_name="#8748 Chris  Winterton">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8748
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8748&lead_status=New Leads" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Chris  Winterton </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">chris@autocal.co.uk</span><br />
101HOMEPAGEENQUIRY<br />Office No. 01664 560992<br /></td>

<td class="sorted date_updated" >2012-11-22</td>

<td class="sorted timestamp">
<span >2012-11-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8748');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8748" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8748'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8748);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8748');">
</div>
<div id='8748_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8748',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">11/21/2012  BP : Walter sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
18
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
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8647);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8647');">
</div>
<div id='8647_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8647',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/23/2012  BP : Rendall Left VM</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
19
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
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8633);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8633');">
</div>
<div id='8633_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8633',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/30/2012  BP : Rendall Left VM</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
20
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
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8613);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8613');">
</div>
<div id='8613_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8613',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/30/2012  BP : Rendall Left VM</a></div>
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