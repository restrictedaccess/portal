<?
include "../../config.php";
include "../../conf.php";
include "../../time.php";
include "../../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$admin_name = $row['admin_fname']." ".$row['admin_lname'];
}


$keyword=$_REQUEST['keyword'];
$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
# create a MySQL REGEXP for the search: 
$regexp = "REGEXP '^.*($search).*\$'"; 
$keyword_search = " WHERE UPPER(u.lname) $regexp OR UPPER(u.fname) $regexp ";


//echo $admin_name;
$section = $_REQUEST['section'];

if($section == ""){
	die("Section is Missing.");
}

if($section == "search"){
	$query="SELECT DISTINCT(u.userid),CONCAT(u.fname,' ',u.lname)
	FROM personal u
	JOIN subcontractors s ON s.userid = u.userid
	$keyword_search
	ORDER BY u.fname ASC;";
}

if($section == "staff"){
	$query="SELECT DISTINCT(u.userid),CONCAT(u.fname,' ',u.lname)
	FROM personal u
	JOIN subcontractors s ON s.userid = u.userid
	ORDER BY u.fname ASC;";
}

if($section == "clients"){
	$query="SELECT DISTINCT(s.leads_id),CONCAT(l.fname,' ',l.lname) FROM subcontractors s
	LEFT JOIN leads l ON l.id = s.leads_id
	WHERE s.status = 'ACTIVE'
	ORDER BY l.fname ASC;";
}

function markName($id,$section){
	//if($section == "staff"){
		if($section=="search") $section = "staff";
		$query="SELECT * FROM testimonials WHERE for_id = $id AND for_by_type = 'subcon';";
		$result = mysql_query($query);
		if(mysql_num_rows($result) > 0){
			//$mark = "<img src=\"images/check_blink.gif\" border=\"0\" />";
			$mark = "<a class='mark' href=javascript:getTestimonialListFrom($id,'$section') >&nbsp;&nbsp;";
		}else{
			$mark = "<a href=javascript:getTestimonialListFrom($id,'$section') >";
		}	
		return 	$mark;
	//}
	
}
//echo $query;

$result = mysql_query($query);
if(!$result) die ("Error in Script. <br>".$query);
$counter=0;
echo "<ol>";
while(list($id,$name)=mysql_fetch_array($result))
{ $counter++;
	?>
	 <li><?=markName($id,$section);?><?=$name;?></a></li>
	<?
}
echo "</ol>";

?>




