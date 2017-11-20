{include file='seat_header_global.tpl'}

{literal}
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
{/literal}

<table cellpadding='0' cellspacing='0' border='0' width='98%'>
<tr><td valign="top" colspan="2" >
<div style="float:left;text-align:right;width:100%;padding:5px; color:#666666;">
<div style="float:left"><img src="/portal/images/remote-staff-logo2.jpg" alt="think" ></div>
 
<!--
<iframe id="frame" name="frame" width="100%" height="100%" src="notes.php" frameborder="0" scrolling="no">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
-->
<div style="float:right;width:190px;">
	{*<a href="logout.php"  style="text-decoration:none;color:#666666;">Logout</a> | <a href="logout.php" style="text-decoration:none;color:#666666;" title="Login in Different Account">Login</a>*}
</div>
</div>


</td>
</tr>

<tr><td colspan='2' style="font: 8pt verdana; background:#abccdd;height:19px;">
<div style='float:left;'>&#160;&#160;<b>Welcome #{$admin.admin_id} {$admin.admin_fname} {$admin.admin_lname}</b></div><div style='float:right;font: 8pt verdana;'>&nbsp;</div></td></tr>

{*
<table width="100%" bgcolor="#abccdd" >

<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  Michael Lacanilao</b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
*}

<tr>
<td class='leftside'>

  <div class='menu_section'>
  <div id='min1'><div class='menu_header' style='float:left;'>Booking Management</div><div class='menu_header' style='text-align: right;' id='min1_icon' onclick='menu_toggle(this, 1)'>[ - ]</div></div>
  <div><img src='./images/admin_menu_bar.gif' border='0'></div>
  <div id='slideup1'>
  <div class='menu'><a href='seat_home.php' class='menu'><img src='./images/icons/menu_home.gif' border='0' class='icon2'>Home</a></div>
  <div class='menu'><a href='seat_staff_manage.php' class='menu'><img src='./images/icons/admin_users16.gif' border='0' class='icon2'>Booking Per Staff</a></div>
  <div class='menu'><a href='seat_client_manage.php' class='menu'><img src='./images/icons/admin_admins16.gif' border='0' class='icon2'>Booking Per Client</a></div>
  <div class='menu'><a href='seat_booking_status.php' class='menu'><img src='./images/icons/status16.gif' border='0' class='icon2'>Booking By Status</a></div>
  </div>
  <div style='padding:7px;'><a href='/portal/tools/TimeZoneConverter/TimeZoneConverter.html' target='_blank' class='menu'>Convert Time Zone</a></div>
  <div style='padding:7px;font-style:italic;border-bottom:1px solid #ddd;'><b>*</b>Note that all bookings and reports are in Manila time.</div>
  </div>



</td>
<td class='rightside'>