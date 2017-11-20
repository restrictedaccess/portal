<?php

/**
 * Component for handling History Functions
 * 
 * @author Allan Joseph Pedernal
 * 
 * @copyright Remote Staff Inc.
 * @method void GenerateAdsHistory()
 * @method string getFieldName()
 * @method string getFieldValue()
 * 
 */
class GenerateHistory {
	
    /**
     * Method for generating new ads history
     *
     * @param int $posting_id - Id of the posting table
     * @param int $change_by_id - Id of current logged in user
     * @param string $change_by_type - Type of current logged in user
     * @return int
     */
	public static function ConvertToAds( $posting_id = 0, $action = 'new', $change_by_id = 0, $change_by_type = '' ) {

		global $db;
		
		$posting = array();
		
		$history_changes = 'Job Order converted into Job Advertisement';
		
		//GET POSTING VALUE
		$posting_sql = $db -> select()

					-> from( 'posting' ) 

					-> where( 'id = ?', $posting_id );
		
		$posting = $db -> fetchRow( $posting_sql );
		
		//COMPOSE CHANGES ARRAY
		$changes = array(
		
			 'posting_id' 		=> $posting_id,

			 'date_change' 		=> date( 'Y-m-d H:i:s' ),
			 
			 'changes'		 	=> $history_changes,
			 
			 'change_by_id' 	=> $change_by_id,
			 
			 'change_by_type' 	=> $change_by_type
				 
		);
		
		//SAVE POSTING HISTORY	 
		$db -> insert( 'posting_history', $changes );
		
		//GET LAST POSTING HISTORY ID
		$posting_history_id = $db -> lastInsertId();
		
		//CHECK IF THERE IS POSTING HISTORY ID
		if( $posting_history_id ) {
			
			return $posting_history_id;
			
		} else {
			
			return 0;
			
		}
	
	}
	
    /**
     * Method for generating convert to ads history
     *
     * @param array $new_posting_data - The new posting data values
     * @param int $posting_id - Id of the posting table
     * @param int $change_by_id - Id of current logged in user
     * @param string $change_by_type - Type of current logged in user
     * @return int
     */
	public static function ConvertToAdsUpdateContent( $new_posting = array(), $posting_id = 0, $change_by_id = 0, $change_by_type = '' ) {

		global $db;
		
		$posting = array();
		
		$history_changes = 'Update Convert to Ads Content <br>';

		//CHECK POSTING ID IF EXIST
		if( $posting_id ) {
			
			//GET POSTING VALUE
			$posting_sql = $db -> select()

						-> from( 'posting' ) 

						-> where( 'id = ?', $posting_id );
			
			$posting = $db -> fetchRow( $posting_sql );

		}
		
		//CHECK DIFFERENCE OF NEW POSTING WITH OLD POSTING
		$new_posting_difference = array_diff_assoc( $new_posting, $posting );
		
		if( count( $new_posting_difference ) > 0 ) {

			//LOOP ALL NEW POSTING DIFFERENCE
			foreach( array_keys( $new_posting_difference ) as $field_name ) {
				
				//GET FIELD NAME IN TABLE IF EXSITS
				$field_name = self::getFieldName( $field_name, 'posting' );
				
				//GET OLD POSTING VALUES
				$posting_field_value = ( $posting_id ? self::getFieldValue( $field_name , $posting[ $field_name ] ) : '' );
				
				//GET NEW POSTING VALUES
				$new_posting_difference_field_value = self::getFieldValue( $field_name , $new_posting_difference[ $field_name ] );
				
				if( $posting_id == 0 ) {
					
					//CREATE HISTORY CHANGES
					$history_changes .= sprintf(
					
						"%s => %s <br>",
						
						ucwords( str_replace( '_', ' ', str_replace( '_id', '', $field_name ) ) ),

						$new_posting_difference_field_value
					
					);
					
				} else {
					
					//CREATE HISTORY CHANGES
					$history_changes .= sprintf(
					
						"%s => <b> From: </b> %s <b> To: </b> %s <br>",
						
						ucwords( str_replace( '_', ' ', str_replace( '_id', '', $field_name ) ) ),
						
						$posting_field_value, 
						
						$new_posting_difference_field_value
					
					);
				
				}
			
			}
			
                        
			//CHECK HISTORY CHANGES
			if( $history_changes != '' ) {
				
				//COMPOSE CHANGES ARRAY
				$changes = array(
				
						 'posting_id' 		=> $posting_id,
			
						 'date_change' 		=> date( 'Y-m-d H:i:s' ),
						 
						 'changes'		 	=> $history_changes,
						 
						 'change_by_id' 	=> $change_by_id,
						 
						 'change_by_type' 	=> $change_by_type
							 
					);
				
				//SAVE POSTING HISTORY	 
				$db -> insert( 'posting_history', $changes );
				
				//GET LAST POSTING HISTORY ID
				$posting_history_id = $db -> lastInsertId();
				
			}
				 
		}
		
			
		//CHECK IF THERE IS POSTING HISTORY ID
		if( $posting_history_id ) {
			
			return $posting_history_id;
			
		} else {
			
			return 0;
			
		}
	
	}
	
	public static function ConvertToAdsUpdateRequirement( $new_posting_requirement = array(), $posting_requirement_id = 0 ) {
		
		global $db;
		
		$posting_requirement = array();
		
		$history_changes = '';

		//CHECK POSTING ID IF EXIST
		if( $posting_requirement_id ) {
			
			//GET POSTING REQUIREMENT VALUE
			$posting_requirement_sql = $db -> select()

						-> from( 'posting_requirement' ) 

						-> where( 'id = ?', $posting_requirement_id );
			
			$posting_requirement = $db -> fetchRow( $posting_requirement_sql );

		}
		
		//CHECK DIFFERENCE OF NEW POSTING WITH OLD POSTING
		$new_posting_requirement_difference = array_diff_assoc( $new_posting_requirement, $posting_requirement );
		
		if( count( $new_posting_requirement_difference ) > 0 ) {

			//LOOP ALL NEW POSTING DIFFERENCE
			foreach( array_keys( $new_posting_requirement_difference ) as $field_name ) {
				
				//GET FIELD NAME IN TABLE IF EXSITS
				$field_name = self::getFieldName( $field_name, 'posting_requirement' );
				
				//GET OLD POSTING VALUES
				$posting_requirement_field_value = ( $posting_requirement_id ? self::getFieldValue( $field_name , $posting_requirement[ $field_name ] ) : '' );
				
				//GET NEW POSTING VALUES
				$new_posting_requirement_difference_field_value = self::getFieldValue( $field_name , $new_posting_requirement_difference[ $field_name ] );
				
				if( $posting_requirement_id == 0 ) {
					
					//CREATE HISTORY CHANGES
					if( $field_name == 'requirement' ) {
						
						$history_changes .= sprintf(
						
							"Requirement => %s has been added <br>",

							$new_posting_requirement_difference_field_value
						
						);
						
					}
					
				} else {
					
					//CREATE HISTORY CHANGES
					if( $field_name == 'requirement' ) {

						$history_changes .= sprintf(
						
							"%s => <b> From: </b> %s <b> To: </b> %s <br>",

							ucwords( str_replace( '_', ' ', str_replace( '_id', '', $field_name ) ) ),

							$posting_requirement_field_value, 

							$new_posting_requirement_difference_field_value

						);

					}
				
				}
			
			}
			
			//CHECK HISTORY CHANGES
			if( $history_changes != '' ) {
				
				return $history_changes;
				
			}

		}
		
		return;
			
	}
	
	public static function ConvertToAdsUpdateResponsibility( $new_posting_responsibility = array(), $posting_responsibility_id = 0 ) {
		
		global $db;
		
		$posting_responsibility = array();
		
		$history_changes = '';

		//CHECK POSTING ID IF EXIST
		if( $posting_responsibility_id ) {
			
			//GET POSTING RESPONSIBILITY VALUE
			$posting_responsibility_sql = $db -> select()

						-> from( 'posting_responsibility' ) 

						-> where( 'id = ?', $posting_responsibility_id );
			
			$posting_responsibility = $db -> fetchRow( $posting_responsibility_sql );

		}
		
		//CHECK DIFFERENCE OF NEW POSTING WITH OLD POSTING
		$new_posting_responsibility_difference = array_diff_assoc( $new_posting_responsibility, $posting_responsibility );
		
		if( count( $new_posting_responsibility_difference ) > 0 ) {

			//LOOP ALL NEW POSTING DIFFERENCE
			foreach( array_keys( $new_posting_responsibility_difference ) as $field_name ) {
				
				//GET FIELD NAME IN TABLE IF EXSITS
				$field_name = self::getFieldName( $field_name, 'posting_responsibility' );
				
				//GET OLD POSTING VALUES
				$posting_responsibility_field_value = ( $posting_responsibility_id ? self::getFieldValue( $field_name , $posting_responsibility[ $field_name ] ) : '' );
				
				//GET NEW POSTING VALUES
				$new_posting_responsibility_difference_field_value = self::getFieldValue( $field_name , $new_posting_responsibility_difference[ $field_name ] );
				
				if( $posting_responsibility_id == 0 ) {
					
					//CREATE HISTORY CHANGES
					if( $field_name == 'responsibility' ) {
						
						$history_changes .= sprintf(
						
							"Responsbility => %s has been added <br>",

							$new_posting_responsibility_difference_field_value
						
						);
					
					}
					
				} else {
					
					//CREATE HISTORY CHANGES
					if( $field_name == 'responsibility' ) {
						
						$history_changes .= sprintf(
						
							"%s => <b> From: </b> %s <b> To: </b> %s <br>",
							
							ucwords( str_replace( '_', ' ', str_replace( '_id', '', $field_name ) ) ),
							
							$posting_responsibility_field_value, 
							
							$new_posting_responsibility_difference_field_value
						
						);
					
					}
				
				}
			
			}
			
			//CHECK HISTORY CHANGES
			if( $history_changes != '' ) {
				
				return $history_changes;
				
			}

		}
		
		return;
		
	}
	
	public static function updateCurrentHistoryChanges( $posting_history_id = 0, $changes = '', $posting_id = 0, $change_by_id = 0, $change_by_type = '' ) {
		
		global $db;
		
		if( $posting_history_id ) {
			
			$db -> update( 'posting_history', array( 'changes' => $changes ), $db -> quoteInto( 'id = ?', $posting_history_id ) );
		
		} else {
			
			//COMPOSE CHANGES ARRAY
			$changes = array(

				 'posting_id' 		=> $posting_id,

				 'date_change' 		=> date( 'Y-m-d H:i:s' ),

				 'changes'		 	=> $changes,

				 'change_by_id' 	=> $change_by_id,

				 'change_by_type' 	=> $change_by_type
					 
			);

			$db -> insert( 'posting_history', $changes );
			
			$posting_history_id = $db -> lastInsertId();

		}
		
		return $posting_history_id;
		
	}
	
	public static function getCurrentHistory( $posting_history_id = 0 ) {
		
		global $db;
		
		if( $posting_history_id ) {
			
			$posting_history_sql = $db -> select()
			
										-> from( 'posting_history', 'changes' )
										
										-> where( 'id = ?', $posting_history_id )
										
										-> order( 'id DESC' );
										
			$last_posting_history = $db -> fetchOne( $posting_history_sql );
			
			return $last_posting_history . '<br>' ;
			
		}
		
		return;
		
	}
	
	//PRIVATE FUNCTION TO GET FIELD NAME
	public static function getFieldName( $field_name = '', $table_name = '' ) {
		
		global $db;
		
		//CHECK IF FIELDNAME AND TABLE NAME IS NOT EMPTY
		if( $field_name != '' && $table_name != '' ) {
			
			$metadata = $db -> describeTable( $table_name );

			$columnNames = array_keys( $metadata );

			if( in_array( $field_name, $columnNames ) ) {
				
				return $field_name;
				
			}
			
			return;
		
		}
		
		return;

	}
	
	// PRIVATE FUNCTION TO GET FIELD VALUE
	public static function getFieldValue( $field_name = '', $value = '' ) {
		
		global $db;
		
		$new_value = '';
		
		if( $field_name == 'agent_id' && ! empty( $value ) && $value != '' ) {
			
			$agent_sql = $db -> select()
						
							 -> from( 'agent' )
						 
						     -> where( 'agent_no = ?', $value );
				 
			$agent = $db -> fetchRow( $agent_sql );

			$new_value =  "#" . $agent[ 'agent_no' ] . " " . $agent[ 'fname' ] . " " . $agent[ 'lname' ];
		
		} else if( $field_name == 'lead_id' && ! empty( $value ) && $value != '' ) {

			$leads_sql = $db -> select()
						
							 -> from( 'leads' )
						 
						     -> where( 'id = ?', $value );
				 
			$leads = $db -> fetchRow( $leads_sql );

			$new_value =  "#" . $leads[ 'id' ] . " " . $leads[ 'fname' ] . " " . $leads[ 'lname' ];

		} else if( $field_name == 'category_id' && ! empty( $value ) && $value != '' ) {
			
			$job_category_sql = $db -> select()
							
									-> from( 'job_category' , 'category_name' )
									
									-> where( 'category_id = ?' , $value );
				
			$job_category_name = $db -> fetchOne( $job_category_sql );
			
			$new_value = $job_category_name;
			
		} else if( $field_name == 'sub_category_id' && ! empty( $value ) && $value != '' ) {
			
			$job_category_sql = $db -> select()
							
									-> from( 'job_category' , 'category_name' )
									
									-> where( 'category_id = ?' , $value );
									
			$job_sub_category_sql = $db->select()
			
									-> from( 'job_sub_category', 'sub_category_name' )
									
									-> where( 'sub_category_id = ?', $value );
									
			$job_sub_category = $db -> fetchOne( $job_sub_category_sql );
			
			$new_value = $job_sub_category;
			
		} else {

			$new_value = $value;

		}
		
		return $new_value;

	}
	
}
