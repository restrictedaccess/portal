<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
	  
<link rel="stylesheet" type="text/css" href="<?php echo $staticdir;?>/seatbooking/css/simpleAutoComplete.css" />
<script type="text/javascript" src="<?php echo $staticdir;?>/seatbooking/js/simpleAutoComplete.js"></script>

<script type="text/javascript">
<!---
$(document).ready(function() {
	$(".pane_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show();
	$(".pane_content:first").show(); 

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".pane_content").hide();

		var activeTab = $(this).find("a").attr("href");

		$(activeTab).show();
			//css('background', '#e0e0e0');
			
		return false;
	});
	<?php if($byfield == 'date'):?>
	Calendar.setup({inputField : "booking_date", trigger: "bd", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });
	
	Calendar.setup({inputField : "booking_date2", trigger: "bd2", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });
	
	<?php endif;?>
	

});
function submitPage() {
	var bdate = $('input#booking_date').val();
	var bdate2 = $('input#booking_date2').val();
	//window.location.href='seatb.php?/index/&date='+bdate+'&date2='+bdate2+'&starttime='+starttime+'&endtime='+endtime;
	window.location.href='seatb.php?/reports/date/&date='+bdate+'&date2='+bdate2;
}
// -->
</script>

<h2>Booking Report by <?php echo $byfield;?></h2>
<br />


	<div style="width:100%;height:20px;padding:7px;border:1px solid #aaa;">&nbsp;
	
	<?php if($byfield != 'date'):?>
	<span id='show_count' style='float:left;'>Filters: </span>
	<span><a href='?/reports/status/'>View All Bookings</a> | <a href='?/reports/status/&booking_status=Pending'>View All Pending Bookings</a>
	| <a href='?/reports/status/&booking_status=Confirmed'>View All Confirmed Bookings</a> | <a href='?/reports/status/&booking_status=Cancelled'>View All Cancelled Bookings</a></span>
	<?php else:?>
	<div style='float:left;'>
	<form id='seat_form' action='' method='post' target='ajaxframe' style='float:left;'>
	<span id='show_count'>Date from:</span>
	<input type="text" id="booking_date" name="booking_date" value="<?php echo $filter_date;?>" class="inputbox2" readonly style="width:100px;"/> <input type='button' id="bd" value='...' title="Date From selector"/>
	&nbsp;&nbsp;
	<span id='show_count'>Date to:</span>
	<input type="text" id="booking_date2" name="booking_date2" value="<?php echo $filter_date2?>" class="inputbox2" readonly style="width:100px;"/> <input type='button' id="bd2" value='...' title="Date To selector"/>
	<a href='javascript:void(0);' onclick='class_seat.daycount(1);'>1 day</a>
	<input type='button' class='button' value="Filter Date" name='submit' onclick="submitPage();"/>
	</form>
	</div>
	<?php endif;?>
	</div>


<br/>
	
<div id='staff'>
<ul class="tabs">
  <li><a href="#bookingstatus" id="hreftab"><?php echo $tab;?></a></i></li>
</ul>
					
<div class="pane_container">
  <div id="bookingstatus" class="pane_content">
	<div style='float:left;width:90%;'>
	  <table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>
        <tr><td>Total Record: <span id='totalrec'><?php echo $items_total;?></span></td>
            <td> &nbsp; <span id='pages'><?php echo $pages;?></span></td>
			<td> &nbsp; <span id='itemspp'><?php echo $items_pp;?></span> &nbsp; </td>
            <td><span id='jumpmenu'><?php echo $jump_menu;?></span></td>
        </tr>
     </table>
	  
	  <div style='float:right;'><span>Filter by client:</span>
		<select name="client" id="client" class="inputbox2" onchange="class_seat.filter_client(this, '<?php echo $params;?>', 'status');">
			<option value='0'>- select here -</option>
            <?php foreach($client_select as $client):?>
            <option value='<?php echo $client['id'];?>'><?php echo $client['fname'].' '.$client['lname'];?></option>
            <?php endforeach;?>
        </select>
	  </div>
	 </div>
	  
	  <div id='result' style='float:left;width:90%;'> 
	  <table cellpadding='3' cellspacing='3' class='list' id='result' width='100%'>
		<tbody>
		<tr>
		  <td class='header'>#</td>
		  <td class='header'>Seat#</td>
		  <td class='header'>Client Name</td>
		  <td class='header'>Staff Name</td>
		  <td class='header'>Hours Booked</td>
		  <td class='header'>Booking Date</td>
		  <td class='header'>Status</td>
		</tr>
		
        <?php if(count($booking_info) > 0):
			foreach($booking_info as $info):
				$ctr++;
				$total_hrs = (int)$info['hrs'] + $total_hrs;?>

          <tr bgcolor="<?php echo $info['bgcolor'];?>">
			<td class='item'><?php echo ($ctr+$ipp);?></td>
			<td class='item'><a href='?/reports/seat/&seat_id=<?php echo $info['seat_id'];?>'><?php echo $info['seat_id'];?></a></td>
			<td class='item'><a href='seatb.php?/client/&leads_id=<?php echo $info['id'];?>'><?php echo $info['cfname'].' '.$info['clname'];?></a></td>
			<td class='item'><a href='seatb.php?/staff/&staff_id=<?php echo $info['staff_id'];?>'><?php echo $info['fname'].' '.$info['lname'];?></a></td>
			<td class='item'><?php echo $info['hrs'];?> hrs</td>
			<td class='item'><a href='?/reports/date/&date=<?php echo $info['book_date'];?>'><?php echo $info['book_date'];?></a> &nbsp;&nbsp;(<?php echo $info['book_start'].'-'.$info['book_end'];?>)</td>
			<td class='item'><?php echo $info['booking_status'];?></td>
			
			
          </tr>
          <?php endforeach;?>
			<tr bgcolor="#d0d0d0"><td class='item' colspan='4'>TOTAL</td>
			  <td class='item'><?php echo $total_hrs;?> hour/s</td><td colspan='2'></td>
			</tr>
          <?php else:?>
            <tr bgcolor="#d0d0d0"><td colspan='6'>No record found.</td></tr>
          <?php endif;?>
		  </tbody>
      </table>

	  </div>
	
  </div>
  
</div>
</div>