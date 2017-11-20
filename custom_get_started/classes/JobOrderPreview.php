<?php

require_once dirname(__FILE__). "/../../lib/Contact.php"; 

/*
* 
* 
* Class for Job Order Preview
* 
* 
* @copyright Remote Staff Inc.
* 
* @author Allan Joseph Pedernal
* 
* 
* @method public __construct()
* 
* @method public render()
* 
* 
* @method public process_leads_details()
* 
* @method public process_job_role_details()
* 
* @method public process_job_order_details()
* 
* 
* @method private _get_lead_details()
* 
* @method private _get_job_role_details()
* 
* @method private _get_job_order_details()
* 
* 
* ---GET JOB ORDER DETAILS ACTIONS---
* 
* 
* @method private _get_subcategory()
* 
* @method private _get_category()
* 
* @method private _get_staff_provide_training()
* 
* @method private _get_staff_make_calls()
* 
* @method private _get_staff_first_time()
* 
* @method private _get_staff_report_directly()
* 
* @method private _get_special_instruction()
* 
* @method private _get_skills()
* 
* @method private _get_tasks()
* 
* @method private _get_responsibilities()
* 
* @method private _get_other_skills()
* 
*/

final class JobOrderPreview {

	/*
	* 
	* Class Global Variable
	* 
	* @param $db => database instance
	* 
	* @param $smarty => smarty template instance
	* 
	* @param $contact => rs contact number instance
	* 
	*/
	private $db;

	private $smarty;

	private $contact;

	private $database;
	
	/*
	* 
	* Construct Job Order Preview Class
	* 
	* @param $db => database instance
	* 
	*/
	public function __construct( $db ) {
	
		//PASS INSTANCE INSIDE CLASS
		$this -> db = $db;
		
		//GET MONGODB INSTANCE
		$retries = 0;
		while(true){
			try{
				if ( TEST ) {
			
					$mongo = new MongoClient( MONGODB_TEST );
				
				} else {
					
					$mongo = new MongoClient( MONGODB_SERVER );
				
				}
				
				$this -> database = $mongo -> selectDB( 'prod' );
				
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
		
		$this -> smarty = new Smarty();
		
		$this -> contact = new Contact();
		
        
        //ASSIGN VARIABLE
        $this -> smarty -> assign( 'contact_numbers', $this -> contact -> rs_contact_numbers( $db ) );
        
        $this -> smarty -> assign( 'script','job_order_preview.js' );
	
	}
	
	/*
	* 
	* Render Job Order Preview Display
	* 
	*/
	public function render() {



		//GET INSTANCE
		$smarty = $this -> smarty;



		//CHECK IF STEP 3 IS ALREADY FINISHED
		if( ! isset( $_SESSION[ 'step' ] ) ) {
			
			header( 'Location:/portal/custom_get_started/step3.php' );
			
			die;
			
		}



		/* JOB ORDER PREVIEW CORE DATA */
		$leads_details = $this -> _get_lead_details();
		
		$job_role_details = $this -> _get_job_role_details( $leads_details[ 'leads_id' ] );
		
		$job_order_details = $this -> _get_job_order_details( $job_role_details[ 'details' ][ 'gs_job_role_selection_id' ] );



		$smarty -> assign( 'leads_details', $leads_details );  
		
		$smarty -> assign( 'job_role_details', $job_role_details );
		
		$smarty -> assign( 'job_order_details', $job_order_details );



		/* STEP 1 PREREQUISITE */
		$countries = $this -> _get_countries();
		
		$smarty -> assign( 'countries', $countries );




		/* STEP 2 PREREQUISITE */
		$categories = $this -> _get_categories();

		$smarty -> assign( 'categories', $categories );




		/* STEP 3 PREREQUISITE */
		$timezones = $this -> _get_all_timezone();
		
		$shift_times = $this -> _get_all_shift_time();
		
		$working_status = $this -> _get_all_working_status();
		
		$smarty -> assign( 'timezones', $timezones );
		
		$smarty -> assign( 'shift_times', $shift_times );
		
		$smarty -> assign( 'working_status', $working_status );




		/* ADMIN IS LOGGED IN */
		if( isset( $_SESSION[ 'admin_id' ] ) ) {
			
			$smarty -> assign( 'admin_user', true );
			
		}




		$smarty -> assign( 'edit_step_1' , true );
		
		/* CHECK WHO IS ACCESSING THE PAGE */
		if( ( isset( $_SESSION[ 'from' ] ) && $_SESSION[ 'from' ] == "portal" ) || ( isset( $_SESSION[ 'from' ] ) && $_SESSION[ 'from' ] == 'recruitment_sheet' ) || ( isset( $_SESSION[ 'from' ] ) && $_SESSION[ 'from' ] == 'email' ) ) {

			$smarty -> assign( 'edit_step_1' , false );
				
		}

		
		$smarty -> assign( 'add_position', true );

		/* CHECK IF SESSION "FROM" IS ALIVE AND EQUAL TO RECRUITEMENT SHEET */
		if( isset( $_SESSION[ 'from' ] ) && $_SESSION[ 'from' ] == 'recruitment_sheet' ) {
			
			$smarty -> assign( 'add_position', false );
			
		}
		



		//SMARTY TEMPLATE CLEAR CACHE
		$smarty -> clear_cache( 'job_order_preview.tpl' ); 
		
		//SMARTY TEMPLATE
		$smarty -> display( 'job_order_preview.tpl' );




	}
	
	/*
	* 
	* Process Leads Details
	* 
	*/
	public function process_leads_details() {
	
		//GET INSTANCES
		$db = $this -> db;
		
		$database = $this -> database;
		
		$job_specification_preview = $database -> selectCollection( 'job_specification_preview' );
		
		
		if( isset( $_POST ) ) {
			
			
			
			$success = true;
			
			$result = array();
			
			$error_message = array();
			
			

			$leads_id = $_POST[ 'leads_id' ];
			
			$job_role_id = $_POST[ 'job_role_id' ];
			
			
			
			UNSET( $_POST[ 'leads_id' ] ); //NOT NEEDED ANYMORE
			
			UNSET( $_POST[ 'job_role_id' ] ); //NOT NEEDED ANYMORE
			
			
			//lEADS DETAILS
			$leads_data = array(
				
				'fname' => $_POST[ 'first_name' ],
				
				'lname' => $_POST[ 'last_name' ],
				
				'mobile' => $_POST[ 'mobile_phone' ],
				
				'email' => $_POST[ 'email_address' ],
				
				'sec_email' => $_POST[ 'alt_email' ],

				'officenumber' => $_POST[ 'company_phone' ],
				
				'outsourcing_experience' => $_POST[ 'tried_staffing' ],
				
				'company_name' => $_POST[ 'company_name' ],
				
				'company_position' => $_POST[ 'company_position' ],
				
				'company_address' => $_POST[ 'leads_address' ],
				
				'company_size' => $_POST[ 'existing_team_size' ],
				
				'company_description' => $_POST[ 'company_description' ]

			);
			
			
			//CHECK IF COUNTRY IS ISSET
			if( isset( $_POST[ 'leads_country' ] ) && ! empty( $_POST[ 'leads_country' ] ) ) {
				
				$leads_country_sql = $db -> select() 
				
										 -> from( 'library_country', 'name' )
									 
										 -> where( 'id = ?', $_POST[ 'leads_country' ] );
										 
				$leads_country = $db -> fetchOne( $leads_country_sql );
										 
				$leads_data[ 'leads_country' ] = $leads_country;
				
			}
			
			//CHECK IF STATE IS ISSET
			if( isset( $_POST[ 'leads_state' ] ) && ! empty( $_POST[ 'leads_state' ] ) ) {
				
				$leads_state_sql = $db -> select() 
				
										 -> from( 'library_state', 'name' )
									 
										 -> where( 'id = ?', $_POST[ 'leads_state' ] );
										 
				$leads_state = $db -> fetchOne( $leads_state_sql );
										 
				$leads_data[ 'state' ] = $leads_state;
				
			}

			//CHECK IF CITY IS ISSET
			if( isset( $_POST[ 'leads_city' ] ) && ! empty( $_POST[ 'leads_city' ] ) ) {
				
				$leads_city_sql = $db -> select() 
				
										 -> from( 'library_city', 'name' )
									 
										 -> where( 'id = ?', $_POST[ 'leads_city' ] );
										 
				$leads_city = $db -> fetchOne( $leads_city_sql );
										 
				$leads_data[ 'city' ] = $leads_city;
				
			}
			
			//lEADS ADDRESS DETAILS
			$leads_address_data = array(
			
				'leads_address' => $_POST[ 'leads_address' ], 
				
				'leads_country' => $_POST[ 'leads_country' ],
				
				'leads_state' => $_POST[ 'leads_state' ],
				
				'leads_city' => $_POST[ 'leads_city' ],
				
				'leads_zip_code' => $_POST[ 'leads_zip_code' ] 
				
			);
			
			//CHECK IF LEADS ALREADY REGISTER TO OUR WEBSITE
			if( isset( $_SESSION[ 'leads_new_info_id' ] ) ) {
				
				//REMOVE STATE
				if( isset( $leads_data[ 'state' ] ) ) {
					
					unset ($leads_data[ 'state' ] );
					
				}
				
				//REMOVE CITY
				if( isset( $leads_data[ 'city' ] ) ) {
					
					unset( $leads_data[ 'city' ] );
					
				}
				
				//UPDATE LEADS NEW INFO DETAILS
				$db -> update( 'leads_new_info', $leads_data, $db -> quoteInto( 'leads_id = ?', $leads_id ) );
				
			} else {
				
				//UPDATE LEADS DETAILS
				$db -> update( 'leads', $leads_data, $db -> quoteInto( 'id = ?', $leads_id ) );
			
			}
			
			//CHECK IF THERES ALREADY LEADS ADDRESS
			$leads_address_sql = $db -> select()
			
									 -> from( 'leads_address' )
									 
									 -> where( 'leads_id = ?', $leads_id );
									 
			$leads_address = $db -> fetchRow( $leads_address_sql );
			
			//CHECK IF LEADS ADDRESS ALREADY EXISTS
			if( $leads_address ) {
			
				//UPDATE LEADS ADDRESS
				$db -> update( 'leads_address', $leads_address_data, $db -> quoteInto( 'leads_id = ?', $leads_id ) );
			
			} else {
				
				//INSERT LEADS ADDRESS
				$db -> insert( 'leads_address', $leads_address_data );
				
			}
			
			//DELETE ALL MONGODB RECORD WITH JOB ROLE
			$job_specification_preview -> remove( array( 'gs_job_role_selection_id' => "{$job_role_id}" ) );
			
			
			//GET ALL JOB ORDERS
			$job_order_ids_sql = $db -> select()
			
								     -> from( 'gs_job_titles_details', array( 'gs_job_titles_details_id' ) )
								 
								     -> where( 'gs_job_role_selection_id = ?', $job_role_id );
			
			$job_order_ids = $db -> fetchAll( $job_order_ids_sql );
			
			
			foreach( $job_order_ids as $job_order_id ) {
				
				//UPDATE MONGODB RECORD
				$this -> update_mongodb_record( $job_role_id, $job_order_id );
				
			}
			

			//SHOW RESPONSE
			echo json_encode( array( 'success' => $success, 'result' => $result, 'error_message' => $error_message ) );
			
			
		}
	
	}
	
	/*
	*
	* Process Job Role Details
	*
	*/
	public function process_job_role_details() {
	
		//GET INSTANCES
		$db = $this -> db;
		
		$database = $this -> database;
		
		$job_specification_preview = $database -> selectCollection( 'job_specification_preview' );
				

		if( isset( $_POST ) ) {
				
			
			
			
			//DEFAULT RESPONSE
			$success = true;
			
			$result = array();
			
			$error_message = array();
				
			
			
			
			//GET JOB ROLE ID
			$job_role_id = $_POST[ 'job_role_id' ];
				
			
			
			
			//GET JOB ROLE CURRENCY
			$currency = $_POST[ 'currency' ];
				
			
			
			
			//GET ALL POST VARIABLES
			$categories = ( isset( $_POST[ 'category' ] ) ? $_POST[ 'category' ] : NULL );
			
			$subcategories = ( isset( $_POST[ 'sub_category' ] ) ? $_POST[ 'sub_category' ] : NULL );
			
			$levels = ( isset( $_POST[ 'level' ] ) ? $_POST[ 'level' ] : NULL );
			
			$work_statuses = ( isset( $_POST[ 'work_status' ] ) ? $_POST[ 'work_status' ] : NULL );
			
			$no_of_staff_needed = ( isset( $_POST[ 'no_of_staff' ] ) ? $_POST[ 'no_of_staff' ] : NULL );
				
			
			
			
			//NEW ENTRIES
			$new_categories = ( isset( $_POST[ 'new_category' ] ) ? $_POST[ 'new_category' ] : NULL );
			
			$new_subcategories = ( isset( $_POST[ 'new_sub_category' ] ) ? $_POST[ 'new_sub_category' ] : NULL );
			
			$new_levels = ( isset( $_POST[ 'new_level' ] ) ? $_POST[ 'new_level' ] : NULL );
			
			$new_work_statuses = ( isset( $_POST[ 'new_work_status' ] ) ? $_POST[ 'new_work_status' ] : NULL );
			
			$new_no_of_staff_needed = ( isset( $_POST[ 'new_no_of_staff' ] ) ? $_POST[ 'new_no_of_staff' ] : NULL );
				
			
			
			
			UNSET( $_POST ); //NOT NEEDED ANYMORE
				
			
			
			
			//OLD JOB ORDER IDS SQL
			$old_job_order_ids_sql = $db -> select()
			
								         -> from( 'gs_job_titles_details', array( 'gs_job_titles_details_id' ) )
								 
								         -> where( 'gs_job_role_selection_id = ?', $job_role_id );
			//OLD JOB ORDER IDS
			$old_job_order_ids = $db -> fetchAll( $old_job_order_ids_sql );
			
			//RECOIL
			$new_old_job_order_ids = array();
			
			foreach( $old_job_order_ids as $key => $job_order_id ) {
				
				$new_old_job_order_ids[ $key ] = $job_order_id[ 'gs_job_titles_details_id' ];
	
			}
				
			
			
			
			//GET ALL JOB ORDER IDS TO BE REMAIN AND UPDATE
			$remaining_job_order_ids = array_keys( $categories );
			
			//GET ALL JOB ORDER IDS TO BE REMOVED
			$remove_job_orders_ids = array_diff( $new_old_job_order_ids, $remaining_job_order_ids );
			
			//TOTAL REMAINING ORDERS PLUS NEW ORDERS
			$new_no_of_job_role = count( $remaining_job_order_ids ) + count( $new_categories );









			//CONSTRUCT JOB ROLE DATA
			$job_role_data = array();
			
			$job_role_data[ 'no_of_job_role' ] = $new_no_of_job_role;
			
			$job_role_data[ 'currency' ] = $currency;

			//UPDATE JOB ROLE SELECTION
			$db -> update( 'gs_job_role_selection', $job_role_data, $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id ) );





			//GET ALL JOB ORDER IDS
			$new_job_order_ids = array();



			//IF REMANING JOB ORDER IDS IS NOT EMPTY
			if( count( $remaining_job_order_ids ) ) {
					
				//LOOP ALL REMAINING JOB ORDER IDS
				foreach( $remaining_job_order_ids as $remaining_job_order_id ) {
					
					
					//OLD JOB SPEC
					$old_job_spec = $this -> _get_job_order_by_id( $remaining_job_order_id );
				
				
					//GET SUBCATEGORY
					$subcategory = $this -> _get_subcategory_by_id( $subcategories[ $remaining_job_order_id ] );
					
					//GET RATE
					$rate = $this -> _get_rate( $subcategories[ $remaining_job_order_id ], $currency, $levels[ $remaining_job_order_id ], $work_statuses[ $remaining_job_order_id ], false );
					
				
				
				
					//CONSTRUCT NEW JOB ORDER DETAILS
					$new_job_order_details = array();
					
					$new_job_order_details[ 'sub_category_id' ] = $subcategories[ $remaining_job_order_id ];
					
					$new_job_order_details[ 'level' ] = ( $levels[ $remaining_job_order_id ] == 'advanced' ? 'expert' : $levels[ $remaining_job_order_id ] );
					
					$new_job_order_details[ 'work_status' ] = $work_statuses[ $remaining_job_order_id ];
					
					$new_job_order_details[ 'no_of_staff_needed' ] = $no_of_staff_needed[ $remaining_job_order_id ];
					
					$new_job_order_details[ 'selected_job_title' ] = ( isset( $subcategory[ 'singular_name' ] ) && ! empty( $subcategory[ 'singular_name' ] ) ? $subcategory[ 'singular_name' ] : $subcategory[ 'sub_category_name' ] );
					
					//UPDATE JOB ORDER DETAILS
					$db -> update( 'gs_job_titles_details', $new_job_order_details, $db -> quoteInto( 'gs_job_titles_details_id = ?', $remaining_job_order_id ) );
					
				
				
				
					//JOB ROLE CATEGORY LIST SQL
					$js_list_id_sql = $db -> select()
					
										  -> from( 'gs_job_titles_details', array( 'jr_list_id' ) )
												 
										  -> where( 'gs_job_titles_details_id = ?', $remaining_job_order_id );
												 
					$js_list_id = $db -> fetchOne( $js_list_id_sql );
					
				
				
				
					//CONSTRUCT JOB ORDER CATEGORY LIST
					$job_order_categoy_list_data = array();
					
					$job_order_categoy_list_data[ 'jr_name' ] = $subcategory[ 'sub_category_name' ];
					
					$job_order_categoy_list_data[ 'jr_currency' ] = $currency;
					
					$job_order_categoy_list_data[ 'jr_' . ( $levels[ $remaining_job_order_id ] == 'advanced' ? 'expert' : $levels[ $remaining_job_order_id ] ) . '_price' ] = $rate[ 'monthly' ];
					
					//UPDATE JOB ORDER CATEGORY LIST
					$db -> update( 'job_role_cat_list', $job_order_categoy_list_data, $db -> quoteInto( 'jr_list_id = ?', $js_list_id ) ); 




					//CHECK OLD JOB SPEC AND NEW JOB SPEC HAVE THE SAME SUB CATEGORY?
					if( $old_job_spec[ 'sub_category_id' ] != $subcategories[ $remaining_job_order_id ] ) {
						
						//DELETE ALL CREDENTIALS WITH SKILLS BOX
						$db -> delete( 'gs_job_titles_credentials', $db -> quoteInto( 'gs_job_titles_details_id = ? AND box = "skills"', $remaining_job_order_id ) );
						
						//DELETE ALL CREDENTIALS WITH TASKS BOX
						$db -> delete( 'gs_job_titles_credentials', $db -> quoteInto( 'gs_job_titles_details_id = ? AND box = "tasks"', $remaining_job_order_id ) );

					}




					//UPDATE MONGODB RECORD
					$this -> update_mongodb_record( $job_role_id, $remaining_job_order_id );




					//UNSET SUBCATEGORY
					UNSET( $subcategory );
					
					//UNSET RATE
					UNSET( $rate );
					
					//GET EXISTING JOB ORDER ID
					$new_job_order_ids[] = $remaining_job_order_id;
					
				}
					
			}
			
			
			
			
			
			
			
			//IF REMOVE JOB ORDER IDS IS NOT EMPTY
			if( count( $remove_job_orders_ids ) ) {
				
				foreach( $remove_job_orders_ids as $remove_job_orders_id ) {
					
					//JOB ROLE CATEGORY LIST SQL
					$jr_list_id_sql = $db -> select()
					
										  -> from( 'gs_job_titles_details', array( 'jr_list_id' ) )
												 
										  -> where( 'gs_job_titles_details_id = ?', $remove_job_orders_id );
												 
					$jr_list_id = $db -> fetchOne( $jr_list_id_sql );
					
					//DELETE JOB ORDER CATEGORY LIST
					$db -> delete( 'job_role_cat_list', $db -> quoteInto( 'jr_list_id = ?', $jr_list_id ) );
					
					//DELETE JOB ORDER DETAILS
					$db -> delete( 'gs_job_titles_details', $db -> quoteInto( 'gs_job_titles_details_id = ?', $remove_job_orders_id ) );
					
					//DELETE JOB ORDER CREDENTIALS
					$db -> delete( 'gs_job_titles_credentials', $db -> quoteInto( 'gs_job_titles_details_id = ?', $remove_job_orders_id ) );
					
					//DELETE MONGODB JOB SPEC
					$job_specification_preview -> remove( array( 'gs_job_titles_details_id' => "{$remove_job_orders_id}", 'gs_job_role_selection_id' => "{$job_role_id}" ) );
					
				}
				
			}
			

				
			
			//IF NEW CATEGORIES IS NOT EMPTY
			if( count( $new_categories ) ) {
				
				//LOOP ALL NEW JOB ORDER
				foreach( $new_categories as $key => $category ) {
					
					//GET SUBCATEGORY
					$subcategory = $this -> _get_subcategory_by_id( $new_subcategories[ $key ] );
					
					//GET RATE
					$rate = $this -> _get_rate( $new_subcategories[ $key ], $currency, $new_levels[ $key ], $new_work_statuses[ $key ], false );
					
					
					//CONSTRUCT JOB ORDER CATEGORY LIST DATA
					$job_order_categoy_list_data = array();
					
					$job_order_categoy_list_data[ 'jr_cat_id' ] = 4;
					
					$job_order_categoy_list_data[ 'jr_name' ] = $subcategory[ 'sub_category_name' ];
					
					$job_order_categoy_list_data[ 'jr_status' ] = 'manual';
					
					$job_order_categoy_list_data[ 'jr_currency' ] = $currency;
					
					$job_order_categoy_list_data[ 'jr_' . ( $new_levels[ $key ] == 'advanced' ? 'expert' : $new_levels[ $key ] ) . '_price' ] = $rate[ 'monthly' ];
					
					//INSERT JOB ROLE CATEGORY LIST
					$db -> insert( 'job_role_cat_list', $job_order_categoy_list_data );	
					
					//GET LAST INSERTED JOB ROLE CATEGORY LIST
					$jr_list_id = $db -> lastInsertId( 'job_role_cat_list' );
					

					//CONSTRUCT NEW JOB ORDER DETAILS
					$new_job_order_details = array();
					
					$new_job_order_details[ 'gs_job_role_selection_id' ] = $job_role_id;
					
					$new_job_order_details[ 'jr_list_id' ] = $jr_list_id;
					
					$new_job_order_details[ 'jr_cat_id' ] = 4; 
					
					$new_job_order_details[ 'selected_job_title' ] = ( isset( $subcategory[ 'singular_name' ] ) && ! empty( $subcategory[ 'singular_name' ] ) ? $subcategory[ 'singular_name' ] : $subcategory[ 'sub_category_name' ] );
					
					$new_job_order_details[ 'level' ] = ( $new_levels[ $key ] == 'advanced' ? 'expert' : $new_levels[ $key ] );
					
					$new_job_order_details[ 'no_of_staff_needed' ] = $new_no_of_staff_needed[ $key ]; 
					
					$new_job_order_details[ 'job_role_no' ] = 1; 
					
					$new_job_order_details[ 'status' ] = 'new';
					
					$new_job_order_details[ 'form_filled_up' ] = 'yes';
					
					$new_job_order_details[ 'date_filled_up' ] = date( 'Y-m-d H:i:s' );
					
					$new_job_order_details[ 'service_type' ] = ( isset( $_SESSION[ 'from' ] ) && $_SESSION[ 'from' ] == 'recruitment_sheet' ? 'ASL' : 'CUSTOM' );
					
					$new_job_order_details[ 'sub_category_id' ] = $new_subcategories[ $key ];
					
					$new_job_order_details[ 'created_reason' ] = ( isset( $_SESSION[ 'from' ] ) && $_SESSION[ 'from' ] == 'recruitment_sheet' ? 'Converted-From-ASL' : 'New JS Form Client' );
					
					$new_job_order_details[ 'work_status' ] = $new_work_statuses[ $key ];
					
					
					//INSERT JOB ORDER DETAILS
					$db -> insert( 'gs_job_titles_details', $new_job_order_details );
					
					//GET LAST INSERTED JOB ORDER DETAILS
					$gs_job_titles_details_id = $db -> lastInsertId( 'gs_job_titles_details' );



					//UPDATE MONGODB RECORD
					$this -> update_mongodb_record( $job_role_id, $gs_job_titles_details_id );











					//UNSET SUBCATEGORY
					UNSET( $subcategory );
					
					//UNSET RATE
					UNSET( $rate );


					//GET NEW JOB ORDER ID
					$new_job_order_ids[] = $gs_job_titles_details_id;

				}

			}

			//SET NEW JOB ORDER IDS
			$_SESSION[ 'job_order_ids' ] = $new_job_order_ids;

			//SHOW RESPONSE
			echo json_encode( array( 'success' => $success, 'result' => $result, 'error_message' => $error_message ) );
			
			
		}
	
	}
	
	/*
	*
	* Process Job Order Details
	*
	*/
	public function process_job_order_details() {
	
		//GET INSTANCES
		$db = $this -> db;
		
		$database = $this -> database;
		
		$job_specifications = $database -> selectCollection( 'job_specifications' );

		if( isset( $_POST ) && count( $_POST ) ) {
			
			
			/* DEFAULT RESPONSE */
			$success = true;
			
			$result = array();
			
			$error_message = array();  
			
			
			/* JOB ROLE ID */
			$job_role_id = $_POST[ 'job_role_id' ];
			
			/* JOB ORDER IDS */
			$job_order_ids = array_values( $_POST[ 'job_order_id' ] );
			
			
			/* 
			* 
			* GS JOB TITLES DETAILS
			* 
			*/
			
			
			$working_timezone = ( isset( $_POST[ 'working_timezone' ] ) ? $_POST[ 'working_timezone' ] : NULL );
			
			$shift_time_start = ( isset( $_POST[ 'shift_time_start' ] ) ? $_POST[ 'shift_time_start' ] : NULL );
			
			$shift_time_end = ( isset( $_POST[ 'shift_time_end' ] ) ? $_POST[ 'shift_time_end' ] : NULL );
			
			$start_date = ( isset( $_POST[ 'start_date' ] ) ? $_POST[ 'start_date' ] : NULL );
			
			
			/* 
			* 
			* GS JOB TITLES CREDENTIALS 
			* 
			*/
			
			
			/* BOX == SKILLS */
			$skills = ( isset( $_POST[ 'skills' ] ) ? $_POST[ 'skills' ] : NULL );
			
			$skills_proficiency = ( isset( $_POST[ 'skills-proficiency' ] ) ? $_POST[ 'skills-proficiency' ] : NULL );
			
			/* BOX == TASKS */
			$tasks = ( isset( $_POST[ 'tasks' ] ) ? $_POST[ 'tasks' ] : NULL );

			$tasks_proficiency = ( isset( $_POST[ 'tasks-proficiency' ] ) ? $_POST[ 'tasks-proficiency' ] : NULL );
			
			/* BOX == RESPONSIBILITY */
			$responsbility = ( isset( $_POST[ 'responsibility' ] ) ? $_POST[ 'responsibility' ] : NULL );
			
			/* BOX == OTHER SKILLS */
			$other_skills = ( isset( $_POST[ 'other_skills' ] ) ?  $_POST[ 'other_skills' ] : NULL );
			
			/* BOX == STAFF PROVIDE TRAINING */
			$staff_provide_training = ( isset( $_POST[ 'staff_provide_training' ] ) ? $_POST[ 'staff_provide_training' ] : NULL );
			
			/* BOX == STAFF MAKE CALLS */
			$staff_make_calls = ( isset( $_POST[ 'staff_make_calls' ] ) ? $_POST[ 'staff_make_calls' ] : NULL );
			
			/* BOX == STAFF FIRST TIME */
			$staff_first_time = ( isset( $_POST[ 'staff_first_time' ] ) ? $_POST[ 'staff_first_time' ] : NULL );
			
			/* BOX == SPECIAL INSTRUCTION */
			$special_instruction = ( isset( $_POST[ 'special_instruction' ] ) ? $_POST[ 'special_instruction' ] : NULL );
			
			
			/*
			* 
			* OTHER DETAILS
			* 
			*/
			
			
			/* BOX == INCREASE DEMAND */
			$increase_demand = ( isset( $_POST[ 'increase_demand' ] ) ? $_POST[ 'increase_demand' ] : NULL );
			
			/* BOX == REPLACEMENT POST */
			$replacement_post = ( isset( $_POST[ 'replacement_post' ] ) ? $_POST[ 'replacement_post' ] : NULL );
			
			/* BOX == SUPPORT CURRENT */
			$support_current = ( isset( $_POST[ 'support_current' ] ) ? $_POST[ 'support_current' ] : NULL );
			
			/* BOX == EXPERIMENT ROLE */
			$experiment_role = ( isset( $_POST[ 'experiment_role' ] ) ? $_POST[ 'experiment_role' ] : NULL );
			
			/* BOX == MEET NEW */
			$meet_new = ( isset( $_POST[ 'meet_new' ] ) ? $_POST[ 'meet_new' ] : NULL );
			
			/* BOX == STAFF REPORT DIRECTLY */
			$staff_report_directly = ( isset( $_POST[ 'staff_report_directly' ] ) ? $_POST[ 'staff_report_directly' ] : NULL );
			
			
			/* 
			* 
			* MANAGER INFORMATION
			* 
			*/
			
			
			$manager_first_name = ( isset( $_POST[ 'manager_first_name' ] ) ? $_POST[ 'manager_first_name' ] : NULL );
			
			$manager_last_name = ( isset( $_POST[ 'manager_last_name' ] ) ? $_POST[ 'manager_last_name' ] : NULL );
			
			$manager_email = ( isset( $_POST[ 'manager_email' ] ) ? $_POST[ 'manager_email' ] : NULL );
			
			$manager_contact_number = ( isset( $_POST[ 'manager_contact_number' ] ) ? $_POST[ 'manager_contact_number' ] : NULL );
			
			
			//LOOP ALL JOB ORDER IDS
			foreach( $job_order_ids as $job_order_id ) {
				
				
				/* 
				* 
				* GS JOB TITLES DETAILS
				* 
				*/
				
				
				//NEW JOB ORDER DETAIL CONTAINER VARIABLE
				$new_job_order_detail = array(); 
				
				//WORKING TIME ZONE
				$new_job_order_detail[ 'working_timezone' ] = $working_timezone[ $job_order_id ];
				
				//START WORK
				$new_job_order_detail[ 'start_work' ] = $shift_time_start[ $job_order_id ];
				
				//FINISH WORK
				$new_job_order_detail[ 'finish_work' ] = $shift_time_end[ $job_order_id ];
				
				//PROPOSED START DATE
				$new_job_order_detail[ 'proposed_start_date' ] = $start_date[ $job_order_id ];
				
				//UPDATE GS JOB TITLES DETAILS
				$db -> update( 'gs_job_titles_details', $new_job_order_detail, $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id ) );
				
				
				/* 
				* 
				* GS JOB TITLES CREDENTIALS 
				* 
				*/
				

				//REMOVE ALL EXISTING SKILLS
				$db -> delete( 'gs_job_titles_credentials', $db -> quoteInto( 'gs_job_titles_details_id = ? AND box = "skills"', $job_order_id ) );

				//LOOP ALL SKILLS UNDER THIS JOB ORDER
				foreach( $skills[ $job_order_id ] as $skill_id => $skill_value ) {
					
					//SKILL MUST HAVE VALUE
					if( trim( $skill_value ) != '' ) {

						//NEW SKILL STORAGE VARIABLE
						$new_skill = array();
						
						$new_skill[ 'gs_job_titles_details_id' ] = $job_order_id;
						
						$new_skill[ 'gs_job_role_selection_id' ] = $job_role_id;
						
						$new_skill[ 'description' ] = $skill_value;
						
						$new_skill[ 'rating' ] = $skills_proficiency[ $job_order_id ][ $skill_id ];
						
						$new_skill[ 'box' ] = 'skills';
						
						$new_skill[ 'is_updated' ] = 0;
						
						//INSERT NEW SKILL
						$db -> insert( 'gs_job_titles_credentials', $new_skill );
					
					}

				}
				
				//REMOVE ALL EXISTING TASKS
				$db -> delete( 'gs_job_titles_credentials', $db -> quoteInto( 'gs_job_titles_details_id = ? AND box = "tasks"', $job_order_id ) );
				
				//LOOP ALL TASK UNDER THIS JOB ORDER
				foreach( $tasks[ $job_order_id ] as $task_id => $task_value ) {

					//TASK MUST HAVE VALUE
					if( trim( $task_value ) != '' ) {
						
						//NEW TASK STORAGE VARIABLE
						$new_task = array();
						
						$new_task[ 'gs_job_titles_details_id' ] = $job_order_id;
						
						$new_task[ 'gs_job_role_selection_id' ] = $job_role_id;
						
						$new_task[ 'description' ] = $task_value;
						
						$new_task[ 'rating' ] = $tasks_proficiency[ $job_order_id ][ $task_id ];
						
						$new_task[ 'box' ] = 'tasks';
						
						$new_task[ 'is_updated' ] = 0;
						
						//INSERT NEW TASK
						$db -> insert( 'gs_job_titles_credentials', $new_task );
					
					}
					
				}
				
				//CHECK IF RESPONSIBILITY POST DATA IS ISSET
				if( isset( $responsbility[ $job_order_id ] ) ) {
					
					//REMOVE ALL EXISTING RESPONSIBILITY
					$db -> delete( 'gs_job_titles_credentials', $db -> quoteInto( 'gs_job_titles_details_id = ? AND box = "responsibility"', $job_order_id ) );
					
					//LOOP ALL SET OF REPONSIBILITY PER JOB ORDER
					foreach( $responsbility[ $job_order_id ] as $responsbility_value ) {
						
						//RESPONSIBILITY MUST HAVE VALUE
						if( trim( $responsbility_value ) != '' ) {
							
							//NEW RESPONSIBILITY STORAGE VARIABLE
							$new_reponsibility = array();
							
							$new_reponsibility[ 'gs_job_titles_details_id' ] = $job_order_id;
							
							$new_reponsibility[ 'gs_job_role_selection_id' ] = $job_role_id;
							
							$new_reponsibility[ 'description' ] = $responsbility_value;
							
							$new_reponsibility[ 'box' ] = 'responsibility';
							
							$new_reponsibility[ 'is_updated' ] = 0;
							
							//INSERT NEW RESPONSIBILITY
							$db -> insert( 'gs_job_titles_credentials', $new_reponsibility );
						
						}
						
					}
				
				}
				
				//CHECK IF OTHER SKILLS POST DATA IS ISSET
				if( isset( $other_skills[ $job_order_id ] ) ) {
					
					//REMOVE ALL EXISTING OTHER SKILLS
					$db -> delete( 'gs_job_titles_credentials', $db -> quoteInto( 'gs_job_titles_details_id = ? AND box = "other_skills"', $job_order_id ) );
					
					//LOOP ALL SET OF OTHER SKILLS PER JOB ORDER
					foreach( $other_skills[ $job_order_id ] as $other_skill_value ) {
						
						//OTHER SKILL MUST HAVE VALUE
						if( trim( $other_skill_value ) != '' ) {
							
							//NEW OTHER SKILLS STORAGE VARIABLE
							$new_other_skills = array();
							
							$new_other_skills[ 'gs_job_titles_details_id' ] = $job_order_id;
							
							$new_other_skills[ 'gs_job_role_selection_id' ] = $job_role_id;
							
							$new_other_skills[ 'description' ] = $other_skill_value;
							
							$new_other_skills[ 'box' ] = 'other_skills';
							
							$new_other_skills[ 'is_updated' ] = 0;
							
							//INSERT NEW OTHER SKILLS
							$db -> insert( 'gs_job_titles_credentials', $new_other_skills );
						
						}
						
					}
					
				}
				
				//CHECK IF STAFF PROVIDE TRAINING POST DATA IS ISSET
				if( isset( $staff_provide_training[ $job_order_id ] ) ) {
					
					//STAFF PROVIDE TRANING SQL
					$spt_sql = $db -> select()
					
								   -> from( 'gs_job_titles_credentials' )
								  
								   -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "staff_provide_training"' );
					
					//FETCH STAFF PROVIDE TRAINING
					$spt = $db -> fetchRow( $spt_sql );
					
					//CHECK IF STAFF PROVIDE TRAINING ALREADY EXISTS
					if( $spt ) {
						
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'staff_provide_training' );

						//UPDATE STAFF PROVIDE TRAINING
						$db -> update( 'gs_job_titles_credentials', array( 'description' => $staff_provide_training[ $job_order_id ] ), $new_where );
						
					} else {
						
						//NEW STAFF PROVIDE TRAINING STORAGE VARIABLE
						$new_staff_provide_training = array();
						
						$new_staff_provide_training[ 'gs_job_titles_details_id' ] = $job_order_id;
						
						$new_staff_provide_training[ 'gs_job_role_selection_id' ] = $job_role_id;
						
						$new_staff_provide_training[ 'description' ] = $staff_provide_training[ $job_order_id ];
						
						$new_staff_provide_training[ 'box' ] = 'staff_provide_training';
						
						$new_staff_provide_training[ 'is_updated' ] = 0;
						
						//INSERT NEW STAFF PROVIDE TRAINING
						$db -> insert( 'gs_job_titles_credentials', $new_staff_provide_training );
						
					}
				
				}
				
				
				//CHECK IF STAFF MAKE CALLS POST DATA IS ISSET
				if( isset( $staff_make_calls[ $job_order_id ] ) ) {
					
					//STAFF MAKE CALLS SQL
					$smc_sql = $db -> select()
					
								   -> from( 'gs_job_titles_credentials' )
								  
								   -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "staff_make_calls"' );
					
					//FETCH STAFF MAKE CALLS
					$smc = $db -> fetchRow( $smc_sql );

					//CHECK IF STAFF MAKE CALLS ALREADY EXISTS
					if( $smc ) {
						
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'staff_make_calls' );
						
						//UPDATE STAFF MAKE CALLS
						$db -> update( 'gs_job_titles_credentials', array( 'description' => $staff_make_calls[ $job_order_id ] ), $new_where );

					} else {
						
						//NEW STAFF MAKE CALLS STORAGE VARIABLE
						$new_staff_make_calls = array();
						
						$new_staff_make_calls[ 'gs_job_titles_details_id' ] = $job_order_id;
						
						$new_staff_make_calls[ 'gs_job_role_selection_id' ] = $job_role_id;
						
						$new_staff_make_calls[ 'description' ] = $staff_make_calls[ $job_order_id ];
						
						$new_staff_make_calls[ 'box' ] = 'staff_make_calls';
						
						$new_staff_make_calls[ 'is_updated' ] = 0;
						
						//INSERT NEW STAFF MAKE CALLS
						$db -> insert( 'gs_job_titles_credentials', $new_staff_make_calls );
						
					}
				
				}
				
				//CHECK IF STAFF FIRST TIME POST DATA IS ISSET
				if( isset( $staff_first_time[ $job_order_id ] ) ) {
					
					//STAFF FIRST TIME SQL
					$sft_sql = $db -> select()
					
								   -> from( 'gs_job_titles_credentials' )
								  
								   -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "staff_first_time"' );
					
					//FETCH STAFF FIRST TIME
					$sft = $db -> fetchRow( $sft_sql );
					
					//CHECK IF STAFF FIRST TIME ALREADY EXISTS
					if( $sft ) {
						
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'staff_first_time' );

						//UPDATE STAFF FIRST TIME
						$db -> update( 'gs_job_titles_credentials', array( 'description' => $staff_first_time[ $job_order_id ] ), $new_where );

					} else {
						
						//NEW STAFF FIRST TIME STORAGE VARIABLE
						$new_staff_first_time = array();
						
						$new_staff_first_time[ 'gs_job_titles_details_id' ] = $job_order_id;
						
						$new_staff_first_time[ 'gs_job_role_selection_id' ] = $job_role_id;
						
						$new_staff_first_time[ 'description' ] = $staff_first_time[ $job_order_id ];
						
						$new_staff_first_time[ 'box' ] = 'staff_first_time';
						
						$new_staff_first_time[ 'is_updated' ] = 0;
						
						//INSERT NEW STAFF MAKE CALLS
						$db -> insert( 'gs_job_titles_credentials', $new_staff_first_time );
						
					}
				
				}
				
				//CHECK IF SPECIAL INSTRUCTION POST DATA IS ISSET
				if( isset( $special_instruction[ $job_order_id ] ) ) {
					
					//SPECIAL INSTRUCTION SQL
					$si_sql = $db -> select()
					
								   -> from( 'gs_job_titles_credentials' )
								  
								   -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "special_instruction"' );
					
					//FETCH SPECIAL INSTRUCTION
					$si = $db -> fetchRow( $si_sql );

					//CHECK IF SPECIAL INSTRUCTION ALREADY EXISTS
					if( $si ) {
						
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'special_instruction' );
						
						//UPDATE SPECIAL INSTRUCTION
						$db -> update( 'gs_job_titles_credentials', array( 'description' => $special_instruction[ $job_order_id ] ), $new_where );

					} else {
						
						//NEW SPECIAL INSTRUCTION STORAGE VARIABLE
						$new_special_instruction = array();
						
						$new_special_instruction[ 'gs_job_titles_details_id' ] = $job_order_id;
						
						$new_special_instruction[ 'gs_job_role_selection_id' ] = $job_role_id;
						
						$new_special_instruction[ 'description' ] = $special_instruction[ $job_order_id ];
						
						$new_special_instruction[ 'box' ] = 'special_instruction';
						
						$new_special_instruction[ 'is_updated' ] = 0;
						
						//INSERT NEW SPECIAL INSTRUCTION
						$db -> insert( 'gs_job_titles_credentials', $new_special_instruction );
						
					}
				
				}
				
				/*
				* 
				* OTHER DETAILS
				* 
				*/
				
				//INCREASE DEMAND SQL
				$id_sql = $db -> select()
				
							  -> from( 'gs_job_titles_credentials' )
							  
							  -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "increase_demand"' );
				
				//FETCH INCREASE DEMAND
				$id = $db -> fetchRow( $id_sql );
				
				//CHECK IF INCREASE DEMAND POST DATA IS ISSET
				if( isset( $increase_demand[ $job_order_id ] ) ) {

					if( $increase_demand[ $job_order_id ] == 'on' ) {
						
						if( ! $id ) {
							
							//NEW INCREASE DEMAND STORAGE VARIABLE
							$new_increase_demand = array();
							
							$new_increase_demand[ 'gs_job_titles_details_id' ] = $job_order_id;
							
							$new_increase_demand[ 'gs_job_role_selection_id' ] = $job_role_id;
							
							$new_increase_demand[ 'description' ] = 'checked';
							
							$new_increase_demand[ 'box' ] = 'increase_demand';
							
							$new_increase_demand[ 'is_updated' ] = 0;
							
							//INSERT NEW INCREASE DEMAND
							$db -> insert( 'gs_job_titles_credentials', $new_increase_demand );
							
						}
						
					}
				
				} else {
					
					if( $id ) {
					
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'increase_demand' );
						
						$db -> delete( 'gs_job_titles_credentials', $new_where );
					
					}
					
				}
				
				//REPLACEMENT POST SQL
				$rp_sql = $db -> select()
				
							  -> from( 'gs_job_titles_credentials' )
							  
							  -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "replacement_post"' );
				
				//FETCH REPLACEMENT POST
				$rp = $db -> fetchRow( $rp_sql );
				
				//CHECK IF REPLACEMENT POST POST DATA IS ISSET
				if( isset( $replacement_post[ $job_order_id ] ) ) {
					
					if( $replacement_post[ $job_order_id ] == 'on' ) {
						
						if( ! $rp ) {
							
							//NEW REPLACEMENT POST STORAGE VARIABLE
							$new_replacement_post = array();
							
							$new_replacement_post[ 'gs_job_titles_details_id' ] = $job_order_id;
							
							$new_replacement_post[ 'gs_job_role_selection_id' ] = $job_role_id;
							
							$new_replacement_post[ 'description' ] = 'checked';
							
							$new_replacement_post[ 'box' ] = 'replacement_post';
							
							$new_replacement_post[ 'is_updated' ] = 0;
							
							//INSERT NEW REPLACEMENT POST
							$db -> insert( 'gs_job_titles_credentials', $new_replacement_post );
							
						}
						
					}
				
				} else {
					
					if( $rp ) {
					
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'replacement_post' );
						
						$db -> delete( 'gs_job_titles_credentials', $new_where );
					
					}
					
				}
				
				//SUPPORT CURRENT SQL
				$sc_sql = $db -> select()
				
							  -> from( 'gs_job_titles_credentials' )
							  
							  -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "support_current"' );
				
				//FETCH SUPPORT CURRENT
				$sc = $db -> fetchRow( $sc_sql );
				
				//CHECK IF SUPPORT CURRENT POST DATA IS ISSET
				if( isset( $support_current[ $job_order_id ] ) ) {
					
					if( $support_current[ $job_order_id ] == 'on' ) {
						
						if( ! $sc ) {
							
							//NEW SUPPORT CURRENT STORAGE VARIABLE
							$new_support_current = array();
							
							$new_support_current[ 'gs_job_titles_details_id' ] = $job_order_id;
							
							$new_support_current[ 'gs_job_role_selection_id' ] = $job_role_id;
							
							$new_support_current[ 'description' ] = 'checked';
							
							$new_support_current[ 'box' ] = 'support_current';
							
							$new_support_current[ 'is_updated' ] = 0;
							
							//INSERT NEW REPLACEMENT POST
							$db -> insert( 'gs_job_titles_credentials', $new_support_current );
							
						}
						
					}
				
				} else {
					
					if( $sc ) {
						
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'support_current' );
						
						$db -> delete( 'gs_job_titles_credentials', $new_where );
						
					}
					
				}
				
				//EXPERIMENT ROLE SQL
				$er_sql = $db -> select()
				
							  -> from( 'gs_job_titles_credentials' )
							  
							  -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "experiment_role"' );
				
				//FETCH EXPERIMENT ROLE
				$er = $db -> fetchRow( $er_sql );
				
				//CHECK IF EXPERIMENT ROLE POST DATA IS ISSET
				if( isset( $experiment_role[ $job_order_id ] ) ) {

					if( $experiment_role[ $job_order_id ] == 'on' ) {
						
						if( ! $er ) {
							
							//NEW EXPERIMENT ROLE STORAGE VARIABLE
							$new_experiment_role = array();
							
							$new_experiment_role[ 'gs_job_titles_details_id' ] = $job_order_id;
							
							$new_experiment_role[ 'gs_job_role_selection_id' ] = $job_role_id;
							
							$new_experiment_role[ 'description' ] = 'checked';
							
							$new_experiment_role[ 'box' ] = 'experiment_role';
							
							$new_experiment_role[ 'is_updated' ] = 0;
							
							//INSERT NEW REPLACEMENT POST
							$db -> insert( 'gs_job_titles_credentials', $new_experiment_role );
							
						}
						
					}
				
				} else {
					
					if( $er ) {
						
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'experiment_role' );
						
						$db -> delete( 'gs_job_titles_credentials', $new_where );
						
					}
					
				}
				
				//MEET NEW SQL
				$mn_sql = $db -> select()
				
							  -> from( 'gs_job_titles_credentials' )
							  
							  -> where( 'gs_job_titles_details_id = '.$job_order_id.' AND gs_job_role_selection_id = '.$job_role_id.' AND box = "meet_new"' );
				
				//FETCH MEET NEW
				$mn = $db -> fetchRow( $mn_sql );
				
				//CHECK IF MEET NEW POST DATA IS ISSET
				if( isset( $meet_new[ $job_order_id ] ) ) {

					if( $meet_new[ $job_order_id ] == 'on' ) {
						
						if( ! $mn ) {
							
							//NEW MEET NEW STORAGE VARIABLE
							$new_meet_new = array();
							
							$new_meet_new[ 'gs_job_titles_details_id' ] = $job_order_id;
							
							$new_meet_new[ 'gs_job_role_selection_id' ] = $job_role_id;
							
							$new_meet_new[ 'description' ] = 'checked';
							
							$new_meet_new[ 'box' ] = 'meet_new';
							
							$new_meet_new[ 'is_updated' ] = 0;
							
							//INSERT NEW MEET NEW 
							$db -> insert( 'gs_job_titles_credentials', $new_meet_new );
							
						}
						
					}
				
				} else {
					
					if( $mn ) {
						
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'meet_new' );
						
						$db -> delete( 'gs_job_titles_credentials', $new_where );
						
					}
				
				}
				
				/*
				* 
				* MANAGER INFORMATION
				* 
				*/
				
				//CHECK IF STAFF REPORT DIRECTLY POST DATA IS ISSET
				if( isset( $staff_report_directly[ $job_order_id ] ) ) {
					
					//STAFF REPORT DIRECTLY SQL
					$srd_sql = $db -> select()
					
								   -> from( 'gs_job_titles_credentials' )
								  
								   -> where( "gs_job_titles_details_id = {$job_order_id} AND gs_job_role_selection_id = {$job_role_id} AND box = 'staff_report_directly'" );
					
					//FETCH STAFF REPORT DIRECTLY
					$srd = $db -> fetchRow( $srd_sql );
					
					//CHECK IF STAFF REPORT DIRECTLY ALREADY EXISTS
					if( $srd ) {
						
						//CREATE NEW WHERE STATEMENT
						$new_where = array();
						
						$new_where[] = $db -> quoteInto( 'gs_job_titles_details_id = ?', $job_order_id );
						
						$new_where[] = $db -> quoteInto( 'gs_job_role_selection_id = ?', $job_role_id );
						
						$new_where[] = $db -> quoteInto( 'box = ?', 'staff_report_directly' );
						
						//UPDATE SPECIAL INSTRUCTION
						$db -> update( 'gs_job_titles_credentials', array( 'description' => $staff_report_directly[ $job_order_id ] ), $new_where );

					} else {
						
						//NEW SPECIAL INSTRUCTION STORAGE VARIABLE
						$new_special_instruction = array();
						
						$new_special_instruction[ 'gs_job_titles_details_id' ] = $job_order_id;
						
						$new_special_instruction[ 'gs_job_role_selection_id' ] = $job_role_id;
						
						$new_special_instruction[ 'description' ] = $staff_report_directly[ $job_order_id ];
						
						$new_special_instruction[ 'box' ] = 'staff_report_directly';
						
						$new_special_instruction[ 'is_updated' ] = 0;
						
						//INSERT NEW SPECIAL INSTRUCTION
						$db -> insert( 'gs_job_titles_credentials', $new_special_instruction );
						
					}

					//GET MANAGER PROFILE
					$job_spec = $job_specifications -> findOne( array( 'gs_job_titles_details_id' => $job_order_id, 'gs_job_role_selection_id' => $job_role_id, 'details.move_like_jagger' => 'step_3' ) );
					
					
					/*
					* 
					* OTHER DETAILS
					* 
					*/
					
					
					$job_spec[ 'other_details' ][ 'increase_demand' ] = ( isset( $increase_demand[ $job_order_id ] ) && $increase_demand[ $job_order_id ] == 'on' ? 'Yes' : 'No' );
					
					$job_spec[ 'other_details' ][ 'replacement_post' ] = ( isset( $replacement_post[ $job_order_id ] ) && $replacement_post[ $job_order_id ] == 'on' ? 'Yes' : 'No' );
					
					$job_spec[ 'other_details' ][ 'support_current' ] = ( isset( $support_current[ $job_order_id ] ) && $support_current[ $job_order_id ] == 'on' ? 'Yes' : 'No' );
					
					$job_spec[ 'other_details' ][ 'experiment_role' ] = ( isset( $experiment_role[ $job_order_id ] ) && $experiment_role[ $job_order_id ] == 'on' ? 'Yes' : 'No' );
					
					$job_spec[ 'other_details' ][ 'meet_new' ] = ( isset( $meet_new[ $job_order_id ] ) && $meet_new[ $job_order_id ] == 'on' ? 'Yes' : 'No' );
					
					
					/* 
					* 
					* MANAGER INFORMATION
					* 
					*/
					
					
					//CHECK IF STAFF REPORT DIRECTLY MUST NOT REPORT TO MANAGER
					if( $staff_report_directly[ $job_order_id ] == 'No' ) {
						
						$job_spec[ 'details' ][ 'manager_first_name' ] = $manager_first_name[ $job_order_id ];
						
						$job_spec[ 'details' ][ 'manager_last_name' ] = $manager_last_name[ $job_order_id ];
						
						$job_spec[ 'details' ][ 'manager_email' ] = $manager_email[ $job_order_id ];
						
						$job_spec[ 'details' ][ 'manager_contact_number' ] = $manager_contact_number[ $job_order_id ];
						
						$job_spec[ 'details' ][ 'manager_contact_number' ] = $manager_contact_number[ $job_order_id ];

					} else {
						
						$job_spec[ 'details' ][ 'manager_first_name' ] = '';
						
						$job_spec[ 'details' ][ 'manager_last_name' ] = '';
						
						$job_spec[ 'details' ][ 'manager_email' ] = '';
						
						$job_spec[ 'details' ][ 'manager_contact_number' ] = '';
						
						$job_spec[ 'details' ][ 'manager_contact_number' ] = '';
						
					}

					$job_spec_id = $job_spec[ '_id' ];
					
					UNSET( $job_spec[ '_id' ] );

					//UPDATE EXISTING JOB SPEC WITH MANAGER DETAILS
					$job_specifications -> update( array( '_id' => new MongoId( $job_spec_id ) ), array( '$set' => $job_spec ) );
					
				}

			}

			//SHOW RESPONSE
			echo json_encode( array( 'success' => $success, 'result' => $result, 'error_message' => $error_message ) );
			
		}
	
	}
	
	/*
	* 
	* Get updated job roles
	* 
	*/
	public function get_updated_job_roles() {
	
		//GET INSTANCES
		$db = $this -> db;
		
		$smarty = $this -> smarty;
		
		/* JOB ORDER PREVIEW CORE DATA */
		$leads_details = $this -> _get_lead_details();
		
		$job_role_details = $this -> _get_job_role_details( $leads_details[ 'leads_id' ] );
		
		$smarty -> assign( 'leads_details', $leads_details );  
		
		$smarty -> assign( 'job_role_details', $job_role_details );


		/* STEP 2 PREREQUISITE */
		$categories = $this -> _get_categories();
		
		$smarty -> assign( 'categories', $categories );


		$job_roles_template = $smarty -> fetch( 'job_roles.tpl' );
		
		echo $job_roles_template;

	}
	
	/*
	* 
	* Get updated job orders
	* 
	*/
	public function get_updated_job_orders() {
		
		
		//GET INSTANCES
		$db = $this -> db;
		
		$smarty = $this -> smarty;
		
		
		/* JOB ORDER PREVIEW CORE DATA */
		$leads_details = $this -> _get_lead_details();
		
		$job_role_details = $this -> _get_job_role_details( $leads_details[ 'leads_id' ] );
		
		$job_order_details = $this -> _get_job_order_details( $job_role_details[ 'details' ][ 'gs_job_role_selection_id' ] );
		
		$smarty -> assign( 'leads_details', $leads_details );  
		
		$smarty -> assign( 'job_role_details', $job_role_details );
		
		$smarty -> assign( 'job_order_details', $job_order_details );
		
		
		/* STEP 3 PREREQUISITE */
		$timezones = $this -> _get_all_timezone();
		
		$shift_times = $this -> _get_all_shift_time();
		
		$working_status = $this -> _get_all_working_status();
		
		$smarty -> assign( 'timezones', $timezones );
		
		$smarty -> assign( 'shift_times', $shift_times );
		
		$smarty -> assign( 'working_status', $working_status );


		/* ADMIN IS LOGGED IN */
		if( isset( $_SESSION[ 'admin_id' ] ) ) {
			
			$smarty -> assign( 'admin_user', true );
			
		}
		
		$job_orders_template = $smarty -> fetch( 'job_orders.tpl' );
		
		echo $job_orders_template;
		
	}
	
	/*
	* 
	* Get Lead Details
	* 
	* @param $leads_id / $client_id => session
	* 
	*/
	private function _get_lead_details() { 
		
		//GET INSTANCE
		$db = $this -> db;

		//GET CLIENT ID SESSION ALSO KNOWN AS LEADS ID
		$lead_id = ( $_SESSION['client_id'] ? $_SESSION['client_id'] : $_SESSION['leads_id'] );
		
		//CHECK IF LEAD IS ALREADY EXISTS!
		if( $lead_id ) {
		
			if( isset( $_SESSION[ 'leads_new_info_id' ] ) ) {
				
				//CONSTRUCT LEAD NEW INFO QUERY
				$lead_sql = $db -> select()
		
								-> from( array( 'l' => 'leads_new_info' ),
							
										array(
										
											'leads_id as leads_id',

											'fname as leads_profile_firstname', 

											'lname as leads_profile_lastname', 

											'email as leads_profile_primary_email_address',

											'sec_email as leads_profile_secondary_email_address',

											'mobile as leads_profile_mobile_no', 

											'company_name as leads_company_name',

											'company_position as leads_company_position',

											'company_size as leads_company_size',
											
											'officenumber as leads_company_office_no',

											'company_address as leads_company_address',

											'company_turnover as leads_company_turnover',

											'company_description as leads_company_description',
											
											'outsourcing_experience as leads_company_tried_staffing'

										)
							
							);
				
			} else {
				
				//CONSTRUCT LEAD QUERY
				$lead_sql = $db -> select()
			
								-> from( array( 'l' => 'leads' ), 
							
										array(
										
											'id as leads_id',

											'fname as leads_profile_firstname', 

											'lname as leads_profile_lastname', 

											'email as leads_profile_primary_email_address',

											'sec_email as leads_profile_secondary_email_address',

											'mobile as leads_profile_mobile_no', 

											'company_name as leads_company_name',

											'company_position as leads_company_position',

											'company_size as leads_company_size',
											
											'officenumber as leads_company_office_no',

											'company_address as leads_company_address',

											'company_turnover as leads_company_turnover',

											'company_description as leads_company_description',
											
											'outsourcing_experience as leads_company_tried_staffing'

										)
							
							);

				}
							
				$lead_sql -> joinLeft( array( 'la' => 'leads_address' ), 'l.id = la.leads_id', array( 'leads_address', 'leads_zip_code as leads_address_zip_code' ) )

						  -> joinLeft( array( 'lco' => 'library_country' ), 'la.leads_country = lco.id', array( 'id as leads_address_country_id', 'name as leads_address_country_name' ) )

						  -> joinLeft( array( 'ls' => 'library_state' ), 'la.leads_state = ls.id', array( 'id as leads_address_state_id', 'name as leads_address_state_name' ) )

						  -> joinLeft( array( 'lci' => 'library_city' ), 'la.leads_city = lci.id', array( 'id as leads_address_city_id', 'name as leads_address_city_name' ) );
							 
							 
				if( isset( $_SESSION[ 'leads_new_info_id' ] ) ) {
					
					$lead_sql -> where( 'l.leads_id = ?', $lead_id );
					
				} else {
					
					$lead_sql -> where( 'l.id = ?', $lead_id ); 
					
				}			 
							 
			
			//FETCH ROW LEAD
			$lead = $db -> fetchRow( $lead_sql ); 
			
			//RETURN LEAD DETAILS
			return $lead;
		
		} else {
			
			//REDIRECT TO STEP 1
			header("Location:/portal/custom_get_started/");
			
		}
	
	}
	
	/*
	* 
	* Get Job Role Details
	* 
	* @param $leads_id => int
	* 
	*/
	private function _get_job_role_details( $leads_id = 0 ) {
		
		//IF LEADS EXISTS
		if( $leads_id ) {
			
			//GET INSTANCE
			$db = $this -> db;
			
			$new_job_role = array();
			
			//JOB ROLE SQL
			$job_role_sql = $db -> select()
			
								-> from( 'gs_job_role_selection' )
								
								-> where( 'leads_id = ?', $leads_id )
								
								-> order( array( 'date_created DESC' ) );
			
			$job_role = $db -> fetchRow( $job_role_sql ); //CONTAINS LAST RECORD OF JOB ROLE FOR LEAD
			
			$new_job_role[ 'details' ] = $job_role;
			
			
			//JOB ORDERS SQL
			$job_orders_sql = $db -> select()
			
								  -> from( 'gs_job_titles_details' )
								 
								  -> where( 'gs_job_role_selection_id = ?', $job_role[ 'gs_job_role_selection_id' ] );
								  
			$job_orders = $db -> fetchAll( $job_orders_sql );
			
								  
			$new_job_orders = array();
			
			$new_job_order_rates = array();
			
			$job_orders_sub_category = array();
				

			foreach( $job_orders as $key => $job_order ) {
				

				//JOB ORDER ID
				$new_job_orders[ $key ][ 'job_order_id' ] = $job_order[ 'gs_job_titles_details_id' ];
				

				/*
				 * 
				 *JOB ORDER
				 * 
				*/
				

				//SUBCATEGORY
				$subcategory = $this -> _get_subcategory_by_id( $job_order[ 'sub_category_id' ] );
				
				$new_job_orders[ $key ][ 'sub_category_id' ] = $subcategory[ 'sub_category_id' ];
				

				//CATEGORY
				$category = $this -> _get_category_by_id( $subcategory[ 'category_id' ] );
				
				$new_job_orders[ $key ][ 'category_id' ] = $category[ 'category_id' ];
				

				//LEVEL
				$new_job_orders[ $key ][ 'level' ] = $job_order[ 'level' ];
				
				//WORK TIME
				$new_job_orders[ $key ][ 'work_status' ] = $job_order[ 'work_status' ];
				
				//NO. OF STAFF
				$new_job_orders[ $key ][ 'no_of_staff_needed' ] = $job_order[ 'no_of_staff_needed' ];
				

				/*
				 * 
				 *JOB ORDER RATES
				 * 
				*/
				

				//SUB CATEGORY NAME
				$new_job_order_rates[ $key ][ 'sub_category_name' ] = $subcategory[ 'sub_category_name' ];
				
				//CATEGORY NAME
				$new_job_order_rates[ $key ][ 'category_name' ] = $category[ 'category_name' ];
				
				//LEVEL
				$new_job_order_rates[ $key ][ 'level' ] = ucwords( $job_order[ 'level' ] );
				
				//NO OF STAFF
				$new_job_order_rates[ $key ][ 'no_of_staff_needed' ] = $job_order[ 'no_of_staff_needed' ];
				
				//CURRENCY
				$new_job_order_rates[ $key ][ 'rate' ] = $this -> _get_rate( $subcategory[ 'sub_category_id' ], $job_role[ 'currency' ], $job_order[ 'level' ], $job_order[ 'work_status' ] );
				

				/*
				 * 
				 *JOB ORDER SUB CATEGORIES
				 * 
				*/
				

				//SUBCATEGORIES
				$job_orders_sub_category[ $key ][ 'subcategories' ] = $this -> _get_subcategories_by_category_id( $category[ 'category_id' ] );
				
				

				UNSET( $subcategory ); //NOT USED
				
				UNSET( $category ); //NOT USED
				

			}
			
			
			//APPEND JOB ORDERS
			$new_job_role[ 'job_orders' ] = $new_job_orders;
			
			//APPEND JOB ORDER RATES
			$new_job_role[ 'job_orders_rate' ] = $new_job_order_rates;
			
			//APPEND JOB ORDER SUBCATEGORY PER CATEGORY
			$new_job_role[ 'job_orders_sub_category' ] = $job_orders_sub_category;
			
			
			//RETURN JOB ROLE
			return $new_job_role;
			
		
		} else {
			
			//REDIRECT TO STEP 1
			header("Location:/portal/custom_get_started/");
			
		}
		
	}
	
	/*
	* 
	* Get Job Order Details
	* 
	* @param $job_role_id => int
	* 
	*/
	private function _get_job_order_details( $job_role_id = 0 ) {
		
		//IF JOB ROLE EXISTS
		if( $job_role_id ) {
			
			//GET INSTANCE
			$db = $this -> db;
			
			//CONSTRUCT JOB ORDERS SQL
			$job_orders_sql = $db -> select()
			
								  -> from( 'gs_job_titles_details' )
								 
								  -> where( 'gs_job_role_selection_id = ?', $job_role_id );
								 
			$job_orders = $db -> fetchAll( $job_orders_sql );
			
			//NEW STORAGE VARIABLE
			$new_job_orders = array();
			
			//RECONSTRUCT JOB ORDERS
			foreach( $job_orders as $key => $job_order ) {

				//APPEND SUBCATEGORY DETAILS
				$new_job_orders[ $key ][ 'subcategory' ] = $this -> _get_subcategory_by_id( $job_order[ 'sub_category_id' ] );
				
				//APPEND CATEGORY DETAILS
				$new_job_orders[ $key ][ 'category' ] = $this -> _get_category_by_id( $new_job_orders[ $key ][ 'subcategory' ][ 'category_id' ] );
				
				//APPEND STAFF PROVIDE TRAINING
				$new_job_orders[ $key ][ 'staff_provide_training' ] = $this -> _get_staff_provide_training( $job_order[ 'gs_job_titles_details_id' ] );

				//APPEND STAFF MAKE CALLS
				$new_job_orders[ $key ][ 'staff_make_calls' ] = $this -> _get_staff_make_calls( $job_order[ 'gs_job_titles_details_id' ] );

				//APPEND STAFF FIRST TIME
				$new_job_orders[ $key ][ 'staff_first_time' ] = $this -> _get_staff_first_time( $job_order[ 'gs_job_titles_details_id' ] );
				
				//APPEND STAFF REPORT DIRECTLY
				$new_job_orders[ $key ][ 'staff_report_directly' ] = $this -> _get_staff_report_directly( $job_order[ 'gs_job_titles_details_id' ] );
				
				//APPEND SPECIAL INSTRUCTION
				$new_job_orders[ $key ][ 'special_instruction' ] = $this -> _get_special_instruction( $job_order[ 'gs_job_titles_details_id' ] );
				
				//APPEND SKILLS
				$new_job_orders[ $key ][ 'skills' ] = $this -> _get_skills( $job_order[ 'gs_job_titles_details_id' ] );
				
				//APPEND TASKS
				$new_job_orders[ $key ][ 'tasks' ] = $this -> _get_tasks( $job_order[ 'gs_job_titles_details_id' ] );

				//APPEND RESPONSIBILITIES
				$new_job_orders[ $key ][ 'responsibilities' ] = $this -> _get_responsibilities( $job_order[ 'gs_job_titles_details_id' ] );

				//APPEND OTHER SKILLS
				$new_job_orders[ $key ][ 'other_skills' ] = $this -> _get_other_skills( $job_order[ 'gs_job_titles_details_id' ] );
				
				//APPEND OTHER DETAILS
				$new_job_orders[ $key ][ 'other_details' ] = $this -> _get_other_details( $job_order[ 'gs_job_titles_details_id' ] );
				
				//APPEND EXISTING JOB ORDER
				$new_job_orders[ $key ][ 'details' ] = $job_order;
				
				//SUBCATEGORY VARIABLE IS NO MORE NEED
				UNSET( $job_order[ 'sub_category_id' ] );
				
			}
			
			return $new_job_orders;
		
		} else {
			
			//REDIRECT TO STEP 2
			header("Location:/portal/custom_get_started/step2.php");
			
		}
		
	}
	
	/*
	* 
	* Get subcategory by id
	* 
	* @param $subcategory_id => int
	* 
	*/
	private function _get_subcategory_by_id( $sub_category_id = 0 ) {
		
		$db = $this -> db;
		
		if( $sub_category_id ) {

			$subcategory_sql = $db -> select()
									
								   -> from( 'job_sub_category' )
								   
								   -> where( 'sub_category_id = ?', $sub_category_id );
								   
			$subcategory = $db -> fetchRow( $subcategory_sql );
			
			return $subcategory;
		
		}
		
	}
	
	/*
	* 
	* Get subcategories
	* 
	*/
	private function _get_subcategories_by_category_id( $category_id = 0 ) {

		if( $category_id ) {
		
			$db = $this -> db;
			
			$subcategories_sql = $db -> select()
									
								   -> from( 'job_sub_category' )
								   
								   -> where( 'category_id =?', $category_id );
								   
			$subcategories = $db -> fetchAll( $subcategories_sql );
			
			$new_subcategories = array();
			
			foreach( $subcategories as $subcategory ) {
				
				$new_subcategories[ $subcategory[ 'sub_category_id' ] ] = $subcategory[ 'sub_category_name' ];
				
			}
			
			return $new_subcategories;
		
		}
		
	}
	
	/*
	* 
	* Get category by id
	* 
	* @param $category_id => int
	* 
	*/
	private function _get_category_by_id( $category_id = 0 ) {
		
		$db = $this -> db;
		
		if( $category_id ) {

			$category_sql = $db -> select()
			
								-> from( 'job_category' )
								
								-> where( 'category_id = ?', $category_id );
								
			$category = $db -> fetchRow( $category_sql );
			
			return $category;
		
		}
		
	}
	
	/*
	* 
	* Get categories
	* 
	*/
	private function _get_categories() { 
		
		$db = $this -> db;
		
		$categories_sql = $db -> select()
		
							  -> from( 'job_category' )
							  
							  -> order( array( 'category_name ASC' ) );
							
		$categories = $db -> fetchAll( $categories_sql );
		
		$new_categories = array();
		
		foreach( $categories as $category ) {
			
			$sub_categories_sql = $db -> select()
			
									  -> from( 'job_sub_category' )
									  
									  -> where( 'category_id = ? AND status = "posted" ', $category[ 'category_id' ] );
									  
			$sub_categories = $db -> fetchAll( $sub_categories_sql );
			
			if( count( $sub_categories ) ) {
			
				$new_categories[ $category[ 'category_id' ] ] = $category[ 'category_name' ];
			
			}
			
		}

		return $new_categories;
		
	}
	
	/*
	* 
	* Get staff provide training details
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_staff_provide_training( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db = $this -> db;
			
			$staff_provide_training_sql = $db -> select()
			
											  -> from( "gs_job_titles_credentials" )
											  
											  -> where( "gs_job_titles_details_id = ?", $job_order_id )
											  
											  -> where( "box = ?", "staff_provide_training" );
			
			$staff_provide_training = $db -> fetchRow( $staff_provide_training_sql );
			
			return $staff_provide_training;
		
		}
		
	}
	
	/*
	* 
	* Get staff make calls details
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_staff_make_calls( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db  = $this -> db;
			
			$staff_make_calls_sql = $db -> select()
			
										-> from( "gs_job_titles_credentials" )
										
										-> where( "gs_job_titles_details_id = ?", $job_order_id )
										
										-> where( "box = ?", "staff_make_calls" );
			
			$staff_make_calls = $db -> fetchRow( $staff_make_calls_sql );
			
			return $staff_make_calls;
			
		}
		
	}
	
	/*
	* 
	* Get staff first time details
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_staff_first_time( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db  = $this -> db;
		
			$staff_first_time_sql = $db -> select() 
			
										-> from( "gs_job_titles_credentials" ) 
										
										-> where( "gs_job_titles_details_id = ?", $job_order_id )
										
										-> where( "box = ?", "staff_first_time" );
			
			$staff_first_time = $db -> fetchRow( $staff_first_time_sql );
			
			return $staff_first_time;
		
		}
	
	}
	
	/*
	* 
	* Get staff report directly details
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_staff_report_directly( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db  = $this -> db;
			
			$database = $this -> database;
			
			$job_specification = $database -> selectCollection( 'job_specifications' );
			
			$staff_report_directly_sql = $db -> select() 
			
											 -> from( "gs_job_titles_credentials" )
											 
											 -> where( "gs_job_titles_details_id = ?", $job_order_id )
											 
											 -> where( "box = ?", "staff_report_directly" );
			
			$staff_report_directly = $db -> fetchRow( $staff_report_directly_sql );
			
			if( $staff_report_directly[ 'description' ] == 'No' ) {
				
				$job_spec = $job_specification -> findOne( array( 'gs_job_titles_details_id' => $job_order_id, 'details.move_like_jagger' => 'step_3' ) );
				
				$staff_report_directly[ 'manager' ][ 'firstname' ] = $job_spec[ 'details' ][ 'manager_first_name' ];
				
				$staff_report_directly[ 'manager' ][ 'lastname' ] = $job_spec[ 'details' ][ 'manager_last_name' ];
				
				$staff_report_directly[ 'manager' ][ 'email' ] = $job_spec[ 'details' ][ 'manager_email' ];
				
				$staff_report_directly[ 'manager' ][ 'contact_no' ] = $job_spec[ 'details' ][ 'manager_contact_number' ];
			
			}
			
			return $staff_report_directly;
			
		}
		
	}
	
	/*
	* 
	* Get special instruction details
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_special_instruction( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db  = $this -> db;
		
			$special_instruction_sql = $db -> select() 
			
										   -> from( "gs_job_titles_credentials" ) 
										   
										   -> where( "gs_job_titles_details_id = ?", $job_order_id )
										   
										   -> where( "box = ?", "special_instruction" );
			
			$special_instruction = $db -> fetchRow( $special_instruction_sql );
			
			return $special_instruction;
		
		}
		
	}
	
	/*
	* 
	* Get skills
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_skills( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db  = $this -> db;
			
			$skills_sql = $db -> select() 
			
							  -> from( "gs_job_titles_credentials" ) 
							   
							  -> where( "gs_job_titles_details_id = ?", $job_order_id )

							  -> where( "box = ?", "skills" );
							  
			$skills = $db -> fetchAll( $skills_sql );
			
			$new_skills = array();
			
			foreach( $skills as $key => $skill ) {
				
				$new_skills[ $key ] = $skill;
				
				$skl_sql = $db -> select() 
								
							   -> from( 'job_position_skills_tasks' ) 
								
							   -> where( 'id = ?', $skill[ 'description' ] );
								 
				$skl = $db -> fetchRow( $skl_sql );
				
				$new_skills[ $key ][ 'skill' ] = $skl;
				
			}
			
			return $new_skills;
			
		}
		
	}
	
	/*
	* 
	* Get tasks
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_tasks( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db  = $this -> db;
			
			$tasks_sql = $db -> select() 
			
							  -> from( 'gs_job_titles_credentials' ) 
							   
							  -> where( 'gs_job_titles_details_id = ?', $job_order_id )

							  -> where( 'box = ?', 'tasks' );
							  
			$tasks = $db -> fetchAll( $tasks_sql );
			
			$new_tasks = array();
			
			foreach( $tasks as $key => $task ) {
				
				$new_tasks[ $key ] = $task;
				
				$tsk_sql = $db -> select() 
				
							   -> from( 'job_position_skills_tasks' ) 

							   -> where( 'id = ?', $task[ 'description' ] );
							   
				$tsk = $db -> fetchRow( $tsk_sql );
						   
				$new_tasks[ $key ][ 'task' ] = $tsk;
				
			}
			
			return $new_tasks;

		}
		
	}
	
	/*
	* 
	* Get responsibilities
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_responsibilities( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			

			$db  = $this -> db;
			
			$responsibilities_sql = $db -> select()
			
									    -> from( "gs_job_titles_credentials" )
									   
									    -> where( "gs_job_titles_details_id = ?", $job_order_id )

									    -> where( "box = ?", "responsibility" );

			$responsibilities = $db -> fetchAll( $responsibilities_sql );
			
			return $responsibilities;
		
		}
		
	}
	
	/*
	* 
	* Get other skills
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_other_skills( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db = $this -> db;
			
			$other_skills_sql = $db -> select() 
			
									-> from( "gs_job_titles_credentials" )
									  
									-> where( 'gs_job_titles_details_id = ?', $job_order_id )
									
									-> where( 'box = ?', "other_skills" );
			  
			$other_skills = $db -> fetchAll( $other_skills_sql );
			
			return $other_skills;
			
		}
		
	}
	
	/*
	* 
	* Get other details
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_other_details( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			$db = $this -> db;
			
			$id_sql = $db -> select() 
			
						  -> from( 'gs_job_titles_credentials', 'gs_job_titles_credentials_id' )
						  
						  -> where( 'gs_job_titles_details_id = ?', $job_order_id )
						
						  -> where( 'box = ?', 'increase_demand' );
			
			$id = $db -> fetchOne( $id_sql );
						  
			$rp_sql = $db -> select() 
			
						  -> from( 'gs_job_titles_credentials', 'gs_job_titles_credentials_id' )
						  
						  -> where( 'gs_job_titles_details_id = ?', $job_order_id )
						
						  -> where( 'box = ?', 'replacement_post' );
						  
			$rp = $db -> fetchOne( $rp_sql );
						  
			$sc_sql = $db -> select() 
			
						  -> from( 'gs_job_titles_credentials', 'gs_job_titles_credentials_id' )
						  
						  -> where( 'gs_job_titles_details_id = ?', $job_order_id )
						
						  -> where( 'box = ?', 'support_current' );
						  
			$sc = $db -> fetchOne( $sc_sql );
						  
			$er_sql = $db -> select() 
			
						  -> from( 'gs_job_titles_credentials', 'gs_job_titles_credentials_id' )
						  
						  -> where( 'gs_job_titles_details_id = ?', $job_order_id )
						
						  -> where( 'box = ?', 'experiment_role' );
			
			$er = $db -> fetchOne( $er_sql );
						  
			$mn_sql = $db -> select() 
			
						  -> from( 'gs_job_titles_credentials', 'gs_job_titles_credentials_id' )
						  
						  -> where( 'gs_job_titles_details_id = ?', $job_order_id )
						
						  -> where( 'box = ?', 'meet_new' );
			
			$mn = $db -> fetchOne( $mn_sql );
			
			$new_other_details = array();

			$new_other_details[ 'increase_demand' ] = ( $id ? 'Yes' : 'No' );
			
			$new_other_details[ 'replacement_post' ] = ( $rp ? 'Yes' : 'No' );
			
			$new_other_details[ 'support_current' ] = ( $sc ? 'Yes' : 'No' );
			
			$new_other_details[ 'experiment_role' ] = ( $er ? 'Yes' : 'No' );
			 
			$new_other_details[ 'meet_new' ] = ( $mn ? 'Yes' : 'No' );

			return $new_other_details;
			
		}
		
	}
	
	/*
	* 
	* Get countries
	* 
	*/
	private function _get_countries() {
		
		$db = $this -> db;
		
		$countries_sql = $db -> select()
		
						     -> from( 'library_country' );

		$countries = $db -> fetchAll( $countries_sql );

		$new_countries = array();
		
		foreach( $countries as $country ) {
			
			$new_countries[ $country[ 'id' ] ] = $country[ 'name' ];
			
		}
		
		return $new_countries;
		
	}

	/*
	* 
	* Get state by country id
	* 
	* @param $country_id => int
	* 
	*/
    private function _get_states_by_country_id( $country_id = 0 ) {
		
		$db = $this -> db;
		
		if( $country_id ) {
			
			$states_sql = $db -> select()
			
							  -> from( 'library_state' ) 
								
							  -> where( 'library_country_id = ?',$country_id );

		} else {
			
			$states_sql = $db -> select()
			
							  -> from( 'library_state' );
			
		}
		
		$states = $db -> fetchAll( $states_sql );

		$new_states = array();
		
		foreach( $states as $state ) {
			
			$new_states[ $state[ 'id' ] ] = $state[ 'name' ];
			
		}
		
		return $new_states;
		
	}

	/*
	* 
	* Get cities by state id
	* 
	* @param $state_id => int
	* 
	*/
    private function _get_cities_by_state_id( $state_id = 0 ) {
		
		$db = $this -> db;
		
		if( $state_id ) {
			
			$cities_sql = $db -> select()
			
							  -> from( 'library_city' )
								
							  -> where( 'library_state_id = ?',$state_id );

		} else {
			
			$cities_sql = $db -> select()
			
							  -> from( 'library_city' );
			
		}
		
		$cities = $db -> fetchAll( $cities_sql );

		$new_cities = array();
		
		foreach( $cities as $city ) {
			
			$new_cities[ $city[ 'id' ] ] = $city[ 'name' ];
			
		}
		
		return $new_cities;
		
	}

	/*
	* 
	* Get rate
	* 
	* @param $job_order_details => array
	* 
	* @param $currency => string
	* 
	*/
	private function _get_rate( $sub_category_id = 0, $currency = 'AUD', $level = 'entry', $work_status = 'Part-Time', $number_format = true ) {
		
		if( $sub_category_id ) {
			
			$db = $this -> db;
			
			//SPECIAL CONDITION IN LEVEL : EXPERT
			if( $level == 'expert' ) {
				
				$level = 'advanced';
				
			}
			
			$sub_category_rate_sql = $db-> select()
			
										-> from( array( 'jscnp' => 'job_sub_categories_new_prices' ), array( 'value', 'currency' ) )
										
										-> joinLeft( array( 'cl' => 'currency_lookup' ), 'jscnp.currency = cl.code', array( 'sign' ) )
										
										-> where( 'sub_category_id = ?', $sub_category_id )
										
										-> where( 'level = ?', $level )
										
										-> where( 'jscnp.currency = ?', $currency )
										
										-> where( 'active = ?', 1 );
										
			
			$sub_category_rate = $db -> fetchRow( $sub_category_rate_sql );
			
			$new_rate = array();
			
			if( $number_format ) {
				
				if ( $sub_category_rate[ "value" ] > 0 ) {
					
					if ( $work_status == "Part-Time" ) { 
						
						$sub_category_rate[ "monthly" ] = number_format( $sub_category_rate[ "value" ] * .6 , 2 );
						
						$sub_category_rate[ "hourly" ] = number_format( ( ( ( $sub_category_rate[ "value" ] * 12 ) / 52 ) / 5 ) / 4, 2 );
						
					} else {

						$sub_category_rate[ "monthly" ] = number_format( $sub_category_rate[ "value" ], 2 );
						
						$sub_category_rate[ "hourly" ] = number_format( ( ( ( $sub_category_rate[ "value" ] * 12 ) / 52 ) / 5 ) / 8, 2 );
						
					}
					
				} else {
					
					$sub_category_rate[ "monthly" ] = false;
					
					$sub_category_rate[ "hourly" ] = false;
					
				}
				
			} else {
				
				if ( $sub_category_rate[ "value" ] > 0 ) {
					
					if ( $work_status == "Part-Time" ) { 
						
						$sub_category_rate[ "monthly" ] = $sub_category_rate[ "value" ] * .6;
						
						$sub_category_rate[ "hourly" ] = ( ( ( $sub_category_rate[ "value" ] * 12 ) / 52 ) / 5 ) / 4;
						
					} else {

						$sub_category_rate[ "monthly" ] = $sub_category_rate[ "value" ];
						
						$sub_category_rate[ "hourly" ] =  ( ( ( $sub_category_rate[ "value" ] * 12 ) / 52 ) / 5 ) / 8;
						
					}
					
				} else {
					
					$sub_category_rate[ "monthly" ] = false;
					
					$sub_category_rate[ "hourly" ] = false;
					
				}
				
			}
			return $sub_category_rate;
			
		}
		
	}
	
	/*
	* 
	* Get job order by id
	* 
	* @param $job_order_id => int
	* 
	*/
	private function _get_job_order_by_id( $job_order_id = 0 ) {
		
		if( $job_order_id ) {
			
			//GET DB INSTANCE
			$db = $this -> db;
			
			//JOB SPEC SQL
			$job_spec_sql = $db -> select()
			
								-> from( 'gs_job_titles_details' )
							   
								-> where( 'gs_job_titles_details_id = ?', $job_order_id );

			//JOB SPEC
			$job_spec = $db -> fetchRow( $job_spec_sql );
			
			return $job_spec;
			
		}
		
	}
	
	/*
	* 
	* Get all timezone
	* 
	* @param void
	* 
	*/
	private function _get_all_timezone() {
		
		$db = $this -> db;
		
		$timezones_sql = $db -> select() 

							 -> from( 'timezone_lookup' ) 

							 -> order( array( 'timezone ASC' ) );
							 
		$timezones = $db -> fetchAll( $timezones_sql );
		
		return $timezones;

	}
	
	/*
	* 
	* Get shift times
	* 
	* @param void
	* 
	*/
	private function _get_all_shift_time() {
		
		$shift_times = array();
		
		$shift_times[] = array( "value" => "00:00", "label" => "12:00 AM" );
		
		$shift_times[] = array( "value" => "00:30", "label" => "12:30 AM" );
		
		for ( $i = 1; $i <= 9; $i++ ) {
			
			$shift_times[] = array( "value" => "0{$i}:00", "label" => "0{$i}:00 AM" );
			
			$shift_times[] = array( "value" => "0{$i}:30", "label" => "0{$i}:30 AM" );
			
		}
		
		for ( $i = 10; $i <= 11; $i++ ) {
			
			$shift_times[] = array( "value" => $i . ":00", "label" => $i . ":00 AM" );
			
			$shift_times[] = array( "value" => $i . ":30", "label" => $i . ":30 AM" );
			
		}
		
		$i = 12;
		
		$shift_times[] = array( "value" => $i . ":00", "label" => $i . ":00 PM" );
		
		$shift_times[] = array( "value" => $i . ":30", "label" => $i . ":30 PM" );
		
	
		for ( $i = 1; $i <= 9; $i++ ) {
			
			$k = $i + 12;
			
			$shift_times[] = array( "value" => "{$k}:00", "label" => "0{$i}:00 PM" );
			
			$shift_times[] = array( "value" => "{$k}:30", "label" => "0{$i}:30 PM" );
			
		}
		
		for ( $i = 10; $i <= 11; $i++ ) {
			
			$k = $i + 12;
			
			$shift_times[] = array( "value" => "{$k}:00", "label" => "{$i}:00 PM" );
			
			$shift_times[] = array( "value" => "{$k}:30", "label" => "{$i}:30 PM" );
			
		}
		
		return $shift_times;
		
	}
	
	/*
	* 
	* Get all working status
	* 
	* @param void
	* 
	*/
	private function _get_all_working_status() {
	
		$working_status = array();
		
		$working_status[] = array( "value" => "Full-Time", "label" => "Full Time 9hours with 1hour break" );
		
		$working_status[] = array( "value" => "Part-Time", "label" => "Part Time 4hours" );
		
		return $working_status;
	
	}
	
	/*
	* 
	* Update mongodb record
	* 
	* @param job_role_id => int
	* 
	* @param $job_order_id => int
	* 
	*/
	private function update_mongodb_record( $job_role_id = 0, $job_order_id = 0 ) {
		
		//GET DB INSTANCE
		$db = $this -> db;
		
		//GET MONGO INSTANCE
		$database = $this -> database;
		
		//SELECT COLLECTION
		$job_specification_preview = $database -> selectCollection( 'job_specification_preview' );
		

		//JOB SPEC
		$job_spec = $this -> _get_job_order_by_id( $job_order_id );
		

		//APPEND LEADS
		$job_spec[ 'leads' ] = $this -> _get_lead_details();
		
		//APPEND JOB ROLE SELECTION IN JOB SPEC
		$job_spec[ 'job_role_selection' ] = $this -> _get_job_role_details( $job_spec[ 'leads' ][ 'leads_id' ] );
		
		//APPEND STAFF PROVIDE TRAINING
		$job_spec[ 'staff_provide_training' ] = $this -> _get_staff_provide_training( $job_order_id );
		
		//APPEND STAFF MAKE CALLS
		$job_spec[ 'staff_make_calls' ] = $this -> _get_staff_make_calls( $job_order_id );
		
		//APPEND STAFF FIRST TIME
		$job_spec[ 'staff_first_time' ] = $this -> _get_staff_first_time( $job_order_id );
		
		//APPEND STAFF REPORT DIRECTLY
		$job_spec[ 'staff_report_directly' ] = $this -> _get_staff_report_directly( $job_order_id );
		
		//APPEND SPECIAL INSTRUCTION
		$job_spec[ 'special_instruction' ] =  $this -> _get_special_instruction( $job_order_id );
		
		//APPEND SKILLS
		$job_spec[ 'skills' ] = $this -> _get_skills( $job_order_id );
		
		//APPEND TASKS
		$job_spec[ 'tasks' ] = $this -> _get_tasks( $job_order_id );
		
		//APPEND RESPONSIBILITY
		$job_spec[ 'responsibilities' ] = $this -> _get_responsibilities( $job_order_id );
		
		//APPEND OTHER SKILLS
		$job_spec[ 'other_skills' ] = $this -> _get_other_skills( $job_order_id );
		
		//APPEND OTHER DETAILS
		$job_spec[ 'other_details' ] = $this -> _get_other_details( $job_order_id );
		
		//APPEND PRICE
		$rate = $this -> _get_rate( $job_spec[ 'sub_category_id' ], $job_spec[ 'job_role_selection' ][ 'details' ][ 'currency' ], $job_spec[ 'level' ], $job_spec[ 'work_status' ], false );

		$job_spec[ 'price' ] = $rate[ 'monthly' ];
		
		//DELETE MONGODB JOB SPEC
		$job_specification_preview -> remove( array( 'gs_job_titles_details_id' => "{$job_order_id}", 'gs_job_role_selection_id' => "{$job_role_id}" ) );
		
		//INSERT MONGODB JOB SPEC
		$job_specification_preview -> insert( $job_spec ); 
		
	}

}
