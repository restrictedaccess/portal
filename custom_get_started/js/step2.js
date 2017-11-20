$(function(){
	
	//INITIALIZE ALL
	initAll();
	
	//REMOVE NAVIGATION A EVENT
	$(document).on("click",'.navigation a',function( e ) {
		e.preventDefault();
	});
	
	//ADD CATEGORY ROW
	$(document).on("click","#add_position",function( e ) {
		e.preventDefault();
		add_category_row($(this));
	});
	
	//REMOVE CATEGORY ROW
	$(document).on("click", '.remove-row', function( e ) {
		e.preventDefault();
		remove_category_row($(this));
	});
	
	//UPDATE PRICING TABLE
	$(document).on('change', '.update-price', function( e ) {
		e.preventDefault();
		update_pricing_table($(this));
	});
	
	//UPDATE PRICING TABLE
	$(document).on('input', '.update-price-text', function( e ) {
		e.preventDefault();
		update_pricing_table($(this));
	});
	
	//CATEGORY SELECT
	$(document).on('change', '.category-select', function( e ) {
		e.preventDefault();
		category_select($(this));
	});

	//CONTINUE STEP 3
	$(document).on('click','#continue-step-3',function( e ) {
		e.preventDefault();
		continue_step_3($(this));
	});
	
});

//GET INPUT FUNCTION
function get_input(){
	var categories = [];
	var subcategories = [];
	var no_of_staffs = [];
	var levels = [];
	var work_statuses = []
	var data = {};
	data.job_orders = [];
	$(".category-select").each(function(){
		categories.push($(this).val());
	});
	$(".sub-category-select").each(function(){
		subcategories.push($(this).val());
	});
	$(".no_of_staff").each(function(){
		var val = $(this).val()
		if ($.trim(val)==""||isNaN(val)){
			no_of_staffs.push(1);
		}else{
			no_of_staffs.push(val);
		}
	});
	$(".level-select").each(function(){
		levels.push($(this).val());
	});
	$(".work-status-select").each(function(){
		work_statuses.push($(this).val());
	});
	$.each(categories, function(i, category){
		if (levels[i]!=""&&no_of_staffs[i]!=""&&subcategories[i]!=""&&categories[i]!=""&&work_statuses[i]!=""){
			data.job_orders.push({level:levels[i], no_of_staff:no_of_staffs[i], subcategory:subcategories[i], category:categories[i], work_status:work_statuses[i]})		
		}
	});
	data.currency = $(".currency-select").val();
	return data;
}

//ADD CATEGORY ROW FUNCTION
function add_category_row(thisObj) {
	var template = $("#category_row").html();
	$( "#job_order_list" ).append(template).children(':last').hide().fadeIn('normal').show();
	initChosen();
}

//REMOVE CATEGORY ROW FUNCTION
function remove_category_row(thisObj) {
	thisObj.closest('.row').fadeOut('normal', function(){
		thisObj.closest('.row').remove();
		update_pricing_table();
	});
}

//CATEGORY SELECT FUNCTION
function category_select(thisObj){
	var category_id = thisObj.val();
	$.get('/portal/custom_get_started/get_sub_categories.php?category_id='+category_id, function(response){
		response = $.parseJSON(response);
		if (response.success){
			var option = '<option value=""></option>';
			if (response.subcategories.length > 0){
				$.each(response.subcategories, function(i, item){
					option += '<option value="'+item.sub_category_id+'">'+item.sub_category_name+"</option>";
				});
			}
			thisObj.closest('.row').find('select.sub-category-select').html(option).val("").trigger("chosen:updated");
		}
	});
	update_pricing_table();
}

//UPDATE PRICING TABLE FUNCTION
function update_pricing_table(thisObj){
	var data = get_input();
	$.post("/portal/custom_get_started/get_rates.php", data, function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		if (response.length > 0){
			var src = jQuery("#pricing_table_row").html();
			$.each(response, function(i, item){
				item.i = i+1;
				var template = Handlebars.compile(src);
				output+= template(item);
			});			
		}
		$("#pricing_table tbody").html(output);
	});
}

//CONTINUE STEP 3 FUNCTION
function continue_step_3(thisObj){
	
	var field_filled = true;
	
	var field_type = 'category';
	
	var active_element = thisObj;
	
	//CHECK ALL WORK STATUS IF THERE ARE VALUES
	$( '.no_of_staff' ).each( function() {
		
		if( $( this ).val() == '' ) {

			field_filled = false;
			
			field_type = 'no. of staff needed';
			
			active_element = $( this );

			return false; 

		}
		
	} );
	
	//CHECK ALL WORK STATUS IF THERE ARE VALUES
	$( '.work-status-select' ).each( function() {
		
		if( $( this ).chosen().val() == '' ) {

			field_filled = false;
			
			field_type = 'work time';
			
			active_element = $( this );

			return false; 

		}
		
	} );
	
	//CHECK ALL LEVEL IF THERE ARE VALUES
	$( '.level-select' ).each( function() {
		
		if( $( this ).chosen().val() == '' ) {

			field_filled = false;
			
			field_type = 'level';
			
			active_element = $( this );

			return false; 

		}
		
	} );
	
	//CHECK ALL SUB CATEGORY IF THERE ARE VALUES
	$( '.sub-category-select' ).each( function() {
		
		if( $( this ).chosen().val() == '' ) {

			field_filled = false;
			
			field_type = 'subcategory';
			
			active_element = $( this );

			return false; 

		}
		
	} );
	
	//CHECK ALL CATEGORY IF THERE ARE VALUES
	$( '.category-select' ).each( function() {
		
		if( $( this ).chosen().val() == '' ) {

			field_filled = false;
			
			field_type = 'category';
			
			active_element = $( this );

			return false; 

		}
		
	} );
	
	
	if( $( '#currency' ).val() == '' ) {
		
		//alert( 'Please fill up currency!' );
		
		alert('Please fill up required fields!');
		
		if( ! $( '#currency' ).is( ":focus" ) ) {
			
			$( '#currency' ).focus();
		
			$( '#currency' ).trigger( 'chosen:open' );
		
		}
		
	} else if( ! field_filled ) {
		
		//alert( 'Please fill up all ' + field_type + '!' );
		
		alert('Please fill up required fields!');
		
		if( ! active_element.is( ":focus" ) ) {
		
			active_element.focus();
			
			if( field_type != 'no of staff' ) {
				 
				active_element.trigger( 'chosen:open' );
				
			}
		
		}
		
	} else {
		
		var total_category = $( '.category-select' ).length;
		
		var role = ( total_category > 1 ? 'roles' : 'role' );
		
		//var answer = confirm( 'Do you want to save this job ' + role + '?' );
		
		//if( answer ) {
			
			_show_loader_targeted( 'body' );
	
			var data = get_input();
			
			$.post("/portal/custom_get_started/process_step2.php", data, function( response ) { 
				
				response = $.parseJSON( response );
				
				if ( response.success ) {
					
					window.location.href = '/portal/custom_get_started/step3.php';
					
				} else {
					
					//alert('Something went wrong. Please try again.');
					
					alert('Please fill up the required fields!');
					
				}
				
				_hide_loader_targeted( 'body' );
				
			} );
			
		//}
		
	}

}

//SHOW LOADER TARGETED
function _show_loader_targeted( targeted ) { 
	
	$( targeted ).isLoading( {
		
		text : 'Saving',
		
		position: 'overlay',

		class: 'fa fa-spinner fa-pulse',
		
		tpl : '<span class="isloading-wrapper %wrapper%">%text%<i class="%class%"></i></span>'
	
	} );
	
}

//HIDE LOADER TARGETED
function _hide_loader_targeted( targeted ) {
	
	$( targeted ).isLoading( 'hide' );
	
}

//INITIALIZE ALL FUNCITON
function initAll(){
	initChosen();
}

//INITIALIZE CHOSEN FUNCTION
function initChosen(){
	$('.chosen').chosen({
		width:"100%",
		disable_search: true,
		allow_single_deselect:true
	});
}
