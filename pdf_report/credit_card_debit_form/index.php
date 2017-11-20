<?php
header('Content-Type: application/pdf');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include('../../conf/zend_smarty_conf.php');


$id = $_REQUEST['id'];
if($id==NULL){
	die(" ");
}


$pages = 0;

$pdf = Zend_Pdf::load('remote_staf_credit_card_form.pdf');
$pdf_page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
$pdf_page = $pdf->pages[$pages];


$pdfString = $pdf->render();
$filename ="RemoteStaffCreditCardForm_".$fname.$lname.".pdf" ;
$fsize = filesize('./remote_staf_credit_card_form.pdf');

header("Content-Length: ".$fsize);
header("Content-Transfer-Encoding: binary");

echo $pdfString;
?>