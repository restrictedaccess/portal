<?php

    /* $ seatbController.php 2012-02-08 mike $ */
    
    class SeatbController {
        private $db = NULL;
        private $timeNum = array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,0,1,2,3,4,5);
        private $seat_model = NULL;
        public static $admin = array();
        private $seatno = 84;
        private $tz_array = array(
                array('tz' => 'AU', 'label' => 'Australia/Sydney'),
                array('tz' => 'US', 'label' => 'America/San Francisco'),
                array('tz' => 'UK', 'label' => 'Europe/London'));
        
        // constructor
        public function __construct() {
            $this->db = Config::$db_conf;
            // store model object as property
            //include_once('../portal/conf/zend_smarty_conf.php');
            //$this->db = $db;
            
            $this->seat_model = new ClassBooking( $this->db );
            
            $this::$admin = $this->seat_model->check_admin_session();
        }
        
        public function index($view_type = NULL) {
            $current_date = date("Y-m-d");
            
            if( $view_type !== NULL ) {
                $booking_date = Input::post('date') ? Input::post('date') : ( Input::get('date') ? : $current_date );
                $booking_date2 = Input::post('date2') ? Input::post('date2') : ( Input::get('date2') ? : $current_date );
                $starttime = Input::post('starttime') ? Input::post('starttime') : ( Input::get('starttime') ? : 0 );
                $endtime = Input::post('endtime') ? Input::post('endtime') : ( Input::get('endtime') ? : 23 );
                
                $tab = Input::get('tab') ? Input::get('tab') : 'first';
    
                $booking_tstamp = strtotime($booking_date);
                
                $book_endtstamp = strtotime($booking_date2) + 86400;
                
                $scroll = Input::get('scroll');
                
                //$seat_model = new ClassBooking($this->db);
                //if( $starttime > -1 && $endtime > -1 ) {
				if( $booking_date && $booking_date2 ) {
                    $this->seat_model->booking_tstamp = $booking_tstamp;
                    $this->seat_model->book_endtstamp = $book_endtstamp;
                }
				
                $datefrom = date("m/d/Y", $booking_tstamp);
                $dateto = date("m/d/Y", $book_endtstamp - 86400);
                
                if( $booking_date == $booking_date2 ) {
                    if( $booking_date == date("Y-m-d") ) $home_date = 'Today, '. $datefrom;
                    else $home_date = date("l", $booking_tstamp) . ', '.$datefrom;
                } else {
                    $home_date = $datefrom . ' - '. $dateto;
                }
                
                
                if( $view_type == 'expand') {
                    $view = new View('seat_view_expand');
                    $seat_id = 1;
                }
                else {
                    $view = new View('seat_home');
                }
                $view->time_sel_value = $this->timeNum;
                //$view->seat_booked = $this->seat_model->getSeatBooked($starttime, $endtime, $booking_date);
                $view->seat_schedule = $this->seat_model->getSeats();
                $view->home_date = $home_date;
                //$view->dow_str = $dow_str;
                $view->filter_date = $booking_date;
                $view->filter_date2 = $booking_date2;
                $view->filter_start = $starttime;
                $view->filter_end = $endtime;
                $view->seat_id = $seat_id;
                $view->scroll = $scroll;
                $view->tab = $tab;
                
                $view->url_date1 = $datefrom;
                $view->url_date2 = $dateto;
                
                $current_tstamp = strtotime($current_date);
                $qry_where = "booking_endtime>=$current_tstamp AND booking_status!='Cancelled'";
                $active_bookings = $this->seat_model->get_total_bookings($qry_where);
                
                $view->total_bookings = $active_bookings;
            } else {
                $month_array = array('January', 'February', 'March', 'April', 'May', 'June',
					'July', 'August', 'September', 'October', 'November', 'December');
                
                // paid hours
                $hrspaid_array = array();
                foreach($month_array as $months => $month) {
                    $hrspaid_array[$month]['au'] = $this->seat_model->booking_payment_count($month, 'AU');
                    $hrspaid_array[$month]['uk'] = $this->seat_model->booking_payment_count($month, 'UK');
                    $hrspaid_array[$month]['us'] = $this->seat_model->booking_payment_count($month, 'US');
                }
                
                // unpaid hours
                $hrsunpaid_array = array();
                foreach($month_array as $months => $month) {
                    $hrsunpaid_array[$month]['au'] = $this->seat_model->booking_payment_count($month, 'AU', 'TBP');
                    $hrsunpaid_array[$month]['uk'] = $this->seat_model->booking_payment_count($month, 'UK', 'TBP');
                    $hrsunpaid_array[$month]['us'] = $this->seat_model->booking_payment_count($month, 'US', 'TBP');
                }
                
                // free booking hours
                $freebooking_array = array();
                foreach($month_array as $months => $month) {
                    $freebooking_array[$month]['au'] = $this->seat_model->booking_payment_count($month, 'AU', 'Free');
                    $freebooking_array[$month]['uk'] = $this->seat_model->booking_payment_count($month, 'UK', 'Free');
                    $freebooking_array[$month]['us'] = $this->seat_model->booking_payment_count($month, 'US', 'Free');
                }
                
                // booked seat pct.
                $bookedseat_array = array();
                $total_seat_hrs = $this->seatno * 24 * (30.4368499/3);
                foreach($month_array as $months => $month) {
                    //$days_cnt = cal_days_in_month(CAL_GREGORIAN, 8, date('Y'));
                    $bookedseat_array[$month]['au'] = ($this->seat_model->get_average_monthly($month, 'AU') / $total_seat_hrs) * 100;
                    $bookedseat_array[$month]['uk'] = ($this->seat_model->get_average_monthly($month, 'UK') / $total_seat_hrs) * 100;
                    $bookedseat_array[$month]['us'] = ($this->seat_model->get_average_monthly($month, 'US') / $total_seat_hrs) * 100;
                }
                //print_r($bookedseat_array);
                // booked seat today
                $booked_today_au = $this->seat_model->get_average_monthly($current_date, 'AU', '%Y-%m-%d') ;
                $booked_today_uk = $this->seat_model->get_average_monthly($current_date, 'UK', '%Y-%m-%d');
                $booked_today_us = $this->seat_model->get_average_monthly($current_date, 'US', '%Y-%m-%d');
                
                $view = new View('seat_summary');
                $view->month_array = $month_array;
                $view->shift_array = array('AU', 'UK', 'US');
                $view->paid_array = $hrspaid_array;
                $view->unpaid_array = $hrsunpaid_array;
                $view->freebooking_array = $freebooking_array;
                $view->booked_array = $bookedseat_array;
                $view->booked_today = array('au' => $booked_today_au, 'us' => $booked_today_us, 'uk' => $booked_today_uk);
            }
            
            $view->display();
        }
        public function user_form() {
            $view = new View('user_form');
            $view->display();
        }
        
        public function reserve_seat() {
            $seat = Input::get('seat_id') ? Input::get('seat_id') : Input::post('seat_id');
            $yearID = Input::post('yearID') ? Input::post('yearID') : ( Input::get('yearID') ? : date('Y') );
            $monthID = Input::post('monthID') ? Input::post('monthID') : ( Input::get('monthID') ? : date('n') );
            $dayID = Input::post('dayID') ? Input::post('dayID') : ( Input::get('dayID') ? : date('d') );
            
            
            
            $this->seat_model->seat_id = $seat;            
            
            $view = new View('quick_booking');
            
            $view->calendar = $this->seat_model->booking_month_cal($yearID, $monthID, $seat);
            
            $view->time_sel_value = $this->timeNum;
            $view->seat_id = $seat;
            $view->userid = $userid;
            $view->timezone = $this->tz_array;
            
            $view->display(FALSE);
        }
        
        public function get_seat_booking() {
            $move = Input::post('move');
            $seat_id = Input::post('seat_id');
			
			$current_date = date("Y-m-d");
			
			$booking_date = Input::post('date') ? Input::post('date') : ( Input::get('date') ? : $current_date );
            $booking_date2 = Input::post('date2') ? Input::post('date2') : ( Input::get('date2') ? : $current_date );
			
			$booking_tstamp = strtotime($booking_date);
            $book_endtstamp = strtotime($booking_date2) + 86400;
			
            if( $booking_date && $booking_date2 ) {
				$this->seat_model->booking_tstamp = $booking_tstamp;
				$this->seat_model->book_endtstamp = $book_endtstamp;
            }    

            switch($move) {
                case 'next':
                    $seat_id += 4;
                    break;
                case 'previous':
                    $seat_id -= 4;
                    break;
            }
            echo json_encode( array('sched'=>$this->seat_model->getSeats($seat_id), 'seat_id'=>$seat_id) );
            exit();
        }
        
        public function show_client() {
            $userid = Input::post('userid');           
            echo json_encode( $this->seat_model->get_client($userid) );
            exit();
        }
        
        public function process_booking() {
            // get POST params
            if (Input::post('createbutton'))
            {
                $seat_id = Input::post('seat_id');
                $staff_id = Input::post('staff_id');
                $client_id = Input::post('client');
                
                $date_from = Input::post('date_from');
                $date_to = Input::post('date_to');
                $start_time = Input::post('start_time');
                $finish_time = Input::post('finish_time');
                
                $type = Input::post('type');
                $payment = Input::post('payment');
                $noise = Input::post('noise');
                
                $timezone = Input::post('timezone');
                $schedule = Input::post('schedule');
                
                $booking_created = time();
                $booking_updated = $booking_created;
                
                $err_msg = '';
                
                $booking_start = strtotime($date_from);
                $booking_finish = strtotime($date_to);
                
                $book_status = ($payment == 'Free') ? 'Confirmed' : 'Pending';
                
                $this->seat_model->booking_tstamp = $booking_start;
                $this->seat_model->book_endtstamp = $booking_finish;
                
                $book_time = array('date_from' => $date_from, 'date_to' => $date_to,
                            'start_time' => $start_time, 'finish_time' => $finish_time);
                
                // setup values for insert query
                $data_array = array('staff_id' => $staff_id, 'leads_id' => $client_id, 'seat_id' => $seat_id, 'booking_type' => $type,
                'booking_by' => $this::$admin['admin_id'], 'booking_payment' => $payment, 'booking_created' => $booking_created,
                'booking_updated' => $booking_updated, 'booking_status' => $book_status, 'noise_level' => $noise,
                'booking_schedule' => $schedule, 'timezone' => $timezone);
                
                // save user data
                $result = $this->seat_model->create_booking($book_time, $data_array);
            }
        }
        
        // LIST OF BOOKING BY STAFF
        public function staff($arg = NULL) {
            $fields = array('staff_id', 'leads_id', 'seat_id', 'id', 'booking_status', 'booking_starttime');
            $keys = array_keys($_GET);
            if( count($keys) == 1 ) $keys = array_keys($_POST);
            
            $where = array();
            foreach($keys as $key) {
                if( in_array($key, $fields) && (!empty($_GET[$key]) || !empty($_POST[$key])) ) {
                    $var = Input::get($key) ? Input::get($key) : Input::post($key);
                    array_push($where, $key.'='.$var);
                    if( $key == 'seat_id' ) $seat_id = $var;
                    elseif( $key == 'staff_id' ) $staff_id = $var;
                }
            }
            
            $booking_info = array();
            if( count($where) ) $booking_info = $this->seat_model->get_bookings($where);
            $view = new View('seat_staff');

            $view->booking_info = $booking_info;
	
            $view->time_sel_value = $this->timeNum;
            $view->seat_id = $seat_id;
            $view->staff_id = $staff_id;
            $view->task = $task;
            $view->taborder = $tab;
            $view->payment_types = array('Free', 'TBP', 'Paid');
            $view->timezone = $this->tz_array;
            $view->display();
        }
        
        // LIST OF BOOKING BY CLIENT
        public function client($arg = NULL) {
            $fields = array('staff_id', 'leads_id', 'seat_id', 'id', 'booking_status', 'booking_starttime');
            $keys = array_keys($_GET);
            if( count($keys) == 1 ) $keys = array_keys($_POST);
            
            $where = array();
            foreach($keys as $key) {
                //echo $key . ' - '.$_GET[$var].'<br/>';
                if( in_array($key, $fields) && (!empty($_GET[$key]) || !empty($_POST[$key])) ) {
                    $var = Input::get($key) ? Input::get($key) : Input::post($key);
                    array_push($where, $key.'='.$var);
                    if( $key == 'seat_id' ) $seat_id = $var;
                    elseif( $key == 'leads_id' ) $leads_id = $var;
                }
            }
            
            $booking_info = array();
            if( count($where) ) $booking_info = $this->seat_model->get_bookings($where);
            $view = new View('seat_client');

            $view->booking_info = $booking_info;
	
            $view->time_sel_value = $this->timeNum;
            $view->seat_id = $seat_id;
            $view->leads_id = $leads_id;
            $view->task = $task;
            $view->taborder = $tab;
            $view->payment_types = array('Free', 'TBP', 'Paid');
            $view->timezone = $this->tz_array;
            $view->display();
        }
        
        public function cancel() {
            $id = Input::post('book_id');
            
            if( $id ) {
                $this->seat_model->cancel_booking($id);
            }
        }
        
        public function modify() {
            $id = Input::post('book_id');
            if( $id ) {
                echo 'modify:'.$id;
                //exit;
                $seat_id = Input::post('seat_id');
                
                $client_id = Input::post('client');
                $date_from = Input::post('date_from');
                
                $start_time = Input::post('start_time');
                $finish_time = Input::post('finish_time');
                    
                $type = Input::post('type');
                $payment = Input::post('payment');
                
                $booking_status = Input::post('status');
                
                $timezone = Input::post('timezone');
                $booking_schedule = Input::post('schedule');
                
                // double check the status
                if(in_array($payment, array('Free', 'Paid'))
                   && $booking_status !== 'Confirmed') {
                    $booking_status = 'Confirmed';
                } else {
                    if( $payment == 'TBP' && $booking_status !== 'Pending')
                        $booking_status = 'Pending';
                }
                
                // double check the payment
                if($booking_status == 'Pending' && $payment !== 'TBP') {
                    $payment = 'TBP';
                } else {
                    if( $booking_status == 'Confirmed' && $payment !== 'Paid')
                        $payment = 'Paid';
                }
                    
                $booking_updated = time();; //$booking_created;
                
                $this->seat_model->book_id = $id;
                $this->seat_model->seat_id = $seat_id;
                
                $book_time = array('date_from' => $date_from, 'start_time' => $start_time, 'finish_time' => $finish_time);
                
                
                $data_array = array('booking_type' => $type, 'booking_payment' => $payment, 'booking_by' => $this::$admin['admin_id'],
                'booking_updated' => $booking_updated, 'booking_status' => $booking_status, 'timezone' => $timezone, 'booking_schedule' => $booking_schedule);
                
                $result = $this->seat_model->update_booking($book_time, $data_array);
            }
        }
        
        public function reports($byfield = NULL) {
            $booking_status = Input::get('booking_status') ? Input::get('booking_status') : 'All Status';
            $seat_id = Input::get('seat_id');
            $booking_date = Input::get('date');
            $booking_date2 = Input::get('date2');
            $timezone = Input::get('timezone');
            $leads_id = Input::get('id');
            
            $args = array('seat_id' => $seat_id, 'date' => $booking_date, 'date2' => $booking_date2,
                'timezone' => $timezone, 'filter' => $byfield, 'leads_id' => $leads_id);
            
            $where = '';
            if( $booking_status != 'All Status' ) //$where = "b.booking_status='$booking_status'";
                $args['b.booking_status'] = $booking_status;
                //$where = "b.booking_status='$booking_status'";
            $url = explode('reports', trim($_SERVER['REQUEST_URI'], 'reports'), 2);
            $url = explode('&', trim($url[1], '&'), 2);
            $params = !empty($url[1]) ? $url[1] : $booking_status;
            
            $params_array = explode('&', $params);
            $tab_array = array();
            
            $replace = array('seat_id' => 'Seat #', 'date' => 'Date: ', 'date2' => ' to ',
                    'booking_status' => 'Status: ', 'All Status' => 'All Status', 'id' => 'Client:');

            for($i = 0; $i < count($params_array); $i++) {
                $fld_str = explode('=', $params_array[$i]);
                
                if( !empty($fld_str[1]) )
                    array_push($tab_array, $replace[ $fld_str[0] ] . $fld_str[1] );
                
            }

            if(count($tab_array) == 0) $tab_array[0] = $booking_status;
            
            $result = $this->seat_model->booking_reports($where, $args);
            //$result = $this->seat_model->booking_reports($where, $seat_id, $booking_date, $booking_date2);
            
            $view = new View('booking_reports');
            
            $view->booking_info = $result['booking_info'];

            $view->params = $params;//$booking_status;
            
            $pages = $result['pages'];            
            $view->ipp = $pages->low;
            $view->items_total = $pages->items_total;
            $view->pages = $pages->display_pages();
            $view->jump_menu = $pages->display_jump_menu();
            $view->items_pp = $pages->display_items_per_page();
            $view->byfield = ($byfield !== NULL) ? $byfield : 'status';
            $view->tab = str_replace('%20', ' ', implode(' ', $tab_array));
            $view->client_select = $this->seat_model->get_client();
            
            if( $byfield == 'date' ) {
                $view->filter_date = $booking_date;
                $view->filter_date2 = $booking_date2 ? $booking_date2 : $booking_date;
            }
            $view->ipp = $pages->low;
            $view->display(); 
        }
       
        public function payment() {
            $payment_type = Input::get('booking_payment') ? Input::get('booking_payment') : 'All Payment';
            $leads_id = Input::get('id');
            
            $where = '';
            
            $args = array('leads_id' => $leads_id);
            
            if( $payment_type != 'All Payment' )
                $args['b.booking_payment'] = $payment_type;
                //$where = "b.booking_payment='$payment_type'";
                
            $url = explode('payment', $_SERVER['REQUEST_URI'], 2);
            //print_r($_SERVER['REQUEST_URI']);
            //print_r($url);
            $url = explode('&', trim($url[1], '&'), 2);
            $params = !empty($url[1]) ? $url[1] : $payment_type;
            
            $params_array = explode('&', $params);
            $tab_array = array();
            $replace = array('All Payment' => 'All Payment', 'id' => 'Client:');
            
            for($i = 0; $i < count($params_array); $i++) {
                $fld_str = explode('=', $params_array[$i]);
                if(array_key_exists($fld_str[0], $tab_array)) continue;
                
                if( !empty($fld_str[1]) )
                    array_push($tab_array, $replace[ $fld_str[0] ] . $fld_str[1] );
                
            }
            
            if(count($tab_array) == 0) $tab_array[0] = $payment_type;
            //print_r($args);
            /*print_r($args);
            print_r($tab_array);
            echo $params;*/

            $result = $this->seat_model->booking_reports($where, $args);//, $seat_id, $booking_date);
            
            $view = new View('payment_type');
            
            $view->booking_info = $result['booking_info'];

            $view->type = $payment_type;
            $view->params = $params;
            $view->tab = str_replace('%20', ' ', implode(' ', $tab_array));
            
            $pages = $result['pages'];
            $view->ipp = $pages->low;
            $view->items_total = $pages->items_total;
            $view->pages = $pages->display_pages();
            $view->jump_menu = $pages->display_jump_menu();
            $view->items_pp = $pages->display_items_per_page();
            
            $view->client_select = $this->seat_model->get_client();
            $view->display();
        }
       
        public function filter($arg = NULL) {
            $id = Input::post('id');
            $fldname = Input::post('fldname');
            $fldsearch = Input::post('fldsearch');
            $params = Input::post('params');
            
            $args = array();
            $args["b.$arg"] = $id;
            //$where = "b.$arg=$id";
            //$where = "";
            
            if($fldsearch != 'All Status' && $fldsearch != 'All Payment')
                $args["b.$fldname"] = $fldsearch;
                //$where .= " AND b.$fldname = '$fldsearch'";
              
            //$replace_flds = array('date' => 'booking: ', 'date2' => ' to ',
            //        'booking_status' => 'Status: ', 'All Status' => 'All Status');
            //echo $params;
            
                    
            $params_array = explode('&', $params);

            $fld_array = array();
            for($i = 0; $i < count($params_array); $i++) {
                $fld_str = explode('=', $params_array[$i]);
                if(($id && $fld_str[0] == 'id') || $fld_str[0] == 'params') continue;
                if(array_key_exists($fld_str[0], $args)) continue;
                
                if( $fld_str[0] == 'date') $args['date'] = $fld_str[1];
                elseif( $fld_str[0] == 'date2') $args['date2'] = $fld_str[1];
                else $args[ $fld_str[0] ] = $fld_str[1];
                
                //if( !empty($fld_str[1]) )
                //    array_push($tab_array, $replace[ $fld_str[0] ] . $fld_str[1] );
                //echo '<br/>'.$params_array[$i];
            }
            
            //$report_type = explode('=', $params);
            if( array_key_exists('booking_payment', $args) || array_key_exists('All Payment', $args) ) {
                $url_replace = "/payment";
                $param_search = "params=id=";
            }
            else { $url_replace = "/reports/leads_id";
                $param_search = "params=";
            }
            //echo $where;
            //print_r($args);
            //$args = array('seat_id' => $seat_id, 'date' => $booking_date, 'date2' => $booking_date2,
             //   'tz' => $timezone, 'filter' => $byfield );
            
            //$result = $this->seat_model->booking_reports($where);
            $result = $this->seat_model->booking_reports($where, $args);//$fld_array['seat_id'], $fld_array['date1'], $fld_array['date2']);
            $pages = $result['pages'];
           
           //echo '>'.$pages->display_items_per_page();
            $result['pp']['display_pages'] = str_replace("/filter/leads_id", $url_replace, $pages->display_pages());
            $result['pp']['display_pages'] = str_replace("params=id=", "", $result['pp']['display_pages']);
            $result['pp']['display_pages'] = str_replace("params=", "", $result['pp']['display_pages']);
            $result['pp']['jump_menu'] = str_replace("/filter/leads_id", $url_replace, $pages->display_jump_menu());
            $result['pp']['jump_menu'] = str_replace("params=id=", "", $result['pp']['jump_menu']);
            $result['pp']['jump_menu'] = str_replace("params=", "", $result['pp']['jump_menu']);
            $result['pp']['items_pp'] = str_replace("/filter/leads_id", $url_replace, $pages->display_items_per_page());
            $result['pp']['items_pp'] = str_replace("params=id=", "", $result['pp']['items_pp']);
            $result['pp']['items_pp'] = str_replace("params=", "", $result['pp']['items_pp']);
            /*$view->ipp = $pages->low;
            $view->items_total = $pages->items_total;
            $view->pages = $pages->display_pages();
            $view->jump_menu = $pages->display_jump_menu();
            $view->items_pp = $pages->display_items_per_page();
            $view->client_select = $this->seat_model->get_client();*/
            
            echo json_encode($result);
        }
        
        public function invoice($arg = NULL) {         
            //$where = "b.$arg=$id";
            //$result = $this->seat_model->booking_reports($where);
            //echo json_encode($result);
            $type = Input::post('type');
            $schedule = Input::post('schedule');
            $booking_info = array();
            if($arg !== NULL) {
                $booking_info = $this->seat_model->get_unpaid($arg, $type, $schedule);
                echo json_encode($booking_info);
                exit;
            }
            //print_r($booking_info);
            $view = new View('seat_invoice');
            $view->client_select = $this->seat_model->get_client();
            $view->display();
        }
    }