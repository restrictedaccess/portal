(function($) {
	$(document).ready(function() {
		
		Calendar.setup({inputField : "from_date", trigger: "from_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		Calendar.setup({inputField : "to_date", trigger: "to_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		$('form#form_filter').submit(function(e) {
			var notice = $('select[name=notice]').val();
			var subcon = $('select[name=subcon]').val();
			var from_date = $('input[name=from_date]').val();
			var to_date = $('input[name=to_date]').val();
			window.location='/portal/subcon_compliance/?/reports/&notice='+notice+'&subcon='+subcon+'&from_date='+from_date+'&to_date='+to_date;
			e.preventDefault();
		});
	});
})(jQuery);