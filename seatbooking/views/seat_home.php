
<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />

<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
<script type="text/javascript" src="/portal/js/tooltip.js"></script>

<script language='JavaScript'>
<!---
$(document).ready(function() {
	Calendar.setup({inputField : "booking_date", trigger: "bd", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });
	
	Calendar.setup({inputField : "booking_date2", trigger: "bd2", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });
	
	/*$(".pane_content").hide();
	$("ul.tabs li:<?php echo $tab;?>").addClass("active").show();
	$(".pane_content:<?php echo $tab;?>").show();

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".pane_content").hide();

		var activeTab = $(this).find("a").attr("href");
		//if( activeTab == 'staffactive' ) 

		$(activeTab).fadeIn();
		$(activeTab).show();
			//css('background', '#e0e0e0');
			
		return false;
	});*/
	
	$('input#cancelbutton').bind('click', function(){history.go(-1);})
	
	var marginTop = <?php echo $scroll;?>;
	if(marginTop > 0) {
		$(window).scrollTop(marginTop);
	}
	//alert(marginTop);
});
hilite = function(e) { e.style.background = '#abccdd'; };
lowlite = function(e) { e.style.background = '';};
function submitPage() {
	var bdate = $('input#booking_date').val();
	var bdate2 = $('input#booking_date2').val();
	//var starttime = $('select#start_time').val();
	//var endtime = $('select#finish_time').val();
	//window.location.href='seatb.php?/index/&date='+bdate+'&date2='+bdate2+'&starttime='+starttime+'&endtime='+endtime;
	window.location.href='seatb.php?/index/&date='+bdate+'&date2='+bdate2;
}
// -->
</script>
<style type='text/css'>
#container{#position: absolute; #top: 50%;display: table-cell; vertical-align: middle;
/*position:absolute;
top: 50%;
display:table-cell; vertical-align: middle;*/
width:100px;height:70px;
   border:1px solid #aaa;
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
	letter-spacing: 20px;
	line-height: 12px;
	overflow: hidden;
	width: 98%;
	padding:6px;
	border: 1px solid #C0C0C0;
}

.child {
	width: 135px;
	height: auto;
	border: solid 1px #011a39;
	display: inline-block;
	letter-spacing: normal;
	white-space: normal;
	text-align: normal;
	vertical-align: middle;
	padding-bottom:3px;
	padding:4px 1px;
}

.child {
	*display: inline;
	*margin: 0 5px 0 5px;
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

<!--<div>Booking and Availabilities for <?php echo $dow_str;?>, <?php echo $home_date;?>-->
<div style='float:right'><a href='?/index/expand/'>Expand view</a></div>
</div>
<br />
<span id='task-status'></span>
<div style='float:left;'><div style='float:left;width:5px;height:3px;' class='seat_empty smallbox'>&nbsp;</div>&nbsp;= Seat Available</div>
<div style='float:right;font-weight:bold;'>Total active bookings: <?php echo $total_bookings;?></div>
<table width="100%" cellpadding="1" cellspacing="5">

<tr>
<td valign="top" width="100%">
	 
	 <!--<ul class="tabs">
      <li><a href="#reports">Reserved Seats</a></li>
      <li><a href="#schedule">Available Seats</a></li>
    </ul>-->
	
	
	<!--<div class="pane_container"> 
		<div id="reports" class="pane_content">-->
			<div class='smallbox_header' style='float:left;width:100%;background:#669966;'>Booking and Availabilities: <?php echo $home_date;?></div>
			
		<div style='float:left;width:100%;'>
			<form id='seat_form' action='' method='post' target='ajaxframe'>
			<div id='avseat' style="width:100%;border:1px solid #aaa;background:#ddd;">
				<!--<div id='show_count' style='padding:1px 0 10px 5px;'><span style='font-size:13px;'>OPTIONAL FILTER: </span>
					<span style='font-size:12px;'><i>This filter will show you the seats available for the indicated date and time.</i></span></div>-->
			<span id='show_count'>Date from:</span>
			<input type="text" id="booking_date" name="booking_date" value="<?php echo $filter_date;?>" class="inputbox2" readonly style="width:100px;"/> <input type='button' id="bd" value='...' title="Date From selector"/>
			&nbsp;&nbsp;
			<span id='show_count'>Date to:</span>
			<input type="text" id="booking_date2" name="booking_date2" value="<?php echo $filter_date2?>" class="inputbox2" readonly style="width:100px;"/> <input type='button' id="bd2" value='...' title="Date To selector"/>
			<a href='javascript:void(0);' onclick='class_seat.daycount(1);'>1 day</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<!--Start Time: <select name="start_time" id="start_time" class="inputbox2">
			<option value="0">-</option>
			<?php foreach($time_sel_value as $time_option):
				if( $time_option > 11 ) {
					$hrs = $time_option - 12;
					$ampm = 'pm';
				} else { $hrs = $time_option;
					$ampm ='am';
				}
				if( $hrs == 0 ) $hrs = 12;?>
				
				<option value='<?php echo $time_option;?>' <?php if($filter_start==$time_option) echo 'selected';?>>
				<?php printf('%02d', $hrs); echo ':00'. $ampm;?>
				</option>
			<?php endforeach;?>
			</select> &nbsp;
			Finish Time: <select name="finish_time" id="finish_time" class="inputbox2">
			<option value="0">-</option>
			<?php foreach($time_sel_value as $time_option):
				if( $time_option > 11 ) {
					$hrs = $time_option - 12;
					$ampm = 'pm';
				} else { $hrs = $time_option;
					$ampm ='am';
				}
				if( $hrs == 0 ) $hrs = 12;?>
				<option value='<?php echo $time_option;?>' <?php if($filter_end==$time_option) echo 'selected';?>>
				<?php printf('%02d', $hrs); echo ':00'. $ampm;?>
				</option>
			<?php endforeach;?>
			</select>-->
			<!--<div style='padding:5px;'>-->
			<input type='button' class='button' value="Show me the bookings and available for this date and time" name='submit' onclick="submitPage()" title="This filter will show you the seats available for the indicated date and time."/>
			<!--<input type='button' class='button' value="Show me the booking for this date and time" name='submit' onclick="submitPage()" title="This filter will show you the reserved seats for the indicated date and time."/>
			</div>-->
			</div></form>
		</div>

		
		
		
		<?php for($i=0; $i<12; $i++):?>
			
		<div id="parent">
			<?php for($j=0; $j<7; $j++):
				$ctr+=1;
				$cnt = count($seat_schedule[$ctr]);
				/*if( !in_array($ctr, $seat_booked) ):*/?>
					
					<div class="child<?php if($cnt == 0):?> seat_empty<?php endif;?>">
					<?php // onmouseover="hilite(this);" onmouseout="lowlite(this);">?>
					<p onmouseover="hilite(this);" onmouseout="lowlite(this);" onclick="location.href='seatb.php?/reports/&seat_id=<?php echo $ctr;?>';"><?php echo $ctr;?></p>
					
					<?php
					/*if($cnt > 0):*/
					for($k=0; $k < $cnt; $k++):
						$sched_array = $seat_schedule[$ctr][$k];
						
						if( $sched_array['cnt'] > 1 ):
							$datestr = $sched_array['book_date1'] .'-'. $sched_array['book_date2'] .', '.
							$sched_array['book_start'].'-'.$sched_array['book_end'];
						else:
							$datestr = $sched_array['book_date1'] .', ' .$sched_array['book_start'].'-'.$sched_array['book_end'];
						endif;
			
						?>
						
						<img src='./images/icons/<?php echo $sched_array['flag'];?>'/><span class='<?php if($sched_array[booking_status]=='Pending'):?>red<?php else:?>black<?php endif;?>'
						onmouseover="tooltip('Staff: <?php echo $sched_array[fname].' '.$sched_array[lname];?><br/>Client: <?php echo $sched_array[cfname].' '.$sched_array[clname];?>');" onmouseout="exit();">
						<a href='?/reports/date/&seat_id=<?php echo $ctr;?>&date=<?php echo $url_date1;?>&date2=<?php echo $url_date2;?>'><?php echo $datestr;?></a></span>
						<span style='font-weight:bold'><?php echo $sched_array['noise_level'][0];?></span><br/>
					<?php endfor;
					/*else:
						for($k=0; $k < 24; $k++):*/
							?>
							<!--<div style='float:left;width:4px;' class='seat_empty'>&nbsp;</div>-->
					<?php   
						/*endfor;*/
					/*endif;*/?>
					<br/>
					<a href='seatb.php?/reserve_seat/&seat_id=<?php echo $ctr;?>' onclick="return toggle_box(this, 650, 670, '2px solid #7a9512', 'SEAT #<?php echo $ctr;?> - Reserve Seat');" style='padding:4px;'>Reserve Seat</a>
					
					</div>	
				
				
			<?php endfor;?>
			
			
			
		</div>
		<?php endfor;?>
		<!--</div>
	</div>-->

</td>
</tr>
</table>

