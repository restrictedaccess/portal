<?php

include('conf/zend_smarty_conf.php');

if( $_SESSION['client_id'] == "" or $_SESSION['client_id'] == NULL ){

	header( "location:index.php" );
	
}

$leads_id = $_SESSION['client_id'];

include ('./leads_information/AdminBPActionHistoryToLeads.php');

$retries = 0;
while(true){
	try{
		
		if ( TEST ) {
			
			$mongo = new MongoClient( MONGODB_TEST );
			
			$job_orders = $mongo->selectDB( 'prod' )->selectCollection( 'job_orders' );
		
		} else {
			
			$mongo = new MongoClient( MONGODB_SERVER );
			
			$job_orders = $mongo->selectDB( 'prod' )->selectCollection( 'job_orders' );
			
		}
		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}



$all_job_orders = $job_orders -> find( array( 'leads_id' => ( int ) $leads_id ) );

$new_job_orders = array();

foreach( $all_job_orders as $key => $job_order ) {
	
	$new_job_orders[ $key ][ 'id' ] = $db->fetchOne( $db->select()->from( array( 'g' => 'gs_job_titles_details' ), array( 'gs_job_titles_details_id' ) )->where( 'g.gs_job_role_selection_id = ?', $job_order[ 'gs_job_role_selection_id' ] )->order( 'g.gs_job_titles_details_id DESC' ) );
	
	$new_job_orders[ $key ][ 'date_created' ] = date( 'F d, Y', $job_order[ 'date_filled_up' ]->sec ); 
	
	$new_job_orders[ $key ][ 'job_title' ] =  ucwords( $job_order[ 'level' ] ) . ' ' . ucwords( $job_order[ 'job_title' ] );
	
	$new_job_orders[ $key ][ 'status' ] = ucwords( $job_order[ 'status' ] );
	
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Client Home</title>

<link type="text/css" href="/portal/site_media/client_portal/css/bootstrap.css" rel="stylesheet">
<link type="text/css" href="css/font.css" rel="stylesheet">
<link type="text/css" href="menu.css" rel="stylesheet">
<link type="text/css" href="css/style.css" rel="stylesheet">
<link type="text/css" href="css/overlay.css" rel="stylesheet">
<link type="text/css" href='get_started/media/css/get_started.css' rel="stylesheet">

<script type="text/javascript" src="/portal/site_media/client_portal/js/jquery.min.js"></script>
<script type="text/javascript" src="/portal/site_media/client_portal/js/bootstrap.js"></script>
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src='get_started/media/js/get_started.js'></script>
<script type="text/javascript" src='js/functions.js'></script>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
	
	<?php if ( $_REQUEST["page_type"]!="iframe" ): ?>

		<?php include 'header.php';?>
		
		<?php include 'client_top_menu.php';?>
		
	<?php endif; ?>

	<table class="table">
		
		<tbody>

			<tr>

				<?php if ( $_REQUEST["page_type"]!="iframe" ): ?>

					<td style="border-right: #006699 2px solid; width: 170px; vertical-align:top;"> <?php include 'clientleftnav.php';?> </td>

				<?php endif; ?>

				<td valign="top">

					<table class="table table-striped table-condensed">
					
						<thead>
							
							<tr> <th colspan="4"> <h3> Recruitment Order <a href="/portal/custom_get_started/step2_leads.php?from=portal" target="_blank" class="btn btn-primary btn-sm pull-right"> <i class="glyphicon glyphicon-briefcase"></i> Post a New Job Ad </a> </h3> </th> </tr>
							
							<tr> <th class="text-center"> # </th> <th class="text-center"> Order Date </th> <th class="text-center"> Job Position </th> <th class="text-center"> Status </th>  </tr>
							
						</thead>

						<tbody>
						
							<?php $x = 1; ?>
							
							<?php foreach( $new_job_orders as $job_order ): ?>
							
								<tr>
									
									<td class="text-center"> <?php echo $x; ?> </td> 
									
									<td class="text-center"> <?php echo $job_order[ 'date_created' ]; ?> </td> 
									
									<td class="text-center"> <a href="#" id="<?php echo $job_order['id']; ?>" class="recruitment_order" style="color:#000000;"> <?php echo $job_order[ 'job_title' ]; ?> </a> </td> 
									
									<td class="text-center"> <?php echo $job_order[ 'status' ]; ?> </td> 

								</tr>
								
								<?php $x++; ?>
							
							<?php endforeach; ?>
						
						</tbody>
					
					</table>
				 
				 </td>
			 
			 </tr>
			 
		 </tbody>
	 
	 </table>
 
	<script type="text/javascript">
		
		var items = getElementsByTagAndClassName( 'a', 'recruitment_order', parent=document );

		for ( var item in items ) {
			
			connect ( items[ item ], 'onclick', OnClickShowClientOrder );
			
		}

	</script>

</body>

</html>
