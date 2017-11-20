/* GLOBAL VARIABLES */
var skill_selected = new Array();

var rating_skill_selected = new Array();

var task_selected = new Array();

var rating_task_selected = new Array();

$( function() {
	
	//INITIALIZE ALL
	initAll();
	
	//INITIALIZE ALL UPDATES
	//_update_step_one();

	//NOT EQUAL ALT EMAIL VALIDATOR ADD METHOD
	$.validator.addMethod( "notEqualAltEmail", function( value, element, param ) {
		
		return this.optional( element ) || value != $( param ).val();
		
	}, "Email address must not be equal" );

	//UPDATE STEP ONE
	$( document ).on( 'click', '#update_step_one_btn', function( e ) {
		
		e.preventDefault();
	
		_update_step_one( $( this ) );
	
	} );
	
	//UPDATE STEP TWO
	$( document ).on( 'click', '#update_step_two_btn', function( e ) {
		
		e.preventDefault();
		
		_update_step_two( $( this ) );
		
	} );
	
	//UPDATE STEP THREE
	$( document ).on( 'click', '#update_step_three_btn', function( e ) {
		
		e.preventDefault();
		
		_update_step_three( $( this ) );
		
	} );

	//GET STATE
	$( '#leads_country' ).change(function( e ) {
		
		e.preventDefault();
		
		_get_state( $( this ) );
		
	});
	
	//GET CITY
	$( '#leads_state' ).change(function( e ) {

		e.preventDefault();

		_get_city( $( this ) );
		
	} );
	
	//UPDATE PRICE
	$( document ).on( "change", '.update-price', function( e ) {
		
		e.preventDefault();
		
		_update_pricing_table();
		
	} );

	//UPDATE PRICE
	$( document ).on( 'input', '.update-price-text', function( e ) {
		
		e.preventDefault();
		
		_update_pricing_table();
		
	} );

	//CATEGORY SELECT
	$( document ).on( 'change', '.category-select', function( e ) {
		
		_category_select( $( this ) );

	} );
	
	//SHIFT TIME START SELECT
	$( document ).on( 'change', '.shift_time_start', function( e ) {

		_shift_time_start_select( $( this ) );
		
	} );
	
	//ADD JOB ROLE ROW
	$( document ).on( 'click', '.add-row', function( e ) {
		
		e.preventDefault();

		_add_row( $( this ) );
		
	} );
	
	//ADD RESPONSIBILITY
	$( document ).on( 'click', '.add-responsibility', function( e ) {
		
		e.preventDefault();
		
		_add_responsibility( $( this ) );

	} );
	
	//ADD OTHER SKILLS
	$( document ).on( 'click', '.add-other_skills', function( e ) {
		
		e.preventDefault();
		
		_add_other_skill( $( this ) );
		
	} );
	
	//REMOVE JOB ROLE ROW
	$( document ).on( 'click', '.remove-row', function( e ) {
		
		e.preventDefault();
		
		_remove_row( $( this ) );
		
	} );
	
	//REMOVE CLOSEST CREDENTIAL RECORD
	$( document ).on( 'click', '.delete-creds', function( e ) {
		
		e.preventDefault();
		
		_delete_credential( $( this ) );
		
	} );

	//CHANGE STAFF REPORT DIRECTLY
	$( document ).on( 'click', '.staff_report_directly', function( e ) {
		
		_staff_report_directly( $( this ) );
		
	} );

	//LAUNCH SKILL MODAL
	$( document ).on( 'click', '.launch-skill', function( e ) {
		
		e.preventDefault();
		
		_launch_skill( $( this ) );
		
	} );
	
	//LAUNCH TASK MODAL
	$( document ).on( 'click', '.launch-task', function( e ) {
		
		e.preventDefault();
		
		_launch_task( $( this ) );
		
	} );

	//ADD NEW SKILL
	$( document ).on( 'submit', '#add-new-skill' ,function( e ) {
		
		e.preventDefault();
		
		_add_new_skill( $( this ) );
		
	} );
	
	//ADD NEW TASK
	$( document ).on( 'submit', '#add-new-task', function( e ) {
		
		e.preventDefault();
		
		_add_new_task( $( this ) );
		
	} );
	
	//SEARCH SKILL ON KEYUP
	$( document ).on( 'keyup', '#search_skill', function( e ) {
		
		e.preventDefault();
		
		searchSkill( $( this ) );
		
	} );
	
	//SEARCH TASK ON KEYUP
	$( document ).on( 'keyup', '#search_task', function( e ) {
		
		e.preventDefault();
		
		searchTask( $( this ) );
		
	} );

	//SELECT SKILLS
	$( document ).on("click", '#select-skill', function() {
		var me = $(this);
		var id = me.attr("data-gs_job_titles_details_id");
		var output = "";
		var outputDiv = "";
		var i = 0;
		var all_skill_have_rating = true;
		jQuery("input[name='skill-selected[]']:checked").each(function(){
			var ratings = jQuery(this).parent().parent().find(".rating-skill-selected").val();
			var original_ratings = ratings;
			if(ratings == ''){
				all_skill_have_rating = false;
			}
			if (ratings == 1){
				ratings = "Beginner (1-3 years)";
			}else if (ratings == 2){
				ratings = "Intermediate (3-5 years)"
			}else if (ratings==3){
				ratings = "Advanced (More than 5 years)";
			}else{
				all_skill_have_rating = false;
				ratings = "N/A"
			}
			output+="<tr>";
				output+="<td>"+jQuery(this).attr("data-label")+"</td>";
				output+="<td>"+ratings+"</td>";
			output+="</tr>";
			
			outputDiv+="<input type='hidden' name='skills["+id+"]["+jQuery(this).val()+"]' class='selected-skill' data-gs_job_titles_details_id='"+id+"' value='"+jQuery(this).val()+"'/>";
			outputDiv+="<input type='hidden' name='skills-proficiency["+id+"]["+jQuery(this).val()+"]' class='selected-skill-proficiency' data-gs_job_titles_details_id='"+id+"' value='"+original_ratings+"'/>";
		});
		if(all_skill_have_rating){
			if (output!=""){
				jQuery("#skill-list-selected-"+id+" tbody").html(output);
				jQuery("#skill-list-selected-"+id).show();
			}else{
				jQuery("#skill-list-selected-"+id+" tbody").html(output);
				jQuery("#skill-list-selected-"+id).hide();
			}
			jQuery("#skill-id-selected-"+id).html(outputDiv);
			jQuery("#addSkillListModal").modal("hide");
		}else{
			alert( 'Please select rate rating of the selected skill!' );
		}
	});
	
	//SELECT TASKS
	$( document ).on( 'click' , '#select-tasks', function() {
		var me = $(this);
		var id = me.attr("data-gs_job_titles_details_id");
		var output = "";
		var outputDiv = "";
		var i = 0;
		var all_task_have_rating = true;
		jQuery("input[name='task-selected[]']:checked").each(function(){
			var ratings = jQuery(this).parent().parent().find(".rating-task-selected").val();
			var original_ratings = ratings;
			if(ratings == ''){
				all_task_have_rating = false;
			}
			output+="<tr>";
				output+="<td>"+jQuery(this).attr("data-label")+"</td>";
				output+="<td>"+ratings+"/10</td>";
			output+="</tr>";
			
			outputDiv+="<input type='hidden' name='tasks["+id+"]["+jQuery(this).val()+"]' class='selected-task' data-gs_job_titles_details_id='"+id+"' value='"+jQuery(this).val()+"'/>";
			outputDiv+="<input type='hidden' name='tasks-proficiency["+id+"]["+jQuery(this).val()+"]' class='selected-task-proficiency' data-gs_job_titles_details_id='"+id+"' value='"+original_ratings+"'/>";
		});
		if(all_task_have_rating){
			if (output!=""){
				jQuery("#task-list-selected-"+id+" tbody").html(output);
				jQuery("#task-list-selected-"+id).show();
			}else{
				jQuery("#task-list-selected-"+id+" tbody").html(output);
				jQuery("#task-list-selected-"+id).hide();
			}
			jQuery("#task-id-selected-"+id).html(outputDiv);
			jQuery("#addTaskListModal").modal("hide");
		}else{
			alert( 'Please select rate rating of the selected task!' );
		}
	});

	//CHECKBOX SKILL SELECTED
	$( document ).on('click', '.skill-selected',function( e ) {
		//console.log(skill_selected);
		var id = $(this).attr('id');
		if(!$(this).is(":checked")){
			for (var i =0; i < skill_selected.length; i++){
			   if (skill_selected[i].value === $(this).val()) {
				  skill_selected.splice(i,1);
				  skill_selected = skill_selected.filter(function(n){ return n != undefined }); 
				  //break;
			   }
			}
		}else{
			var skill = {
				'id':id,
				'value':$(this).val()
			}
			skill_selected.push(skill);
		}
	});

	//CHECKBOX TASK SELECTED
	$( document ).on('click', '.task-selected',function( e ) {
		var id = $(this).attr('id');
		if(!$(this).is(":checked")){
			for (var i =0; i < task_selected.length; i++){
			   if (task_selected[i].value === $(this).val()) {
				  task_selected.splice(i,1);
				  task_selected = task_selected.filter(function(n){ return n != undefined }); 
				  //break;
			   }
			}
		}else{
			var task = {
				'id':id,
				'value':$(this).val()
			}
			task_selected.push(task);
		}
	});

	//CHECKBOX TR SELECTED
	$( document ).on( 'click', '#skill-select-form tr, #task-select-form tr', function( e ) {
		
		if ( e.target.type !== 'checkbox' && e.target.tagName !== 'SELECT' && e.target.tagName === 'TD' ) { 
			
			$( ':checkbox', this ).trigger( 'click' );
			
		}
		
	} );
	
	//DROPDOWN SKILL SELECTED
	$( document ).on( 'change', '.rating-skill-selected', function( e ) {
		
		e.preventDefault();
		
		skillChange( $( this ) );
		
	} );
	
	//DROPDOWN TASK SELECTED
	$( document ).on( 'change', '.rating-task-selected', function( e ) {
		
		e.preventDefault();
		
		taskChange( $( this ) );
		
	} );

	//RESET ARRAY ON MODAL CLOSE
	$( document ).on( 'hidden.bs.modal', '#addSkillListModal', function( e ) {
		
		skill_selected = new Array();
		
		rating_skill_selected = new Array();
		
		$( '#search_skill' ).val('');
		
	} );
	
	//RESET ARRAY ON MODAL CLOSE ADD TASK LIST MODAL
	$( document ).on( 'hidden.bs.modal', '#addTaskListModal', function( e ) {
		
		task_selected = new Array();
		
		rating_task_selected = new Array();
		
		$( '#search_task' ).val('');
		
	} );

	//NAVIGATION TO OPTION STEP 4
	$( document ).on( 'click', '#optional_step4_btn', function( e ) {
		
		e.preventDefault();
		
		_optional_step_4( $( this ) );
		
	} );

} );


$( document ).ready( function() {

	//SELECT LEADS COUNTRY DEFAULT VALUE
	$( "#leads_country" ).val( leads_address_country_id ).trigger( "change" ).trigger( "chosen:updated" );
	
	setTimeout( function() {
		
		//SELECT LEADS STATE DEFAULT VALUE
		$( "#leads_state" ).val( leads_address_state_id ).trigger( "change" ).trigger( "chosen:updated" );
	
	}, 700 );
	
	setTimeout( function() {
		
		//SELECT LEADS CITY DEFAULT VALUE
		$( "#leads_city" ).val( leads_address_city_id ).trigger( "change" ).trigger( "chosen:updated" );
	
	},1200 );
	
} );

//UPDATE STEP ONE FUNCTION
function _update_step_one( thisObj ) {
	
	/*
	$.validator.addMethod( "alpha", function( value, element ) {
		
		return this.optional( element ) || value == value.match( /^[a-zA-Z\s]+$/ );
		
	}, "Please input characters only." );
	

	$( "#update-step-one" ).validate( {
	
		errorElement : 'span',
		
		errorClass : 'help-block',
		
		errorPlacement : function( error, element ) {
		
			if( element.parent( '.input-group' ).length ) {
			
				error.insertAfter( element.parent() );
				
			} else {
			
				error.insertAfter( element );
				
			}
			
		},
		
		rules : {
		
			first_name:{
				
				required:true,
				
				alpha:true
				
			},
			
			last_name:{
				
				required:true,
				
				alpha:true
				
			},
			
			company_name:{
				
				required:true 
				
			},
			
			company_position:{
				
				required:true,
				
				alpha:true
				
			},
			
			company_phone:{
				
				required:true,
				
				digits:true
				
			},
			
			mobile_phone:{
				
				required:true
				
			},
			
			email_address:{
				
				required:true,
				
				email:true
				
			},
			
			alt_email:{
				
				notEqualAltEmail:"#email_address_text",
				
				email:true
				
			}
			
		},
		
		highlight : function( element ) {
		
			$( element ).closest( '.form-group' ).addClass( 'has-error' );
			
		},
		
		unhighlight : function( element ) {
		
			$( element ).closest( '.form-group' ).removeClass( 'has-error' );
			
		},
		
		submitHandler : function( form ) {
			
			var answer = confirm( 'Do you want to update client details?' );
			
			if( answer ) {
				
				_show_loader_targeted( 'body' );
		
				var data = $( form ).serializeArray();
				
				data.push({ name : 'job_role_id',  value : $( '#job_role_id' ).val() });
				
				$.post( "/portal/custom_get_started/update_step_one.php", data, function( response ) {
				
					if ( response.success ) {
					
						//RESET FORM
						$( '#update-step-one' ).validate().resetForm();
						
						$( '#update-step-one .form-group' ).removeClass( 'has-error' );

						_hide_loader_targeted( 'body' );
						
						alert( 'Client details has been updated!' );
						
					}
					
				}, 'json' );
			
			}
			
		 }
		 
	} );
	
	*/
	
	_show_loader_targeted( 'body' );

	var data = $( '#update-step-one' ).serializeArray();
	
	data.push({ name : 'job_role_id',  value : $( '#job_role_id' ).val() });
	
	$.post( "/portal/custom_get_started/update_step_one.php", data, function( response ) {
	
		if ( response.success ) {
		
			//RESET FORM
			//$( '#update-step-one' ).validate().resetForm();
			
			//$( '#update-step-one .form-group' ).removeClass( 'has-error' );

			//_hide_loader_targeted( 'body' );
			
			//alert( 'Client details has been updated!' );
			
		} else {
		
			alert('Please fill up required fields!');
			
		}
		
		_hide_loader_targeted( 'body' );
		
	}, 'json' );
	
}

//UPDATE STEP TWO FUNCTION
function _update_step_two( thisObj ) {
	
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
		
		//var answer = confirm( 'Do you want to update job ' + role + '?' ); 
		
		//if( answer ) { 
			
			_show_loader_targeted( 'body' );
	
			var data = $( '#job_role_selection_form' ).serializeArray();
			
			$.post( "/portal/custom_get_started/update_step_two.php", data, function( response ) {

				if ( response.success ) {
					
					_update_job_roles();
					
					_update_job_orders();

					//alert( 'Job roles has been updated!' );
					
				} else {
					
					alert('Please fill up required fields!');
					
				}
				
				_hide_loader_targeted( 'body' );
				
			}, 'json' );
		
		//}
		
	}

}

//UPDATE STEP THREE FUNCTION
function _update_step_three( thisObj ) { 

	var job_order_id = 0;
	
	var error_message = '';
	
	var field_filled = true;
	
	var field_type = 'working_timezone';
	
	var active_element = thisObj;
	
	var job_position_number = 1;

	//VALIDATE WORKING TIMEZONE
	$( '.working_timezone' ).each( function() {

		if( $( this ).chosen().val() == '' ) {
			
			job_order_id = $( this ).data( 'gs_job_titles_details_id' );
			
			error_message = 'Please fill up working timezone in job position ' + job_position_number + '!';
			
			field_filled = false;
			
			field_type = 'working timezone';

			active_element = $( this );
			
			return false;
			
		}
		
		job_position_number++;

	} );

	//NO ERROR OCCURED
	if( field_filled ) {
		
		job_position_number = 1;
		
		//VALIDATE SHIFT TIME START
		$( '.shift_time_start' ).each( function() {

			if( $( this ).chosen().val() == '' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				error_message = 'Please fill up shift time start in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'shift time start';

				active_element = $( this );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
	
	}
	
	//NO ERROR OCCURED
	if( field_filled ) {
		
		job_position_number = 1;
		
		//VALIDATE SHIFT END START
		$( '.shift_time_end' ).each( function() {

			if( $( this ).chosen().val() == '' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				error_message = 'Please fill up shift time end in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'shift time end';

				active_element = $( this );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
	
	}

	//NO ERROR OCCURED
	if( field_filled ) {
		
		job_position_number = 1;
		
		//VALIDATE START DATE
		$( '.start_date' ).each( function() {
			
			if( $( this ).val() == '' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				error_message = 'Please fill up start date in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'start date';

				active_element = $( this );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
	
	}

	//NO ERROR OCCURED
	if( field_filled ) {
		
		job_position_number = 1;
		
		//VALIDATE STAFF REPORT DIRECTLY
		$( '.staff_report_directly:checked' ).each( function() {
			
			if( $( this ).val() == 'No' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				/* 
				 * 
				 * VALIDATE MANAGER INFORMATION
				 * 
				 */
				
				/* FIRSTNAME */
				if( $( '#manager_first_name_' + job_order_id ).val() == '' ) {
					
					error_message = 'Please fill up manager firstname in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager firstname';

					active_element = $( '#manager_first_name_' + job_order_id );
					
					return false;
				
				/* LASTNAME */
				} else if( $( '#manager_last_name_' + job_order_id ).val() == '' ) {
					
					error_message = 'Please fill up manager lastname in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager lastname';

					active_element = $( '#manager_last_name_' + job_order_id );
					
					return false;
				
				/* EMAIL ADDRESS */
				} else if( $( '#manager_email_' + job_order_id ).val() == '' ) {
					
					error_message = 'Please fill up manager email address in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager email address';

					active_element = $( '#manager_email_' + job_order_id );
					
					return false;
				
				/* VALIDATE EMAIL ADDRESS */
				} else if( ! validateEmail( $( '#manager_email_' + job_order_id ).val() ) ) {
					
					error_message = 'Invalid email address in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager email address';

					active_element = $( '#manager_email_' + job_order_id );
					
					return false;
				
				/* MANAGER CONTACT NUMBER */	
				} else if( $( '#manager_contact_number_' + job_order_id ).val() == '' ) {
					
					error_message = 'Please fill up manager contact number in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager contact number';

					active_element = $( '#manager_contact_number_' + job_order_id );
					
					return false;
					
				}
				
			}
			
			job_position_number++;
			
		} );

	}
	
	//NO ERROR OCCURED
	if( field_filled ) {
		
		var skill_container = '';

		job_position_number = 1;
		
		$( '.skill_container' ).each( function() {
			
			var skill_container_id = $( this ).attr( 'id' ).split( '-' );

			skill_container = $( this ).html().replace(/\s/g,"");
			
			job_order_id = skill_container_id[ 3 ];
			
			if( skill_container == '' ) {
				
				error_message = 'Please select skill in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'skill';

				active_element = $( '#launch_skill_btn_' + job_order_id );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
		
	}
		
	//NO ERROR OCCURED
	if( field_filled ) {
		
		var task_container = '';
		
		job_position_number = 1;
		
		$( '.task_container' ).each( function() {
			
			var task_container_id = $( this ).attr( 'id' ).split( '-' );
			
			job_order_id = task_container_id[ 3 ];
			
			task_container = $( this ).html().replace(/\s/g,"");
			
			if( task_container == '' ) {
				
				error_message = 'Please select task in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'task';

				active_element = $( '#launch_task_btn_' + job_order_id );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
		
	}
	
	//CHECK IF FIELD FILED CORRECTLY
	if( ! field_filled ) {
		
		//alert( error_message );
		
		alert('Please fill up required fields!');
		
		$( '#tabber-job-order a[href="#job-order-'+job_order_id+'"]' ).tab( 'show' );
		
		if( ! active_element.is( ":focus" ) ) {
		
			active_element.focus();
			
			//FILTER CONDITION IF CHOSEN OR NOT
			if( field_type != 'start date' && field_type != 'manager firstname' && field_type != 'manager lastname' && field_type != 'manager email address' && field_type != 'manager contact number' && field_type != 'skill' && field_type != 'task' ) {
				 
				active_element.trigger( 'chosen:open' );
			
			/* FILTER CONDITION BUTTON */
			} else if( field_type == 'skill' || field_type == 'task' ) {
				
				active_element.click();
				
			} 
		
		}
		
	} else {
		
		var total_job_order = $( 'ul#tabber-job-order li' ).length;
		
		var job_order = ( total_job_order > 1 ? 'orders' : 'order' );
		
		//var answer = confirm( 'Do you want to update job ' + job_order + ' details?' );
		
		//if( answer ) {

			_show_loader_targeted( 'body' );

			var data = $( '#job_order_form' ).serializeArray();
			
			data.push({ name : 'job_role_id',  value : $( '#job_role_id' ).val() });
			
			$.post( "/portal/custom_get_started/update_step_three.php", data, function( response ) {

				if ( response.success ) {
					
					//alert( 'Job order details has been updated!' );
					
					/*
					var answer_next_step = confirm( 'Do you want to proceed to the next step?' );
					
					if( answer_next_step ) {
						
						window.location.href = '/portal/custom_get_started/optional_step4.php';
						
					}
					*/

				} else {
					
					alert('Please fill up required fields!');
					
				}
				
				_hide_loader_targeted( 'body' );

			}, 'json' );
		
		//}
		
	}

}

//OPTIONAL STEP 4
function _optional_step_4( thisObj ) {
	
	var total_job_role = $( '.category-select' ).length;
	
	var total_job_order = $( '#tabber-job-order li' ).length;
	
	if( total_job_role == total_job_order ) {
	
		var job_order_id = 0;
		
		var error_message = '';
		
		var field_filled = true;
		
		var field_type = 'working_timezone';
		
		var active_element = thisObj;
		
		var job_position_number = 1;

		//VALIDATE WORKING TIMEZONE
		$( '.working_timezone' ).each( function() {

			if( $( this ).chosen().val() == '' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				error_message = 'Please fill up working timezone in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'working timezone';

				active_element = $( this );
				
				return false;
				
			}
			
			job_position_number++;

		} );

		//NO ERROR OCCURED
		if( field_filled ) {
			
			job_position_number = 1;
			
			//VALIDATE SHIFT TIME START
			$( '.shift_time_start' ).each( function() {

				if( $( this ).chosen().val() == '' ) {
					
					job_order_id = $( this ).data( 'gs_job_titles_details_id' );
					
					error_message = 'Please fill up shift time start in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'shift time start';

					active_element = $( this );
					
					return false;
					
				}
				
				job_position_number++;
				
			} );
		
		}
		
		//NO ERROR OCCURED
		if( field_filled ) {
			
			job_position_number = 1;
			
			//VALIDATE SHIFT END START
			$( '.shift_time_end' ).each( function() {

				if( $( this ).chosen().val() == '' ) {
					
					job_order_id = $( this ).data( 'gs_job_titles_details_id' );
					
					error_message = 'Please fill up shift time end in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'shift time end';

					active_element = $( this );
					
					return false;
					
				}
				
				job_position_number++;
				
			} );
		
		}

		//NO ERROR OCCURED
		if( field_filled ) {
			
			job_position_number = 1;
			
			//VALIDATE START DATE
			$( '.start_date' ).each( function() {
				
				if( $( this ).val() == '' ) {
					
					job_order_id = $( this ).data( 'gs_job_titles_details_id' );
					
					error_message = 'Please fill up start date in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'start date';

					active_element = $( this );
					
					return false;
					
				}
				
				job_position_number++;
				
			} );
		
		}

		//NO ERROR OCCURED
		if( field_filled ) {
			
			job_position_number = 1;
			
			//VALIDATE STAFF REPORT DIRECTLY
			$( '.staff_report_directly:checked' ).each( function() {
				
				if( $( this ).val() == 'No' ) {
					
					job_order_id = $( this ).data( 'gs_job_titles_details_id' );
					
					/* 
					 * 
					 * VALIDATE MANAGER INFORMATION
					 * 
					 */
					
					/* FIRSTNAME */
					if( $( '#manager_first_name_' + job_order_id ).val() == '' ) {
						
						error_message = 'Please fill up manager firstname in job position ' + job_position_number + '!';
						
						field_filled = false;
						
						field_type = 'manager firstname';

						active_element = $( '#manager_first_name_' + job_order_id );
						
						return false;
					
					/* LASTNAME */
					} else if( $( '#manager_last_name_' + job_order_id ).val() == '' ) {
						
						error_message = 'Please fill up manager lastname in job position ' + job_position_number + '!';
						
						field_filled = false;
						
						field_type = 'manager lastname';

						active_element = $( '#manager_last_name_' + job_order_id );
						
						return false;
					
					/* EMAIL ADDRESS */
					} else if( $( '#manager_email_' + job_order_id ).val() == '' ) {
						
						error_message = 'Please fill up manager email address in job position ' + job_position_number + '!';
						
						field_filled = false;
						
						field_type = 'manager email address';

						active_element = $( '#manager_email_' + job_order_id );
						
						return false;
					
					/* VALIDATE EMAIL ADDRESS */
					} else if( ! validateEmail( $( '#manager_email_' + job_order_id ).val() ) ) {
						
						error_message = 'Invalid email address in job position ' + job_position_number + '!';
						
						field_filled = false;
						
						field_type = 'manager email address';

						active_element = $( '#manager_email_' + job_order_id );
						
						return false;
					
					/* MANAGER CONTACT NUMBER */	
					} else if( $( '#manager_contact_number_' + job_order_id ).val() == '' ) {
						
						error_message = 'Please fill up manager contact number in job position ' + job_position_number + '!';
						
						field_filled = false;
						
						field_type = 'manager contact number';

						active_element = $( '#manager_contact_number_' + job_order_id );
						
						return false;
						
					}
					
				}
				
				job_position_number++;
				
			} );

		}
		
		//NO ERROR OCCURED
		if( field_filled ) {
			
			var skill_container = '';

			job_position_number = 1;
			
			$( '.skill_container' ).each( function() {
				
				var skill_container_id = $( this ).attr( 'id' ).split( '-' );

				skill_container = $( this ).html().replace(/\s/g,"");
				
				job_order_id = skill_container_id[ 3 ];
				
				if( skill_container == '' ) {
					
					error_message = 'Please select skill in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'skill';

					active_element = $( '#launch_skill_btn_' + job_order_id );
					
					return false;
					
				}
				
				job_position_number++;
				
			} );
			
		}
			
		//NO ERROR OCCURED
		if( field_filled ) {
			
			var task_container = '';
			
			job_position_number = 1;
			
			$( '.task_container' ).each( function() {
				
				var task_container_id = $( this ).attr( 'id' ).split( '-' );
				
				job_order_id = task_container_id[ 3 ];
				
				task_container = $( this ).html().replace(/\s/g,"");
				
				if( task_container == '' ) {
					
					error_message = 'Please select task in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'task';

					active_element = $( '#launch_task_btn_' + job_order_id );
					
					return false;
					
				}
				
				job_position_number++;
				
			} );
			
		}
		
		//CHECK IF FIELD FILED CORRECTLY
		if( ! field_filled ) {
			
			//alert( error_message );
			
			alert('Please fill up required fields!');
			
			$( '#tabber-job-order a[href="#job-order-'+job_order_id+'"]' ).tab( 'show' );
			
			if( ! active_element.is( ":focus" ) ) {
			
				active_element.focus();
				
				//FILTER CONDITION IF CHOSEN OR NOT
				if( field_type != 'start date' && field_type != 'manager firstname' && field_type != 'manager lastname' && field_type != 'manager email address' && field_type != 'manager contact number' && field_type != 'skill' && field_type != 'task' ) {
					 
					active_element.trigger( 'chosen:open' );
				
				/* FILTER CONDITION BUTTON */
				} else if( field_type == 'skill' || field_type == 'task' ) {
					
					active_element.click();
					
				} 
			
			}
			
		} else {
			
			var total_job_order = $( 'ul#tabber-job-order li' ).length;
			
			var job_order = ( total_job_order > 1 ? 'orders' : 'order' );
			
			//var answer = confirm( 'Do you want to update job ' + job_order + ' details?' );
			
			//if( answer ) {

				_show_loader_targeted( 'body' );

				var data = $( '#job_order_form' ).serializeArray();
				
				data.push({ name : 'job_role_id',  value : $( '#job_role_id' ).val() });
				
				$.post( "/portal/custom_get_started/update_step_three.php", data, function( response ) {

					if ( response.success ) {
						
						//alert( 'Job order details has been updated!' );
						
						window.location.href = '/portal/custom_get_started/congrats.php';

					} else {
						
						alert('Please fill up required fields!');
						
					}
					
					_hide_loader_targeted( 'body' );

				}, 'json' );
			
			//}
			
		}
	
	} else {
		
		//alert( 'Please update step 2!' );
		
		//$( '#update_step_two_btn' ).focus();
		
		alert('Please fill up required fields!');
		
		$( '#update_step_two_btn' ).click();
		
	}
	
}

//GET STATE FUNCTION
function _get_state( thisObj ) {
	
	//GET COUNTRY ID
	var country_id = thisObj.chosen().val();
	
	//CHECK COUNTRY ID
	if( country_id == '' ) {
		
		//SET STATE AND CITY TO EMPTY
		$( '#leads_state' ).html( '<option value=""></option>' ).trigger( "chosen:updated" );
		
		$( '#leads_city' ).html( '<option value=""></option>' ).trigger( "chosen:updated" );
		
		
	} else {
	
		//GET ALL STATE
		$.post( '/portal/custom_get_started/get_state.php', { country_id : country_id }, function( response ) {
			
			if( response.success ) {
				
				var states = '<option value=""></option>';
				
				$.each( response.result, function( id, country_state ) {
					
					states += '<option value="' + id + '">' + country_state + '</option>';
					
				} );
				
				$( '#leads_state' ).html( states ).trigger( "chosen:updated" );
				
				$( '#leads_city' ).html( '<option value=""></option>' ).trigger( "chosen:updated" );
				
			} else {
				
				var error_message = "The following failed to save because of the following error: \n\n";
				
				$.each( response.error_message, function( i, item ) {
					
					error_message += item + "\n";
					
				} );
				
				alert( error_message ); 
				
			}
			
		}, 'json' );
	
	}
	
}

//GET CITY FUNCTION
function _get_city( thisObj ) {
	
	var state_id = thisObj.chosen().val();
	
	$.post( '/portal/custom_get_started/get_city.php', { state_id : state_id },function( response ) {
		
		if( response.success ) {
			
			var cities = '<option value=""></option>';
			
			$.each( response.result, function( id, state_city ) {
				
				cities += '<option value="' + id + '">' + state_city + '</option>';
				
			} );
			
			$( '#leads_city' ).html( cities ).trigger( "chosen:updated" );
			
		} else {
			
			var error_message = "The following failed to save because of the following error: \n\n";
			
			$.each( response.error_message, function( i, item ) {
				
				error_message += item + "\n";
				
			} );
			
			alert( error_message );
			
		}
		
	}, 'json' );
	
}

//GET INPUT FUNCTION
function _get_input() {
	
	var categories = [];
	
	var subcategories = []; 

	var levels = [];
	
	var work_statuses = [];
	
	var no_of_staffs = [];
	
	var data = {};
	
	data.job_orders = [];
	
	$( ".category-select" ).each( function() {
		
		categories.push( $( this ).val() );
		
	} );
	
	$( ".sub-category-select" ).each( function() {
		
		subcategories.push( $( this ).val() );
		
	} );

	$(".level-select").each( function() {
		
		levels.push( $( this ).val() );
		
	} );
	
	$( ".work-status-select" ).each( function() {
		
		work_statuses.push( $( this ).val() );
		
	} );
	
	$( ".no_of_staff" ).each( function() {
		
		var val = $( this ).val();
		
		if ( $.trim( val ) == "" || isNaN( val ) ) {
			
			no_of_staffs.push( 1 );
			
		} else {
			
			no_of_staffs.push( val );
			
		}
		
	} );
	
	$.each( categories, function( i, category ) {
		
		if ( levels[ i ] != "" && no_of_staffs[ i ] != "" && subcategories[ i ] != "" && categories[ i ] != "" && work_statuses[ i ] != "" ) {
			
			data.job_orders.push( { level : levels[ i ], no_of_staff : no_of_staffs[ i ], subcategory : subcategories[ i ], category : categories[ i ], work_status : work_statuses[ i ] } );		
		
		}
		
	} );
	
	data.currency = $( ".currency-select" ).val();
	
	return data;
	
}

//CATEGORY SELECT FUNCTION
function _category_select( thisObj ) {

	var category_id = thisObj.val();
	
	$.get( "/portal/custom_get_started/get_sub_categories.php", { category_id : category_id } , function( response ) {
		
		if ( response.success ) {
			
			var option = '<option value=""></option>';
			
			if ( response.subcategories.length > 0 ) {
				
				$.each( response.subcategories, function( i, item ) {
					
					option += '<option value="' + item.sub_category_id + '">' + item.sub_category_name + "</option>";
					
				} );
				
			}
			
			thisObj.closest( '.row' ).find( 'select.sub-category-select' ).html( option ).val( "" ).trigger( "chosen:updated" );
			
			_update_pricing_table();
			
		}
		
	}, 'json' );

}

//SHIFT TIME START SELECT FUNCTION
function _shift_time_start_select( thisObj ) {
	
		var job_order_id = thisObj.data( 'gs_job_titles_details_id' );
	
		var shift_start = thisObj.val().split( ':' );
		
		var shift_start_hour = parseInt( shift_start[ 0 ] );
		
		var shift_start_minute = shift_start[ 1 ];
		
		var shift_end_hour = 0;
		
		var status = $( '#work_status_' + job_order_id ).val();

		if ( status == 'Full-Time' ) {
			
			shift_end_hour = shift_start_hour + 9;
			
		} else {
			
			shift_end_hour = shift_start_hour + 4;
			
		}
		
		if ( shift_end_hour > 23 ) {
			
			shift_end_hour = shift_end_hour - 24;
		
		}
		
		if ( shift_end_hour < 10 ) {
			
			shift_end_hour = "0"+shift_end_hour;
			
		}
		
		if( shift_start == '' ) { 
			
			var current_shift_time = '';
			
		} else {
			
			var current_shift_time = shift_end_hour + ":" + shift_start_minute;
			
		}

		//TRIGGER SHIFT TIME END
		$( '#shift_time_end_' + job_order_id ).val( current_shift_time ).trigger( 'chosen:updated' );
	
}

//ADD ROW FUNCTION
function _add_row() {
	
	var raw_template = $( "#category_row" ).html(); 
	
	var template = Handlebars.compile( raw_template );
	
	var context = {};
	
	var html = template( context );
	
	$( "#job_role_list" ).append( html ).children( ':last' ).hide().fadeIn( 'normal' ).show();
	
	initChosen();

	_update_pricing_table();

}

//ADD RESPONSIBILITY ROW FUNCTION
function _add_responsibility( thisObj ) {
	
	var job_order_id = thisObj.data( 'gs_job_titles_details_id' );
	
	var raw_template = $( '#responsibility-row' ).html();
	
	var template = Handlebars.compile( raw_template );
	
	var context = { job_order_id : job_order_id };
	
	var html = template( context );

	$( thisObj.parent().parent().find( '.responsibilities-div' ) ).append( html ).children( ':last' ).hide().fadeIn( 'normal' ).show();
	
}

//ADD OTHER SKILLS ROW FUNCTION
function _add_other_skill( thisObj ) {
	
	var job_order_id = thisObj.data( 'gs_job_titles_details_id' );
	 
	var raw_template = $( "#other-skills-row" ).html();
	
	var template = Handlebars.compile( raw_template );
	
	var context = { job_order_id : job_order_id };
	
	var html = template( context );

	$( thisObj.parent().parent().find( '.other-skills-div' ) ).append( html ).children( ':last' ).hide().fadeIn( 'normal' ).show();
	
}

//REMOVE ROW FUNCTION
function _remove_row( thisObj ) { 
	
	thisObj.closest( '.row' ).fadeOut( "normal", function() { 
		
		thisObj.closest( '.row' ).remove();
		
		_update_pricing_table();
		
	} );
	
}

//REMOVE CREDENTIAL ROW FUNCTION
function _delete_credential( thisObj ) {
	
	thisObj.closest( '.row' ).fadeOut( "normal", function() { 
		
		thisObj.closest( '.row' ).remove();
		
	} );
	
}

//SELECT STAFF REPORT DIRECTLY FUNCTION
function _staff_report_directly( thisObj ) {
	
	var value = thisObj.val();
	
	var job_order_id = thisObj.data( 'gs_job_titles_details_id' );
	
	if( value == 'Yes' ) {
		
		$( '#manager_first_name_' + job_order_id ).attr( 'disabled', 'disabled' );
		
		$( '#manager_last_name_' + job_order_id ).attr( 'disabled', 'disabled' );
		
		$( '#manager_email_' + job_order_id ).attr( 'disabled', 'disabled' );
		
		$( '#manager_contact_number_' + job_order_id ).attr( 'disabled', 'disabled' );
		
	} else {
		
		$( '#manager_first_name_' + job_order_id ).removeAttr( 'disabled' );
		
		$( '#manager_last_name_' + job_order_id ).removeAttr( 'disabled' );
		
		$( '#manager_email_' + job_order_id ).removeAttr( 'disabled' );
		
		$( '#manager_contact_number_' + job_order_id ).removeAttr( 'disabled' );
		
	}
	
}

//LAUNCH SKILL FUNCTION
function _launch_skill( thisObj ) {
	
	var job_order_id = thisObj.data( 'gs_job_titles_details_id' );

	var sub_category_id = thisObj.attr( 'data-sub_category_id' );
	
	$( '#required_skill_sub_category_id' ).val( sub_category_id );
	
	$( '#select-skill' ).attr( 'data-gs_job_titles_details_id', job_order_id );
	
	loadTaskList( sub_category_id, thisObj );
	
	$( '#addSkillListModal' ).modal( { backdrop : 'static',keyboard : true } );
	
}

//LAUNCH TASK FUNCTION
function _launch_task( thisObj ) {
	
	var job_order_id = thisObj.data( 'gs_job_titles_details_id' );

	var sub_category_id = thisObj.attr( 'data-sub_category_id' );
	
	$( '#required_task_sub_category_id' ).val( sub_category_id );
	
	$( '#select-tasks' ).attr( 'data-gs_job_titles_details_id', job_order_id );
	
	loadTaskList( sub_category_id, thisObj );
	
	$( '#addTaskListModal' ).modal( { backdrop : 'static', keyboard : true } );
	
}

//ADD NEW SKILL FUNCTION
function _add_new_skill( thisObj ) {
	if($('#updateNameSkill').val() != ''){
		var answer = confirm('Do you want to add this skill?');
		if(answer){
			var data = {
				type:jQuery("#updateTypeSkill").val(),
				sub_category_id:jQuery("#updateSubCategoryIdSkill").val(),
				value:jQuery("#updateNameSkill").val(),
				gs_job_titles_details_id:jQuery(".tab-pane.active").find('.job_order_id').val(),
				leads_id:jQuery("#leads_id").val()
			};
			jQuery.post("/portal/custom_get_started/add_skill_task.php", data, function(response){
				jQuery("#updateNameSkill").val("");
				response = jQuery.parseJSON(response);
				var output = "";
				var item = null;
				if (response.success){
					jQuery.each(response.required_skills, function(i, required_skill){
						if (required_skill.value == data.value){
							item = required_skill;
							return false;
						}
					});
					output+='<tr>';
					output+='<td class="text-center" style="vertical-align:middle; width:10%;"><input type="checkbox" checked="checked" name="skill-selected[]" class="skill-selected" id="optionsCheckbox'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
					output+='<td style="vertical-align:middle; width:60%;">'+item.value+'</td>';
					output+='<td style="vertical-align:middle; width:30%;"><select name="rating-skill-selected[]" class="form-control rating-skill-selected" data-id="'+item.id+'"><option value="">Select Proficiency</option><option value="1">Beginner (1 - 3 years)</option><option value="2">Intermediate (3 - 5 years)</option><option value="3">Advanced (More than 5 years)</option></select></td>';
					output+='</tr>';
					jQuery(output).appendTo(jQuery("#skill-select-form tbody")).hide().fadeIn(100);
					var skill = {
						'id':"optionsCheckbox"+item.id,
						'value':item.id
					}
					skill_selected.push(skill);
				}
			});
		}
	}else{
		alert('Please fill up new skill!');
		$('#updateNameSkill').focus();
	}
}

//ADD NEW TASK FUNCTION
function _add_new_task( thisObj ) {
	if($('#updateNameTask').val() != ''){
		var answer = confirm('Do you want to add this task?');
		if(answer){
			var data = {
				type:jQuery("#updateTypeTask").val(),
				sub_category_id:jQuery("#updateSubCategoryIdTask").val(),
				value:jQuery("#updateNameTask").val(),
				gs_job_titles_details_id:jQuery(".tab-pane.active").find('.job_order_id').val(),
				leads_id:jQuery("#leads_id").val()
			};
			jQuery.post("/portal/custom_get_started/add_skill_task.php", data, function(response){
				jQuery("#updateNameTask").val("");
				response = jQuery.parseJSON(response);
				var output = "";
				var item = null;
				if (response.success){
					jQuery.each(response.required_tasks, function(i, required_task){
						if (required_task.value == data.value){
							item = required_task;
							return false;
						}
					});
					output+='<tr>';
					output+='<td class="text-center" style="vertical-align:middle; width:10%;"><input checked="checked" type="checkbox" class="task-selected" name="task-selected[]" id="optionsCheckboxTask'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
					output+='<td style="vertical-align:middle; width:60%;">'+item.value+'</td>';
					output+='<td style="vertical-align:middle; width:30%;"><select name="rating-task-selected[]" class="form-control rating-task-selected" data-id="'+item.id+'">';
					output+="<option value=''>Select Rate of Importance</option>";
					for(var i=1;i<=10;i++){
						var label = "";
						if (i==1){
							label = i+" Low";
						}else if (i==10){
							label = i+" High";
						}else{
							label = i
						}
						output+='<option value="'+i+'">'+label+'</option>';
					}
					output+='</select></td></tr>';
					jQuery(output).appendTo(jQuery("#task-select-form tbody")).hide().fadeIn(100);
					var task = {
						'id':"optionsCheckboxTask"+item.id,
						'value':item.id
					}
					task_selected.push(task);
				}
			});
		}
	}else{
		alert('Please fill up new task!');
		$('#updateNameTask').focus();
	}
}

//UPDATE PRICING TABLE FUNCTION
function _update_pricing_table() {
	
	var data = _get_input();
	
	$.post( "/portal/custom_get_started/get_rates.php", data, function( response ) {

		var output = "";

		if ( response.length > 0 ) {

			var src = $( "#pricing_table_row" ).html();

			$.each( response, function( i, item ) {

				item.i = i + 1;

				var template = Handlebars.compile( src );

				output += template( item );

			} );

		}

		$( "#pricing_table tbody" ).html( output );

	}, 'json' );
	
}

//UPDATE JOB ROLES FUNCTION
function _update_job_roles() {
	
	$.post( '/portal/custom_get_started/get_updated_job_roles.php', function( response ) {
		
		$( '#job_role_list' ).html( response ).hide().fadeIn( 'normal' ).show();

		initChosen();

	} );
	
}

//UPDATE JOB ORDERS FUNCTION
function _update_job_orders() {
	
	$.post( '/portal/custom_get_started/get_updated_job_orders.php', function( response ) {
		
		$( '#job_order_list' ).html( response ).hide().fadeIn( 'normal' ).show();

		initAll();

	} );
	
}

//SHOW LOADER TARGETED
function _show_loader_targeted( targeted ) {
	
	$( targeted ).isLoading( {
		
		text : 'Updating',
		
		position: 'overlay',

		class: 'fa fa-spinner fa-pulse',
		
		tpl : '<span class="isloading-wrapper %wrapper%">%text%<i class="%class%"></i></span>'
	
	} );
	
}

//HIDE LOADER TARGETED
function _hide_loader_targeted( targeted ) {
	
	$( targeted ).isLoading( 'hide' );
	
}

//INITIALIZE ALL FUNCTION
function initAll() {
	
	initChosen();
	
	initDatePicker();
	
}

//INITIALIZE CHOSEN FUNCTION
function initChosen() {
	
	$( '.chosen' ).chosen( {
		
		width : "100%",
		
		no_results_text : "Oops, nothing found!",
		
		allow_single_deselect : true
		
	} );
	
	$( '.chosen-without-search' ).chosen( {
		
		width : "100%",
		
		no_results_text : "Oops, nothing found!",
		
		disable_search : true,
		
		allow_single_deselect : true
		
	} );
	
}

//INITIALIZE DATE PICKER
function initDatePicker() {
	
	$( '.datepicker' ).datepicker( {
	
		dateFormat: 'yy-mm-dd'
		
	} );
	
}



































 
//VALIDATE EMAIL
function validateEmail( email ) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

//LOAD TASK LIST
function loadTaskList( subcategory_id, thisObj ) {
	if (typeof subcategory_id == "undefined"){
		subcategory_id = 3;
	}
	jQuery.get("/portal/custom_get_started/get_task_job_position.php?sub_category_id="+subcategory_id, function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.result, function(i, item){
			output+='<tr>';
            output+='<td class="text-center" style="vertical-align:middle; width:10%;"><input type="checkbox" class="task-selected" name="task-selected[]" id="optionsCheckboxTask'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
            output+='<td style="vertical-align:middle; width:60%;">'+item.value+'</td>';
            output+='<td style="vertical-align:middle; width:30%;"><select name="rating-task-selected[]" class="form-control rating-task-selected" data-id="'+item.id+'">';
			output+="<option value=''>Select Rate of Importance</option>"
			for(var i=1;i<=10;i++){
				var label = "";
				if (i==1){
					label = i+" Low";
				}else if (i==10){
					label = i+" High";
				}else{
					label = i
				}
				output+='<option value="'+i+'">'+label+'</option>';
			}
			output+='</select></td></tr>';
		});
		jQuery("#task-select-form tbody").html(output);
		var j = 0;
		thisObj.parent().find(".selected-task").each(function(){
			var ratings_hidden = thisObj.parent().find(".selected-task-proficiency");
			jQuery("#optionsCheckboxTask"+jQuery(this).val()).parent().parent().find(".rating-task-selected").val(jQuery(ratings_hidden[j]).val());
			jQuery("#optionsCheckboxTask"+jQuery(this).val()).attr("checked", "checked");
			var task = {
				'id':"optionsCheckboxTask"+jQuery(this).val(),
				'value':jQuery(this).val()
			}
			var rating_task = {
				'id':jQuery(this).val(),
				'value':jQuery(ratings_hidden[j]).val()
			}
			task_selected.push(task);
			rating_task_selected.push(rating_task);
			//console.log(task);
			//console.log(rating_task);
			j++;
		});
		jQuery("#updateSubCategoryIdTask").val(subcategory_id);
		jQuery(".selected_job_title").html(response.sub_category.sub_category_name);
	});
	jQuery.get("/portal/custom_get_started/get_skill_job_position.php?sub_category_id="+subcategory_id, function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.result, function(i, item){
			output+='<tr>';
            output+='<td class="text-center" style="vertical-align:middle; width:10%;"><input type="checkbox" name="skill-selected[]" class="skill-selected" id="optionsCheckbox'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
            output+='<td style="vertical-align:middle; width:60%;">'+item.value+'</td>';
            output+='<td style="vertical-align:middle; width:30%;"><select name="rating-skill-selected[]" class="form-control rating-skill-selected" data-id="'+item.id+'"><option value="">Select Proficiency</option><option value="1">Beginner (1 - 3 years)</option><option value="2">Intermediate (3 - 5 years)</option><option value="3">Advanced (More than 5 years)</option></select></td>';
			output+='</tr>';
		});		
		jQuery("#skill-select-form tbody").html(output);
		var j = 0;
		thisObj.parent().find(".selected-skill").each(function(){
			var ratings_hidden = thisObj.parent().find(".selected-skill-proficiency");
			jQuery("#optionsCheckbox"+jQuery(this).val()).parent().parent().find(".rating-skill-selected").val(jQuery(ratings_hidden[j]).val());
			jQuery("#optionsCheckbox"+jQuery(this).val()).attr("checked", "checked");
			var skill = {
				'id':"optionsCheckbox"+jQuery(this).val(),
				'value':jQuery(this).val()
			}
			var rating_skill = {
				'id':jQuery(this).val(),
				'value':jQuery(ratings_hidden[j]).val()
			}
			skill_selected.push(skill);
			rating_skill_selected.push(rating_skill);
			//console.log(skill_selected);
			//console.log(rating_skill_selected);
			j++;
		});
		jQuery("#updateSubCategoryIdSkill").val(subcategory_id);
		jQuery(".selected_job_title").html(response.sub_category.sub_category_name);
	});
}

//SEARCH SKILL FUNCTION
function searchSkill( thisObj ) {
	var search_skill = $('#search_skill').val();
	var subcategory_id = $('#required_skill_sub_category_id').val();
	jQuery.get("/portal/custom_get_started/search_skill_job_position.php?sub_category_id="+subcategory_id+"&search_skill="+search_skill,function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.result, function(i, item){
			output+='<tr>';
            output+='<td class="text-center" style="vertical-align:middle; width:10%;"><input type="checkbox" name="skill-selected[]" class="skill-selected" id="optionsCheckbox'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
            output+='<td style="vertical-align:middle; width:60%;">'+item.value+'</td>';
            output+='<td style="vertical-align:middle; width:30%;"><select name="rating-skill-selected[]" class="form-control rating-skill-selected" data-id="'+item.id+'"><option value="">Select Proficiency</option><option value="1">Beginner (1 - 3 years)</option><option value="2">Intermediate (3 - 5 years)</option><option value="3">Advanced (More than 5 years)</option></select></td>';
			output+='</tr>';
		});
		jQuery("#skill-select-form tbody").html(output);
		jQuery("#updateSubCategoryIdSkill").val(subcategory_id);
		jQuery(".selected_job_title").html(response.sub_category.sub_category_name);
		//ALLOCATE STORED SKILL SELECTED ARRAY VALUE
		$.each(skill_selected,function(){
			$('#'+this.id).prop('checked', true);
		});
		//ALLOCATE STORED RATING SKILL SELECTED
		$.each(rating_skill_selected,function(){
			$('select[data-id='+this.id+']').val(this.value);
		});
	});
}

//SEARCH TASK FUNCTION
function searchTask( thisObj ) {
	var search_task = $('#search_task').val();
	var subcategory_id = $('#required_task_sub_category_id').val();
	jQuery.get("/portal/custom_get_started/search_task_job_position.php?sub_category_id="+subcategory_id+"&search_task="+search_task,function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.result, function(i, item){
			output+='<tr>';
			output+='<td class="text-center" style="vertical-align:middle; width:10%;">';
            output+='<input type="checkbox" class="task-selected" name="task-selected[]" id="optionsCheckboxTask'+item.id+'" value="'+item.id+'" data-label="'+item.value+'">';
            output+='<td style="vertical-align:middle; width:60%;">'+item.value+'</td>';
            output+='</td>';
            output+='<td style="vertical-align:middle; width:30%;">';
            output+='<select name="rating-task-selected[]" class="form-control rating-task-selected" data-id="'+item.id+'">';
			output+="<option value=''>Select Rate of Importance</option>"
			for(var i=1;i<=10;i++){
				var label = "";
				if (i==1){
					label = i+" Low";
				}else if (i==10){
					label = i+" High";
				}else{
					label = i
				}
				output+='<option value="'+i+'">'+label+'</option>';
			}
			output+='</select>';
			output+='</td>';
			output+='</tr>';
		});
		jQuery("#task-select-form tbody").html(output);
		//ALLOCATE STORED TASK SELECTED ARRAY VALUE
		$.each(task_selected,function(){
			$('#'+this.id).prop('checked', true);
		});
		//ALLOCATE STORED RATING TASK SELECTED
		$.each(rating_task_selected,function(){
			$('select[data-id='+this.id+']').val(this.value);
		});
	});
}

function taskChange(thisObj){
	
	var id = thisObj.data('id');
	var value = thisObj.val();
	for (var i =0; i < rating_task_selected.length; i++){
	   if (rating_task_selected[i].id === id) {
		  rating_task_selected.splice(i,1);
		  rating_task_selected = rating_task_selected.filter(function(n){ return n != undefined }); 
	   }
	}
	
	var rating_task = {
		'id':id,
		'value':value
	}
	
	var task = {
		'id':'optionsCheckboxTask'+id,
		'value':value
	}
	
	task_selected.push(task);
	rating_task_selected.push(rating_task);
	
	//CHECK THE VALUE OF SELECTED TEXTBOX
	if(value==''){
		$('#optionsCheckboxTask'+id).prop('checked', false);
	}else{
		$('#optionsCheckboxTask'+id).prop('checked', true);
	}
	
}

function skillChange(thisObj){
	
	var id = thisObj.data('id');
	var value = thisObj.val();
	for (var i =0; i < rating_skill_selected.length; i++){
	   if (rating_skill_selected[i].id === id) {
		  rating_skill_selected.splice(i,1);
		  rating_skill_selected = rating_skill_selected.filter(function(n){ return n != undefined }); 
	   }
	}
	
	var rating_skill = {
		'id':id,
		'value':value
	}
	
	var skill = {
		'id':'optionsCheckbox'+id,
		'value':value
	}
	
	skill_selected.push(skill);
	rating_skill_selected.push(rating_skill);
	
	//CHECK THE VALUE OF SELECTED TEXTBOX
	if(value==''){
		$('#optionsCheckbox'+id).prop('checked', false);
	}else{
		$('#optionsCheckbox'+id).prop('checked', true);
	}
	
}
