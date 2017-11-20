<?
function sendZendMail($email_to,$subject,$message,$from_address,$from_name){
	$mail = new Zend_Mail();
	$mail->setBodyHtml($message);
	$mail->setFrom($from_address,$from_name);
	$mail->addTo($email_to);
	$mail->setSubject($subject);
	$mail->send($transport);
}
	
function imageResize($filename,$maxwidth,$maxheight){ 
    include("lib/SimpleImage.php");
    $image = new SimpleImage(); 
    $image->load($filename);
    $image->resizeToWidth($maxwidth);
    if($image->getHeight($filename)>$maxheight) $image->resizeToHeight($maxheight);
    $image->save($filename);
}
function checkClientsBPAFF($agent_id,$business_partner_id){
	global $link2;
    //return $agent_id ." #|# ". $business_partner_id;
    $query = "SELECT fname, lname , email FROM agent a WHERE agent_no = $business_partner_id;";
    $result = mysqli_query($link2, $query);
    list($fname, $lname , $email)=mysqli_fetch_array($result);
    $BPName =  "Business Partner : ".$fname." ".$lname;
    
    if($agent_id != $business_partner_id){
        $query = "SELECT fname, lname , email FROM agent a WHERE agent_no = $agent_id AND work_status = 'AFF';";
        $result = mysqli_query($link2, $query);
        list($fname, $lname , $email)=mysqli_fetch_array($result);
        $AFFName = "<br>Affiliates : ".$fname." ".$lname;
    }
    
    return $BPName.$AFFName;
}


function checkLeadsOwner($agent_id,$business_partner_id){
    global $db;
    if($agent_id != $business_partner_id){
        $query = "SELECT fname, lname , email FROM agent a WHERE agent_no = $business_partner_id;";
        $result = $db->fetchRow($query);        
        echo "<div class=\"leads_list_note\">NOTE : Serviced by Business Partner " . $result['fname']." ".$result['fname']."</div>";
    }
}
function getBPId($agent_id){
	global $link2;
    $sql = "SELECT agent_no , work_status FROM agent a WHERE agent_no = $agent_id;";
    $result=mysqli_query($link2, $sql);
    if(!$result) die ("Error in Script<br>".$sql);
    list($agent_no, $work_status)=mysqli_fetch_array($result);
    if($work_status == "AFF"){
        $sqlBP="SELECT f.business_partner_id FROM agent_affiliates f WHERE f.affiliate_id = $agent_id;";
        //echo $sqlBP;
        $data = mysqli_query($link2, $sqlBP);
        list($business_partner_id) = mysqli_fetch_array($data);
        return $business_partner_id;
        
    }else{
        return $agent_no; 
    }
}

function checkAgentIdForAdmin($agent_id){
	global $link2;
    if($agent_id!=""){
        $sql = "SELECT CONCAT(fname,' ',lname), email, work_status FROM agent a WHERE agent_no = $agent_id;";
        $result=mysqli_query($link2, $sql);
        if(!$result) die ("Error in Script<br>".$sql);
        list($agent_name,$email, $work_status)=mysqli_fetch_array($result);
        if($work_status == "AFF"){
            //return strtoupper($work_status)." ".$agent_name." ".$email; 
            // Check to whose Business Partner is this Affiate is?
            $sqlBP="SELECT CONCAT(a.fname,' ',a.lname),a.email FROM agent_affiliates f 
                    JOIN agent a ON a.agent_no = f.business_partner_id 
                    WHERE f.affiliate_id = $agent_id;";
            //echo $sqlBP;
            $data = mysqli_query($link2, $sqlBP);
            list($bp_name,$bp_email) = mysqli_fetch_array($data);
            $aff_name = "<span class=\"agent1\">Affiliate : ".$agent_name."</span>";
            $aff_name .="<div class=\"agent2\">Business Partner : ".$bp_name."</div>";
            return $aff_name;
            
        }else{
            return "<span class=\"agent1\">Business Partner : ".$agent_name."</span>"; 
        }
    }else{
        return "<span class=\"agent1\">Unknown</span>"; 
    }
}



function checkAgentAffiliates($leads_id){
	global $link2;
    //return "Hello World ".$leads_id;
    $sql = "SELECT agent_id ,  business_partner_id FROM leads l WHERE id = $leads_id;";
    $result = mysqli_query($link2, $sql);
    list($agent_id ,  $business_partner_id)=mysqli_fetch_array($result);
    
    $query2 = "SELECT fname, lname , email FROM agent a WHERE agent_no = $business_partner_id;";
    $result2 = mysqli_query($link2, $query2);
    list($fname2, $lname2 , $email2)=mysqli_fetch_array($result2);
    
    
    if($agent_id == $business_partner_id){
        return "BP : ".$fname2." ".$lname2 ." [ ". $email2." ] ";
    }else{
        $query1 = "SELECT fname, lname , email FROM agent a WHERE agent_no = $agent_id;";
        $result1 = mysqli_query($link2, $query1);
        list($fname, $lname , $email)=mysqli_fetch_array($result1);
    
        return "BP : ".$fname2." ".$lname2 ." [ ". $email2." ] <br>AFF : ".$fname." ".$lname ." [ ". $email." ]";
    }
    
}




function getWorkStatusLongDescription($work_status){
    $work_statusLongDescArray = array("Full-Time 9hrs w/ 1hr lunch","Part-Time 4hrs","Freelancer - Hourly Rate");
    $work_statusArray = array("Full-Time","Part-Time","Freelancer");
    for($i=0;$i<count($work_statusArray);$i++){
        if($work_status == $work_statusArray[$i]){
            $work_status =$work_statusLongDescArray[$i];
            break;
        }
    }
    return $work_status;
}
function filterfield($fieldname){
    $fieldname = str_replace("'", "",$fieldname);
    $fieldname = str_replace("ñ", 'n',$fieldname);
    $fieldname = stripslashes($fieldname);
    if(get_magic_quotes_gpc())  // prevents duplicate backslashes
    {
    $fieldname = stripslashes($fieldname);
    
    }
    if (phpversion() >= '4.3.0')
    {
    $fieldname = addslashes($fieldname);
    }
    else
    {
    $fieldname = addslashes($fieldname);
    }
    
    //return the filtered data
    return $fieldname;

}
function filterfield2($str){

    $str = str_replace(",", "&nbsp;",$str);
}

function RandomCode(){
/*
$time =time();
$y =date('Y');
$m =date('m');
$d= date('d');

  
   $code=$time.substr(microtime(),2).$y.$d.$m;
 */  
 $code =generatecode();
   return $code;
   
}


function generatecode(){
        $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','W');
        $lenght = 8; 
        (string) $keygen = '';
        for($i=0;$i<=$lenght;$i++){
            $keygen .= $chars[rand(0,37)];         }
        return $keygen;
} 

function format_date($original='', $format="%B %d, %Y") {
    $format = ($format=='date' ? "%m-%d-%Y" : $format);
    $format = ($format=='datetime' ? "%m-%d-%Y %H:%M:%S" : $format);
    $format = ($format=='mysql-date' ? "%Y-%m-%d" : $format);
    $format = ($format=='mysql-datetime' ? "%Y-%m-%d %h:%M:%S" : $format);
    return (!empty($original) ? strftime($format, strtotime($original)) : "" );
}

function format_date_month($original='', $format="%B - %Y") {
    $format = ($format=='date' ? "%m-%d-%Y" : $format);
    $format = ($format=='datetime' ? "%m-%d-%Y %H:%M:%S" : $format);
    $format = ($format=='mysql-date' ? "%Y-%m-%d" : $format);
    $format = ($format=='mysql-datetime' ? "%Y-%m-%d %H:%M:%S" : $format);
    return (!empty($original) ? strftime($format, strtotime($original)) : "" );
}

function ATZ()
{
    //putenv('TZ=Australia/Perth');
    //format the timezone for SQL
    //$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));
    //mysql_query('SET time_zone='.$timeZone);
    putenv ('TZ=Australia/Perth'); 
    $AusTime = date("H:i:s"); 
    $AusDate = date("Y")."-".date("m")."-".date("d");
    $ATZ = $AusDate." ".$AusTime;
    return $ATZ;
}



function get_rand_id()
{
  $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $lenght = 44; 
        (string) $keygen = '';
        for($i=0;$i<=$lenght;$i++){
            $keygen .= $chars[rand(0,37)]; 
        }
  return $keygen;
} 


function setConvertTimezones($original_timezone, $converted_timezone , $start_time, $finish_time){
    if($original_timezone!=""){
        $converted_timezone = new DateTimeZone("$converted_timezone");
        $original_timezone = new DateTimeZone($original_timezone);
         
        $start_time_str = $start_time;
        if ($start_time_str == null) {
            $start_time_hour = "";
        }
        else {
            //INFO: Due to the client_start_work_hour field type, I had to append a :00
            $time = new DateTime($start_time_str.":00", $original_timezone);
            $time->setTimeZone($converted_timezone);
            $start_hour = $time->format('h:i a');
        }
    
        $finish_time_str = $finish_time;
        if ($finish_time_str == null) {
            $finish_time_hour = "";
        }
        else {
            //INFO: Due to the client_start_work_hour field type, I had to append a :00
            $time = new DateTime($finish_time_str.":00", $original_timezone);
            $time->setTimeZone($converted_timezone);
            $finish_hour = $time->format('h:i a');
        }
        return $start_hour."-".$finish_hour;
    }else{
        return "00:00 - 00:00";
    }
}



function ConvertTime($original_timezone, $converted_timezone , $start_time){
    if($original_timezone!=""){
        $converted_timezone = new DateTimeZone("$converted_timezone");
        $original_timezone = new DateTimeZone($original_timezone);
         
        $start_time_str = $start_time;
        
		//INFO: Due to the client_start_work_hour field type, I had to append a :00
		$time = new DateTime($start_time_str, $original_timezone);
		$time->setTimeZone($converted_timezone);
		$start_hour = $time->format('h:i a');
        
        
        return $start_hour;
    }else{
        return "00:00 - 00:00";
    }
}
?>
