<?php
include(Config::$templ_dir .'/header_global.php'); ?>

<script type="text/javascript">
<!--
  $(document).ready(function() {
	$.fn.slideFadeToggle = function(easing, callback) {
		return this.animate({ opacity: 'toggle', height: 'toggle' }, "slow", easing, callback);};
  });
  function menu_toggle(icon, id) {
	$('div#slideup'+id).slideFadeToggle();
	$(icon).text( ($(icon).text() == '[ + ]') ? '[ - ]' : '[ + ]' );
	return false;
  }
  
  function showPage(url) {
	var href = url.href;
	//parent.window.location=url;
	
	boxdiv = parent.window.document.createElement('div');
	
    // Assign id equalling to the document it will show
    //boxdiv.setAttribute('id', href);
	boxdiv.id = 'boxdiv'; //href;
	
	//var marginleft = (width/2) * -1;
	//var margintop = (height/2) * -1;

	//boxdiv.setAttribute('style', boxdiv.getAttribute('style') + "; float:left; ");
	//alert(boxdiv.style.styleFloat);
    boxdiv.style.display = 'block';
    //boxdiv.style.position = 'fixed';
	boxdiv.style.zIndex = 999;
	boxdiv.style.top = 0;

    boxdiv.style.width = '100%';
    boxdiv.style.height = 'auto';
    boxdiv.style.border = '1px solid #696';
    boxdiv.style.textAlign = 'right';
    boxdiv.style.padding = '4px';
    boxdiv.style.background = '#FFFFFF';
	//boxdiv.style.marginLeft = marginleft + 'px';
	//boxdiv.style.marginTop = margintop + 'px';
	//boxdiv.style.top = '50%';
	//boxdiv.style.left = '50%';
    
	
	$('td.rightside').html(boxdiv);
	
	var contents = parent.window.document.createElement('iframe');
    contents.scrolling = 'auto';
    contents.overflowX = 'hidden';
    contents.overflowY = 'scroll';
    contents.frameBorder = '0';
    contents.style.width = '100%';
    contents.style.height = '400px';
    boxdiv.contents = contents;


    boxdiv.appendChild(contents);
	
    if (contents.contentWindow){
        contents.contentWindow.document.location.replace(href); }
    else {
        contents.src = href; }
		
	var the_height = contents.contentWindow.document.body.scrollHeight;
	//alert(the_height);
	$(contents).height(the_height);
	
	//var iframe = document.getElementById('iFrameWin');
	//iframe.contentWindow.location.reload(true);
	//iframe.src = url;
	//iframe.height = 600;
	return false;
  }
 /* window.addEvent('domready', function() { 
    var Slideup1 = new Fx.Slide('slideup1');
    if(menu_minimized.get(1) == 0) { $('min1_icon').innerHTML = '[ + ]'; Slideup1.hide(); }
	
    $('min1').addEvent('click', function(e){
	e = new Event(e);
	if(menu_minimized.get(1) == 0) { 
	  menu_minimized.set(1, 1);
	  Slideup1.slideIn(); 
	  $('min1_icon').innerHTML = '[ - ]';
	} else { 
	  menu_minimized.set(1, 0);
	  Slideup1.slideOut(); 
	  $('min1_icon').innerHTML = '[ + ]';
	}
	e.stop();
	this.blur();
    });
  });*/
//-->
</script>

<table cellpadding='0' cellspacing='0' border='0' style='width:100%;'>
<tr><td valign="top" colspan="2" style="position:fixed;">
<?php /*<div style="float:left;text-align:right;width:100%;padding:5px; color:#666666;">
<div style="float:left"><img src="/portal/images/remote-staff-logo2.jpg" alt="think" ></div>
 

<div style="float:right;width:190px;">
	<!--<a href="logout.php"  style="text-decoration:none;color:#666666;">Logout</a> | <a href="logout.php" style="text-decoration:none;color:#666666;" title="Login in Different Account">Login</a>-->
</div>
</div>*/?>


</td>
</tr>

<tr bgcolor="#7a9512"><td colspan='2' style="width:100%;font:8pt verdana;height:19px;border-bottom:1px solid #7a9512;">
<div style='float:left;width:200px;color:#000;padding-top:6px;'>&#160;&#160;<b>RS SEAT BOOKING<?php /*Welcome #{$admin.admin_id} {$admin.admin_fname} {$admin.admin_lname}*/?></b></div>

<div style='float:left;width:83%;font: 8pt verdana;'>
  <table width="100%" bgcolor="#7a9512" border='0'>
	<tr>
	  <td align="right" style="font: 8pt verdana; ">
	 <ul id="sddm">
	  <li><a href='seatb.php?/index/' class='menu'><img src='<?php echo $staticdir;?>/seatbooking/images/icons/menu_home.gif' border='0' class='icon2'>Home</a></li>
	  <li><a href='seatb.php?/index/seatview' class='menu'><img src='<?php echo $staticdir;?>/seatbooking/images/icons/RedSeat.png' border='0' class='icon2'>Seat View</a></li>
  
	  <li><a href="#" onmouseover="mopen('m2')" onmouseout="mclosetime()"><img src='<?php echo $staticdir;?>/seatbooking/images/icons/admin_activity16.gif' border='0' class='icon2'>Booking Report</a>
		  <div id="m2" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
			
		  <a href='seatb.php?/staff/' class='menu'><img src='<?php echo $staticdir;?>/seatbooking/images/icons/admin_users16.gif' border='0' class='icon2'>Booking Per Staff</a>
		  <a href='seatb.php?/client/' class='menu'><img src='<?php echo $staticdir;?>/seatbooking/images/icons/admin_admins16.gif' border='0' class='icon2'>Booking Per Client</a>
		  <a href='seatb.php?/reports/status' class='menu'><img src='<?php echo $staticdir;?>/seatbooking/images/icons/status16.gif' border='0' class='icon2'>Booking By Status</a>
		  <a href='seatb.php?/payment/' class='menu'><img src='<?php echo $staticdir;?>/seatbooking/images/icons/money-bag-icon.png' border='0' class='icon2'>Payment Status</a>
		  <a href='seatb.php?/reports/date/&date=<?php echo date('Y-m-d');?>' class='menu'><img src='<?php echo $staticdir;?>/seatbooking/images/icons/table_16x16.gif' border='0' class='icon2'>Booking By Date</a>
		  </div>
	  </li>
	  
	  <li><a href='seatb.php?/invoice/' class='menu'><img src='<?php echo $staticdir;?>/seatbooking/images/icons/invoice-information-icon.png' border='0' class='icon2'>Invoicing Report</a></li>

	</ul>
	<div style="font: 8pt verdana;color:#fff;"><?php echo '#'.$userid.' '.$userfname;?> &nbsp; <a href="/portal/adminHome.php">Home</a></div>
	</td></tr>
</table>
</div></td></tr>


<tr>

<td class='content'>