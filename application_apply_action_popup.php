<?
putenv("TZ=Philippines/Manila");
include 'config.php';
include 'function.php';
include 'conf.php';

if(!isset($_SESSION['admin_id']))
{
  echo '
  <script language="javascript">
    alert("Session expired...'.$_SESSION['admin_id'].'");
    window.location="index.php";
  </script>
  ';
}

$userid=$_GET['userid'];
$action = $_REQUEST['action'];
$agent_no = $_SESSION['admin_id'];
$leads_id=$_REQUEST['userid'];
$hid =$_REQUEST['hid'];
$hmode =$_REQUEST['hmode'];
$mode =$_REQUEST['mode'];
$code=$_REQUEST['code'];

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($hmode!="" && $hmode=='delete')
{
  $query="DELETE FROM applicant_history WHERE id=$hid;";
  mysql_query($query);
}

$sql ="SELECT * FROM applicant_history WHERE id = $hid;";
$res=mysql_query($sql);
$ctr=@mysql_num_rows($res);
if ($ctr >0)
{
  $row = mysql_fetch_array($res);
  $desc=$row['history'];
}

if($action!="" && $action =="blacklist")
{
  $blacklist="UPDATE personal set status='BLACKLISTED' WHERE userid=$userid;";
  //echo $blacklist;
  mysql_query($blacklist)or trigger_error("Query: $blacklist\n<br />MySQL Error: " . mysql_error());
  echo("<html><head><script>function update(){top.location='resume2.php?userid=$userid';}var refresh=setInterval('update()',1500);
  </script></head><body onload=refresh><body></html>");
}

if (isset($_POST['Ok'])) { // Check if the form has been submitted.
  $userid=$_REQUEST['userid'];
  $star=$_REQUEST['star'];
  $note=$_REQUEST['note'];
  $note=filterfield($note);
  $insertQuery="INSERT INTO comments (agent_no,userid,rate,comments,date_created) VALUES ($agent_no,$userid,$star,'$note',NOW());";
  mysql_query($insertQuery)or trigger_error("Query: $insertQuery\n<br />MySQL Error: " . mysql_error());
  
  echo("<html><head><script>function update(){top.location='resume2.php?userid=$userid';}var refresh=setInterval('update()',1500);
  </script></head><body onload=refresh><body></html>");
  
}

$q="SELECT * FROM tb_additional_information WHERE userid=$userid";
$r=mysql_query($q);
$ctr=@mysql_num_rows($r);
if ($ctr >0 )
{
  $row = mysql_fetch_array ($r); 
  $job_category = $row['job_category'];
  $sub_job_category = $row['sub_job_category'];
  $availability = $row['availability'];
  $expected_salary = $row['expected_salary'];
  $salary_from_previous_job = $row['salary_from_previous_job'];
  $lowest_non_negostiable_salary = $row['lowest_non_negostiable_salary'];
  $notes = $row['notes'];
  $rating = $row['rating'];
}

$query="SELECT * FROM personal p  WHERE p.userid=$userid";
$query2="SELECT * FROM currentjob c  WHERE c.userid=$userid";
$result2=mysql_query($query2);
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
  $row = mysql_fetch_array ($result); 
  $row2 = mysql_fetch_array ($result2); 
  $latest_job_title=$row2['latest_job_title'];
  $image= $row['image'];

  $voice_path = $row['voice_path'];
  $name =$row['fname']."  ".$row['lname'];
  $dateapplied =$row['datecreated'];
  $dateupdated =$row['dateupdated'];
  $address=$row['address1']." ".$row['city']." ".$row['postcode']." <br>".$row['state']." ".$row['country_id'];
  $tel=$row['tel_area_code']." - ".$row['tel_no'];
  $cell =$row['handphone_country_code']."+".$row['handphone_no'];
  $email =$row['email'];
  $skype_id =$row['skype_id'];
  $byear = $row['byear'];
  $bmonth = $row['bmonth'];
  $bday = $row['bday'];
  $gender =$row['gender'];
  $nationality =$row['nationality'];
  $residence =$row['permanent_residence'];
  
  $initial_email_password =$row['initial_email_password'];
  $initial_skype_password =$row['initial_skype_password'];

  $home_working_environment=$row['home_working_environment'];
  $internet_connection=$row['internet_connection'];
  $isp=$row['isp'];
  $computer_hardware=$row['computer_hardware'];
  $headset_quality=$row['headset_quality'];
  
  $computer_hardware2=str_replace("\n","<b>",$computer_hardware);
  if($headset_quality=="0") {
    $headset_quality ="No Headset Available";
  }  
  $message="<p align =justify>Working Environment :".$home_working_environment."<br>";
  $message.="Internet Connection :".$internet_connection."<br>";
  $message."Internet Provider :".$isp."<br>";
  $message.="Computer Hardware/s :".$computer_hardware2."<br>";
  $message.="Headset Quality :".$headset_quality."<br></p>";
  
  $yr = date("Y");
  switch($bmonth)
  {
    case 1:
    $bmonth= "Jan";
    break;
    case 2:
    $bmonth= "Feb";
    break;
    case 3:
    $bmonth= "Mar";
    break;
    case 4:
    $bmonth= "Apr";
    break;
    case 5:
    $bmonth= "May";
    break;
    case 6:
    $bmonth= "Jun";
    break;
    case 7:
    $bmonth= "Jul";
    break;
    case 8:
    $bmonth= "Aug";
    break;
    case 9:
    $bmonth= "Sep";
    break;
    case 10:
    $bmonth= "Oct";
    break;
    case 11:
    $bmonth= "Nov";
    break;
    case 12:
    $month= "Dec";
    break;
    default:
    break;
  }
  
  
}

//LAST SEARCH RESULT
//TOP 10 CATEGORIES
  $t10 = @$_GET["t10_category_id"];
  $t10_category_name = @$_GET["t10_category_name"];
//ENDED


//ADVANCE SEARCH OPTIONS
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
  
  if($key == "" || $key == NULL)
  {
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
    if($date_check== "" || $date_check== NULL)
    {
      $date_check = @$_GET["date_check"];
    }
    if($key_check== "" || $key_check== NULL)
    {
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


//ENDED


?>



<html>

<head>

<title>Applications</title>
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

function check_val()
{
  var ins = document.getElementsByName('recruitment_job_order_form')
  var i;
  var j=0;
  var vals="without"; //= new Array();
  for(i=0;i<ins.length;i++)
  {
    if(ins[i].checked==true) {
      //vals[j]=ins[i].value;
      //j++;
      vals="with";
    }
  }
  document.form.job_order.value=(vals);
}
function leadsNavigation(direction){
  var selObj = document.getElementById("leads");
  current_index = selObj.selectedIndex;
  if(direction!="direct"){
    if(direction == "back"){
      if(current_index >0){
        current_index = current_index-1;
      }else{
        current_index =0 ;
      }  
    }
    if(direction == "forward"){
      current_index = current_index+1;
    }
    value = selObj.options[current_index].value;
  }else{
    value = selObj.value;
  }
  location.href = "<?=basename($_SERVER['SCRIPT_FILENAME']);?>?id="+value;
}

function checkFields()
{
  if(document.form.star.selectedIndex==0)
  {
    missinginfo = "";
    if(document.form.txt.value=="")
    {
      missinginfo += "\n     -  There is no message or details to be save or send \t \n Please enter details.";
    }
    if (document.form.mode.value =="")
    {
      if (document.form.fill.value=="" )
      {
        missinginfo += "\n     -  Please choose actions.";
      }
      if (document.form.fill.value=="EMAIL" )
      {
        if (document.form.subject.value=="" )
        {
          missinginfo += "\n     -  Please enter a subject in your Email.";
        }
        if (document.form.templates[0].checked==false && document.form.templates[1].checked==false && document.form.templates[2].checked==false)
        {
          missinginfo += "\n     -  Please choose email templates.";
        }
      }
    }  
    if (missinginfo != "")
    {
      missinginfo =" " + "You failed to correctly fill in the required information:\n" +
      missinginfo + "\n\n";
      alert(missinginfo);
      return false;
    }
    else return true;
  }
}



  function popup_calendar(id) 



  {



    previewPath = "application_calendar/popup_calendar.php?id="+id;



    window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');



  }


  function admin_edit(userid,p)
  {
    previewPath = p+"?userid="+userid;
    window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
  }
  
</script>  









<!-- ROY'S CODE ------------------->

    <script language="javascript">

    var chck = 0;

    var temp = '';

    var int=self.setInterval('check_schedule(temp)',9000)  

    var curSubMenu = '';  

    function check_schedule(id,a)

    {

      chck = 0;

      http.open("GET", "app_return_schedule.php?a="+a+"&id="+id, true);

      http.onreadystatechange = handleHttpResponse;

      http.send(null);

    }

    function hideAlarm(id,a)

    {
      
      a = a;
      
      chck = 0;

      document.getElementById('alarm').style.visibility='hidden';

      check_schedule(id,a);

    }

    //ajax



    function handleHttpResponse() 

    {

      if (http.readyState == 4) 

      {

        var temp = http.responseText;

        if(temp == "" || temp == '')

        {

          //do nothing

          //document.getElementById('support_sound_alert').innerHTML = "";

        }

        else

        {

          document.getElementById('alarm').innerHTML = http.responseText;      

          document.getElementById('alarm').style.visibility='visible';              

          //if(chck == 0)

          //{

            //document.getElementById('support_sound_alert').innerHTML = "<EMBED SRC='calendar/media/crawling.mid' hidden=true autostart=true loop=1>";

            //chck = 1;

          //}

        }  

      }

    }

    function getHTTPObject() 

    {

          var x 

          var browser = navigator.appName 

          if(browser == 'Microsoft Internet Explorer'){

            x = new ActiveXObject('Microsoft.XMLHTTP')

          }

          else

          {

            x = new XMLHttpRequest()

          }

          return x    

    }

    var http = getHTTPObject();    

    //ajax    

    

    //menu

    //var curSubMenu='';

    function showSubMenu(menuId){

        if (curSubMenu!='') hideSubMenu();

        eval('document.all.'+menuId).style.visibility='visible';

        curSubMenu=menuId;

    }

    

    function hideSubMenu(){

        eval('document.all.'+curSubMenu).style.visibility='hidden';

        curSubMenu='';

    }


    function leadsNavigation(direction)
    {
      var selObj = document.getElementById("leads");
      current_index = selObj.selectedIndex;
      if(direction!="direct"){
        if(direction == "back"){
          if(current_index >0){
            current_index = current_index-1;
          }else{
            current_index =0 ;
          }  
        }
        if(direction == "forward"){
          current_index = current_index+1;
        }
        value = selObj.options[current_index].value;
      }else{
        value = selObj.value;
      }
      location.href = "<?=basename($_SERVER['SCRIPT_FILENAME']);?>?userid="+value;
    }


    function change_rating(id, rating) 
    {
      previewPath = "change_rating.php?rating="+rating+"&userid="+id;
      window.open(previewPath,'_blank','width=300,height=300,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
    }      

    function change_top10(id, rating) 
    {
      previewPath = "change_top10.php?rating="+rating+"&userid="+id;
      window.open(previewPath,'_blank','width=300,height=300,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
    }  
    
    function move(id, status) 
    {
      switch(status)
      {
        case "Category":
          previewPath = "adminadvertise_add_to_category.php?userid="+id;
          break;      
        case "Pre-Screen":
          previewPath = "move_pre-screen.php?userid="+id;
          break;
        case "Unprocessed":
          previewPath = "move_unprocessed.php?userid="+id;
          break;
                          
        case "Shortlist":
          previewPath = "move_shortlist.php?userid="+id;
          break;
        case "Select":
          previewPath = "move_select.php?userid="+id;
          break;
        case "Become a Staff":
          previewPath = "move_become_a_staff.php?userid="+id;
          break;
        case "Edit":
          previewPath = "move_edit.php?userid="+id;
          break;
        case "No Potential":
          previewPath = "move_no_potential.php?userid="+id;
          break;
        case "Endorse to Client":
          previewPath = "move_endorse_to_client.php?userid="+id;
          break;
      }  
      window.open(previewPath,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
    }
    //menu    

    

    

    </script>    

<!-- ROY'S CODE ------------------->      





<style type="text/css">

<!--

  div.scroll {
    height: 200px;
    width: 100%;
    overflow: auto;
    border: 1px solid #CCCCCC;
    padding: 8px;
    font-family:Tahoma, Verdana; 
    font-size:12px;
  }

  .scroll p{

    margin-bottom: 10px;

    margin-top: 4px;

  }

  .spanner

  {

    float: right;

    text-align: right;

    padding:5px 0 5px 10px;

  

  

  }

  .spannel

  {

    float: left;

    text-align:left;

    padding:5px 0 5px 10px;

    border:#f2cb40 solid 1px;

    

  }  

.l {

  float: left;

  }  



.r{

  float: right;

  }

  

.btn{
  font:11px Tahoma;
}  

-->

</style>  

</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<form method="POST" name="form" action="application_apply_actionphp.php?userid=<?php echo $userid; ?>" enctype="multipart/form-data"  onsubmit="return checkFields();">
<input type="hidden" name="userid" value="<? echo $userid?>">
<input type="hidden" name="id" id="leads_id" value="<? echo $userid;?>">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="fill" value="">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<input type="hidden" name="hid" value="<? echo $hid;?>">
<input type="hidden" name="fullname" value="<? echo $fname." ".$lname;?>">
<input type="hidden" name="email" value="<? echo $email;?>">
<input type="hidden" name="job_order" id="job_order" >


<!-- HEADER -->

<script language=javascript src="js/functions.js"></script>

<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr>


<td valign=top align=left>
<table width="100%">
<tr>
<td valign="top">

<table width=98% cellpadding=3 cellspacing="3" border=0 align=left>
<tr>
  <td width=100% colspan=2>
  <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
    <b>Meeting Candidate</b>  
  </div>
  </td>
</tr>









<!-- appointments calendar -->

<tr>

  <td colspan=2 >

    <table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">

      <tr>

        <td valign="middle" onClick="javascript: window.location='application_calendar/popup_calendar.php?back_link=4&id=<?php echo @$_GET["userid"]; ?>'; " colspan=3 onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; ">

          <a href="application_calendar/popup_calendar.php?back_link=4&id=<?php echo @$_GET["userid"]; ?>" target="_self"><img src='images/001_44.png' alt='Calendar' align='texttop' border='0'></a><strong>&nbsp;&nbsp;Manage Meetings        </strong>

        </td>

      </tr>

    </table>      

  </td>

</tr>

<!-- appointments calendar -->





<!-- appointments -->

<tr>

  <td colspan=2 >


<table width="100%">
  <tr>
    <td width="50%" valign="top">







              <?php

                require_once("conf/connect.php");

                $time_offset ="0"; // Change this to your time zone

                $time_a = ($time_offset * 120);

                $h = date("h",time() + $time_a);

                $m = date("i",time() + $time_a);

                $d = date("Y-m-d" ,time());

                $type = date("a",time() + $time_a);                

              

                $db=connsql();

                $c = mysql_query("SELECT id FROM tb_app_appointment WHERE user_id='$agent_no' AND date_start='$d'");  

              

                $num_result = mysql_num_rows($c);

              ?>

                    <table width="100%">              
      
                      <tr><td bgcolor="#F1F1F3" height="25" colspan=3><font color='#000000'><b>Today's Meeting(<?php echo $num_result; ?>)</b></font><br /></td></tr>
      
                      <?php if($num_result > 0) { ?>
      
                      <tr >
      
                        <td colspan=3 valign="top" >
      
                            <iframe id="frame" name="frame" width="100%" height="100" src="todays_appointments_admin.php?agent_no=<?php echo $agent_no; ?>" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
      
                        </td>  
      
                      </tr>
                      <?php } ?>
                    </table>    





    </td>
    
    
    <td width="50%" valign="top">

                    <?php
      
                      $c = mysql_query("SELECT id FROM tb_app_appointment WHERE user_id='$agent_no' AND date_start > '$d'");  
      
                      $num_result = mysql_num_rows($c);
      
                    ?>
      
                    <table width="100%">              
      
                      <tr><td bgcolor="#F1F1F3" height="25" colspan=3><font color='#000000'><b>Other Days Meeting(<?php echo $num_result; ?>)</b></font><br /></td></tr>
      
                      <?php if($num_result > 0) { ?>
      
                      <tr >
      
                        <td colspan=3 valign="top" >
      
                            <iframe id="frame" name="frame" width="100%" height="100" src="other_appointments_admin.php?agent_no=<?php echo $agent_no; ?>" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
      
                        </td>  
      
                      </tr>
                      <?php } ?>
                    </table>      


    </td>    
  </tr>  
</table>




  </td>

</tr>

<!-- appointments -->




<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Voice</b>
    </div>    
  </td>
</tr>

<tr><td colspan=2 >

<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
<tr>
  <td width="50%" valign="top">
    <table cellspacing=1 cellpadding=3 width=100% >
      <tr>
        <td><font color='#000000'><b>Voice Uploaded</b></font></td>
      </tr>
      <tr>
        <td>
          <?php  
              if ($voice_path!="") 
              { 
                ?>
                <br>
                <a href="./<?=$voice_path;?>">Download</a>
                <?
              } 
          ?>
        </td>
      </tr>
    </table>
  </td>
  <td valign="top" width="50%">
    <table cellspacing=1 cellpadding=3 width=100%>
      <tr>
        <td><font color='#000000'><b>Voice</b></font></td>
      </tr>    
      <tr>
        <td>
          <FONT size="1">
          Voice recording should be: <BR />
          <em>
          Size: Equal or less than 2000kb in size<BR />
          Format: WAV, Mpeg, WMA, MP3 <BR />
          Length: Should be equal or less than 3 minutes<BR />
          Content: Quick voice resume. Introduction and summary of experience     <BR />
          </em></FONT>
          <input type="file" name="sound_file" id="sound_file">      
        </td>
      </tr>
      <tr>
        <td><input type="submit" name="sound_btn" id="sound_btn" value="upload"></td>
      </tr>      
    </table>
    
  </td>
</tr>
</table>







<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Files</b>
    </div>    
  </td>
</tr>

<tr><td colspan=2 >

<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
<tr>
  <td width="50%" valign="top">
    <table cellspacing=1 cellpadding=3 width=100% >
      <tr>
        <td><font color='#000000'><b>Files Uploaded</b></font></td>
      </tr>
      <?php
        $c = mysql_query("SELECT * FROM tb_applicant_files WHERE userid='$userid'");  
        while ($row = @mysql_fetch_assoc($c)) 
        {    
      ?>                    
      <tr>
        <td>
          <?php 
            if($row["file_description"] != "" || $row["file_description"] != NULL)
            {
              echo "<a href='application_apply_actionphp.php?userid=".$userid."&delete=".$row['name']."'><img src='images/delete.png' border=0></a>&nbsp;&nbsp;".$row["file_description"].":&nbsp;<i><a href='applicants_files/".$row["name"]."' target='_blank'>".$row["name"]."</a></i>"; 
            }
            else
            {
              echo "<a href='application_apply_actionphp.php?userid=".$userid."&delete=".$row['name']."'><img src='images/delete.png' border=0></a> "."<i>".$row["name"]."</i>"; 
            }
          ?>          
        </td>
      </tr>
      <?php
        }
      ?>
    </table>
  </td>
  <td valign="top" width="50%">
    <table cellspacing=1 cellpadding=3 width=100%>
      <tr>
        <td><font color='#000000'><b>File Type</b> <font color="#666666"><em>(doc, pdf or image format)</em></font></font></td>
      </tr>    
      <tr>
        <td>
          <select name="file_description">
            <option value="Resume" selected>Resume</option>
            <option value="Sample Work">Sample Work</option>
            <option value="Other">Other</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><font color='#000000'><b>File</b></font></td>
      </tr>      
      <tr>
        <td><input type="file" name="fileimg" value="" size="35" />  </td>
      </tr>
      <tr>
        <td><input type="submit" value="Upload File" name="upload_file"></td>
      </tr>      
    </table>
    
  </td>
</tr>
</table>










<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Candidate's Profile</b>
    </div>    
  </td>
</tr>

<tr><td colspan=2 >

<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
<tr><td valign="top" colspan="3">

<!-- START PROFILE -->
    
    <div class="ads">
    
      
     
     <!-- image -->
    <table width="100%">
    <tr>
    <td width="20%" valign="top" align="center">
<?
    if ($image!=""){
      $filename = $image;
      if (file_exists($filename)) {
      //echo "The file $filename exists";
      echo "<img border=0 src='$image' width=110 height=150>";
      } else {
        $image="http://www.remotestaff.com.au/".$image;
        //echo $image;
        echo "<img border=0 src='$image' width=110 height=150>";
        //echo "The file $filename does not exist";
      }
    }
    else
    {
        echo "<img border=0 src='images/Client.png' width=110 height=150>";
    }   
    
    //echo "<img border=0 src='$image' width=110 height=150>";
    
    
    
    ?>    
    <br />

      </td>
    <td width="80%" class="subtitle" valign="top">
    
    
    
    
    
    
          <table width="100%">
          <td><b>Candidate ID</b></td><td>:</td><td><? echo $userid;?></td></tr>
          <tr><td valign="top"><b>Candidate Ratings</b></td><td>:</td><td valign="top">
          <select name="star" style="font:10px tahoma;" onChange="javascript: change_rating(<?php echo $userid; ?>, this.value);" >
          
          <option value="0">-</option>
          <option value="<?php echo $rating; ?>" selected><?php echo $rating; ?></option>
          <option value="1">1</option>
          
          <option value="2">2</option>
          
          <option value="3">3</option>
          
          <option value="4">4</option>
          
          <option value="5">5</option>
          
          </select>&nbsp;
          
          <i>(Ratings : 1 <img src="images/star.png" align="texttop"> = Low potential  ----  5 <img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top">=Highest potential)</i>
          
          
          </td></tr>
          
          
          
          <tr><td width="27%" valign="top" ><b>Date Registered</b></td>
          
          <td width="2%" valign="top">:</td>
          
          <td width="71%" valign="top"><? echo $dateapplied;?></td>
          
          </tr>
          
          <tr><td width="27%" valign="top" ><b>Last Update</b></td>
          
          <td width="2%" valign="top">:</td>
          
          <td width="71%" valign="top"><? echo $dateupdated;?></td>
          
          </tr>
                    
          
          <tr><td valign="top"><strong>Fullname</strong></td>
          
          <td valign="top">:</td><td valign="top"><? echo $name; ?></td></tr>
          
          <tr><td valign="top"><strong>Latest Job Title</strong></td>
          
          <td valign="top">:</td><td valign="top"><? echo $latest_job_title;?></td></tr>    
          
          <tr><td valign="top"><strong>Change Picture</strong></td>
          
          <td valign="top">:</td><td valign="top">
          <input type="file" name="img" id="img" style=""><input type="submit" name="picture" id="upload" value="Upload">          
          </td></tr>    
                    
          <tr><td valign="top">&nbsp;</td>
          
          <td valign="top"></td><td valign="top"></td></tr>                    
          </table>    
    </td>
    </tr>
    </table>
    
    <!-- image -->
    
    <!-- Personal Information -->  
    <table width=100% border=0 cellspacing=1 cellpadding=3 bgcolor="#ffffff">
    <tr bgcolor="#CCCCCC"><td colspan="5"><b>Personal Information</b></td><td align="right"><a href="javascript: admin_edit('<?php echo $userid; ?>','admin_updatepersonal.php'); ">Edit</a></td></tr>
    <tr><td width="26%" valign="top"><b>Age</b></td>
    <td width="3%" valign="top">:</td>
    <td width="35%" valign="top"><? echo $yr-$byear;?></td>
    <td width="17%" valign="top"><b>Date of Birth</b></td>
    <td width="2%" valign="top">:</td>
    <td width="17%" valign="top"><? echo $bmonth." ".$bday." ".$byear;?></td>
    </tr>
    <tr><td valign="top"><b>Nationality</b></td><td valign="top">:</td>
    <td valign="top"><? echo $nationality;?></td>
    <td valign="top"><b>Gender</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $gender;?></td></tr>
    <tr><td valign="top"><b>Permanent Residence</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $residence;?></td>
    <td valign="top" colspan="3"> </td></tr><tr><td valign="top" colspan="6">  </td></tr>
    <tr bgcolor="#CCCCCC"><td colspan="6"><b>Contact Information</b></td></tr>
    <tr>
    <td width="20%" valign="top"><b>Address</b></td>
    <td width="2%" valign="top">:</td>
    <td valign="top" colspan="4">
    <? echo $address;?></td></tr><tr><td valign="top"><b>Telephone No.</b></td><td valign="top">:</td>
    <td valign="top" colspan="4">
    <? echo $tel;?></td></tr><tr><td valign="top"><b>Mobile No.</b></td>
    <td valign="top">:</td><td valign="top" colspan="4">
    <? echo $cell;?>
    </td></tr>
    <tr><td valign="top"><b>Email</b></td><td valign="top">:</td><td width="37%" valign="top" colspan="4">
    <a href=mailto:<? echo $email; ?>><? echo $email;?></a>
    </td>
    </tr>

    <tr><td valign="top"><b>Initial Email Password</b></td><td valign="top">:</td><td width="37%" valign="top" colspan="4">
    <? echo $initial_email_password;?>
    </td>
    </tr>

    <tr><td valign="top"><b>Skype</b></td><td valign="top">:</td><td width="37%" valign="top" colspan="4"><? echo $skype_id;?></td>
    </tr>

    <tr><td valign="top"><b>Initial Skype Password</b></td><td valign="top">:</td><td width="37%" valign="top" colspan="4"><? echo $initial_skype_password;?></td>
    </tr>
    
    <td valign="top" colspan="3"> </td></tr><tr><td valign="top" colspan="6">  </td></tr>
    
    <tr bgcolor="#CCCCCC"><td colspan="6"><b>Working at Home Capabilities</b></td></tr>
    
    <tr><td valign="top" colspan="6">
    <!-- DETAILS HERE -->
    <? echo $message;?>
    <!-- DETAILS HERE -->
    </td>
    </tr>
    
    
    
    
    <!-- Education -->
    <?
    /*
    0 id,1 userid,2 educationallevel,3 fieldstudy,4 major,5 grade,6 gpascore,7 college_name,8 college_country,9 graduate_month,10 graduate_year
    */
    $query="SELECT * FROM education WHERE userid=$userid";
    $result=mysql_query($query);
    $ctr=@mysql_num_rows($result);
    if ($ctr >0 )
    {
      $row = mysql_fetch_array ($result, MYSQL_NUM); 
      $level = $row[2];
      $field = $row[3];
      $score = $row[6];
      $major = $row[4];
      $school =$row[7];
      $loc  = $row[8];
      $year =$row[10];
      $month =$row[9];
      switch($month)
      {
        case 1:
        $month= "Jan";
        break;
        case 2:
        $month= "Feb";
        break;
        case 3:
        $month= "Mar";
        break;
        case 4:
        $month= "Apr";
        break;
        case 5:
        $month= "May";
        break;
        case 6:
        $month= "Jun";
        break;
        case 7:
        $month= "Jul";
        break;
        case 8:
        $month= "Aug";
        break;
        case 9:
        $month= "Sep";
        break;
        case 10:
        $month= "Oct";
        break;
        case 11:
        $month= "Nov";
        break;
        case 12:
        $month= "Dec";
        break;
        default:
        break;
      }
      
    }  
    
    ?>
    <tr bgcolor="#CCCCCC"><td valign="top" colspan="5" class="ResumeHdr"><b>Highest Qualification</b></td><td align="right"><a href="javascript: admin_edit('<?php echo $userid; ?>','admin_updateeducation.php'); ">Edit</a></td>
    <tr><td valign="top"><b>Level</b></td><td valign="top">:</td>
    <td valign="top"><? echo $level;?></td>
    <?
     if ($score >0)
     {
      //echo "<td valign='top'><b>CGPA</b></td><td valign='top'>:</td><td valign='top'>".$score."/100</td>";
     }
    
    ?>
    </tr><tr><td valign="top"><b>Field of Study</b></td><td valign="top">:</td><td valign="top"><? echo $field;?></td><td valign="top" colspan="3"></td></tr>
    <tr><td valign="top"><b>Major</b></td><td valign="top">:</td>
    <td valign="top" colspan="4"><? echo $major;?></td></tr>
    <tr><td valign="top"><b>Institute / University</b></td>
    <td valign="top">:</td><td valign="top" colspan="4"><? echo $school;?></td></tr>
    <tr><td valign="top"><b>Located In</b></td><td valign="top">:</td>
    <td valign="top"><? echo $loc;?></td>
    <td valign="top"><b>Graduation Date</b></td>
    <td valign="top">:</td><td valign="top"><? echo $month;?>&nbsp;<? echo $year;?></td>
    </tr>
    
    <!--- work Experience --->
    <?
    
    /*
    0 id,1 userid,2 freshgrad,3 years_worked,4 months_worked,5 intern_status,6 iday,7 imonth,8 iyear,9 intern_notice,10 company_name,11 company_industry,12 title,
    13 dpt_field,14 positionlevel,15 monthjoined,16 yearjoined,17 monthleft,18 yearleft,19 available_status,20 available_notice,21 aday,22 amonth,23 ayear,
    24 salary_currency,25 expected_salary,26 expected_salary_neg
    */
    $query="SELECT * FROM currentjob WHERE userid=$userid";
    $result=mysql_query($query);
    $ctr=@mysql_num_rows($result);
    if ($ctr >0 )
    {
      $row3 = mysql_fetch_array ($result, MYSQL_NUM); 
      $company = $row3[10];
      $title= $row3[12];
      $level2 = $row3[14];
      $specialization = $row3[13];
      $industry = $row3[11];
      $month =$row3[15];
      $currency =$row3[24];
      $salary =$row3[25];
      $neg = $row3[26];
      
      $current = $row3[2];
      if ($current=="2")
      {
        $intern =$row3[5]; 
        switch ($intern)
        {
          case 'x':
      $mess=  "I am available for internship jobs.My internship period is from &nbsp;".$row3[6]." ".$row3[7]." ".$row3[8]."&nbsp;and the duration is &nbsp;".$row3[9];
          break;
          case 'p':
          $mess = "I am not looking for an internship now";
          break;
          default:
          break;
              
        }
      }
      
        
      
      
      switch($month)
      {
        case 1:
        $month= "Jan";
        break;
        case 2:
        $month= "Feb";
        break;
        case 3:
        $month= "Mar";
        break;
        case 4:
        $month= "Apr";
        break;
        case 5:
        $month= "May";
        break;
        case 6:
        $month= "Jun";
        break;
        case 7:
        $month= "Jul";
        break;
        case 8:
        $month= "Aug";
        break;
        case 9:
        $month= "Sep";
        break;
        case 10:
        $month= "Oct";
        break;
        case 11:
        $month= "Nov";
        break;
        case 12:
        $month= "Dec";
        break;
        default:
        break;
      }
      
      $start =$month." ".$row3[16];
      
      $month2 =$row3[17];
      switch($month2)
      {
        case 1:
        $month2= "Jan";
        break;
        case 2:
        $month2= "Feb";
        break;
        case 3:
        $month2= "Mar";
        break;
        case 4:
        $month2= "Apr";
        break;
        case 5:
        $month2= "May";
        break;
        case 6:
        $month2= "Jun";
        break;
        case 7:
        $month2= "Jul";
        break;
        case 8:
        $month2= "Aug";
        break;
        case 9:
        $month2= "Sep";
        break;
        case 10:
        $month2= "Oct";
        break;
        case 11:
        $month2= "Nov";
        break;
        case 12:
        $month2= "Dec";
        break;
        default:
        break;
      }
      $end =$month2." ".$row3[18];
      
      $status = $row3[19];
      switch($status)
      {
        case 'a':
        $str = "Can start work after &nbsp;".$row3[20];
        break;
        case 'b':
        $str = "Can start work after &nbsp;".$row3[22]."-".$row3[21]."-".$row3[23];
        break;
        case 'p':
        $str ="I am not actively looking for a job now";
        break;
        case 'Work Immediately';
        $str ="I can work immediately";
        break;
        default:
        break;
      }
      
    }
    
    ?>
    
    <tr><td valign="top" colspan="6"> </td></tr><tr class="TRHeader">
    <!--- work Experience --->
    <?
    $query="SELECT * FROM currentjob WHERE userid=$userid";
    $result=mysql_query($query);
    $ctr=@mysql_num_rows($result);
    if ($ctr >0 )
    {
      $row3 = mysql_fetch_array ($result); 
      // 1
      $company = $row3['companyname'];
      $position= $row3['position'];
      $period = $row3['monthfrom']." ".$row3['yearfrom']." "."to"." ".$row3['monthto']." ".$row3['yearto'];
      $duties =$row3['duties'];
      // 2
      $company2 = $row3['companyname2'];
      $position2= $row3['position2'];
      $period2 = $row3['monthfrom2']." ".$row3['yearfrom2']." "."to"." ".$row3['monthto2']." ".$row3['yearto2'];
      $duties2 =$row3['duties2'];
      // 3
      $company3 = $row3['companyname3'];
      $position3= $row3['position3'];
      $period3 = $row3['monthfrom3']." ".$row3['yearfrom3']." "."to"." ".$row3['monthto3']." ".$row3['yearto3'];
      $duties3 =$row3['duties3'];
      // 4
      $company4 = $row3['companyname4'];
      $position4= $row3['position4'];
      $period4 = $row3['monthfrom4']." ".$row3['yearfrom4']." "."to"." ".$row3['monthto4']." ".$row3['yearto4'];
      $duties4 =$row3['duties4'];
      //5
      $company5 = $row3['companyname5'];
      $position5= $row3['position5'];
      $period5 = $row3['monthfrom5']." ".$row3['yearfrom5']." "."to"." ".$row3['monthto5']." ".$row3['yearto5'];
      $duties5 =$row3['duties5'];
      //6
      $company6 = $row3['companyname6'];
      $position6= $row3['position6'];
      $period6 = $row3['monthfrom6']." ".$row3['yearfrom6']." "."to"." ".$row3['monthto6']." ".$row3['yearto6'];
      $duties6 =$row3['duties6'];      
      //7
      $company7 = $row3['companyname7'];
      $position7= $row3['position7'];
      $period7 = $row3['monthfrom7']." ".$row3['yearfrom7']." "."to"." ".$row3['monthto7']." ".$row3['yearto7'];
      $duties7 =$row3['duties7'];      
      //8
      $company8 = $row3['companyname8'];
      $position8= $row3['position8'];
      $period8 = $row3['monthfrom8']." ".$row3['yearfrom8']." "."to"." ".$row3['monthto8']." ".$row3['yearto8'];
      $duties8 =$row3['duties8'];      
      //9
      $company9 = $row3['companyname9'];
      $position9= $row3['position9'];
      $period9 = $row3['monthfrom9']." ".$row3['yearfrom9']." "."to"." ".$row3['monthto9']." ".$row3['yearto9'];
      $duties9 =$row3['duties9'];      
      //10
      $company10 = $row3['companyname10'];
      $position10= $row3['position10'];
      $period10 = $row3['monthfrom10']." ".$row3['yearfrom10']." "."to"." ".$row3['monthto10']." ".$row3['yearto10'];
      $duties10 =$row3['duties10'];      
      
      ///////////////////////////
      $currency =$row3['salary_currency'];
      $salary =$row3['expected_salary'];
      $neg = $row3['expected_salary_neg'];
      
      $current = $row3['freshgrad'];
      if ($current=="2")
      {
        $intern =$row3['intern_status']; 
        switch ($intern)
        {
          case 'x':
      $mess=  "I am available for internship jobs.My internship period is from &nbsp;".$row3['iday']." ".$row3['imonth']." ".$row3['iyear']."&nbsp;and the duration is &nbsp;".$row3['intern_notice'];
          break;
          case 'p':
          $mess = "I am not looking for an internship now";
          break;
          default:
          break;
              
        }
      }
      
      $status = $row3['available_status'];
      switch($status)
      {
        case 'a':
        $str = "Can start work after &nbsp;".$row3['available_notice'];
        break;
        case 'b':
        $str = "Can start work after &nbsp;".$row3['amonth']."-".$row3['aday']."-".$row3['ayear'];
        break;
        case 'p':
        $str ="I am not actively looking for a job now";
        break;
        case 'Work Immediately';
        $str ="I can work immediately";
        break;
        default:
        break;
      }
      
    }
    
    ?>
    
    <tr bgcolor="#CCCCCC">
    <td valign="top" colspan="5" class="ResumeHdr"><b>Employment History</b></td><td align="right"><a href="javascript: admin_edit('<?php echo $userid; ?>','admin_updatecurrentJob.php'); ">Edit</a></td>
    </tr>
    <tr><td valign="top" colspan="6">
    <table width="100%" border="0">
    <? if ($company!="") {?>
    <tr><td valign="top" width="3%">1. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties;?></td></tr>
    <? }?>
    
    <? if ($company2!="") {?>
    <tr><td valign="top" width="3%">2. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company2;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position2;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period2;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties2;?></td></tr>
    <? }?>
    
    <? if ($company3!="") {?>
    <tr><td valign="top" width="3%">3. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company3;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position3;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period3;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties3;?></td></tr>
    <? }?>
    
    <? if ($company4!="") {?>
    <tr><td valign="top" width="3%">4. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company4;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position4;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period4;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties4;?></td></tr>
    <? }?>
    
    <? if ($company5!="") {?>
    <tr><td valign="top" width="3%">5. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company5;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position5;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period5;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties5;?></td></tr>
    <? }?>
    
    
    
    <? if ($company6!="") {?>
    <tr><td valign="top" width="3%">6. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company6;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position6;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period6;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties6;?></td></tr>
    <? }?>    
    
    
    <? if ($company7!="") {?>
    <tr><td valign="top" width="3%">7. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company7;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position7;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period7;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties7;?></td></tr>
    <? }?>
    
    
    <? if ($company8!="") {?>
    <tr><td valign="top" width="3%">8. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company8;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position8;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period8;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties8;?></td></tr>
    <? }?>    
        
        
    <? if ($company9!="") {?>
    <tr><td valign="top" width="3%">9. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company9;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position9;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period9;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties9;?></td></tr>
    <? }?>        
    
    
    <? if ($company10!="") {?>
    <tr><td valign="top" width="3%">10. </td>
    <td valign="top" width="20%"><b>Company Name</b></td>
    <td valign="top" width="1%">:</td>
    <td valign="top" width="75%"><? echo $company10;?>
    </td></tr>
    <tr>
    <td valign="top"></td>
    <td valign="top"><b>Position Title</b></td><td valign="top">:</td>
    <td valign="top"><? echo $position10;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Employment Period</b></td>
    <td valign="top">:</td>
    <td valign="top"><? echo $period10;?></td></tr>
    <tr><td valign="top"></td>
    <td valign="top"><b>Responsibilies /Achievements</b></td>
    <td valign="top">:</td><td valign="top"><? echo $duties10;?></td></tr>
    <? }?>    
    
    
    <tr><td valign="top" colspan="4" align="left">&nbsp;</td></tr>
    
    <? if ($mess!=""){
    
    echo "<tr>
    <td valign='top' colspan=3 align=left>".$mess."</td>";
    
    }
    ?>
    
    <? if ($str!=""){
    
    echo "<tr>
    <td valign='top' colspan=3 align=left>".$str."</td>";
    }
    ?>
    <tr><td valign="top" colspan="2" align="left"><b><? echo $currency." ".$salary." ".$neg;?></b></td></tr>
    </table>
    </td>
    </tr>
    
    <?
    
    if($company=="")
    {
      
      if($mess!="")
      {
        echo "<tr bgcolor='#CCCCCC'><td valign='top' colspan='6'><b>Intership Status</b></td></tr>";
        echo "<tr><td colspan=6>&nbsp;</td></tr>";
        echo "<tr><td colspan=6>$mess</td></tr>";
        echo "<tr><td colspan=6>&nbsp;</td></tr>";
      }
      if($str!="")
      {
        echo "<tr bgcolor='#CCCCCC'><td valign='top' colspan='6'><b>Availability Status</b></td></tr>";
        echo "<tr><td colspan=6>&nbsp;</td></tr>";
        echo "<tr><td colspan=6>$str</td></tr>";
        echo "<tr><td colspan=6>&nbsp;</td></tr>";
      }
    }
    
    ?>
    <!--- languages --->
    <tr bgcolor="#CCCCCC"><td valign="top" colspan="5" ><b>Languages</b></td><td align="right"><a href="javascript: admin_edit('<?php echo $userid; ?>','admin_updatelanguages.php'); ">Edit</a></td></tr>
    <tr><td valign="top" colspan="6">
    <table width="100%" cellpadding="2" cellspacing="0"><tr><td valign="top"> </td>
    <td valign="top" align="right" colspan="3"><b>Proficiency</b> (0=Poor - 10=Excellent)</td></tr>
    <tr><td valign="top"><b>Language</b></td><td valign="top" align="center"><b>Spoken</b></td><td valign="top" align="center"><b>Written</b></td></tr>
    <?
    
    $counter = 0;
    $query="SELECT id,language,spoken,written FROM language WHERE userid=$userid;";
    //echo $query;
    $result=mysql_query($query);
    //echo @mysql_num_rows($result);
    $ctr=@mysql_num_rows($result);
    
      
      while(list($id,$language,$spoken,$written) = mysql_fetch_array($result))
      {
        
        echo "<tr>
            <td valign='top'>".$language."</td>
            <td valign='top' align='center'>".$spoken."</td>
            <td valign='top' align='center'>".$written."</td>
            </tr>";
      }  
    
    ?>
    
    </table></td></tr>
    <!-- Skills -->
    <?
    
    $counter = 0;
    $query="SELECT id, skill, experience, proficiency FROM skills WHERE userid=$userid;";
    //echo $query;
    $result=mysql_query($query);
    //echo @mysql_num_rows($result);
    $ctr=@mysql_num_rows($result);
    
    ?>
    <tr ><td valign="top" colspan="6" >&nbsp;</td></tr>
    <tr bgcolor="#CCCCCC"><td valign="top" colspan="5" ><b>Skills</b></td><td align="right"><a href="javascript: admin_edit('<?php echo $userid; ?>','admin_updateskillsStrengths.php'); ">Edit</a></td></tr>
    <tr><td valign="top" colspan="6">
    <table width="100%" cellpadding="2" cellspacing="0"><tr><td width="22%" valign="top"> </td>
    <td valign="top" align="right" colspan="3"><b>Proficiency</b> (1=Beginner - 2=Intermediate - 3=Advanced)</td></tr>
    <tr><td valign="top"><b>Skill</b></td><td width="39%" align="center" valign="top"><b>Experience</b></td>
    <td width="39%" align="center" valign="top"><b>Proficiency</b></td>
    </tr>
    <?  
      while(list($id,$skill,$exp,$pro) = mysql_fetch_array($result))
      {
        
        echo "<tr>
            <td valign='top'>".$skill."</td>
            <td valign='top' align='center'>".$exp." yr/s</td>
            <td valign='top' align='center'>".$pro."</td>
            </tr>";
      }  
    
    ?>
    
    </table></td></tr>
    <!-- Comments here --->
    <?
    
    $counter = 0;
    $query5="SELECT id, agent_no, userid, rate, comments, DATE_FORMAT(date_created,'%D %M %Y') FROM comments WHERE userid=$userid ORDER BY date_created DESC;";
    //echo $query;
    $result5=mysql_query($query5);
    //echo @mysql_num_rows($result);
    $ctr=@mysql_num_rows($result5);
    if ($ctr >0 )
    {
    ?>
    
    <tr ><td valign="top" colspan="6" >&nbsp;</td></tr>
    <tr bgcolor="#CCCCCC"><td valign="top" colspan="6" ><b>Comments</b></td></tr>
    <tr><td valign="top" colspan="6">
    
    <?  
      while(list($id, $agent_no, $userid, $rate, $comments, $date) = mysql_fetch_array($result5))
      {
        $counter=$counter+1;
        if($rate=="1")
        {
          $rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
        }
        if($rate=="2")
        {
          $rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
        }
        if($rate=="3")
        {
          $rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
        }
        if($rate=="4")
        {
          $rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
        }
        if($rate=="5")
        {
          $rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
        }
        $comments=str_replace("\n","<br>",$comments);
        $notes.="<p><div id='l'><b>".$counter.")&nbsp;&nbsp;".$date."</b><ul>" .$comments."</ul></div>
        <div id='r'>".$rate."</div></p>";
      }  
      echo "<div class='scroll'>".$notes."</div></p>";
    }
    ?>
    
    </td></tr>
    
    <!-- Ends Here --->
    
    
    
    
    </table>
    </div>

<!-- END PROFILE -->









</td>

</tr>

<tr><td colspan="3"><hr></td></tr>

<tr><td width="27%" valign="top"><strong>Questions / Concern</strong></td>

<td width="2%" valign="top">:</td><td width="71%" valign="top"><ul style="margin-top:0px; margin-left:2px;"><? echo $your_questions;?></ul></td></tr>

<? if($outsourcing_experience =="Yes")

echo "<tr><td valign=top><b>Outsourcing Experience / Details</b></td><td valign=top>:</td><td valign=top><ul style='margin-top:0px; margin-left:2px;'>".$outsourcing_experience_description."</ul></td></tr>";

?>

    </table>



</td></tr>
<tr><td colspan="2">
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>


    <table cellpadding="5" cellspacing="5">
      <tr>
        <td align="center">
          <input type="button" class="button" value="Add to Categories / Evaluate" onClick="javascript: move(<?php echo $userid; ?>, 'Category'); "/>
          <input type="button" class="button" value="Pre-Screen" onClick="javascript: move(<?php echo $userid; ?>, 'Pre-Screen'); "/>
          <input type="button" class="button" value="Unprocessed" onClick="javascript: move(<?php echo $userid; ?>, 'Unprocessed'); "/>
          <input type="button" class="button" value="Shortlist" onClick="javascript: move(<?php echo $userid; ?>, 'Shortlist'); "/>
        </td>
      </tr>
      <tr>
        <td align="center">
          <input type="button" class="button" value="Select" onClick="javascript: move(<?php echo $userid; ?>, 'Select'); "/>
          <input name="button" type="button" class="button" onClick="javascript: move(<?php echo $userid; ?>, 'Become a Staff'); " value="Become a Staff"/>
          <input type="button" class="button"  value="No Potential" onClick="javascript: move(<?php echo $userid; ?>, 'No Potential'); "/>
          <input type="button" class="button"  value="Endorse to Client" onClick="javascript: move(<?php echo $userid; ?>, 'Endorse to Client'); "/>
        </td>
      </tr>
    </table>


</td>
</tr></table>
</td>
</tr>




<!------- EVALUATION ------------>
<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Evaluation</b>
    </div>    
  </td>
</tr>
<tr>
  <td colspan="2" bgcolor="#FFFFFF">



<?php
include '../time.php';
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
  die("Admin ID is Missing.");
}

$admin_id = $_SESSION['admin_id'];
$userid=$_REQUEST['userid'];

$queryApplicant="SELECT * FROM personal p  WHERE p.userid=$userid";
$data=mysql_query($queryApplicant);
$row = mysql_fetch_array ($data); 
$name =$row['fname']."  ".$row['lname'];

$timeNum = array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");
$timeArray = array("-","1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am");
for($i=0; $i<count($timeNum); $i++)
{
  if($starting_hours == $timeNum[$i])
  {
    $start_work_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
  }else{
    $start_work_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
  }
  if($ending_hours == $timeNum[$i])
  {
    $finish_work_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
  }else{
    $finish_work_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
  }
}


$daynameArray = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
for($i=0;$i<count($daynameArray);$i++)
{
  $daysOptions.="<option value= ".$daynameArray[$i].">".$daynameArray[$i]."</option>";
}



$sql = "SELECT id,DATE_FORMAT(evaluation_date,'%D %b %Y'), work_fulltime, fulltime_sched, work_parttime, parttime_sched, work_freelancer, expected_minimum_salary FROM evaluation WHERE userid = $userid;";
$result = mysql_query($sql);
list($evaluation_id,$evaluation_date, $work_fulltime, $fulltime_sched, $work_parttime, $parttime_sched, $work_freelancer, $expected_minimum_salary)=mysql_fetch_array($result);

if($evaluation_date!=""){
  $evaluation_date = "<p><label>Evaluation Date</label>".$evaluation_date."</p>";
}

if($work_fulltime == "yes"){
  $work_fulltime = 'checked="checked"';
  $show_full_time_div = "style='display:block;'";
}else{
  $show_full_time_div = "style='display:none;'";
}

if($work_parttime == "yes"){
  $work_parttime = 'checked="checked"';
  $show_part_time_div = "style='display:block;'";
}else{
  $show_part_time_div = "style='display:none;'";
}

if ($work_freelancer == "yes"){
  $work_freelancer =  'checked="checked"';
  $show_freelancer_div = "style='display:block;'";
}else{
  $show_freelancer_div = "style='display:none;'";
}



$shift_Array = array("Morning-Shift","Afternoon-Shift","Night-Shift","Anytime");
for($i=0;$i<count($shift_Array);$i++){
  if($fulltime_sched == $shift_Array[$i]){
    $fulltime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='full_time_shift' checked='checked' value=".$shift_Array[$i]." ></p>";
  }else{
    $fulltime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='full_time_shift' value=".$shift_Array[$i]." ></p>";
  }
  
  if($parttime_sched == $shift_Array[$i])
  {
    $parttime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='part_time_shift' checked='checked' value=".$shift_Array[$i]." ></p>";
  }else
  {
    $parttime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='part_time_shift' value=".$shift_Array[$i]." ></p>";
  }
  
}

?>

  <div style="padding:5px; border:#CCCCCC solid 1px;font:12px Arial; background:#FFFFFF;">
    <?=$evaluation_date;?>
    <p><label>Expected Minimum Salary: <?=$expected_minimum_salary;?></label></p>
    <p><label>Willing to Work Full-Time </label><input type="checkbox" name="full_time_status" value="Full-Time" <?=$work_fulltime;?> ></p>
    
    <div id="full_time_div" <?=$show_full_time_div;?>>
    <p style="color:#999999;"><i>The Applicant must work a minimum of 9 hours a day with 1 hour lunch break 5 days a week </i></p>
    <?=$fulltime_shifts;?>
      
    </div>
    
    
    
    
    
    
    <p><label>Willing to Work Part-Time </label>
      <input type="checkbox" name="part_time_status" value="Part-Time" <?=$work_parttime;?> onClick="checkCheckBoxes('part_time_status' , 'part_time_div');" > 
      </p>
    <div id="part_time_div" <?=$show_part_time_div;?>>
    <p style="color:#999999;"><i>The Applicant must work a minimum of 4 hours a day 5 days a week </i></p>
    <?=$parttime_shifts;?>
    
    </div>
    
    <!-- Freelancer time schedule -->    <p><label>Willing to Work as a Freelancer </label><input type="checkbox" name="freelancer_status" value="Part-Time" <?=$work_freelancer;?> onClick="checkCheckBoxes('freelancer_status' , 'freelancer_div');" > </p>
    <div id="freelancer_div" <?=$show_freelancer_div;?>>
    <p>Working Time</p>
    <p style="color:#999999;"><i>The Applicant must indicate his time availability </i></p>
      
    <p>
    <div id="freelancer_schedule_list" style="width:500px;">
    <div style="border:#CCCCCC outset 1px; font: 12px Arial; background:#CCCCCC; padding-top:2px; padding-bottom:2px;">
      <div style="float:left; width:90px; display:block;font: 12px Arial;"><b>Day</b></div>
      <div style="float:left; width:200px; display:block;font: 12px Arial;"><b>Schedule</b></div>
      <div style="float:left; width:60px; display:block;font: 12px Arial;"><b>Hour</b></div>
      <div style="clear:both;"></div>
    </div>
    <?
    $sql = "SELECT id, day_name, start_str, finsh_str, hour FROM evaluation_freelancer_time_schedule WHERE userid = $userid ORDER BY day_id ASC;";
    $result = mysql_query($sql);
    while(list($id, $days, $start_str, $finsh_str, $hour)=mysql_fetch_array($result))
    {
    ?>
      <div style="border-bottom:#CCCCCC solid 1px;font: 12px Arial;">
      <div style="float:left; width:90px; display:block;font: 12px Arial;"><?=$days;?></div>
      <div style="float:left; width:200px; display:block;font: 12px Arial;"><?=$start_str;?> - <?=$finsh_str;?></div>
      <div style="float:left; width:60px; display:block;font: 12px Arial;"><?=$hour;?></div>
      <div style="clear:both;"></div>
      </div>
    <?
    }
    ?>
    </div>
    </div>
    
    <div style="background:#ffffff; padding:10px; font:12px Arial; border:#CCCCCC solid 1px;">
    <div id="evaluation_comments_list">
    
  <div style='border:#000000 outset 1px; font: 12px Arial; background:#CCCCCC '>
    <div style='float:left; width:30px; display:block;font: 12px Arial;'><strong>#</strong></div>
    <div style='float:left; width:450px; display:block;font: 12px Arial;text-align:center;border-left:#000000 solid 1px; border-right:#000000 solid 1px;'><strong>Comments / Notes</strong></div>
    <div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center;'><strong>Date</strong></div>
    <div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center; border-left:#000000 solid 1px;'><strong>Comment By</strong></div>
    <div style='clear:both;'></div>
  </div>
<?
$sql = "SELECT id, comments, DATE_FORMAT(comment_date,'%D %b %y'),a.admin_fname  FROM evaluation_comments e LEFT OUTER JOIN admin a ON a.admin_id = e.comment_by WHERE userid = $userid;";


//echo $sql;
$result = mysql_query($sql);
$counter = 0;
while(list($id, $comments, $date , $admin_fname)=mysql_fetch_array($result))
{
  $counter++;
  $comments = str_replace("\n","<br>",$comments);
 ?>
 
   <div style='border:#CCCCCC  solid 1px; font: 12px Arial; background:#FFFFFF '>
    <div style='float:left; width:30px; display:block;font: 12px Arial;'><?=$counter?></div>
    <div style='float:left; width:450px; display:block;font: 11px Arial;text-align:center;border-left:#000000 solid 1px; border-right:#000000 solid 1px;'>
    <?=$comments;?>
    </div>
    <div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center;'><?=$date;?></div>
    <div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center; border-left:#000000 solid 1px;'><?=$admin_fname?></div>
    <div style='clear:both;'></div>
  </div>
 
 <?
}

?>
    
    </div>
    </div>  </td>
</tr>
<!------- EVALUATION ------------>



<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Additional Information</b>
    </div>    
  </td>
</tr>

<tr>
  <td  colspan="2" width=30% >    
  <table width=100% border=0 cellspacing=1 cellpadding=2>

      <tr>
        <td valign="top" width="50%">
      <strong>Relevant&nbsp;Industry&nbsp;Experience&nbsp;</strong>[<a href="javascript: admin_edit('<?php echo $userid; ?>','admin_relevant_industry_experience.php'); ">Edit</a>]<br />
          <?php
            echo '<table cellpadding="0" cellspacing="0" border="0">';
            $queryAllLeads = "SELECT name
              FROM tb_relevant_industry_experience WHERE userid='$userid'
              ORDER BY name ASC;";
            //echo $queryAllLeads;
            $result = mysql_query($queryAllLeads);
            $counter = 1;
            while(list($name)=mysql_fetch_array($result))
            {
              echo "<tr><td>".$counter.")&nbsp;</td><td>".$name."</td></tr>";
              $counter++;
            }
            echo "</table>";
      ?>
        </td>
      </tr>
    </table></td>
</tr>








<tr>
  <td>
              <table width="100%">
                <tr>
                  <td>
                    <strong>Top 10 Categories</strong>
                  </td>
                </tr>
                <tr>
                  <td>
                      <table width=100% border=0 cellspacing=1 cellpadding=3 bgcolor="#E9E9E9">
                        <tr>
                          <td>Category</td>
                          <td>Sub Category</td>
                          <td>TOP-10</td>
                          <td>Date Created</td>
                        </tr>
                        
                        

                            <?php
                            $q = "SELECT id, category_id, sub_category_id, ratings, sub_category_applicants_date_created FROM job_sub_category_applicants WHERE userid='$userid'";
                            $result = mysql_query($q);
                            while(list($id, $category_id, $sub_category_id, $ratings, $sub_category_applicants_date_created)=mysql_fetch_array($result))
                            {
                              echo "<tr>";
                              $cat = "SELECT category_name FROM job_category WHERE category_id='$category_id'";
                              $cat_result = mysql_query($cat);
                              while(list($category_name)=mysql_fetch_array($cat_result))
                              {      
                                echo "<td valign='top' bgcolor='#ffffff'>".$category_name.":&nbsp;&nbsp;</td>";
                              }  
                              $cat = "SELECT sub_category_name FROM job_sub_category WHERE sub_category_id='$sub_category_id'";
                              $cat_result = mysql_query($cat);
                              while(list($sub_category_name)=mysql_fetch_array($cat_result))
                              {
                                echo "<td valign='top' bgcolor='#ffffff'>".$sub_category_name."</td>";
                              }
                              echo "<td valign='top' bgcolor='#ffffff'>";
                              ?>
                              
                              
                                <select name="star" style="font:10px tahoma;" onChange="javascript: change_top10(<?php echo $id; ?>, this.value);" >
                                  <option value="">-</option>
                                  <option value="<?php echo $ratings; ?>" selected><?php if($ratings==1) echo "No"; else echo "Yes"; ?></option>
                                  <option value="0">Yes</option>
                                  <option value="1">No</option>
                                </select>

                              
                              <?php
                              echo "</td>";
                              echo "<td valign='top' bgcolor='#ffffff'>".$sub_category_applicants_date_created."</td>";
                              echo "</tr>";  
                            }
                            ?>            



                      </table>
                      
                  </td>
                </tr>
              </table>  
  </td>
</tr>














<tr>
  <td>
              <table width="100%">
                <tr>
                  <td>
                    <strong>Endorsement History</strong>
                  </td>
                </tr>
                <tr>
                  <td>
                      <table width=100% border=0 cellspacing=1 cellpadding=3 bgcolor="#E9E9E9">
                        <tr>
                          <td>Client Name</td>
                          <td>Position</td>
                          
                          <td>Part-time&nbsp;Rate</td>
                          <td>Full-Time&nbsp;Rate</td>
                          
                          <td>Status</td>
                          <td>Date Endosed</td>
                        </tr>
        <?php
          $queryAllLeads = "SELECT client_name, position, part_time_rate, full_time_rate status, date_endoesed
            FROM tb_endorsement_history WHERE userid='$userid'
            ORDER BY position ASC;";
          //echo $queryAllLeads;
          $result = mysql_query($queryAllLeads);
          while(list($client_name, $position, $part_time_rate, $full_time_rate, $status, $date_endoesed)=mysql_fetch_array($result))
          {
              $a = mysql_query("SELECT fname, lname FROM leads WHERE id='$client_name' LIMIT 1");
              $name = mysql_result($a,0,"fname")." ".mysql_result($a,0,"lname");          
        ?>                
                        <tr>
                          <td bgcolor="#FFFFFF">
                            <?php 
                              echo $name; 
                            ?>
                          </td>
                          <td bgcolor="#FFFFFF">
                            <?php 
                              $a = mysql_query("SELECT jobposition FROM posting WHERE id='$position' LIMIT 1");
                              $name = mysql_result($a,0,"jobposition");
                              echo $name;                              
                            ?>
                          </td>
                          
                          <td bgcolor="#FFFFFF"><?php echo $part_time_rate; ?></td>
                          <td bgcolor="#FFFFFF"><?php echo $full_time_rate; ?></td>
                          
                          <td bgcolor="#FFFFFF"><?php echo $status; ?></td>
                          <td bgcolor="#FFFFFF"><?php echo $date_endoesed; ?></td>
                        </tr>
        <?php
          }
        ?>                
                      </table>
                      
                  </td>
                </tr>
              </table>  
  </td>
</tr>


<tr>
  <td>
              <table width="100%">
                <tr>
                  <td>
                    <strong>Shortlist History</strong>
                  </td>
                </tr>
                <tr>
                  <td>
                      <table width=100% border=0 cellspacing=1 cellpadding=3 bgcolor="#E9E9E9">
                        <tr>
                          <td>Position</td>
                          <td>Status</td>
                          <td>Date Listed</td>
                        </tr>
        <?php
          $queryAllLeads = "SELECT position, status, date_listed
            FROM tb_shortlist_history WHERE userid='$userid'
            ORDER BY position ASC;";
          //echo $queryAllLeads;
          $result = mysql_query($queryAllLeads);
          while(list($position, $status, $date_listed)=mysql_fetch_array($result))
          {
        ?>                
                        <tr>
                          <td bgcolor="#FFFFFF">
                            <?php 
                              $a = mysql_query("SELECT jobposition FROM posting WHERE id='$position' LIMIT 1");
                              $name = mysql_result($a,0,"jobposition");
                              echo $name;
                            ?>
                          </td>
                          <td bgcolor="#FFFFFF"><?php echo $status; ?></td>
                          <td bgcolor="#FFFFFF"><?php echo $date_listed; ?></td>
                        </tr>
        <?php
          }
        ?>                
                      </table>
                      
                  </td>
                </tr>
              </table>  
  </td>
</tr>


<tr>
  <td>
              <table width="100%">
                <tr>
                  <td>
                    <strong>Selection History</strong>
                  </td>
                </tr>
                <tr>
                  <td>
                      <table width=100% border=0 cellspacing=1 cellpadding=3 bgcolor="#E9E9E9">
                        <tr>
                          <td>Position</td>
                          <td>Status</td>
                          <td>Date Selected</td>
                        </tr>
        <?php
          $queryAllLeads = "SELECT position, status, date_selected
            FROM tb_selected_history WHERE userid='$userid'
            ORDER BY position ASC;";
          //echo $queryAllLeads;
          $result = mysql_query($queryAllLeads);
          while(list($position, $status , $date_selected)=mysql_fetch_array($result))
          {
        ?>                
                        <tr>
                          <td bgcolor="#FFFFFF">
                            <?php 
                              $a = mysql_query("SELECT sub_category_name FROM job_sub_category WHERE sub_category_id='$position' LIMIT 1");
                              $name = mysql_result($a,0,"sub_category_name");
                              echo $name;
                            ?>
                          </td>
                          <td bgcolor="#FFFFFF"><?php echo $status; ?></td>
                          <td bgcolor="#FFFFFF"><?php echo $date_selected; ?></td>
                        </tr>
        <?php
          }
        ?>                
                      </table>
                      
                  </td>
                </tr>
              </table>  
  </td>
</tr>


<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Contacts Records</b>
    </div>    
  </td>
</tr>

<tr>

  <td  colspan="2" width=30% >
  <p><? echo $fname." ".$lname;?></p>
  <p style="color:#333333;">Please send all Service Agreements Contracts to contracts@remotestaff.com.au</p>  
  <table width=100% border=0 cellspacing=1 cellpadding=2>

  <tr>

  <td width="22%">

  <input type="radio" name="action" value="EMAIL" onclick ="showHide('EMAIL');"> Email

  <a href="sendemail.php?id=<? echo $leads_id;?>">

  <img border="0" src="images/email.gif" alt="Email" width="16" height="10">  </a>  </td>

  <td width="21%">


  <input type="radio" name="action" value="CALL" onclick ="showHide('CALL');"> Call 

  <img src="images/icon-telephone.jpg" alt="Call">  </td>

  <td width="21%">

  <input type="radio" name="action" value="MAIL" onclick ="showHide('MAIL');"> Notes

  <img src="images/textfile16.png" alt="Notes" >  </td>

  <td width="36%">

  <input type="radio" name="action" value="MEETING FACE TO FACE" onclick ="showHide('MEETING FACE TO FACE');"> Meeting face to face

  <img src="images/icon-person.jpg" alt="Meet personally">  </td>

  </tr>

  </table>

  <script language=javascript>

<!--

  function go(id) 

  {

    document.form.fill.value=id;      

  }

  function showHide(actions)

  {

    if(actions=="EMAIL")

    {

    

    newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";

    newitem+="<tr><td>";

    newitem+="<p><b>Subject :</b>&nbsp;&nbsp;<input type=\"text\"  name=\"subject\"></p>";

    newitem+="<B>Message :</B>";

    newitem+="<textarea name=\"txt\" cols=\"48\" rows=\"7\" wrap=\"physical\" class=\"text\"  style=\"width:100%\"></textarea>";

    newitem+="</td></tr>";

    newitem+="<tr><td><b>Send Message as :</b><br>";

    newitem+="<input type=\"radio\" name=\"templates\" value=\"signature\"> Signature Template";

    newitem+="&nbsp;&nbsp;&nbsp;";

    newitem+="<input type=\"radio\" name=\"templates\" value=\"plain\"> Plain Text";

    newitem+="&nbsp;&nbsp;&nbsp;";

    newitem+="<input type=\"radio\" name=\"templates\" value=\"promotional\"> Promotional Template";

    newitem+="<br>";

    newitem+="<b>1) Attach File :</b> <input name=\"image\" type=\"file\" id=\"image\" class=text >";

    newitem+="<br>";

    newitem+="<b>2) Attach File :</b> <input name=\"image2\" type=\"file\" id=\"image2\" class=text >";

    newitem+="<br>";

    newitem+="<b>3) Attach File :</b> <input name=\"image3\" type=\"file\" id=\"image3\" class=text >";

    newitem+="<br>";

    newitem+="<b>4) Attach File :</b> <input name=\"image4\" type=\"file\" id=\"image4\" class=text >";

    newitem+="<br>";

    newitem+="<b>5) Attach File :</b> <input name=\"image5\" type=\"file\" id=\"image5\" class=text >";

    newitem+="</td></tr>";

    newitem+="<tr><td align=center>";

    newitem+="<INPUT type=\"submit\" value=\"Send / Save\" name=\"Add\" class=\"button\" style=\"width:120px\">";

    newitem+="&nbsp;&nbsp;";

    newitem+="<INPUT type=\"reset\" value=\"Cancel\" name=\"Cancel\" class=\"button\" style=\"width:120px\">";

    newitem+="</td></tr></table>";

    document.getElementById("message").innerHTML=newitem;

    document.form.fill.value=actions;



    }

    else

    {

    newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";

    newitem+="<tr><td>";

    newitem+="<B>Add Record :</B>";

    newitem+="<textarea name=\"txt\" cols=\"48\" rows=\"7\" wrap=\"physical\" class=\"text\"  style=\"width:100%\"></textarea>";

    newitem+="</td></tr>";

    newitem+="<tr><td align=center>";

    newitem+="<INPUT type=\"submit\" value=\"Save\" name=\"Add\" class=\"button\" style=\"width:120px\">";

    newitem+="&nbsp;&nbsp;";

    newitem+="<INPUT type=\"reset\" value=\"Cancel\" name=\"Cancel\" class=\"button\" style=\"width:120px\">";

    newitem+="</td></tr></table>";

    document.getElementById("message").innerHTML=newitem;

    document.form.fill.value=actions;

    }

    

  }

-->

</script>  </td>

 </tr>

 <tr>

   <td colspan="2">

<!-- -->

<div id="message">

<table width=100% border=0 cellspacing=1 cellpadding=2 style="border:#CCCCCC solid 1px;">

<tr><td>

<B>Add Record :</B>

<textarea name="txt" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"><? echo $desc;?></textarea>

</td></tr>



<tr><td align=center>

<INPUT type="submit" value="save" name="Add" class="button" style="width:120px">

&nbsp;&nbsp;

<INPUT type="reset" value="Cancel" name="Cancel" class="button" style="width:120px">

</td></tr></table>

</div> 


<!-- --></td>

</tr>



<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Communication History</b>
    </div>    
  </td>
</tr>


<tr>

<td  colspan="2" width=30%  >

<?
function getCreator($created_by , $created_by_type)
{
  $query = "SELECT admin_fname, admin_lname FROM admin WHERE admin_id = $created_by;";
  $result=mysql_query($query);
  $ctr=@mysql_num_rows($result);
  if ($ctr >0 )
  {
    $row3 = mysql_fetch_array ($result); 
    $admin_fname = $row3['admin_fname'];
    $admin_lname= $row3['admin_lname'];
    $name = "Created by:  ".$admin_fname." ".$admin_lname;  
  }    
  
  return $name;
}

function getAttachment($id,$type,$mode){
  if($mode == "history"){
    if($type=="Quote"){
      $sql = "SELECT * FROM quote WHERE id = $id;";
      $data = mysql_query($sql);
      $row = mysql_fetch_array($data);
      $str = " <a href='#' class='link10'>Quote #".$row['quote_no']."</a>";
    }
    if($type=="Set-Up Fee Invoice"){
      $sql = "SELECT * FROM set_up_fee_invoice WHERE id = $id;";
      $data = mysql_query($sql);
      $row = mysql_fetch_array($data);
      $str = " <a href='./pdf_report/spf/?id=$id' target='_blank' class='link10'>Invoice #".$row['invoice_number']."</a>";
    }
    if($type=="Service Agreement"){
      $str = " <a href='./pdf_report/service_agreement/?id=$id' target='_blank' class='link10'>Service Agreement #".$id."</a>";
    }
    return $str;
  }
  if($mode == "details"){
    $sql = "SELECT DATE_FORMAT(date_attach,'%D %b %y') FROM history_attachments WHERE attachment = $id AND attachment_type = '$type';";
    $data = mysql_query($sql);
    list($date_sent) = mysql_fetch_array($data);
    if($date_sent!=NULL){
      $str = "Date Sent  ".$date_sent;
    }else{
      $str ="&nbsp;";
    }
    return $str;
  }
}


// id, agent_no, leads_id, actions, history, date_created, subject, created_by_type
$sql="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y'),agent_no,created_by_type FROM applicant_history WHERE userid=$leads_id AND actions ='EMAIL' ORDER BY date_created DESC;";
//echo $sql;
$result=mysql_query($sql);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
  $counter=0;
  while(list($id,$history,$date ,$created_by , $created_by_type) = mysql_fetch_array($result))
  {
    $creator = getCreator($created_by , 'Admin');
    $sqlAttachments = "SELECT attachment,attachment_type FROM applicant_history_attachments WHERE history_id = $id;";
    $data=mysql_query($sqlAttachments);
    $att="";
    while(list($attachment,$attachment_type)=mysql_fetch_array($data))
    {
      $att.= getAttachment($attachment,$attachment_type,'history');
    }
    
    $counter=$counter+1;
    $hist=$history;
    $history=substr($history,0,100);
    $txt.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
        <div style='float:left;'><b>".$counter.")  ".$date."</b><span style='margin-left:100px; FONT: bold 7.5pt verdana;
    COLOR: #676767;'>Sent the FF :".$att."</span></div>
        <div style='float:right;'><a href='?hid=$id&hmode=delete&userid=$leads_id' class='link12b' > Delete</a></div>
    <div style='clear:both;'></div>
    <div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./applicant_viewHistory.php?id=$id',500,400); title='$hist'>".$history."</a>
.</div>
    <div style='color:#999999;'>-- ".$creator."</div>
</div>";


  }

  echo "<p>Email <img src='images/email.gif' alt='Email' width='16' height='10'>";
  echo "<div class='scroll'>".$txt."</div></p>";

}



$sql2="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y'),agent_no,created_by_type FROM applicant_history WHERE userid=$leads_id AND actions ='CALL' ORDER BY date_created DESC;";

//echo $sql2."<br>";

$result2=mysql_query($sql2);

$ctr2=@mysql_num_rows($result2);

if ($ctr2 >0 )

{

  $counter=0;

  while(list($id,$history, $date,$created_by , $created_by_type) = mysql_fetch_array($result2))

  {

    $creator = getCreator($created_by , 'Admin');

    $counter=$counter+1;

    $hist=$history;

    $history=substr($history,0,30);

    $txt2.="<div><div class='l'><b>".$counter.")  ".$date."</b>"

    ."&nbsp;&nbsp;&nbsp;&nbsp;".

    "<a href=javascript:popup_win('./applicant_viewHistory.php?id=$id',500,400); title='$hist'>".$history."</a>

    </div>

    <div class='r'><a href='?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='?hid=$id&hmode=delete&userid=$leads_id' class='link12b' > Delete</a></div>

    <div style='clear:both;'></div>

    <div style='color:#CCCCCC'>-- ".$creator."</div>

    </div>";

    

  }

  echo "<p>Call <img src='images/icon-telephone.jpg' alt='Call'>";

  echo "<div class='scroll'>".$txt2."</div></p>";

}



$sql3="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y'),agent_no,created_by_type FROM applicant_history WHERE userid=$leads_id AND actions ='MAIL' ORDER BY date_created DESC;";

//echo $sql3."<br>";

$result3=mysql_query($sql3);

$ctr3=@mysql_num_rows($result3);

if ($ctr3 >0 )

{

  $counter=0;

  while(list($id,$history,$date,$created_by , $created_by_type) = mysql_fetch_array($result3))

  {

    $creator = getCreator($created_by , 'Admin');

    $counter=$counter+1;

    $hist=$history;

    $history=substr($history,0,30);

    $txt3.="<div><div class='l'><b>".$counter.")  ".$date."</b>"

    ."&nbsp;&nbsp;&nbsp;&nbsp;".

    "<a href=javascript:popup_win('./applicant_viewHistory.php?id=$id',500,400); title='$hist'>".$history."</a>

    </div>

    <div class='r'><a href='?hid=$id&mode=update&userid=$leads_id' class='link12b' >Edit</a> |<a href='?hid=$id&hmode=delete&userid=$leads_id' class='link12b' > Delete</a></div>

    <div style='clear:both;'></div>

    <div style='color:#CCCCCC'>-- ".$creator."</div>

    </div>";

    

  }

  echo "<p>Notes  <img src='images/textfile16.png' alt='Mail' >";

  echo "<div class='scroll'>".$txt3."</div></p>";

}



$sql4="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y') ,agent_no,created_by_type FROM applicant_history WHERE  userid=$leads_id AND actions ='MEETING FACE TO FACE' ORDER BY date_created DESC;";

//echo $sql3."<br>";

$result4=mysql_query($sql4);

$ctr4=@mysql_num_rows($result4);

if ($ctr4 >0 )

{

  $counter=0;

  while(list($id,$history,$date,$created_by , $created_by_type) = mysql_fetch_array($result4))

  {

    $creator = getCreator($created_by , 'Admin');

    $counter=$counter+1;
    $hist=$history;
    $history=substr($history,0,30);
    $txt4.="<div><div class='l'><b>".$counter.")  ".$date."</b>"
    ."&nbsp;&nbsp;&nbsp;&nbsp;".
    "<a href=javascript:popup_win('./applicant_viewHistory.php?id=$id',500,400); title='$hist'>".$history."</a>
    </div>
    <div class='r'><a href='?hid=$id&mode=update&userid=$leads_id' class='link12b' >Edit</a> |<a href='?hid=$id&hmode=delete&userid=$leads_id' class='link12b' > Delete</a></div>
    <div style='clear:both;'></div>
    <div style='color:#CCCCCC'>-- ".$creator."</div>
    </div>";
  }

  echo "<p>Meeting face to face <img src='images/icon-person.jpg' alt='Meet personally'>";

  echo "<div class='scroll'>".$txt4."</div></p>";

}



?></td>

</tr>







</table>

</td>

</tr></table>
</td>
</tr>
</table>

<script type="text/javascript">

<!--

showProductForm();

--> 

</script>

<? include 'footer.php';?>

</form>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
</body>
</html>

