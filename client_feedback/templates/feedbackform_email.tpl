<link rel="stylesheet" type="text/css" href="/portal/client_feedback/static/styles.css" />
<iframe id='ajaxframe' name='ajaxframe' style='display:none;height:10px;' src='javascript:false;'></iframe>
<span id='loading'>LOADING...</span>
	<strong>Send Feedback Form via email: </strong> <a href='#' class='jqmClose' style='float:right'>Close</a><hr style='width:100%'>
				
		
	<div style="float:left;width:100%;height:170px;padding:4px;">
		
		<form action='#' method='post' id='emailform' class='ff' target='ajaxframe'>
			<input id="leads_id" name="leads_id" type="hidden" value="{$leads_id}"/>
			<input id='hash' name='hash' type='hidden' value='{$hash}'/>
			<!--<header>
			  <div>Feedback form will be attached to this email.</div>
			</header>-->
			<div>
			  <label class="desc" id="title7" for="Field4">Client Name</label>
			
			  <div>
				<input type="text" name="client_name" value="{$client_fullname}" style="width:100%"/>
			  </div>
			</div>

			<div>
			  <label class="desc" id="title7" for="Field4">Email Address</label>
			
			  <div>
				<input type="text" name="email" value="{$emailaddr}" style="width:100%"/>
			  </div>
			</div>
			
			<div>
				  <div><input id="saveForm" name="sendForm" type="submit" value="Send Email"/></div>
			</div>
		</form>
    </div>
	
	<script type='text/javascript'>

	{literal}
	jQuery(document).ready(function($) {
	
		$('form#emailform').submit(function() {
			$('#loading').show();
			//var leads_id = $("input#leads_id").val();
			//var ticket_id = $("input#ticket_id").val();
			var clientname = $("input[name=client_name]").val();
			var emailaddr = $("input[name=email]").val();
			
			//console.log(leads_id+' '+ticket_id);
			if (emailaddr && clientname) {
				$(this).attr("action", "/portal/client_feedback/?/send_email");
				return true;
			} else {
				alert("Empty field found! Unable to continue.");
				return false;
			}
		});
	});
	
	function endloading(errormsg) {
		if(errormsg) {
			jQuery('#loading').empty().append(errormsg).show().fadeOut(7000);
		} else {
			jQuery('#loading').empty().append('Email has been successfully sent!').show().fadeOut(7000);
			setTimeout(function(){jQuery('#linkgenerate').jqmHide();}, 5000);
		}
	}
	function showmsg() {
		jQuery('#loading').empty().append('Email has been successfully sent!').show().fadeOut(7000);
		setTimeout(function(){jQuery('#linkgenerate').jqmHide();}, 5000);
	}
	{/literal}
	</script>