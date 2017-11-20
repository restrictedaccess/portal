var current_page = 1;

function filterForm(page) {
	var url = "/portal/recruiter/load_referrals.php?search";
	if (jQuery.trim(jQuery("#date_from").val()) != "") {
		url += ("&date_from=" + jQuery.trim(jQuery("#date_from").val()));
	}
	if (jQuery.trim(jQuery("#date_to").val()) != "") {
		url += ("&date_to=" + jQuery.trim(jQuery("#date_to").val()));
	}
	url += "&filter_type=1";
	if (jQuery.trim(jQuery("#text-search").val()) != "") {
		url += ("&filter_text=" + jQuery.trim(jQuery("#text-search").val()));
	}
	if ( typeof page == "undefined") {
		url += "&page=1";
	} else {
		url += "&page=" + page;
	}
	url += ("&status=" + jQuery("#refer_type").val());
	url += "&rows=50"
	jQuery.get(url, function(response) {
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.rows, function(i, item) {
			var src = jQuery("#referral-row-template").html();
			var template = Handlebars.compile(src);
			output += template(item);
		});

		jQuery("#search_result tbody").html(output);

		var start = ((parseInt(response.page) - 1) * 50) + 1;
		var end = start + 49;

		if (end >= response.records) {
			end = response.records;
			jQuery(".next").addClass("disabled");
		} else {
			jQuery(".next").removeClass("disabled");
		}

		if (response.page == 1) {
			jQuery(".previous").addClass("disabled");
		} else {
			jQuery(".previous").removeClass("disabled");
		}

		jQuery(".page-start").html(start)
		jQuery(".page-end").html(end)
		jQuery(".page-total").html(response.records);

		var total_page = Math.ceil(response.records / 50);
		var src_pager = jQuery("#page-row-template").html();
		var template_pager = Handlebars.compile(src_pager);
		output = "";
		for (var i = 1; i <= total_page; i++) {
			output += template_pager(i);
		}

		jQuery(".pager-select").html(output);
		jQuery(".pager-select").val(response.page);
		current_page = parseInt(response.page);

	});
}


jQuery(document).ready(function() {
	jQuery("#date_from").datepicker();
	jQuery("#date_to").datepicker();
	jQuery("#date_from").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#date_to").datepicker("option", "dateFormat", "yy-mm-dd");

	jQuery("#referral-filter").submit(function() {
		filterForm();
		return false;
	}).trigger("submit");

	jQuery(".pager-select").change(function() {
		filterForm(jQuery(this).val());
		return false;
	});
	
	jQuery(".previous > a").on("click", function(e){
		if (!jQuery(this).parent().hasClass("disabled")){
			filterForm(current_page-1);
		}
		e.preventDefault();
	})
	jQuery(".next > a").on("click", function(e){
		if (!jQuery(this).parent().hasClass("disabled")){
			filterForm(current_page+1);
		}
		e.preventDefault();
	})
});

jQuery(document).on("click", ".contacted", function() {
	var id = jQuery(this).attr("data-id");
	if (jQuery(this).is(":checked")) {
		jQuery.post("/portal/recruiter/update_referral_contacted.php", {
			id : id,
			contacted : 1
		}, function(data) {
		});
	} else {
		jQuery.post("/portal/recruiter/update_referral_contacted.php", {
			id : id,
			contacted : 0
		}, function(data) {
		});
	}
});

jQuery(document).on("click", ".convert_job_seeker", function() {
	var referralId = jQuery(this).attr("data-id");
	if (jQuery(this).is(":checked")) {
		popup_win("/portal/candidates/?referral_id=" + referralId + "&type=popup", 800, 600);
	} else {
		jQuery(this).attr("checked", "checked");
	}
}); 