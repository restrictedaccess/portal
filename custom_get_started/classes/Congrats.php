<?php
require_once dirname(__FILE__) . "/../../lib/CheckLeadsFullName.php";
require_once dirname(__FILE__) . "/../../lib/addLeadsInfoHistoryChanges.php";
require_once dirname(__FILE__) . "/../../tools/CouchDBMailbox.php";
require_once dirname(__FILE__) . "/../../jobseeker/classes/QQFileUploader.php";
require_once dirname(__FILE__) . "/../lib/get_started_function.php";
include_once dirname(__FILE__)."/location_constants.php";
require_once dirname(__FILE__). "/../../lib/Contact.php";
require_once dirname(__FILE__). "/ShowPrice.php";

function configurePriceRate($jr_list_id, $level, $work_status, $currency_lookup_id) {
	global $db;
	$query = "SELECT * FROM job_role_cat_list WHERE jr_list_id = $jr_list_id;";
	$result = $db -> fetchRow($query);
	$jr_status = $result['jr_status'];
	$jr_entry_price = $result['jr_entry_price'];
	$jr_mid_price = $result['jr_mid_price'];
	$jr_expert_price = $result['jr_expert_price'];

	if ($currency_lookup_id != "") {
		$sql = $db -> select() -> from('currency_lookup') -> where('id = ?', $currency_lookup_id);
		$currency_lookup = $db -> fetchRow($sql);
		$currency = $currency_lookup['code'];
		$currency_symbol = $currency_lookup['sign'];
	}

	if ($jr_status == "system") {

		if ($level == "entry") {
			if ($work_status == "Full-Time") {
				$selected_job_title_price = $result['jr_entry_price'];
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 8), 2, ".", ",");
			} else {
				$selected_job_title_price = ($result['jr_entry_price'] * .55);
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 4), 2, ".", ",");
			}
		}

		if ($level == "mid") {
			if ($work_status == "Full-Time") {
				$selected_job_title_price = $result['jr_mid_price'];
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 8), 2, ".", ",");
			} else {
				$selected_job_title_price = ($result['jr_mid_price'] * .55);
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 4), 2, ".", ",");
			}
		}
		if ($level == "expert") {
			if ($work_status == "Full-Time") {
				$selected_job_title_price = $result['jr_expert_price'];
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 8), 2, ".", ",");
			} else {
				$selected_job_title_price = ($result['jr_expert_price'] * .55);
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 4), 2, ".", ",");
			}
		}

		$price_str = sprintf("%s%s%s/Hourly %s%s/Monthly ", $currency, $currency_symbol, $hr_price, $currency_symbol, $selected_job_title_price);
		return $price_str;

	}

}

class Congrats{
	
    private $db;
    private $smarty;
    private $contact;
    
    public function __construct($db) {
        $this -> db = $db;
        $this -> smarty = new Smarty();
        $this -> contact = new Contact();
    }
    
    //RENDER
    public function render(){
        $db = $this -> db;
        $smarty = $this -> smarty;
        $rs_contact_nos = $this -> contact;
        $contact_numbers = $rs_contact_nos->rs_contact_numbers($db);
		if (!isset($_SESSION["step"])){
			header("Location:/portal/custom_get_started/optional_step4.php");
		}else{
			$this->_get_job_order_summary();
			$this->send_email();
			if(isset($_SESSION["job_order_ids"])){
				unset($_SESSION["job_order_ids"]);
			}
			if(isset($_SESSION['from'])&&$_SESSION['from']=='recruitment_sheet'){
				unset($_SESSION["from"]);
			}
			if(isset($_SESSION["step"])){
				unset($_SESSION["step"]);
			}
		}
        $smarty->assign('contact_numbers', $contact_numbers);
        $smarty->clear_cache('congrats.tpl'); 
        $smarty->display('congrats.tpl');
    }
    
    //GET JOB ORDER SUMMARY
    private function _get_job_order_summary(){
		
        $db = $this -> db;
        $smarty = $this -> smarty;
		
		$job_order_ids = $_SESSION["job_order_ids"];
		
		$job_order_summary_sql = $db->select()
								  ->from( 'gs_job_titles_details',array('gs_job_titles_details_id','service_type','selected_job_title','level','no_of_staff_needed'))
								  ->where('gs_job_titles_details_id  IN (?)',$job_order_ids);
		$job_order_summary = $db->fetchAll($job_order_summary_sql);
		
		$new_job_order_summary = array();
		foreach($job_order_summary as $key => $job_order){ 
			$new_job_order_summary[ $key ][ 'tracking_code' ] = $job_order[ 'gs_job_titles_details_id' ] . '-' . ( ! empty( $job_order[ 'service_type' ] ) ? $job_order[ 'service_type' ] : 'ASL' );
			$new_job_order_summary[ $key ][ 'job_position' ] = $job_order[ 'selected_job_title' ];
			$new_job_order_summary[ $key ][ 'level' ] = ucwords( $job_order[ 'level' ] );
			$new_job_order_summary[ $key ][ 'no_of_staff_needed' ] = $job_order[ 'no_of_staff_needed' ];
		}
		$smarty->assign('job_order_summary',$new_job_order_summary);
	}
	
	//SEND EMAIL AFTER FINISHING JOB ORDER
	private function send_email(){
		
        $db = $this -> db;
        $smarty = $this -> smarty;
        $rs_contact_nos = $this -> contact;
        $contact_numbers = $rs_contact_nos->rs_contact_numbers($db);
		
		$ATZ = date("Y-m-d H:i:s");
		$gs_job_role_selection_id = $db -> fetchOne($db -> select() -> from("gs_job_titles_details", "gs_job_role_selection_id") -> where("gs_job_titles_details_id = ?", $_SESSION['job_order_ids'][0]));
		$currency = $db -> fetchOne($db -> select() -> from("gs_job_role_selection", "currency") -> where("gs_job_role_selection_id = ?", $gs_job_role_selection_id));
		$leads_id  = $_SESSION["leads_id"];
		
		if ($currency) {
			//get the currency_lookup.id of the currency
			$sql2 = $db -> select() -> from('currency_lookup', 'id') -> where('code = ?', $currency);
			$currency_lookup_id = $db -> fetchOne($sql2);

			//echo $currency_lookup_id;
			// get the unit prices
			// ID of the Recruitment Setup Fee
			// 3 = Initial Recruitment Setup Fee
			// 4 = Regular Recruitment Setup Fee (additional staff)

			//id, product_id, amount, currency_id, admin_id, date

			$free_custom_recruitment_product_id = 791;
			//get the additional price
			$query2 = $db -> select() -> from('product_price_history', 'amount') -> where('product_id = ?', $free_custom_recruitment_product_id) -> where('currency_id = ?', $currency_lookup_id);
			//echo $query2."<br>";
			$free_custom_recruitment_product_price = $db -> fetchOne($query2);

			if (!$free_custom_recruitment_product_price) {
				$free_custom_recruitment_product_price = 0;
			}
			//echo $free_custom_recruitment_product_price;exit;
			//A.

			//B. Create random string
			$random_string = rand_str();
			//B.

			//C. Save leads session id
			
			$data = array('leads_id' => $leads_id, 'random_string' => $random_string);
			$db -> insert('leads_session_transfer', $data);
			//C.

			//D. Insert new record in the leads_invoice
			$data = array('leads_id' => $leads_id, 'date_created' => $ATZ, 'invoice_date' => $ATZ, 'currency' => $currency_lookup_id, 'description' => 'Custom Recruitment Setup Fee Payment', 'status' => 'open');
			//print_r($data);
			$db -> insert('leads_invoice', $data);
			$leads_invoice_id = $db -> lastInsertId();

			$sql = "SELECT SUM(no_of_staff_needed)AS total_no_of_staff_needed , selected_job_title FROM gs_job_titles_details g WHERE gs_job_role_selection_id = $gs_job_role_selection_id GROUP BY selected_job_title;";

			$orders = $db -> fetchAll($sql);
			if (count($orders) > 0) {

				foreach ($orders as $order) {
					$total_no_of_staff_needed = $order['total_no_of_staff_needed'];
					$selected_job_title = $order['selected_job_title'];

					if ($total_no_of_staff_needed == 1) {
						//get the details in the gs_job_titles_details table per selected_job_title
						$query = $db -> select() -> from('gs_job_titles_details') -> where('selected_job_title = ?', $selected_job_title) -> where('gs_job_role_selection_id = ?', $gs_job_role_selection_id);
						$result = $db -> fetchRow($query);

						$description = sprintf("Custom recruitment of (1) %s %s level for %s working %s Monday to Friday.", $selected_job_title, $result['level'], configurePriceRate($result['jr_list_id'], $result['level'], $result['work_status'], $currency_lookup_id), $result['work_status']);

						$data = array('leads_invoice_id' => $leads_invoice_id, 'product_id' => $free_custom_recruitment_product_id, 'qty' => 1, 'unit' => 'pc', 'unit_price' => $free_custom_recruitment_product_price, 'description' => $description);
						$db -> insert('leads_invoice_item', $data);
						//echo $description."<hr>";
					} else {
						//echo $total_no_of_staff_needed." => ".$selected_job_title."<br>";
						$selected_job_titles = array();
						//initial staff
						$query = $db -> select() -> from('gs_job_titles_details') -> where('selected_job_title = ?', $selected_job_title) -> where('gs_job_role_selection_id = ?', $gs_job_role_selection_id) -> limit(1);

						$job_position = $db -> fetchRow($query);

						$description = sprintf("Custom recruitment of (%s) initial staff %s %s level for %s working %s Monday to Friday.", 1, $selected_job_title, $job_position['level'], configurePriceRate($job_position['jr_list_id'], $job_position['level'], $job_position['work_status'], $currency_lookup_id), $job_position['work_status']);
						//echo "<b>".$description."</b><br>";

						//push data in array
						array_push($selected_job_titles, $job_position['gs_job_titles_details_id']);

						//save data
						$data = array('leads_invoice_id' => $leads_invoice_id, 'product_id' => $free_custom_recruitment_product_id, 'qty' => 1, 'unit' => 'pc', 'unit_price' => $free_custom_recruitment_product_price, 'description' => $description);
						$db -> insert('leads_invoice_item', $data);

						//additional staff
						//check if the parse row column field no_of_staff_needed is greatere than 1
						if ($job_position['no_of_staff_needed'] > 1) {

							$description = sprintf("Custom recruitment of (%s) additional staff %s %s level for %s working %s Monday to Friday.", ($job_position['no_of_staff_needed'] - 1), $selected_job_title, $job_position['level'], configurePriceRate($job_position['jr_list_id'], $job_position['level'], $job_position['work_status'], $currency_lookup_id), $job_position['work_status']);
							//echo $description."<br>";
							$data = array('leads_invoice_id' => $leads_invoice_id, 'product_id' => $free_custom_recruitment_product_id, 'qty' => ($job_position['no_of_staff_needed'] - 1), 'unit' => 'pc', 'unit_price' => $free_custom_recruitment_product_price, 'description' => $description);
							$db -> insert('leads_invoice_item', $data);
						}

						//added staff
						$query2 = $db -> select() -> from('gs_job_titles_details') -> where('selected_job_title = ?', $selected_job_title) -> where('gs_job_role_selection_id = ?', $gs_job_role_selection_id);
						$job_positions = $db -> fetchAll($query2);
						foreach ($job_positions as $job_position) {

							$i = 0;
							if ($selected_job_titles[$i] != $job_position['gs_job_titles_details_id']) {

								$description = sprintf("Custom recruitment of (%s) additional staff %s %s level for %s working %s Monday to Friday.", $job_position['no_of_staff_needed'], $selected_job_title, $job_position['level'], configurePriceRate($job_position['jr_list_id'], $job_position['level'], $job_position['work_status'], $currency_lookup_id), $job_position['work_status']);
								//echo $description."<br>";

								$data = array('leads_invoice_id' => $leads_invoice_id, 'product_id' => $free_custom_recruitment_product_id, 'qty' => $job_position['no_of_staff_needed'], 'unit' => 'pc', 'unit_price' => $free_custom_recruitment_product_price, 'description' => $description);
								$db -> insert('leads_invoice_item', $data);

							}

						}
						//echo "<hr>";

					}

				}
			}
		}


			//G. we need to track this record
			$data = array(
						'leads_invoice_id' => $leads_invoice_id,
						'gs_job_role_selection_id' => $gs_job_role_selection_id,
						'status' => 'open', 
						'date_created' => $ATZ
						);
			$db->insert('gs_payment_track' , $data);
			//G.

			$leads_info_sql=$db->select()
				->from(array('l'=>'leads'), array('id','fname','lname','business_partner_id','email','hiring_coordinator_id'))
                ->joinLeft(array('a'=>'admin'), 'l.hiring_coordinator_id = a.admin_id', array('admin_id','admin_fname','admin_lname'))
				->where('l.id = ?' ,$leads_id);
			$leads_info = $db->fetchRow($leads_info_sql);	
			$name = $leads_info['fname']." ".$leads_info['lname'];
			$email = $leads_info['email'];
			$business_partner_id = $leads_info['business_partner_id'];
			
			if($_SESSION['filled_up_by_type'] == 'leads'){
			
				//get the business partner email
				if($business_partner_id){
					$sql = $db->select()
						->from('agent')
						->where('agent_no =?', $business_partner_id);
					$bp = $db->fetchRow($sql);
				}
			
				/*
				$smarty->assign('lead', $leads_info);
				$smarty->assign('leads_invoice_id', $leads_invoice_id);
				$smarty->assign('admin_email', ADMIN_EMAIL);
				$smarty->assign('admin_name', ADMIN_NAME);
				$smarty->assign('site', $_SERVER['HTTP_HOST']);
                $smarty->assign('contact_numbers',$contact_numbers);
				$body = $smarty->fetch('confirm.tpl');
				*/
				
				//echo $bp['email'];exit;
			
				/*		 
				$mail = new Zend_Mail('utf-8');
				$mail->setBodyHtml($body);
				$mail->setFrom('sales@remotestaff.com.au', 'REMOTESTAFF');
				if(! TEST){
					$mail->addTo($email, $name);
					$mail->addCc('orders@remotestaff.com.au', 'Order');// Adds a recipient to the mail with a "Cc" header
					$mail->addBcc('devs@remotestaff.com.au', 'Remotestaff Developers');
					$subject= "FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE";
				}else{
					$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
					//$mail->addCc('orders@remotestaff.com.au', 'Order');// Adds a recipient to the mail with a "Cc" header
					$subject= "TEST FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE";
				}
				$mail->setSubject($subject);
				$mail->send($transport);
				*/
				
				/*
				$attachments_array =NULL;
				$to_array = array($email); //
				$bcc_array=array('devs@remotestaff.com.au');
				$cc_array = array('orders@remotestaff.com.au');
				$from = "REMOTESTAFF <sales@remotestaff.com.au>";
				$html = $body;
				$subject = "FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE";
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
				*/
				
			    //echo $html;	
				//exit;
				//autoresponder for admin
				/*
				$mail = new Zend_Mail('utf-8');
				$mail->setBodyHtml($body2);
				$mail->setFrom('sales@remotestaff.com.au', 'REMOTESTAFF');
				if(! TEST){
					$mail->addTo('orders@remotestaff.com.au', 'Order');
					$mail->addBcc('devs@remotestaff.com.au', 'Remotestaff Developers');
					$subject= "FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD ".$name;
				}else{
					//$mail->addTo('orders@remotestaff.com.au', 'Order');
					$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
					$subject= "TEST FREE (admin) REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD ".$name;
				}
				$mail->setSubject($subject);
				$mail->send($transport);
				*/
				
				$smarty->assign('lead', $leads_info);
				$smarty->assign('leads_invoice_id', $leads_invoice_id);
				$smarty->assign('qk', sha1($ATZ));
				
				$smarty->assign('admin_email', ADMIN_EMAIL);
				$smarty->assign('admin_name', ADMIN_NAME);
				$smarty->assign('site', $_SERVER['HTTP_HOST']);
                $smarty->assign('contact_numbers', $contact_numbers);
				$body2 = $smarty->fetch('autoresponder-for-admin.tpl');	
				
				$attachments_array =NULL;
				$to_array = array('orders@remotestaff.com.au');
				$bcc_array=array('devs@remotestaff.com.au');
				$cc_array = NULL;
				$from = "REMOTESTAFF <sales@remotestaff.com.au>";
				$html = $body2;
				$subject = sprintf('FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD %s %s', $leads_id, strtoupper($name));
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
			
			
			
				if($bp['email']){
					//autoresponder for BP
					/*
					$mail = new Zend_Mail('utf-8');
					$mail->setBodyHtml($body2);
					$mail->setFrom('sales@remotestaff.com.au', 'REMOTESTAFF');
					if(! TEST){
						$mail->addTo($bp['email'], $bp['fname']." ".$bp['lname']);
						$mail->addBcc('devs@remotestaff.com.au', 'Remotestaff Developers');
						$subject= "FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD ".$name;
					}else{
						$mail->addTo('devs@remotestaff.com.au', $bp['fname']." ".$bp['lname']);
						$subject= "TEST (bp) FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD ".$name;
					}
			
					$mail->setSubject($subject);
					$mail->send($transport);
					*/
					
					$attachments_array =NULL;
					$to_array = array($bp['email']); //
					$bcc_array=array('devs@remotestaff.com.au');
					$cc_array = NULL;
					$from = "REMOTESTAFF <sales@remotestaff.com.au>";
					$html = $body2;
					$subject = sprintf('FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD %s %s', $leads_id, strtoupper($name));
					SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
				}
			}else{
			    //send autoresponder to the one who filled up this JS form. 
				//send autoresponder to admin
				$smarty->assign('lead', $leads_info);
				$smarty->assign('leads_invoice_id', $leads_invoice_id);
				$smarty->assign('ATZ', $ATZ);
				$smarty->assign('site', $_SERVER['HTTP_HOST']);
				$smarty->assign('filled_up_by', ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name'));
                $smarty->assign('contact_numbers',$contact_numbers);
				$body = $smarty->fetch('filled_up_by_notice_autoresponder.tpl');
				/*
				$mail = new Zend_Mail('utf-8');
				$mail->setBodyHtml($body);
				$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
				if(! TEST){
					$mail->addTo(ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'email'), ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name'));
					$mail->addBcc('devs@remotestaff.com.au', 'Remotestaff Developers');
					$subject= "CUSTOM RECRUITMENT SERVICE CREATED AND FILLED BY ".ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name');
				}else{
					$mail->addTo('devs@remotestaff.com.au');
					$subject= "TEST CUSTOM RECRUITMENT SERVICE CREATED AND FILLED BY ".ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name');
				}
				$mail->setSubject($subject);
				$mail->send($transport);
				*/
				$subject= "CUSTOM RECRUITMENT SERVICE CREATED AND FILLED BY ".ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name');
				$email = ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'email');
				$attachments_array =NULL;
				$to_array = array($email);
				$bcc_array=array('devs@remotestaff.com.au');
				$cc_array = NULL;
				$from = "No Reply <noreply@remotestaff.com.au>";
				$html = $body;
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
				
				
				//Send notice to lead
				$smarty->assign('lead', $leads_info);
				$smarty->assign('leads_invoice_id', $leads_invoice_id);
				$smarty->assign('ATZ', $ATZ);
				$smarty->assign('site', $_SERVER['HTTP_HOST']);
				$smarty->assign('filled_up_by', ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name'));
				$smarty->assign('contact_numbers', $contact_numbers);
				$body = $smarty->fetch('job_order_for_lead_autoresponder.tpl');
				
				$attachments_array =NULL;
				$to_array = array($leads_info['email']);
				$bcc_array=array('devs@remotestaff.com.au');
				$cc_array = NULL;
				$from = "No Reply <noreply@remotestaff.com.au>";
				$html = $body;
				$subject= sprintf("Job Order for %s %s %s",  $leads_info['fname'], $leads_info['lname'], $leads_info['id']);
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
				
			}
			
			//update leads company description
			/*
			if($_POST['company_description'] != 'Type Here'){
			    $data = array('company_description' => $_POST['company_description']);
				addLeadsInfoHistoryChanges($data , $_SESSION['leads_id'] , $_POST['leads_id'] , 'client');
				$where = "id = ".$_SESSION['leads_id'];
				$db->update('leads', $data , $where);
				$company_description = $_POST['company_description'];
			}
			*/
			
			
			//marked this lead in the leads list.
			$data = array('custom_recruitment_order' => 'yes', 'last_updated_date' => $ATZ);
			$where = "id = ".$_SESSION['leads_id'];
			$db->update('leads', $data, $where);
			
			
			$data = array(
			    'filled_up_by_id' => $_SESSION['filled_up_by_id'],
				'filled_up_by_type' => $_SESSION['filled_up_by_type'],
				'filled_up_date' => $ATZ
			);
			
			//echo '<PRE>';	
			//print_r($data);
			//echo '</PRE>';
			//exit;
			$where = "gs_job_role_selection_id = ".$gs_job_role_selection_id;
			$db->update('gs_job_role_selection' ,  $data , $where);

	}
	
}
