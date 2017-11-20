<?php
//2011-01-24 Normaneil Macutay <normanm@remotestaff.com.au>
//	- remove status display in the pdf file

//2010-12-23 Normaneil Macutay <normanm@remotestaff.com.au>
//  make the attachment inline

//2010-12-14 Normaneil Macutay <normanm@remotestaff.com.au>
//	update and modified the default message

//2010-12-03 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  added name to the content type, attachment

//2010-11-24 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  added utf8 on Zend_Mail

//2010-11-19 Normaneil Macutay <normanm@remotestaff.com.au>
//	added a value in the attachement type $at->type= 'application/pdf';

//2010-10-25 Normaneil Macutay <normanm@remotestaff.com.au>
//	put a comment on the bank acct details

//2010-08-05 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Updated the clients email using the acct_dept_email1 field from leads
//  Include TEST constant to prevent it from sending to the true recipient
//
//2009-11-18 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  leave the status to as is when mailed


include('../conf/zend_smarty_conf.php');
include '../time.php';
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$client_invoice_id = $_REQUEST['client_invoice_id'];
$site = $_SERVER['HTTP_HOST'];

if($client_invoice_id == Null){
	die("Invoice Id is missing");
}

if($_SESSION['admin_id']=="")
{
    die("Invalid Id for Admin");
}

$admin_id = $_SESSION['admin_id'];
$sql = $db->select()
	->from('admin')
	->where('admin_id = ?' , $admin_id);
$row = $db->fetchRow($sql);
$admin_name = $row['admin_fname']." ".$row['admin_lname'];
$admin_email=$row['admin_email'];


function rand_str($length = 45, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
    // Length of character list
    $chars_length = strlen($chars);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
   
    // Generate random string
    for ($i = 1; $i < $length; $i++) {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        $string = $string . $r;
    }
   
    // Return the string
    return $string;
}

$random_string = rand_str();

if(@isset($_POST["submit"])){
	
	
//create pdf
$sql="SELECT CONCAT(l.fname, ' ',l.lname)AS client_name, c.status, DATE_FORMAT(c.invoice_date,'%D %b %Y')AS invoice_date, c.invoice_month, DATE_FORMAT(c.draft_date,'%D %b %Y')AS draft_date, DATE_FORMAT(c.post_date,'%D %b %Y')AS post_date, DATE_FORMAT(c.paid_date,'%D %b %Y')AS paid_date,description, c.invoice_year , c.sub_total , c.gst, c.total_amount,l.company_name,l.company_address, c.payment_details,c.invoice_number,c.currency ,DATE_FORMAT(invoice_payment_due_date,'%D %b %Y')AS invoice_payment_due_date,l.email, c.leads_id  FROM client_invoice c LEFT JOIN leads l ON l.id = c.leads_id WHERE c.id = $client_invoice_id;";

$result = $db->fetchRow($sql);
////
$result = $db->fetchRow($sql);
$is_executed = "";
$leads_id = $result['leads_id'];
$client_name = $result['client_name'];
$description = $result['description'];
$email = $result['email'];

//check if the lead has a setting in leads_send_invoice_setting
$sql = $db->select()
    ->from('leads_send_invoice_setting')
	->where('leads_id=?', $leads_id);
$invoice_setting = $db->fetchRow($sql); 

if($invoice_setting['id']){
    if($invoice_setting['address_to'] == 'main_acct_holder'){
	    $client_name = $result['client_name'];
	}else{
	    $sql = $db->select()
		    ->from('leads', $invoice_setting['address_to'])
			->where('id=?', $leads_id);
		$client_name = $db->fetchOne($sql);
	}
}

$status = $result['status'];
$invoice_date = $result['invoice_date'];
$invoice_month = $result['invoice_month']; 
$draft_date = $result['draft_date']; 
$post_date = $result['post_date'];
$paid_date = $result['paid_date'];
 
$invoice_year = $result['invoice_year']; 
$sub_total = $result['sub_total']; 
$gst = $result['gst']; 
$total_amount = $result['total_amount']; 
$company_name = $result['company_name']; 
$company_address = $result['company_address']; 
$payment_details = $result['payment_details'];
$invoice_number = $result['invoice_number']; 
$currency = $result['currency']; 
$invoice_payment_due_date = $result['invoice_payment_due_date'];



$monthArray=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($invoice_month == $monthArray[$i])
  {
     $monthoptions .= "$monthName[$i]";
    break;
  }
}

if($currency == "AUD")
{
    $currency_txt = "Australian Dollar (AUD)"; 
    //$currency_sign = "$ ";
    $bank_account = "490 589 267";
    $bsb="082 140";
}

if($currency == "USD")
{
    $currency_txt = "US Dollar (USD)"; 
    //$currency_sign = "$ ";
    $bank_account = "THIINUSD01";
}

if($currency == "POUND" || $currency == "GBP")
{
    $currency_txt = "UK POUND "; 
    //$currency_sign = "£ ";
}

if($currency){
	if($currency == "POUND"){
		$currency = "GBP";
	}
	$sql = $db->select()
		->from('currency_lookup' , 'sign')
		->where('code =?' ,$currency);
	$currency_sign = $db->fetchOne($sql);
}



                // Pdf Setup
                $pdf = Zend_Pdf::load('client_tax_invoice.pdf');
                
                //invoice_header_a4.pdf
                $pdf_page = $pdf->pages[0];
                
                $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                $pdf_page->setFont($font, 10);
                $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#FF0000"));
                
                // Tax Invoice Number header
                $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
                $pdf_page->setFont($font, 20);
                $pdf_page->drawText($invoice_number, 290, 655);
                
                // Left Information
                $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                $pdf_page->setFont($font, 10);
                
                // Client Name
                $pdf_page->drawText(strtoupper($client_name), 65, 595);
                // make the client name color red
                
                $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));

                ///Client Company
                $pdf_page->drawText($company_name, 115, 583);





                //Client Address
                                                $h = 571;
                                                $string_data = $company_address;
                                                $character_limit = 38;
                                                $total_character = strlen($string_data);
                                                $total_lines = $total_character / $character_limit;
                                                $temp = str_split($string_data,$character_limit);
                                                $c = 0;
                                                $loc = 128;
                                                if($total_character > 38)
                                                {
                                                    for($i = 0; $i <= $total_lines; $i++)
                                                    {
                                                        if($c > 0) 
                                                        {
                                                            //$loc = 30;
                                                            //$character_limit = 38;
                                                            //$temp = str_split($string_data,$character_limit);
                                                        }    
                                                        $pdf_page->drawText($temp[$i], $loc, $h);
                                                        $c++;
                                                        $lines_counter++;        
                                                        $h = $h - 12;                                                
                                                        $c++;
                                                    }                                        
                                                }
                                                else
                                                {
                                                    $pdf_page->drawText($company_address, 128, 571);                                        
                                                }

                // Right Information
                //tax invoice number
                $pdf_page->drawText($invoice_number, 422, 598);

                //tax invoice month / year
                $pdf_page->drawText($monthoptions." - ".$invoice_year, 478, 586);
                
                //date created
                $pdf_page->drawText($draft_date, 415, 573);
                
                //status
                //$pdf_page->drawText(strtoupper($status), 380, 561);
                
                //posted date
                $pdf_page->drawText($post_date, 412, 561);
                

               //account number
				$pdf_page->setFont($font, 9);
				
                if($currency == "AUD")
				{
					//$pdf_page->drawText("Account Name: Think Innovations Pty. Ltd", 32, 475);
					//$pdf_page->drawText("BSB: 082 973", 32, 463);
					//$pdf_page->drawText("ACCOUNT NUMBER: 49 058 9267", 32, 451);
					//$pdf_page->drawText("BANK BRANCH : Darling Street, Balmain NSW Australia 2041", 32, 439);
					//$pdf_page->drawText("SWIFT CODE: NATAAU3302S", 32, 427);
					
				}
				if($currency == "USD")
				{
					//$pdf_page->drawText("Account Name: Think Innovations Pty Ltd", 32, 475);
					//$pdf_page->drawText("Account Number: THIINUSD01", 32, 463);
					//$pdf_page->drawText("BANK BRANCH : Darling Street, Balmain NSW Australia 2041", 32, 451);
					//$pdf_page->drawText("SWIFT CODE: NATAAU3302S", 32, 439);
					
				}
				if($currency == "POUND") {

					//$pdf_page->drawText("HSBC", 32, 475);
					//$pdf_page->drawText("Think Innovations Pty Ltd", 32, 463);
					//$pdf_page->drawText("BSC: 40-05-09", 32, 451);
					//$pdf_page->drawText("ACC: 61506323", 32, 439);
					
				}


				$pdf_page->setFont($font, 10);





                
                //invoice details
                $QUERY="SELECT DISTINCT(counter)AS counter FROM client_invoice_details WHERE  client_invoice_id = $client_invoice_id";
				$RESULT=$db->fetchAll($QUERY);
				
				
                $num=0;
                $y=220;
                $y_line = 220;
                $x_axis = 580;
                $y_axis = 220;

                // Draw rectangle 
                $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#FFFFFF")); 
                $pdf_page->setLineColor(new Zend_Pdf_Color_Html("#000000")); 
                $pdf_page->setLineWidth(0); 
                
                // left , bottom, width , height
                $rm = 577;
                $lm = 22;
                $bm = 333;
                $tm = 20;
                $pdf_page->drawRectangle($lm, $tm, $rm, $bm); 
                //end


                $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                $pdf_page->setFont($font, 6);
                $h = 320;
                $c = 0;
                $current_page = 0;
                $lines_counter = 0;
                $new_page_counter = 5; //any value > 1
               
			    foreach($RESULT as $RESULT){
					$counter =  $RESULT['counter'];
                    if ($counter!="")
                    {        
                        $num++;    
                        $y=$y-15;

                        $QUERY2="SELECT id, CONCAT(DATE_FORMAT(start_date , '%D %b'),' - ',DATE_FORMAT(end_date , '%D %b %Y') )AS start_end_date  , decription, total_days_work, rate, amount  FROM client_invoice_details WHERE  client_invoice_id = $client_invoice_id AND sub_counter = $counter;";                        
                        $RESULT2=$db->fetchAll($QUERY2);
						foreach($RESULT2 as $RESULT2){
							$id = $RESULT2['id']; 
							$start_end_date = $RESULT2['start_end_date']; 
							$decription = $RESULT2['decription']; 
							$total_days_work = $RESULT2['total_days_work']; 
							$rate = $RESULT2['rate']; 
							$amount = $RESULT2['amount'];
                            $c++;
                            $lines_counter++;
                            if($c >= 11)
                            {
                                if(($c == 11 || $c == 13 || $lines_counter >= 39) && $new_page_counter > 0)
                                {
                                    if($lines_counter >= 39 && $is_executed == "yes")
                                    {
                                        $new_page_counter = 0;
                                        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                                        $pdf_page->setFont($font, 6);                                        
                                        
                                        //add new page
                                        $current_page++;
                                        $pdf->pages[$current_page] = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4); 
                                        $pdf_page = $pdf->pages[$current_page];
                                        //end
                                                                    
                                        // Draw rectangle 
                                        $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#FFFFFF")); 
                                        $pdf_page->setLineColor(new Zend_Pdf_Color_Html("#000000")); 
                                        $pdf_page->setLineWidth(0); 
                                        //drawRectangle: left , bottom, width , height
                                        $rm = 577;
                                        $lm = 22;
                                        $bm = 820;
                                        $tm = 20;
                                        $pdf_page->drawRectangle($lm, $tm, $rm, $bm); 
                                        //end     
                                         
                                        $h = 800;        
                                        $lines_counter = 0;                
                                    }    
                                    if($is_executed == "")
                                    {
                                        $new_page_counter = 0;
                                        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                                        $pdf_page->setFont($font, 6);                                        
                                        
                                        //add new page
                                        $current_page++;
                                        $pdf->pages[$current_page] = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4); 
                                        $pdf_page = $pdf->pages[$current_page];
                                        //end
                                                                    
                                        // Draw rectangle 
                                        $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#FFFFFF")); 
                                        $pdf_page->setLineColor(new Zend_Pdf_Color_Html("#000000")); 
                                        $pdf_page->setLineWidth(0); 
                                        //drawRectangle: left , bottom, width , height
                                        $rm = 577;
                                        $lm = 22;
                                        $bm = 820;
                                        $tm = 20;
                                        $pdf_page->drawRectangle($lm, $tm, $rm, $bm); 
                                        //end     
                                         
                                        $h = 800;        
                                        $lines_counter = 0;                
                                        $is_executed = "yes";
                                    }    
                                    
                                }            
                                

                                    $new_page_counter++;
                                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                                    $pdf_page->setFont($font, 6);                                        
                                    //PDF
                                        $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));
                                        $pdf_page->drawText(wordwrap($start_end_date,10), 30, $h);

                                                $string_data = $decription;
                                                $character_limit = 90;
                                                $total_character = strlen($string_data);
                                                $total_lines = $total_character / $character_limit;
                                                $temp = str_split($string_data,$character_limit);
                                                if($total_character > 90)
                                                {
                                                    for($i = 0; $i < $total_lines; $i++)
                                                    {
                                                        $pdf_page->drawText($temp[$i], 114, $h);
                                                        $c++;
                                                        $lines_counter++;        
                                                        $h = $h - 10;                                                
                                                    }                                        
                                                }
                                                else
                                                {
                                                    $pdf_page->drawText(wordwrap($decription,10), 114, $h);                                            
                                                }    
                                            
                                        //if($total_days_work == "" || $total_days_work==0)
                                        //{
                                            //$pdf_page->drawText(wordwrap(""), 390, $h);
                                        //}
                                        //else
                                        //{
                                            //$pdf_page->drawText(wordwrap($total_days_work,10), 390, $h);
                                        //}                                            
                                        
                                        if($rate == "" || $rate==0)
                                        {
                                            $pdf_page->drawText(wordwrap(""), 430, $h);
                                        }
                                        else
                                        {
                                            $pdf_page->drawText(wordwrap($currency_sign.$rate,10), 430, $h, 'UTF-8');
                                        }
										
                                        $pdf_page->drawText(wordwrap($currency_sign.$rate,10), 430, $h, 'UTF-8');
                                        $pdf_page->drawText(wordwrap($currency_sign.$amount,10), 530, $h, 'UTF-8');

                                        // ROW lines
                                        $h = $h - 10;
                                        $pdf_page->drawText('_____________________________________________________________________________________________________________________________________________________________________', 24, $h);
                                        $h = $h - 10;

                                    //PDF
                            }
                            else
                            {
                                    //PDF
                                        $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));
                                        $pdf_page->drawText(wordwrap($start_end_date,10), 30, $h);
                                        
                                                $string_data = $decription;
                                                $character_limit = 90;
                                                $total_character = strlen($string_data);
                                                $total_lines = $total_character / $character_limit;
                                                $temp = str_split($string_data,$character_limit);
                                                if($total_character > 90)
                                                {
                                                    for($i = 0; $i < $total_lines; $i++)
                                                    {
                                                        $pdf_page->drawText($temp[$i], 114, $h);
                                                        $c++;
                                                        $lines_counter++;        
                                                        $h = $h - 8;                                                
                                                    }                                        
                                                }
                                                else
                                                {
                                                    $pdf_page->drawText(wordwrap($decription,10), 114, $h);                                            
                                                }    
                                                                                        
                                                                                        
                                        //if($total_days_work == "" || $total_days_work==0)
                                        //{
                                            //$pdf_page->drawText(wordwrap(""), 390, $h);
                                        //}
                                        //else
                                        //{
                                            //$pdf_page->drawText(wordwrap($total_days_work,10), 390, $h);
                                        //}                                            
                                        
                                        if($rate == "" || $rate==0)
                                        {
                                            $pdf_page->drawText(wordwrap(""), 430, $h);
                                        }
                                        else
                                        {
                                            $pdf_page->drawText(wordwrap($currency_sign.$rate,10), 430, $h, 'UTF-8');
                                        }                                                                                        
                                        
                                        $pdf_page->drawText(wordwrap($currency_sign.$amount,10), 530, $h, 'UTF-8');

                                        // ROW lines
                                        $h = $h - 10;
                                        $pdf_page->drawText('_____________________________________________________________________________________________________________________________________________________________________', 24, $h);
                                        $h = $h - 10;
                                    //PDF
                            }        
                        }

                    }
                }
                // -->    
                                    //$c >= 10: checks if the lines counts in the first page >= 10 then it's needs to add page for the sub total space
                                    //$c <= 17: total lines of a haft page of the first page it's 17 but - 7 for the sub total space
                                    //$lines_counter >= 33: totals lines of a page record..it's 40 but - 7 for the sub total space
                                    //if((($c >= 12 && $c <= 16) || $lines_counter >= 35) && $new_page_counter > 0)
                                    if((($c >= 7 && $c <= 13) || $lines_counter >= 34))
                                    {
                                             
                                            //add new page
                                            $current_page++;
                                            $new_page_counter = 0;
                                            $pdf->pages[$current_page] = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4); 
                                            $pdf_page = $pdf->pages[$current_page];
                                            //end
                                                                        
                                            // Draw rectangle 
                                            $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#FFFFFF")); 
                                            $pdf_page->setLineColor(new Zend_Pdf_Color_Html("#000000")); 
                                            $pdf_page->setLineWidth(0); 
                                            //drawRectangle: left , bottom, width , height
                                            $rm = 577;
                                            $lm = 22;
                                            $bm = 820;
                                            $tm = 20;
                                            $pdf_page->drawRectangle($lm, $tm, $rm, $bm); 
                                            //end     

                                            //$h = 810;        
                                            $h = 800;            
                                            $lines_counter = 0;    

                                    }



                                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
                                    $pdf_page->setFont($font, 13);
                                    $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));

                                    // payment details box
                                    // tax invoice currency to be paid
                                    $h = $h - 10;
                                    $pdf_page->drawText("PAYMENT DETAILS", 380, $h);

                                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
                                    $pdf_page->setFont($font, 11);
                                    $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));

                                    // tax invoice currency to be paid
                                    $h = $h - 10;
                                    $pdf_page->drawText("Tax Invoice Currency to be Paid: ", 380, $h);
                                    
                                    // tax invoice currency to be paid
                                    $h = $h - 10;
                                    $pdf_page->drawText($currency_txt, 380, $h);


                                    //sub total
                                    $h = $h - 10;
                                    $pdf_page->drawText("Sub Total: ".$currency_sign.number_format($sub_total,2,'.',','), 380, $h, 'UTF-8');
                                    
                                    // gst
                                    $h = $h - 10;
                                    $pdf_page->drawText("GST (10%): ".$currency_sign.number_format($gst,2,'.',','), 380, $h, 'UTF-8');
                                    
                                    // total
                                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
                                    $pdf_page->setFont($font, 11);
                                    $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#0000FF"));
                                    $h = $h - 10;
                                    $pdf_page->drawText("Total: ".$currency_sign.number_format($total_amount,2,'.',','), 380, $h, 'UTF-8');
                                    
                                    // return the font soze anf weight to normal
                                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                                    $pdf_page->setFont($font, 10);
                                    $pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));
                                    //
                                    
                                    // payment due date
                                    $h = $h - 10;
                                    $pdf_page->drawText("Payment Due Date: ".$invoice_payment_due_date, 380, $h);
                                    ///
        
                                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                                    $pdf_page->setFont($font, 6);    
                                    $h = $h - 24;
                                    $pdf_page->drawText(wordwrap('Think Innovations - Remote Staff only issues electronic invoices.',10), 380, $h);                

                                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                                    $pdf_page->setFont($font, 6);    
                                    $h = $h - 6;
                                    $pdf_page->drawText(wordwrap('You will need to print this invoice if you require a paper invoice.',10), 380, $h);                
                
               $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$pdf_page->setFont($font, 8);
				$h = $h - 24;
				$pdf_page->drawText('For Invoices in Australian Dollar a Merchant facility fees apply for the following credit card holders:', 100, $h);
				$h = $h - 15;
				$pdf_page->drawText('AMEX : 2%  ', 100, $h);	
				$h = $h - 15;
				$pdf_page->drawText('Visa / MasterCard : 1%    ', 100, $h);	
				$h = $h - 18;
				$pdf_page->drawText('For Invoices in Pounds and USD, 2% Merchant facility fees apply for all credit card payments. ', 100, $h);
				$h = $h - 18;
				$pdf_page->drawText('Note that we prefer payments made via bank transfer or direct debit.   ', 100, $h);	
				
				
				
				//new page
				$pdf_page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
				$pdf->pages[] = $pdf_page; 
				
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$pdf_page->setFont($font, 10);
				$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));
				
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
				$pdf_page->setFont($font, 10);
				
				$pdf_page->drawText('Client invoicing and payment structure: ', 30, 800);
				$pdf_page->drawText('# How to get the hourly charge out rate? ', 80, 780);
				
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$pdf_page->setFont($font, 10);
				
				$pdf_page->drawText('• Staffs are paid on an hourly basis same as charging or invoicing the clients.  ', 100, 765);
				$pdf_page->drawText('• The computation of hourly rate is prorated for the year as is the standard formula anywhere.  ', 100, 750);
				$pdf_page->drawText('• Please refer below sample computation:  ', 100, 735);
				$pdf_page->drawText('Given:   $ 1,700/month, staff work as full time or 8hrs per day  ', 150, 720);
				$pdf_page->drawText('Computation:', 150, 705);
				$pdf_page->drawText('$ 1,700 x 12mos. = $ 20,400/annual ', 150, 690);
				$pdf_page->drawText('$ 20,400 / 52 weeks = $ 392.31/week', 150, 675);
				$pdf_page->drawText('$ 392.31/ 5working days = $ 78.46/day ', 150, 660);
				$pdf_page->drawText('$ 78.46/ 8 hrs (Full Time) = $ 9.81/hour ', 150, 645);
				
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
				$pdf_page->setFont($font, 10);
				
				$pdf_page->drawText('# How and when should  clients be invoiced? ', 80, 625);
				
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$pdf_page->setFont($font, 10);
					
				$pdf_page->drawText('• Once the client confirm who he/she want to work with and have provided the agreed definite start date', 100, 610);
				$pdf_page->drawText('for the staff to work, Remote Staff will then issue a First Month Invoice to the client for 22 working days', 106, 595);
				$pdf_page->drawText('or 176 hours for full time and 88 hours for part time multiply by the hourly charge out rate plus 10% GST', 106, 580);
				$pdf_page->drawText('GST will apply only on those businesses located in Australia.  First month invoices are non-refundable.', 106, 565);
				
				$pdf_page->drawText('• Second invoice - will apply only to those clients whose staff start date does not fall on the 1st day of any', 100, 545);
				$pdf_page->drawText('given month.  The client will be invoice for the remaining days/hours (pro rated) of the current month so', 106, 530);
				$pdf_page->drawText('that we can start the billing every 1st of each month moving forward.  This process is to ensure uniformity', 106, 515);
				$pdf_page->drawText('on all invoices since client invoices are generated every 1st  to 3rd of each month. Any adjustments', 106, 500);
				$pdf_page->drawText('(unused hours or overtime) from previous month will be reflected on this invoice as “adjustments”.', 106, 485);
				
				$pdf_page->drawText('• Regular monthly invoice (3rd invoice) - we invoice clients on a regular monthly basis,  this covers', 100, 465);
				$pdf_page->drawText('the period from day 1 to last day (business days) of any given month.', 106, 450);
				$pdf_page->drawText('Any adjustments (unused hours or overtime) from previous month will be reflected on this invoice', 106, 435);
				$pdf_page->drawText('as “adjustments”.', 106, 420);

				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
				$pdf_page->setFont($font, 10);
				
				$pdf_page->drawText('• Example as follows:', 100, 400);
				
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$pdf_page->setFont($font, 10);
				
				$pdf_page->drawText('Given: ', 106, 385);
				$pdf_page->drawText('January 12, 2011 (date that staff will start to work) ', 150, 370);
				
				
				
				$pdf_page->drawText('Structure: ', 106, 350);
				
				$pdf_page->drawText('First month invoice', 110, 330);
				$pdf_page->drawText('– Jan12 - Feb10   (22 working days)  ', 350, 330);
				
				$pdf_page->drawText('Second invoice', 110, 315);
				$pdf_page->drawText('– Feb11- Feb28    (to close month of Feb.)', 350, 315);

				$pdf_page->drawText('Regular monthly invoice (3rd invoice)', 110, 300);
				$pdf_page->drawText('– Mar01 – Mar31', 350, 300);

				$pdf_page->drawText('Regular monthly invoice (4th  invoice)', 110, 285);
				$pdf_page->drawText('– Apr01 – Apr30', 350, 285);
				
				$pdf_page->drawText('Regular monthly invoice (5th  invoice)', 110, 270);
				$pdf_page->drawText('– May01 – May31  and so on…', 350, 270);
			
				
				$pdf_page->drawText('• Also, please note that total amount of your invoice for the month will depend on the number of days or ', 100, 250);
				$pdf_page->drawText('hours worked by your staff, not just the quote given to you. ', 106, 235);

				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
				$pdf_page->setFont($font, 10);
				
				$pdf_page->drawText('# When should invoices be paid? ', 80, 215);
				
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$pdf_page->setFont($font, 10);
				
				$pdf_page->drawText('• First month invoice  -  this should be paid on or before the staff starts to work with the client or as', 100, 200);
				$pdf_page->drawText('due date stated on the invoice (in case of late invoicing).', 106, 185);
				
				$pdf_page->drawText('• Second invoice – should be paid on or before or as due date stated on the invoice', 100, 170);
				$pdf_page->drawText('• Regular monthly invoice - should be paid on or before or as due date stated on the invoice', 100, 155);
				
				$pdf_page->drawText('# It is a requirement as per agreement that a nominated card (credit card or Ezi debit) will be provided as ', 80, 135);
				$pdf_page->drawText('a security for overdue invoices. ', 88, 120);
				$pdf_page->drawText('Ezi debit applies only for those clients whose businesses located in Australia. ', 88, 105);

				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
				$pdf_page->setFont($font, 10);
				$pdf_page->drawText('Commitment to our strict invoicing and payment terms is required.', 150, 50);
				
				
                // display the pdf file
                $pdfString = $pdf->render();
                //echo $pdfString;





$data = array('client_invoice_id' => $client_invoice_id, 'random_string' => $random_string, 'date_sent' => $ATZ, 'sent_by_id' => $_SESSION['admin_id']);
$db->insert('sent_client_invoice',$data);
$client_invoice_random_string = $random_string;
//
	
	
	
// send email	
///////////////////////////////////////////////	
	$from = trim($_REQUEST['from']);
	$subject = trim($_POST['subject']);
	$message = trim($_REQUEST['message']);
	
	 if(! TEST){
		$invoice_link = "https://".$site."/portal/pdf_report/index.php?ran=".$client_invoice_random_string;
	}else{
		$invoice_link = "http://".$site."/portal/pdf_report/index.php?ran=".$client_invoice_random_string;
	}
	
	
	
	$invoice_link_str = "<p>&nbsp;</p><p style='color:#999999;'>If you are having problem in viewing and downloading the invoice.<br> Try this link <a href='".$invoice_link."'>".$invoice_link."</a></p>";
	
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';
	// Processes \r\n's first so they aren't converted twice.
	$body = str_replace($order, $replace, $message);
	$mail = new Zend_Mail('utf-8');
	//to recipiens
	for ($i = 0; $i < count($_POST['to']); ++$i)
	{
		if($_POST['to'][$i]!="")
		{
			//echo $_POST['to'][$i]."<br>";
			if(! TEST){
				$mail->addTo($_POST['to'][$i] , $_POST['to_name'][$i]);
				$history_changes .= sprintf("SENT TO %s %s,", $_POST['to'][$i], $_POST['to_name'][$i]);
			}else{
				$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
				$history_changes .= sprintf("SENT TO %s %s,", 'devs@remotestaff.com.au', 'Remotestaff Developers');
			}
			
		}	
	}
	
	//cc recipients
	for ($i = 0; $i < count($_POST['cc']); ++$i)
	{
		if($_POST['cc'][$i]!="")
		{
			//echo $_POST['cc'][$i]."<br>";
			if(! TEST){
				$mail->addCc($_POST['cc'][$i] , $_POST['cc_name'][$i]);
				$history_changes .= sprintf("CC TO %s %s,", $_POST['cc'][$i], $_POST['cc_name'][$i]);
			}else{
				$mail->addCc('devs@remotestaff.com.au', $_POST['cc_name'][$i]);
				$history_changes .= sprintf("CC TO %s %s,", 'devs@remotestaff.com.au', 'Remotestaff Developers');
			}
		}	
	}
	
	
	
	
	
	
	
	
	//Atttached invoice.html
	$sql = $db->select()
    ->from(array('c' => 'client_invoice'))
	->join(array('l' => 'leads'), 'l.id = c.leads_id', Array('fname', 'lname', 'email', 'l.company_name', 'l.company_address'))
	->where('c.id =?', $client_invoice_id);
    $invoice = $db->fetchRow($sql);	

    //CURRENCY
    if($invoice['currency'] == 'POUND') $invoice['currency'] = 'GBP' ;
    $sql = $db->select()
    ->from('currency_lookup')
	->where('code =?' , $invoice['currency']);
    $currency = $db->fetchRow($sql);
	$sql = $db->select()
    ->from('client_invoice_details')
	->where('client_invoice_id =?', $client_invoice_id);
    $invoice_items = $db->fetchAll($sql);
    
	$smarty->assign('invoice',$invoice);
	$smarty->assign('client_name',$client_name);
	$smarty->assign('description',$description);
	$smarty->assign('currency',$currency);
	$smarty->assign('invoice_items',$invoice_items);
	$html = $smarty->fetch('invoice.tpl');
	//$attachment2 = $html;
	//$filename2 = "invoice.html";
	//$myImage2 = $attachment2;//$filename;//file_get_contents($tmp_name);
	//$at2 = new Zend_Mime_Part($myImage2);
	//$at2->type= "application/pdf";
	//$at2->disposition = Zend_Mime::DISPOSITION_INLINE;
	//$at2->encoding = Zend_Mime::ENCODING_BASE64;
	//$at2->filename = $filename2;
	//$mail->addAttachment($at2);
	
	$mail->setBodyHtml(stripslashes($body.$html.$invoice_link_str));
	$mail->setFrom($from, $admin_name);
    if(! TEST){
	    $mail->setSubject($subject);
	}else{
	    $mail->setSubject("TEST ".$subject);
	}
	
	
	// attachment name
	// encode data (puts attachment in proper format)

	$pdfdoc = $pdfString;
	$attachment = $pdfdoc;
	$filename = "invoice.pdf";
	$myImage = $attachment;//$filename;//file_get_contents($tmp_name);
	$at = new Zend_Mime_Part($myImage);
	$at->type= "application/pdf";
	$at->disposition = Zend_Mime::DISPOSITION_INLINE;
	$at->encoding = Zend_Mime::ENCODING_BASE64;
	$at->filename = $filename;
	$mail->addAttachment($at);
	
	
	$mail->send($transport);
	echo '<script language="javascript">
       alert("The Invoice has been successfully sent.");
       window.close();
    </script>';
	
	
	$query="UPDATE client_invoice SET post_date ='$ATZ', last_update_date ='$ATZ', status='posted' WHERE status='draft' AND id = $client_invoice_id;";
	$data = array(
		'post_date' => $ATZ ,
		'last_update_date' => $ATZ,
		'status' => 'posted'
	);
	

	$where = "id = ".$client_invoice_id. " AND status = 'draft'";	
	$db->update('client_invoice', $data , $where);

    //history
	$history_changes=substr($history_changes,0,(strlen($history_changes)-1));
    $data = array(
        'client_invoice_id' => $client_invoice_id, 
	    'changes' => 'SEND INVOICE :'.$history_changes, 
	    'changed_by_id' => $_SESSION['admin_id'], 
	    'date_changed' => $ATZ 
    );
    $db->insert('client_invoice_history', $data);
	exit;
}





	

//echo $admin_name." / ".$admin_email;
//id, tracking_no, agent_id, business_partner_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, email_receives_invoice, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip, contact_person, logo_image, company_owner, contact, others, accounts, acct_dept_name1, acct_dept_name2, acct_dept_contact1, acct_dept_contact2, acct_dept_email1, acct_dept_email2, supervisor_staff_name, supervisor_job_title, supervisor_skype, supervisor_email, supervisor_contact, business_owners, business_partners, location_id, old_agent_id, registered_in, registered_url, registered_domain


$sql = $db->select()
	->from(array('c' => 'client_invoice') , Array('invoice_number' , 'leads_id'))
	->join(array('l' => 'leads') , 'l.id = c.leads_id' , Array('fname' , 'lname' , 'email' , 'email_receives_invoice', 'acct_dept_name1', 'acct_dept_name2', 'acct_dept_email1', 'acct_dept_email2', 'supervisor_staff_name', 'supervisor_email', 'secondary_contact_person', 'sec_email' ))
	->where('c.id = ?' , $client_invoice_id);
	


$is_executed = "";
$result = $db->fetchRow($sql);
$leads_id = $result['leads_id'];
$client_name = $result['fname'] ." ".$result['lname'];
$email = $result['email'];

$address_to = $client_name;
$default_email_field = $email;
$invoice_number = $result['invoice_number'];


$supervisor_staff_name = $result['supervisor_staff_name'];
$supervisor_email = $result['supervisor_email'];

$secondary_contact_person = $result['secondary_contact_person'];
$sec_email = $result['sec_email'];

$acct_dept_name1 = $result['acct_dept_name1'];
$acct_dept_email1 = $result['acct_dept_email1'];

$acct_dept_name2 = $result['acct_dept_name2'];
$acct_dept_email2 = $result['acct_dept_email2'];

//$email_receives_invoice = $result['email_receives_invoice'];
//check if the lead has a setting in leads_send_invoice_setting
$sql = $db->select()
    ->from('leads_send_invoice_setting')
	->where('leads_id=?', $leads_id);
$invoice_setting = $db->fetchRow($sql); 
//echo "=> ".$invoice_setting['id'];
if($invoice_setting['id']){
    if($invoice_setting['address_to'] == 'main_acct_holder'){
	    $address_to = $client_name;
	}else{
	    $sql = $db->select()
		    ->from('leads', $invoice_setting['address_to'])
			->where('id=?', $leads_id);
		$address_to = $db->fetchOne($sql);
	}
	
	$sql = $db->select()
		    ->from('leads', $invoice_setting['default_email_field'])
			->where('id=?', $leads_id);
	$default_email_field = $db->fetchOne($sql);
	
	$cc = explode(',',$invoice_setting['cc_emails']);
	//echo "<pre>";
    //print_r($cc);
    //echo "</pre>";

	$cc_emails = array();
	if(count($cc) > 0){
	    foreach($cc as $c){
	        //email,supervisor_email,sec_email,acct_dept_email1,acct_dept_email2
		    if($c == 'email'){
	            $data = array('cc_name' => $client_name, 'cc_email' => $email, 'cc' => $c);
				array_push($cc_emails,$data);		
		    }else if($c == 'supervisor_email'){
			    $data = array('cc_name' => $supervisor_staff_name, 'cc_email' => $supervisor_email, 'cc' => $c);
				array_push($cc_emails,$data);
			}else if($c == 'sec_email'){
			    $data = array('cc_name' => $secondary_contact_person, 'cc_email' => $sec_email, 'cc' => $c);
				array_push($cc_emails,$data);
			}else if($c == 'acct_dept_email1'){
			    $data = array('cc_name' => $acct_dept_name1, 'cc_email' => $acct_dept_email1, 'cc' => $c);
				array_push($cc_emails,$data);
			}else if($c == 'acct_dept_email2'){
			    $data = array('cc_name' => $acct_dept_name2, 'cc_email' => $acct_dept_email2, 'cc' => $c);
				array_push($cc_emails,$data);
			}    
	    }
	}
	//$address_to = $client_name;
}else{
    
	$address_to = $client_name;
	
	if($acct_dept_email2){
	    $default_email_field = $acct_dept_email2;
		$cc_emails = array();
        $data = array('cc_name' => $client_name, 'cc_email' => $email, 'cc' => $c);
	    array_push($cc_emails,$data); 
	}
	
	if($acct_dept_email1){
		$default_email_field = $acct_dept_email1;
		
		$cc_emails = array();
        $data = array('cc_name' => $client_name, 'cc_email' => $email, 'cc' => 'email');
	    array_push($cc_emails,$data);
		if($acct_dept_email2){
            $data = array('cc_name' => $acct_dept_name2, 'cc_email' => $acct_dept_email2, 'cc' => 'acct_dept_email1');
	        array_push($cc_emails,$data);
		}	
	}
	
	if($default_email_field == ''){
	    $default_email_field = $email;
		$cc_emails = array();
	}
	
	
}
//echo "<pre>";
//print_r($cc_emails);
//echo "</pre>";
//exit;

$message = "Hi, 

Attached is your latest invoice. Please note of the due date on the invoice and the method of payment available. 

<strong><i>To know more about Remote Staff invoice please follow this link : http://$site/invoice/index.php</i></strong>


If a remittance advice and proof of payment is not received by the due date, your nominated payment details will be automatically debited the amount due. 


Please note that from March 2010 onwards, merchant facility fees apply for the following credit card holders:  


AMEX : 2%  
Visa / MasterCard : 1%  


There are no fees associated to direct debit payments and EFTs. We prefer this payment method. Should you wish to shift to paying via direct debit, please don't hesitate to contact me.  


Thanks and regards,


".$admin_name;




//$smarty->assign('email_receives_invoice',$email_receives_invoice);
$smarty->assign('address_to',$address_to);
$smarty->assign('default_email_field',$default_email_field);
$smarty->assign('cc_emails', $cc_emails);
$smarty->assign('cc_counter', count($cc_emails));
$smarty->assign('message',$message);
$smarty->assign('client_invoice_id',$client_invoice_id);
$smarty->assign('email', $email);
$smarty->assign('client_name', $client_name);
//$smarty->assign('acct_dept_email2', $acct_dept_email2);
//$smarty->assign('acct_dept_name2', $acct_dept_name2);
$smarty->assign('admin_name', $admin_name);
$smarty->assign('invoice_number', $invoice_number);
$smarty->assign('admin_email', $admin_email);
$smarty->assign('signature_template', $signature_template);
$smarty->display('mail_client_tax_invoice.tpl');
?>