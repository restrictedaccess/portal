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
		<a href="/portal/bubblehelp/bhelp.php?/create_page/&curl=leads_list/index.php?lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" title="Open Help Page" >Help Page</a>
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
																			            												            												            												            												            							<a href="index.php?lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" id="navselected">Follow-Up</a>
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
<input type="hidden" name="path" id="path" value="lead_status=Follow-Up" />
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
		        	    <option value="Follow-Up" selected="selected">Follow-Up</option>
		        	    <option value="New Leads" >New Leads</option>
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
            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to New Leads" disabled="disabled" onclick="Move('New Leads')" class="button" />
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
    Follow-Up
</h2>

<p align="center">There are <strong>0</strong> <span style="text-transform:capitalize;">follow-up</span> today March 21, 2013








</p>
<br clear="all" />

</div><div id="leads_list" counter="20" style="background:#BBCCFF;" >

<div style="clear:both;background:#BBCCFF; height:20px;">&nbsp;</div>

<div class="list_list_holder">

<span><a name="UNMARKED">UNMARKED LEADS</a> [ 365 Records ] <select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'  >
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
<input type='checkbox' onClick='check_val()' name='users' value='9132' >
<div align="center">
<span id="mark_link_9132" class="mark_unmark_link" onclick="mark_unmark_lead(9132)" mode='mark' leads_name="#9132 Jo  McInnes">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9132
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9132&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jo  McInnes </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">info@shecommerce.com.au</span><br />
139INBOUNDCALL<br />Mobile 0419 333 659</td>

<td class="sorted date_updated" >2013-03-20</td>

<td class="sorted timestamp">
<span >2013-03-20</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9132');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9132" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9132'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9132);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9132');">
</div>
<div id='9132_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9132',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/20/2013  BP : Walter researching, 2 months away from ready</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='9128' >
<div align="center">
<span id="mark_link_9128" class="mark_unmark_link" onclick="mark_unmark_lead(9128)" mode='mark' leads_name="#9128 Steve  Growcott">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9128
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9128&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Steve  Growcott </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">steve.growcott@ninelanterns.com.au</span><br />
139INBOUNDCALL<br />Office No. 03 8689 9404<br />Mobile 0413 389 719 </td>

<td class="sorted date_updated" >2013-03-20</td>

<td class="sorted timestamp">
<span >2013-03-19</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9128');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9128" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9128'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9128);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9128');">
</div>
<div id='9128_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9128',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/19/2013  BP : Walter Will complete JS form</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2155</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1597&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=2155',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='9125' >
<div align="center">
<span id="mark_link_9125" class="mark_unmark_link" onclick="mark_unmark_lead(9125)" mode='mark' leads_name="#9125 Paul  Baril">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9125
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9125&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Paul  Baril </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">paul@cashstop.com.au</span><br />
139INBOUNDCALL<br /></td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-03-18</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9125');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9125" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9125'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9125);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9125');">
</div>
<div id='9125_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9125',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/18/2013  BP : Walter reviewing needs</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' onClick='check_val()' name='users' value='9119' >
<div align="center">
<span id="mark_link_9119" class="mark_unmark_link" onclick="mark_unmark_lead(9119)" mode='mark' leads_name="#9119 George  Burraws">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9119
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9119&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">George  Burraws </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">e-trader@live.com</span><br />
101<br />Mobile 0410578917</td>

<td class="sorted date_updated" >2013-03-18</td>

<td class="sorted timestamp">
<span >2013-03-17</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9119');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9119" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9119'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9119);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9119');">
</div>
<div id='9119_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9119',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/18/2013  BP : Walter Will comp JS form</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2149</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1590&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=2149',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
5
<input type='checkbox' onClick='check_val()' name='users' value='9100' >
<div align="center">
<span id="mark_link_9100" class="mark_unmark_link" onclick="mark_unmark_lead(9100)" mode='mark' leads_name="#9100 Cathy  Galbraith">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9100
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9100&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Cathy  Galbraith </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">cathy@vteamalliance.com</span><br />
101<br />Mobile 0418 718 513</td>

<td class="sorted date_updated" >2013-03-14</td>

<td class="sorted timestamp">
<span >2013-03-12</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9100');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9100" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9100'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9100);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9100');">
</div>
<div id='9100_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9100',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/14/2013  BP : Walter will review candidates and comp JS form</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
6
<input type='checkbox' onClick='check_val()' name='users' value='9096' >
<div align="center">
<span id="mark_link_9096" class="mark_unmark_link" onclick="mark_unmark_lead(9096)" mode='mark' leads_name="#9096 Charles  Reynolds">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9096
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9096&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Charles  Reynolds </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">sales@florescence.com.au</span><br />
101<br />Office No. 08 9841 1938<br />Mobile 0417 231 720</td>

<td class="sorted date_updated" >2013-03-12</td>

<td class="sorted timestamp">
<span >2013-03-12</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9096');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9096" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9096'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9096);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9096');">
</div>
<div id='9096_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9096',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/12/2013  BP : Walter LNN and email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
7
<input type='checkbox' onClick='check_val()' name='users' value='9090' >
<div align="center">
<span id="mark_link_9090" class="mark_unmark_link" onclick="mark_unmark_lead(9090)" mode='mark' leads_name="#9090 Joe  Kizana">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9090
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9090&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Joe  Kizana </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">jkizana@hotmail.com</span><br />
139INBOUNDCALL<br />Mobile 0410 787 744</td>

<td class="sorted date_updated" >2013-03-11</td>

<td class="sorted timestamp">
<span >2013-03-08</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9090');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9090" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9090'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9090);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9090');">
</div>
<div id='9090_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9090',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/11/2013  BP : Walter Is reviewing needs to make sure he has sufficient work for a part</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2128</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1570&jr_cat_id=4&jr_list_id=103&gs_job_role_selection_id=2128',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Architecture</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
8
<input type='checkbox' onClick='check_val()' name='users' value='9084' >
<div align="center">
<span id="mark_link_9084" class="mark_unmark_link" onclick="mark_unmark_lead(9084)" mode='mark' leads_name="#9084 Hilary  Poeton">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9084
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9084&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Hilary  Poeton </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">hpoeton@gmail.com</span><br />
139ClientReferral<br />Mobile 0417 917 232</td>

<td class="sorted date_updated" >2013-03-08</td>

<td class="sorted timestamp">
<span >2013-03-07</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9084');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9084" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9084'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9084);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9084');">
</div>
<div id='9084_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9084',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/8/2013  BP : Walter Assessing tasks, possibly after Easter</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
9
<input type='checkbox' onClick='check_val()' name='users' value='9066' >
<div align="center">
<span id="mark_link_9066" class="mark_unmark_link" onclick="mark_unmark_lead(9066)" mode='mark' leads_name="#9066 Lian  Monley">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9066
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9066&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lian  Monley </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">info@lianmonleywellbeing.com</span><br />
139INBOUNDCALL<br />Mobile 0407 229 906</td>

<td class="sorted date_updated" >2013-03-13</td>

<td class="sorted timestamp">
<span >2013-03-04</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9066');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9066" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9066'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9066);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9066');">
</div>
<div id='9066_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9066',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/13/2013  BP : Walter sent whats up email.</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
10
<input type='checkbox' onClick='check_val()' name='users' value='9060' >
<div align="center">
<span id="mark_link_9060" class="mark_unmark_link" onclick="mark_unmark_lead(9060)" mode='mark' leads_name="#9060 Sharbel  Chehade">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9060
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9060&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Sharbel  Chehade </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">sharbel.chehade@technicorp.com.au</span><br />
139INBOUNDCALL<br />Mobile 0400 800 111</td>

<td class="sorted date_updated" >2013-03-01</td>

<td class="sorted timestamp">
<span >2013-03-01</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9060');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9060" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9060'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9060);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9060');">
</div>
<div id='9060_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9060',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/1/2013  BP : Walter Reviewing needs</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
11
<input type='checkbox' onClick='check_val()' name='users' value='9052' >
<div align="center">
<span id="mark_link_9052" class="mark_unmark_link" onclick="mark_unmark_lead(9052)" mode='mark' leads_name="#9052 Chris  Vassiliadis">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9052
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9052&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Chris  Vassiliadis </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">Chris@m2k.com.au</span><br />
139ClientReferral<br />Office No. 1300 890 534<br /></td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-02-27</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9052');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9052" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9052'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9052);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9052');">
</div>
<div id='9052_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9052',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/27/2013  BP : Walter Apt set for the 15/3</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
12
<input type='checkbox' onClick='check_val()' name='users' value='9046' >
<div align="center">
<span id="mark_link_9046" class="mark_unmark_link" onclick="mark_unmark_lead(9046)" mode='mark' leads_name="#9046 Adele  McConnell-Cummins">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9046
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9046&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Adele  McConnell-Cummins </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">adele@vegiehead.com</span><br />
139EmailReceived_RS<br />Mobile 0416 100 271</td>

<td class="sorted date_updated" >2013-02-25</td>

<td class="sorted timestamp">
<span >2013-02-25</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9046');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9046" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9046'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9046);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9046');">
</div>
<div id='9046_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9046',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/25/2013  BP : Walter Will review needs</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
13
<input type='checkbox' onClick='check_val()' name='users' value='9043' >
<div align="center">
<span id="mark_link_9043" class="mark_unmark_link" onclick="mark_unmark_lead(9043)" mode='mark' leads_name="#9043 Evelyn  Reid">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9043
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9043&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Evelyn  Reid </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">evelyn@creditratingrepairaustralia.com.au</span><br />
101<br />Mobile 0400 177 444</td>

<td class="sorted date_updated" >2013-03-20</td>

<td class="sorted timestamp">
<span >2013-02-25</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
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
<div align='right' ><a href="javascript: toggle('note_form_9043');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9043" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9043'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9043);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9043');">
</div>
<div id='9043_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9043',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/25/2013  BP : Walter Currently not enough work</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2086</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1534&jr_cat_id=1&jr_list_id=1&gs_job_role_selection_id=2086',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div><div><strong>Custom Recruitment Order #2158</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1600&jr_cat_id=1&jr_list_id=1&gs_job_role_selection_id=2158',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
14
<input type='checkbox' onClick='check_val()' name='users' value='9042' >
<div align="center">
<span id="mark_link_9042" class="mark_unmark_link" onclick="mark_unmark_lead(9042)" mode='mark' leads_name="#9042 Rodney  Goodall">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9042
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9042&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Rodney  Goodall </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">rodius@yahoo.com</span><br />
101<br />Mobile 0401 923 127</td>

<td class="sorted date_updated" >2013-03-07</td>

<td class="sorted timestamp">
<span >2013-02-25</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9042');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9042" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9042'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9042);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9042');">
</div>
<div id='9042_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9042',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/7/2013  BP : Walter moving, needs about 5 weeks and will be ready to start</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2087</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1535&jr_cat_id=2&jr_list_id=6&gs_job_role_selection_id=2087',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">PHP Developer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
15
<input type='checkbox' onClick='check_val()' name='users' value='9035' >
<div align="center">
<span id="mark_link_9035" class="mark_unmark_link" onclick="mark_unmark_lead(9035)" mode='mark' leads_name="#9035 Steve  Voegt">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9035
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9035&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Steve  Voegt </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">sv@cbdata.com.au</span><br />
139LiveChatRS<br />Mobile 0414 513 648</td>

<td class="sorted date_updated" >2013-02-22</td>

<td class="sorted timestamp">
<span >2013-02-22</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9035');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9035" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9035'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9035);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9035');">
</div>
<div id='9035_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9035',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/22/2013  BP : Walter reviewing needs</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
16
<input type='checkbox' onClick='check_val()' name='users' value='9029' >
<div align="center">
<span id="mark_link_9029" class="mark_unmark_link" onclick="mark_unmark_lead(9029)" mode='mark' leads_name="#9029 Grant  Laing">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9029
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9029&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Grant  Laing </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">grant@blendedit.com.au</span><br />
101<br />Office No. 07 3453 4125<br />Mobile 0421 175 817</td>

<td class="sorted date_updated" >2013-03-14</td>

<td class="sorted timestamp">
<span >2013-02-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9029');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9029" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9029'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9029);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9029');">
</div>
<div id='9029_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9029',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/13/2013  BP : Walter LNN and sent email</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2142</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1581&jr_cat_id=2&jr_list_id=42&gs_job_role_selection_id=2142',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">.Net Developer</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1582&jr_cat_id=4&jr_list_id=201&gs_job_role_selection_id=2142',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Technical Support</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
17
<input type='checkbox' onClick='check_val()' name='users' value='9024' >
<div align="center">
<span id="mark_link_9024" class="mark_unmark_link" onclick="mark_unmark_lead(9024)" mode='mark' leads_name="#9024 Paul  Busingye">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9024
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9024&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Paul  Busingye </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">paulb@sydneyfishmarket.com.au</span><br />
139INBOUNDCALL<br />Office No. 02 9004 1143<br /></td>

<td class="sorted date_updated" >2013-02-21</td>

<td class="sorted timestamp">
<span >2013-02-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9024');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9024" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9024'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9024);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9024');">
</div>
<div id='9024_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9024',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/21/2013  BP : Walter will discuss with associates</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
18
<input type='checkbox' onClick='check_val()' name='users' value='9022' >
<div align="center">
<span id="mark_link_9022" class="mark_unmark_link" onclick="mark_unmark_lead(9022)" mode='mark' leads_name="#9022 Peter  Wellman">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9022
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9022&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Peter  Wellman </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">peter@victoriankitchencompany.com.au</span><br />
101<br />Mobile 0415 975 277</td>

<td class="sorted date_updated" >2013-02-22</td>

<td class="sorted timestamp">
<span >2013-02-21</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9022');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9022" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9022'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9022);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9022');">
</div>
<div id='9022_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9022',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/21/2013  BP : Walter Reviewing reviewing needs</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
19
<input type='checkbox' onClick='check_val()' name='users' value='9016' >
<div align="center">
<span id="mark_link_9016" class="mark_unmark_link" onclick="mark_unmark_lead(9016)" mode='mark' leads_name="#9016 Dominic  Littlewood">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9016
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9016&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Dominic  Littlewood </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">dominic.littlewood@sales.canon.com.au</span><br />
139referredbynonclient<br />Office No. 0404 329 713<br /></td>

<td class="sorted date_updated" >2013-02-20</td>

<td class="sorted timestamp">
<span >2013-02-20</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9016');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9016" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9016'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9016);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9016');">
</div>
<div id='9016_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9016',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/20/2013  BP : Walter linked to Jarrad Brown #4142</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
20
<input type='checkbox' onClick='check_val()' name='users' value='9008' >
<div align="center">
<span id="mark_link_9008" class="mark_unmark_link" onclick="mark_unmark_lead(9008)" mode='mark' leads_name="#9008 Cheryl  Brookes">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9008
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9008&lead_status=Follow-Up" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Cheryl  Brookes </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">cheryl@onlinecoursesaustralia.com.au</span><br />
139INBOUNDCALL<br />Office No. 07 3199 9659<br />Mobile 0406 422 727</td>

<td class="sorted date_updated" >2013-02-25</td>

<td class="sorted timestamp">
<span >2013-02-18</span>
</td>


<td class="actions">
<div class="identical"></div>
Follow-Up<br />
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
<div align='right' ><a href="javascript: toggle('note_form_9008');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9008" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9008'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9008);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9008');">
</div>
<div id='9008_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9008',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/25/2013  BP : Walter Looking processes and organising schedule.</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2066</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1516&jr_cat_id=4&jr_list_id=186&gs_job_role_selection_id=2066',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Customer Service</a></li></ol></div></div>
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