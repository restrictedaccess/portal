// JavaScript Document
function suggest(inputString){
		if(inputString.length == 0) {
			$('#suggestions').fadeOut();
		} else {
		//$('#inquiring_about').addClass('load');
			$.post("./autosuggest/autosuggest.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').fadeIn();
					$('#suggestionsList').html(data);
					//$('#inquiring_about').removeClass('load');
				}
			});
		}
	}

function fill(thisValue) {
	$('#inquiring_about').val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 1000);
	//$('#inquiring_about').removeClass('load');
}
