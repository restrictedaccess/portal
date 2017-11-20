<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
<script type="text/javascript" src="/portal/js/tooltip.js"></script>
<script type="text/javascript">
<!---
$(document).ready(function() {
	var prioritylevel = undefined;
	$('input#status').val('<?php echo $status;?>');
	$("div.main ul li:eq(<?php echo $tab;?>)").addClass("youarehere");
	$("div.main ul").find('li').click(function() {
		var userlink = '';
		<?php
		$user_id = $userid ? $userid : ($filter['userid']?:$filter['userid']);
		if($leads):?>
			userlink = "&leads_id=<?php echo $leads;?>";
		<?php endif;
		if($user_id):?>
			userlink = "&userid=<?php echo $user_id;?>";
		<?php endif;?>
				

		var activeTab = $(this).find("a").attr("href");
		
		var tabIdx = $(this).index();
		var idx_list = {'0':'first', '1':'last', '2':'all'};
		
		if(activeTab=='#prioritylevel') {
			prioritylevel = $(this).find("a").text();
			$(this).empty().append($('<select/>').attr({'name':'day_priority','id':'day_priority'})
										 .css({'width':'160px','height':'22px'}).addClass('inputbox2')
								).css({'padding':'1px'});
			$('select#day_priority').append($('<option/>').val("").text(" Select priority "));
			
			
			/*$('select#day_priority').change(function(){
				var url = "?/index/"+activeTab.split('#')[1] + "/&day="+ $(this).val()+"&tab="+tabIdx+userlink;
				location.href=url;
			});*/
			
			/*$('select#day_priority').blur(function(){
				$('li#priority').empty().append($('<a/>').attr({'href':'#prioritylevel'}).text(prioritylevel)).css({'padding':''});
			});*/
			
			return;
		} else {
			if(!activeTab) return;
		}
		
		$("div.main ul li").removeClass("youarehere");
		$(this).addClass("youarehere");
		//if( activeTab == '#open' )
		
		var url = "?/index/"+activeTab.split('#')[1] + "/&tab="+tabIdx+userlink;
		
		location.href=url;
		
		//if( activeTab == 'staffactive' )
		//class_ticket.refresh_page(activeTab);
		/*$(activeTab).fadeIn();
		$(activeTab).show();*/
			//css('background', '#e0e0e0');
			
		return false;
	});
	Calendar.setup({inputField : "ticket_date1", trigger: "ticket_date1", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });
	
	Calendar.setup({inputField : "ticket_date2", trigger: "ticket_date2", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });
	
	$("form#case_form").submit(function() {
		var keyword = $('input#keyword').val();
		var bdate = $('input#ticket_date1').val();
		var age = $('select#ticket_age').val();
		var type = $('select#ticket_type').val();
		//var status = $('input#status').val();
		var csro = $('select#ticket_csro').val();
		var accts = $('select#ticket_accounts').val();
		var priority = $('select#day_priority').val();
		if (keyword || bdate || age || type || csro || accts || priority) {
			$(this).attr("action", "ticket.php?/reports/" + status);
			return true;
		} else { return false; }
    });
	$('input#keyword').val('<?php echo $filter['keyword'];?>');
	$("select#ticket_age option[value=<?php echo $filter['ticket_age'];?>]").attr("selected","selected");
	$("select#ticket_type option[value=<?php echo $filter['ticket_type'];?>]").attr("selected","selected");
	$("select#ticket_csro option[value=<?php echo $filter['ticket_csro'];?>]").attr("selected","selected");
	$("select#ticket_accounts option[value=<?php echo $filter['ticket_accounts'];?>]").attr("selected","selected");
	$("select#day_priority option[value=<?php echo $filter['day_priority'];?>]").attr("selected","selected");
	if($('select#ticket_age').val()=='btwn') agebtwn();
	$('select#ticket_age').change(function(){
		if($(this).val()=='btwn') {
			agebtwn();
		} else {
			if($('#btwndays').is(':visible')) $('#btwndays').hide();
		}
	});
	
});
function submitPage() {
	
	//window.location.href='seatb.php?/index/&date='+bdate+'&date2='+bdate2+'&starttime='+starttime+'&endtime='+endtime;
	//window.location.href='seatb.php?/index/&date='+bdate+'&date2='+bdate2;
	$('form#case_form').submit();
}
function fieldselect(fldname) {
        $('div#fieldsearch').find('input[type=text]').val('');
        //$('input#'+fldname).removeAttr('disabled');
    }
function agebtwn() {
	$('#btwndays').show();
	$('input[name=from_age]').focus();
	$('input[name=from_age]').add(('input[name=to_age]')).keydown(function(event) {
		//backspace, delete, tab, escape, and enter
		if( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
			(event.keyCode == 65 && event.ctrlKey === true) ||  //Ctrl+A
			(event.keyCode >= 35 && event.keyCode <= 39)) { //home, end, left, right
			return;
		} else {
			if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				event.preventDefault(); 
			}   
		}
	});
}
// -->
</script>
<style type='text/css'>
.divfilter {
	float:left;
	width:100%;
	height:auto;
	/*padding:0 7px;*/
}
.divfilter span{
	float:left;
	display:block;
	margin:4px 4px 4px 12px;
}

</style>

<div style='float:left;width:100%;padding:7px;'>
			<form id='case_form' method='post'>
			<input type='hidden' name='status' id='status' value=''/>
			<input type='hidden' name='tab' id='tab' value='<?php echo $tab;?>'/>
			<input type='hidden' name='leads_id' id='leads_id' value='<?php echo $leads;?>'/>
			<input type='hidden' name='userid' id='userid' value='<?php echo $userid?$userid:($filter['userid']?:$filter['userid']);?>'/>
			<div id='avseat' style="float:left;width:100%;border:1px solid #aaa;background:#ddd;">
			
			 <div class='divfilter'>
				<span>Keyword: <input type='text' class='inputbox' id='keyword' name='keyword' title='Keyword' style='width:96px;'/></span>
			
			<span>Ticket Age:
			<div id='btwndays'>
			<input type='text' name='from_age' value='<?php echo $from_age;?>' class='inputbox' style='width:35px;' maxlength='3'/> -
			<input type='text' name='to_age' value='<?php echo $to_age;?>' style='width:35px;' class='inputbox' maxlength='3'/>
			</div>
			
			<select name="ticket_age" id="ticket_age" title='Ticket Age' class="inputbox" style='width:70px;'>
			<option value="">--</option>
			<option value="btwn">Btwn days</option>
			<option value="-1">&lt; 1 day</option>
			<?php for($i=1; $i<31; $i++):?>
			<option value="<?php echo $i;?>"><?php echo $i; if($i==1) echo ' day'; else echo ' days';?></option>
			<?php endfor;?>
			<option value="31">&gt;1 month</option>
			</select></span>
			
			
			<span>Ticket Type: <select name="ticket_type" id="ticket_type" title='Type' class="inputbox" style='width:170px;'>
			<option value="">--</option>
			<?php foreach($types as $type):?>
			<option value='<?php echo $type['id'];?>'><?php echo $type['type_name'];?></option>
			<?php endforeach;?>
			</select></span>
			
			<span>CSRO:&nbsp;<select name="ticket_csro" id="ticket_csro" title='CSRO' class="inputbox" style='width:84px;'>
			<option value="">--</option>
			<option value="all">All CSRO</option>
			<?php foreach($csro_array as $csro):?>
			<option value='<?php echo $csro['admin_id'];?>'><?php echo $csro['admin_fname'];?></option>
			<?php endforeach;?>
			<option value="0">No CSRO</option>
			</select></span>
			
			<span>Accounts:&nbsp;<select name="ticket_accounts" id="ticket_accounts" title='Accounts' class="inputbox" style='width:84px;'>
			<option value="">--</option>
			<option value="all">All Accounts</option>
			<?php foreach($accounts_array as $accounts):?>
			<option value='<?php echo $accounts['admin_id'];?>'><?php echo $accounts['admin_fname'];?></option>
			<?php endforeach;?>
			<option value="0">No Accounts</option>
			</select></span>
			
			<span>Priority Level:&nbsp;
				<select name="day_priority" id="day_priority" title='Priority Level' class="inputbox">
				<option value="">--</option>
			<?php foreach($day_priority as $priority):?>
			<option value='<?php echo $priority['count'];?>'><?php echo $priority['label'];?></option>
			<?php endforeach;?>
			</select>
			</span>
			
			<span id='show_count'>Date from:
			<input type="text" id="ticket_date1" name="ticket_date1" value="<?php echo $filter_date1;?>" class="inputbox" readonly style="width:84px;" title='Date From'/><!-- <input type='button' id="bd" value='...' title="Date From selector"/>-->
			</span>
			<span id='show_count'>Date to:
			<input type="text" id="ticket_date2" name="ticket_date2" value="<?php echo $filter_date2?>" class="inputbox" readonly style="width:84px;" title='Date To'/><!-- <input type='button' id="bd2" value='...' title="Date To selector"/>-->
			<!--<a href='javascript:void(0);' onclick='class_seat.daycount(1);'>1 day</a>-->
			</span>
			
			</select>
			<!--Finish Time: <select name="finish_time" id="finish_time" class="inputbox2">
			<option value="0">-</option>
			
			</select>-->
			
			<span><input type='submit' value="Filter" name='submit' title="Filter data"/></span>
			</div>
			
			</div></form>
		</div>
		

<div id='cases' style='padding:15px 7px;'>
    
	<span style=" float:left;padding:8px;font-weight:bold">
		<span id='totalresult'>
			<?php echo count($ticket_counts).' row/s found ';?>
			<script type='text/javascript'>
			var filter_array = new Array();
			//filter_array.push
		
		<?php
		foreach($filter as $k => $v){
			if( in_array($k, array('status', 'submit', 'tab', 'from_age', 'to_age')) ) continue;
			elseif(in_array($k, array('ticket_date1', 'ticket_date2') ) ) {
				echo "filter_array.push($('#{$k}').attr('title')+': '+$('#{$k}').val());";
			} else {
				if($v) echo "filter_array.push($('#{$k}').attr('title')+' '+$('#{$k} option[value={$v}]').text());";
			}
		}
		?>
		if(filter_array.length > 0)	document.write('for '+filter_array.join(', '));
		</script>
		</span> 
	</span>
	
    <div id="reports" class="pane_content">


	   <form name='casesform' action='?/delete/' method='post' target='ajaxframe'>
        <div id='results' style='width:80%'>
        <input type='hidden' name='action' id='action'/>
           
           <!--<span style=" float:right;"><input type="button" onClick="class_seminar.excelExport();" value="Export to Excel"></span>-->
           <table cellpadding='1' cellspacing='0' class='list' width='100%' id='ticket_list'>
           <tbody id='tbody_list'>
           <tr>
             <td class='header' style='width:10%;'>CSRO Name</td>
             <td class='header' style='width:10%;'>Open Ticket</td>
			 <td class='header' style='width:10%;'>Escalated Ticket</td>
			 <td class='header' style='width:10%;'>Resolved Ticket</td>
			 <td class='header' style='width:10%;'>Total Ticket</td>
           </tr>
		   
		   <?php if(count($ticket_counts) > 0):
		    $bgcolor = array('#d0d8e8', '#e9edf4');
			foreach($ticket_counts as $counts):
				$row_bg = $bgcolor[$ctr++ % 2];
				$open = $counts['open'];
				$closed = $counts['closed'];
				$escal = $counts['escal'];
				$total = $open + $closed + $escal;
				$total_open += $open;
				$total_closed += $closed;
				$total_escal += $escal;
				$total_tickets += $total;
			?>

			<tr id='row<?php echo $info['id'];?>' bgcolor="<?php echo $row_bg;?>">
			  <!--<td class='item'></td>-->
			  <td class='item' style='float:left;padding:0 0 0 10px;'><?php echo $counts['a_csro']?$counts['a_csro']:$counts['a_accnt'].' - Accounts';?></td>
			  <td class='item'><?php echo $open;?></td>
			  <td class='item'><?php echo $escal;?></td>
			  <td class='item'><?php echo $closed;?></td>
			  <td class='item'><?php echo $total;?></td>
			</tr>
			<?php endforeach;?>
			<tr>
             <td class='item'>&nbsp;</td>
             <td class='item'><?php echo $total_open;?></td>
			 <td class='item'><?php echo $total_escal;?></td>
			 <td class='item'><?php echo $total_closed;?></td>
			 <td class='item'><?php echo $total_tickets;?></td>
           </tr>
			
			<?php else:?>
            <tr bgcolor="#d0d0d0"><td colspan='8'>No record found.</td></tr>
			<?php endif;?>
   
           </tbody>
   
           </table>

		</div>
	   </form>
  

    </div>
</div>
<script type='text/javascript'>
<!--
class_ticket.tooltip();
//-->
</script>