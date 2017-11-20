(function($) {
	Index = (function(){
		closewin = function() {
			//window.close();
			//console.log('close win.');
		};
		return {
			endloading : function(msg) {
				$('#loading').hide();
				$('body')
				.append( $('<div/>').attr({'id':'dialog'})
					.css({'height':'130px'})
					.addClass('generate_link').css('display','block')
					.html( "<div class='confirmWindow'><strong>Remotestaff</strong><hr>"
						+"<div style='float:left;padding:4px;width:100%;'>"
						+msg+"<p style='text-align:center;'><button id='btn_ok'>OK</button></p>"
						+"</div></div>")
					.jqm({overlay: 50, modal: true, trigger: false}).jqmShow()
				);
				$('#btn_ok').click(function(){
					jQuery('#dialog').jqmHide();
					$('input#saveForm').attr('disabled', true);
					window.location.href = 'http://www.remotestaff.com.au';
				});
				
			}
		}
	}());
	$(document).ready(function(){
		$('form#surveyform').submit(function() {
			$('#loading').show();
			var clunder = $("input[name=clunder]:checked").val();
			var poprof = $("input[name=poprof]:checked").val();
			var cleardef = $("input[name=cleardef]:checked").val();
			var how_fast = $("input[name=how_fast]:checked").val();
			var rate = $("input[name=rate]:checked").val();
			var ovrallcustxp = $("input[name=ovrallcustxp]:checked").val();
		
			if (clunder && poprof && cleardef && how_fast && rate && ovrallcustxp) {
				$(this).attr("action", "?/save_answers/");
				return true;
			} else {
				$('#loading').empty().append('Please complete the survey!').show().fadeOut(7000);
				return false;
			}
		});
	});
})(jQuery);