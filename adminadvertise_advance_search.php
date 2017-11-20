<?
include 'config.php';
include 'conf.php';
include 'time.php';

if($_SESSION['admin_id']=="")
{
  header("location:index.php");
}


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$queryAdmin="SELECT * FROM admin WHERE admin_id=$admin_id;";
$data=mysql_query($queryAdmin);
$ctr=@mysql_num_rows($data);
if ($ctr >0 )
{
  $row = mysql_fetch_array ($data); 
  $name = $row['admin_fname']." ".$row['admin_lname'];
  $admin_email=$row['admin_email'];
}


$date_apply=$_REQUEST['date_apply'];
$month=$_REQUEST['month'];
$keysearch=$_REQUEST['keysearch'];
$status=$_REQUEST['status'];
$status_search=$_REQUEST['status'];
$audio=$_REQUEST['audio'];


//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = 100;
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
  $pageNum = $_GET['page'];
}
// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
//////////////////////


//////////// SEND MESSAGE /////////////
$message=$_REQUEST['message'];
$message=str_replace("\n","<br>",$message);
$emails=$_REQUEST['emails'];
$subj="MESSAGE FROM REMOTESTAFF.COM.AU";
$applicant=explode(",",$emails);
$agent_email=$admin_email;

//////// DELETE USERS //////
$applicants=$_REQUEST['applicants'];
//echo "Applicants ".$applicants;
$users=explode(",",$applicants);
if(isset($_POST['delete']))
{
  for ($i=0; $i<count($users);$i++)
  {  //personal , currentjob, education, skills, language
    $sqlDeletePersonal ="DELETE FROM personal WHERE userid =".$users[$i];
    $sqlDeleteCurrentjob ="DELETE FROM currentjob WHERE userid =".$users[$i];
    $sqlDeleteEducation ="DELETE FROM education WHERE userid =".$users[$i];
    $sqlDeleteSkills ="DELETE FROM skills WHERE userid =".$users[$i];
    $sqlDeleteLanguage ="DELETE FROM language WHERE userid =".$users[$i];
    mysql_query($sqlDeletePersonal);
    mysql_query($sqlDeleteCurrentjob);
    mysql_query($sqlDeleteEducation);
    mysql_query($sqlDeleteSkills);
    mysql_query($sqlDeleteLanguage);
  }

}



if(isset($_POST['send']))
{
$mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
$headers = "From: ".$agent_email." \r\n"."Reply-To: ".$agent_email."\r\n";
$headers .= "MIME-Version: 1.0\r\n" ."Content-Type: multipart/mixed;\r\n" ." boundary=\"{$mime_boundary}\"";
$message = "This is a multi-part message in MIME format.\n\n" .
"--{$mime_boundary}\n" .
"Content-Type: text/html; charset=\"iso-8859-1\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" .
$message . "\n\n";

foreach($_FILES as $userfile){
// store the file information to variables for easier access
$tmp_name = $userfile['tmp_name'];
$type = $userfile['type'];
$name = $userfile['name'];
$size = $userfile['size'];
// if the upload succeded, the file will exist
if (file_exists($tmp_name)){
// check to make sure that it is an uploaded file and not a system file
if(is_uploaded_file($tmp_name)){
// open the file for a binary read
$file = fopen($tmp_name,'rb');
// read the file content into a variable
$data = fread($file,filesize($tmp_name));
// close the file
fclose($file);
// now we encode it and split it into acceptable length lines
$data = chunk_split(base64_encode($data));
}
// now we'll insert a boundary to indicate we're starting the attachment
// we have to specify the content type, file name, and disposition as
// an attachment, then add the file content.
// NOTE: we don't set another boundary to indicate that the end of the 
// file has been reached here. we only want one boundary between each file
// we'll add the final one after the loop finishes.
$message .= "--{$mime_boundary}\n" .
"Content-Type: {$type};\n" .
" name=\"{$name}\"\n" .
"Content-Disposition: attachment;\n" .
" filename=\"{$fileatt_name}\"\n" .
"Content-Transfer-Encoding: base64\n\n" .
$data . "\n\n";
}

}

// here's our closing mime boundary that indicates the last of the message
$message.="--{$mime_boundary}--\n";
// now we just send the message
for ($i=0; $i<count($applicant);$i++)
{
  $to=$applicant[$i];
  $check = mail($to,$subj, $message, $headers);
}
if(!$check){  
  $mess ="<div style='background:#FFFFCC' align='center'><b>Message Sending Failed !</b></div>";  
}
else
{
  $mess ="<div style='background:#FFFFCC' align='center'><b>Message Sent !</b></div>";  
}  
}
//////////////////////////////////////////////
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$sql="SELECT * FROM admin WHERE admin_id=$admin_id;";

$resulta=mysql_query($sql);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
  $row = mysql_fetch_array ($resulta); 
  $name = $row['admin_lname'].",  ".$row['admin_fname'];
  
}


$monthArray=array("","01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
 for ($i = 0; $i < count($monthArray); $i++)
  {
      if($month == $monthArray[$i])
      {
   $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
      else
      {
  $monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
   }



















//ROY'S FUNCTION
  //ADVANCE SEARCH
  $month_a = @$_POST["month_a"];
  $day_a = @$_POST["day_a"];
  $year_a = @$_POST["year_a"];
  $month_b = @$_POST["month_b"];
  $day_b = @$_POST["day_b"];
  $year_b = @$_POST["year_b"];
  $category = @$_POST["category"];
  $key = @$_POST["key"];
  $date_check = @$_POST["date_check"];
  $key_check = @$_POST["key_check"];
  $view = @$_POST["view"];

  if($month_a== "" || $month_a== NULL){
    $month_a = @$_GET["month_a"];
  }  
  
  if($day_a== "" || $day_a== NULL){
    $day_a = @$_GET["day_a"];
  }    
  
  if($year_a== "" || $year_a== NULL){
    $year_a = @$_GET["year_a"];
  }  
  
  if($month_b== "" || $month_b== NULL){
    $month_b = @$_GET["month_b"];
  }  
  
  if($day_b== "" || $day_b== NULL){
    $day_b = @$_GET["day_b"];
  }  
  
  if($year_b== "" || $year_b== NULL){
    $year_b = @$_GET["year_b"];
  }  
  
  if($category== "" || $category== NULL){
    $category = @$_GET["category"];
  }  
  
  if($key== "" || $key== NULL){
    $key = @$_GET["key"];
  }  
  
  if(@isset($_POST["quick_search"]) || @$_GET["search_type"] == "quick")
  {
    $search_type = "quick";
  }
  elseif(@isset($_POST["advance_search"]) || @$_GET["search_type"] == "advance")
  {
    $search_type = "advance";
  }
  else
  {
    $search_type = "";
  }
  
  if(@!isset($_POST["advance_search"]))  
  {
    if($date_check== "" || $date_check== NULL){
      $date_check = @$_GET["date_check"];
    }
    if($key_check== "" || $key_check== NULL){
      $key_check = @$_GET["key_check"];
    }
  }
  
  if($view== "" || $view== NULL){
    $view = @$_GET["view"];
  }    
  //ENDED

  
  //QUICK SEARCH
  $rt = @$_POST['rt'];
  $category_a = @$_POST['category_a'];
  $view_a = @$_POST['view_a'];

  if($category_a== "" || $category_a== NULL){
    $category_a = @$_GET['category_a'];
  }
  if($view_a== "" || $view_a== NULL){
    $view_a = @$_GET['view_a'];
  }
  if($rt == "" || $rt == NULL){
    $rt = @$_GET["rt"];
  }

      switch ($rt) 
      {
        case "today" :
          $a_1 = time();
          $b_1 = time() + (1 * 24 * 60 * 60);
          $a_ = date("Ymd"); 
          $b_ = date("Ymd",$b_1);
          $title = "Today (".date("M d, Y").")";
          break;
        case "yesterday" :
          $a_1 = time() - (1 * 24 * 60 * 60);
          $b_1 = time() - (1 * 24 * 60 * 60);
          $a_ = date("Ymd",$a_1);
          $b_ = date("Ymd",$b_1);
          $title = "Yesterday (".date("M d, Y",$a_1).")";
          break;
        case "curmonth" :
          $a_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
          $b_1 = mktime(0, 0, 0, date("n"), 31, date("Y"));
          $a_ = date("Ymd",$a_1);
          $b_ = date("Ymd",$b_1);
          $title = "Current Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "curweek" :
          $wd_arr = array('Mo ', 'Tu ', 'We ', 'Th ', 'Fr ', 'Sa ', 'Su ');
          $a_1 = mktime(0, 0, 0,(int)date('m'),(int)date('d')+(1-(int)date('w')),(int)date('Y'));
          $b_1 = time();
          $a_ = date("Ymd",$a_1);
          $b_ = date("Ymd",$b_1);
          $title = "Current Week (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "lmonth" :
          $a_1 = mktime(0, 0, 0, date("n"), -31, date("Y"));
          $b_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
          $a_ = date("Ymd",$a_1);
          $b_ = date("Ymd",$b_1);
          $title = "Last Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "last7" :
          $a_1 = time() - (14 * 24 * 60 * 60);
          $b_1 = time() - (7 * 24 * 60 * 60);
          $a_ = date("Ymd",$a_1);
          $b_ = date("Ymd",$b_1);
          $title = "Last 7 Days (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "alltime" :
          $a_1 = mktime(0, 0, 0, 1, 11, 2006);
          $b_1 = time();
          $a_ = date("Ymd",$a_1);      
          $b_ = date("Ymd",$b_1);
          $title = "All time (".date("M d, Y").")";      
          break;
        default :
          $a_ = date("Ymd"); 
          $b_ = date("Ymd",time() + (1 * 24 * 60 * 60));
          $title = "Today (".date("M d, Y").")";  
      }
      //ENDED



  $sub_category_title = "Searched Result";  
  if($search_type == "quick")
  {
    if($category_a == "Any")
    {
      if($view_a == "Any" || $view_a == "any")
      {
        $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
        FROM personal, posting WHERE
        posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid AND (DATE(applicants.date_apply) BETWEEN '$a_' AND '$b_'))
        GROUP BY personal.userid
        ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
        ;";
        
        $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
        FROM personal, posting WHERE
        posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid AND (DATE(applicants.date_apply) BETWEEN '$a_' AND '$b_'))
        GROUP BY personal.userid
        ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
        ;";      
      }
      else
      {
        $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
        FROM personal, posting WHERE
        posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid AND applicants.status='$view_a' AND (DATE(applicants.date_apply) BETWEEN '$a_' AND '$b_'))
        GROUP BY personal.userid
        ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
        ;";
        
        $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
        FROM personal, posting WHERE
        posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid AND applicants.status='$view_a' AND (DATE(applicants.date_apply) BETWEEN '$a_' AND '$b_'))
        GROUP BY personal.userid
        ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
        ;";          
      }  
    }
    else
    {
      if($view_a == "Any" || $view_a == "any")
      {
        $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
        FROM personal, posting WHERE
        posting.jobposition = '$category_a'
        AND        
        posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid AND (DATE(applicants.date_apply) BETWEEN '$a_' AND '$b_'))
        GROUP BY personal.userid
        ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
        ;";
        
        $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
        FROM personal, posting WHERE
        posting.jobposition = '$category_a'
        AND        
        posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid AND (DATE(applicants.date_apply) BETWEEN '$a_' AND '$b_'))
        GROUP BY personal.userid
        ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
        ;";      
      }
      else
      {
        $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
        FROM personal, posting WHERE
        posting.jobposition = '$category_a'
        AND        
        posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid AND applicants.status='$view_a' AND (DATE(applicants.date_apply) BETWEEN '$a_' AND '$b_'))
        GROUP BY personal.userid
        ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
        ;";
        
        $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
        FROM personal, posting WHERE
        posting.jobposition = '$category_a'
        AND        
        posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid AND applicants.status='$view_a' AND (DATE(applicants.date_apply) BETWEEN '$a_' AND '$b_'))
        GROUP BY personal.userid
        ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
        ;";          
      }      
    }  
  }
  elseif($search_type == "advance")
  {
    $date_a = $year_a."-".$month_a."-".$day_a;
    $date_b = $year_b."-".$month_b."-".$day_b;
    
    $condition = "applicants.posting_id=posting.id AND applicants.userid=personal.userid";
    if($view == "Any" || $view == "any")
    {
    }
    else
    {
      $condition = $condition." AND applicants.status='$view'";
    }
    
    if($date_check == "" || $date_check == NULL)
    {
      $condition = $condition." AND (DATE(applicants.date_apply) BETWEEN '$date_a' AND '$date_b')";    
    }


    if($key != "" || $key != NULL)
    {
        if($category == "Any")
        {
          $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
          FROM personal, posting WHERE
          (fname LIKE '%$key%' OR lname LIKE '%$key%')
          AND          
          posting.id IN (SELECT posting_id FROM applicants WHERE $condition)
          GROUP BY personal.userid
          ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
          ;";
            
          $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
          FROM personal, posting WHERE
          (fname LIKE '%$key%' OR lname LIKE '%$key%')
          AND          
          posting.id IN (SELECT posting_id FROM applicants WHERE $condition)
          GROUP BY personal.userid
          ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
          ;";
        }
        else
        {
          $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
          FROM personal, posting WHERE
          posting.jobposition = '$category'
          AND
          (fname LIKE '%$key%' OR lname LIKE '%$key%')
          AND
          posting.id IN (SELECT posting_id FROM applicants WHERE $condition)
          GROUP BY personal.userid
          ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
          ;";
          
          $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
          FROM personal, posting WHERE
          posting.jobposition = '$category'
          AND
          (fname LIKE '%$key%' OR lname LIKE '%$key%')
          AND
          posting.id IN (SELECT posting_id FROM applicants WHERE $condition)
          GROUP BY personal.userid
          ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
          ;";  
        }        
    }  
    else
    {
        if($category == "Any")
        {
          $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
          FROM personal, posting WHERE
          posting.id IN (SELECT posting_id FROM applicants WHERE $condition)
          GROUP BY personal.userid
          ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
          ;";
            
          $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
          FROM personal, posting WHERE
          posting.id IN (SELECT posting_id FROM applicants WHERE $condition)
          GROUP BY personal.userid
          ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
          ;";
        }
        else
        {
          $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
          FROM personal, posting WHERE
          posting.jobposition = '$category'
          AND
          posting.id IN (SELECT posting_id FROM applicants WHERE $condition)
          GROUP BY personal.userid
          ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
          ;";
          
          $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
          FROM personal, posting WHERE
          posting.jobposition = '$category'
          AND
          posting.id IN (SELECT posting_id FROM applicants WHERE $condition)
          GROUP BY personal.userid
          ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
          ;";
        }      
    }
  

  } 
  else
  {
    $sub_category_title = "All Registered Applicants";    
    $query = "SELECT DISTINCT(personal.userid), personal.lname, personal.fname, personal.email, personal.handphone_country_code, personal.handphone_no, personal.tel_area_code, personal.tel_no, personal.address1,  personal.postcode, personal.country_id, personal.state, personal.city, personal.skype_id, personal.image, DATE_FORMAT(personal.datecreated,'%D %b %Y'),personal.status,personal.voice_path
    FROM personal, posting WHERE
    posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid)
    GROUP BY personal.userid
    ORDER BY posting.date_created DESC LIMIT $offset, $rowsPerPage
    ;";
      
    $query2 = "SELECT DISTINCT(COUNT(personal.userid)) AS numrows
    FROM personal, posting WHERE
    posting.id IN (SELECT posting_id FROM applicants WHERE applicants.posting_id=posting.id AND applicants.userid=personal.userid)
    GROUP BY personal.userid
    ORDER BY date_created DESC LIMIT $offset, $rowsPerPage
    ;";        
  }
//END ROY'S FUNCTION




















$result=mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());
if($mark=="")
{
  $mark="Mark/Remember";
}

?>

<html><head>
<title>Administrator - Job Category Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">
<script type="text/javascript" src="category/category.js"></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript" src="js/tooltip.js"></script>
<script type='text/javascript' language='JavaScript' src='audio_player/audio-player.js'></script>




<script type="text/javascript">

function checkAll(field)
{
  userval2 =new Array();
  if (field==null)
  {
    alert("There is no Selection to be Processed!");
    return false;
  }
  else
  {
    if((field.length)!=undefined)
    {
      for (i = 0; i < field.length; i++)
      {
        field[i].checked = true ;
        userval2.push(field[i].value);  
      }
      document.getElementById("emails").value=(userval2);
    }
    else
    {
      document.getElementById("emails").value = document.getElementById("list").value;
      document.getElementById("users").checked = true ;
    }
  }
}

function setSearchDate()
{
  //date_apply
  if(document.form.date_apply.value!="")
  {
    document.form.submit();
    //alert(document.form.date_apply.value);
  }
  
}

function move(id, status) 
{
  previewPath = "adminadvertise_move.php?id="+id+"&stat="+status;
  window.open(previewPath,'_blank','width=300,height=300,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}


function any_date(check)
{
  document.getElementById('month_a_id').disabled = (check.checked);
  document.getElementById('day_a_id').disabled = (check.checked);
  document.getElementById('year_a_id').disabled = (check.checked);
  document.getElementById('month_b_id').disabled = (check.checked);
  document.getElementById('day_b_id').disabled = (check.checked);
  document.getElementById('year_b_id').disabled = (check.checked);
}      
    
function any_key(check)
{
  document.getElementById('key_id').disabled = (check.checked);
}      
  
function validate(form) 
{
  if(!form.date_check.checked)
  {
    if (form.month_a.value == '') { alert("You forgot to select the 'month field'."); form.month_a.focus(); return false; }  
    if (form.day_a.value == '') { alert("You forgot to select the 'day field'."); form.day_a.focus(); return false; }  
    if (form.year_a.value == '') { alert("You forgot to select the 'year field'."); form.year_a.focus(); return false; }  
    if (form.month_b.value == '') { alert("You forgot to select the 'month field'."); form.month_b.focus(); return false; }  
    if (form.day_b.value == '') { alert("You forgot to select the 'day field'."); form.day_b.focus(); return false; }  
    if (form.year_b.value == '') { alert("You forgot to select the 'year field'."); form.year_b.focus(); return false; }        
  }
  if(!form.key_check.checked)
  {
    if (form.key.value == '') { alert("You forgot to enter the 'keyword'."); form.month_a.focus(); return false; }  
  }
}


</script>  
  
  
  
<style type="text/css">
<!--
.style2 {color: #666666}
#dhtmltooltip{
position: absolute;
font-family:Verdana;
font-size:11px;
left: -300px;
width: 110px;
height:150px;
border: 5px solid #6BB4C2;
background: #F7F9FD;
padding: 2px;

visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}
#searchbox
{
 padding-left:30px; padding-bottom:5px; padding-top:5px; margin-left:10px;
 border: 8px solid #E7F0F5;
 
}

#searchbox p
{
  margin-top:5px; margin-bottom:5px;
}


.pagination{
padding: 2px;
margin-top:10px; 
text-align:center;

}

.pagination ul{
margin: 0;
padding: 0;
text-align: center; /*Set to "right" to right align pagination interface*/
font-family: tahoma; font-size: 11px;
}

.pagination li{
list-style-type: none;
display: inline;
padding-bottom: 1px;
}

.pagination a, .pagination a:visited{
padding: 0 5px;
border: 1px solid #9aafe5;
text-decoration: none; 
color: #2e6ab1;
}

.pagination a:hover, .pagination a:active{
border: 1px solid #2b66a5;
color: #000;
background-color: #FFFF80;
}

.pagination a.currentpage{
background-color: #2e6ab1;
color: #FFF !important;
border-color: #2b66a5;
font-weight: bold;
cursor: default;
}

.pagination a.disablelink, .pagination a.disablelink:hover{
background-color: white;
cursor: default;
color: #929292;
border-color: #929292;
font-weight: normal !important;
}

.pagination a.prevnext{
font-weight: bold;
}

#tabledesign{
border:#666666 solid 1px;
}
#tabledesign tr:hover{
background-color:#FFFFCC;
}
-->
</style>
</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<input type="hidden" name="summary" value="<? echo $summary;?>">
<script language=javascript src="js/functions.js"></script>



<!-- HEADER -->

<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<table width="106%">

<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">



<? include 'applicationsleftnav.php';?>

</td>

<td valign="top"  style="width:100%; background: #E7F0F5;">








<table width="102%">
  <tr>
  <td valign="top" >
    <div style="margin:10px;">
    <table width="98%" style="border:#CCCCCC solid 1px; margin:10px;" cellpadding="3" cellspacing="3">
      <tr>
        <td colspan="2">
          <strong>Search Option 1</strong>
        </td>
      </tr>    
      <tr>
        <td colspan="2">
        <form action="adminadvertise_advance_search.php?category_a=<?php echo @$category_a; ?>&view_a=<?php echo @$view_a; ?>&rt=<?php echo @$rt; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">                              
          <table width="0%"  border="0" cellspacing="3" cellpadding="3">
            <tr>
            <td><font size="1">Date</font></td>
            <td><font size="1">Category</font></td>
            <td><font size="1">Status</font></td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>
                                  <select size="1" name="rt" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                    <?php
                                      switch ($rt) 
                                      {
                                        case "today":
                                          echo "<option value=\"$rt\" selected>today</option>";
                                          break;
                                        case "yesterday":
                                          echo "<option value=\"$rt\" selected>yesterday</option>";
                                          break;
                                        case "curweek":
                                          echo "<option value=\"$rt\" selected>current week</option>";
                                          break;
                                        case "curmonth":
                                          echo "<option value=\"$rt\" selected>current month</option>";
                                          break;
                                        case "lmonth":
                                          echo "<option value=\"$rt\" selected>last month</option>";
                                          break;
                                        case "last7":
                                          echo "<option value=\"$rt\" selected>last 7 days</option>";
                                          break;
                                        case "alltime":
                                          echo "<option value=\"$rt\" selected>all time</option>";
                                          break;
                                        default:
                                          echo "<option value='alltime' selected>all time</option>";
                                          break;
                                      }
                                  ?>
                                                              <option value="today">today</option>
                                                              <option value="yesterday">yesterday</option>
                                                              <option value="curweek">current week</option>
                                                              <option value="curmonth">current month</option>
                                                              <option value="lmonth">last month</option>
                                                              <option value="last7">last 7 days</option>
                                                              <option value="alltime">all time</option>
                                                            </select>            
            </td>
            <td>
                              <select name="category_a" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                
                                <?php 
                                    echo '<optgroup label="Top 10 Categories">';
                                    $main_category_name_result = mysql_query("SELECT * FROM job_sub_category");
                                    if($category_a=="Any" || $category_a=="any")
                                    {
                                      echo "<option value='Any' selected>Any</option>\n";
                                    }                                        
                                    while ($row = @mysql_fetch_assoc($main_category_name_result)) 
                                    {
                                      if($category_a==$row['sub_category_name'])
                                      {
                                        echo "<option value='".$row['sub_category_name']."' selected>".$row['sub_category_name']." (".$row['sub_category_date_created'].")</option>\n";
                                      }    
                                      else
                                      {                                
                                        echo "<option value='".$row['sub_category_name']."'>".$row['sub_category_name']." (".$row['sub_category_date_created'].")</option>\n";
                                      }  
                                    }

                                    echo '<optgroup label="Postings">';
                                    $main_category_name_result = mysql_query("SELECT id, date_created, jobposition FROM posting");            
                                    while ($row = @mysql_fetch_assoc($main_category_name_result)) 
                                    {
                                      if($category_a==$row['jobposition'])
                                      {
                                        echo "<option value='".$row['jobposition']."' selected>".$row['jobposition']." (".$row['date_created'].")</option>\n";
                                      }    
                                      else
                                      {                                
                                        echo "<option value='".$row['jobposition']."'>".$row['jobposition']." (".$row['date_created'].")</option>\n";
                                      }
                                    }                                    
                                    echo "<option value='Any'>Any</option>";
                                ?>                                  
                              </select>            
            </td>
            <td>
                                        <select name="view_a" id="view_id_a" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                          <?php
                                            switch($view_a)
                                            {
                                              case "No Potential":
                                                echo '<option value="No Potential" selected>No Potential</option>';
                                                break;
                                              case "Unprocessed":  
                                                echo '<option value="Unprocessed" selected>Unprocessed</option>';
                                                break;
                                              case "Endorsed":  
                                                echo '<option value="Endorsed" selected>Endorsed</option>';
                                                break;
                                              case "Pre-Screen":  
                                                echo '<option value="Pre-Screen" selected>Pre-Screen</option>';
                                                break;
                                              case "Shorlisted":  
                                                echo '<option value="Shorlisted" selected>Shorlisted</option>';
                                                break;      
                                              default:    
                                                echo '<option value="Any" selected>Any</option>';
                                                break;
                                            }
                                          ?>
                                          <option value="No Potential">No Potential</option>
                                          <option value="Unprocessed">Unprocessed</option>
                                          <option value="Endorsed">Endorsed</option>
                                          <option value="Pre-Screen">Pre-Screen</option>
                                          <option value="Shorlisted">Shorlisted</option>  
                                          <option value="Any">Any</option>                                        
                                        </select>              
            </td>
            <td>
                                        <input type="submit" value="View Result" name="quick_search" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>              
            </td>
            </tr>
          </table>
        </form>    
                                
                              
                                  
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <br /><strong>Search Option 2</strong>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
        
        
        
                            <form action="adminadvertise_advance_search.php?category_a=<?php echo @$category_a; ?>&view_a=<?php echo @$view_a; ?>&rt=<?php echo @$rt; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>" method="post" name="formtable" onSubmit="return validate(this); ">
                              <table width="0" border="0" cellpadding="0">
                                                          <tr>
                                                            <td>Date&nbsp;Between&nbsp;</td>
                                                            <td colspan="3">
                                <table width="0"  border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                  <td>
                                    <SELECT ID="month_a_id" NAME="month_a" <?php if($date_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                    <?php 
                                      switch($month_a)
                                      {
                                        case "1":
                                          echo '<OPTION VALUE="1" selected>Jan</OPTION>';
                                          break;
                                        case "2":  
                                          echo '<OPTION VALUE="2" selected>Feb</OPTION>';
                                          break;
                                        case "3":    
                                          echo '<OPTION VALUE="3" selected>Mar</OPTION>';
                                          break;
                                        case "4":  
                                          echo '<OPTION VALUE="4" selected>Apr</OPTION>';
                                          break;
                                        case "5":  
                                          echo '<OPTION VALUE="5" selected>May</OPTION>';
                                          break;
                                        case "6":  
                                          echo '<OPTION VALUE="6" selected>Jun</OPTION>';
                                          break;
                                        case "7":  
                                          echo '<OPTION VALUE="7" selected>Jul</OPTION>';
                                          break;
                                        case "8":  
                                          echo '<OPTION VALUE="8" selected>Aug</OPTION>';
                                          break;
                                        case "9":  
                                          echo '<OPTION VALUE="9" selected>Sep</OPTION>';
                                          break;
                                        case "10":  
                                          echo '<OPTION VALUE="10" selected>Oct</OPTION>';
                                          break;
                                        case "11":  
                                          echo '<OPTION VALUE="11" selected>Nov</OPTION>';
                                          break;
                                        case "12":  
                                          echo '<OPTION VALUE="12" selected>Dec</OPTION>';
                                          break;
                                        default:  
                                          echo '<OPTION VALUE="" SELECTED>Month</OPTION>';
                                          break;
                                      }
                                    ?>
                                                                          
                                      <OPTION VALUE="1">Jan</OPTION>
                                      <OPTION VALUE="2">Feb</OPTION>
                  
                                      <OPTION VALUE="3">Mar</OPTION>
                                      <OPTION VALUE="4">Apr</OPTION>
                                      <OPTION VALUE="5">May</OPTION>
                                      <OPTION VALUE="6">Jun</OPTION>
                                      <OPTION VALUE="7">Jul</OPTION>
                                      <OPTION VALUE="8">Aug</OPTION>
                  
                                      <OPTION VALUE="9">Sep</OPTION>
                                      <OPTION VALUE="10">Oct</OPTION>
                                      <OPTION VALUE="11">Nov</OPTION>
                                      <OPTION VALUE="12">Dec</OPTION>
                                    </SELECT>
                              
                                  </td>
                                  <td>
                                  
                                    <SELECT ID="day_a_id" NAME="day_a" <?php if($date_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                      <?php
                                        $counter = 0;
                                        for($i = 1; $i <= 30; $i++)
                                        {
                                          if($day_a == $i){
                                            echo '<OPTION VALUE="'.$i.'" SELECTED>'.$i.'</OPTION>';
                                            $counter++;
                                            break;
                                          }
                                        }
                                        if($counter == 0) echo '<OPTION VALUE="" SELECTED>day</OPTION>';
                                        
                                      ?>
                                      <OPTION VALUE="1">01</OPTION>
                                      <OPTION VALUE="2">02</OPTION>
                                      <OPTION VALUE="3">03</OPTION>
                                      <OPTION VALUE="4">04</OPTION>
                                      <OPTION VALUE="5">05</OPTION>
                  
                                      <OPTION VALUE="6">06</OPTION>
                                      <OPTION VALUE="7">07</OPTION>
                                      <OPTION VALUE="8">08</OPTION>
                                      <OPTION VALUE="9">09</OPTION>
                                      <OPTION VALUE="10">10</OPTION>
                                      <OPTION VALUE="11">11</OPTION>
                  
                                      <OPTION VALUE="12">12</OPTION>
                                      <OPTION VALUE="13">13</OPTION>
                                      <OPTION VALUE="14">14</OPTION>
                                      <OPTION VALUE="15">15</OPTION>
                                      <OPTION VALUE="16">16</OPTION>
                                      <OPTION VALUE="17">17</OPTION>
                  
                                      <OPTION VALUE="18">18</OPTION>
                                      <OPTION VALUE="19">19</OPTION>
                                      <OPTION VALUE="20">20</OPTION>
                                      <OPTION VALUE="21">21</OPTION>
                                      <OPTION VALUE="22">22</OPTION>
                                      <OPTION VALUE="23">23</OPTION>
                  
                                      <OPTION VALUE="24">24</OPTION>
                                      <OPTION VALUE="25">25</OPTION>
                                      <OPTION VALUE="26">26</OPTION>
                                      <OPTION VALUE="27">27</OPTION>
                                      <OPTION VALUE="28">28</OPTION>
                                      <OPTION VALUE="29">29</OPTION>
                  
                                      <OPTION VALUE="30">30</OPTION>
                                      <OPTION VALUE="31">31</OPTION>
                                    </SELECT>                              
                                  
                                  </td>
                                  <td>
                                                
                                    <SELECT ID="year_a_id" NAME="year_a" <?php if($date_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                      <?php
                                        switch($year_a)
                                        {
                                          case "2008":
                                            echo '<OPTION VALUE="2008" SELECTED>2008</OPTION>';
                                            break;
                                          case "2009":
                                            echo '<OPTION VALUE="2009" SELECTED>2009</OPTION>';
                                            break;
                                          case "2010":
                                            echo '<OPTION VALUE="2010" SELECTED>2010</OPTION>';
                                            break;
                                          default:
                                            echo '<OPTION VALUE="" SELECTED>year</OPTION>';
                                            break;
                                        }
                                      ?>
                                      <OPTION VALUE="2008">2008</OPTION>
                                      <OPTION VALUE="2009">2009</OPTION>
                                      <OPTION VALUE="2010">2010</OPTION>
                                    </SELECT>                                  
                                  
                                  </td>
                                  <td>&nbsp;and&nbsp;</td>
                                  <td>
                                    <SELECT ID="month_b_id" NAME="month_b" <?php if($date_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                    <?php 
                                      switch($month_b)
                                      {
                                        case "1":
                                          echo '<OPTION VALUE="1" selected>Jan</OPTION>';
                                          break;
                                        case "2":  
                                          echo '<OPTION VALUE="2" selected>Feb</OPTION>';
                                          break;
                                        case "3":    
                                          echo '<OPTION VALUE="3" selected>Mar</OPTION>';
                                          break;
                                        case "4":  
                                          echo '<OPTION VALUE="4" selected>Apr</OPTION>';
                                          break;
                                        case "5":  
                                          echo '<OPTION VALUE="5" selected>May</OPTION>';
                                          break;
                                        case "6":  
                                          echo '<OPTION VALUE="6" selected>Jun</OPTION>';
                                          break;
                                        case "7":  
                                          echo '<OPTION VALUE="7" selected>Jul</OPTION>';
                                          break;
                                        case "8":  
                                          echo '<OPTION VALUE="8" selected>Aug</OPTION>';
                                          break;
                                        case "9":  
                                          echo '<OPTION VALUE="9" selected>Sep</OPTION>';
                                          break;
                                        case "10":  
                                          echo '<OPTION VALUE="10" selected>Oct</OPTION>';
                                          break;
                                        case "11":  
                                          echo '<OPTION VALUE="11" selected>Nov</OPTION>';
                                          break;
                                        case "12":  
                                          echo '<OPTION VALUE="12" selected>Dec</OPTION>';
                                          break;
                                        default:  
                                          echo '<OPTION VALUE="" SELECTED>Month</OPTION>';
                                          break;
                                      }
                                    ?>
                                                                          
                                      <OPTION VALUE="1">Jan</OPTION>
                                      <OPTION VALUE="2">Feb</OPTION>
                  
                                      <OPTION VALUE="3">Mar</OPTION>
                                      <OPTION VALUE="4">Apr</OPTION>
                                      <OPTION VALUE="5">May</OPTION>
                                      <OPTION VALUE="6">Jun</OPTION>
                                      <OPTION VALUE="7">Jul</OPTION>
                                      <OPTION VALUE="8">Aug</OPTION>
                  
                                      <OPTION VALUE="9">Sep</OPTION>
                                      <OPTION VALUE="10">Oct</OPTION>
                                      <OPTION VALUE="11">Nov</OPTION>
                                      <OPTION VALUE="12">Dec</OPTION>
                                    </SELECT>
                              
                                  </td>
                                  <td>
                                  
                                    <SELECT ID="day_b_id" NAME="day_b" <?php if($date_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                      <?php
                                        $counter = 0;
                                        for($i = 1; $i <= 30; $i++)
                                        {
                                          if($day_b == $i){
                                            echo '<OPTION VALUE="'.$i.'" SELECTED>'.$i.'</OPTION>';
                                            $counter++;
                                            break;
                                          }
                                        }
                                        if($counter == 0) echo '<OPTION VALUE="" SELECTED>day</OPTION>';
                                        
                                      ?>
                                      <OPTION VALUE="1">01</OPTION>
                                      <OPTION VALUE="2">02</OPTION>
                                      <OPTION VALUE="3">03</OPTION>
                                      <OPTION VALUE="4">04</OPTION>
                                      <OPTION VALUE="5">05</OPTION>
                  
                                      <OPTION VALUE="6">06</OPTION>
                                      <OPTION VALUE="7">07</OPTION>
                                      <OPTION VALUE="8">08</OPTION>
                                      <OPTION VALUE="9">09</OPTION>
                                      <OPTION VALUE="10">10</OPTION>
                                      <OPTION VALUE="11">11</OPTION>
                  
                                      <OPTION VALUE="12">12</OPTION>
                                      <OPTION VALUE="13">13</OPTION>
                                      <OPTION VALUE="14">14</OPTION>
                                      <OPTION VALUE="15">15</OPTION>
                                      <OPTION VALUE="16">16</OPTION>
                                      <OPTION VALUE="17">17</OPTION>
                  
                                      <OPTION VALUE="18">18</OPTION>
                                      <OPTION VALUE="19">19</OPTION>
                                      <OPTION VALUE="20">20</OPTION>
                                      <OPTION VALUE="21">21</OPTION>
                                      <OPTION VALUE="22">22</OPTION>
                                      <OPTION VALUE="23">23</OPTION>
                  
                                      <OPTION VALUE="24">24</OPTION>
                                      <OPTION VALUE="25">25</OPTION>
                                      <OPTION VALUE="26">26</OPTION>
                                      <OPTION VALUE="27">27</OPTION>
                                      <OPTION VALUE="28">28</OPTION>
                                      <OPTION VALUE="29">29</OPTION>
                  
                                      <OPTION VALUE="30">30</OPTION>
                                      <OPTION VALUE="31">31</OPTION>
                                    </SELECT>                              
                                  
                                  </td>
                                  <td>
                                                
                                    <SELECT ID="year_b_id" NAME="year_b" <?php if($date_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                      <?php
                                        switch($year_b)
                                        {
                                          case "2008":
                                            echo '<OPTION VALUE="2008" SELECTED>2008</OPTION>';
                                            break;
                                          case "2009":
                                            echo '<OPTION VALUE="2009" SELECTED>2009</OPTION>';
                                            break;
                                          case "2010":
                                            echo '<OPTION VALUE="2010" SELECTED>2010</OPTION>';
                                            break;
                                          default:
                                            echo '<OPTION VALUE="" SELECTED>year</OPTION>';
                                            break;
                                        }
                                      ?>
                                      <OPTION VALUE="2008">2008</OPTION>
                                      <OPTION VALUE="2009">2009</OPTION>
                                      <OPTION VALUE="2010">2010</OPTION>
                                    </SELECT>                                  
                                  
                                  </td>
                                  <td>&nbsp;Any</td>                                  
                                  <td><input type="checkbox" id="date_check_id" name="date_check" onClick="javascript: any_date(this); " <?php if($date_check == "on") echo "checked"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                  </tr>
                                </table>
                              
                              
                              
                              
                              
                              
                              </td>
                                                          </tr>
                                                          <tr>
                                                            <td>Category</td>
                                                            <td>
                              
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
                                        <select name="category" id="category_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                          <?php 
                                              echo '<optgroup label="Top 10 Categories">';
                                              $main_category_name_result = mysql_query("SELECT * FROM job_sub_category");
                                              if($category=="Any" || $category=="any")
                                              {
                                                echo "<option value='Any' selected>Any</option>\n";
                                              }                                                  
                                              while ($row = @mysql_fetch_assoc($main_category_name_result)) 
                                              {
                                                if($category==$row['sub_category_name'])
                                                {
                                                  echo "<option value='".$row['sub_category_name']."' selected>".$row['sub_category_name']." (".$row['sub_category_date_created'].")</option>\n";
                                                }    
                                                else
                                                {                                
                                                  echo "<option value='".$row['sub_category_name']."'>".$row['sub_category_name']." (".$row['sub_category_date_created'].")</option>\n";
                                                }                                    
                                                
                                              }                                              
                                              echo '<optgroup label="Postings">';
                                              $main_category_name_result = mysql_query("SELECT id, date_created, jobposition FROM posting");            
                                              while ($row = @mysql_fetch_assoc($main_category_name_result)) 
                                              {
                                                if($category==$row['jobposition'])
                                                {
                                                  echo "<option value='".$row['jobposition']."' selected>".$row['jobposition']." (".$row['date_created'].")</option>\n";
                                                }    
                                                else
                                                {                                
                                                  echo "<option value='".$row['jobposition']."'>".$row['jobposition']." (".$row['date_created'].")</option>\n";
                                                }
                                              }
                                              echo "<option value='Any'>Any</option>";
                                          ?>  
                                        </select>                              
                                      </td>
                                      <td>&nbsp;status&nbsp;</td>
                                      <td colspan="7">
                                        <select name="view" id="view_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                          <?php
                                            switch($view)
                                            {
                                              case "No Potential":
                                                echo '<option value="No Potential" selected>No Potential</option>';
                                                break;
                                              case "Unprocessed":  
                                                echo '<option value="Unprocessed" selected>Unprocessed</option>';
                                                break;
                                              case "Endorsed":  
                                                echo '<option value="Endorsed" selected>Endorsed</option>';
                                                break;
                                              case "Pre-Screen":  
                                                echo '<option value="Pre-Screen" selected>Pre-Screen</option>';
                                                break;
                                              case "Shorlisted":  
                                                echo '<option value="Shorlisted" selected>Shorlisted</option>';
                                                break;      
                                              default:    
                                                echo '<option value="Any" selected>Any</option>';
                                                break;
                                            }
                                          ?>
                                          <option value="No Potential">No Potential</option>
                                          <option value="Unprocessed">Unprocessed</option>
                                          <option value="Endorsed">Endorsed</option>
                                          <option value="Pre-Screen">Pre-Screen</option>
                                          <option value="Shorlisted">Shorlisted</option>  
                                          <option value="Any">Any</option>    
                                        </select>                                                                      
                                      </td>  
                                    </tr>
                                  </table>

                              </td>                              
                                                          </tr>
                                                          <tr>
                                                            <td>Keyword</td>
                                                            <td>
                              
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td><input type="text" id="key_id" name="key" value="<?php echo $key; ?>" <?php if($key_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    <td>&nbsp;Any</td>
                                    <td><input id="key_check_id" name="key_check" type="checkbox" onClick="javascript: any_key(this); " <?php if($key_check == "on") echo "checked"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    <td><i><font size="1">(first name, last name)</font></i></td>
                                    </tr>
                                  </table>
                                
                              </td>
                                                          </tr>  
                                                          <tr>
                                                            <td></td>
                                                            <td>
                              
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td><input type="submit" name="advance_search" value="View Result" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    </tr>
                                  </table>
                                
                              </td>
                                                          </tr>                                                          
                                                        </table>
                            </form>        
        
        
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><b>Send Email to Applicants</b></td>
      </tr>
      <tr>
        <td width="62%" valign="top" colspan="2">
          <?=$mess;?>
          <font color='#999999'>
          To send email to Applicants. Click on the ckeckbox below.<br>
          Type multiple email address here separated by (",") comma in sending message to multiple clients.</font>
          <textarea name='emails' id='emails' cols='48' rows='5' wrap='physical' class='text'  style='width:85%'></textarea><br />
          <b>Message :</b> <font color='#999999'>(Type your message here)</font>
          <textarea name='message' cols='48' rows='5' wrap='physical' class='text'  style='width:85%'></textarea><br />
          <p>Attach File :</b> <input name='logo' type='file' id='logo' class=text >&nbsp;
          <input type='submit' name='send' value='Send Email' class='text' style=' width:150px;'>
          </p>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center"></td>
      </tr>
    </table>
  
  </div>
  </td>
  </tr>
</table>  
  
  <div id="category_applicants">
  <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
    <b>
      <strong><?php echo $sub_category_title; ?></strong>
    </b>
  </div>
  <div style='padding:5px; border:#CCCCCC solid 1px;'>
  <div class="pagination">

<ul>



<?
$result_page  = mysql_query($query2);
$row     = mysql_fetch_array($result_page);
$numrows = $row['numrows'];
//echo $numrows;
// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);
// print the link to access each page
$self = "./adminadvertise_category.php?stat=$stat&action=$action&main_category_id=$main_category_id&sub_category_id=$sub_category_id&audio=$audio&status=$status_search&date_apply=$date_apply&month=$month";
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
  if ($page == $pageNum)
  {
    //$nav .= " $page ";   // no need to create a link to current page
    $nav .= " <li><a class='currentpage' href=\"$self&page=$page\">$page</a></li> ";
  }
  else
  {
    $nav .= " <li><a href=\"$self&page=$page\">$page</a></li> ";
  }
}
// creating previous and next link
// plus the link to go straight to
// the first and last page

if ($pageNum > 1)
{
  $page = $pageNum - 1;
  $prev = " <li><a class='prevnext disablelink' href=\"$self&page=$page\">[Prev]</a></li> ";
  $first = "<li><a href=\"$self&page=1\">[First Page]</a></li>";
}
else
{
  $prev  = '&nbsp;'; // we're on page one, don't print previous link
  $first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage)
{
  $page = $pageNum + 1;
  $next = " <li><a class='prevnext' href=\"$self&page=$page\">[Next]</a></li>";
  $last = " <li><a href=\"$self&page=$maxPage\">[Last Page]</a></li> ";
}
else
{
  $next = '&nbsp;'; // we're on the last page, don't print next link
  $last = '&nbsp;'; // nor the last page link
}
if($keysearch=="")
{
  //echo $numrows;
  echo $first . $prev . $nav. $next . $last;
  echo "Note : shows 100 rows per page&nbsp;&nbsp;";
  echo "[".$numrows."&nbsp;rows results]";
}
?>
</ul>
</div>
    <table width=98% id='tabledesign' cellspacing=1 cellpadding=1 align=center border=0 bgcolor="" >
<tr bgcolor="#666666" >
<td width="4%"   align=left><b><font color="#FFFFFF" size='1'>#</font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/email.gif" alt="Send Message"  onClick="checkAll(document.form.users)" style="cursor: pointer; "></font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/delete.png" alt="Delete This Applicant"></font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/adduser16.png" alt="mark Applicants"></font></b></td>
<td width="28%"  align=left><b><font color="#FFFFFF" size='1'>NAME</font></b></td>
<td width="12%"  align=left><b><font color="#FFFFFF" size='1'>DATE REGISTERED</font></b></td>
<td width="25%" align="center"><b><font color="#FFFFFF" size='1'>SKILLS</font></b></td>
<td width="25%" align="center"><b><font color="#FFFFFF" size='1'>MOVE</font></b></td>
</tr>
<?
$counter=$offset;
//$counter=0;
//$bgcolor="#f5f5f5";
$bgcolor="#ECEBF3";  
while(list($userid, $lname, $fname, $email, $handphone_country_code, $handphone_no, $tel_area_code, $tel_no, $address1,  $postcode, $country_id, $state, $city, $skype_id, $image, $date,$status,$voice_path)=mysql_fetch_array($result))
{
$counter++;

if($status=="MARK")
{
  $mark="Unmark";
}
else
{
  $mark="Mark/Remember";
}
/// applicants image
if ($image!="")
{
  $filename = $image;
  if (file_exists($filename))
  {
    //echo "The file $filename exists";
    $pic= "<img border=0 src=$image width=110 height=150>";
  } else {
    $image="http://www.remotestaff.com.au/".$image;
    //echo $image;
    $pic= "<img border=0 src=$image width=110 height=150>";
    //echo "The file $filename does not exist";
  }
}
else
{
$pic= "<img border=0 src=images/Client.png width=110 height=150>";
} 
//

?>
<tr bgcolor=<? echo $bgcolor;?>>
<td width="4%"   align=left valign="top"><font size='1'><?=$counter;?>) </font></td>
<td width="2%"   align=center valign="top"><font size='1'> 
  <input name="users" id="users"type="checkbox" onClick="check_val();" value="<? echo $email;?>" title="Send Email to Applicant <?=$fname." ".$lname;?>"  >
</font></td>
<td width="2%"   align=center valign="top"><font size='1'>
  <input name="userss" id="userss" type="checkbox" onClick="check_val2(<? echo $userid;?>);" value="<? echo $userid;?>" title="Delete Applicant <?=$fname." ".$lname;?>"  >
  </font></td>
<td width="2%"   align=center valign="top"><font size='1'>
  <input name="mark_applicants" id="mark_applicants" type="radio" onclick ="goto(<? echo $userid;?>,'<?=$status;?>'); return false;" value="<? echo $userid;?>" title="<?=$mark;?> Applicant <?=$fname." ".$lname;?>&nbsp; as a Reserve Staff for future Employment "  >

  </font></td>  
<td width="28%"  align=left valign="top">
<div style="background-color:#FEFDE2; margin-bottom:0px; float:left;">
<div style="cursor:pointer;" onMouseOut="hideddrivetip();" onMouseOver="ddrivetip('<?=$pic;?>')" class='jobCompanyName' onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);" ><?="<b>".$fname." ".$lname."</b>";?></div>


</div>
<div style="float:right">
<? if($status=="MARK")
{
  echo "<img src='images/hot.gif' alt='Marked Applicants'>";
}
else { echo "&nbsp;";}
?></div>
<div style=" font-size:11px; margin-top:18px;">
<b style='color:#FF0000'>
<? 
$sql="SELECT latest_job_title FROM currentjob c WHERE c.userid= $userid;";
$result2=mysql_query($sql);
list($latest_job_title)=mysql_fetch_array($result2);
if ($latest_job_title!=""){ echo $latest_job_title."<br>";}
?>
</b>
<?=$email."<br>"."SkypeId : ".$skype_id;?>
</div>
  <?
if ($voice_path!="") 
{ //echo $voice_path;
?>
<br>
<a href="./<?=$voice_path;?>">Download</a>
<?
} 
?></td>
<td width="12%"  align=left valign="top"><font size='1'><?=$date;?></font></td>
<td valign="top">
<div style="margin-left:10px; text-align:center">
<i>
<?
$sqlSkill="SELECT skill FROM skills WHERE userid=$userid $AND;";
//echo $sqlSkill."<br>";

//echo "<b>".$skills."</b>";
$resultSkill=mysql_query($sqlSkill);
while(list($skill) = mysql_fetch_array($resultSkill))
{
  
  
  if((strtolower($skill)) == (strtolower($skills)))
  {
    echo "<span style='background-color:#FFFFCC;'>".$skill."</span> ,&nbsp;";
  }  
  else
  {
    echo $skill.",&nbsp;&nbsp;";
  }
}
?>
</i>
</div>
</td>
<td>
  <?php
    $app_stat = mysql_query("SELECT id, userid, status FROM applicants WHERE userid='$userid' LIMIT 1");
    $stat = mysql_result($app_stat,0,"status");
    $u_id = mysql_result($app_stat,0,"userid");
    $id = mysql_result($app_stat,0,"id");
  ?>    
  <table>
    <tr>
      <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $id; ?>, 'No Potential'); " value="No Potential" <?php if($stat == "No Potential") echo "checked"; ?>></td>
      <td><font size="1">No&nbsp;Potential</font></td>    
      <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $id; ?>, 'Pre-Screen'); " value="Pre-Screen" <?php if($stat == "Pre-Screen") echo "checked"; ?>></td>
      <td><font size="1">Pre-Screen</font></td>
    </tr>    
    <tr>
      <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $id; ?>, 'Unprocessed'); " value="Unprocessed" <?php if($stat == "Unprocessed") echo "checked"; ?>></td>
      <td><font size="1">Unprocessed</font></td>
      <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $id; ?>, 'Shorlisted'); " value="Shorlisted" <?php if($stat == "Shorlisted") echo "checked"; ?>></td>
      <td><font size="1">Shorlisted</font></td>
    </tr>  
      <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $id; ?>, 'Endorsed'); " value="Endorsed" <?php if($stat == "Endorsed") echo "checked"; ?>></td>
      <td><font size="1">Endorsed</font></td>
    </tr>
  </table>
</td>


</tr>
<? 
if($bgcolor=="#ECEBF3"){$bgcolor="#E6E6F0";}else{$bgcolor="#ECEBF3";}

}
// how many rows we have in database
//$query   = "SELECT COUNT(eid) AS numrows FROM employer";
//echo $query2;

$result  = mysql_query($query2) or die('Error, query failed');
$row     = mysql_fetch_array($result);
$numrows = $row['numrows'];

//echo $numrows;
// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);

// print the link to access each page
$self = "./adminadvertise_positions.php?audio=$audio&status=$status_search&date_apply=$date_apply&month=$month&keysearch=$keysearch";
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
  if ($page == $pageNum)
  {
    $nav .= " $page ";   // no need to create a link to current page
  }
  else
  {
    $nav .= " <a href=\"$self&page=$page\">$page</a> ";
  }
}

// creating previous and next link
// plus the link to go straight to
// the first and last page

if ($pageNum > 1)
{
  $page = $pageNum - 1;
  $prev = " <a href=\"$self&page=$page\">[Prev]</a> ";

  $first = " <a href=\"$self&page=1\">[First Page]</a> ";
}
else
{
  $prev  = '&nbsp;'; // we're on page one, don't print previous link
  $first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage)
{
  $page = $pageNum + 1;
  $next = " <a href=\"$self&page=$page\">[Next]</a> ";

  $last = " <a href=\"$self&page=$maxPage\">[Last Page]</a> ";
}
else
{
  $next = '&nbsp;'; // we're on the last page, don't print next link
  $last = '&nbsp;'; // nor the last page link
}

?>

</table>
</div>
</td>
</tr>
</table>










</td>
</tr>
</table>
<input type='hidden' id='applicants' name="applicants" >
<script type="text/javascript">
<!--
function goto(id,stat) 
{
  location.href = "mark_applicantsphp_bycategory.php?stat=<?php echo $stat; ?>&action=<?php echo $action; ?>&main_category_id=<?php echo $main_category_id; ?>&sub_category_id=<?php echo $sub_category_id; ?>&id="+id;
}
  
function check_val()
{
  var ins = document.getElementsByName('users')
  var i;
  var x;
  var j=0;
  var vals= new Array();
  var vals2 =new Array();
  for(i=0;i<ins.length;i++)
  {
    if(ins[i].checked==true)
    {
      if(ins[i].value!="" || ins[i].value!="undefined")
      {
        vals[j]=ins[i].value;
        //vals2[j]=id;
        j++;
      }    
    }
  }
document.getElementById("emails").value =(vals);
}

function check_val2()
{

userval =new Array();
var userlen = document.form.userss.length;
for(i=0; i<userlen; i++)
{
  if(document.form.userss[i].checked==true)
  {  
  //  document.getElementById("applicants").value+=(id);
    //push.userval=(id);
    userval.push(document.form.userss[i].value);
  }
}
document.getElementById("applicants").value=(userval);
}

-->
</script>



<script type="text/javascript">
<!--
getAllCategory();
-->
</script>


<? include 'footer.php';?>  
</body>

</html>



