<?php
//2011-01-24 Normaneil Macutay <normanm@remotestaff.com.au>
//	- remove status display in the pdf file
//2012-01-24 Normaneil Macutay <normanm@remotestaff.com.au>
// - changed the client name display if the lead has a send invoice setting

header('Content-type: application/pdf');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Disposition: attachment; filename="invoice.pdf"');

include('../conf/zend_smarty_conf.php');

$client_invoice_id= $_REQUEST['client_invoice_id'];

//create pdf
$sql="SELECT CONCAT(l.fname, ' ',l.lname)AS client_name, c.status, DATE_FORMAT(c.invoice_date,'%D %b %Y')AS invoice_date, c.invoice_month, DATE_FORMAT(c.draft_date,'%D %b %Y')AS draft_date, DATE_FORMAT(c.post_date,'%D %b %Y')AS post_date, DATE_FORMAT(c.paid_date,'%D %b %Y')AS paid_date,description, c.invoice_year , c.sub_total , c.gst, c.total_amount,l.company_name,l.company_address, c.payment_details,c.invoice_number,c.currency ,DATE_FORMAT(invoice_payment_due_date,'%D %b %Y')AS invoice_payment_due_date,l.email, c.leads_id FROM client_invoice c LEFT JOIN leads l ON l.id = c.leads_id WHERE c.id = $client_invoice_id;";

$result = $db->fetchRow($sql);
$is_executed = "";
$leads_id = $result['leads_id'];
$client_name = $result['client_name'];
$description = $result['description'];

//check if the lead has a setting in leads_send_invoice_setting
$sql = $db->select()
    ->from('leads_send_invoice_setting')
	->where('leads_id=?', $leads_id);
$invoice_setting = $db->fetchRow($sql); 

if($invoice_setting['id']){
    if($invoice_setting['address_to'] == 'main_acct_holder'){
	    $client_name = $result['client_name'];
		//$description = $result['description'];
	}else{
	    $sql = $db->select()
		    ->from('leads', $invoice_setting['address_to'])
			->where('id=?', $leads_id);
		$client_name = $db->fetchOne($sql);
		//$description = $result['description'];	
	}
}
//echo $client_name;
//exit;

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
$email = $result['email'];


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

if($currency == "POUND" or $currency == "GBP")
{
    $currency_txt = "GBP "; 
    //$currency_sign = "GBP ";
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
                //$pdf_page->drawText($post_date, 412, 548);
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
                                    $pdf_page->drawText("Sub Total: ".$currency_sign.number_format($sub_total,2,'.',','), 380, $h , 'UTF-8');
                                    
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
				$pdf_page->drawText('Ezi debit applies only for those clients whose businesses located in Australia.', 88, 105);

				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD );
				$pdf_page->setFont($font, 10);
				$pdf_page->drawText('Commitment to our strict invoicing and payment terms is required.', 150, 50);

                // display the pdf file
                $pdfString = $pdf->render();
				
				
				
				
				
				
	//history
	$AusTime = date("H:i:s"); 
    $AusDate = date("Y")."-".date("m")."-".date("d");
    $ATZ = $AusDate." ".$AusTime;
    $data = array(
        'client_invoice_id' => $client_invoice_id, 
	    'changes' => 'INVOICE EXPORTED TO PDF', 
	    'changed_by_id' => $_SESSION['admin_id'], 
	    'date_changed' => $ATZ 
    );
	$db->insert('client_invoice_history', $data);			
				
				
				
				
				
				
                echo $pdfString;
				exit;
?>