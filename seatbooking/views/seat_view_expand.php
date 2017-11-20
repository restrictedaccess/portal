
<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />

<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
<script type="text/javascript" src="/portal/js/tooltip.js"></script>


<script language='JavaScript'>
<!---
$(document).ready(function() {
	Calendar.setup({inputField : "booking_date", trigger    : "bd", onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,dateFormat : "%Y-%m-%d"
    });
	Calendar.setup({inputField : "booking_date2", trigger: "bd2", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });
	var marginTop = <?php echo $scroll;?>;
	if(marginTop > 0) {
		$(window).scrollTop(marginTop);
	}
});
hilite = function(e) { e.style.background = '#abccdd'; };
lowlite = function(e) { e.style.background = '';};
function submitPage() {
	var bdate = $('input#booking_date').val();
	var bdate2 = $('input#booking_date2').val();
	/*var starttime = $('select#start_time').val();
	var endtime = $('select#finish_time').val();*/
	window.location.href='seatb.php?/index/expand/&date='+bdate+'&date2='+bdate2;
}
// -->
</script>
<style type='text/css'>
#container{float:left;width:100%; display: table-cell; vertical-align: middle;
   border:1px solid #C0C0C0;
}
#content {#position: relative; #top: -50%;
  /* position: relative;top: -50%;width:30px;height:27px;*/
   border:1px solid #ff0000;
}
.greenBorder {border: 1px solid green;}

#parent {
	/*border: solid 1px #aaa;*/
	text-align: center;
	white-space: nowrap;
	font-size: 18px;
	/*letter-spacing: 15px;*/
	line-height: 12px;
	overflow: hidden;
	width: 100%;
	padding:10px;
	/*border: 1px solid #C0C0C0;*/
	top:0; left:0;
}

.child {
	width: 490px;
	height: auto;
	border: solid 1px #011a39;
	display: inline-block;
	letter-spacing: normal;
	white-space: normal;
	text-align: normal;
	vertical-align: middle;
	padding-bottom:3px;
}

.child {
	*display: inline;
	*margin: 0 10px 0 10px;
}
.child p {
	position:relative;top:-10px;cursor:pointer;
	border:1px solid #aaa;font-weight:bold;width:20%;height:13%;margin:1px auto;padding:3px;background:#696;
}
.child span {font-size:10px;cursor:pointer;}
.child span.red {color:#ff0000;}
.child span.black {font-size:10px;color:#000;}
</style>

<h2>Seat View</h2>

<div>Booking and Availabilities for <?php echo $home_date;?>
<div style='float:right'><a href='?/index/compact/'>Compact view</a></div>
</div>
<br />
<span id='task-status'></span>
<div style='float:right;font-weight:bold;'>Total active bookings: <?php echo $total_bookings;?></div>
<table width="100%" cellpadding="1" cellspacing="5">

<tr>
<td valign="top" width="60%">
	<div style='width:100%;background:#ddd;padding:5px;'>
		<form id='seat_form' action='' method='post' target='ajaxframe'>
		<div style="width:100%;border:1px solid #aaa;">
			<div id='show_count' style='padding:1px 0 10px 5px;'><span style='font-size:13px;'>OPTIONAL FILTER: </span>
				<span style='font-size:12px;'><i>This filter will show you the seats available for the indicated date and time.</i></span></div>
		<span id='show_count'>Date from:</span>
			<input type="text" id="booking_date" name="booking_date" value="<?php echo $filter_date;?>" class="inputbox2" readonly style="width:100px;"/> <input type='button' id="bd" value='...' title="Date From selector"/>
			&nbsp;&nbsp;
			<span id='show_count'>Date to:</span>
			<input type="text" id="booking_date2" name="booking_date2" value="<?php echo $filter_date2?>" class="inputbox2" readonly style="width:100px;"/> <input type='button' id="bd2" value='...' title="Date To selector"/>
			<a href='javascript:void(0);' onclick='class_seat.daycount(1);'>1 day</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<!--<div style='padding:5px;'>-->
			<input type='button' class='button' value="Show me the bookings and available for this date and time" name='submit' onclick="submitPage()" title="This filter will show you the seats available for the indicated date and time."/>
		<input type='hidden' name='seat_id' id='seat_id' value='<?php echo $seat_id;?>'/>
		</div></form>
	  </div>
	<div style='float:left;width:100%;'>
<a href='javascript:void(0);' style='float:left;' onclick='class_seat.navigateSeat("previous");'><img src='/portal/seatbooking/images/icons/arrow_back.gif'/></a>
<a href='javascript:void(0);' style='float:right;' onclick='class_seat.navigateSeat("next");'><img src='/portal/seatbooking/images/icons/arrow_next.gif'/></a>
</div>
	<div id='container'>
		<?php for($i=0; $i<2; $i++):?>
			
		<div id="parent">
			
			<?php for($j=0; $j<2; $j++):
				$ctr+=1;
			
				//if( !in_array($ctr, $seat_booked) ):?>
					
					<div class="child" id="child<?php echo $ctr;?>">
					<?php // onmouseover="hilite(this);" onmouseout="lowlite(this);">?>
					<p onmouseover="hilite(this);" onmouseout="lowlite(this);" onclick="location.href='seatb.php?/reports/&seat_id=<?php echo $ctr;?>';"><?php echo $ctr;?></p>
					
					<table cellpadding='1' cellspacing='1' class='list' id='list<?php echo $ctr;?>' width='100%'>
						<tbody>
					<tr>
					  <td class='header'>Type</td>
					  <td class='header'>Status</td>
					  <td class='header'>Payment</td>
					  <td class='header'>Staff Name</td>
					  <td class='header'>Client Name</td>
					  <td class='header'>Date/Time</td>
					</tr>
					

				  
					<?php if(count($seat_schedule[$ctr]) > 0):
						$total_hrs = 0;?>
						<?php for($k=0; $k<count($seat_schedule[$ctr]); $k++):
							$sched_array = $seat_schedule[$ctr][$k];
							$booked_hrs = (int)$sched_array['hrs'] * $sched_array['cnt'];
							$total_hrs += $booked_hrs;
							if( $sched_array['cnt'] > 1 ):
								$datestr = $sched_array['date_start'] .' - '. $sched_array['date_end'] .', '.
								$sched_array['book_start'].'-'.$sched_array['book_end'];
							else:
								$datestr = $sched_array['date_start'] .', ' .$sched_array['book_start'].' - '.$sched_array['book_end'];
							endif;?>
							<tr bgcolor='<?php echo $sched_array['bgcolor'];?>'>
							<td class='item'><?php echo $sched_array['booking_type'];?></td>
							<td class='item'><?php echo $sched_array['booking_status'];?></td>
							<td class='item'><?php echo $sched_array['booking_payment'];?></td>
							<td class='item'><a href='seatb.php?/staff/&staff_id=<?php echo $sched_array['staff_id'];?>'><?php echo $sched_array['fname'].' '.$sched_array['lname'];?></a></td>
							<td class='item'><a href='seatb.php?/client/&leads_id=<?php echo $sched_array['leads_id'];?>'><?php echo $sched_array['cfname'].' '.$sched_array['clname'];?></a></td>
							
							<td class='item'><?php echo $datestr.' (<span style="color:#ff0000;">'.$booked_hrs.'</span>hrs)';?></td>			
							</tr>
						<?php endfor;?>
						<tr bgcolor="#d0d0d0"><td class='item' colspan='5'>TOTAL</td>
						<td class='item'><?php echo $total_hrs;?> hour/s</td>
						</tr>
					<?php else:?>
						<tr style='background:#d0d0d0;'><td colspan='6' style='color:#ff0000;'>No record found.</td></tr>
					<?php endif;?>
						</tbody>
					</table>
					<a href='seatb.php?/reserve_seat/&seat_id=<?php echo $ctr;?>' onclick="return toggle_box(this, 650, 670, '2px solid #7a9512', 'SEAT #<?php echo $ctr;?> - Reserve Seat');">Reserve Seat</a>
					</div>
					<?php if($ctr % 2) echo '&nbsp;&nbsp;&nbsp;&nbsp;';?>
				<?php //endif;?>
				
			<?php endfor;?>
			
			
		
		</div>
		<?php endfor;?>
		
	</div>
</td>
</tr>
</table>