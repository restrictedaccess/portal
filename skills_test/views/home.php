<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript" src="test.js"></script>

<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>

<style type="text/css">

.jqmWindow {
	
    display: none;
    
    position: fixed;
    
    top: 30%;
    
    left: 70%;

    width: 350px;
    
    background-color: #EEE;
    
    color: #333;
    
    border: 1px solid black;
    
    padding: 12px;
    
}

.jqmOverlay { 

	background-color: #000; 
	
}

* html .jqmWindow {
	
     position: absolute;
     
     top: expression((document.documentElement.scrollTop || document.body.scrollTop) + Math.round(17 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + 'px');

}

.system_requirements_content { 

	display: inline-block;
	
	vertical-align: top;
	
	width:900px; 
	
}

div#testholder {
	
	padding-left:0px;
	
}

div.category {
	
	width: 235px;
	
}

div a.title {

  float:left;

  width: 100%;
  
  font-weight: bold;
  
  font-size: 13px;
  
  background-color: #ddddee;
  
  padding: 2px 2px 2px 6px;
  
}

.footermain {
	
	width: 945px;
	
}

div.main-container{
	
	width:955px;
	
}

/*TOTOP CSS*/
#toTop {
	display:none;
	text-decoration:none;
	position:fixed;
	bottom:10px;
	right:10px;
	overflow:hidden;
	width:51px;
	height:51px;
	border:none;
	text-indent:100%;
	background:url('/portal/skills_test/images/ui.totop.png') no-repeat left top;
}

#toTopHover {
	background:url('/portal/skills_test/images/ui.totop.png') no-repeat left -51px;
	width:51px;
	height:51px;
	display:block;
	overflow:hidden;
	float:left;
	opacity: 0;
	-moz-opacity: 0;
	filter:alpha(opacity=0);
}

#toTop:active, #toTop:focus {
	outline:none;
}

</style>

<script type="text/javascript">

	$( function() {
		
		$( "#tabs" ).tabs();
		
		$( document ).ready( function() { 
		
			$('#hardware_and_software_specification').click( function( e ) {
				
				e.preventDefault();
				
				$('html, body').animate( { scrollTop: 480 }, "slow");
				
			} );
			
			$('#optimize_your_browswer').click( function( e ) {
				
				e.preventDefault();
				
				$('html, body').animate( { scrollTop: 1800 }, "slow");
				
			} );
			
			$('#disconnect_and_service_disruption').click( function( e ) { 
				
				e.preventDefault();
				
				$('html, body').animate({ scrollTop: $(document).height() }, "slow");
				
			} );
			
			
			$('#internet_speed').click( function( e ) { 
				
				e.preventDefault();
				
				$('html, body').animate({ scrollTop: $(document).height() }, "slow");
				
			} );
			
			$( '.check_system_requirements' ).click(function( e ){
				
				e.preventDefault();
				
				$('#system_requirements_nav').click();
				
			} );
			
		} );
	
	} );

</script>

<div class="main-container" >
	
	<span id='loading'> Loading, please wait... </span>
	
	<p class="lastNode" style="margin-bottom: 5px;"> Remote Staff Test </p>
	
	<p style="margin-bottom: 5px;"> <span style='color:red; font-weight:700;'>Note</span>: Before taking the Remote Staff Test, Please check your <a href="#" class="check_system_requirements">System Requirements</a>. </p>
	
	<div id="tabs">
		
		<ul>
			
			<li> <a id="remotestaff_test_nav" href="#remotestaff_test"> Tests </a> </li>
			
			<li> <a id="system_requirements_nav" href="#system_requirements"> System Requirements </a> </li>
			
		</ul>
		
		<div id="remotestaff_test">
	
			<div style='display:inline-block;width:250px;height:auto;vertical-align:top;'>
				
				<div class='category' id='catlist'>
					
					<span class='title collapse'id='catlisthead'> Test Category </span>
					
					<ul>
						
						<?php foreach($categories as $cat):?>
							
							<li> <a href="#<?php echo $cat['assessment_category'];?>"><?php echo $cat['assessment_category'];?> </a> </li>
						
						<?php endforeach;?>
					
					</ul>
					
				</div>
			
				<div class='category' id='postlist'>
					
					<span class='title collapse' id='postlisthead'> Position List </span>
				
					<?php foreach($positions as $entry):
					
						if( preg_match('/<cat>(.*)<\/cat>/', $entry, $match) ) echo "<span class='subtitle'>".$match[1]."</span>\n";
						
						elseif( preg_match('/<li>(.*):(.*)<\/li>/', $entry, $match) )
						
							echo "<li><a href='#__pos__".$match[2]."'>".$match[1]."</a></li>\n";
						
						else echo $entry."\n";
						
					?>
					
					<?php endforeach;?>
					
				</div>
			
			</div>
					
			<div id="testholder" style="float:none; display:inline-block;vertical-align:top;">
				
				<span class='title'> Selected Test </span>
				
				<table id="selected_test" width="100%" cellspacing="2" class="list">
					
					<tr>
						
						<td class='header' style='width:1%;'> # </td>
						
						<td class='header' style='width:3%;'> Category </td>
						
						<td class='header' style='width:15%;'> Test Title </td>
						
					</tr>
					
					<tr>
						
						<td class='item' colspan='3'>
							
							<span style='font-size:6em'>&larr;</span>
							
							<span style='font-size:14pt; vertical-align:super;'> Select category to get the test lists </span>
						
						</td>
						
					</tr>
					
					<tr>
						
						<td style='height:130px;'>&nbsp;</td>
						
					</tr>
					
					<tr>
						
						<td class='item' colspan='3'>
							
							<span style='font-size:6em'>&larr;</span>
							
							<span style='font-size:14pt;vertical-align:super;'> Select Position to get test list per position </span>
						
						</td>
						
					</tr>
					
				</table>
				
			</div>
		
		</div><!-- remotestaff test tab end -->
		
		<div id="system_requirements">

			<div class="system_requirements_content">
				
				<div style="width:815px; padding: 0px 55px;">
					
					<div style="width:250px; display:inline-block; text-align:center;"> <a id="hardware_and_software_specification" class="title" href="#"> Hardware/Software Specification </a> </div>
					
					<div style="width:175px; display:inline-block; text-align:center;"> <a id="optimize_your_browswer" class="title" href="#"> Optimize Your Browser </a> </div>

					<div style="width:252px; display:inline-block; text-align:center;"> <a id="disconnect_and_service_disruption" class="title" href="#"> Disconnects &amp; Service Disruptions </a> </div>

					<div style="width:115px; display:inline-block; text-align:center;"> <a id="internet_speed" class="title" href="#"> Internet Speed </a> </div>
					
				</div>
			
				<iframe src="http://www.proveit.com/marketing/sysrequirements.asp" style="width:900px; overflow: hidden; height:2400px;" scrolling="no" frameborder="0"></iframe>
			
			</div>
			
		</div><!-- system requiremnets tab end --> 
	
	</div><!-- #tabs end-->
	 
	<div class='jqmWindow' id='dialog'> ID: <span id='aid'></span> <a href='#' class='jqmClose' style='float:right'> Close </a>
		
		<hr>
		
		<div style='float:left;padding:4px;'>
			
			<p>
				
				<strong>Test Name:</strong> 
				
				<span id='testname'></span>
				
			</p>
			
			<p> <?php echo $popup_text;?> </p>
			
			<p>
				
				<button style="" type="button" id="btn_yes"> YES </button>
				
				<button style="" type="button" id="btn_no"> NO </button>
				
			</p>
			
		</div>
		
	</div>
	
	<?php echo $redirect_url;?>
	        
	<div id="footer_divider"></div>

</div>

<script type="text/javascript">
/*
|--------------------------------------------------------------------------
| UItoTop jQuery Plugin 1.2 by Matt Varone
| http://www.mattvarone.com/web-design/uitotop-jquery-plugin/
|--------------------------------------------------------------------------
*/
(function($){
	$.fn.UItoTop = function(options) {

 		var defaults = {
    			text: 'To Top',
    			min: 200,
    			inDelay:600,
    			outDelay:400,
      			containerID: 'toTop',
    			containerHoverID: 'toTopHover',
    			scrollSpeed: 1200,
    			easingType: 'linear'
 		    },
            settings = $.extend(defaults, options),
            containerIDhash = '#' + settings.containerID,
            containerHoverIDHash = '#'+settings.containerHoverID;
		
		$('body').append('<a href="#" id="'+settings.containerID+'">'+settings.text+'</a>');
		$(containerIDhash).hide().on('click.UItoTop',function(){
			$('html, body').animate({scrollTop:0}, settings.scrollSpeed, settings.easingType);
			$('#'+settings.containerHoverID, this).stop().animate({'opacity': 0 }, settings.inDelay, settings.easingType);
			return false;
		})
		.prepend('<span id="'+settings.containerHoverID+'"></span>')
		.hover(function() {
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 1
				}, 600, 'linear');
			}, function() { 
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 0
				}, 700, 'linear');
			});
					
		$(window).scroll(function() {
			var sd = $(window).scrollTop();
			if(typeof document.body.style.maxHeight === "undefined") {
				$(containerIDhash).css({
					'position': 'absolute',
					'top': sd + $(window).height() - 50
				});
			}
			if ( sd > settings.min ) 
				$(containerIDhash).fadeIn(settings.inDelay);
			else 
				$(containerIDhash).fadeOut(settings.Outdelay);
		});
};
})(jQuery);

$().UItoTop({ easingType: 'easeOutQuart' });

</script>
