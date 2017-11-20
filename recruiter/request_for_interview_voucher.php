<?php
include('../conf/zend_smarty_conf.php');

include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

if(!$_SESSION['admin_id']){
	header("location:index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
	echo "This page is for HR usage only.";
	exit;
}


$a = mktime(0, 0, 0, date("n"), +30, date("Y")); 
$date_today_advance = date("Y-m-d",$a); 
$date_today = date("Y-m-d");


//REDUCE THE SIZE OF COMMENTS
function truncate_comment($string) 
{
	return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[19].'...';
}
//ENDED


//POST
$f_code_number = $_REQUEST['f_code_number']; if($f_code_number == "") $f_code_number = "Any";
$f_date_expire = $_REQUEST['f_date_expire']; if($f_date_expire == "") $f_date_expire = "Any";
$f_date_created = $_REQUEST["f_date_created"]; if($f_date_created == "") $f_date_created = "Any";
$f_admin_id = $_REQUEST["f_admin_id"]; if($f_admin_id == "") $f_admin_id = "Any";
$f_comment = @$_REQUEST["f_comment"]; if($f_comment == "") $f_comment = "Any";
$f_limit_of_use = @$_REQUEST["f_limit_of_use"]; if($f_limit_of_use == "") $f_limit_of_use = "1";
$p = @$_REQUEST["p"];
//ENDED


//INSERT VOUCHER
if(@isset($_REQUEST["create"]))
{
	mysql_query("INSERT INTO voucher SET
	admin_id = '$f_admin_id',
	code_number = '$f_code_number',
	comment = '$f_comment',
	limit_of_use = '$f_limit_of_use',
	date_expire = '$f_date_expire',
	date_created = '$f_date_created'
	");
}	
//ENDED


//FUNCTIONS
function search($f_code_number,$f_date_expire,$f_date_created,$f_admin_id,$p,$maxp,$max) 
{
	$set = ($p-1)*$maxp ;
	
	$from = "FROM voucher";
	$order_by = "ORDER BY date_created DESC LIMIT $set, $maxp";	
	$fields = "*";

	//default	
	$date_today = date('Y-m-d');
	$where = "WHERE date_created='$date_today'";
	$query = "SELECT $fields $from $where $order_by";
	//ended
	
	if($f_code_number != "Any" || $f_date_expire != "Any" || $f_date_created != "Any" || $f_admin_id != "Any")
	{	
		$where = "";
		if($f_code_number != "Any")
		{
			$where = $where."code_number = '$f_code_number'";
		}
		if($f_date_expire != "Any")
		{
			if($where == "")
			{
				$where = $where."date_expire = '$f_date_expire'";
			}
			else
			{
				$where = $where." AND date_expire = '$f_date_expire'";
			}	
		}
		if($f_date_created != "Any")
		{
			if($where == "")
			{
				$where = $where."date_created = '$f_date_created'";
			}
			else
			{
				$where = $where." AND date_created = '$f_date_created'";
			}	
		}		
		if($f_admin_id != "Any")
		{
			if($where == "")
			{
				$where = $where."admin_id = '$f_admin_id'";
			}
			else
			{
				$where = $where." AND admin_id = '$f_admin_id'";
			}
		}
		$where = "WHERE ".$where;
		$query = "SELECT $fields $from $where $order_by";
	}

	$result =  mysql_query($query);
	
	if(!isset($max))
	{
		$m =  mysql_query("SELECT id $from $where");
		$max = mysql_num_rows($m);
	}
	
	$x = 0 ;	
	while ($r = mysql_fetch_assoc($result)) 
	{
		$temp[$x]['title'] = $title;
		$temp[$x]['max'] = $max;
		$temp[$x]['id'] = $r['id'];
		$temp[$x]['admin_id'] = $r['admin_id'];
		$temp[$x]['bp_id'] = $r['bp_id'];
		$temp[$x]['admin_name'] = "System Generated";
		$temp[$x]['limit_of_use'] = $r['limit_of_use'];
		
		if($temp[$x]['admin_id'] <> 0)
		{
			$q = "SELECT admin_id,admin_fname,admin_lname FROM admin WHERE admin_id='".$temp[$x]['admin_id']."'";
			$r_e = mysql_query($q);
			while ($rr = mysql_fetch_assoc($r_e)) 
			{
				$temp[$x]['admin_name'] = $rr["admin_fname"]." ".$rr["admin_lname"];
			}		
		}
		if($temp[$x]['bp_id'] <> 0)
		{
			$q = "SELECT agent_no,fname,lname FROM agent WHERE agent_no='".$temp[$x]['bp_id']."'";
			$r_e = mysql_query($q);
			while ($rr = mysql_fetch_assoc($r_e)) 
			{
				$temp[$x]['admin_name'] = $rr["fname"]." ".$rr["lname"];
			}			
		}
		
		$temp[$x]['code_number'] = $r['code_number'];
		$temp[$x]['comment'] = $r['comment'];
		$temp[$x]['date_expire'] = $r['date_expire'];
		$temp[$x]['date_created'] = $r['date_created'];

		$temp[$x]['total_used'] = mysql_num_rows(mysql_query("SELECT id FROM tb_request_for_interview WHERE voucher_number='".$temp[$x]['code_number']."'"));
		
		$x++ ;
	}
	return $temp ;
}

function linkpage($f_code_number,$f_date_expire,$f_date_created,$f_admin_id,$p,$size,$d) 
{
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="?f_limit_of_use='.$f_limit_of_use.'&f_code_number='.$f_code_number.'&f_date_expire='.$f_date_expire.'&f_date_created='.$f_date_created.'&f_admin_id='.$f_admin_id.'&max='.$max.'&p='.($p-1).'"><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="?f_limit_of_use='.$f_limit_of_use.'&f_code_number='.$f_code_number.'&f_date_expire='.$f_date_expire.'&f_date_created='.$f_date_created.'&f_admin_id='.$f_admin_id.'&max='.$max.'&p='.($p + 1).'"><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ENDED - FUNCTIONS



//GENERATE REPORT
if (!isset($p)) $p = 1 ;
$maxp = 20 ;
$found = search($f_code_number,$f_date_expire,$f_date_created,$f_admin_id,$p,$maxp,$max) ;
$pages = linkpage($f_code_number,$f_date_expire,$f_date_created,$f_admin_id,$p,$maxp,$found[0]['max']) ;
//ENDED


//GENERATE VOUCHER NUMBER
	$l = rand(1000, 2000);
	$gen_f_code_number = $l.rand(10000000, 20000000) ;
	for($i=0; $i < 2; $i++)
	{
		$q=mysql_query("SELECT id FROM voucher WHERE code_number = '$gen_f_code_number' LIMIT 1");
		$n = mysql_num_rows($q);
		if ($n > 0) 
		{
			$i = 0;
			$l = rand(1000, 2000);
			$gen_f_code_number = $l.rand(10000000, 20000000) ;
		}
		else
		{
			$i = 3; //break the loop
		}
	}
//ENDED


//START: searched result listings
$x = 0;
$bgcolor = "#E4E4E4";
$counter_checker = 1;
if ($found[0]['max'] <> 0) 
{
	$total = count($found);
	for ($x=0; $x < $total; $x++) 
	{

		$searched_result_listings .= '
						  <tr bgcolor="'.$bgcolor.'">
							<td align="right" valign="top" style="border-right: #006699 2px solid;">'.$found[$x]['admin_name'].'
								
								
								<!-- NOTES BOX -->	
								<div id="notes_'.$x.'" STYLE=\'POSITION: Absolute; VISIBILITY: HIDDEN\'>
								<table bgcolor="#2A629F" width="300" cellpadding="1" cellspacing="1"><tr><td>
									<table bgcolor="#FFFFCC" width="300" cellpadding="5" cellspacing="5">
										<tr>
											<td align="right"><a href="javascript: hideSubMenu(); "><img src="../images/action_delete.png" border="0"></a></td>
										</tr>
										<tr>
											<td>
												<font size="1">'.$found[$x]['comment'].'</font>
											</td>
										</tr>
									</table>
								</td></tr>	
								</table>	
								</div>
								<!-- ENDED - NOTES BOX -->	
																
																
							</td>
							<td align="left" valign="top">
								<!--<a href="admin_request_for_interview_popup.php?v='.$found[$x]['code_number'].'">-->'.$found[$x]['code_number'].'<!--</a>-->
							</td>
							<td align="left" valign="top">
								'.$found[$x]['date_expire'].'
							</td>
							<td align="left" valign="top">
								'.$found[$x]['date_created'].'
							</td>
							<td align="left" valign="top">
                            
                            	<table>
                                	<tr>
                                    	<td><input type="text" id="limit_of_use'.$found[$x]['code_number'].'" class="text" value="'.$found[$x]['limit_of_use'].'" size="5" maxlength="5"></td>
                                        <td><input type="text" id="total_used" class="text" value="'.$found[$x]['total_used'].'" size="5" maxlength="5" readonly></td>
                                        <td><input type="submit" value="Save" name="Save" class="button" onClick="javascript: voucher_limit('.$found[$x]['code_number'].'); "></td>
									</tr>
								</table>
								
                            </td>
							<td align="left" valign="top">';
							
							$temp = truncate_comment($found[$x]['comment']); 
							
							$searched_result_listings .= '<a href="javascript: showSubMenu(\'notes_'.$x.'\'); ">'.$temp.'</a>
							</td>
						  </tr>';
						  
						if($counter_checker == 1)
						{
							$bgcolor = "#F5F5F5";
							$counter_checker = 0;
						}
						else
						{
							$bgcolor = "#E4E4E4";
							$counter_checker = 1;
						}						  
	}
}	
//ENDED: searched result listings


//START: caledar date picker jscript
$id_f_date_created = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_f_date_created",
		ifFormat	: "%Y-%m-%d",
		button		: "id_f_date_created_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
$id_f_date_expire = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_f_date_expire",
		ifFormat	: "%Y-%m-%d",
		button		: "id_f_date_expire_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';

$id_f_date_created_c = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_f_date_created_c",
		ifFormat	: "%Y-%m-%d",
		button		: "id_f_date_created_c_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
$id_f_date_expire_c = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_f_date_expire_c",
		ifFormat	: "%Y-%m-%d",
		button		: "id_f_date_expire_c_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
//ENDED: caledar date picker jscript


//START: admin dropdown options
$admin_search_options .= '
<option value=\'0\'>System Generated</option>';
$query = "SELECT admin_id,admin_fname,admin_lname FROM admin";
$r_e = mysql_query($query);
$is_true = 0;
while ($row = mysql_fetch_assoc($r_e)) 
{
	if($f_admin_id == $row["admin_id"])
	{
		$is_true = 1;
		$admin_search_options .= "<option value='".$row["admin_id"]."' selected>".$row["admin_fname"]." ".$row["admin_lname"]."</option>";
	}
	else
	{
		$admin_search_options .= "<option value='".$row["admin_id"]."'>".$row["admin_fname"]." ".$row["admin_lname"]."</option>";
	}
}
																
if($is_true == 0)
{
	$admin_search_options .= "<option value='' selected>Any</option>";
}
else
{
	$admin_search_options .= "<option value=''>Any</option>";
}	

$admin_create_options .= "
<option value='".$_SESSION['admin_id']."' selected>Admin</option>
<option value='0'>System Generated</option>";
//ENDED: admin dropdown options


$smarty->assign('id_f_date_created', $id_f_date_created);
$smarty->assign('f_date_created', $f_date_created);
$smarty->assign('date_today', $date_today);
$smarty->assign('id_f_date_expire', $id_f_date_expire);
$smarty->assign('id_f_date_created_c', $id_f_date_created_c);
$smarty->assign('id_f_date_expire_c', $id_f_date_expire_c);
$smarty->assign('date_today_advance', $date_today_advance);
$smarty->assign('f_limit_of_use', $f_limit_of_use);
$smarty->assign('admin_create_options', $admin_create_options);
$smarty->assign('position_advertised', $position_advertised);
$smarty->assign('country_option', $country_option);
$smarty->assign('staff_status', $staff_status);
$smarty->assign('searched_result_listings', $searched_result_listings);
$smarty->assign('gen_f_code_number', $gen_f_code_number);
$smarty->assign('gen_f_comment', $gen_f_comment);
$smarty->assign('pages', $pages);
$smarty->display('request_for_interview_voucher.tpl');
?>