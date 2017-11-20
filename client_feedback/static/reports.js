(function($) {
	$(document).ready(function() {
		
		Calendar.setup({inputField : "from_date", trigger: "from_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		Calendar.setup({inputField : "to_date", trigger: "to_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		$("input[name=needreply][value={/literal}{$result.reply}{literal}]").attr('checked', true);
		
		$('form#filter_form').submit(function(e) {
			var client = $('select[name=client]').val();
			var csro = $('select[name=csro]').val();
			var status = $('select[name=status]').val();
			var from_date = $('input[name=from_date]').val();
			var to_date = $('input[name=to_date]').val();
			window.location='/portal/client_feedback/?/reports/&client='+client+'&csro='+csro+'&status='+status+'&from_date='+from_date+'&to_date='+to_date;
			e.preventDefault();
		});
		
		$('form#summary_filter').submit(function(e) {
			var from_date = $('input[name=from_date]').val();
			var to_date = $('input[name=to_date]').val();
			window.location='/portal/client_feedback/?/summary/&from_date='+from_date+'&to_date='+to_date;
			e.preventDefault();
		});
	});
})(jQuery);