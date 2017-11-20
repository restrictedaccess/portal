<?php

include('../conf/zend_smarty_conf.php');

if ( ! isset( $_SESSION[ "admin_id" ] ) ) {

	die;
	
}

try {

	if( isset( $_POST[ "result_id" ] ) && isset( $_POST[ "result_selected" ] ) ) {
		
		$result_id = $_POST[ 'result_id' ];
		
		$result_selected = $_POST[ 'result_selected' ];

		$db->update( "assessment_results", array( 'result_selected' => $result_selected ), "result_id = " . $result_id );
		
		echo json_encode ( array( 'response' => true ) );
	
	} else {
		
		echo json_encode ( array( 'response' => false ) );
	
	}

} catch( Exception $e ){

	die( $e->getMessage );

}
