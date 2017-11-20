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
		<a href="/portal/bubblehelp/bhelp.php?/create_page/&curl=leads_list/index.php?lead_status=custom" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"+recruitment" title="Open Help Page" >Help Page</a>
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
																							    <img src='images/star.png' border='0'  >
												            												            												            												            												            
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
		        	    <option value="custom recruitment" selected="selected">Custom Recruitment</option>
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
	            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Follow-Up" disabled="disabled" onclick="Move('Follow-Up')" class="button" />
	            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Keep In-Touch" disabled="disabled" onclick="Move('Keep In-Touch')" class="button" />
	            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Pending" disabled="disabled" onclick="Move('pending')" class="button" />
	            <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="move" id="move" value="Move to Asl" disabled="disabled" onclick="Move('asl')" class="button" />
	    <input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name="transfer" id="transfer" disabled="disabled" value="Tranfer to" onClick="return CheckBP();"  class="button"> <select name="agent_id" id="agent_id" style="width:200px;" disabled="disabled" >
<option value="">Business Developer</option>
<option value='2'>Chris Jankulovski</option><option value='44'>Walter Fulmizi</option><option value='343'>Michael Burns</option><option value='402'>Kenneth Tubio</option><option value='426'>Rendall Young</option>
</select>
</p>
</fieldset></div>
<br clear="all" />
<h2 align="center">
    custom recruitment
</h2>

<p align="center">There are <strong>0</strong> <span style="text-transform:capitalize;">custom recruitment</span> today March 21, 2013








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
<th >3 Marked leads found..</th>
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
<input type='checkbox' onClick='check_val()' name='users' value='9118' >
<div align="center">
<span id="mark_link_9118" class="mark_unmark_link" onclick="mark_unmark_lead(9118)" mode='mark' leads_name="#9118 Stephen  Esketzis">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
</td>

<td class="ids">
9118
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9118&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Stephen  Esketzis </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">admin@meggle.com.au</span><br />
101<br />Office No. 61422097234<br />Mobile 61422097234</td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-03-16</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
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
<div align='right' ><a href="javascript: toggle('note_form_9118');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9118" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9118'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9118);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9118');">
</div>
<div id='9118_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
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
<div class="identical"><div>Identical Name to : <br><a href="../leads_information.php?id=8595&lead_status=New Leads&url=leads_list/index.php?lead_status=custom" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;"+recruitment'>#8595 Billy Evans [New Leads]</a></div></div>
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
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8594);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8594');">
</div>
<div id='8594_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1532</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1081&jr_cat_id=1&jr_list_id=12&gs_job_role_selection_id=1532',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
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
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8585);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8585');">
</div>
<div id='8585_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8585',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/3/2012  BP : Rendall Left VM</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1525</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1076&jr_cat_id=1&jr_list_id=13&gs_job_role_selection_id=1525',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr>
</tbody>
</table>

</div>

<div style="clear:both;background:#BBCCFF; height:20px;">&nbsp;</div>

<div class="list_list_holder">

<span><a name="UNMARKED">UNMARKED LEADS</a> [ 123 Records ] <select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'  >
<option value="1"  selected="selected" >Page 1</option>
<option value="2" >Page 2</option>
<option value="3" >Page 3</option>
<option value="4" >Page 4</option>
<option value="5" >Page 5</option>
<option value="6" >Page 6</option>
<option value="7" >Page 7</option>
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
<input type='checkbox' onClick='check_val()' name='users' value='9128' >
<div align="center">
<span id="mark_link_9128" class="mark_unmark_link" onclick="mark_unmark_lead(9128)" mode='mark' leads_name="#9128 Steve  Growcott">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9128
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9128&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Steve  Growcott </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">steve.growcott@ninelanterns.com.au</span><br />
139INBOUNDCALL<br />Office No. 03 8689 9404<br />Mobile 0413 389 719 </td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span >2013-03-19</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9128');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9128" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9128'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9128);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9128');">
</div>
<div id='9128_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9128',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/21/2013  BP : Walter Jobstart Michelle</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2155</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1597&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=2155',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='9126' >
<div align="center">
<span id="mark_link_9126" class="mark_unmark_link" onclick="mark_unmark_lead(9126)" mode='mark' leads_name="#9126 Grant  O'Neill">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9126
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9126&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Grant  O'Neill </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">grant@go-creative.com.au</span><br />
101<br />Office No. (07) 3333 2932<br />Mobile 0421 187 670</td>

<td class="sorted date_updated" >2013-03-18</td>

<td class="sorted timestamp">
<span >2013-03-18</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9126');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9126" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9126'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9126);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9126');">
</div>
<div id='9126_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2151</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1592&jr_cat_id=2&jr_list_id=6&gs_job_role_selection_id=2151',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">PHP Developer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='9123' >
<div align="center">
<span id="mark_link_9123" class="mark_unmark_link" onclick="mark_unmark_lead(9123)" mode='mark' leads_name="#9123 Kiran  Chauhan">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9123
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9123&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kiran  Chauhan </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">kiranchauhan0@gmail.com</span><br />
139LiveChatRS<br />Mobile 0431 158 178</td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-03-18</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9123');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9123" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9123'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9123);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9123');">
</div>
<div id='9123_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9123',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/19/2013  BP : Walter Job start Michelle</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2148</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1594&jr_cat_id=4&jr_list_id=313&gs_job_role_selection_id=2148',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Combination of C#, .Net, Javascript</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1595&jr_cat_id=4&jr_list_id=177&gs_job_role_selection_id=2148',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">SEO</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1596&jr_cat_id=4&jr_list_id=207&gs_job_role_selection_id=2148',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' onClick='check_val()' name='users' value='9115' >
<div align="center">
<span id="mark_link_9115" class="mark_unmark_link" onclick="mark_unmark_lead(9115)" mode='mark' leads_name="#9115 Michael  Haines">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9115
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9115&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Michael  Haines </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">michael@workspacecommunications.com</span><br />
101RECRUITMENTSERVICE<br />Office No. 9139567980<br />Mobile 9132448974</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span >2013-03-15</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9115');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9115" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9115'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9115);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9115');">
</div>
<div id='9115_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2147</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1587&jr_cat_id=2&jr_list_id=93&gs_job_role_selection_id=2147',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Microsoft Certified</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
5
<input type='checkbox' onClick='check_val()' name='users' value='9112' >
<div align="center">
<span id="mark_link_9112" class="mark_unmark_link" onclick="mark_unmark_lead(9112)" mode='mark' leads_name="#9112 Scott  Darwon">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9112
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9112&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Scott  Darwon </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">scott.darwon@raywhite.com</span><br />
101<br />Mobile 0401 151 090</td>

<td class="sorted date_updated" >2013-03-20</td>

<td class="sorted timestamp">
<span >2013-03-14</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9112');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9112" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9112'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9112);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9112');">
</div>
<div id='9112_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9112',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/18/2013  BP : Walter Job start Simon</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2145</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1586&jr_cat_id=1&jr_list_id=1&gs_job_role_selection_id=2145',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
6
<input type='checkbox' onClick='check_val()' name='users' value='9102' >
<div align="center">
<span id="mark_link_9102" class="mark_unmark_link" onclick="mark_unmark_lead(9102)" mode='mark' leads_name="#9102 Brad  Hull">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9102
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9102&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Brad  Hull </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">brad@dynamicorange.com.au</span><br />
101RECRUITMENTSERVICE<br />Office No. 0424170545<br />Mobile 0424170545</td>

<td class="sorted date_updated" ></td>

<td class="sorted timestamp">
<span >2013-03-13</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9102');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9102" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9102'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9102);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9102');">
</div>
<div id='9102_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
7
<input type='checkbox' onClick='check_val()' name='users' value='9101' >
<div align="center">
<span id="mark_link_9101" class="mark_unmark_link" onclick="mark_unmark_lead(9101)" mode='mark' leads_name="#9101 Simon  Chamaa">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9101
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9101&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Simon  Chamaa </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">simonc@strataplan.com.au</span><br />
139ClientReferral<br />Office No. 1300 278 728<br />Mobile 0413 448 899</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span >2013-03-12</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9101');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9101" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9101'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9101);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9101');">
</div>
<div id='9101_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9101',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/15/2013  BP : Walter Job start Simon</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2137</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1578&jr_cat_id=2&jr_list_id=42&gs_job_role_selection_id=2137',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">.Net Developer</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1579&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=2137',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=GP18HZ7C96M9CVLZHXEK5VXKKFI4YcaHCMZBIXGYG14b3' target='_blank'> - 20th Mar 13 12:48 PM quote given Full-Time Virtual Assistany :  $ AUD 1278.05</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2013-03-20<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=2663PGAPIa67Z1XYBDIUPN0EE0D6RKWW27WJT59C1UDO6' target='_blank' class=''>- 12:48 PM Service Agreement # 2158</a><br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
8
<input type='checkbox' onClick='check_val()' name='users' value='9091' >
<div align="center">
<span id="mark_link_9091" class="mark_unmark_link" onclick="mark_unmark_lead(9091)" mode='mark' leads_name="#9091 Mavis  Wong">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9091
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9091&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Mavis  Wong </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">mavis@safercosmeticsurgery.co.uk</span><br />
101HOMEPAGEENQUIRY<br />Mobile +442071932074</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span >2013-03-08</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9091');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9091" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9091'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9091);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9091');">
</div>
<div id='9091_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9091',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/14/2013  BP : Walter will complete JS form</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2134</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1584&jr_cat_id=1&jr_list_id=24&gs_job_role_selection_id=2134',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
9
<input type='checkbox' onClick='check_val()' name='users' value='9057' >
<div align="center">
<span id="mark_link_9057" class="mark_unmark_link" onclick="mark_unmark_lead(9057)" mode='mark' leads_name="#9057 Recel  Tayor">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9057
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9057&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Recel  Tayor </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">recel@syd.vitalpartners.com.au</span><br />
139ClientReferral<br />Office No. 02 9017 8444<br />Mobile 0422 488 990</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span >2013-03-01</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9057');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9057" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9057'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9057);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9057');">
</div>
<div id='9057_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9057',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/6/2013  BP : Walter Job start PJ</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2114</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1560&jr_cat_id=1&jr_list_id=1&gs_job_role_selection_id=2114',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1561&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=2114',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
10
<input type='checkbox' onClick='check_val()' name='users' value='9053' >
<div align="center">
<span id="mark_link_9053" class="mark_unmark_link" onclick="mark_unmark_lead(9053)" mode='mark' leads_name="#9053 Kerry  Spero">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9053
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9053&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Kerry  Spero </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">kerrys@accentsoftware.com.au</span><br />
139INBOUNDCALL<br />Office No. 02 9850 4933<br />Mobile 0410 410 495</td>

<td class="sorted date_updated" >2013-03-15</td>

<td class="sorted timestamp">
<span >2013-02-27</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9053');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9053" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9053'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9053);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9053');">
</div>
<div id='9053_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9053',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/6/2013  BP : Walter Job start PJ</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2092</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1559&jr_cat_id=2&jr_list_id=42&gs_job_role_selection_id=2092',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">.Net Developer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
11
<input type='checkbox' onClick='check_val()' name='users' value='9027' >
<div align="center">
<span id="mark_link_9027" class="mark_unmark_link" onclick="mark_unmark_lead(9027)" mode='mark' leads_name="#9027 Paul  Ayris">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9027
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9027&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Paul  Ayris </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">paul@myhostingsolutions.com.au</span><br />
101INBOUNDCALL<br />Mobile 0468395130</td>

<td class="sorted date_updated" >2013-03-13</td>

<td class="sorted timestamp">
<span >2013-02-21</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>CUSTOM ORDER : IN PROGRESS<br></div></div>
<!--
<div>
</div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_9027');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9027" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9027'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9027);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9027');">
</div>
<div id='9027_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2079</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1531&jr_cat_id=2&jr_list_id=19&gs_job_role_selection_id=2079',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Web Designer</a></li></ol></div><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=BZb3ccL1B7MDKPJYZEaU81G51D4RISYOU0HDSBDT900Bb' target='_blank'> - 26th Feb 13 04:03 PM quote given Full-Time Web Developer :  $ AUD 1131.71</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2013-02-26<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=2XHDbV2V0FUOJS8bV93OPH8XXC3IM8F2LMCG1VL3IWN7C' target='_blank' class=''>- 04:03 PM Service Agreement # 2127</a><br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
12
<input type='checkbox' onClick='check_val()' name='users' value='9018' >
<div align="center">
<span id="mark_link_9018" class="mark_unmark_link" onclick="mark_unmark_lead(9018)" mode='mark' leads_name="#9018 Cid  Daher">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9018
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9018&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Cid  Daher </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">cid@grannyflatsaustralia.com.au</span><br />
101INBOUNDCALL<br />Office No. 02 8824 3428<br />Mobile 0414 571 871</td>

<td class="sorted date_updated" >2013-03-06</td>

<td class="sorted timestamp">
<span >2013-02-20</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9018');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9018" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9018'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9018);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9018');">
</div>
<div id='9018_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9018',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/25/2013  BP : Walter asked Ryan for an update</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2074</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1525&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=2074',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
13
<input type='checkbox' onClick='check_val()' name='users' value='9002' >
<div align="center">
<span id="mark_link_9002" class="mark_unmark_link" onclick="mark_unmark_lead(9002)" mode='mark' leads_name="#9002 Isaac  Balbin">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
9002
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9002&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Isaac  Balbin </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">RFBalbin@Gmail.com</span><br />
101<br />Mobile 0403 197 799</td>

<td class="sorted date_updated" >2013-03-20</td>

<td class="sorted timestamp">
<span >2013-02-17</span>
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
<div align='right' ><a href="javascript: toggle('note_form_9002');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9002" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9002'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9002);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9002');">
</div>
<div id='9002_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9002',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/6/2013  BP : Walter 4 weeks away from restart of hiring</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
14
<input type='checkbox' onClick='check_val()' name='users' value='9000' >
<div align="center">
<span id="mark_link_9000" class="mark_unmark_link" onclick="mark_unmark_lead(9000)" mode='mark' leads_name="#9000 Rebecca  Cawood">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
9000
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=9000&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Rebecca  Cawood </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">info@photobooth2u.com.au</span><br />
101<br />Office No. 0732932466<br />Mobile 0416 237 229</td>

<td class="sorted date_updated" >2013-03-21</td>

<td class="sorted timestamp">
<span >2013-02-16</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>CUSTOM ORDER : NEW!!!<br>CUSTOM ORDER : IN PROGRESS<br></div></div>
<!--
<div>
 <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p></div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_9000');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_9000" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_9000'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(9000);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_9000');">
</div>
<div id='9000_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=9000',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/18/2013  BP : Walter Job start Michelle</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2065</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1515&jr_cat_id=4&jr_list_id=307&gs_job_role_selection_id=2065',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Vitual Assitant/SEO/Web Assitance</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
15
<input type='checkbox' onClick='check_val()' name='users' value='8999' >
<div align="center">
<span id="mark_link_8999" class="mark_unmark_link" onclick="mark_unmark_lead(8999)" mode='mark' leads_name="#8999 Jason  Hardie">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8999
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8999&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jason  Hardie </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">contact@jasonhardie.com</span><br />
101<br />Mobile 0427 258 320</td>

<td class="sorted date_updated" >2013-03-12</td>

<td class="sorted timestamp">
<span >2013-02-16</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8999');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8999" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8999'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8999);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8999');">
</div>
<div id='8999_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8999',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/8/2013  BP : Walter job start PJ</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2123</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1569&jr_cat_id=2&jr_list_id=6&gs_job_role_selection_id=2123',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">PHP Developer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
16
<input type='checkbox' onClick='check_val()' name='users' value='8990' >
<div align="center">
<span id="mark_link_8990" class="mark_unmark_link" onclick="mark_unmark_lead(8990)" mode='mark' leads_name="#8990 Paul  Jones">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8990
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8990&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Paul  Jones </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">regalmediainfo@gmail.com</span><br />
139INBOUNDCALL<br />Mobile 0424 994 945</td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-02-14</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8990');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8990" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8990'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8990);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8990');">
</div>
<div id='8990_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8990',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/14/2013  BP : Walter Job start Michelle</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
17
<input type='checkbox' onClick='check_val()' name='users' value='8989' >
<div align="center">
<span id="mark_link_8989" class="mark_unmark_link" onclick="mark_unmark_lead(8989)" mode='mark' leads_name="#8989 Robert  De Burgh-Day">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8989
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8989&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Robert  De Burgh-Day </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">Rob@starecruitment.com.au</span><br />
101INBOUNDCALL<br />Office No. 0423946152<br /></td>

<td class="sorted date_updated" >2013-02-19</td>

<td class="sorted timestamp">
<span >2013-02-14</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8989');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8989" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8989'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8989);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8989');">
</div>
<div id='8989_latest_notes'></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
18
<input type='checkbox' onClick='check_val()' name='users' value='8984' >
<div align="center">
<span id="mark_link_8984" class="mark_unmark_link" onclick="mark_unmark_lead(8984)" mode='mark' leads_name="#8984 Joe  Dipierdomenico">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8984
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8984&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Joe  Dipierdomenico </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">joe@diaoro.com.au</span><br />
139EmailReceived_RS<br />Office No. +61 3 9465 6111 (angus)<br />Mobile 0411 636 634 / 61 (0) 422 612 835 (angus)</td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-02-14</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
<div align="center">www.remotestaff.com.au</div>
<div><img src='../images/OrderInProgress.png' style='float:left;' align='texttop' width='33' height='48'  /><div style='display:block;float:left;margin-left:7px;font-weight:bold;'>CUSTOM ORDER : NEW!!!<br>CUSTOM ORDER : IN PROGRESS<br></div></div>
<!--
<div>
 <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p></div>
-->
<div class="pin">



</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_8984');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8984" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8984'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8984);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8984');">
</div>
<div id='8984_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8984',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/20/2013  BP : Walter JOB start Michelle</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2072</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1521&jr_cat_id=4&jr_list_id=191&gs_job_role_selection_id=2072',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Data Entry</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1522&jr_cat_id=3&jr_list_id=11&gs_job_role_selection_id=2072',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Accountant</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1523&jr_cat_id=3&jr_list_id=11&gs_job_role_selection_id=2072',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Accountant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
19
<input type='checkbox' onClick='check_val()' name='users' value='8980' >
<div align="center">
<span id="mark_link_8980" class="mark_unmark_link" onclick="mark_unmark_lead(8980)" mode='mark' leads_name="#8980 Greg  Weiss">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8980
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8980&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Greg  Weiss </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">gregw@thefirstfewseconds.com</span><br />
139INBOUNDCALL<br />Mobile 0416 278 278</td>

<td class="sorted date_updated" >2013-02-28</td>

<td class="sorted timestamp">
<span >2013-02-13</span>
</td>


<td class="actions">
<div class="identical"></div>
custom recruitment<br />
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
<div align='right' ><a href="javascript: toggle('note_form_8980');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8980" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8980'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8980);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8980');">
</div>
<div id='8980_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8980',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">02/14/2013  BP : Walter Job start Michelle</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #2054</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1504&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=2054',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1505&jr_cat_id=4&jr_list_id=206&gs_job_role_selection_id=2054',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Virtual Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
20
<input type='checkbox' onClick='check_val()' name='users' value='8973' >
<div align="center">
<span id="mark_link_8973" class="mark_unmark_link" onclick="mark_unmark_lead(8973)" mode='mark' leads_name="#8973 Clinton  Shilliday">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8973
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8973&lead_status=custom recruitment" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Clinton  Shilliday </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">clinton@digital-shift.com</span><br />
139ClientReferral<br />Mobile 0434 521 531</td>

<td class="sorted date_updated" >2013-03-19</td>

<td class="sorted timestamp">
<span >2013-02-12</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8973');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8973" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8973'></textarea></p>
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8973);">
<input type="button" style="cursor:pointer" onclick="alert('disabled');return false;" onmouseout="" oncontextmenu="return false;" class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8973');">
</div>
<div id='8973_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8973',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">03/19/2013  BP : Walter sent whats up email</a></div>
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