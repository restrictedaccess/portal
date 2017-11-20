<?php

require( 'classes/php-export-data.class.php' );

require_once dirname(__FILE__)."../../../lib/Portal.php";

class UnprocessedStaff extends Portal {

    private $exporter;
    
    public function render() {
		
		//PAULO ADMIN IDS
		$paulo_admin_ids = array( 43, 131 , 201, 257 );
		
		if( ! in_array( $_SESSION[ 'admin_id' ], $paulo_admin_ids ) ) {
			
			echo "Get Lost!";
			
			echo "<br>";
			
			echo 'Only paulo can extract uncprocessed staff!';
			
			die;
			
		}

		//GET DATABASE CONNECTION
		$db = $this -> db;

		//GET REQUEST PARAMETERS
		$start_date = $_REQUEST[ 'start_date' ];
		
		$end_date = $_REQUEST[ 'end_date' ];
		
		//FILTER REQUIRED PARAMETERS
		if( empty( $start_date ) ) {
			
			echo "Start Date is missing!";
			
			die;
			
		} else if( empty( $end_date ) ) {
			
			echo "End Date is missing!";
			
			die;
			
		}
		
		//SET FIRST PAGE
		$page = 1;
		
		//SET NEW UNPROCESS STAFF CONTAINER
		$new_unprocess_staff = array();
		
		//GET ALL UNPROCESS STAFF PER PAGE
		while( true ) {

			$unprocess_staffs_sql = $db -> select()
			
										-> from ( array( 'us' => 'unprocessed_staff' ), array() )
										
										-> joinLeft( array( 'p' => 'personal' ), 'us.userid = p.userid', array( 'p.fname', 'p.middle_name', 'p.lname', 'p.email', 'p.datecreated' ) )
		
										-> where( 'DATE(p.datecreated)>="'.$start_date.'" AND DATE(p.datecreated)<="'.$end_date.'" ' )
										
										-> limitPage( $page, 100 );
			
			$unprocess_staffs = $db -> fetchAll( $unprocess_staffs_sql );
			
			if ( empty( $unprocess_staffs ) ) {
				
				break;
				
			}

			$page += 1;
			
			$new_unprocess_staff = array_merge( $new_unprocess_staff, $unprocess_staffs );
			
		}
		
		//CREATE NEW INSTANCE
		$this -> exporter = new ExportDataExcel( 'browser', 'unprocessed_staff.xls' );

		// starts streaming data to web browser
		$this -> exporter ->initialize();
		
		// doesn't care how many columns you give it
		foreach( $new_unprocess_staff as $key => $unprocess_staff ) {
			
			$this -> exporter -> addRow( array( $key + 1, $unprocess_staff[ 'fname' ] . ' ' . $unprocess_staff[ 'lname' ], $unprocess_staff[ 'email' ] ) );
		
		}
		
		// writes the footer, flushes remaining data to browser.
		$this -> exporter ->finalize();
		
		// all done
		exit();

    }

}
