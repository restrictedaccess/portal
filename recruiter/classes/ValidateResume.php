<?php

require_once dirname(__FILE__)."/../../lib/Portal.php";

class ValidateResume extends Portal {

	public function render() {
	
		$userid = $_POST[ 'userid' ];
	
		$db = $this -> db;
		
		//CHECK PERSONAL TABLE
		$personal_sql = $db -> select()
		
							  -> from( 'personal', array( 'fname', 'lname', 'byear', 'bmonth', 'bday', 'gender', 'home_working_environment', 'internet_connection', 'computer_hardware', 'headset_quality' ) )
							  
							  -> where( 'userid=?', $userid );
				  
		$personal = $db -> fetchRow( $personal_sql );
		
		
		$error = false;
		
		$error_message = array();

		
		if( $personal[ 'fname' ] == '' || empty( $personal[ 'fname' ] ) ) {
			
			$error_message['personal_information']['fname'] = '\xa0\xa0\xa0\xa0\xa0\u2022 firstname! \n';
			
			$error = true;
			
		}
		
		if( $personal[ 'lname' ] == '' || empty( $personal[ 'lname' ] ) ) {
			
			$error_message['personal_information']['lname'] = '\xa0\xa0\xa0\xa0\xa0\u2022 lastname! \n';
			
			$error = true;
			
		}
		
		
		
		$error_bday = false;
		
		if( $personal[ 'byear' ] == '' || empty( $personal[ 'byear' ] ) ) {
			
			$error = true;
			
			$error_bday = true;
		}
		
		if( $personal[ 'bmonth' ] == '' || empty( $personal[ 'bmonth' ] ) ) {
			
			$error = true;
			
			$error_bday = true;
			
		}
		
		if( $personal[ 'bday' ] == '' || empty( $personal[ 'bday' ] ) ) {
				
			$error = true;
			
			$error_bday = true;
			
		}

		if( $error_bday ) {
			
			$error_message['personal_information']['birthday'] = '\xa0\xa0\xa0\xa0\xa0\u2022 date of birth! \n';
			
		}
		
		
		
		if( $personal[ 'gender' ] == '' || empty( $personal[ 'gender' ] ) ) {
			
			$error_message['personal_information']['gender'] = '\xa0\xa0\xa0\xa0\xa0\u2022 gender! \n';
			
			$error = true;
			
		}

		/*
		if( $personal[ 'home_working_environment' ] == '' || empty( $personal[ 'home_working_environment' ] ) ) {
			
			$error_message['working_capabilities']['home_working_environment'] .= '\xa0\xa0\xa0\xa0\xa0\u2022 home working environment! \n';
			
			$error = true;
			
		}
		
		if( $personal[ 'internet_connection' ] == '' || empty( $personal[ 'internet_connection' ] ) ) {
			
			$error_message['working_capabilities']['internet_connection'] .= '\xa0\xa0\xa0\xa0\xa0\u2022 internet connection! \n';
			
			$error = true;
			
		}
		
		if( $personal[ 'computer_hardware' ] == '' || empty( $personal[ 'computer_hardware' ] ) ) {
			
			$error_message['working_capabilities']['computer_hardware'] .= '\xa0\xa0\xa0\xa0\xa0\u2022 computer hardware! \n';
			
			$error = true;
			
		}
		
		if( $personal[ 'headset_quality' ] == '' || empty( $personal[ 'headset_quality' ] ) ) {
			
			$error_message['working_capabilities']['headset_quality'] .= '\xa0\xa0\xa0\xa0\xa0\u2022 headset quality! \n';
			
			$error = true;
			
		}
		*/


		$new_error_message = '';
		
		$section = '';


		//ERROR MESSAGE EXIST
		if( count( $error_message ) ) {
			
			//PERSONAL INFORMATION ERROR MESSAGE EXIST
			if( count( $error_message[ 'personal_information' ] ) ) {
				
				$section = 'personal_information';
				
				$new_error_message .= 'PERSONAL INFORMATION \n';
				
				$new_error_message .= '\n Please fill up the following:\n';
				
				foreach( $error_message[ 'personal_information' ] as $type => $message ) {
					
					$new_error_message .= $message;
					
				}
				
			}
			
			/*
			//WORKING CAPABILITIES
			if( count( $error_message[ 'working_capabilities' ] ) ) {
				
				if( count( $error_message[ 'personal_information' ] ) ){
					
					$new_error_message .= "\n\n";
					
				}
				
				$section = 'working_capabilities';
				
				$new_error_message .= 'WORKING CAPABILITIES \n';
				
				$new_error_message .= '\n Please fill up the following:\n';
				
				foreach( $error_message[ 'working_capabilities' ] as $type => $message ) {
					
					$new_error_message .= $message;
					
				}
				
			}
			*/
			
			
		}
		
		echo json_encode( array( 'success' => $error, 'section' => $section, 'error_message' => $new_error_message ) ); 
		
		exit;
		
	}
	
}
