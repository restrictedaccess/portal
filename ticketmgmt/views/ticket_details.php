<link rel="stylesheet" type="text/css" href="<?php echo $staticdir;?>/seatbooking/css/simpleAutoComplete.css" />
<script type="text/javascript" src="<?php echo $staticdir;?>/ticketmgmt/js/simpleAutoComplete.js"></script>
<script type="text/javascript" src="<?php echo $staticdir;?>/ticketmgmt/js/jqModal.js"></script>
<script type="text/javascript" src="/adhoc/php/js/hilite.js" ></script>
<script type='text/javascript'>
<!--///

//back_link.style.fontSize = '14px';
//back_link.innerHTML = 'Back';

$(document).ready(function() {
	// remove layerX and layerY
    var all = $.event.props,
    len = all.length,
    res = [];
    while (len--) {
      var el = all[len];
      if (el != 'layerX' && el != 'layerY') res.push(el);
    }
    $.event.props = res;
	
	class_ticket();

	$(window).keydown(function(event){
		//alert(event.target.nodeName);
		if(event.keyCode == 13 && event.target.nodeName == 'INPUT') {
		  event.preventDefault();
		  return false;
		}
	});
	
	<?php if($submit == 'Update Ticket'):?>
	var ticket_status = "<?php echo $ticket_info['ticket_status'];?>";
	$("select#ticket_status").append("<option value='"+ticket_status+"'>"+ticket_status+"</option>");
	//$("select#ticket_status option[value=<?php echo $ticket_info['ticket_status'];?>]").attr("selected","selected");
	$("select#ticket_type option[value=<?php echo $ticket_info['ticket_type'];?>]").attr("selected","selected");
	$("select#ticket_csro option[value=<?php echo $ticket_info['csro'];?>]").attr("selected","selected");
	$("select#ticket_accounts option[value=<?php echo $ticket_info['accounts'];?>]").attr("selected","selected");
	$("select#day_priority option[value=<?php echo $ticket_info['day_priority'];?>]").attr("selected","selected");
	var priority_selected = $('select#day_priority option:selected').text();
	$("select#day_priority").attr('title',priority_selected);//.attr('disabled', 'disabled');
	$('input#ticket_title').val('<?php echo $ticket_info['ticket_title'];?>');
	//$('textarea#ticket_details').val('<?php echo $ticket_info['ticket_details'];?>');
	//$('textarea#ticket_solution').val('<?php echo $ticket_info['ticket_solution'];?>');
	if( $('select#ticket_csro').val() == "") {
		alert('Please update CSRO field. It looks like the CSRO assigned to this ticket is no longer a CSRO.');
	}
	<?php else:?>
	$("select#ticket_status").append("<option value='Open'>Open</option>");
	<?php endif;?>
	
	
	$(".pane_content").hide();
	$("div.client ul li:first").addClass("youarehere");
	$(".pane_content:first").show();
	
	$("div.client ul").find('li').click(function() {

		$("div.client ul li").removeClass("youarehere");
		$(this).addClass("youarehere");
		$(".pane_content").hide();

		var activeTab = $(this).find("a").attr("href");
		//if( activeTab == '#open' )
		var tabIdx = $(this).index();
		//var idx_list = {'0':'first', '1':'last'};
		var createlink = $('li#create-comm-client');
		if(tabIdx > 0) {
			createlink.empty().append("<a href='javascript:void(0);' onclick='openNoteBox(\"client-note\");'>Add Note</a>");
		} else {
			createlink.empty().append("<a href='javascript:void(0);' onclick='openEmailBox(\"client-email\", \"Client\");'>Create Email</a>");
		}
		$(activeTab).show();
			
		return false;
	});
	
	$(".pane_content2").hide();
	$("div.staff ul li:first").addClass("youarehere");
	$(".pane_content2:first").show();
	
	$("div.staff ul").find('li').click(function() {

		$("div.staff ul li").removeClass("youarehere");
		$(this).addClass("youarehere");
		$(".pane_content2").hide();

		var activeTab = $(this).find("a").attr("href");
		//if( activeTab == '#open' )
		var tabIdx = $(this).index();
		//var idx_list = {'0':'first', '1':'last'};
		var createlink = $('li#create-comm-staff');
		if(tabIdx > 0) {
			createlink.empty().append("<a href='javascript:void(0);' onclick='openNoteBox(\"staff-note\");'>Add Note</a>");
		} else {
			createlink.empty().append("<a href='javascript:void(0);' onclick='openEmailBox(\"staff-email\", \"Staff\");'>Create Email</a>");
			
		}
		$(activeTab).show();			
		return false;
	});
	
	$("form#ticketform").submit(function(e) {
		$('span#task-status').empty().append('Loading...').show();
		var btnName = $("input[type=submit][clicked=true]").val();
		var ticket_id = $('input#tid_email').val();
		
		if( btnName == 'Upload' && !ticket_id) {
			//$('input#ticket_id').val(ticket_id);
			alert('Sorry, you must create ticket first to be able to upload file.');
			e.preventDefault();
			return false;
		} else {
			return true;
		}
    });
	
	$("form#ticketform input[type=submit]").click(function() {
		$("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
		$(this).attr("clicked", "true");
	});
	
	$('div#logs').hide();
	$('a#showhide').click(function() {
		var ticket_id = $('input#tid_email').val();
		
		var logs = $('div#logs');
		class_ticket.getHistory(ticket_id, logs);
	});
	$('.jqmWindow').jqm({overlay: 50, modal: true, trigger: false});
});

function showNote(id) {
	$('#dialog'+id).jqmShow();
}


function submitForm() {
	var frm = parent.document.getElementById('myform');
	$("form#ticketform").submit();
	alert($("form#ticketform"));
	//return false;
}
function clientNCallback( param ) {
	//alert(param[0]);
	$("input#client_id").val( param[0] );
	//$("input#client_name").val( param[1] + ' ');
	  
	  /*$.ajax({
			type: "POST",
			url: "/portal/seatbooking/seatb.php?/show_client",
			data: { 'userid': param[0] },
			dataType: "json",
			success: function(data){
				class_seat.setStaffData(data);
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});*/
}
function clientIDCallback( param ) {
	$("input#client_name").val( param[1] +' '+param[2] );
}
//-->
</script>
<style type="text/css">
.jqmWindow {
    display: none;
    
    position: fixed;
    top: 17%;
    left: 70%;
    
    margin-left: -300px;
    width: 600px;
    
    background-color: #EEE;
    color: #333;
    border: 1px solid black;
    padding: 12px;
}

.jqmOverlay { background-color: #000; }

/* Fixed posistioning emulation for IE6
     Star selector used to hide definition from browsers other than IE6
     For valid CSS, use a conditional include instead */
* html .jqmWindow {
     position: absolute;
     top: expression((document.documentElement.scrollTop || document.body.scrollTop) + Math.round(17 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + 'px');
}
</style>

<span id='task-status'>status</span>
<?php if($submit == 'Update Ticket'):?>
<div style='float:left;width:100%;background:#FFF3F3;'>
	<a href='?/ticketinfo/<?php echo $next_id-1;?>' title='Previous ticket' style='float:left;'><img src='images/icons/arrow_back.gif'/></a>
	<span style='line-height: 25px;font-weight:bold;'><?php echo stripslashes($ticket_info['ticket_title']);?></span>
	<a href='?/ticketinfo/<?php echo $next_id+1;?>' title='Next ticket' style='float:right;'><img src='images/icons/arrow_next.gif'/></a>
</div>
<?php endif;
	$date_from = strtotime(date("Y-m-d H:i:s"));
	$created = $date_from - (int)$ticket_info['date_created'];
	//$level1 = $level2 = FALSE;
	$redalert = FALSE;
	if($created > 86400 ) {
		$age_date = round($created / 86400);
		//$level1 = $age_date > 1 && $age_date < 6 && $ticket_info['ticket_status'] == 'Open';
		//$level2 = $age_date > 5 && $ticket_info['ticket_status'] == 'Open';
		$redalert = $age_date > (int)$ticket_info['day_priority'] && $ticket_info['ticket_status'] == 'Open';
	}
?>
  <div id='mainbox' style='float:left;width:98%;padding:15px 7px;'>
	
	<form id='ticketform' name='ticketform' method='POST' target='ajaxframe' action='?/process_ticket/&leads_id=<?php echo $leads;?>&userid=<?php echo $userid;?>'  enctype='multipart/form-data' style='padding:0px;'>
	<input type='hidden' name='ticket_id' id='ticket_id' value='<?php echo $ticket_id ? $ticket_id : $next_id;?>'/>
    <div style='float:left;width:100%;background:<?php echo ($redalert) ? '#cc0033' : '#F9EDBE';?>;height:19px;padding-bottom:10px;'>
		<table width="100%" cellpadding="2" cellspacing="2" class="list">
			<tr><td width='20%' class='form2'>Ticket ID: <strong><?php printf('%07d', $next_id);?></strong></td>
			<td width='20%'>Ticket Status:&nbsp;<select class='inputbox2' name='case_status' id='ticket_status' style='width:100px;height:22px;'>
			</select></td>
			<td width='20%'>CSRO:&nbsp;
			<select name='ticket_csro' id='ticket_csro' class='inputbox2' style='width:130px;height:22px;'>
				<option value="">- Default -</option>
				<?php foreach($csro_array as $csro):?>
				<option value='<?php echo $csro['admin_id'];?>'><?php echo $csro['admin_fname'];?></option>
				<?php endforeach;?>
			</select>
			</td>
			<td width='20%'>Accounts:&nbsp;
			<select name='ticket_accounts' id='ticket_accounts' class='inputbox2' style='width:130px;height:22px;'>
				<option value="">- select here -</option>
				<?php foreach($accounts_array as $accounts):?>
				<option value='<?php echo $accounts['admin_id'];?>'><?php echo $accounts['admin_fname'];?></option>
				<?php endforeach;?>
			</select>
			</td>
			<td width='30%'>Priority:&nbsp;
			<select name='day_priority' id='day_priority' class='inputbox2' style='width:130px;height:22px;'>
				<?php foreach($day_priority as $priority):?>
				<option value='<?php echo $priority['count'];?>'><?php echo $priority['label'];?></option>
				<?php endforeach;?>
			</select>
			</td>
			</tr>
		
		</table>
	</div>
	

	<div id='divresult' style='float:left;width:99%;border:1px solid #7a9512;'>
		
		<table width="100%" border='0' cellpadding="7" cellspacing="2" class="list">
			<tbody>
				<tr><td width='50%' valign='top'>
			
			<table width="100%" border='0' cellpadding="3" cellspacing="7" class="list">
			
			
			  
			  
			  <tr><td colspan='2'>
				<div style='float:left;width:auto;'>
					<table width='100%' border='0' class="list">
						<tr><td class='form1' width='22%'><span class='inplabel'>Ticket Type</span> </td><td class='form2'>
						<select name='ticket_type' id='ticket_type' class='inputbox2' style='height:22px;'>
						  <option value="">- select here -</option>
						  <?php foreach($types as $type):?>
						  <option value='<?php echo $type['id'];?>'><?php echo $type['type_name'];?></option>
						  <?php endforeach;?>
						</select>
						</td></tr>
			  
						<tr><td class='form1' valign='top'><span class='inplabel'>Ticket Title</span></td>
						<td class='form2'><input type="text" id='ticket_title' name='ticket_title' class='inputbox2'></td>
						</tr>
					</table>

			  
			    </div>
			  </td></tr>
			  
			  
			  
			  <!--<tr><td class='form1' width='22%' valign='top'><span class='inplabel'>Case Details</span> </td><td class='form2'>
			  
				<?php if(count($case_details) > 0):
					//foreach($case_details as $k => $detail):
					//	$date = explode(' ', $detail['date_updated']);
					?>
					<div id='ticket_details' style='float:left;padding:4px 2px;'>
					<?php //echo $date[0].' <strong>'.$detail['admin_fname'].': </strong>'.$detail['field_update'];?></div>
					</div>
					<?php //endforeach;
				endif;?>
			  
			  <br/>
			  <textarea id="ticket_details2" name='ticket_details' class='text' rows='1' style='width:400px;'></textarea>
			  
			  </td></tr>-->
			  
			   <tr><td colspan='2'>
				<div style='float:left;width:auto;'>
					<table width='100%' border='0' class="list" id='details_tbl'>
						<tr><td class='form1' valign='top'><span class='inplabel'>Ticket Details</span></td>
						<td class='form2'>
						<?php if(count($case_details) > 0):
							foreach($case_details as $k => $detail):
								$date = explode(' ', $detail['date_updated']);
							?>
								<div id='ticket_details' style='width:100%;float:left;padding:4px 2px;'>
								<?php echo $date[0].' <strong>'.$detail['admin_fname'].': </strong>'.$detail['field_update'];?></div>
								</div>
							<?php endforeach;
						endif;?>
						  
						  <textarea id="ticket_details2" name='ticket_details' class='text' rows='1' style='width:400px;'></textarea>
						</td>
						</tr>
					</table>

			  
			    </div>
			  </td></tr>
			  
			  <tr><td colspan='2' align='left'>
				<div style='float:left;width:90%;padding:12px;border:1px solid #ff0000;text-align:left;'>
					<table width='100%' border='0' cellpadding="1" cellspacing="1" class="list" id="clients">
						 <tr><td class='form1'><span class='inplabel'>Client ID:</span></td>
						 <td class='form2'><input type="text" id='client_id0' name='client_id[]' class='inputbox2' value='<?php echo $client[0]['id'];?>' style='width:65px;'/></td>
						 
						<td class='form1'><span class='inplabel'>Client Name:</span></td>
						<td class='form2'><input type="text" id='client_name0' name='client_name[]' class='inputbox2' value='<?php echo trim($client[0]['fname'].' '.$client[0]['lname']);?>'/></td>
						</tr>
						 
					</table>
					<hr/>
					<!--<div>&nbsp;&nbsp;&nbsp;<input type='button' id='addclient' class='button_small' value='Add another client'/></div>-->
					
					<table width='100%' border='0' cellpadding="1" cellspacing="1" class="list" id="staff">
						 <tr><td class='form1'><span class='inplabel'> Contractor ID:</span></td>
						 <td class='form2'><input type="text" id='staff_id0' name='staff_id[]' class='inputbox2' value='<?php echo $staff[0]['userid'];?>' style='width:65px;'/></td>
						 
						<td class='form1'><span class='inplabel'> Contractor Name:</span></td>
						<td class='form2'><input type="text" id='staff_name0' name='staff_name[]' class='inputbox2' value='<?php echo trim($staff[0]['fname'].' '.$staff[0]['lname']);?>'/></td>
						</tr>
						<?php for($i = 1; $i < count($staff); $i++):?>
							<tr><td class='form1'><span class='inplabel'>Contractor ID:</span></td>
							<td class='form2'><input type="text" id='staff_id<?php echo $i;?>' name='staff_id[]' class='inputbox2' value='<?php echo $staff[$i]['userid'];?>' style='width:65px;'/></td>
						 
							<td class='form1'><span class='inplabel'>Contractor Name:</span></td>
							<td class='form2'><input type="text" id='staff_name<?php echo $i;?>' name='staff_name[]' class='inputbox2'
								value='<?php echo $staff[$i]['fname'].' '.$staff[$i]['lname'];?>'/></td>
							</tr>
						<?php endfor;?>
					</table>
					<div>&nbsp;&nbsp;&nbsp;<input type='button' id='addstaff' class='button_small' value='Add another contractor'/></div>
				</div>
			  </td></tr>
			  
			  
			  <tr><td colspan='2'>
				<div style='float:left;width:auto;'>
					<table width='100%' border='0' class="list" id='solution_tbl'>
						<tr><td class='form1' valign='top'><span class='inplabel'>Solution</span></td>
						<td class='form2'>
							<?php if(count($case_solution) > 0):
								foreach($case_solution as $k => $solution):
									$date = explode(' ', $solution['date_updated']);
								?>
									<div id='ticket_solution' style='width:100%;float:left;padding:4px 2px;'>
									<?php echo $date[0].' <strong>'.$solution['admin_fname'].': </strong>'.$solution['field_update'];?></div>
									</div>
								<?php endforeach;
							endif;?>

						
							<textarea id="ticket_solution2" name='ticket_solution' class='text' rows='1' style='width:500px;'></textarea>
						</td>
						</tr>
					</table>

			  
			    </div>
			  </td></tr>
			</table>
			</td>
					
				
			<td width='50%' valign='top'>
				<div id='result' style='float:left;width:100%;border:1px solid #aaa;'>
					
				   <p>&nbsp;</p>
				   
				   <div class='nav client' style='width:50%;'>
						<ul>
							<li class='youarehere'><a href='#clientemail'>Client Email</a></li>
							<li><a href='#clientnotes'>Client Notes</a></li>
						</ul>
					</div>
					<div class='nav createemail'>
						<ul><li id='create-comm-client'><a href='javascript:void(0);' onclick='openEmailBox("client-email", "Client");'>Create Email</a></li></ul>
					</div>
					
					<div id="clientemail" class="pane_content">
						<table border='0' cellpadding='1' cellspacing='1' class='comm' width='100%' id='client-email'>
						<tbody>
						
						<tr>
						  <td class='header' width='10%'>Date</td>
						  <td class='header' width='10%'>Time</td>
						  <td class='header' width='40%'>Content</td>
						  <td class='header' width='15%'>Sender</td>
						</tr>
						<?php if(count($client_email) > 0):
						 foreach($client_email as $k => $email):?>
						<tr>
						  <td class='item' width='10%'><?php echo $email['date'];?></td>
						  <td class='item' width='10%'><?php echo $email['time'];?></td>
						  <td class='form2' width='40%' style='border-top: 1px solid #ddd;'>
						  <!--<span style='max-width:150px;'><?php echo $email['content'];?></span>-->
						  <?php if( strlen($email['content'])>40 ):
							$stripped = preg_replace('/(<br\/>|<br\/|<br)/', '&nbsp;', substr($email['content'],0,40));
							echo $stripped.".. <a href='#dialog".$email['id']."' onclick='showNote(".$email['id'].");'>more</a>";
						 
						    echo "<div class='jqmWindow' id='dialog".$email['id']."'>\n".
							$email['date']. "<a href='#' class='jqmClose' style='float:right'>Close</a><hr>\n".
							$email['content']."\n</div>";
							 
						   else: echo $email['content'];
						   endif;
						  ?>
						  </td>
						  <td class='item' width='15%'><?php echo $email['sender'];?></td>
						</tr>
						<?php endforeach;
						endif;?>
						</tbody>
				
						</table>
					</div>
						<?php /*-----------------*/?>
					<div id="clientnotes" class="pane_content">
						<table border='0' cellpadding='1' cellspacing='1' class='comm' width='100%' id='client-note'>
						<tbody>
			 
						<tr>
						  <td class='header' width='10%'>Date</td>
						  <td class='header' width='10%'>Time</td>
						  <td class='header' width='40%'>Content</td>
						  <td class='header' width='15%'>User</td>
						</tr>
						
						<?php if(count($client_notes) > 0):
						 foreach($client_notes as $k => $note):?>
						<tr onmouseover="hilite(this);" onmouseout="lowlite(this);">
						  <td class='item' width='10%'><?php echo $note['date'];?></td>
						  <td class='item' width='10%'><?php echo $note['time'];?></td>
						  <td class='form2' width='40%' style='border-top: 1px solid #ddd;'>
						  <?php //echo strlen($note['content'])>40 ? substr($note['content'],0,40).'..' : $note['content'];?>
						  <?php if( strlen($note['content'])>40 ):
							$stripped = preg_replace('/(<br\/>|<br\/|<br)/', '&nbsp;', substr($note['content'],0,40));
							echo $stripped.".. <a href='#dialog".$note['id']."' onclick='showNote(".$note['id'].");'>more</a>";
						 
						    echo "<div class='jqmWindow' id='dialog".$note['id']."'>\n".
							$note['date']. "<a href='#' class='jqmClose' style='float:right'>Close</a><hr>\n".
							$note['content']."\n</div>";
							 
						   else: echo $note['content'];
						   endif;
						  ?>
						  </td>
						  <td class='item' width='15%'><?php echo $note['sender'];?></td>
						</tr>
						<?php endforeach;
						endif;?>
				
						</tbody>
				
						</table>
				   
					</div>
				   
				   
				   
				   <p>&nbsp;</p>
				   
				   <div class='nav staff'>
						<ul>
							<li class='youarehere'><a href='#staffemail'>Staff Email</a></li>
							<li><a href='#staffnotes'>Staff Notes</a></li>
						</ul>
					</div>
				   
				   
					<div class='nav createemail'>
						<ul><li id='create-comm-staff'><a href='javascript:void(0);' onclick='openEmailBox("staff-email", "Staff");'>Create Email</a></li></ul>
					</div>
					<div id="staffemail" class="pane_content2">
						<table border='0' cellpadding='1' cellspacing='1' class='comm' width='100%' id='staff-email'>
						<tbody>
						<tr>
						  <td class='header' width='10%'>Date</td>
						  <td class='header' width='10%'>Time</td>
						  <td class='header' width='40%'>Content</td>
						  <td class='header' width='15%'>Sender</td>
						</tr>
						<?php if(count($staff_email) > 0):
						 foreach($staff_email as $k => $email):?>
						<tr onmouseover="hilite(this);" onmouseout="lowlite(this);">
						  <td class='item' width='10%'><?php echo $email['date'];?></td>
						  <td class='item' width='10%'><?php echo $email['time'];?></td>
						  <td class='form2' width='40%' style='border-top: 1px solid #ddd;'>
							 <!--<span style='max-width:150px;'><?php echo $email['content'];?></span>-->
							<?php if( strlen($email['content'])>40 ):
							$stripped = preg_replace('/(<br\/>|<br\/|<br)/', '&nbsp;', substr($email['content'],0,40));
							echo $stripped.".. <a href='#dialog".$email['id']."' onclick='showNote(".$email['id'].");'>more</a>";
						 
						    echo "<div class='jqmWindow' id='dialog".$email['id']."'>\n".
							$email['date']. "<a href='#' class='jqmClose' style='float:left'>Close</a><hr>\n".
							$email['content']."\n</div>";
							 
						   else: echo $email['content'];
						   endif;
						  ?>
						  
						  </td>
						  <td class='item' width='15%'><?php echo $email['sender'];?></td>
						</tr>
						<?php endforeach;
						endif;?>
						</tbody>
						</table>
					</div>
					
					<div id="staffnotes" class="pane_content2">
						<table border='0' cellpadding='1' cellspacing='1' class='comm' width='100%' id='staff-note'>
						<tbody>
			 
						<tr>
						  <td class='header' width='10%'>Date</td>
						  <td class='header' width='10%'>Time</td>
						  <td class='header' width='40%'>Content</td>
						  <td class='header' width='15%'>User</td>
						</tr>
						
						<?php if(count($staff_notes) > 0):
						 foreach($staff_notes as $k => $note):?>
						<tr onmouseover="hilite(this);" onmouseout="lowlite(this);" class="staff_notes <?php echo $note['id'];?>">
						  <td class='item' width='10%'><?php echo $note['date'];?></td>
						  <td class='item' width='10%'><?php echo $note['time'];?></td>
						  <td class='form2' width='40%' style='border-top: 1px solid #ddd;'>
						  <?php if( strlen($note['content'])>40 ):
							$stripped = preg_replace('/(<br\/>|<br\/|<br)/', '&nbsp;', substr($note['content'],0,40));
							echo $stripped.".. <a href='#dialog".$note['id']."' onclick='showNote(".$note['id'].");'>more</a>";

							echo "<div class='jqmWindow' id='dialog".$note['id']."'>\n".
							$note['date']. "<a href='#' class='jqmClose' style='float:right'>Close</a><hr>\n".
							$note['content']."\n</div>";
							 
						  else: echo $note['content'];
						  endif;
						  
						  ?>
						  </td>
						  <td class='item' width='15%'><?php echo $note['sender'];?></td>
						</tr>
						<?php endforeach;
						endif;?>
				
						</tbody>
				
						</table>
				   
					</div>
					
					<p>&nbsp;</p>
				
					<table border='0' cellpadding='1' cellspacing='1' class='comm' width='100%' id='relevant-files'>
					<tbody>
					<tr><td><strong>Relevant Files</strong>
				
					<div style='float:left;width:95%;padding:12px;border:1px solid #ff9900;text-align:center;'>
						<table width='100%' border='0' cellpadding="7" cellspacing="2" class="list" id="files">
							<tbody>
							<tr><td class='form2'  style='border-bottom:1px solid #aaa;'>Filename</td>
								<td class='form1'  style='border-bottom:1px solid #aaa;'>Date</td>
							</tr>
							 <?php if(count($files) > 0):
							 foreach($files as $k => $f):?>
								<tr>
									<td class='form2'><a href='/portal/ticketmgmt/<?php echo $f['filepath'];?>' target='_blank'><?php echo $f['fname'];?></a></td>
									<td class='form1'><?php echo $f['date'];?></td>
								</tr>
							 <?php endforeach;
							 endif;?>
							 </tbody>
						</table>
						<div id='filediv'><input type='file' id="inpfile0" name="inpfile[]" class='button_small' style='float:left;width:300px;'/>
						<?php if($submit == 'Update Ticket'):?>
							<input type='submit' id='submit1' name='upload' class='button_small' value='Upload' style='float:right;'/>
						<?php else:?>
						  <input type='button' id='addfile' class='button_small' value='Add another file'/>
						<?php endif;?>
						</div>
						<!--iframe name="upload_iframe" style="display:block;height:5px;"></iframe-->
					</div>
	
					</td></tr>
				 
					</tbody>
		   
					</table>
				</div>
				
			
			</td>
				
		</tr>
			
		<tr><td class='form1'>&nbsp;</td>
		<td>
		<div style='float:left;'>
		
		<?php if($submit != 'Create Ticket' ):?>
			<fieldset>
			<?php if( $ticket_info['ticket_status'] == 'Open' ):?>
			
			<input type='radio' name='ticket_status' value='Open' checked='checked'/>leave as open &nbsp;
			<input type='radio' name='ticket_status' value='Resolved'/>close this ticket &nbsp;
			<input type='radio' name='ticket_status' value='Escalated'/>escalate &nbsp;
			
			<?php elseif( $ticket_info['ticket_status'] == 'Resolved' ):?>
			<input type='radio' name='ticket_status' value='Open'/>re-open this ticket  &nbsp;
			
			<?php elseif( $ticket_info['ticket_status'] == 'Escalated' ):?>
			<input type='radio' name='ticket_status' value='Open'/>close this ticket &nbsp;
			
			<?php else:?>
			<input type='radio' name='ticket_status' value='Open' checked='checked'/>open this ticket&nbsp;
			<input type='radio' name='ticket_status' value='Resolved'/>close this ticket &nbsp;
			<?php endif;
		endif;?>
		</fieldset>
		</div>
			<div style='float:right;width:28%;'>
			<input type='submit' id='submit2' name='new_update' class='button' value='<?php echo $submit;?>' /> &nbsp;
			<input type='button' name='back' class='button' value='Cancel' onclick="window.location='<?php echo $referer;?>'"/> &nbsp;
			<!--input type='button' name='done' class='button' value='Done' disabled='disabled'/-->
			</div>
		</td></tr>
			
		</tbody>
		</table>
	</form>
	</div>
	
	
<?php if($submit == 'Update Ticket'):?>
  <div style='float:left;width:100%;text-align:left;padding-top:10px;'>History [ <a href='#loghist' id='showhide'>Show</a> ]</div>
  <div id='logs' style='float:left;width:75%;padding:12px;border:1px solid #ff9900;text-align:center;'>
	<table width='100%' border='0' cellpadding="7" cellspacing="2" class="list" id="logtbl">
		<tbody>
		<tr><td class='header' style='width:15%;'>Date</td>
		<td class='header' style='width:15%'>Admin</td>
		<td class='header' style='width:70%;'>Changes</td>
		</tr>
		</tbody>
	</table>
  </div>
<?php endif;?> 
  </div>
  
  
  
<div id='notediv' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:370px;padding:3px;border:1px solid #011a39;'>
	<div class='title'>New Note - <span id='notecat'></span></div>
		
		<form name='regform' method='POST' target='ajaxframe' action='?/addnote/' style='padding:0;margin:0;'>
			<input type='hidden' name='ticket_id' id='tid_note' value='<?php echo $ticket_id;?>'/>
			<input type='hidden' name='type' id='type_notes'/>
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			  
			  <tr><td align='center'><textarea id="note_content" name='note_content' class='text' rows='4' style='width:95%;float:left;'></textarea></td></tr>
			   
			 <tr>
			<td colspan="2" align='center'>
			<input type='submit' class='button' id='createbutton' value='Add Note'> <input type='button' id='cancelmgr' class='button' value='Cancel' onClick="$('div#notediv').hide();">
			</tr>
		  </table>
		</form>
	</div>
	
</div>
  
<div id='emaildiv' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:390px;padding:3px;border:1px solid #011a39;'>
	<div class='title'>Create Email - <span id='cat'></span></div>
		
		<form name='regform' method='POST' target='ajaxframe' action='?/createemail/' style='padding:0;margin:0;'>
			<input type='hidden' name='ticket_id' id='tid_email' value='<?php echo $ticket_id;?>'/>
			<input type='hidden' name='type' id='type_email'/>
			<input type='hidden' name='email_subject' id='email_subject'/>
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			<!--<tr><td class='form1'>Subject:</td>
				<td class='form2'><input type="text" id="email_subject" name="email_subject" value="Remotestaff: Client-Staff Support" class="inputbox2"/></td>
			</tr>-->
			  
			  <tr><td class='form2'>Email Message:</td></tr>
			<tr><td class='form2'><textarea id="email_content" name='email_content' class='text' rows='5' style='width:95%;float:left;'></textarea></td></tr>
			   
			 <tr>
			<td colspan="2" align='center'>
			<input type='submit' class='button' id='createbutton' value='Send'> <input type='button' class='button' value='Cancel' onClick="$('div#emaildiv').hide();">
			</tr>
		  </table>
		</form>
	</div>
	
</div>

<!--<form action="?/fileupload/" target="upload_iframe" id="uploadform" name="uploadform" method="post" enctype="multipart/form-data" style='visibility:hidden;'>
<input type='hidden' name='ticket_id' value='<?php //echo $next_id;?>'/>
  <input type="hidden" name="fileframe" value="true">
</form>-->
	<script type="text/javascript">
	<!--
	function isNumber(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}

	function openNoteBox(type_str) {
		var ticket_id = $('input#tid_note').val();
		//if( parseInt(ticket_id) > 0) {
			$('div#notediv').show();
			$('input#type_notes').val(type_str);
			$('span#notecat').text(type_str.split('-')[0]);
		//} else {
		//	alert('Please create ticket first!');
		//	return false;
		//}
		/*$('input#book_id').val(id);
		$('span#booknum').text(id);
		$('input#seat_id').val(seat);
		var winHeight = $(window).height();
		var winWidth = $(window).width();*/
		// overwrite width and height to fix IE display
		//$('div#confirmcancel').width(winWidth);
		//$('div#confirmcancel').height(winHeight);
		
	}
	
	function openEmailBox(type_str, cat) {
		var ticket_id = $('input#tid_email').val();
		if( parseInt(ticket_id) > 0) {
			$('div#emaildiv').show();
			$('input#type_email').val(type_str);
			$('span#cat').text(cat);
			$('input#email_subject').val( $('input#ticket_title').val() );
		} else {
			alert('Please create ticket first!');
			return false;
		}
	}
	function closePage() {
		//var seat_id = document.getElementById('seat_id');
		var seat_id = $('input#seat_id');
		var boxlink = document.createElement('a');
		boxlink.href = 'seatb.php?/quick_booking/&seat_id='+seat_id.val();
        
        var boxdiv = window.parent.document.getElementById(boxlink.href);
        boxdiv.style.display='none';
		
		var currentScroll = $(window.parent).scrollTop();
		var currentURL = window.parent.location.href.split('&')[0];
		
		if (currentURL.charAt( currentURL.length-1 ) != '/') currentURL += '?';
		
		window.parent.location.href = currentURL+'&scroll='+currentScroll;
	}

	function createResult(error_message) {
		if(error_message)
			$('span#task-status').empty().append(error_message).show().fadeOut(6000);
		else {//$('span#task-status').empty().append('Data Updated!').show().fadeOut(7000);
			window.location.href='ticket.php?/index/open/&leads_id=<?php echo $leads;?>&userid=<?php echo $userid;?>';
		}
		
	}
	function uploadResult(error_message, id) {//, ret, fname) {
		if(error_message) {
			$('span#task-status').empty().append(error_message).show().fadeOut(6000);
		}
		else {
			$("input#inpfile0").val('');
			//if( id ) {
			class_ticket.retrieve_files(id);
			/*} else {
				$('form#ticketform').append("<input type='hidden' name='files_id[]' value='"+ret+"'/>");
				var d = new Date();
				var curr_date = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
				var tbl = $('table#files');
				tbl.find('tbody').append("<tr>"+
				"<td class='form2'><a href='/portal/ticketmgmt/"+fname+"' target='_blank'>"+fname+"</a></td>"+
				"<td class='form1'>"+curr_date+"</td></tr>");
			}*/
		}
	}
	function commResult(ret, type) {
		if(!isNumber(ret)) {
			$('span#task-status').empty().append(ret).show().fadeOut(6000);
		}
		else {
			var typearr = type.split('-');
			$('div#'+typearr[1]+'div').hide();
			var ticket_id = $('input#ticket_id').val();
			$('textarea#'+typearr[1]+'_content').val('');
			
			class_ticket.retrieve_comm(type, ticket_id);
			//if( $('input#submit2').val() == 'Create Ticket') alert('New note has been created!');
		}
	}
	
	function commResult_wait(ret, type, notes, admin) {
		var typearr = type.split('-');
		$('div#'+typearr[1]+'div').hide();
		var ticket_id = $('input#ticket_id').val();
		$('textarea#'+typearr[1]+'_content').val('');
		$('form#ticketform').append("<input type='hidden' name='notes_id[]' value='"+ret+"'/>");
			
		var d = new Date();
		var curr_date = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
		var curr_time = d.getHours() + ':' + d.getMinutes() +':' +d.getSeconds();
			
		var tbl = $('table#'+type);
		tbl.find('tbody').append("<tr>"+
		"<td class='item'>"+curr_date+"</a></td><td class='item'>"+curr_time+"</td>"+
		"<td class='form2' style='border-top: 1px solid #ddd;'>"+notes+"</td><td class='item'>"+admin+"</td></tr>");
	}
	
	function reloadPage() {
		var el = document.getElementById('box-result');
		el.style.display = (el.style.display == "none") ? "block" : "none";
		var seat_id = document.getElementById('seat_id');
		window.location.href='seatb.php?/quick_booking/&seat_id='+seat_id.value;
	}
	function showStaffBooking(seat_id, staff_id) {
		window.parent.location.href = 'seatb.php?/staff/seat/&seat_id='+seat_id+'&staff_id='+staff_id;
		
		var boxlink = document.createElement('a');
		boxlink.href = 'seatb.php?/quick_booking/&seat_id='+seat_id;
		var boxdiv = window.parent.document.getElementById(boxlink.href);
		boxdiv.style.display='none';
	}
	//-->
	</script>