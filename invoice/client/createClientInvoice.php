<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';
include '../../function.php';




if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}



$ran = get_rand_id();
$ran = CheckRan($ran);
//Check random character if existing in the table quote 
function CheckRan($ran){
	$query = "SELECT * FROM client_invoice WHERE ran = '$ran';";
	$result =  mysql_query($query);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
		// The random character is existing in the table
		$ran = get_rand_id();
		return $ran;
	}else{
		return $ran;
	}
}



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$mode=$_REQUEST['mode'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$client=$_REQUEST['client'];
$description =$_REQUEST['description'];
$section_status = $_REQUEST['status'];

$currency =$_REQUEST['currency'];
$fix_currency_rate = $_REQUEST['fix_currency_rate'];
$current_rate =$_REQUEST['current_rate'];
if($current_rate==""){
	$current_rate=0;
}



$num = cal_days_in_month(CAL_GREGORIAN, $month, $year) ; 
$sat_sun=0;
$reg_days=0;


$monthArray=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($month == $monthArray[$i])
  {
 	$monthoptions = "$monthName[$i]";
	break;
  }
  
}



$queryClient ="SELECT fname,lname FROM leads WHERE id = $client;";
$result=mysql_query($queryClient);
list($fname,$lname)=mysql_fetch_array($result);
$client_name =  $fname." ".$lname;

// Check if the selected Month's is existing then add a new one then increment counter  by one..
$queryCheck ="SELECT COUNT(invoice_month)AS counter FROM client_invoice WHERE invoice_month =$month AND leads_id =$client;";
//echo $queryCheck;
$resultCheck = mysql_query($queryCheck);
list($counter) = mysql_fetch_array($resultCheck);
if($counter > 0) {
	$counter++;
}else{
	$counter++;
}

function checkTimeIn($previuos_month, $year,$userid , $client)
{

		$num_days = cal_days_in_month(CAL_GREGORIAN, $previuos_month, $year) ; 
		for($i=1; $i<=$num_days; $i++)										
		{																	
		if($i<=9){													
			$i="0".$i;															
		}																
		$compare_date2 = $year."-".$previuos_month."-".$i;				
		$dateSearch[]=$compare_date2;
		}
		$queryTimeRecord="SELECT DATE_FORMAT(t.time_in,'%Y-%m-%d'),DATE_FORMAT(t.time_out,'%Y-%m-%d') FROM timerecord t
				WHERE t.leads_id = $client
				AND t.mode = 'regular'
				AND t.userid = $userid
				AND DATE_FORMAT(t.time_in,'%Y-%m') = '$year-$previuos_month'
				AND DATE_FORMAT(t.time_out,'%Y-%m') = '$year-$previuos_month'";		
		    $res=mysql_query($queryTimeRecord);
			while(list($time_in,$time_out)=mysql_fetch_array($res))
			{
				$timerecord_dates[]=$time_in;
			}
		$result=array_diff($dateSearch, $timerecord_dates);	
		$newArray=array_merge($result);
		for($x=0; $x<count($newArray);$x++)
		{
			$sqlDateCheck="SELECT DAYNAME('".$newArray[$x]."');";		
			//echo $sqlDateCheck."<br>";
			$resultDateCheck = mysql_query($sqlDateCheck);			
			list($dayname) = mysql_fetch_array($resultDateCheck);	
			if($dayname=="Saturday" or $dayname=="Sunday"){			
				//do nothing
			}else{
				//echo $dayname."<br>";
				$dates_check[]=$newArray[$x];
			}
		}
		
		return $dates_check;

}	
function checkSubconDateWorks($previuos_month, $year,$userid , $client)
{

		$num_days = cal_days_in_month(CAL_GREGORIAN, $previuos_month, $year) ; 
		for($i=1; $i<=$num_days; $i++)										
		{																	
			if($i<=9){													
				$i="0".$i;															
			}																
			$compare_date2 = $year."-".$previuos_month."-".$i;				
			$dateSearch[]=$compare_date2;
		}
		for($i=0; $i<count($dateSearch);$i++){
			$query="SELECT * FROM timerecord t
				WHERE t.leads_id = $client
				AND t.mode = 'regular'
				AND t.userid = $userid
				AND DATE_FORMAT(t.time_in,'%Y-%m-%d') = '$dateSearch[$i]'
				AND DATE_FORMAT(t.time_out,'%Y-%m-%d') = '$dateSearch[$i]'";	
				//echo $query."<br>";
			 $result = mysql_query($query);	
			 $ctr=@mysql_num_rows($result);
			 if($ctr >0){
			 	$date_work[]=$dateSearch[$i];
			 }
			
		}		
		return($date_work);

}	
function getOvertimeWorkingDates($previous_month_regular_working_dates , $subcon_previous_month_work_dates, $userid , $client)
{
	$result=array_diff($subcon_previous_month_work_dates,$previous_month_regular_working_dates);
	$newArray=array_merge($result);
	for($i=0;$i<count($newArray);$i++)
	{
		$dates[]=$newArray[$i];
	}	
	return $dates;
}
function getPreviousMonthRegularWorkingDates($previuos_month, $year)
{
	$num_days = cal_days_in_month(CAL_GREGORIAN, $previuos_month, $year) ; 
	for($x=1; $x<=$num_days; $x++)										
	{																	
		if($x<=9){													
			$x="0".$x;															
		}																
		$compare_date2 = $year."-".$previuos_month."-".$x;	
		$sqlDateCheck2="SELECT DAYNAME('$compare_date2');";		
		$resultDateCheck2 = mysql_query($sqlDateCheck2);			
		list($dayname2) = mysql_fetch_array($resultDateCheck2);	
		if($dayname2=="Saturday" or $dayname2=="Sunday"){			
			//$previous_month_sat_sun++;											
		}else{													
			//$previous_month_reg_days++;
			$regular_working_dates[]=$compare_date2;
		}	
	}
	return $regular_working_dates;
}	


function getPreviuosMonthName($month)
{
	$monthArray=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
	$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
	for ($i = 0; $i < count($monthArray); $i++)
	{
	  if($month == $monthArray[$i])
  		{
	 	$monthoptions = "$monthName[$i]";
		break;
  		}
	}	
	return $monthoptions;
  
	

}


function DateFormatStr($str)
{
	$datetime = new DateTime("$str");
	return $datetime->format('D d');
}







///Save to the Database
// Create invoice number
$sqlInvoiceNumber = "SELECT MAX(invoice_number) FROM client_invoice;";
$res = mysql_query($sqlInvoiceNumber);
$row_result = mysql_fetch_array($res);

if($row_result[0] == 0 or $row_result[0]==""){
	$invoice_number = 1000;
}else{
	$invoice_number = $row_result[0] + 1;
}	
//echo $row_result[0]."<br>";
//echo $invoice_number."<br>";
if($description==""){
	$description ="#".$invoice_number." Client Invoice " .$client_name;
}	
/*
id, leads_id, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, start_date, end_date, invoice_date, draft_date, post_date, last_update_date, sub_total, gst, total_amount, invoice_month, invoice_year, paid_date, invoice_number, currency, fix_currency_rate, current_rate
*/

$query="INSERT INTO client_invoice SET leads_id = $client, description = '$description' , drafted_by =".$_SESSION['admin_id']." , drafted_by_type = 'admin',status = 'draft', invoice_date = '$ATZ', draft_date = '$ATZ' , invoice_month = '$month',invoice_year = '$year' , invoice_number = $invoice_number ,currency = '$currency', fix_currency_rate = $fix_currency_rate , current_rate = $current_rate ,invoice_payment_due_date = date_add('$ATZ', INTERVAL 5 DAY) ;";
$result = mysql_query($query);
$client_invoice_id = mysql_insert_id();
if($result)
{
///
	/*
		- Get the total number or working days in a month...;
		- Get the total days work in the previuos month by the Client subcontractor;
		- Calculate the total number of working days in a month to the Client Price (daily_rate);
		- If the subcon has absences in the previous month, subtract it to the total number or working days in a month "CREDIT MEMO"
		- If the subcon has overtime or have a weekend work days reflect and plus it to the invoice total amount...
	*/
	
	// 1. Create a Calendar Check to get the total working days of the month
	for($i=1; $i<=$num; $i++)										//
	{																//	
		if($i<=9){													//
			$i="0".$i;												//			
		}															//	
			$compare_date = $year."-".$month."-".$i;				//
			$sqlDateCheck="SELECT DAYNAME('$compare_date');";		//
			$resultDateCheck = mysql_query($sqlDateCheck);			//
			list($dayname) = mysql_fetch_array($resultDateCheck);	//
			if($dayname=="Saturday" or $dayname=="Sunday"){			//
				$sat_sun++;											//
			}else{													//
				$reg_days++;
				//echo $compare_date."<br>";
				$date[] = $compare_date;										//
			}
		
		
	}

	// Get the first working date of the month and last working date of the month 					
	$min_date = min($date);
	$max_date = max($date);
	//Get tje Previous month
	// check if the selected month is January or 1 then the month to be checked in the subcon timerecords table will be decemeber or 12.
	if($month == 1){
		$previuos_month =12;
		$year=($year-1); // current year - 1 eg: (2009- 1) = 2008
	}else{
		
		$previuos_month = ($month - 1);
	}	
	if($previuos_month<10){
		$previuos_month ="0".$previuos_month;
	}
	//echo $previuos_month;
	$num_days = cal_days_in_month(CAL_GREGORIAN, $previuos_month, $year) ; 
	$search_date = $year."-".$previuos_month;
	for($x=1; $x<=$num_days; $x++)										
	{																	
		if($x<=9){													
			$x="0".$x;															
		}																
		$compare_date2 = $year."-".$previuos_month."-".$x;	
		$sqlDateCheck2="SELECT DAYNAME('$compare_date2');";		
		$resultDateCheck2 = mysql_query($sqlDateCheck2);			
		list($dayname2) = mysql_fetch_array($resultDateCheck2);	
		if($dayname2=="Saturday" or $dayname2=="Sunday"){			
			$previous_month_sat_sun++;											
		}else{													
			$previous_month_reg_days++;
			//echo $compare_date."<br>";										
		}	
	}

	// 2. Get all Client Staff
	$query="SELECT DISTINCT(p.userid), CONCAT(p.fname,' ',p.lname)AS subcon_name ,s.working_days,s.client_price,j.latest_job_title , php_daily , aud_daily
			FROM personal p
			LEFT JOIN subcontractors s ON s.userid = p.userid
			LEFT JOIN currentjob j ON j.userid = p.userid
			WHERE s.status = 'ACTIVE'
			AND s.leads_id = $client
			ORDER BY p.fname ASC;";
	$result=mysql_query($query);	
	$days_work=0;	
	while(list($userid,$subcon_name,$registered_working_days,$registered_client_price,$job_title ,$php_daily, $aud_daily)=mysql_fetch_array($result))
	{
		
		
		if($registered_working_days==""){
			$registered_working_days ='5';
		}
		if($job_title!=""){
			$job_title ="[".$job_title."]";
		}
		//
		// create counter to show breakdown of data of each subcon
		$sqlCounter = "SELECT MAX(counter) from client_invoice_details;";
		$res = mysql_query($sqlCounter);
		$row = mysql_fetch_array($res);
		$counter = $row[0] + 1;
			
		
		//
		$client_price_daily = ((($registered_client_price * 12)/52)/$registered_working_days);
		$client_price = number_format($client_price_daily,2) * $reg_days;
		$decription = $subcon_name." ".$job_title;
		
		$query ="INSERT INTO client_invoice_details SET client_invoice_id = $client_invoice_id, start_date = '$min_date', end_date = '$max_date', decription = '$decription ', total_days_work = $reg_days, company_rate = $aud_daily, rate = $client_price_daily, amount = $client_price , counter = $counter ,sub_counter = $counter , subcon_id = $userid; ";
		mysql_query($query);
	
		//Check the previous month attendance of the subcon in the timrecord table
		//
		for($i=1; $i<=$num_days; $i++)										
		{																	
			if($i<=9){													
				$i="0".$i;															
			}																
			$compare_date2 = $year."-".$previuos_month."-".$i;				
			$queryTimeRecord="SELECT * FROM timerecord t
					WHERE t.leads_id = $client
					AND t.mode = 'regular'
					AND t.userid = $userid
					AND DATE_FORMAT(t.time_in,'%Y-%m-%d') = '$compare_date2'
					AND DATE_FORMAT(t.time_out,'%Y-%m-%d') = '$compare_date2'";		
			//echo $queryTimeRecord."<br>";			
			$resulta=mysql_query($queryTimeRecord);
			$ctr=@mysql_num_rows($resulta);
			$row = mysql_fetch_array ($resulta); 
			if ($ctr >0 )
			{
				$days_work++;
			}
						
		}
		
		// Check the subcon Absences...
		
			$result_dates = checkTimeIn($previuos_month, $year,$userid , $client);
			
			$date_absent_start_at = min($result_dates);
			$date_absent_end_at = max($result_dates);
			
			
			$days_absent =count($result_dates); 	
			if($days_absent > 0){	
				$description= "**Credit Memo ". $subcon_name ." is absent for " .$days_absent . " day(s) ".getPreviuosMonthName($previuos_month)." ".$year." [ ";
				$client_price_absent = $client_price_daily * $days_absent;
				$x = (count($result_dates)-1);
				for($i=0; $i<count($result_dates); $i++){
				
					if($i==$x) {
						$description.=DateFormatStr($result_dates[$x]);
					}
					else{
						$description.=DateFormatStr($result_dates[$i]).", ";
					}
					
				}
				$description.=" ]";
				/*
				$queryInsert ="INSERT INTO client_invoice_details SET client_invoice_id = $client_invoice_id, 
				start_date = '$date_absent_start_at', 
				end_date = '$date_absent_end_at', 
				decription = '$description', 
				total_days_work = $days_absent, 
				rate = $client_price_daily, 
				amount = (-$client_price_absent) , sub_counter = $counter; ";
				*/
				$queryInsert ="INSERT INTO client_invoice_details SET client_invoice_id = $client_invoice_id, 
				decription = '$description', 
				total_days_work = $days_absent, 
				rate = $client_price_daily, 
				amount = (-$client_price_absent) , sub_counter = $counter, counter = $counter; ";
				mysql_query($queryInsert);
			}	
			
		
		
		//Check the Subcon Overtime Days...
		$date_works = checkSubconDateWorks($previuos_month, $year,$userid , $client); 
		$get_overtime_working_dates="";
		$overtime_dates="";
		//$overtime_days = (count($date_works)) - $previous_month_reg_days;
		
		//echo "Subcon Previous Month Work : ". (count($date_works)) ."<br>";
		//echo "Previous Month Regular working Days : " .$previous_month_reg_days."<br>";
		//echo $overtime_days." - ".$userid."<br>";
		//echo $overtime_days;
		
		//if($overtime_days > 0){
			
			//echo "Subcon : ".$subcon_name ." has " .$overtime_days ." overtime day(s)<br>";
			$previous_month_regular_working_dates = getPreviousMonthRegularWorkingDates($previuos_month, $year);
			$subcon_previous_month_work_dates = checkSubconDateWorks($previuos_month, $year,$userid , $client);
			
			$get_overtime_working_dates = getOvertimeWorkingDates($previous_month_regular_working_dates , $subcon_previous_month_work_dates, $userid , $client);
			$overtime_days = count($get_overtime_working_dates);
						
			//print_r($subcon_previous_month_work_dates)."<br>";
			//echo $userid."<br>---<br>";
			if($overtime_days==1)
			{
				$overtime_dates.=DateFormatStr($get_overtime_working_dates[0]);
			}else{
				for($i=0;$i<(count($get_overtime_working_dates)-1);$i++)
				{
					$overtime_dates.=DateFormatStr($get_overtime_working_dates[$i]).",";
				}
				$overtime_dates.=DateFormatStr($get_overtime_working_dates[(count($get_overtime_working_dates)-1)]);
			}
			
			if($overtime_days>0){
			
				$date_overtime_start_at = min($get_overtime_working_dates);
				$date_overtime_end_at = max($get_overtime_working_dates);	
							
				$description = "*** ".$subcon_name ." have " .$overtime_days ." extra working day(s) ".getPreviuosMonthName($previuos_month)." ".$year." [ ";
				$description.= $overtime_dates;
				$description.=" ]";
				$client_price_overtime_days = $client_price_daily * $overtime_days;
				
				
				
				$queryInsert ="INSERT INTO client_invoice_details SET client_invoice_id = $client_invoice_id, start_date = '$date_overtime_start_at', end_date = '$date_overtime_end_at', decription = '$description', total_days_work = $overtime_days, rate = $client_price_daily, amount = $client_price_overtime_days , sub_counter = $counter, counter = $counter; ";			
				mysql_query($queryInsert);
		}	
		
		// For Currency Difference Memo
		if($current_rate!="")
		{
			//First and Last date of the previous month
			
			$first_date_previous_month = $year."-".$previuos_month."-01";
			$last_date_previous_month = date('Y-m-d',mktime(0, 0, 0, (date('m')), 0, date('Y'))); 
			
			$queryTotalAmount="SELECT DISTINCT (s.total_amount)
					FROM subcon_invoice s
					WHERE drafted_by_type = 'admin'
					AND s.status ='posted'
					AND start_date between '$first_date_previous_month' AND '$last_date_previous_month'
					AND end_date between '$first_date_previous_month' AND '$last_date_previous_month'
					AND userid = $userid;";
			
			$resulta = mysql_query($queryTotalAmount);
			list($total_amount) = mysql_fetch_array($resulta);
			
			$extra_currency_fee_formula_1 = ($total_amount / $fix_currency_rate);
			$extra_currency_fee_formula_2 = ($total_amount / $current_rate);
			
			
			$total_currency_fee_charge = ($extra_currency_fee_formula_2 - $extra_currency_fee_formula_1);
			//echo $total_currency_fee_charge."<br>";
			
			$description =  "Currency Difference for ".getPreviuosMonthName($previuos_month)." ".$year." @ ".$current_rate." Peso";
			
			
			//echo $previuos_month_regular_working_dates_start_at ." - ".$previuos_month_regular_working_dates_end_at."<br>";
			$queryInsertCurrencyFee ="INSERT INTO client_invoice_details SET client_invoice_id = $client_invoice_id, 
			start_date = '$first_date_previous_month', 
			end_date = '$last_date_previous_month', 
			decription = '$description',
			amount = $total_currency_fee_charge , 
			sub_counter = $counter, counter = $counter; ";	
			mysql_query($queryInsertCurrencyFee);
			
		}	
		
		
		
		
	
		
	//while loop	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$querySum="SELECT SUM(amount)AS total_amount FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id;";
	//echo $querySum ."<br>";
	$resultSum=mysql_query($querySum);
	list($total_amount)=mysql_fetch_array($resultSum);
	//uodate the client_invoice
	$sqlUpdate ="UPDATE client_invoice SET total_amount = $total_amount , sub_total = $total_amount WHERE id = $client_invoice_id;";
	mysql_query($sqlUpdate);
	
	//Parse All data
	$sql="SELECT CONCAT(l.fname, ' ',l.lname)AS client_name, c.status, DATE_FORMAT(c.invoice_date,'%D %b %Y'), c.invoice_month, DATE_FORMAT(c.draft_date,'%D %b %Y'), DATE_FORMAT(c.post_date,'%D %b %Y'), DATE_FORMAT(c.paid_date,'%D %b %Y'),description, c.invoice_year, c.sub_total , c.gst, c.total_amount,l.company_name,l.company_address,c.invoice_number,c.currency,DATE_FORMAT(invoice_payment_due_date,'%D %b %Y'),l.email
		FROM client_invoice c
		LEFT JOIN leads l ON l.id = c.leads_id
		WHERE c.id = $client_invoice_id;";
		$result =mysql_query($sql);
		list($client_name , $status , $invoice_date  , $invoice_month , $draft_date , $post_date , $paid_date ,$description , $invoice_year , $sub_total , $gst, $total_amount , $company_name, $company_address ,$invoice_number , $currency , $invoice_payment_due_date ,$email)= mysql_fetch_array($result);
		
		if($status =="draft"){
			$date_status ="<label>Draft Date :</label>".$draft_date;
		}
		if($status =="posted"){
			$date_status ="<label>Posted Date :</label>".$post_date;
		}
		
		if($status =="paid"){
			$date_status ="<label>Paid Date :</label>".$paid_date;
		}
		
		
		if($currency == "AUD"){
			$currency_txt ="Tax Invoice to be Paid in Australian Dollar (AUD)";
			$currency_symbol = "\$ ";
		}
		if($currency == "USD"){
			$currency_txt ="Tax Invoice to be Paid in US Dollar (USD)";
			$currency_symbol = "\$ ";
		}
		if($currency == "POUND"){
			$currency_txt ="Tax Invoice to be Paid in United Kingdom  (POUNDs)";
			$currency_symbol = "&pound; ";
		}

// <--		
		$QUERY="SELECT DISTINCT(counter) FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id";
		$RESULT=mysql_query($QUERY);
		$num=0;
		while(list($counter)=mysql_fetch_array($RESULT))
		{	
			if ($counter!=""){		
				$num++;	
				$data.="<div style='background:#E9E9E9;padding-top:10px;border-bottom:#000000 dashed 1px;'><b>$num )</b>";
				$QUERY2="SELECT id, CONCAT(DATE_FORMAT(start_date , '%D %b'),' - ',DATE_FORMAT(end_date , '%D %b %Y') )AS start_end_date  , decription, total_days_work, rate, amount , company_rate FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id AND sub_counter = $counter;";		
				$RESULT2=mysql_query($QUERY2);
				while(list($id, $start_end_date , $decription, $total_days_work, $rate, $amount , $company_rate)=mysql_fetch_array($RESULT2))
				{		
					// DATA HERE
					$rate ? number_format($rate,2,'.','.') : '&nbsp;';
					$company_rate ? number_format($company_rate,2,'.','.') : '&nbsp;';
					$data .="<div class='invoice_data_wrrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this)'; >
								<div class='invoice_data_start_end_date'>$start_end_date</div>
								<div class='invoice_data_offshore_staff'>$decription</div>
								<div class='invoice_data_working_days'>$total_days_work</div>
								<div class='invoice_data_rate'>$currency_symbol ".$rate."</div>
								<div class='invoice_data_rate2'>$currency_symbol ".$company_rate."</div>
								<div class='invoice_data_amount'>".$currency_symbol." ".number_format($amount,2,'.','.')."</div>	
								<div class='invoice_data_button'>
									
									<input type='button' class ='butt' value='edit' onclick='editInvoiceDetails($id,$client_invoice_id)'  />
									<input type='button' class ='butt' value='del' onclick='deleteInvoiceDetails($id,$client_invoice_id)'  />
									
								</div>	
								<div style='clear:both;'></div>
							</div>";
				}
				$data.="&nbsp;</div>";
			}
		}
// -->	

	
///
}
else
{
	echo "ERROR IN SCRIPT: <BR>".$query;
}
?>


<div id="client_invoice">
<div style="padding:3px; margin-left:2px; float:left;width:400px;">
<p><b><?=$description;?></b></p>
<p><label>Client Name :</label><b style="color:#FF0000;"><?=$client_name;?></b></p>
<p><label>Company Name :</label><?=$company_name ? $company_name : '&nbsp;';?></p>
<p><label>Company Address :</label><?=$company_address ? $company_address : '&nbsp;';?></p>
</div>
<div style="padding:3px; margin-left:2px; float:right; margin-right:20px; ">
<p><label>Tax Invoice Month / Year:</label><?=$monthoptions;?> - <?=$invoice_year;?></p>
<p><label>Date Created :</label><?=$invoice_date;?></p>
<p><label>Status :</label><?=$status;?></p>
<p><?=$date_status;?></p>
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px; padding:3px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>Payments</b></div>
<div style="padding:5px; border:#CCCCCC solid 1px;">
<p><label>Tax Invoice Currency :</label><?=$currency_txt;?></p>
<p style="margin-top:2px;"><label>Sub Total :</label><b><?=$currency_symbol;?> <?=number_format($sub_total,2,'.',',');?></b></p>

<? if ($currency=="AUD") {
	$disabled='';
	$gst_txt =$currency_symbol. number_format(($gst),2,'.',',');
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>GST (%10) :</label><b> ".$gst_txt."</b></p>";

}else if($currency=="POUND"){
	$disabled='';
	$gst_txt =$currency_symbol. number_format(($gst),2,'.',',');
	
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>VAT (%17.5) :</label><b> ".$gst_txt."</b></p>";
	
}else{
	$disabled='disabled="disabled"';
	$gst_txt = "Not Available";
	
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>GST (%10) :</label><b> ".$gst_txt."</b></p>";
}
?>




<p><label>Total :</label><b style="color:#0000FF;"><?=$currency_symbol;?> <?=number_format($total_amount,2,'.',',');?></b></p>
<p id="payment_due_date"><label>Invoice Payment Due Date :</label><?=$invoice_payment_due_date;?>  
<span style=" margin-left:20px;color:#666666; font:12px; cursor:pointer;" onclick="editDueDate(<?=$client_invoice_id;?>);">edit</span>
</p>

</div>

<div id="due_date_div" style="display:none; padding:7px; background:#333333; border:#666666 outset 1px; color:#FFFFFF; font-weight:bold;"></div>
<div id="invoice_controls" style="margin:3px; padding:3px; border:#999999 dashed 1px;">
<?
if($status=="draft"){
?>
  <input name="button" type="button" onclick="addItem(<?=$client_invoice_id;?>);" value="Add Item" />
  &nbsp;
  <input type="button" value="Post this Invoice" onclick="show_hide('post_div');" />&nbsp;
  <input type="button" value="Delete this Invoice" onclick="deleteInvoice(<?=$client_invoice_id;?>)" />&nbsp;
<? } 
if ($status=="posted"){
?>
	<input type="button" value="Move to Paid Section" onclick="paidInvoice(<?=$client_invoice_id;?>)" />&nbsp;
    <input type="button" value="Delete this Invoice" onclick="deleteInvoice(<?=$client_invoice_id;?>)" />&nbsp;
<?
}
?>  
</div>
<div id="post_div"  style="padding:10px; display:none; background:#62A4D5; color:#FFFFFF; border:#000000 solid 1px; margin-bottom:5px;">
<div style="float:left;">
	<p>Are you sure want to POST this Invoice No. : <?=$invoice_number;?></p>
	<p>A copy of this Invoice will be sent via email</p>
	<p><label style="width:40px;display:block;float:left;">To :</label><input type="text" name="leads_email" id="leads_email" class="select" value="<?=$email;?>" /></p>
	<p><label style="width:40px;display:block;float:left;">CC :</label><input type="text" name="cc" id="cc" class="select" value="" /></p>
	<p>
	 <input type="button" value="Post" onclick="postInvoice(<?=$client_invoice_id;?>)" />
	 <input type="button" value="Cancel" onclick="show_hide('post_div');" />
	 </p>
</div>	 
<div style="float:left; margin-left:20px;">
	<p align="right"><b>Message</b></p>
	<textarea id="message" name="message" class="select" style="width:370px; height:150px;"></textarea>
</div>
<div style="clear:both;"></div>
</div>
<div id="edit_div"></div>

<div style="clear:both;"></div>


	<div class="invoice_title_wrrapper_hdr">
		<div class="invoice_start_end_date">DATE</div>
		<div class="invoice_offshore_staff">OFFSHORE STAFF &amp; JOB DESCRIPTION</div>
		<div class="invoice_working_days">DAYS</div>
		<div class="invoice_rate">RATE</div>
		<div class="invoice_rate">COMPANY RATE</div>
		<div class="invoice_amount">AMOUNT</div>
	</div>
	<?=$data;?>
	<div style="clear:both;"></div>
</div>



