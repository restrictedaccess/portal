/**
 * Full text search Javascripts
 *
 * @author Marlon Peralta
 * @copyright Remote Staff Inc.
 *
 * @version 0.0.1
 * @method string addCandidatesPreloader()
 * @method string removeCandidatesPreloader()
 * @method string addJobOrdersPreloader()
 * @method string removeJobOrderPreloader()
 * @method string addLeadsPreloader()
 * @method string removeLeadsPreLoader()
 * @method string getCandidatesFromAPI(data)
 * @method string getJobOrdersFromAPI(data)
 * @method string getLeadsFromAPI(data)
 * @method string loadCandidates()
 * @method string loadJobOrders()
 * @method string loadLeads()
 * 
 */

var BASE_URL = jQuery("#BASE_URL").val();
var url_pages = "1";
var result_start;
var result_end;
	



jQuery(document).ready(function() {
	jQuery("#search-form").on("submit", function() {
		
		var data = jQuery(this).serialize();
		resetResult();
		url_pages = "1";
		getCandidatesDetailsFromAPI(data);
		getResumeDetailsFromAPI(data);
		getJobOrderDetailsFromAPI(data);
		getLeadsDetailsFromAPI(data);
		
		clearCandidatePagination();
		clearResumesPagination();
		clearJobOrdersPagination();
		clearLeadsPagination();
		
	
		document.location.hash = jQuery("#search-text-box").val();
		
		
		return false;
	});

	//check if search text has content
	if (jQuery("#search-text-box").val() != "") {
		
		if(document.location.hash != ""){
			var hash = document.location.hash;
			
			var splitted_hash = hash.split("#");
			
			jQuery("#search-text-box").val(splitted_hash[1]);
			
			document.location.hash = "";
			
			//document.location.search = "q=" + splitted_hash[1];
			
		}
		
		jQuery("#search-form").trigger("submit");
	}
	
	

	
	initDownloadCSVBtns();
	
	
	
}); //DOCUMENT READY 


function initDownloadCSVBtns(){
	jQuery("body").on("click", ".download_csv_btn", function(event){
		
		var q = jQuery("#search-text-box").val();
		
		var csvContent = "data:text/csv;charset=utf-8,";
		
		var input = document.createElement("input");
		
		input.setAttribute("hidden", true);
		
		input.setAttribute("value", csvContent);
		
		var get_requests = [];
		
		
		jQuery.ajaxSetup({timeout:0});
		
		
		getCandidatesCsv(0, 0, input, q);
		
		
		jQuery('body').isLoading({
	
			text : 'Generating CSV.',
	
			position : 'overlay',
	
			'class' : 'fa fa-spinner fa-pulse',
	
			tpl : '<span id="loading_candidates_csv" class="isloading-wrapper %wrapper%">%text%<i class="%class%"></i><div class="progress"><div id="loading_bar_csv" class="progress-bar" role="progressbar" style="width:0%">0%</div></div></span>'
	
		});
			
	});
}


function getCandidatesCsv(page_for_csv, max_page, input, q){
	
	var get_request = jQuery.ajax({
		type : "get",
		url : jQuery("#BASE_URL").val() + "/search/candidates/?q=" + q + "&csv=true&page_for_csv=" + page_for_csv,
		success : function(response) {
			var response_array = response.split("}");

			response_array[0] += "}";

			var json_response = jQuery.parseJSON(response_array[0]);

			var csvContent = input.getAttribute("value");

			max_page = json_response["max_page"];

			page_for_csv = json_response["page_for_csv"];
			csv_response = response_array[1];

			csvContent += csv_response;

			input.setAttribute("value", csvContent);
			
			updateLoadingDiv(max_page, page_for_csv);

		},
		error : function(request, status, error) {
			
			hideLoader();
		}
	});



	jQuery.when(get_request).done(function(){
		
		if (page_for_csv <= max_page) {
			getCandidatesCsv(page_for_csv, max_page, input, q);
		} else {
			csvContent = input.getAttribute("value");
			var now = new Date();
			var encodedUri = encodeURI(csvContent);
			var link = document.createElement("a");
			link.setAttribute("href", encodedUri);
			link.setAttribute("download", "recruiter_search_candidates_" + now.getFullYear() + "_" + now.getDay() + "_" + now.getMonth() + "_" + now.getHours() + "_" + now.getMinutes() + "_" + now.getMilliseconds() + ".csv");

			jQuery("body").append(link);

			// This will download the data file named ".csv".
			link.click();
			
			jQuery(link).remove();
			
			hideLoader();
		}

	});
	
}


function updateLoadingDiv(max_page, page_for_csv){
	
	var loading_div_span = jQuery("#loading_candidates_csv");

	var loading_div_text = jQuery("#loading_candidates_csv").text();

	if (loading_div_text == "" || loading_div_text == "Generating CSV...") {
		jQuery(loading_div_span).text("Generating CSV. ");
	} else if (loading_div_text == "Generating CSV. ") {
		jQuery(loading_div_span).text("Generating CSV..");
	} else if (loading_div_text == "Generating CSV..") {
		jQuery(loading_div_span).text("Generating CSV...");
	}
	
	var totalWidth = max_page;
	
	var current_width = page_for_csv;
	
	var current_percentage = Math.round((current_width / totalWidth) * 100);
	
	jQuery("#loading_bar_csv").width(current_percentage);
	
	jQuery("#loading_bar_csv").text(current_percentage + "%");
	
	
}

function getPaginationValues(response){
	
	
	fetched_count = Object.keys(response["result"]).length;
			
	result_end = (url_pages * response.num_rows) - (response.num_rows - fetched_count);
			
	result_start = ((url_pages - 1) * response.num_rows) + 1;
	
	
	return fetched_count;
}


function getCandidatesDetailsFromAPI(data) {
	
	showLoader();
	
	jQuery.get(jQuery("#BASE_URL").val() + "/search/candidates/?" + data + "&page=" + url_pages, function(response) {
		response = jQuery.parseJSON(response);
		console.log(response);
		
		jQuery("#candidates_badge").text(response.num_found);
		if (response.num_found < 1) {
			num_pages = 1;
			resetResult();
			
			jQuery("#download_csv_candidates").hide();
			
		} else {
			
			num_pages = Math.ceil(response.num_found / response.num_rows);
			
				result_start = ((url_pages - 1) * response.num_rows) + 1;
			if(response.num_rows > response.num_found){
				result_end = response.num_found;
			}else{
				result_end = (result_start + response.num_rows) - 1;
			}
			
			jQuery("#download_csv_candidates").show();
			
			var candidates_fetched = getPaginationValues(response);
			
			if(candidates_fetched <= 0){
				jQuery("#input_download_csv").hide();
			} else{
				jQuery("#input_download_csv").show();
			}
			
		}
		jQuery(".candidates_start_count").text(result_start);
		jQuery(".candidates_end_count").text(result_end);
		jQuery(".candidates_total_records").text(response.num_found);
		
		console.log(num_pages);
		var output = "";
		var src = jQuery("#candidate-row-template").html();
		var template = Handlebars.compile(src);
		jQuery.each(response.result, function(i, item) {
			if (item.staff_status == "") {
				item.staff_status = "Unprocessed";
			}
			if (item.staff_status == "Inactive") {
				item.candidate.inactive = true;
			} else {
				item.candidate.inactive = false;
			}
			output += template(item);
		});
		jQuery("#candidate_result_list").html(output);
		$('.candidates-pagination').twbsPagination({
			totalPages : num_pages,
			onPageClick : function(event, page) {
				url_pages = page;
				getCandidatesDetailsFromAPI(data);
			}
		});

	});
	hideLoader();
}

function getResumeDetailsFromAPI(data) {
	
	
	jQuery.get(jQuery("#BASE_URL").val() + "/search/resumes/?" + data + "&page=" + url_pages, function(response) {
		response = jQuery.parseJSON(response);
		console.log(response);
		
		jQuery("#resume_badge").text(response.num_found);
		if (response.num_found < 1) {
			num_pages = 1;
			resetResult();
		} else {
			num_pages = Math.ceil(response.num_found / response.num_rows);
				result_start = ((url_pages - 1) * response.num_rows) + 1;
				if(response.num_rows > response.num_found){
					result_end = response.num_found;
				}else{
					result_end = (result_start + response.num_rows) - 1;
				}
				
				
				getPaginationValues(response);
			
			
		}
		
		jQuery(".resume_start_count").text(result_start);
		jQuery(".resume_end_count").text(result_end);
		jQuery(".resume_total_records").text(response.num_found);
		console.log(num_pages);
		var output = "";
		var src = jQuery("#resumes-row-template").html();
		var template = Handlebars.compile(src);
		jQuery.each(response.result, function(i, item) {
			if (item.candidate.staff_status == "") {
				item.candidate.staff_status = "Unprocessed";
			}
			if (item.candidate.staff_status == "Inactive") {
				item.candidate.inactive = true;
			} else {
				item.candidate.inactive = false;
			}
			output += template(item);
		});
		jQuery("#resume_result_list").html(output);
		$('.resumes-pagination').twbsPagination({
			totalPages : num_pages,
			onPageClick : function(event, page) {
				url_pages = page;
				getResumeDetailsFromAPI(data);
			}
		});

	});

}


function getJobOrderDetailsFromAPI(data) {

	jQuery.get(jQuery("#BASE_URL").val() + "/search/job-orders/?" + data + "&page=" + url_pages, function(response) {
		response = jQuery.parseJSON(response);
		console.log(response);
		jQuery("#job_order_badge").text(response.num_found);
		if (response.num_found < 1) {
			num_pages = 1;
			resetResult();
			
		} else {
			num_pages = Math.ceil(response.num_found / response.num_rows);
				result_start = ((url_pages - 1) * response.num_rows) + 1;
				if(response.num_rows > response.num_found){
					result_end = response.num_found;
				}else{
					result_end = (result_start + response.num_rows) - 1;
				}
				
				
				getPaginationValues(response);
			

		}
		jQuery(".job_orders_start_count").text(result_start);
		jQuery(".job_orders_end_count").text(result_end);
		jQuery(".job_orders_total_records").text(response.num_found);
		console.log(num_pages);
		var output = "";
		var src = jQuery("#job-orders-row-template").html();
		var template = Handlebars.compile(src);
		jQuery.each(response.result, function(i, item) {
			output += template(item);
		});
		jQuery("#job_orders_result_list").html(output);
		$('.job-orders-pagination').twbsPagination({
			totalPages : num_pages,
			onPageClick : function(event, page) {
				url_pages = page;
				getJobOrderDetailsFromAPI(data);
			}
		});

	});

}
function getLeadsDetailsFromAPI(data) {

	jQuery.get(jQuery("#BASE_URL").val() + "/search/leads/?" + data + "&page=" + url_pages, function(response) {
		response = jQuery.parseJSON(response);
		console.log(response);
		jQuery("#leads_badge").text(response.num_found);
		if (response.num_found < 1) {
			num_pages = 1;
			resetResult();
		} else {
			num_pages = Math.ceil(response.num_found / response.num_rows);
				result_start = ((url_pages - 1) * response.num_rows) + 1;
				if(response.num_rows > response.num_found){
					result_end = response.num_found;
				}else{
					result_end = (result_start + response.num_rows) - 1;
				}
				
				
				getPaginationValues(response);
			
			
		}
		jQuery(".leads_start_count").text(result_start);
		jQuery(".leads_end_count").text(result_end);
		jQuery(".leads_total_records").text(response.num_found);
		console.log(num_pages);
		var output = "";
		var src = jQuery("#leads-row-template").html();
		var template = Handlebars.compile(src);
		jQuery.each(response.result, function(i, item) {
			output += template(item);
		});
		jQuery("#leads_result_list").html(output);
		$('.leads-pagination').twbsPagination({
			totalPages : num_pages,
			onPageClick : function(event, page) {
				url_pages = page;
				getLeadsDetailsFromAPI(data);
			}
		});

	});
}

function clearCandidatePagination() {
	$('.candidates-pagination').empty();

	$('.candidates-pagination').removeData("twbs-pagination");

	$('.candidates-pagination').unbind("page");
}

function clearResumesPagination() {
	$('.resumes-pagination').empty();

	$('.resumes-pagination').removeData("twbs-pagination");

	$('.resumes-pagination').unbind("page");
}

function clearJobOrdersPagination() {
	$('.job-orders-pagination').empty();

	$('.job-orders-pagination').removeData("twbs-pagination");

	$('.job-orders-pagination').unbind("page");
}

function clearLeadsPagination() {
	$('.leads-pagination').empty();

	$('.leads-pagination').removeData("twbs-pagination");

	$('.leads-pagination').unbind("page");
}

function showLoader() {

	$('body').isLoading({

		text : 'Loading',

		position : 'overlay',

		class : 'fa fa-spinner fa-pulse',

		tpl : '<span class="isloading-wrapper %wrapper%">%text%<i class="%class%"></i></span>'

	});

}

function hideLoader() {

	$('body').isLoading('hide');

}

function resetResult(){
		
		 result_start = "0";
		 result_end = "0";
}