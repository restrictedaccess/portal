jQuery(document).ready(function(){
	jQuery(".popup").live("click", function(e){
		var href = jQuery(this).attr("href")
		window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		e.preventDefault()
	})
})
