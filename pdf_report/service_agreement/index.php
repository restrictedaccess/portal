<?php
header('Content-type: application/pdf');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include('../../conf/zend_smarty_conf.php');
include '../../config.php';
include '../../conf.php';


$site = $_SERVER['HTTP_HOST'];

$ran = $_REQUEST['ran'];
$queryCheckRan = "SELECT * FROM service_agreement WHERE ran = '$ran';";
//echo $queryCheckRan;
$result =  mysqli_query($link2, $queryCheckRan);
$ctr=@mysqli_num_rows($result);
if ($ctr >0 )
{
	$row = mysqli_fetch_array($result);
	$service_agreement_id = $row['service_agreement_id'];
	
}
else{
	die("Invalid Code");
}




//$service_agreement_id = $_REQUEST['id'];
if($service_agreement_id==NULL){
	die(" ");
}


// parse the data from table  set_up_fee_invoice

$query = "SELECT s.leads_id,CONCAT(l.fname,' ',l.lname) ,s.created_by,s.created_by_type,quote_no, l.company_name, l.company_address, l.mobile, l.email,DATE_FORMAT(s.date_created,'%D %b %Y') 
		  FROM service_agreement s
		  LEFT JOIN leads l ON l.id = s.leads_id 
		  LEFT JOIN quote q ON q.id = s.quote_id 
		  WHERE s.service_agreement_id = $service_agreement_id ;";
	//echo $query;
$data = mysqli_query($link2, $query);
list($leads_id,$leads_name,$created_by,$created_by_type,$quote_no, $company_name, $company_address, $mobile, $email,$date_created )=mysqli_fetch_array($data);


$pages = 0;
$pdf = Zend_Pdf::load('PART_1_Service_Agreement.pdf');
$pdf_page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
$pdf_page = $pdf->pages[$pages];

function getCreator($by , $by_type)
{
	if($by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $by;";
		$data = mysqli_query($link2, $query);
		$row = mysqli_fetch_array($data);
		$name = "c/o ".$row['work_status']." ".$row['fname'] ." ".$row['lname']." ".$row['email'];
		
	}
	else if($by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $by;";
		$data = mysqli_query($link2,$query);
		$row = mysqli_fetch_array($data);
		$name = "c/o ADMIN ".$row['admin_fname'] ." ".$row['admin_lname']." ".$row['admin_email'];
	}
	else{
		$name="";
	}
	return $name;
	
}
//SCHEDULE 1
// PRO FORMA REQUEST FOR SERVICE
$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
$pdf_page->setFont($font, 10);
$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#FF0000"));
$pdf_page->drawText("PART 1", 247, 647 );
$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));
$pdf_page->drawText("PRO FORMA REQUEST FOR SERVICE", 184, 636 );




$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#999999"));
$pdf_page->setFont($font, 9);



// Leads Info
$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));

$pdf_page->drawText($date_created, 72, 575);
$pdf_page->drawText($leads_name, 72, 566);

$pdf_page->drawText($company_name, 88, 547);
$pdf_page->drawText($company_address, 88, 509);
$pdf_page->drawText($mobile, 90, 498);
$pdf_page->drawText($email, 90, 479);



if(LOCATION_ID == 1){
	//left
	$pdf_page->drawText('104 / 529 Old South Head Road, Rose Bay, NSW 2029', 36, 734);
	$pdf_page->drawText('USA Phone: +1(415) 376 1472', 36, 720);
	$pdf_page->drawText('AUS Phone: +61(2) 8005 0569', 36, 710);
	$pdf_page->drawText('UK Phone: +44(020) 3286 9010', 36, 700);
	$pdf_page->drawText('Email : '.getCreator($created_by,$created_by_type), 36, 680);
	
	//right
	$pdf_page->drawText('Think Innovations Pty. Ltd. ABN 37 094 364 511', 329, 734);
	$pdf_page->drawText('Website: www.remotestaff.com.au', 329, 724);
	
	
	//center 450
	$pdf_page->drawText('TO: Think Innovations- Remote Staff', 36, 450);
	$pdf_page->drawText('ABN: 37-094-364-511', 36, 440);
	$pdf_page->drawText('Contact: Chris Jankulovski', 36, 430);
	$pdf_page->drawText('Telephone: +61 2 8014 9196', 36, 420);
	$pdf_page->drawText('Facsimile:+61 2 8088 7247', 36, 410);
	$pdf_page->drawText('US Fax : (650) 745 1088', 36, 400);
	$pdf_page->drawText('Email: chrisj@remotestaff.com.au', 36, 390);





	
}else if(LOCATION_ID == 2){
	//left
	$pdf_page->drawText('2 Martin House, Flat 2, 179 - 181 North End Road', 36, 734);
	$pdf_page->drawText('London W14 9NL UK', 36, 724);
	$pdf_page->drawText('USA Phone: +1(415) 376 1472', 36, 710);
	$pdf_page->drawText('AUS Phone: +61(2) 8005 0569', 36, 700);
	$pdf_page->drawText('UK Phone: +44(020) 3286 9010', 36, 690);
	$pdf_page->drawText('Email : '.getCreator($created_by,$created_by_type), 36, 670);
	//right
	$pdf_page->drawText('Think Innovations Pty. Ltd. ABN 37 094 364 511', 329, 734);
	$pdf_page->drawText('Website: www.remotestaff.co.uk', 329, 724);
	
	//center 450
	$pdf_page->drawText('TO: Remote Staff Limited', 36, 450);
	$pdf_page->drawText('Contact: Chris Jankulovski ', 36, 440);
	$pdf_page->drawText('Company Number: 6978568 ', 36, 430);
	$pdf_page->drawText('Telephone: +44 2033 970 990, +61 2 8006 1975 ', 36, 420);
	$pdf_page->drawText('Facsimile:+44 8704718094 ', 36, 410);
	$pdf_page->drawText('US Fax : (650) 745 1088', 36, 400);
	$pdf_page->drawText('Email: chrisj@remotestaff.co.uk , ricag@remotestaff.co.uk', 36, 390);

}else{
	//left
	$pdf_page->drawText('104 / 529 Old South Head Road, Rose Bay, NSW 2029', 36, 734);
	$pdf_page->drawText('USA Phone: +1(415) 376 1472', 36, 720);
	$pdf_page->drawText('AUS Phone: +61(2) 8005 0569', 36, 710);
	$pdf_page->drawText('UK Phone: +44(020) 3286 9010', 36, 700);
	$pdf_page->drawText('Email : '.getCreator($created_by,$created_by_type), 36, 680);
	
	//right
	$pdf_page->drawText('Think Innovations Pty. Ltd. ABN 37 094 364 511', 329, 734);
	$pdf_page->drawText('Website: www.remotestaff.com.au', 329, 724);
	
	
	//center 450
	$pdf_page->drawText('TO: Think Innovations- Remote Staff', 36, 450);
	$pdf_page->drawText('ABN: 37-094-364-511', 36, 440);
	$pdf_page->drawText('Contact: Chris Jankulovski', 36, 430);
	$pdf_page->drawText('Telephone:+61 2 8014 9196, +61 2 8006 1975', 36, 420);
	$pdf_page->drawText('Facsimile:+61 2 8088 7247', 36, 410);
	$pdf_page->drawText('US Fax : (650) 745 1088', 36, 400);
	$pdf_page->drawText('Email: chrisj@remotestaff.com.au', 36, 390);
}



//Service Agreement Details
$sql = "SELECT service_agreement_details_id, service_agreement_details FROM service_agreement_details s WHERE service_agreement_id = $service_agreement_id;";
$result = mysqli_query($link2, $sql);	
$counter=0;
$y = 340;
$page=0;
while(list($service_agreement_details_id, $service_agreement_details)=mysqli_fetch_array($result))
{	
	$string = $service_agreement_details;
	$patterns[0] = '/&pound;/';
	$replacements[0] = '£ ';
	$service_agreement_details =  preg_replace($patterns, $replacements, $string);

	$counter++;
	$y = $y-40;
	if ($y > 80) {
	
		$pdf_page->drawText($counter.")", 35, $y );
		$str =  $service_agreement_details;
		
        $str = trim($str);
        $chars = preg_split('/Monthly/', $str, -1, PREG_SPLIT_NO_EMPTY);
        $pdf_page->drawText(trim($chars[0]), 50, $y);

        if (preg_match('/TAX/',$chars[1])){
            $chars2 = preg_split('/TAX/', $chars[1], -1, PREG_SPLIT_NO_EMPTY);
            $chars2[0] = trim($chars2[0]);
            $pdf_page->drawText("Monthly ".substr($chars2[0], 0, ( strlen($chars2[0]) -1 ) )  , 50, $y-15);
            $pdf_page->drawText("+ TAX ".$chars2[1], 50, $y-30);
        }else{
            $chars2 = preg_split('/GST/', $chars[1], -1, PREG_SPLIT_NO_EMPTY);
            $chars2[0] = trim($chars2[0]);
            $pdf_page->drawText("Monthly ".substr($chars2[0], 0, ( strlen($chars2[0]) -1 ) )  , 50, $y-15);
            $pdf_page->drawText("+ GST ".$chars2[1], 50, $y-30);
        }
		
	}
	else{
		$y = 750;		
		$pdf_page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
		$pdf->pages[] = $pdf_page; 
			
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$pdf_page->setFont($font, 9);
		$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#000000"));
		
		$pdf_page->drawText($counter.")", 60, $y );
		$str =  $service_agreement_details;
		//$chars = preg_split('/Monthly/', $str, -1, PREG_SPLIT_NO_EMPTY);
		//$pdf_page->drawText($chars[0], 80, $y);
		//$pdf_page->drawText("Monthly ".$chars[1], 80, $y-15);
		$str = trim($str);
        $chars = preg_split('/Monthly/', $str, -1, PREG_SPLIT_NO_EMPTY);
        $pdf_page->drawText(trim($chars[0]), 80, $y);

        if (preg_match('/TAX/',$chars[1])){
            $chars2 = preg_split('/TAX/', $chars[1], -1, PREG_SPLIT_NO_EMPTY);
            $chars2[0] = trim($chars2[0]);
            $pdf_page->drawText("Monthly ".substr($chars2[0], 0, ( strlen($chars2[0]) -1 ) )  , 80, $y-15);
            $pdf_page->drawText("+ TAX ".$chars2[1], 80, $y-30);
        }else{
            $chars2 = preg_split('/GST/', $chars[1], -1, PREG_SPLIT_NO_EMPTY);
            $chars2[0] = trim($chars2[0]);
            $pdf_page->drawText("Monthly ".substr($chars2[0], 0, ( strlen($chars2[0]) -1 ) )  , 80, $y-15);
            $pdf_page->drawText("+ GST ".$chars2[1], 80, $y-30);
        }
		
		

		
	}	

	


	
}	


$pdf_page->drawText("PERIOD SERVICES TO BE PROVIDED: Upon receipt of the payment for the set up invoice attached with this contract.", 35, ($y-100));
$pdf_page->drawText("Signed by : ___________________________", 35, ($y-120));
$pdf_page->drawText("Remote Staff authorised representative", 35, ($y-135));
$pdf_page->drawText("Date :         ___________________________", 35, ($y-150));


$pdf_page->drawText("____________________________________", 380, ($y-120));
$pdf_page->drawText("Your authorised representative", 380, ($y-135));
$pdf_page->drawText("Date :         ___________________________", 380, ($y-150));





$pdf_page->setFont($font, 8);
$pdf_page->setFillColor(new Zend_Pdf_Color_Html("#999999"));
$pdf_page->drawText("Think Innovations - Remote Staff only issues electronic invoices. You will need to print this invoice if you require a paper invoice", 70, 50);
$pdf_page->setFont($font, 6);
$pdf_page->drawText("If you chooce to take up our staffing solution, you acknowlege & agree to our Service Agreement & Terms & Conditions found on our website ".$site, 80, 40);





$pdfString = $pdf->render();
$filename ="PART_1_Service_Agreement_".$leads_name.".pdf" ;


header("Pragma: public");
header("Expires: 0"); //set expiration time
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header('Content-Disposition: inline; filename="'.$filename.'"');
header("Content-Transfer-Encoding: binary");
//header("Cache-Control: no-cache");
//header("Pragma: no-cache");
//echo LOCATION_ID;
echo $pdfString;
?>
