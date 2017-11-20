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
												            												            							<a href="index.php?lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;" id="navselected">Keep In-Touch</a>
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
<input type="hidden" name="path" id="path" value="lead_status=Keep In-Touch" />
<input type="hidden" name="applicants" id="applicants">
<input type="hidden" name="status" id="status" >
<div class="form_filters">
<fieldset><legend>SEARCH FILTERS</legend>
<p >Search Leads : 
<select name="lead_status" id="lead_status" style="width:120px;">
    <option value="All">All</option>        	    <option value="Keep In-Touch" selected="selected">Keep In-Touch</option>
		        	    <option value="Client" >Client</option>
		        	    <option value="Inactive" >Inactive</option>
		        	    <option value="REMOVED" >REMOVED</option>
		        	    <option value="Contacted Lead" >Contacted Lead</option>
		        	    <option value="Follow-Up" >Follow-Up</option>
		        	    <option value="New Leads" >New Leads</option>
		            	    <option value="transferred" >Transferred</option>
		        	    <option value="pending" >Pending</option>
		        	    <option value="custom recruitment" >Custom Recruitment</option>
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
    Keep In-Touch
</h2>

<p align="center">There are <strong>0</strong> <span style="text-transform:capitalize;">keep in-touch</span> today October  4, 2012








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
<th >5 Marked leads found..</th>
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
<input type='checkbox' onClick='check_val()' name='users' value='8489' >
<div align="center">
<span id="mark_link_8489" class="mark_unmark_link" onclick="mark_unmark_lead(8489)" mode='mark' leads_name="#8489 Jason  Mailey">Add Pin</span>
</div>
<!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

<td class="ids">
8489
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8489&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jason  Mailey </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">jason.mailey@ubteam.com</span><br />
101AVAILABLESTAFF<br />Office No. 866-996-6336<br />Mobile 2044679993</td>

<td class="sorted date_updated" >2012-10-01</td>

<td class="sorted timestamp">
<span >2012-09-06</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8489');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8489" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8489'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8489);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8489');">
</div>
<div id='8489_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1373</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1009&jr_cat_id=2&jr_list_id=53&gs_job_role_selection_id=1373',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">C# Developer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
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
3
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
4
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
5
<input type='checkbox' onClick='check_val()' name='users' value='5886' >
<div align="center">
<span id="mark_link_5886" class="mark_unmark_link" onclick="mark_unmark_lead(5886)" mode='mark' leads_name="#5886 Anjali  Daryanani">Add Pin</span>
</div>
 <img src="./media/images/important_icon2.gif" title="Marked" /><!---->
 <img src="./media/images/question-flag.png" title="Ask A Question" /></td>

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
</tr>
</tbody>
</table>

</div>

<div style="clear:both;background:#BBCCFF; height:20px;">&nbsp;</div>

<div class="list_list_holder">

<span><a name="UNMARKED">UNMARKED LEADS</a> [ 3719 Records ] <select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'  >
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
<input type='checkbox' onClick='check_val()' name='users' value='8582' >
<div align="center">
<span id="mark_link_8582" class="mark_unmark_link" onclick="mark_unmark_lead(8582)" mode='mark' leads_name="#8582 Mick  Cullen">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8582
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8582&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Mick  Cullen </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">mick@cullen.net.au</span><br />
139ClientReferral<br /></td>

<td class="sorted date_updated" >2012-10-02</td>

<td class="sorted timestamp">
<span >2012-10-01</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8582');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8582" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8582'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8582);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8582');">
</div>
<div id='8582_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8582',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/2/2012  BP : Walter helping Michael Hanson select staff, no need for staff</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
2
<input type='checkbox' onClick='check_val()' name='users' value='8580' >
<div align="center">
<span id="mark_link_8580" class="mark_unmark_link" onclick="mark_unmark_lead(8580)" mode='mark' leads_name="#8580 Alison  Hicks">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8580
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8580&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Alison  Hicks </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">alisonhicks1@gmail.com</span><br />
504<br />Office No. 03 5410 8944<br />Mobile 0425 340 020</td>

<td class="sorted date_updated" >2012-10-04</td>

<td class="sorted timestamp">
<span >2012-09-30</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8580');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8580" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8580'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8580);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8580');">
</div>
<div id='8580_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8580',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/1/2012  BP : Walter Job started - PJ</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1510</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1068&jr_cat_id=1&jr_list_id=2&gs_job_role_selection_id=1510',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Marketing Assistant</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
3
<input type='checkbox' onClick='check_val()' name='users' value='8575' >
<div align="center">
<span id="mark_link_8575" class="mark_unmark_link" onclick="mark_unmark_lead(8575)" mode='mark' leads_name="#8575 Francia  Tuzon">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8575
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8575&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Francia  Tuzon </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">franciatuzon@hotmail.com</span><br />
101<br />Mobile 0411 223 457</td>

<td class="sorted date_updated" >2012-10-01</td>

<td class="sorted timestamp">
<span >2012-09-28</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8575');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8575" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8575'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8575);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8575');">
</div>
<div id='8575_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8575',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/1/2012  BP : Walter needs to identify tasks more clearly</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
4
<input type='checkbox' onClick='check_val()' name='users' value='8572' >
<div align="center">
<span id="mark_link_8572" class="mark_unmark_link" onclick="mark_unmark_lead(8572)" mode='mark' leads_name="#8572 Amanda  Gleeson">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8572
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8572&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Amanda  Gleeson </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">djmissmatch@hotmail.com</span><br />
101<br />Mobile 0402 323 833</td>

<td class="sorted date_updated" >2012-09-28</td>

<td class="sorted timestamp">
<span >2012-09-28</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8572');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8572" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8572'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8572);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8572');">
</div>
<div id='8572_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8572',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/28/2012  BP : Walter One off need, could not assist</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
5
<input type='checkbox' onClick='check_val()' name='users' value='8558' >
<div align="center">
<span id="mark_link_8558" class="mark_unmark_link" onclick="mark_unmark_lead(8558)" mode='mark' leads_name="#8558 Darren  Saul">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8558
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8558&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Darren  Saul </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">darren@saulrecruitment.com.au</span><br />
139ClientReferral<br />Mobile 0414 659 800</td>

<td class="sorted date_updated" >2012-10-01</td>

<td class="sorted timestamp">
<span >2012-09-24</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8558');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8558" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8558'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8558);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8558');">
</div>
<div id='8558_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8558',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">10/1/2012  BP : Walter no req for now</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
6
<input type='checkbox' onClick='check_val()' name='users' value='8548' >
<div align="center">
<span id="mark_link_8548" class="mark_unmark_link" onclick="mark_unmark_lead(8548)" mode='mark' leads_name="#8548 Ganis  Stevens">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8548
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8548&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Ganis  Stevens </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">ganisstevens@mail.com</span><br />
101<br />Office No. 614444444<br />Mobile 61555555</td>

<td class="sorted date_updated" >2012-09-26</td>

<td class="sorted timestamp">
<span >2012-09-22</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8548');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8548" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8548'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8548);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8548');">
</div>
<div id='8548_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8548',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/26/2012  BP : Walter requested one off, sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
7
<input type='checkbox' onClick='check_val()' name='users' value='8539' >
<div align="center">
<span id="mark_link_8539" class="mark_unmark_link" onclick="mark_unmark_lead(8539)" mode='mark' leads_name="#8539 Jay  Singh">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8539
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8539&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jay  Singh </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">anujay_singh@hotmail.com</span><br />
101<br />Mobile 0451 151 336</td>

<td class="sorted date_updated" >2012-09-28</td>

<td class="sorted timestamp">
<span >2012-09-19</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8539');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8539" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8539'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8539);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8539');">
</div>
<div id='8539_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8539',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/28/2012  BP : Walter after a TM servcie</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
8
<input type='checkbox' onClick='check_val()' name='users' value='8532' >
<div align="center">
<span id="mark_link_8532" class="mark_unmark_link" onclick="mark_unmark_lead(8532)" mode='mark' leads_name="#8532 Jim  Cock">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8532
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8532&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jim  Cock </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">jim.cock77@gmail.com</span><br />
101RECRUITMENTSERVICE<br />Mobile 0414 815 094</td>

<td class="sorted date_updated" >2012-09-18</td>

<td class="sorted timestamp">
<span >2012-09-17</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8532');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8532" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8532'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8532);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8532');">
</div>
<div id='8532_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8532',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/18/2012  BP : Walter one off need</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
9
<input type='checkbox' onClick='check_val()' name='users' value='8528' >
<div align="center">
<span id="mark_link_8528" class="mark_unmark_link" onclick="mark_unmark_lead(8528)" mode='mark' leads_name="#8528 Christine  Brown">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8528
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8528&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Christine  Brown </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">chrissy.brown@telstra.com</span><br />
101<br />Mobile 0400 365 851</td>

<td class="sorted date_updated" >2012-09-17</td>

<td class="sorted timestamp">
<span >2012-09-15</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8528');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8528" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8528'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8528);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8528');">
</div>
<div id='8528_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8528',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/17/2012  BP : Walter one off requirement</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
10
<input type='checkbox' onClick='check_val()' name='users' value='8526' >
<div align="center">
<span id="mark_link_8526" class="mark_unmark_link" onclick="mark_unmark_lead(8526)" mode='mark' leads_name="#8526 Jess  Tarn">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8526
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8526&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Jess  Tarn </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">jesstarn@hotmail.com</span><br />
101<br />Mobile 0405 688 265</td>

<td class="sorted date_updated" >2012-09-18</td>

<td class="sorted timestamp">
<span >2012-09-14</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8526');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8526" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8526'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8526);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8526');">
</div>
<div id='8526_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8526',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/17/2012  BP : Walter small one off job</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
11
<input type='checkbox' onClick='check_val()' name='users' value='8521' >
<div align="center">
<span id="mark_link_8521" class="mark_unmark_link" onclick="mark_unmark_lead(8521)" mode='mark' leads_name="#8521 Sam  Gibson">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8521
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8521&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Sam  Gibson </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">sam.gibson5@gmail.com</span><br />
101<br />Office No. 1234<br /></td>

<td class="sorted date_updated" >2012-09-18</td>

<td class="sorted timestamp">
<span >2012-09-13</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8521');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8521" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8521'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8521);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8521');">
</div>
<div id='8521_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8521',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/13/2012  BP : Walter sent email re trial</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
12
<input type='checkbox' onClick='check_val()' name='users' value='8520' >
<div align="center">
<span id="mark_link_8520" class="mark_unmark_link" onclick="mark_unmark_lead(8520)" mode='mark' leads_name="#8520 Lynn  Gluhak">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8520
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8520&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lynn  Gluhak </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">lynn@gluhak.id.au</span><br />
139INBOUNDCALL<br />Office No. 02 6161 7363<br /></td>

<td class="sorted date_updated" >2012-09-13</td>

<td class="sorted timestamp">
<span >2012-09-13</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8520');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8520" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8520'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8520);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8520');">
</div>
<div id='8520_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8520',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/13/2012  BP : Walter one off requirement</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
13
<input type='checkbox' onClick='check_val()' name='users' value='8516' >
<div align="center">
<span id="mark_link_8516" class="mark_unmark_link" onclick="mark_unmark_lead(8516)" mode='mark' leads_name="#8516 David  Dunford">Add Pin</span>
</div>
<!-- <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />-->
</td>

<td class="ids">
8516
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8516&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">David  Dunford </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">david@educatedentrepreneurs.com</span><br />
101<br />Mobile 0407 181 278</td>

<td class="sorted date_updated" >2012-09-30</td>

<td class="sorted timestamp">
<span >2012-09-12</span>
</td>


<td class="actions">
<div class="identical"></div>
Keep In-Touch<br />
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
<div align='right' ><a href="javascript: toggle('note_form_8516');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8516" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8516'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8516);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8516');">
</div>
<div id='8516_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8516',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/22/2012  ADMIN : Ryan  pushing to delay hiring due to business issues needing resolution</a></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1412</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1022&jr_cat_id=2&jr_list_id=6&gs_job_role_selection_id=1412',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">PHP Developer</a></li></ol></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
14
<input type='checkbox' onClick='check_val()' name='users' value='8511' >
<div align="center">
<span id="mark_link_8511" class="mark_unmark_link" onclick="mark_unmark_lead(8511)" mode='mark' leads_name="#8511 Charlie  Cruz">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8511
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8511&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Charlie  Cruz </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">charlie_cruz0420@yahoo.com</span><br />
486<br />Mobile 0932-2208041</td>

<td class="sorted date_updated" >2012-09-18</td>

<td class="sorted timestamp">
<span >2012-09-11</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8511');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8511" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8511'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8511);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8511');">
</div>
<div id='8511_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8511',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/12/2012  BP : Walter number failed, sent email</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
15
<input type='checkbox' onClick='check_val()' name='users' value='8509' >
<div align="center">
<span id="mark_link_8509" class="mark_unmark_link" onclick="mark_unmark_lead(8509)" mode='mark' leads_name="#8509 Lee  Woodward">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8509
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8509&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Lee  Woodward </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">lee.w@realestateacademy.com.au</span><br />
101AVAILABLESTAFF<br />Office No. 1300 367 412<br />Mobile 0412 410 669</td>

<td class="sorted date_updated" >2012-10-02</td>

<td class="sorted timestamp">
<span >2012-09-10</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8509');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8509" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8509'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8509);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8509');">
</div>
<div id='8509_latest_notes'></div>
<div></div>
<div class='steps_list_section'><div><strong>Custom Recruitment Order #1381</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1012&jr_cat_id=4&jr_list_id=260&gs_job_role_selection_id=1381',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Audio Editor</a></li></ol></div><div><strong>Custom Recruitment Order #1386</strong><ol><li><a href="javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=1016&jr_cat_id=1&jr_list_id=1&gs_job_role_selection_id=1386',950,600)" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Telemarketer</a></li></ol></div><div style='margin-bottom:8px;'><b>1 Quote(s)</b><div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=0AJaOI53IbAI05LJKUONJGY236C2DRW8146PXX9UB6LMV' target='_blank'> - 14th Sep 12 09:50 AM quote given Part-Time Telemarketer :  $ AUD 493.90</a></div></div><div style='margin-bottom:8px;'><div style=' margin-bottom:3px;'><b>1 Service Agreement given</b></div>2012-09-14<br><a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=ZYLMaFI3JMOJ5HF96R67cZH2TRMXT2XGS6WIOF43O9LV6' target='_blank' class=''>- 09:50 AM Service Agreement # 1908</a><br></div></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
16
<input type='checkbox' onClick='check_val()' name='users' value='8507' >
<div align="center">
<span id="mark_link_8507" class="mark_unmark_link" onclick="mark_unmark_lead(8507)" mode='mark' leads_name="#8507 Joe  WIlliams">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8507
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8507&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Joe  WIlliams </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">newtec12@yahoo.com</span><br />
139INBOUNDCALL<br />Mobile 0432 223 684</td>

<td class="sorted date_updated" >2012-09-10</td>

<td class="sorted timestamp">
<span >2012-09-10</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8507');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8507" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8507'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8507);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8507');">
</div>
<div id='8507_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8507',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/10/2012  BP : Walter short term req only of JAVA</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
17
<input type='checkbox' onClick='check_val()' name='users' value='8504' >
<div align="center">
<span id="mark_link_8504" class="mark_unmark_link" onclick="mark_unmark_lead(8504)" mode='mark' leads_name="#8504 Stephanie  Walsh">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8504
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8504&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Stephanie  Walsh </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">stephanie@duffieldsolicitors.com.au</span><br />
139INBOUNDCALL<br />Office No. 07 4994 0725<br /></td>

<td class="sorted date_updated" >2012-09-20</td>

<td class="sorted timestamp">
<span >2012-09-10</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8504');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8504" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8504'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8504);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8504');">
</div>
<div id='8504_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8504',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/20/2012  BP : Walter revieiwing options</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
18
<input type='checkbox' onClick='check_val()' name='users' value='8500' >
<div align="center">
<span id="mark_link_8500" class="mark_unmark_link" onclick="mark_unmark_lead(8500)" mode='mark' leads_name="#8500 Greig  Sewell">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8500
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8500&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Greig  Sewell </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">gtsewell@live.com</span><br />
101<br />Mobile 0459 528 882</td>

<td class="sorted date_updated" >2012-09-10</td>

<td class="sorted timestamp">
<span >2012-09-09</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8500');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8500" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8500'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8500);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8500');">
</div>
<div id='8500_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8500',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/10/2012  BP : Walter only had one day requirement</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
19
<input type='checkbox' onClick='check_val()' name='users' value='8497' >
<div align="center">
<span id="mark_link_8497" class="mark_unmark_link" onclick="mark_unmark_lead(8497)" mode='mark' leads_name="#8497 Michael  Feletti">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8497
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8497&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Michael  Feletti </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">michaelfeletti@iwcps.com</span><br />
101HOMEPAGEENQUIRY<br />Mobile 0478 709 961</td>

<td class="sorted date_updated" >2012-09-28</td>

<td class="sorted timestamp">
<span >2012-09-07</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8497');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8497" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8497'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8497);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8497');">
</div>
<div id='8497_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8497',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/28/2012  BP : Walter said he only want to communicate via email for TM</a></div>
<div></div>
<div class='steps_list_section'></div>
</div>
</td>
</tr><tr bgcolor="#ffffff">



<td class="sorted item" >
20
<input type='checkbox' onClick='check_val()' name='users' value='8493' >
<div align="center">
<span id="mark_link_8493" class="mark_unmark_link" onclick="mark_unmark_lead(8493)" mode='mark' leads_name="#8493 Justin  Lowe">Add Pin</span>
</div>
<!---->
</td>

<td class="ids">
8493
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id=8493&lead_status=Keep In-Touch" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Justin  Lowe </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">jlowe@asi.com.au</span><br />
101<br />Mobile 0414 919 659</td>

<td class="sorted date_updated" >2012-09-14</td>

<td class="sorted timestamp">
<span >2012-09-06</span>
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
<div align='right' ><a href="javascript: toggle('note_form_8493');" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_8493" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_8493'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote(8493);">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_8493');">
</div>
<div id='8493_latest_notes'><a href="javascript:popup_win('../viewRemarks.php?leads_id=8493',600,600);" style="cursor:pointer" onclick="return bubbletip.show(this);" onmouseout="bubbletip.hide();" oncontextmenu="showContextMenu(this);return false;">09/7/2012  BP : Walter Had a one off need that he filled with Odesk</a></div>
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