<?
include 'conf.php';
include 'config.php';

$main_category_id = @$_GET["main_category_id"];
$sub_category_id = @$_GET["sub_category_id"];
$action = @$_GET["action"];
$stat = @$_GET["stat"];
	
$userid=$_REQUEST['id'];
$status=$_REQUEST['status'];



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

//echo $userid."<br>";
//echo $status."<br>";

if($status=="New")
{
	$new_status="MARK";
}
elseif($status=="MARK")
{
	$new_status="New";
}
	$sqlMark="UPDATE personal SET status='$new_status' WHERE userid = $userid;";

//echo $sqlMark;

$result=mysql_query($sqlMark);
if(!$result)
{
	("Query: $sqlMark\n<br />MySQL Error: " . mysql_error());
	exit;
}
else
{
	header("location:adminadvertise_category_action.php?stat=".$stat."&action=".$action."&main_category_id=".$main_category_id."&sub_category_id=".$sub_category_id);
}	


?>
