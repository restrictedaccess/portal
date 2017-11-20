<?
include("../../conf.php");
//include("../../config.php");

date_default_timezone_set("Asia/Manila");

class Payments
{
	  		
	 function CreateAutomaticInvoice($date_start, $date_end, $invoice_id) {
            $date_start_str = $date_start->format('Y-m-d');
            $date_end_str = $date_end->format('Y-m-d 23:59:59');

           // Get Affiliate's Clients
			$query="SELECT DISTINCT(*)
				FROM leads l
				JOIN subcontractors s ON s.leads_id = l.id
				WHERE l.status = 'Client' AND l.agent_id =$this->agentid ORDER BY timestamp DESC;";
			// $result = mysql_query($query);
			 $result = $this->dbh->query($query);
			
			 //while(list($leads_id)=mysql_fetch_array($result))
			  foreach ($result->fetchAll() as $row) 
			 {
			 	$sql = "SELECT t.userid, l.fname, l.lname, l.company_name, t.subcontractors_id, t.posting_id, t.time_in, t.time_out, s.working_hours 
							FROM timerecord AS t 
							LEFT JOIN leads AS l ON t.leads_id = l.id 
							LEFT JOIN subcontractors AS s ON t.subcontractors_id = s.id 
							WHERE t.leads_id = ".$row['id']." 
							AND t.mode = 'regular' 
							AND t.time_in BETWEEN '$date_start_str' 
							AND '$date_end_str' 
							ORDER by t.time_in desc";
			
			        $resulta = $this->dbh->query($sql);
            		$invoice_details = new InvoiceDetails($invoice_id);
		            forEach ($resulta->fetchAll() as $record) {
        	        	$invoice_details->AddRecord($record);
            		}
		            $total_amount = $invoice_details->GetTotalAmount();

        		    //update total amount on subcon_invoice table
		            $query = "update subcon_invoice set total_amount = '$total_amount' where id = $invoice_id";
        		    $result = $this->dbh->exec($query);
			}
				
        }
	
	
// end of class
}

 class InvoiceDetails extends FormattedTimeRecord{
        /**
        *
        * Initialize
        *
        */
        function __construct($invoice_id) {
            parent::__construct();

            $this->invoice_id = $invoice_id;
            $this->item_id = 0; //increments upon adding records
            $this->total_amt = 0;
        }


        /**
        *
        * Returns total amount
        *
        * @return	float	 Description
        */
        function GetTotalAmount() {
            return $this->total_amt;
        }


        function AddRecord($record) {
            $day_of = $this->GetDayOf($record);

            $client_name = $record['lname'] . ', ' . $record['fname'] . ' (' . $record['company_name'] . ')';

            $total_hours = $this->GetTotalHours($record);
            list($start_lunch_ph, $finish_lunch_ph, $start_lunch_au, $finish_lunch_au) = $this->GetLunchHours($record);
            $total_lunch_hours = $this->GetTotalLunchSeconds($record) / 60 / 60;

            $time_in_ph = $this->FormatTimeInvoice($record['time_in']);
            $time_out_ph = $this->FormatTimeInvoice($record['time_out']);
            $subcontractors_id = $record['subcontractors_id'];

            //get the hourly rate and working hours
            $query = "select php_hourly, working_hours FROM subcontractors where id = $subcontractors_id";
            $data = $this->dbh->query($query);
            $result = $data->fetch();
            $php_hourly_rate = $result['php_hourly'];
            $registered_working_hours = $result['working_hours'];

            //insert to subcon_invoice_details
            $this->item_id += 1;
            $total_hours = number_format($total_hours, 2, '.', ',');
            $description = "$day_of from $time_in_ph to $time_out_ph for $client_name with total hours of $total_hours @ $php_hourly_rate/hr.";
            if ($total_hours > $registered_working_hours) {
                $amount = $php_hourly_rate * $registered_working_hours;
            }
            else {
                $amount = $php_hourly_rate * $total_hours;
            }
            $amount = number_format($amount, 2, '.', '');
            $this->total_amt += $amount;
            $query = "INSERT INTO agent_invoice_details (agent_invoice_id, item_id, description, amount) VALUES ($this->invoice_id, $this->item_id, '$description', '$amount')";
            $this->dbh->exec($query);

        }

        /**
        *
        * Formats the time
        *
        * @return	string
        */
        function FormatTimeInvoice($time) {
            if (($time == null) or ($time == '')) {
                return '';
            }
            $time = new DateTime($time);
            $time->setTimeZone($this->tz_ph);
            return $time->format('h:i a');
        }
    }
?>