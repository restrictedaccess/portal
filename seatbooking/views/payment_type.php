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
	
	class_seat.onblur_search('client', 'client');
	$('input#client').focus(function(){class_seat.onfocus_search('client', 'client');});
	
	$('input#client').simpleAutoComplete('autocomplete_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'client'
	    }, staffCallback);

});
function staffCallback( param ) {
	$("input#client_id").val( param[0] );
}
// -->
</script>

<h2>Payment Type</h2>
<br />


	<div style="width:100%;height:20px;padding:7px;border:1px solid #aaa;">&nbsp;
	<span id='show_count'>Filters: </span>
	<span><a href='?/payment/'>View All</a> | <a href='?/payment/&booking_payment=Paid'>View Paid</a>
	| <a href='?/payment/&booking_payment=Free'>View Free</a> | <a href='?/payment/&booking_payment=TBP'>View Unpaid</a></span>
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
		<select name="client" id="client" class="inputbox2" onchange="class_seat.filter_client(this, '<?php echo $params;?>', 'payment');">
			<option value='0'>- select here -</option>
            <?php foreach($client_select as $client):?>
            <option value='<?php echo $client['id'];?>'><?php echo $client['fname'].' '.$client['lname'];?></option>
            <?php endforeach;?>
        </select>
	  </div>
	</div>
	  
	  <div id='result' style='float:left;width:90%;'> 
	  <table cellpadding='3' cellspacing='3' class='list' id='result' width='100%'>
		<tr>
		  <td class='header'>#</td>
		  <td class='header'>Seat#</td>
		  <td class='header'>Client Name</td>
		  <td class='header'>Staff Name</td>
		  <td class='header'>Hours Booked</td>
		  <td class='header'>Booking Date</td>
		  <td class='header'>Payment</td>
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
			<td class='item'><a href='?/reports/date/&date=<?php echo $info['book_date'];?>'><?php echo $info['book_date'];?></a></td>
			<td class='item'><?php echo $info['booking_payment'];?></td>
			
			
          </tr>
          <?php endforeach;?>
			<tr bgcolor="#d0d0d0"><td class='item' colspan='4'>TOTAL</td>
			  <td class='item'><?php echo $total_hrs;?> hour/s</td><td colspan='2'></td>
			</tr>
          <?php else:?>
            <tr bgcolor="#d0d0d0"><td colspan='6'>No record found.</td></tr>
          <?php endif;?>
      </table>

	  </div>
	
  </div>
  
</div>
</div>