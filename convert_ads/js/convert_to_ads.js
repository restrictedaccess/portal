


var total_requirement = $('input.requirements').length;
var total_responsibility = $('input.responsibilities').length;

var requirement_sequence = $('#requirements_sort .requirements_sequence').length;
var responsibility_sequence = $('#responsibilities_sort .responsibilities_sequence').length;

$(function(){

	//REQUIREMENTS SORTABLE
	$('#requirements_sort').sortable({
		connectWith: "ul.requirements",
		update : function () {
			$('#requirements_sort input.requirements_sequence').each(function(idx) {          
				$(this).val(idx); 
			});
			//SET TO EMPTY
			$('#requirements_sort input.requirements_type').val('');
		}
	});
	 
	//REQUIREMENTS MUST TO HAVE SORTABLE
	$('#requirements_must_to_have_sort').sortable({
		connectWith: "ul.requirements",
		update : function () {
			$('#requirements_must_to_have_sort input.requirements_sequence').each(function(idx) {          
				$(this).val(idx);
			});
			//SET TO EMPTY
			$('#requirements_must_to_have_sort input.requirements_type').val('must to have');
		}
	});
	
	//REQUIREMENTS GOOD TO HAVE SORTABLE
	$('#requirements_good_to_have_sort').sortable({
		connectWith: "ul.requirements",
		update : function () {
			$('#requirements_good_to_have_sort input.requirements_sequence').each(function(idx) {          
				$(this).val(idx);
			});
			//SET TO EMPTY
			$('#requirements_good_to_have_sort input.requirements_type').val('good to have');
		}
	});
	
	//REQUIREMENTS DISABLE SELECTION
	//$( "#requirements_sort, #requirements_must_to_have_sort, #requirements_good_to_have_sort" ).disableSelection();
	
	
	//RESPONSIBILITIES SORTABLE
	$('#responsibilities_sort').sortable({
		connectWith: "ul.responsibilities",
		update : function () {
			$('#responsibilities_sort input.responsibilities_sequence').each(function(idx) {          
				$(this).val(idx);
			});
		}
	});
	
	//REQUIREMENTS DISABLE SELECTION
	//$( "#responsibilities_sort, #responsibilities_must_to_have_sort, #responsibilities_good_to_have_sort" ).disableSelection();

	$(document).on('click','#convert_to_ads',function(e){
		e.preventDefault();
		var form_validated = validate_ads_form();
		if(form_validated){
			$('#action').val('convert'); //CHANGE ACTION TO CONVERT
			$('#ads-form').submit(); //SUBMIT FORM
		}
	});

	//SUBMIT ADS FORM
	$(document).on("submit",'#ads-form',function(e){
		var form_validated = validate_ads_form();
		if(form_validated) {
			var answer = confirm( 'Do you really want to ' + ( $('input[name=action]').val() == 'update' ? 'update' : 'convert' ) + ' Ads!' );
			if( answer ) {
				var data = jQuery(this).serializeArray();
				showLoader();
				$.ajax({
					type: 'POST', 
					url: '/portal/convert_ads/convert.php',
					data: data,
					dataType: 'json',
					success: function(response) {
						if(response.success){
							var action;
							if( response.action == 'update' ){
								action = 'updated';
							} else {
								action = 'converted';
							}
							alert( 'Ads successfully ' + action + '!' );
							window.location.href="/portal/convert_ads/convert_to_ads.php?gs_job_titles_details_id="+response.job_order_id;
						}
					}
				});
			}else{
				$('#action').val('update'); //RESET ACTION TO UPDATE
			}
		}
		return false;
	});
	
	//ADD REQUIREMENT BTN
	$(document).on('click','#add_requirement_btn',function(e){
		e.preventDefault();
		add_requirement($(this));
	});
	
	//REMOVE REQUIREMENT
	$(document).on('click','.remove_requirement',function(e){
		e.preventDefault();
		var answer = confirm('Do you want to remove this requirement?');
		if(answer){
			remove_requirement($(this));
		}
	});
	
	//ADD RESPONSIBILITY BTN
	$(document).on('click','#add_responsibility_btn',function(e){
		e.preventDefault();
		add_responsibility($(this));
	});
	
	//ADD REMOVE RESPONSIBILITY
	$(document).on('click','.remove_responsibility',function(e){
		e.preventDefault();
		var answer = confirm('Do you want to remove this responsibility?');
		if(answer){
			remove_responsibility($(this));
		}
	});
	
});

function add_requirement(thisObj){
	
	total_requirement  = total_requirement + 1;
	requirement_sequence = requirement_sequence + 1;
	
	var context = {
			sequence: total_requirement,
			requirement_sequence: requirement_sequence
		};
	var source   = $("#new_requirement_template").html();
	var template = Handlebars.compile(source);
	
	//APPEND NEW REQUIREMENT
	$('ul#requirements_sort').append(template(context)).children('li:last').hide().fadeIn('normal');
	
	$('.chosen').chosen({
		width:"100%",
		no_results_text:"Oops, nothing found!",
		allow_single_deselect:true,
		disable_search:true
	});

}

function remove_requirement(thisObj){
	
	total_requirement  = total_requirement - 1;
	
	//REMOVE SELECTED REQUIREMENT
	thisObj.closest( "li" ).fadeOut("normal", function(){
        $(this).remove();
    });
    
}

function add_responsibility(thisObj){
	
	total_responsibility  = total_responsibility + 1;
	responsibility_sequence = responsibility_sequence + 1;
	
	var context = {
			sequence: total_responsibility,
			responsibility_sequence: responsibility_sequence
		};
	var source   = $("#new_responsibility_template").html();
	var template = Handlebars.compile(source);
	
	//APPEND NEW RESPONSIBILITIES
	$('ul#responsibilities_sort').append(template(context)).children('li:last').hide().fadeIn('normal');
	
	
}

function remove_responsibility(thisObj){
	
	total_responsibility  = total_responsibility - 1;
	
	//REMOVE SELECTED RESPONSIBILITY
	thisObj.closest( "li" ).fadeOut("normal", function(){
        $(this).remove();
    });
	
}

function validate_ads_form(){

	var ads_title = $('input[name=ads_title]');
	var sub_category_id = $('select[name=sub_category_id]');
	var classification = $('select[name=classification]');
	var outsourcing_model = $('select[name=outsourcing_model]');
	var company = $('select[name=company]');
	var show_status = $('select[name=show_status]');

	//SET REQUIREMENT AND RESPONSIBILITY MISSING VALUE TO FALSE
	var requirements_missing_value = false;
	var requirement_rating_missing_value = false;
	var responsibilities_missing_value = false;
	
	//VALIDATE ALL REQUIREMENTS VALUE
	$('input.requirements').each(function(idx) {          
		if($(this).val()==''){
			requirements_missing_value = true;
			return false;
		}
	});
	
	//VALIDATE ALL REQUIREMENTS RATING
	$('select.requirement_rating').each(function(idx) {          
		if($(this).val()==''){
			requirement_rating_missing_value = true;
			return false;
		}
	});
	
	//VALIDATE ALL RESPONSIBILITIES VALUE
	$('input.responsibilities').each(function(idx) {          
		if($(this).val()==''){
			responsibilities_missing_value = true;
			return false;
		}
	});
	
	if(ads_title.val() == ''){
		
		alert('Please fill up Ads Title!');
		ads_title.focus();
		return false;
		
	}else if(sub_category_id.val() == ''){
		
		alert('Please select Category!');
		sub_category_id.trigger("liszt:updated");
		return false;
		
	}else if(classification.val() == ''){
		
		alert('Please select Classification!');
		classification.trigger("liszt:updated");
		return false;
		
	}else if(outsourcing_model.val() == ''){
		
		alert('Please select Outsourcing Model!');
		outsourcing_model.trigger("liszt:updated");
		return false;
		
	}else if(company.val() == ''){
		
		alert('Please select Company!');
		company.trigger("liszt:updated");
		return false;
		
	}else if(tinyMCE.activeEditor.getContent() == ''){
		
		alert('Please fill up Heading!');
		tinymce.execCommand('mceFocus',false,'heading');
		return false;
		
	}else if(show_status.val() ==''){
		
		alert('Please select Status!');
		show_status.trigger("liszt:updated");
		return false;
		
	}else if(total_requirement == 0) {
		
		alert('Please add Requirement!');
		return false;
		
	}else if(total_responsibility == 0){
		
		alert('Please add Responsibility!');
		return false;
		
	}else if(requirements_missing_value){
		
		alert('Please fill up all requirement value!');
		return false;
		
	}else if(requirement_rating_missing_value){
		
		alert('Please fill up all requirement rating!');
		return false;
		
	}else if(responsibilities_missing_value){
		
		alert('Please fill up all responsibility value!');
		return false;

	}else{
		
		return true;
		
	}

}

