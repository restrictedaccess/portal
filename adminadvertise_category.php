<?php
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
include 'config.php';
include 'conf.php';
include 'time.php';

require_once('./lib/paginator.class.php');


//SESSION CHECKER
$admin_id = $_SESSION['admin_id'];
if($admin_id=="")
{
  header("location:index.php");
}
//ENDED


//START - country filter options
if(!isset($_SESSION["country_option"]))
{
  $_SESSION["country_option"] = "philippines";
}
if(@isset($_REQUEST['country_option']))
{
  $_SESSION["country_option"] = $_REQUEST['country_option'] ;
}
  
switch($_SESSION["country_option"])
{
  case "philippines":
    $country_id = "PH";
    break;
  case "china":
    $country_id = "CN";
    break;
  case "india":
    $country_id = "IN";
    break;
  case "all":
    $country_id = "ALL";
    break;      
}

if($country_id == "ALL")
{
  $country_filter = "";
}
else
{
  
  $country_filter_w_and = "AND p.country_id='$country_id' ";
  $country_filter = "p.country_id='$country_id' ";
}
//ENDED - country filter options



$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$date_apply=$_REQUEST['date_apply'];
$month=$_REQUEST['month'];
$keysearch=$_REQUEST['keysearch'];
$status=$_REQUEST['status'];
$status_search=$_REQUEST['status'];
$audio=$_REQUEST['audio'];

putenv("TZ=Philippines/Manila");

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$pages = new Paginator;


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



          //TITLE
          $main_category_id = @$_GET["main_category_id"];
          $sub_category_id = @$_GET["sub_category_id"];
          $action = @$_GET["action"];
          $stat = @$_GET["stat"];
          
          if($main_category_id == 0 || $main_category_id == "")
          {
            $main_category_title = "All Postings";
            
            $sub_category_name_result = mysql_query("SELECT jobposition, date_created FROM posting WHERE id='$sub_category_id' LIMIT 1");
            $sub_category_name = mysql_result($sub_category_name_result,0,"jobposition");
            $sub_category_title = mysql_result($sub_category_name_result,0,"jobposition")."<i>(".mysql_result($sub_category_name_result,0,"date_created").")</i>";
          }
          else
          {
            $main_category_name_result = mysql_query("SELECT category_name FROM job_category WHERE category_id='$main_category_id' LIMIT 1");
            $main_category_title = mysql_result($main_category_name_result,0,"category_name");
            
            $sub_category_name_result = mysql_query("SELECT sub_category_name, sub_category_date_created FROM job_sub_category WHERE sub_category_id='$sub_category_id' LIMIT 1");
            $sub_category_name = mysql_result($sub_category_name_result,0,"sub_category_name");
            $sub_category_title = mysql_result($sub_category_name_result,0,"sub_category_name")."<i>(".mysql_result($sub_category_name_result,0,"sub_category_date_created").")</i>";
          }
          //ENDED




  //TOP 10 CATEGORIES
  $t10 = @$_GET["t10_category_id"];
  $t10_category_name = @$_GET["t10_category_name"];
  //ENDED


  //ADVANCE SEARCH OPTIONS
  $date_requested_applied1 = @$_REQUEST["date_requested_applied1"];
  $date_requested_applied2 = @$_REQUEST["date_requested_applied2"];
  
  //if (isset($_POST["month_a"])) $month_a = $_POST["month_a"]; elseif(isset($_GET["month_a"])) $month_a=$_GET["month_a"]; else $month_a = '';
  //if (isset($_POST["day_a"])) $day_a = $_POST["day_a"]; elseif(isset($_GET["day_a"])) $day_a=$_GET["day_a"]; else $day_a = '';
  //if (isset($_POST["year_a"])) $year_a = $_POST["year_a"]; elseif(isset($_GET["year_a"])) $year_a=$_GET["year_a"]; else $year_a = '';
  
  //if (isset($_POST["month_b"])) $month_b = $_POST["month_b"]; elseif(isset($_GET["month_b"])) $month_b=$_GET["month_b"]; else $month_b = '';
  //if (isset($_POST["day_b"])) $day_b = $_POST["day_b"]; elseif(isset($_GET["day_b"])) $day_b=$_GET["day_b"]; else $day_b = '';
  //if (isset($_POST["year_b"])) $year_b = $_POST["year_b"]; elseif(isset($_GET["year_b"])) $year_b=$_GET["year_b"]; else $year_b = '';
  
  if (isset($_POST["category"])) $category = $_POST["category"]; elseif(isset($_GET["category"])) $category=$_GET["category"]; else $category = '';
  if (isset($_POST["key"])) $key = $_POST["key"]; elseif(isset($_GET["key"])) $key=$_GET["key"]; else $key = '';
  if (isset($_POST["key_type"])) $key_type = $_POST["key_type"]; elseif(isset($_GET["key_type"])) $key_type=$_GET["key_type"]; else $key_type = '';
  if (isset($_POST["date_check"])) $date_check = $_POST["date_check"]; elseif(isset($_GET["date_check"])) $date_check=$_GET["date_check"]; else $date_check = '';
  if (isset($_POST["key_check"])) $key_check = $_POST["key_check"]; elseif(isset($_GET["key_check"])) $key_check=$_GET["key_check"]; else $key_check = '';
  if (isset($_POST["view"])) $view = $_POST["view"]; elseif(isset($_GET["view"])) $view=$_GET["view"]; else $view = '';
  if (isset($_POST["is_page"])) $is_page = $_POST["is_page"]; elseif(isset($_GET["is_page"])) $is_page=$_GET["is_page"]; else $is_page = '';
  //ENDED
  
  
  //ADVANCE REGISTERED SEARCH OPTIONS
  $date_requested1 = @$_POST["date_requested1"];
  $date_requested2 = @$_POST["date_requested2"];
  
  $registered_category = @$_POST["registered_category"];
  $registered_key = @$_POST["registered_key"];
  $registered_key_type = @$_POST["registered_key_type"];
  $registered_date_check = @$_POST["registered_date_check"];
  $registered_key_check = @$_POST["registered_key_check"];
  $registered_view = @$_POST["registered_view"];
  $registered_is_page = @$_GET["registered_is_page"];

  //if($registered_month_a== "" || $registered_month_a== NULL){
  //  $registered_month_a = @$_GET["registered_month_a"];
  //}  
  
  //if($registered_day_a== "" || $registered_day_a== NULL){
  //  $registered_day_a = @$_GET["registered_day_a"];
  //}    
  
  //if($registered_year_a== "" || $registered_year_a== NULL){
  //  $registered_year_a = @$_GET["registered_year_a"];
  //}
  
  //if($registered_month_b== "" || $registered_month_b== NULL){
  //  $registered_month_b = @$_GET["registered_month_b"];
  //}  
  
  //if($registered_day_b== "" || $registered_day_b== NULL){
  //  $registered_day_b = @$_GET["registered_day_b"];
  //}  
  
  //if($registered_year_b== "" || $registered_year_b== NULL){
  //  $registered_year_b = @$_GET["registered_year_b"];
  //}  
  
  if($registered_category== "" || $registered_category== NULL){
    $registered_category = @$_GET["registered_category"];
  }  
  
  if($registered_key == "" || $registered_key == NULL)
  {
    $registered_key = @$_GET["registered_key"];
  }
  
  if($registered_key_type == "" || $registered_key_type == NULL)
  {
    $registered_key_type = @$_GET["registered_key_type"];
  }
  
  if(@!isset($_POST["registered_advance_search"]))  
  {
    if($registered_date_check== "" || $registered_date_check== NULL)
    {
      $registered_date_check = @$_GET["registered_date_check"];
    }
    if($registered_key_check== "" || $registered_key_check== NULL)
    {
      $registered_key_check = @$_GET["registered_key_check"];              
    }
  }
  
  if($registered_view== "" || $registered_view== NULL){
    $registered_view = @$_GET["registered_view"];
  }    
  //ENDED



  
  if(isset($_POST["quick_search"]) || isset($_GET["quick_search"]))
  {
    $search_type = "quick";
  }
  elseif(isset($_POST["advance_search"]) || isset($_GET["advance_search"]))
  {
    $search_type = "advance";
  }
  elseif(isset($_POST["registered_quick_search"]) || isset($_GET["registered_quick_search"]))
  {
    $search_type = "registered_quick";
  }
  elseif(isset($_POST["registered_advance_search"]) || isset($_GET["registered_advance_search"]))
  {
    $search_type = "registered_advance";
  }  
  else
  {
    $search_type = "";
  }


  
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
          $a_ = date("Y-m-d");
          $b_ = date("Y-m-d",$b_1);
          $title = "Today (".date("M d, Y").")";
          break;
        case "yesterday" :
          $a_1 = time() - (1 * 24 * 60 * 60);
          $b_1 = time() - (1 * 24 * 60 * 60);
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Yesterday (".date("M d, Y",$a_1).")";
          break;
        case "curmonth" :
          $a_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
          $b_1 = mktime(0, 0, 0, date("n"), 31, date("Y"));
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Current Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "curweek" :
          $wd_arr = array('Mo ', 'Tu ', 'We ', 'Th ', 'Fr ', 'Sa ', 'Su ');
          $a_1 = mktime(0, 0, 0,(int)date('m'),(int)date('d')+(1-(int)date('w')),(int)date('Y'));
          $b_1 = time();
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Current Week (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "lmonth" :
          $a_1 = mktime(0, 0, 0, date("n"), -31, date("Y"));
          $b_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Last Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "last7" :
          $a_1 = time() - (14 * 24 * 60 * 60);
          $b_1 = time() - (7 * 24 * 60 * 60);
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Last 7 Days (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "alltime" :
          $a_1 = mktime(0, 0, 0, 1, 11, 2000);
          $b_1 = time();
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "All time (".date("M d, Y").")";      
          break;
        default :
          $a_ = date("Y-m-d"); 
          $b_ = date("Y-m-d",time() + (1 * 24 * 60 * 60));
          $title = "Today (".date("M d, Y").")";  
      }
      //ENDED
  //QUICK REGISTERED SEARCH
  $registered_rt = @$_POST['registered_rt'];
  $registered_category_a = @$_POST['registered_category_a'];
  $registered_view_a = @$_POST['registered_view_a'];

  if($registered_category_a== "" || $registered_category_a== NULL){
    $registered_category_a = @$_GET['registered_category_a'];
  }
  if($registered_view_a== "" || $registered_view_a== NULL){
    $registered_view_a = @$_GET['registered_view_a'];
  }
  if($registered_rt == "" || $registered_rt == NULL){
    $registered_rt = @$_GET["registered_rt"];
  }

      $gte_date = 0;
      $lt_date = 0;
      switch ($registered_rt) 
      {
        case "today" :
          //$a_1 = time();
          //$b_1 = time() + (1 * 24 * 60 * 60);
          //$registered_a_ = date("Y-m-d"); 
          //$registered_b_ = date("Y-m-d",$b_1);
          $title = "Today (".date("M d, Y").")";
          
          $gte_date = date("Y-m-d");
          
          break;
        case "yesterday" :
          //$a_1 = time() - (1 * 24 * 60 * 60);
          //$b_1 = time() - (1 * 24 * 60 * 60);
          //$registered_a_ = date("Y-m-d",$a_1);
          //$registered_b_ = date("Y-m-d",$b_1);
          $title = "Yesterday (".date("M d, Y",$a_1).")";
          
          $gte_date = strtotime("-1 day",date(time()));
          $gte_date = date("Y-m-d", $gte_date);
          $lt_date = date("Y-m-d");
          
          break;
        case "curmonth" :
          //$a_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
          //$b_1 = mktime(0, 0, 0, date("n"), 31, date("Y"));
          //$registered_a_ = date("Y-m-d",$a_1);
          //$registered_b_ = date("Y-m-d",$b_1);
          $title = "Current Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          
          $gte_date = date("Y-m");
          break;
        case "curweek" :
          //$wd_arr = array('Mo ', 'Tu ', 'We ', 'Th ', 'Fr ', 'Sa ', 'Su ');
          //$a_1 = mktime(0, 0, 0,(int)date('m'),(int)date('d')+(1-(int)date('w')),(int)date('Y'));
          //$b_1 = time();
          //$registered_a_ = date("Y-m-d",$a_1);
          //$registered_b_ = date("Y-m-d",$b_1);
          $title = "Current Week (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          
          $dow = date("w");
          
          $gte_date = strtotime("-$dow days",date(time()));
          $gte_date = date("Y-m-d", $gte_date);
          break;
        case "lmonth" :
          //$a_1 = mktime(0, 0, 0, date("n"), -31, date("Y"));
          //$b_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
          //$registered_a_ = date("Y-m-d",$a_1);
          //$registered_b_ = date("Y-m-d",$b_1);
          $title = "Last Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          
          
          $moy = date("n");
          
          $gte_date = date("Y-0".($moy-1));
          $lt_date = strtotime(date("Y-m"));
          $lt_date = date("Y-m-d", $lt_date);
          break;
        case "last7" :
          //$a_1 = time() - (14 * 24 * 60 * 60);
          //$b_1 = time() - (7 * 24 * 60 * 60);
          //$registered_a_ = date("Y-m-d",$a_1);
          //$registered_b_ = date("Y-m-d",$b_1);
          $title = "Last 7 Days (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          
          $gte_date = strtotime("-7 days",date(time()));
          $gte_date = date("Y-m-d", $gte_date);
          break;
        case "alltime" :
          //$a_1 = mktime(0, 0, 0, 1, 11, 2000);
          //$b_1 = time();
          //$registered_a_ = date("Y-m-d",$a_1);
          //$registered_b_ = date("Y-m-d",$b_1);
          $title = "All time (".date("M d, Y").")";      
          break;
        default :
          //$registered_a_ = date("Y-m-d"); 
          //$registered_b_ = date("Y-m-d",time() + (1 * 24 * 60 * 60));
          $title = "Today (".date("M d, Y").")";
          
          $gte_date = strtotime(date("Y-m-d"));
      }
      //ENDED
//echo '<br>'.$registered_a_;
//echo '<br>'.$registered_b_;
  
  $sub_category_title = "Searched Result";  
  $lim = $offset.", ".$rowsPerPage;
            
  if($is_page == 'yes' || $is_page == 'Yes')
  {
    $query = $_SESSION['last_query'];
    $query2 = $_SESSION['last_query2'];    
  }
  elseif($search_type == "quick")
  {

            switch($view_a)
            {
              case "Shorlisted":
                $join = ", tb_shortlist_history j";
                break;
              case "Endorsed":
                $join = ", tb_endorsement_history j";
                break;
              case "Sub Contracted":
                $join = ", subcontractors j";
                break;
              case "Selected":
                $join = ", tb_selected_history j";
                break;
            }
            if($category_a == "Any")
            {
              $query = "SELECT DISTINCT(a.userid)
              FROM personal a $join
              WHERE a.userid=j.userid $country_filter_w_and
              ORDER BY a.fname DESC ";
              
              $query2 = "SELECT COUNT(a.userid) AS numrows
              FROM personal a $join
              WHERE a.userid=j.userid";
            }
            else
            {
              $query = "SELECT DISTINCT(a.userid)
              FROM personal a $join
              WHERE a.userid=j.userid AND j.position='$category_a' $country_filter_w_and
              ORDER BY a.fname DESC ";
              
              $query2 = "SELECT COUNT(a.userid) AS numrows
              FROM personal a $join
              WHERE a.userid=j.userid AND j.position='$category_a'";
            }  
  }
  elseif($search_type == "registered_quick")
  {
          $where = '';
          if ($gte_date) $where = " WHERE p.datecreated >= '$gte_date'";
          if ($lt_date) $where .= " AND p.datecreated < '$lt_date'";
          
          if($where == "")
          {
            $where .= " WHERE $country_filter";
          }
          else
          {
            $where .= " $country_filter_w_and";
          }
          
          if($registered_view_a != "Any" || $registered_view_a != "")
          {
            
            switch($registered_view_a)
            {
              case "Shorlisted":
                $join = "JOIN tb_shortlist_history s ON s.userid = p.userid";
                break;              
              case "Endorsed":
                $join = "JOIN tb_endorsement_history e ON e.userid = p.userid";
                break;              
              case "Sub Contracted":
                $join = "JOIN subcontractors s ON s.userid = p.userid";
                break;              
              case "Selected":
                $join = "JOIN tb_selected_history s ON s.userid = p.userid";
                break;
            }
            $query = "SELECT DISTINCT(p.userid)
            FROM personal p
            $join
            $where
            ORDER BY p.datecreated DESC ";  
            
            $query2 = "SELECT count(numrows) as count from ( SELECT COUNT(p.userid) AS numrows
            FROM personal p 
            $join
            $where GROUP by p.userid) cnt";    
          }
          else
          {
            //$where = "WHERE (DATE(p.datecreated) BETWEEN '$registered_a_' AND '$registered_b_')";
            $query = "SELECT DISTINCT(p.userid)
            FROM personal p
            $where
            ORDER BY p.datecreated DESC ";  
            
            $query2 = "SELECT COUNT(p.userid) AS numrows
            FROM personal p
            $where";
            //ORDER BY p.datecreated DESC ";    
          }  
  }
  elseif($search_type == "registered_advance")
  {
    
            $registered_date_a = $date_requested1; //$registered_year_a."-".$registered_month_a."-".$registered_day_a;
            $registered_date_b = $date_requested2; //$registered_year_b."-".$registered_month_b."-".$registered_day_b;

            $condition = "";
            if($registered_date_check == "" || $registered_date_check == NULL)
            {
              $condition .= " WHERE (DATE(p.datecreated) BETWEEN '$registered_date_a' AND '$registered_date_b')";    
            }
            if($condition == "")
            {
              if($country_filter <> "")
              {
                if(($registered_key_check == "" || $registered_key_check == NULL) && trim($registered_key) != "")
                {
                  $condition .=" WHERE $country_filter AND ";
                }
                else
                {
                  $condition .=" WHERE $country_filter ";
                }                
              }
              else
              {
                $condition .=" WHERE ";
              }              
            }
            else
            {
              if($country_filter <> "")
              {
                if(($registered_key_check == "" || $registered_key_check == NULL) && trim($registered_key) != "")
                {
                  $condition .=" AND $country_filter AND ";
                }
                else
                {
                  $condition .=" AND $country_filter ";
                }
              }
              else
              {
                if(($registered_key_check == "" || $registered_key_check == NULL) && trim($registered_key) != "")
                {
                  $condition .=" AND ";
                }
                else
                {
                  $condition .=" ";
                }                
                
              }
            }
            
            if(($registered_key_check == "" || $registered_key_check == NULL) && trim($registered_key) != "")
            {
                  
                  $key_multi = array();
                  if (preg_match("/\,/i", $registered_key))
                    $key_multi = explode(',', $registered_key);
                  
                  
                  switch($registered_key_type)
                  {
                    case "id":
                      if (count($key_multi)>0) {
                        $key_cond = implode("' OR p.userid='", $key_multi);
                        $key_cond = "p.userid='" . $key_cond;
                        $key_cond .= "'";
                      } else $key_cond = "p.userid='$registered_key'";
                      
                      
                      $query = "SELECT DISTINCT(p.userid)  FROM personal p ".
                      $condition ." ( $key_cond ) ORDER BY p.datecreated DESC ";
            
                      $query2 = "SELECT DISTINCT(COUNT(p.userid)) AS numrows
                      FROM personal p
                      $condition ( $key_cond )";
                      //ORDER BY p.datecreated DESC ";
                      break;
                    case "fname":
                      if (count($key_multi)>0) {
                        $key_cond = implode("%' OR p.fname LIKE '%", $key_multi);
                        $key_cond = "p.fname LIKE '%" . $key_cond;
                        $key_cond .= "%'";
                      } else $key_cond = "p.fname LIKE '%$registered_key%'";
                      
                      $query = "SELECT DISTINCT(p.userid)
                      FROM personal p
                      $condition ( $key_cond )
                      ORDER BY p.datecreated DESC ";
            
                      $query2 = "SELECT DISTINCT(COUNT(p.userid)) AS numrows
                      FROM personal p
                      $condition ($key_cond )";
                      //ORDER BY p.datecreated DESC ";
                      break;
                    case "lname":
                      if (count($key_multi)>0) {
                        $key_cond = implode("%' OR p.lname LIKE '%", $key_multi);
                        $key_cond = "p.lname LIKE '%" . $key_cond;
                        $key_cond .= "%'";
                      } else $key_cond = "p.lname LIKE '%$registered_key%'";
                      
                      $query = "SELECT DISTINCT(p.userid)
                      FROM personal p
                      $condition ($key_cond)
                      ORDER BY p.datecreated DESC ";
            
                      $query2 = "SELECT DISTINCT(COUNT(p.userid)) AS numrows
                      FROM personal p
                      $condition ($key_cond)";
                      //ORDER BY p.datecreated DESC ";
                      break;
                    case "email":
                      if (count($key_multi)>0) {
                        $key_cond = implode("%' OR p.email LIKE '%", $key_multi);
                        $key_cond = "p.email LIKE '%" . $key_cond;
                        $key_cond .= "%'";
                      } else $key_cond = "p.email LIKE '%$registered_key%'";
                      
                      $query = "SELECT DISTINCT(p.userid)
                      FROM personal p
                      $condition ($key_cond)
                      ORDER BY p.datecreated DESC ";
            
                      $query2 = "SELECT COUNT(p.userid) AS numrows
                      FROM personal p
                      $condition ($key_cond)";
                      //ORDER BY p.datecreated DESC ";
                      break;
                    case "skills":
                      if (count($key_multi)>0) {
                        $key_cond = implode("%' OR s.skill LIKE '%", $key_multi);
                        $key_cond = "s.skill LIKE '%" . $key_cond;
                        $key_cond .= "%'";
                      } else $key_cond = "s.skill LIKE '%$registered_key%'";
                      
                      $query = "SELECT DISTINCT(p.userid)
                      FROM personal p INNER JOIN skills s  ON p.userid=s.userid 
                      $condition ($key_cond)
                      ORDER BY p.datecreated DESC ";
            
                      $query2 = "SELECT COUNT(p.userid) AS numrows
                      FROM personal p INNER JOIN skills s  ON p.userid=s.userid
                      $condition ($key_cond)";
                      //ORDER BY p.datecreated DESC ";
                      break;                    
                    case "resume_body":
                      if (count($key_multi)>0) {
                        $key_cond = implode("%' OR c.latest_job_title LIKE '%", $key_multi);
                        $key_cond = "c.latest_job_title LIKE '%" . $key_cond;
                        $key_cond .= "%'";
                      } else $key_cond = "c.latest_job_title LIKE '%$registered_key%'";
                      
                      $query = "SELECT DISTINCT(p.userid)
                      FROM personal p,
                      INNER JOIN currentjob c ON p.userid=c.userid
                      $condition (($key_cond) OR (c.duties5 LIKE '%$registered_key%') OR (c.position5 LIKE '%$registered_key%') OR (c.companyname5 LIKE '%$registered_key%') OR (c.duties4 LIKE '%$registered_key%') OR (c.position4 LIKE '%$registered_key%') OR (c.companyname4 LIKE '%$registered_key%') OR (c.duties3 LIKE '%$registered_key%') OR (c.position3 LIKE '%$registered_key%') OR (c.companyname3 LIKE '%$registered_key%') OR (c.duties2 LIKE '%$registered_key%') OR (c.position2 LIKE '%$registered_key%') OR (currentjob.companyname2 LIKE '%$registered_key%') OR (c.duties LIKE '%$registered_key%') OR (c.position LIKE '%$registered_key%') OR (c.companyname LIKE '%$registered_key%') OR (c.freshgrad LIKE '%$registered_key%'))
                      ORDER BY p.datecreated DESC ";
            
                      $query2 = "SELECT COUNT(p.userid) AS numrows
                      FROM personal p INNER JOIN currentjob c ON p.userid=c.userid
                      $condition (($key_cond) OR (c.duties5 LIKE '%$registered_key%') OR (c.position5 LIKE '%$registered_key%') OR (c.companyname5 LIKE '%$registered_key%') OR (c.duties4 LIKE '%$registered_key%') OR (c.position4 LIKE '%$registered_key%') OR (c.companyname4 LIKE '%$registered_key%') OR (c.duties3 LIKE '%$registered_key%') OR (c.position3 LIKE '%$registered_key%') OR (c.companyname3 LIKE '%$registered_key%') OR (c.duties2 LIKE '%$registered_key%') OR (c.position2 LIKE '%$registered_key%') OR (currentjob.companyname2 LIKE '%$registered_key%') OR (c.duties LIKE '%$registered_key%') OR (c.position LIKE '%$registered_key%') OR (c.companyname LIKE '%$registered_key%') OR (c.freshgrad LIKE '%$registered_key%'))";
                      //ORDER BY p.datecreated DESC ";
                      break;                      
                    case "notes":
                      $query = "SELECT DISTINCT(p.userid)
                      FROM personal p INNER JOIN applicant_history a ON p.userid=a.userid
                      $condition (a.history LIKE '%$registered_key%' OR a.subject LIKE '%$registered_key%')
                      ORDER BY p.datecreated DESC ";
            
                      $query2 = "SELECT COUNT(p.userid) AS numrows
                      FROM personal p INNER JOIN applicant_history a ON p.userid=a.userid
                      $condition (a.history LIKE '%$registered_key%' OR a.subject LIKE '%$registered_key%')";
                      //ORDER BY p.datecreated DESC ";
                      break;
                    case "mobile":
                      if (count($key_multi)>0) {
                        $key_cond = implode("%' OR p.handphone_no LIKE '%", $key_multi);
                        $key_cond = "p.handphone_no LIKE '%" . $key_cond;
                        $key_cond .= "%'";
                      } else $key_cond = "p.handphone_no LIKE '%$registered_key%'";
                      $query = "SELECT DISTINCT(p.userid)
                      FROM personal p
                      $condition ($key_cond)
                      ORDER BY p.datecreated DESC ";
            
                      $query2 = "SELECT DISTINCT(COUNT(p.userid)) AS numrows
                      FROM personal p
                      $condition ($key_cond)";
                      break;
                  }
                
            }
            
            else
            {
              $sub_category_title = "All Registered Applicants";
                $query = "SELECT DISTINCT(p.userid)
                FROM personal p
                $condition
                ORDER BY p.datecreated DESC ";
                        
                $query2 = "SELECT COUNT(p.userid) AS numrows
                  FROM personal p
                  $condition";
                  //ORDER BY p.datecreated DESC ";
            }
  }   
  else
  {

      //SELECTED TOP 10 CATEGORIES ONLY
      if(@isset($_GET["t10_category_id"]))
      {
        $t10 = $_GET["t10_category_id"];
        $sub_category_title = @$_GET["t10_category_name"]."'s Applicants";
        $query = "SELECT DISTINCT(userid)
        FROM job_sub_category_applicants
        WHERE sub_category_id = $t10 ";
              
        $query2 = "SELECT COUNT(userid) AS numrows
        FROM job_sub_category_applicants
        WHERE sub_category_id = $t10";
      }
      //ENDED
      
      
      else
      {
          //SELECT POSITIONS AND TOP 10 CATEGORIES
          if($stat != "" || $stat != NULL)
          {
            
            $where = "WHERE a.posting_id=p.posting.id";
            switch($stat)
            {
              case "Shortlisted":
                $join = "JOIN tb_shortlist_history s ON s.userid = a.userid";
                break;              
              case "Endorsed":
                $join = "JOIN tb_endorsement_history e ON e.userid = a.userid";
                break;              
              case "Sub Contracted":
                $join = "JOIN subcontractors s ON s.userid = a.userid";
                break;              
              case "Selected":
                $join = "JOIN tb_selected_history s ON s.userid = a.userid";
                break;
              default:
                $where = "WHERE a.posting_id=p.posting.id AND a.status='$stat'";
                break;  
            }
            if($sub_category_name == "")
            {
              $sub_category_title = $stat." Applicants";
              $query = "SELECT DISTINCT(a.userid)
              FROM personal a $join
              ORDER BY a.datecreated DESC ";
              
              $query2 = "SELECT COUNT(a.userid) AS numrows
              FROM personal a $join";
              //ORDER BY a.datecreated DESC ";
            }
            else
            {
              $sub_category_title = $stat." Applicants: ".$sub_category_title;
              $query = "SELECT DISTINCT(a.userid)
              FROM applicants a, posting p $where AND p.jobposition = '$sub_category_name'
              ORDER BY a.datecreated DESC ";
              
              $query2 = "SELECT COUNT(a.userid) AS numrows
              FROM applicants a, posting p $where AND p.jobposition = '$sub_category_name'";
            }  
          }
          else
          {
            if($sub_category_name=="")
            {
              //$sub_category_title = "All Registered Applicants";
              //$query = "SELECT DISTINCT(p.userid)
              //FROM personal p
              //ORDER BY p.datecreated DESC ";
              
              //$query2 = "SELECT DISTINCT(COUNT(p.userid)) AS numrows
              //FROM personal p
              //ORDER BY p.datecreated DESC ";              
            }
            else
            {
              $query = "SELECT DISTINCT(a.userid)
              FROM applicants a, posting 
              WHERE a.posting_id=posting.id AND posting.jobposition = '$sub_category_name'
              ORDER BY a.date_apply ";
              
              $query2 = "SELECT COUNT(a.userid) AS numrows
              FROM applicants a, posting 
              WHERE a.posting_id=posting.id AND posting.jobposition = '$sub_category_name'";
            }  
          }
          //END
      }    
        
  }
  $_SESSION['last_query'] = $query;
  $_SESSION['last_query2'] = $query2;  
  $posted_data = "t10_category_id=".$t10."&t10_category_name=".$t10_category_name."&main_category_id=".$main_category_id."&sub_category_id=".$sub_category_id."&stat=".$stat."&action=".$action."&category_a=".$category_a."&view_a=".$view_a."&rt=".$rt."&category=".$category."&month_a=".$month_a."&day_a=".$day_a."&year_a=".$year_a."&month_b=".$month_b."&day_b=".$day_b."&year_b=".$year_b."&type=".$type."&key=".$key."&view=".$view."&date_check=".$date_check."&key_check=".$key_check."&registered_category_a=".$registered_category_a."&registered_view_a=".$registered_view_a."&registered_rt=".$registered_rt."&registered_category=".$registered_category."&registered_month_a=".$registered_month_a."&registered_day_a=".$registered_day_a."&registered_year_a=".$registered_year_a."&registered_month_b=".$registered_month_b."&registered_day_b=".$registered_day_b."&registered_year_b=".$registered_year_b."&registered_type=".$registered_type."&registered_key=".$registered_key."&registered_view=".$registered_view."&registered_date_check=".$registered_date_check."&registered_key_check=".$registered_key_check;
  $_SESSION['lim'] = $lim;
  //$query = $query." ".$lim;
  //$query2 = $query2." ".$lim;
  //$query2 = $query2." 0,100";
//END

//$result=mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());
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

<script type="text/javascript" src="js/tooltip.js"></script>
<script type='text/javascript' language='JavaScript' src='audio_player/audio-player.js'></script>

<!--calendar picker - setup-->
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->


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


function l(action,main_category_id,sub_category_id)
{
  window.location="?stat=<?php echo @$stat; ?>&action="+action+"&main_category_id="+main_category_id+"&sub_category_id="+sub_category_id+"&category_a=<?php echo @$category_a; ?>&view_a=<?php echo @$view_a; ?>&rt=<?php echo @$rt; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>";
}


    function move(id, status) 
    {
      switch(status)
      {
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
        case "Category":
          previewPath = "adminadvertise_add_to_category.php?userid="+id;
          break;          
        case "popup":
          previewPath = "application_apply_action.php?userid="+id+"&page_type=popup";
          break;            
      }  
      window.open(previewPath,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
    }

</script>  
  
  
  
  
  
  
  
  
  
<script type="text/javascript">

function any_date(check)
{
  document.getElementById('id_date_requested_applied1').disabled = (check.checked);
  document.getElementById('id_date_requested_applied2').disabled = (check.checked);
}      
    
function registered_any_date(check)
{
  document.getElementById('id_date_requested1').disabled = (check.checked);
  document.getElementById('id_date_requested2').disabled = (check.checked);
  //document.getElementById('registered_month_a_id').disabled = (check.checked);
  //document.getElementById('registered_day_a_id').disabled = (check.checked);
  //document.getElementById('registered_year_a_id').disabled = (check.checked);
  //document.getElementById('registered_month_b_id').disabled = (check.checked);
  //document.getElementById('registered_day_b_id').disabled = (check.checked);
  //document.getElementById('registered_year_b_id').disabled = (check.checked);
}  

function any_key(check)
{
  document.getElementById('key_id').disabled = (check.checked);
  document.getElementById('key_type_id').disabled = (check.checked);
}      

function registered_any_key(check)
{
  document.getElementById('registered_key_id').disabled = (check.checked);
  document.getElementById('registered_key_type_id').disabled = (check.checked);
}      

function validate(form) 
{
  if(!form.date_check.checked)
  {
    if (form.date_requested_applied1.value == '' || form.date_requested_applied1.value == 'Any') { alert("You forgot to select the date."); form.date_requested_applied1.focus(); return false; }  
    if (form.date_requested_applied2.value == '' || form.date_requested_applied2.value == 'Any') { alert("You forgot to select the date."); form.date_requested_applied2.focus(); return false; }  
  }
  if(!form.key_check.checked)
  {
    if (form.key.value == '') { alert("You forgot to enter the 'keyword'."); form.month_a.focus(); return false; }  
  }
}

function registered_validate(form) 
{
  if(!form.registered_date_check.checked)
  {
    if (form.date_requested1.value == '' || form.date_requested1.value == 'Any') { alert("You forgot to select the date."); form.date_requested1.focus(); return false; }  
    if (form.date_requested2.value == '' || form.date_requested2.value == 'Any') { alert("You forgot to select the date."); form.date_requested2.focus(); return false; }  
  }
  if(!form.registered_key_check.checked)
  {
    if (form.registered_key.value == '') { alert("You forgot to enter the 'keyword'."); form.registered_month_a.focus(); return false; }  
  }
}


</script>    
  
  
  
  
  


<!--menu-->
<script language="javascript">
var curSubMenu='';
function showSubMenu(menuId)
{
  if (curSubMenu!='') hideSubMenu();
    eval('document.all.'+menuId).style.visibility='visible';
  curSubMenu=menuId;
}

function hideSubMenu()
{
  eval('document.all.'+curSubMenu).style.visibility='hidden';
  curSubMenu='';
}
</script>
<!--ended-->


  
<!-- added by mike 2010-02-10 -->
<script language=''>
<!--
function show_hide_search(id, label) {
  var search_box = document.getElementById(id);
  var label_str = document.getElementById(label);
  if (search_box.style.display == 'none') {
    search_box.style.display = '';
    label_str.innerHTML = '[Hide]';
  } else {
    search_box.style.display = 'none';
    label_str.innerHTML = '[Show]';
  }
}
-->
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
<script language=javascript src="js/functions.js"></script>



<!-- HEADER -->

<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>
<?php include 'admin-sub-tab.php';?>
<table width="106%">

<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">



<?php include 'applicationsleftnav.php';?>

</td>

<td valign="top"  style="width:100%;">


  <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
  <span><strong>Sub Categories / Advance Search</strong></span> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;
  <span style='width:150px;color:#ff0000;text-align:right;cursor:pointer;' id='label_str' onClick="show_hide_search('search_box','label_str');">[Show]</span>
  </div>
    <br/>
  <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
        <button onClick="window.open('tools/AvailableStaffChecker/AvailableStaffChecker.html', '_blank');">Available Staff Checker</button>
  </div>




<!--ASL ALARM-->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!--ENDED-->




<table width="100%" style='display:none;' id='search_box'>
  <tr>
  <td valign="top">
    <table width="100%" style="border:#CCCCCC solid 1px"; cellpadding="1" cellspacing="1">
      <tr>
        <td width="30%">
          <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
            <b>
              <strong><?php echo $main_category_title; ?></strong>
            </b>
          </div>        
        </td>
        <td width="70%">

  <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
    <b>
      <strong>Search Options</strong>
    </b>
  </div>        
        </td>
      </tr>
      <tr>
        <td width="40%" valign="top" align="left">
          <select name="menu1" size="36" style='width:100%;' onChange="javascript: l('<?php echo @$action; ?>','<?php echo $main_category_id; ?>',this.value);">

          <?php 
            if($main_category_id == 0)
            {
              $main_category_name_result = mysql_query("SELECT id, lead_id, date_created, jobposition FROM posting WHERE status='ACTIVE'");  
              $counter = 0;          
              while ($row = @mysql_fetch_assoc($main_category_name_result)) 
              {
                $l_id = $row['lead_id'];
                $l = mysql_query("SELECT fname, lname FROM leads WHERE id='$l_id' LIMIT 1") ;
                $client_name = @mysql_result($l,0,"fname") . " " . @mysql_result($l,0,"lname") ;                
                if($counter == 0)
                {
                  echo "<optgroup label='Active Postings'></optgroup>";
                }
                if($sub_category_id == $row['id'])
                {
                  echo "<option value=".$row['id']." selected>".$row['jobposition']." (".$client_name.")</option>\n";
                  $sub_category_title = $row['jobposition'];
                }
                else
                {
                  echo "<option value=".$row['id'].">".$row['jobposition']." (".$client_name.")</option>\n";
                } 
                $counter++;
              }
            }
            else
            {
              $main_category_name_result = mysql_query("SELECT * FROM job_sub_category WHERE category_id='$main_category_id'");
              while ($row = @mysql_fetch_assoc($main_category_name_result)) 
              {
              
                if($sub_category_id == $row['sub_category_id'])
                {
                  echo "<option value=".$row['sub_category_id']." selected>".$row['sub_category_name']." (".$row['sub_category_date_created'].")</option>\n";
                  $sub_category_title = $row['sub_category_name'];
                }
                else
                {
                  echo "<option value=".$row['sub_category_id'].">".$row['sub_category_name']." (".$row['sub_category_date_created'].")</option>\n";
                }              
              }
            }
          ?>
                  </select>                
        </td>
        <td width="60%" valign="top">










                      <table width="100%" style="border:#CCCCCC solid 1px; " cellpadding="3" cellspacing="3">
                        <tr>
                          <td colspan="2">
                                                      <div class="subtab">
                                                        <ul>
                                                        <li id="p" <?php if($_SESSION["country_option"] == "philippines") { echo "class='selected'"; } ?>><a href="?country_option=philippines"><span>Philippines</span></a></li>
                                                        <li id="c" <?php if($_SESSION["country_option"] == "china") { echo "class='selected'"; } ?>><a href="?country_option=china"><span>China</span></a></li>
                                                        <li id="i" <?php if($_SESSION["country_option"] == "india") { echo "class='selected'"; } ?>><a href="?country_option=india"><span>India</span></a></li>
                                                         <li id="a" <?php if($_SESSION["country_option"] == "all") { echo "class='selected'"; } ?>><a href="?country_option=all"><span>All</span></a></li>
                                                        </ul>
                                                        <br /><br /><br />
                            <strong>Quick Search by Positions</strong>
                                                        </div>
                          </td>
                        </tr>    
                        <tr>
                          <td colspan="2">

                          <form action="?<?php echo $posted_data; ?>" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">  
                          <input type="hidden" name="rt" value="">
                                                    <input type="hidden" name="country_option" id="country_option1" value="<?php echo $_SESSION["country_option"]; ?>">
                                                    
                            <table width="0%"  border="0" cellspacing="3" cellpadding="3">
                            <!--  
                              <tr>
                              <td><font size="1">Date Applied</font></td><td width="100%"><font size="1">Status</font></td>
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
                              -->
                                <td align="left">
                                        <select name="view_a" id="view_id_a" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                          <?php
                                            switch($view_a)
                                            {
                                              case "Endorsed":  
                                                echo '<option value="Endorsed" selected>Endorsed</option>';
                                                echo '
                                                <option value="Shorlisted">Shorlisted</option>  
                                                <option value="Sub Contracted">Sub Contracted </option>
                                                <option value="Selected">Selected</option>
                                                ';
                                                break;
                                              case "Sub Contracted":  
                                                echo '<option value="Sub Contracted" selected>Sub Contracted </option>';
                                                echo '
                                                <option value="Shorlisted">Shorlisted</option>  
                                                <option value="Selected">Selected</option>
                                                <option value="Endorsed">Endorsed</option>
                                                ';
                                                break;  
                                              case "Selected":  
                                                echo '<option value="Selected" selected>Selected</option>';
                                                echo '
                                                <option value="Shorlisted">Shorlisted</option>  
                                                <option value="Sub Contracted">Sub Contracted </option>
                                                <option value="Endorsed">Endorsed</option>
                                                ';
                                                break;                                                  
                                              case "Shorlisted":  
                                                echo '<option value="Shorlisted" selected>Shorlisted</option>';
                                                echo '
                                                <option value="Sub Contracted">Sub Contracted </option>
                                                <option value="Selected">Selected</option>
                                                <option value="Endorsed">Endorsed</option>
                                                ';
                                              default:
                                                echo '
                                                <option value="Shorlisted">Shorlisted</option>
                                                <option value="Sub Contracted">Sub Contracted </option>
                                                <option value="Selected">Selected</option>
                                                <option value="Endorsed">Endorsed</option>
                                                ';
                                                break;                                                      
                                            }
                                          ?>
                                        </select>              
                                  </td>
                              </tr>
                                    
                              <tr>
                                <td colspan="2"><font size="1">Positions Advertised</font></td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                    <select name="category_a" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                    <?php 
                                        $main_category_name_result = mysql_query("SELECT id, lead_id, date_created, jobposition FROM posting WHERE status='ACTIVE'");            
                                        while ($row = @mysql_fetch_assoc($main_category_name_result)) 
                                        {
                                          $l_id = $row['lead_id'];
                                          $l = mysql_query("SELECT fname, lname FROM leads WHERE id='$l_id' LIMIT 1") ;
                                          $client_name = @mysql_result($l,0,"fname") . " " . @mysql_result($l,0,"lname") ;                                                  
                                          if($category_a==$row['id'])
                                          {
                                            echo "<option value='".$row['id']."' selected>".$row['jobposition']." (".$client_name.")</option>\n";
                                            $c = 1;
                                          }    
                                          else
                                          {                                
                                            echo "<option value='".$row['id']."'>".$row['jobposition']." (".$client_name.")</option>\n";
                                          }
                                        }                
                                        if($c==1)
                                        {
                                          echo "<option value='Any'>Any</option>";
                                        }
                                        else
                                        {
                                          echo "<option value='Any' selected>Any</option>";
                                        }                    
                                    ?>                          
                                    </select>                                
                              </td>                              
                              </tr>
                              <tr>

                                  <td colspan="2">
                                        <input type="submit" value="View Result" name="quick_search" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>              
                                  </td>
                                </table>
                              </form>    
                                
                              

        
        
                            <!--
                            <form action="?<?php echo $posted_data; ?>" method="post" name="formtable" onSubmit="return validate(this); ">
                              <input type="hidden" name="country_option" id="country_option2" value="<?php echo $_SESSION["country_option"]; ?>">
                                                        <table width="0" border="0" cellpadding="0">
                            <tr>
                              <td colspan="3">
                                <strong>Search for Registered Applicant Who Applied</strong><br /><br />
                              </td>
                            </tr>                            
                                                          <tr>
                                                            <td colspan=3>Date&nbsp;Applied&nbsp;Between&nbsp;</td>
                              </tr>
                              <tr>  
                                                            <td colspan="5">
                                                            
                                                            
                                                            
                                                            
                                <table width="0"  border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                  <td>
                                                                        <table>
                                                                            <tr>
                                                                                <td><img align="absmiddle" src="../images/date-picker.gif" id="date_requested_applied1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                <td>
                                                                                <input type="text" name="date_requested_applied1" id="id_date_requested_applied1" class="text" <?php if($date_check == "on") echo "disabled"; ?> value="<?php echo $date_requested_applied1; ?>">
                                                                                <script type="text/javascript">
                                                                                    Calendar.setup({
                                                                                            inputField  : "id_date_requested_applied1",
                                                                                            ifFormat  : "%Y-%m-%d",
                                                                                            button    : "date_requested_applied1_button",
                                                                                            align    : "T_appliedl",
                                                                                            showsTime  : false, 
                                                                                            singleClick  : true
                                                                                    });
                                                                                </script>                                         
                                                                                </td>
                                                                            </tr>
                                                                        </table> 
                                                                     </td>
                                                                     <td>
                                                                        <table>
                                                                            <tr>
                                                                                <td><img align="absmiddle" src="../images/date-picker.gif" id="date_requested_applied2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                <td>
                                                                                <input type="text" name="date_requested_applied2" id="id_date_requested_applied2" class="text" <?php if($date_check == "on") echo "disabled"; ?> value="<?php echo $date_requested_applied2; ?>">
                                                                                <script type="text/javascript">
                                                                                    Calendar.setup({
                                                                                            inputField  : "id_date_requested_applied2",
                                                                                            ifFormat  : "%Y-%m-%d",
                                                                                            button    : "date_requested_applied2_button",
                                                                                            align    : "T_applied2",
                                                                                            showsTime  : false, 
                                                                                            singleClick  : true
                                                                                    });
                                                                                </script>                                         
                                                                                </td>
                                                                            </tr>
                                                                        </table> 
                                                                    </td>                                                                                                                                             
                                  <td>&nbsp;Any</td>                                  
                                  <td><input type="checkbox" id="date_check_id" name="date_check" onClick="javascript: any_date(this); " <?php if($date_check == "on") echo "checked"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                  </tr>
                                </table>                                                                                            
                              
                              
                              
                              
                              </td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan=3>Positions Advertised&nbsp;&nbsp;</td>
                              </tr>
                              <tr>  
                                                            <td colspan=4>
                              
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
                                        <select name="category" id="category_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                          <?php 
                                              $main_category_name_result = mysql_query("SELECT id, lead_id, date_created, jobposition FROM posting WHERE status='ACTIVE'");            
                                              while ($row = @mysql_fetch_assoc($main_category_name_result)) 
                                              {
                                                $l_id = $row['lead_id'];
                                                $l = mysql_query("SELECT fname, lname FROM leads WHERE id='$l_id' LIMIT 1") ;
                                                $client_name = @mysql_result($l,0,"fname") . " " . @mysql_result($l,0,"lname") ;                                                  
                                                if($category==$row['jobposition'])
                                                {
                                                  echo "<option value='".$row['jobposition']."' selected>".$row['jobposition']." (".$client_name.")</option>\n";
                                                  $c = 1;
                                                }    
                                                else
                                                {                                
                                                  echo "<option value='".$row['jobposition']."'>".$row['jobposition']." (".$client_name.")</option>\n";
                                                }
                                              }
                                              if($c==1)
                                              {
                                                echo "<option value='Any'>Any</option>\n";
                                              }
                                              else
                                              {
                                                echo "<option value='Any' selected>Any</option>\n";
                                              }  
                                          ?>  
                                        </select>                              
                                      </td>
                                    </tr>
                                  </table>

                              </td>                              
                                                          </tr>
                                                          <tr>
                                                            <td colspan=4>Keyword / Keyword Type</td>
                              </tr>
                              <tr>  
                                                            <td colspan=4>
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td><input type="text" id="key_id" name="key" value="<?php echo $key; ?>" <?php if($key_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    <td>&nbsp;
                                        <select name="key_type" id="key_type_id" <?php if($key_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                          <?php
                                            switch($key_type)
                                            {
                                              case "fname":
                                                echo '<option value="fname" selected>First Name</option>';
                                                break;
                                              case "lname":  
                                                echo '<option value="lname" selected>Last Name</option>';
                                                break;
                                              case "email":  
                                                echo '<option value="email" selected>Email</option>';
                                                break;
                                              case "skills":  
                                                echo '<option value="skills" selected>Skills</option>';
                                                break;
                                              case "resume_body":  
                                                echo '<option value="resume_body" selected>Resume Body</option>';
                                                break;  
                                              case "notes":  
                                                echo '<option value="notes" selected>Notes</option>';
                                                break;                                                  
                                            }
                                          ?>
                                          <option value="fname">First Name</option>
                                          <option value="lname">Last Name</option>
                                          <option value="email">Email</option>
                                          <option value="skills">Skills</option>
                                          <option value="resume_body">Resume Body</option>
                                          <option value="notes">Notes</option>
                                        </select>                                    
                                    </td>
                                    <td>&nbsp;Any</td>
                                    <td><input id="key_check_id" name="key_check" type="checkbox" onClick="javascript: any_key(this); " <?php if($key_check == "on") echo "checked"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    <td></td>
                                    </tr>
                                  </table>
                                
                              </td>
                                                          </tr>  
                              <tr>
                                                            <td>
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input type="hidden" name="view" value="Any"><input type="submit" name="advance_search" value="View Result" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    </tr>
                                  </table>

                              </td>                              
                              </tr>
                                                          <tr>
                                                            <td>
                              
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td></td>
                                    </tr>
                                  </table>
                                
                              </td>
                                                          </tr>                                                          
                                                        </table>
                            </form>  
                                                        -->      
        

        </td>
      </tr>
    </table>













<table width="100%" style="border:#CCCCCC solid 1px; " cellpadding="3" cellspacing="3">
                        <tr>
                          <td colspan="2">
                            <strong>Search for All Registered Applicant <font size=1><i>(entire database)</i></font></strong>
                          </td>
                        </tr>    
                        <tr>
                          <td colspan="2">

                          <form action="?<?php echo $posted_data; ?>" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">                              
                          <input type="hidden" name="country_option" id="country_option3" value="<?php echo $_SESSION["country_option"]; ?>">  
                                                        <table width="0%"  border="0" cellspacing="3" cellpadding="3">
                              <tr>
                              <td><font size="1">Date Registerd</font></td><td width="100%"><font size="1">Status</font></td>
                              </tr>
                              <tr>
                                <td>
                                    <select size="1" name="registered_rt" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                      <?php
                                        switch ($registered_rt) 
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
                                <td align="left">
                                        <select name="registered_view_a" id="view_id_a" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                          <?php
                                            switch($registered_view_a)
                                            {
                                              case "Endorsed":  
                                                echo '<option value="Endorsed" selected>Endorsed</option>';
                                                break;
                                              case "Sub Contracted":  
                                                echo '<option value="Sub Contracted" selected>Sub Contracted </option>';
                                                break;  
                                              case "Selected":  
                                                echo '<option value="Selected" selected>Selected</option>';
                                                break;                                                  
                                              case "Shorlisted":  
                                                echo '<option value="Shorlisted" selected>Shorlisted</option>';
                                                break;                                                      
                                              default:    
                                                echo '<option value="Any" selected>Any</option>';
                                                break;
                                            }
                                          ?>
                                          
                                          <option value="Sub Contracted">Sub Contracted </option>
                                          <option value="Selected">Selected</option>
                                          <option value="No Potential">No Potential</option>
                                          <option value="Unprocessed">Unprocessed</option>
                                          <option value="Endorsed">Endorsed</option>
                                          <option value="Pre-Screen">Pre-Screen</option>
                                          <option value="Shorlisted">Shorlisted</option>  
                                          <option value="Any">Any</option>                                        
                                        </select>              
                                        <input type="submit" value="View Result" name="registered_quick_search" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                    </td>
                                  </tr>
                                </table>
                              </form>    
                                
                              

        
        
        
                            <form action="?<?php echo $posted_data; ?>" method="post" name="formtable" onSubmit="return registered_validate(this); ">
                              <input type="hidden" name="country_option" id="country_option4" value="<?php echo $_SESSION["country_option"]; ?>">
                                                        <table width="0" border="0" cellpadding="0">
                                                          <tr>
                                                            <td colspan=3>Date&nbsp;Registered&nbsp;Between&nbsp;</td>
                              </tr>
                              <tr>  
                                                            <td colspan="5">
                                                            
                                                            
                                <table width="0"  border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                  <td>
                                                                        <table>
                                                                            <tr>
                                                                                <td><img align="absmiddle" src="../images/date-picker.gif" id="date_requested1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                <td>
                                                                                <input type="text" name="date_requested1" id="id_date_requested1" class="text" <?php if($registered_date_check == "on") echo "disabled"; ?> value="<?php echo $date_requested1; ?>">
                                                                                <script type="text/javascript">
                                                                                    Calendar.setup({
                                                                                            inputField  : "id_date_requested1",
                                                                                            ifFormat  : "%Y-%m-%d",
                                                                                            button    : "date_requested1_button",
                                                                                            align    : "Tl",
                                                                                            showsTime  : false, 
                                                                                            singleClick  : true
                                                                                    });
                                                                                </script>                                         
                                                                                </td>
                                                                            </tr>
                                                                        </table> 
                                                                     </td>
                                                                     <td>
                                                                        <table>
                                                                            <tr>
                                                                                <td><img align="absmiddle" src="../images/date-picker.gif" id="date_requested2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                                                <td>
                                                                                <input type="text" name="date_requested2" id="id_date_requested2" class="text" <?php if($registered_date_check == "on") echo "disabled"; ?> value="<?php echo $date_requested2; ?>">
                                                                                <script type="text/javascript">
                                                                                    Calendar.setup({
                                                                                            inputField  : "id_date_requested2",
                                                                                            ifFormat  : "%Y-%m-%d",
                                                                                            button    : "date_requested2_button",
                                                                                            align    : "T2",
                                                                                            showsTime  : false, 
                                                                                            singleClick  : true
                                                                                    });
                                                                                </script>                                         
                                                                                </td>
                                                                            </tr>
                                                                        </table> 
                                                                    </td>                                                                                                                                             
                                  <td>&nbsp;Any</td>                                  
                                  <td><input type="checkbox" id="registered_date_check_id" name="registered_date_check" onClick="javascript: registered_any_date(this); " <?php if($registered_date_check == "on") echo "checked"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                  </tr>
                                </table>
                              
                              
                              
                              </td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan=4>Keyword / Keyword Type (<i>multiple keywords separated by comma</i>)</td>
                              </tr>
                              <tr>  
                                                            <td colspan=4>
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td><input type="text" id="registered_key_id" name="registered_key" value="<?php echo $registered_key; ?>" <?php if($registered_key_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    <td>&nbsp;
                                        <select name="registered_key_type" id="registered_key_type_id" <?php if($registered_key_check == "on") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                          <?php
                                            switch($registered_key_type)
                                            {
                                              case "id":
                                                echo '<option value="id" selected>ID</option>';
                                                break;
                                              case "fname":
                                                echo '<option value="fname" selected>First Name</option>';
                                                break;
                                              case "lname":  
                                                echo '<option value="lname" selected>Last Name</option>';
                                                break;
                                              case "email":  
                                                echo '<option value="email" selected>Email</option>';
                                                break;
                                              case "skills":  
                                                echo '<option value="skills" selected>Skills</option>';
                                                break;
                                              case "mobile":  
                                                echo '<option value="mobile" selected>Mobile No.</option>';
                                                break;
                                              case "resume_body":  
                                                echo '<option value="resume_body" selected>Resume Body</option>';
                                                break;  
                                              case "notes":  
                                                echo '<option value="notes" selected>Notes</option>';
                                                break;                                                  
                                            }
                                          ?>
                                          <option value="id">ID</option>
                                          <option value="fname">First Name</option>
                                          <option value="lname">Last Name</option>
                                          <option value="email">Email</option>
                                          <option value="mobile">Mobile No.</option>
                                          <option value="skills">Skills</option>
                                          <option value="resume_body">Resume Body</option>
                                          <option value="notes">Notes</option>
                                        </select>                                    
                                    </td>
                                    <td>&nbsp;Any</td>
                                    <td><input id="registered_key_check_id" name="registered_key_check" type="checkbox" onClick="javascript: registered_any_key(this); " <?php if($registered_key_check == "on") echo "checked"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    <td></td>
                                    </tr>
                                  </table>
                                
                              </td>
                                                          </tr>  
                              <tr>
                                                            <td>
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input type="hidden" name="registered_view" value="Any"><input type="submit" name="registered_advance_search" value="View Result" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
                                    </tr>
                                  </table>

                              </td>                              
                              </tr>
                                                          <tr>
                                                            <td>
                              
                                  <table width="0%"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td></td>
                                    </tr>
                                  </table>
                                
                              </td>
                                                          </tr>                                                          
                                                        </table>
                            </form>        
        

        </td>
      </tr>
    </table>




        </td>
      </tr>
      <tr>
        <td colspan="2" align="center"></td>
      </tr>
    </table>
  
  </td>
  </tr>
</table>  
  
  <div id="category_applicants">
  <div style='margin-top:12px;padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
    <b>
      <strong><?php echo $sub_category_title; $_SESSION['sub_category_title'] = $sub_category_title; ?></strong>
    </b>
  </div>
  <div style='padding:5px; border:#CCCCCC solid 1px;'>
  <div class="pagination">

<ul>



<?php

// 2010-02-10 - mike s. lacanilao
// -- added paginator to take care of the pages

$result_total = mysql_query($query2);

$items = mysql_fetch_row($result_total);
$pages->items_total = $items[0];


$pages->mid_range = 7;
$pages->items_per_page = 100;
$pages->paginate();

$show_last = ($pages->items_total > $pages->high) ? $pages->high+1 : $pages->items_total;

// display number of records and navigation link
echo "<table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>".
    "<tr><td style='color:#FF0000'>Total Record: ".$pages->items_total ." &nbsp; &nbsp;</td>".
    "<td style='color:#642'> [ Showing ".($pages->low+1)." - ".$show_last." ]</td>".
    "<td> &nbsp; ".$pages->display_pages()."</td><td> &nbsp; ".$pages->display_items_per_page()." &nbsp; </td>".
    "<td>".$pages->display_jump_menu()."</td>".
    "</tr></table>";

?>
</ul>
</div>
<table width=98% id='tabledesign' cellspacing=1 cellpadding=1 align=center border=0 bgcolor="" >
<tr bgcolor="#666666" >
<td width="4%"   align=left><b><font color="#FFFFFF" size='1'>#</font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/email.gif" alt="Send Message"  onClick="checkAll(document.form.users)" style="cursor: pointer; "></font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/delete.png" alt="Delete This Applicant"></font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/documentsorcopy16.png" alt="mark Applicants"></font></b></td>
<td width="28%"  align=left><b><font color="#FFFFFF" size='1'>NAME</font></b></td>
<td width="12%"  align=left><b><font color="#FFFFFF" size='1'>DATE REGISTERED</font></b></td>
<td width="25%" align="center"><b><font color="#FFFFFF" size='1'>SKILLS</font></b></td>
<td width="25%" align="center"><b><font color="#FFFFFF" size='1'>MOVE</font></b></td>
</tr>

<?php
$counter=$offset;
$counter=0;
$curr_id = 0;
//$bgcolor="#f5f5f5";
$bgcolor="#ECEBF3";

$r_s = mysql_query($query . $pages->limit);
while ($row = @mysql_fetch_assoc($r_s)) 
{
  $userid = $row["userid"];
  if ($userid == 0) continue;
  $sql = "SELECT p.userid, p.lname, p.fname, p.email, p.skype_id, p.image, DATE_FORMAT(p.datecreated,'%D %b %Y') date,"
  . "p.status p_status, p.voice_path, c.latest_job_title, a.id , a.status a_status "
  . "FROM personal p LEFT JOIN currentjob c ON p.userid=c.userid "
  . "LEFT JOIN applicants a ON a.userid=c.userid "
  . "WHERE p.userid=".$userid ." ORDER BY date DESC LIMIT 1";
  
  $query_object = mysql_query($sql);
  $result = mysql_fetch_array($query_object);  
      
  $lname = $result['lname'];
  $fname = $result['fname'];
  $email = $result['email'];

  $skype_id = $result['skype_id'];
    
  $image= $result['image'];
  $date = $result['date'];
  $status = $result['status'];
  $voice_path = $result['voice_path'];
  $latest_job_title = $result['latest_job_title'];
  $skill = $result['skill'];
  $a_id = $result['a_id'];
  $a_status = $result['a_status'];
  
  
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
    } 
    else 
    {
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
    
    <tr bgcolor=<?php echo $bgcolor;?>>
    <td width="4%"  align=left valign="top"><font size='1'><?php echo $counter+$pages->low; ?>) </font></td>
    <td width="2%"  align=center valign="top"><font size='1'> 
      <input name="users" id="users"type="checkbox" onClick="check_val();" value="<?php echo $email;?>" title="Send Email to Applicant <?php echo $fname." ".$lname;?>"  >
    </font></td>
    <td width="2%"   align=center valign="top"><font size='1'>
      <div id='action<?php echo $userid; ?>'><input name="userss" id="userss" type="checkbox" onClick="action_delete('profile',<?php echo $userid;?>);" value="<?php echo $userid;?>" title="Delete Applicant <?php echo $fname." ".$lname;?>"></div>
      </font></td>
    <td width="2%"   align=center valign="top"><font size='1'>
      <input name="mark_applicants" id="mark_applicants" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'popup'); " value="<?php echo $userid;?>" title="<?php echo $mark;?> Applicant <?php echo $fname." ".$lname;?>&nbsp; as a Reserve Staff for future Employment "  >
    
      </font></td>  
    <td width="28%"  align=left valign="top">
    <div style="background-color:#FEFDE2; margin-bottom:0px; float:left;">
    <div style="cursor:pointer;" onMouseOut="hideddrivetip();" onMouseOver="ddrivetip('<?php echo $pic;?>')" class='jobCompanyName' onClick= "javascript:window.location='./application_apply_action.php?userid=<?php echo $userid;?>';" ><?php echo "<b>".$fname." ".$lname."</b>";?></div>
    
    
    </div>
    <div style="float:right">
    <?php if($status=="MARK")
    {
      echo "<img src='images/hot.gif' alt='Marked Applicants'>";
    }
    else { echo "&nbsp;";}
    ?></div>
    <div style=" font-size:11px; margin-top:18px;">
    <b style='color:#FF0000'>
    <?php echo $latest_job_title."<br>"; ?>
    </b>
    <?php echo $email."<br>"."SkypeId : ".$skype_id;?>
    </div>
      <?php
    if ($voice_path!="") 
    { 
      ?>
      <br>
      <a href="./<?php echo $voice_path;?>">Download</a>
      <?php
    } 
    ?>
    
    </td>
    <td width="12%"  align=left valign="top"><font size='1'><?php echo $date;?></font></td>
    <td valign="top">
    <div style="margin-left:10px; text-align:center">
      <i>
  <?php
    
    $sql_query = mysql_query("SELECT skill FROM skills WHERE userid=".$userid);
    $skill_str = '';
    while ($skillset = mysql_fetch_array($sql_query)) {
      if ($skill_str) $skill_str .= ",&nbsp;&nbsp;";
      
      $skill_str .= $skillset['skill'];
    }
    echo $skill_str;  
  
  ?>
    </i>
    </div>
    </td>
    
    
    <td>
        
      <table>
        <tr>
          <td><input name="<?php echo $inp_name; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'No Potential'); " value="No Potential" <?php if($a_status == "No Potential") echo "checked"; ?>></td>
          <td><font size="1">No&nbsp;Potential</font></td>    
          <td><input name="<?php echo $inp_name; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Pre-Screen'); " value="Pre-Screen" <?php if($a_status == "Pre-Screen") echo "checked"; ?>></td>
          <td><font size="1">Pre-Screen</font></td>
        </tr>    
        <tr>
          <td><input name="<?php echo $inp_name; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Unprocessed'); " value="Unprocessed" <?php if($a_status == "Unprocessed") echo "checked"; ?>></td>
          <td><font size="1">Unprocessed</font></td>
          <td><input name="<?php echo $inp_name; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Shortlist'); " value="Shorlisted" <?php if($a_status == "Shortlisted") echo "checked"; ?>></td>
          <td><font size="1">Shorlisted</font></td>
        </tr>  
        <tr>
          <td><input name="<?php echo $inp_name; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Endorse to Client'); " value="Endorsed" <?php if($a_status == "Endorse to Client") echo "checked"; ?>></td>
          <td><font size="1">Endorse to Client</font></td>
          <td><input name="<?php echo $inp_name; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Select'); " value="Select" <?php if($a_status == "Select") echo "checked"; ?>></td>
          <td><font size="1">Select</font></td>      
        </tr>
        <tr>
          <td><input name="<?php echo $inp_name; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Become a Staff'); " value="Become a Staff" <?php if($a_status == "Sub Contracted") echo "checked"; ?>></td>
          <td><font size="1">Become a Staff</font></td>
          <td><input name="<?php echo $inp_name; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Category'); " value="Become a Staff"></td>
          <td><font size="1">Add to Categories <br />/ Evaluate</font></td>        
        </tr>    
      </table>
    </td>
    
    
    </tr>
  <?php
    
    if($bgcolor=="#ECEBF3"){$bgcolor="#E6E6F0";}else{$bgcolor="#ECEBF3";}
    $curr_id = $result[$i]['userid'];
  
}
  
// display number of records and navigation link
echo "<table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>".
    "<tr><td style='color:#FF0000'>Total Record: ".$pages->items_total ." &nbsp; &nbsp;</td>".
    "<td style='color:#642'> [ Showing ".($pages->low+1)." - ".$show_last." ]</td>".
    "<td> &nbsp; ".$pages->display_pages()."</td><td> &nbsp; ".$pages->display_items_per_page()." &nbsp; </td>".
    "<td>".$pages->display_jump_menu()."</td>".
    "</tr></table>";


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


<? include 'footer.php';?>  

</body>
</html>



