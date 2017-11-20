<?php
header('Content-type: application/pdf');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include('../../conf/zend_smarty_conf.php');
include '../../config.php';
include '../../conf.php';


$site = $_SERVER['HTTP_HOST'];
$ran = $_REQUEST['ran'];
$queryCheckRan = "SELECT * FROM set_up_fee_invoice WHERE ran = '$ran';";
//echo $queryCheckRan;
$result =  mysql_query($queryCheckRan);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array($result);
	$set_fee_invoice_id = $row['id'];
	
}
else{
	die("Invalid Code");
}




//$set_fee_invoice_id = $_REQUEST['id'];
// parse the data from table  set_up_fee_invoice
$query = "SELECT leads_name, leads_email , status, invoice_date ,DATE_FORMAT(draft_date,'%D %b %Y'),DATE_FORMAT(post_date,'%D %b %Y'), 
		  sub_total, gst, total_amount, invoice_number, currency  , gst_flag ,  DATE_FORMAT(paid_date,'%D %b %Y') ,drafted_by, drafted_by_type , 
		  leads_company, leads_address
		  FROM set_up_fee_invoice WHERE id = $set_fee_invoice_id;";
$result = mysql_query($query);
list($leads_name,$leads_email,$status,$invoice_date,$draft_date,$post_date,$sub_total,$gst,$total_amount,$invoice_number,$currency ,$gst_flag ,$paid_date ,$drafted_by, $drafted_by_type, $leads_company, $leads_address)=mysql_fetch_array($result);

//AUD","USD","POUND
if($currency == "AUD"){
	$currency_txt = "Tax Invoice to be paid in Australian Dollar (AUD)";
	$currency_symbol = " $";
	$bank_account = "Account Number: 490 589 267 | BSB: 082 140 ";
	$tax_str = "GST";
	
}

if($currency == "USD"){
	$currency_txt = "Tax Invoice to be paid in United States Dollar (USD)";
	$currency_symbol = " $";
	$bank_account = "Account Number: THIINUSD01";
	$tax_str = "TAX";
}

if($currency == "POUND"){
	$currency_txt = "Tax Invoice to be paid in United Kingdom Pounds (GBP)";
	$currency_symbol = " £";
	$tax_str = "VAT";
	
}

function getCreator($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		if($row['work_status']=="AFF") $work_status ="Affiliate";
		if($row['work_status']=="BP") $work_status ="Business Partner";
		$name = $work_status." ".strtoupper($row['fname']." ".$row['lname']);
	}
	else if($created_by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Admin ".strtoupper($row['admin_fname']." ".$row['admin_lname']);
	}
	else{
		$name="";
	}
	return $name;
	
}

$name = getCreator($drafted_by, $drafted_by_type);
$pages = 0;


//Zend_Loader::registerAutoload();

$pdf = Zend_Pdf::load('client_set_up_fee_tax_invoice.pdf');

$pdf_page = $pdf->pages[$pages];


$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
$pdf_page->setFont($font, 15);
// Set up Fee Tax Invoice No.
$pdf_page->drawText("RECRUITMENT SETUP FEE TAX INVOICE ".$invoice_number, 100, 658);
$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
$pdf_page->setFont($font, 10);
$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));


// Leads Info
$pdf_page->drawText($leads_name, 66, 606);
$pdf_page->drawText($leads_email, 66, 595);
$pdf_page->drawText($leads_company, 116, 584);
$pdf_page->drawText($leads_address, 128, 572);
$pdf_page->drawText($name, 58, 548);
$pdf_page->drawText($draft_date, 107, 497);
//$pdf_page->drawText($bank_account, 34, 408);
//account number
/*
if($currency == "AUD")
{
	$pdf_page->drawText("Account Name: Think Innovations Pty. Ltd", 36, 426);
	$pdf_page->drawText("BSB: 082 973", 36, 414);
	$pdf_page->drawText("ACCOUNT NUMBER: 49 058 9267", 36, 402);
	$pdf_page->drawText("BANK BRANCH : Darling Street, Balmain NSW Australia 2041", 36, 390);
	$pdf_page->drawText("SWIFT CODE: NATAAU3302S", 36, 378);
	
	$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
	$pdf_page->setFont($font, 10);
	$pdf_page->drawText("3. Direct Debit Payment through EZI Debit", 32, 355);


	
}
if($currency == "USD")
{
	$pdf_page->drawText("Account Name: Think Innovations Pty Ltd", 36, 426);
	$pdf_page->drawText("Account Number: THIINUSD01", 36, 414);
	$pdf_page->drawText("BANK BRANCH : Darling Street, Balmain NSW 2041", 36, 402);
	$pdf_page->drawText("SWIFT CODE: NATAAU3302S", 36, 390);
	
}
if($currency == "POUND") {

	$pdf_page->drawText("HSBC", 36, 426);
	$pdf_page->drawText("Think Innovations Pty Ltd", 36, 414);
	$pdf_page->drawText("BSC: 40-05-09", 36, 402);
	$pdf_page->drawText("ACC: 61506323", 36, 390);
	
}
*/


$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
$pdf_page->setFont($font, 10);
$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));

$pdf_page->setLineWidth(0.5); 

$num=0;
$y = 302;
$new_y = 840;
$current_page = 0;
$page_num = 0;

function rightAlignAmount($str)
{
	$width = 12;
	$expected_space = ($width - (strlen($str)));
	for($i=0; $i<$expected_space;$i++){
		$space.=" ";
	}
	return $space.$str;
	
}


$query = "SELECT id, description, amount,counter  
		  FROM set_up_fee_invoice_details s 
		  WHERE set_fee_invoice_id = $set_fee_invoice_id  ;";
$result= mysql_query($query);

while(list($id, $description, $amount,$count )=mysql_fetch_array($result))
{
	if($amount=="" or $amount == " "){
		$amount =" ";
	}else{
		$amount = $currency_symbol.number_format($amount,2,'.',',');
	}	
	
	$string = $description;
	$patterns[0] = '/&pound;/';
	$replacements[0] = '£';
	$description =  preg_replace($patterns, $replacements, $string);

		//draw a box of line
		// Configuration
		$y = $y - 30;
		$y2 = ($y - 30); // the height of the row
		
		if ($y > 80) {
			// horizontal line top
			$pdf_page->drawLine(21, $y, 577, $y);
			// vertical line left side
			$pdf_page->drawline(21,$y,21, $y2);
			// vertical line side item
			$pdf_page->drawline(70,$y,70, $y2);
			// vertical line side description
			$pdf_page->drawline(495,$y,495, $y2);
			// vertical right side
			$pdf_page->drawline(577,$y,577,$y2);
			// horizontal bottom
			$pdf_page->drawLine(21, $y2, 577, $y2);
			
			// display the data set up fee tax invoice details
			// ITEM NO
			if ($count!=""){		
				$num++;	
				// ITEM NO	
				$pdf_page->drawText($num, 35, ($y-20));
			}
			//DESCRIPTION
			$pdf_page->drawText($description, 80, ($y-20));
			// AMOUNT 
			$pdf_page->drawText(rightAlignAmount($amount), 500, ($y-20));
			
		
			
		}else {
			//$pages =$pages+1;
			//$pdf_page->drawText('Page '.$pages, 70, 30);
			$y = 800;
			$y = $y - 30;
			$y2 = ($y - 30); // the height of the row
			
			$pdf_page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
			$pdf->pages[] = $pdf_page; 
			
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
			$pdf_page->setFont($font, 10);
			$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));
			
			$pdf_page->setLineWidth(0.5); 
			
			// horizontal line top
			$pdf_page->drawLine(21, $y, 577, $y);
			// vertical line left side
			$pdf_page->drawline(21,$y,21, $y2);
			// vertical line side item
			$pdf_page->drawline(70,$y,70, $y2);
			// vertical line side description
			$pdf_page->drawline(495,$y,495, $y2);
			// vertical right side
			$pdf_page->drawline(577,$y,577,$y2);
			// horizontal bottom
			$pdf_page->drawLine(21, $y2, 577, $y2);
			
			// display the data set up fee tax invoice details
			// ITEM NO
			if ($count!=""){		
				$num++;	
				// ITEM NO	
				$pdf_page->drawText($num, 35, ($y-20));
			}
			//DESCRIPTION
			$pdf_page->drawText($description, 80, ($y-20));
			// AMOUNT 
			$pdf_page->drawText(rightAlignAmount($amount), 500, ($y-20));
			
		}
		
}

function spacer($str)
{
	$width = 45;
	$expected_space = ($width - (strlen($str)));
	for($i=0; $i<$expected_space;$i++){
		$space.=" ";
	}
	return $space.$str;
	
}

$sub_total_str = "Sub Total ".$currency_symbol.number_format($sub_total,2,'.',',');
$gst_str = $tax_str.$currency_symbol.number_format($gst,2,'.',',');
$total_str = "Total Amount ".$currency_symbol.number_format($total_amount,2,'.',',');

$y = $y-50;
if($y == 72){
	$pdf_page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
	$pdf->pages[] = $pdf_page; 
	$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
	$pdf_page->setFont($font, 10);
	$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));
	$y=800;
	$pdf_page->drawText($currency_txt, 250, $y);
	$y = $y-20;
	$pdf_page->drawText(spacer($sub_total_str), 300, $y);
	//$pdf_page->drawText("Variable :" . $y, 150, $y);
	$y = $y-20;
	$pdf_page->drawText(spacer($gst_str), 300, $y);
	$y = $y-20;
	$pdf_page->drawText(spacer($total_str), 300, $y);
	//$pdf_page->drawText("Variable :" . $y, 150, $y);
	
	$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
	$pdf_page->setFont($font, 8);
	$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#999999"));

	$y = $y-20;
	$pdf_page->drawText("Think Innovations - Remote Staff only issues electronic invoices. You will need to print this invoice if you require a paper invoice", 70, $y);
	$y = $y-10;
	$pdf_page->drawText("By Paying Our Invoice(s) You Acknowlege & Agree To Our Service Agreement & Terms & Conditions Found On The Website ".$site, 30, $y);
	//$pdf_page->drawText('Page '.$pages, 70, 30);
}else{
	$pdf_page->drawText($currency_txt, 250, $y);
	//$pdf_page->drawText("Variable :" . $y, 150, $y);
	$y = $y-20;
	$pdf_page->drawText(spacer($sub_total_str), 300, $y);
	//$pdf_page->drawText("Variable :" . $y, 150, $y);
	$y = $y-20;
	$pdf_page->drawText(spacer($gst_str), 300, $y);
	$y = $y-20;
	$pdf_page->drawText(spacer($total_str), 300, $y);
	//$pdf_page->drawText("Variable :" . $y, 150, $y);
	
	$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
	$pdf_page->setFont($font, 8);
	$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#999999"));
	
	$y = $y-20;
	$pdf_page->drawText("Think Innovations - Remote Staff only issues electronic invoices. You will need to print this invoice if you require a paper invoice", 70, $y);
	$y = $y-10;
	$pdf_page->drawText("By Paying Our Invoice(s) You Acknowlege & Agree To Our Service Agreement & Terms & Conditions Found On The Website ".$site, 30, $y);

}
	

$pdfString = $pdf->render();
header('Content-Disposition: inline; filename="'.$filename.'"');
header("Content-Transfer-Encoding: binary");

echo $pdfString;
?>
