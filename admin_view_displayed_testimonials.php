<?php
include './conf/zend_smarty_conf_root.php';
$admin_id = $_SESSION['admin_id'];
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
//$db->setFetchMode(Zend_Db::FETCH_OBJ);
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";
$result = $db->fetchRow($query);
$admin_name = "Welcome Admin :".$result['admin_fname']." ".$result['admin_lname'];


//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = $_REQUEST['rowsPerPage'];
if($rowsPerPage==""){
	$rowsPerPage = 10;
}
$rows = array("6 results","10 results" ,"12 results","14 results","16 results","18 results","20 results");
$rows_num = array(6,10,12,14,16,18,20);
for($i=0;$i<count($rows_num);$i++){
	if($rowsPerPage == $rows_num[$i]){
		$row_result.= "<option value=\"$rows_num[$i]\" selected >$rows[$i]</option>\n";
	}else{
		$row_result.= "<option value=\"$rows_num[$i]\">$rows[$i]</option>\n";
	}
}

// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
	$pageNum = $_GET['page'];
}
// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
// print the link to access each page
$self = "./".basename($_SERVER['SCRIPT_FILENAME']);

?>

<html>

<head>

<title>Administrator-Testimonials</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="testimonials/admin/testi.css">
<script language=javascript src="js/functions.js"></script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="<?=$self;?>">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>
<div style="padding-right:20px; FONT: bold 7.5pt verdana; COLOR: #676767; margin:5px;"><?=$admin_name;?></div>
<table width="100%">
<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>

</td>

<td valign="top"  style="font:12px Arial;">
<div class="testi_hdr" >
	<div style="float:left;">
		<b>Displayed Testimonials</b>
	</div>
	<div style="float:right;">
		<input type="button" value="Create and Configure Testimonials" onClick="javscript: location.href = 'admin_testimonials.php';">
	</div>
	<div style="clear:both;"></div>
</div>
<div class='pagination'><ul>
<?php	
//PAGING
$query2="SELECT COUNT(DISTINCT(u.userid))AS numrows
FROM personal u
LEFT JOIN subcontractors s ON s.userid = u.userid
LEFT JOIN testimonials t ON t.for_id = u.userid
WHERE t.testimony_status = 'posted' AND t.for_by_type = 'subcon' ORDER BY u.fname ASC;";

$result = $db->fetchRow($query2);
$numrows = $result['numrows'];

// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
	if ($page == $pageNum)
	{
		$nav .= " <li><a class='currentpage' href=\"$self?page=$page&rowsPerPage=$rowsPerPage\">$page</a></li> ";
	}
	else
	{
		$nav .= " <li><a href=\"$self?page=$page&rowsPerPage=$rowsPerPage\">$page</a></li> ";
	}
}
// creating previous and next link
// plus the link to go straight to
// the first and last page
	if ($pageNum > 1)
	{
		$page = $pageNum - 1;
		$prev = " <li><a class='prevnext disablelink' href=\"$self?page=$page&rowsPerPage=$rowsPerPage\">[Prev]</a></li> ";
		$first = "<li><a href=\"$self?page=1&rowsPerPage=$rowsPerPage\">[First Page]</a></li>";
	}
	else
	{
		$prev  = '&nbsp;'; // we're on page one, don't print previous link
		$first = '&nbsp;'; // nor the first page link
	}
	
	if ($pageNum < $maxPage)
	{
		$page = $pageNum + 1;
		$next = " <li><a class='prevnext' href=\"$self?page=$page&rowsPerPage=$rowsPerPage\">[Next]</a></li>";
		$last = " <li><a href=\"$self?page=$maxPage&rowsPerPage=$rowsPerPage\">[Last Page]</a></li> ";
	}
	else
	{
		$next = '&nbsp;'; // we're on the last page, don't print next link
		$last = '&nbsp;'; // nor the last page link
	}
echo $first . $prev . $nav. $next . $last;

?>
</ul>
<? echo "Shows $rowsPerPage results per page&nbsp;&nbsp;";?>
<select id="rowsPerPage" name="rowsPerPage" style="font:11px tahoma;" onChange="javascript: document.form.submit();"><?=$row_result;?></select>
</div>
<div id="staff_wrapper" >
<?php


function getTestiCreator($id,$type,$recipient){
	global $db;
	$ctr=0;
	if($type=="subcon"){
		$sql="SELECT CONCAT(fname,' ',lname)as name FROM personal u WHERE userid = $id;";
		$result = $db->fetchRow($sql);
		$name = $result['name'];
		return "Staff " .$name;
	}
	if($type=="leads"){
		// check first to the testimonials_display_info  for the client propose display info if there is no data parse it to the leads table;
		$sql = "SELECT display_name, display_desc FROM testimonials_display_info WHERE for_id = $id AND for_by_type = 'leads' AND recipient_id = $recipient AND recipient_type = 'subcon' ;";
					
		$result = $db->fetchRow($sql);
		$display_name = $result['display_name'];
		$display_desc = $result['display_desc'];
		
		
		
		$sql2="SELECT CONCAT(fname,' ',SUBSTRING(lname,1,1),'.')AS name, company_name , logo_image  FROM leads WHERE id = $id;";
		$result2 = $db->fetchRow($sql2);
		$name = $result2['name'];
		$company_name = $result2['company_name'];
		$logo_image = $result2['logo_image'];
		
		if ($display_name == ""){
			$display_name = $name;
		}
		if ($display_desc == ""){
			$display_desc = $company_name;
		}
		
		
		$mess = "<div class='testi_img_holder' >
					<img src='./lib/thumbnail_staff_pic.php?file_name=$logo_image' height='105' width='90'  />
				</div>
				<div>
					<div class='client_name'><span>Client :</span> ".$display_name."</div>
					<div class='staff_job_title'>".$display_desc."</div>
				</div>";
		return $mess;		
				
		
		
	}
}

$rowCount = 0;
$query = "SELECT DISTINCT(u.userid),u.fname,u.lname,u.image 
FROM personal u
LEFT JOIN subcontractors s ON s.userid = u.userid
LEFT JOIN testimonials t ON t.for_id = u.userid
WHERE t.testimony_status = 'posted' AND t.for_by_type = 'subcon' ORDER BY u.fname ASC LIMIT $offset, $rowsPerPage";
$result = $db->fetchAll($query);
$rowCount = count($result);
//echo $rowCount;

for($i=0; $i<$rowCount;$i++){
    $userid = $result[$i]['userid'];
	$staff_name = $result[$i]['fname']." ".substr($result[$i]['lname'],0,1).".";
	$image = $result[$i]['image'];
	
	$sqlJobTitle = "SELECT latest_job_title FROM currentjob c WHERE userid = ".$userid;
	$res = $db->fetchRow($sqlJobTitle);
	$latest_job_title = $res['latest_job_title'];
	//echo $latest_job_title."<br>";
	$testiCount = 0;
	$sql = "SELECT testimony, for_id, for_by_type FROM testimonials t 
	WHERE ((recipient_id = $userid AND recipient_type = 'subcon') OR (for_id = $userid AND for_by_type = 'subcon')) AND testimony_status = 'posted';";
	$rowset = $db->fetchAll($sql);
	
	
	//print_r($rowset);
    

	$testiCount = count($rowset);
	if($testiCount > 0){
	?>
		<div class="staff_box">
			<div>
				<div class="testi_img_holder">
					<img src="<?php echo "./lib/thumbnail_staff_pic.php?file_name=$image";?>" height="105" width="90"  />
				</div>
				<div>
					<div class="staff_name"><?php echo $userid." : ".$staff_name;?></div>
					<div class="staff_job_title"><?php echo $latest_job_title;?></div>
					<div class="testi_holder">
					<?php	
						$staff_testi="";
						$client_testi="";
						$counter = 0;
						$counter2=0;
						for($j=0; $j<$testiCount;$j++){
												
							$testimony = $rowset[$j]['testimony'];
							$for_id= $rowset[$j]['for_id'];
							$for_by_type= $rowset[$j]['for_by_type'];
							
							if($for_id == $userid and $for_by_type =="subcon"){
								$counter++;
								$staff_testi.= "<p>&quot;". str_replace("\n","<br>",$testimony)."&quot;</p>";
													
							}else{
								$counter2++;
								$client_testi.= "<div style='clear:both;'></div>";
								$client_testi.= "<div style='margin-top:10px;'>".getTestiCreator($for_id,$for_by_type,$userid)."<div class='testi_holder'><p>&quot;". str_replace("\n","<br>",$testimony)."&quot;</p></div></div>";

							}
						}
						if($counter>0){
							echo $staff_testi;
						}
					?>	
					</div>
				</div>
			</div>
			<div>
			<?php
				if($counter2>0){
					echo $client_testi;
				}
			?>
			</div>
		</div>
	<?php	
	}
	
}

?>

<div style="clear:both;"></div>
</div>

</td>
</tr>
</table>
<? include 'footer.php';?>
</form>	
</body>
</html>



