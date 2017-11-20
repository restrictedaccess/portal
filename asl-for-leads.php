<?php
include('../ShowPrice.php');
include 'config.php';
include 'conf.php';

if($_SESSION['admin_id']=="")
{
	if($_SESSION['agent_no']=="")
	{
		header("location:index.php");
	}
}

$keyword = @$_REQUEST["id"];

$max = @$_REQUEST["max"];
$p = @$_REQUEST["p"];
$c = @$_REQUEST["c"];
$cl = @$_REQUEST["cl"];
$sr = @$_REQUEST["sr"];
$to = @$_REQUEST["to"];
$staff_skill_option = @$_REQUEST["staff_skill_option"];
$staff_skill_key = @$_REQUEST["staff_skill_key"];
$staff_skill_sumit = @$_REQUEST["staff_skill_sumit"];
$skills_option = @$_REQUEST["skills_option"];
if($skills_option == 0) $skills_option0 = 'checked="checked"'; else $skills_option1 = 'checked="checked"';

$_SESSION["position_id"] = $keyword;
if(isset($cl))
{
	$_SESSION["selected_currency_id"] = $cl;
}
else
{
	switch(LOCATION_ID)
	{
		case 1:
			//$selected_timezone = "Australia/Sydney";
			$_SESSION["selected_currency_id"] = 3;
			$cl = 3;
			$_REQUEST["cl"] = 3;
			break;
		case 2:
			//$selected_timezone = "Europe/London";
			$_SESSION["selected_currency_id"] = 4;
			$cl = 4;
			$_REQUEST["cl"] = 4;
			break;
		case 3:
			//$selected_timezone = "America/New_York";
			$_SESSION["selected_currency_id"] = 5;
			$cl = 5;
			$_REQUEST["cl"] = 5;
			break;
		case 4:
			//$selected_timezone = "Asia/Manila";
			$_SESSION["selected_currency_id"] = 6;
			$cl = 6;
			$_REQUEST["cl"] = 6;
			break;
		default:
			//$selected_timezone = "Australia/Sydney";
			$_SESSION["selected_currency_id"] = 3;
			$cl = 3;
			$_REQUEST["cl"] = 3;
			break;	
	}
}


//functions
function search($keyword,$page,$maxp,$max,$cl,$sr) 
{
	$set = ($page-1)*$maxp ;
	
	//get the sign
	$q_l=mysql_query("SELECT code, sign FROM currency_lookup WHERE id='$cl' LIMIT 1");
	$ctr=@mysql_num_rows($q_l);
	if ($ctr > 0)
	{
		$r_a = mysql_fetch_array ($q_l); 
		$sign = $r_a['code'];
		$money_sign = $r_a['sign'];
	}
	//end	
	
	if($staff_skill_sumit == "")
	{
		$result = mysql_query("SELECT j.userid,p.fname,p.image,voice_path,j.id 
		FROM 
			job_sub_category_applicants j, 
			personal p 
		WHERE 
			j.userid = p.userid AND 
			j.sub_category_id ='$keyword' AND 
			j.ratings='0'
		ORDER BY p.fname DESC LIMIT $set, $maxp") ;
		if(!isset($max))
		{
			$maxr = mysql_query("SELECT count(j.userid)
			FROM 
				job_sub_category_applicants j, 
				personal p 
			WHERE 
				j.userid = p.userid AND 
				j.sub_category_id ='$keyword' AND 
				j.ratings='0'
			") ;	
			$max = mysql_result(@$maxr,0) ;
		}
	}
	else
	{
		//category query options
		$category_query = "";	
		if($skills_option == 0)
		{
			$category_query = "j.sub_category_id = '$keyword' AND ";
		}
		//ended
		
		//like skills query options
		if($staff_skill_key == "" || $staff_skill_key == "Type Skill or ID")
		{
			$skill_query = "(s.skill LIKE '%$staff_skill_option%') AND ";
		}
		elseif($staff_skill_option == "" || $staff_skill_option == "Select Skill")
		{
			$skill_query = "(j.userid='$staff_skill_key' OR s.skill LIKE '%$staff_skill_key%') AND ";
		}
		else
		{
			$skill_query = "(j.userid='$staff_skill_key' OR s.skill LIKE '%$staff_skill_option%' OR s.skill LIKE '%$staff_skill_key%') AND ";
		}
		//ended
 
 		$result = mysql_query("SELECT j.userid,p.fname,p.image,voice_path,j.id 
		FROM 
			job_sub_category_applicants j, 
			skills s,
			personal p 
		WHERE 
			j.userid = p.userid AND 
			j.userid = s.userid AND 
			$skill_query
			$category_query
			j.ratings='0'
		ORDER BY p.fname DESC LIMIT $set, $maxp") ;
		
		if(!isset($max))
		{
			$maxr = mysql_query("SELECT count(j.userid)
			FROM 
				job_sub_category_applicants j, 
				skills s,
				personal p 
			WHERE 
				j.userid = p.userid AND 
				j.userid = s.userid AND 
				$skill_query
				$category_query
				j.ratings='0'
			") ;	
			$max = mysql_result(@$maxr,0) ;
		}	
	}
	
	
	$x = 0 ;	
	while ($r = mysql_fetch_assoc($result)) 
	{
		$u_id = $r['userid'] ;
		$temp[$x]['max'] = $max ;
		$temp[$x]['userid'] = $r['userid'] ;
		$temp[$x]['applicant_name'] = $r['fname']." ".$r['lname'] ;
		$temp[$x]['image'] = $r['image'] ;
		$temp[$x]['voice_path'] = $r['voice_path'] ;
		$temp[$x]['id'] = $r['id'] ;
		
		//compute staff rate - used currency_id = 3 as AUD default currency
		//formula: Monthly Rate * 12 = Yearly Rate, Yearly Rate / 52 Weeks = Weekly Rate, Weekly Rate / 5 Days = Daily Rate, Daily Rate / 8 Hours = Hourly Rate		
			$u_id = $r['userid'] ;
			if($sr == 2)
			{			
					//part time rate
					$part_time_r = 0;
					$part_time_h = 0;
					$q_amount=mysql_query("SELECT p.amount FROM staff_rate s, product_price_history p WHERE p.currency_id='$cl' AND s.userid='$u_id' AND s.part_time_product_id=p.product_id ORDER BY p.date DESC LIMIT 1");
					$ctr=@mysql_num_rows($q_amount);
					if ($ctr > 0)
					{
						$r_amount = mysql_fetch_array ($q_amount); 
						$part_time_r = $r_amount['amount'];
						$yearly = $part_time_r * 12;
						$weekly = $yearly / 52;
						$daily = $weekly / 5;
						$part_time_h = $daily / 4;
						$part_time_h = round($part_time_h, 2);				
					}		
					$sign=str_replace("£","&pound;",$sign);		
					$part_time_r = number_format($part_time_r, 2, '.', ',');
					$temp[$x]['part_time'] = $part_time_r ; 
					$part_time_h = number_format($part_time_h, 2, '.', ',');
					$temp[$x]['part_time_hour'] = $part_time_h ; 
					//ended
			}
			else
			{		
					//hourly rate / monthly rate
					$per_h = 0;
					$per_m = 0;
					$q_amount=mysql_query("SELECT p.amount FROM staff_rate s, product_price_history p WHERE p.currency_id='$cl' AND s.userid='$u_id' AND s.product_id=p.product_id ORDER BY p.date DESC LIMIT 1");
					$ctr=@mysql_num_rows($q_amount);
					if ($ctr > 0)
					{
						$r_amount = mysql_fetch_array ($q_amount); 
						$per_m = $r_amount['amount'];
						$yearly = $per_m * 12;
						$weekly = $yearly / 52;
						$daily = $weekly / 5;
						$per_h = $daily / 8;
						$per_h = round($per_h, 2);
					}		
					$sign=str_replace("£","&pound;",$sign);
					$per_h = number_format($per_h, 2, '.',',');
					$temp[$x]['per_hour'] = $per_h ; 
					$per_m = number_format($per_m, 2, '.',',');
					$temp[$x]['per_month'] = $per_m ; 
					//ended
			}
			
			
			if($sr == 2)
			{
				$temp[$x]['sr_pf'] = $sign."&nbsp;".$money_sign.$temp[$x]['part_time_hour']."/Hourly&nbsp;".$money_sign.$temp[$x]['part_time']."/Monthly";
			}
			else
			{
				$temp[$x]['sr_pf'] = $sign."&nbsp;".$money_sign.$temp[$x]['per_hour']."/Hourly&nbsp;".$money_sign.$temp[$x]['per_month']."/Monthly";
			}
		//end
		
		//NOTE: this is temporary disabled, this code is tested and ready to use
		//generate currency dropdown per staff
		//$q_currency=mysql_query("SELECT DISTINCT(c.id), c.code FROM staff_rate s, product_price_history p, currency_lookup c WHERE s.product_id = p.product_id AND c.id = p.currency_id");
		//while ($r_currency = mysql_fetch_assoc($q_currency)) 
		//{
			//if($r_currency['id'] == 3) //3 = USD as default
			//{
				//$temp[$x]['currency_option'] = $temp[$x]['currency_option']."<option value='".$r_currency['id']."' selected>".$r_currency['code']."</option>\n";
			//}
			//else
			//{
				//$temp[$x]['currency_option'] = $temp[$x]['currency_option']."<option value='".$r_currency['id']."'>".$r_currency['code']."</option>\n";
			//}
		//}		
		//end
		
		//generate skills
		$counter = 0;
		$q_skills=mysql_query("SELECT id, skill, experience, proficiency FROM skills WHERE userid='$u_id'");
		while(list($s_id,$s_skill,$exp,$pro) = mysql_fetch_array($q_skills))
		{
			$s_skill = str_replace(",",", ",$s_skill);
			$exp = str_replace(",",", ",$exp);
			
			$s_skill = str_replace("/"," / ",$s_skill);
			$exp = str_replace("/"," / ",$exp);
						
			$temp[$x]['skills'] = $temp[$x]['skills']. 
			"<p>
				<strong>".strtoupper($s_skill)."</strong><br />
				Experience&nbsp;:&nbsp;".$exp."<br />
				Proficiency&nbsp;:&nbsp;".$pro."<br />
			</p>";
		}
		//end
		
		//generate working availability
		$q_availability = mysql_query("SELECT id,DATE_FORMAT(evaluation_date,'%D %b %Y'), work_fulltime, fulltime_sched, work_parttime, parttime_sched, work_freelancer, expected_minimum_salary FROM evaluation WHERE userid = '$u_id' LIMIT 1");
		list($evaluation_id,$evaluation_date, $work_fulltime, $fulltime_sched, $work_parttime, $parttime_sched, $work_freelancer, $expected_minimum_salary)=mysql_fetch_array($q_availability);
		$temp[$x]['availability'] = "";
		if($work_fulltime == "yes")
		{
			$temp[$x]['availability'] = "Full Time";
		}
		if($work_parttime == "yes")
		{
			if($temp[$x]['availability'] != "")
			{
				$temp[$x]['availability'] = $temp[$x]['availability']."/Part Time";
			}
			else
			{
				$temp[$x]['availability'] = "Part Time";
			}	
		}
		if ($work_freelancer == "yes")
		{
			if($temp[$x]['availability'] != "")
			{
				$temp[$x]['availability'] = $temp[$x]['availability']."/Freelancer";
			}
			else
			{
				$temp[$x]['availability'] = "Freelancer";
			}
		}
		//end
		
		$x++ ;
	}
	return $temp ;
}

function linkpage($keyword,$d,$p,$size,$c,$cl,$sr,$to) 
{
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="?to='.$to.'&sr='.$sr.'&cl='.$cl.'&c='.$c.'&max='.$max.'&p='.($p-1).'&id='.$keyword.'"><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="?to='.$to.'&sr='.$sr.'&cl='.$cl.'&c='.$c.'&max='.$max.'&p='.($p + 1).'&id='.$keyword.'"><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ended



//generate result
if (!isset($p)) $p = 1 ;
$maxp = 20 ;
$found = search($keyword,$p,$maxp,$max,$cl,$sr) ;
$pages = linkpage($keyword,$found[0]['max'],$p,$maxp,$c,$cl,$sr,$to) ;
//ended




//check actions
if(isset($keyword))
{
	//generate currency dropdown on all staff
	$currency_option = 'Currency&nbsp;<SELECT name="currency_id" onchange="javascript: window.location=\'?cl=\'+this.value+\'&c='.$c.'&p='.$p.'&id='.$keyword.'\'; " style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">';
	$q_currency=mysql_query("SELECT DISTINCT(c.id), c.currency FROM staff_rate s, product_price_history p, currency_lookup c WHERE s.product_id = p.product_id AND c.id = p.currency_id");
	while ($r_currency = mysql_fetch_assoc($q_currency)) 
	{
		if($_SESSION["selected_currency_id"] == $r_currency['id'])
		{
			$currency_option = $currency_option."<option value='".$r_currency['id']."' selected>".$r_currency['currency']."</option>\n";
		}	
		else
		{
			$currency_option = $currency_option."<option value='".$r_currency['id']."'>".$r_currency['currency']."</option>\n";
		}	
	}		
	$currency_option = $currency_option.'</SELECT>';
	//end

	//generate staff rate dropdown on all staff
	$staff_rate_option = '&nbsp;&nbsp;Staff&nbsp;Rate&nbsp;<SELECT name="rs" onchange="javascript: window.location=\'?sr=\'+this.value+\'&cl='.$cl.'&c='.$c.'&p='.$p.'&id='.$keyword.'\'; " style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">';
	if($sr == 2) 
	{
		$staff_rate_option = $staff_rate_option."<option value='2' selected>Part Time</option>\n";
		$staff_rate_option = $staff_rate_option."<option value='1'>Full Time</option>\n";		
	}	
	else
	{	 
		$staff_rate_option = $staff_rate_option."<option value='2'>Part Time</option>\n";	
		$staff_rate_option = $staff_rate_option."<option value='1' selected>Full Time</option>\n";
	}	
	$staff_rate_option = $staff_rate_option.'</SELECT>';
	//end
}
//ended





//skills actions
	//generate staff skills dropdown on all staff
	//$q_skills=mysql_query("SELECT DISTINCT s.skill FROM skills s, job_sub_category_applicants j WHERE j.userid = s.userid ORDER BY s.skill ASC");
	//$staff_skill_option = '<SELECT name="skills" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">';
	//$staff_skill_option = $staff_skill_option."<option value=''>Select Skill Here</option>\n";
	//while(list($skill) = mysql_fetch_array($q_skills))
	//{
		//$staff_skill_option = $staff_skill_option."<option value='".$skill."'>".strtoupper($skill)."</option>\n";	
	//}
	//$staff_skill_option = $staff_skill_option.'</SELECT>';
	
	//if($skills_option == 1)
	//{
		//$skills_option1 = "checked";
	//}
	//else
	//{
		//$skills_option0 = "checked";
	//}

	$staff_skill_option_value = $staff_skill_option;
	$staff_skill_option = '<SELECT name="staff_skill_option" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">';
	if(!isset($staff_skill_option_value) || $staff_skill_option_value == "" || $staff_skill_option_value == "Select Skill")
	{
		$staff_skill_option = $staff_skill_option."<option value='' selected>Select Skill</option>\n";
	}
	else
	{
		$staff_skill_option = $staff_skill_option."<option value='".$staff_skill_option_value."' selected>".$staff_skill_option_value."</option>\n";		
	}
	$staff_skill_option = $staff_skill_option.'
	<OPTGROUP label="Technical Skills ">
	<option value="Actionscript" >Actionscript </option>
	<option value="Adobe Fireworks" >Adobe Fireworks</option>
	<option value="Adobe Illustrator" >Adobe Illustrator </option>
	<option value="Adobe Indesign" >Adobe Indesign</option>
	<option value="Adobe Photoshop" >Adobe Photoshop</option>
	<option value="AJAX" >AJAX</option>
	<option value="ASP" >ASP </option>
	<option value="C#" >C# </option>
	<option value="C++" >C++</option>
	<option value="CAD" >CAD </option>
	<option value="CISCO" >CISCO </option>
	<option value="Classic ASP" >Classic ASP </option>
	<option value="Coldfusion" >Coldfusion</option>
	<option value="Corel Draw" >Corel Draw</option>
	<option value="CSS" >CSS</option>
	<option value="Drupal" >Drupal </option>
	<option value="HTML" >HTML</option>
	<option value="JavaScript" >JavaScript</option>
	<option value="Joomla" >Joomla </option>
	<option value="Link Building" >Link Building </option>
	<option value="Macromedia Dreamweaver" >Macromedia Dreamweaver</option>
	<option value="Magento" >Magento </option>
	<option value="Maya" >Maya </option>
	<option value="MS Access" >MS Access </option>
	<option value="MS Office" >MS Office </option>
	<option value="MS SQL" >MS SQL</option>
	<option value="MySQL" >MySQL </option>
	<option value="OOP" >OOP </option>
	<option value="Photoshop" >Photoshop </option>
	<option value="PHP" >PHP </option>
	<option value="SEO" >SEO </option>
	<option value="SOLIDWORKS" >SOLIDWORKS</option>
	<option value="Swishmax" >Swishmax </option>
	<option value="Vector Works" >Vector Works </option>
	<option value="Video Editing" >Video Editing </option>
	<option value="Wordpress" >Wordpress </option>
	<option value="XHTML" >XHTML</option>
	<option value="XML" >XML </option>
	<option value=".NET" >.NET </option>
	<option value="3D MAX" >3D MAX</option>
	</OPTGROUP>
	
	<OPTGROUP label="Admin Skills  ">
	<option value="Appointment Setting" >Appointment Setting </option>
	<option value="Customer Service" >Customer Service </option>
	<option value="Data Entry" >Data Entry </option>
	<option value="Debt Collection" >Debt Collection</option> 
	<option value="Internet Research" >Internet Research </option>
	<option value="Lead Generation" >Lead Generation</option> 
	<option value="Legal" >Legal </option>
	<option value="MS Application" >MS Application </option>
	<option value="MS Excel" >MS Excel </option>
	<option value="MS Powepoint" >MS Powepoint </option>
	<option value="MS Word" >MS Word</option>
	<option value="MYOB" >MYOB</option>
	<option value="ORACLE" >ORACLE</option>
	<option value="Peachtree" >Peachtree</option>
	<option value="Photo Editing" >Photo Editing </option>
	<option value="Quickbooks" >Quickbooks </option>
	<option value="SAP" >SAP </option>
	<option value="Tele Sales" >Tele Sales</option>
	<option value="Tele Survey" >Tele Survey </option>
	<option value="Telemarketing" >Telemarketing </option>
	<option value="Video Editing" >Video Editing </option>
	<option value="Writing" >Writing </option>
	</OPTGROUP>	
	';
	$staff_skill_option = $staff_skill_option.'</SELECT>';
	
	if(!isset($staff_skill_key) || $staff_skill_key == "")
	{
		$staff_skill_key = "Type Skill or ID";
	}
	$staff_skill_key = '<INPUT name="staff_skill_key" id="staff_skill_key" value="'.$staff_skill_key.'" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;" onclick="javascript: if(this.value==\'Type Skill or ID\') this.value=\'\'; ">';	
	//end	
//skills ended	
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Business Partner</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">



<script type="../text/javascript" src="video/flowplayer-3.1.4.min.js"></script>
<script src="../js/rsscroll.js" type="text/javascript"></script>
<script language="javascript">
var active_userid = ""; //used on active_currency function
function validate(form) 
{
	if ((form.staff_skill_option.value == '' || form.staff_skill_option.value == 'Select Skill Here') && (form.staff_skill_key.value == '' || form.staff_skill_key.value == 'Type Skill Here')) { alert("Please select or type the keyword."); form.staff_skill_key.focus(); return false; }
	return true;
}
function listmax(idx,idy,idz)
{
	document.getElementById(idx).style.display = 'block';
	document.getElementById(idy).style.display = 'none';
	document.getElementById(idz).style.display = 'block';
}
function listmin(idx,idy,idz)
{
	document.getElementById(idx).style.display = 'none';
	document.getElementById(idy).style.display = 'none';
	document.getElementById(idz).style.display = 'block';
}
function makeObject()
{
	var x ; 
	var browser = navigator.appName ;
	if(browser == 'Microsoft Internet Explorer')
	{
		x = new ActiveXObject('Microsoft.XMLHTTP')
	}
	else
	{
		x = new XMLHttpRequest()
	}
	return x ;
}
var request = makeObject()
var currency_check = makeObject()
function order(userid,name,id)
{
	if(document.getElementById('app_id'+id).checked == true)
	{
		request.open('get', 'available-staff-booking-session.php?userid='+userid+'&name='+name+'&id='+id)
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		request.onreadystatechange = active_listings 
		request.send(1)
		//alert(name+" has been added to your list.");	
	}
	else
	{
		request.open('get', 'available-staff-booking-session.php?uncheck_id='+id)
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		request.onreadystatechange = active_listings 
		request.send(1)
		//alert(name+" has been removed from your list.");	
	}
}

function clear_list()
{
	request.open('get', 'available-staff-booking-session.php?reset=true')
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	request.onreadystatechange = active_listings 
	request.send(1)
}
function email_resume(to) 
{
	if(to == "")
	{
		previewPath = "available-staff-email-resume.php";
	}	
	else
	{
		previewPath = "available-staff-email-resume.php?to="+to;
	}
	window.open(previewPath,'_blank','width=700,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
function resume(id) 
{
	previewPath = "../available-staff-resume.php?userid="+id;
	window.open(previewPath,'_blank','width=820,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
function sample_files(id) 
{
	previewPath = "../available-staff-sample-files.php?userid="+id;
	window.open(previewPath,'_blank','width=500,height=300,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
function cancel_selected_order(id)
{
	request.open('get', 'available-staff-booking-session.php?uncheck_id='+id)
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	request.onreadystatechange = active_listings 
	request.send(1)
}
function active_currency()
{
	var data;
	data = currency_check.responseText
	if(currency_check.readyState == 4)
	{
		document.getElementById('rate'+active_userid).innerHTML = data;
	}
	else
	{
		document.getElementById('rate'+active_userid).innerHTML="Loading...";
	}
}
function active_listings()
{
	var data;
	data = request.responseText
	if(request.readyState == 4)
	{
		document.getElementById('listings').innerHTML = '<table width="330" border="0" cellspacing="0" cellpadding="0" style="margin:5px 8px 0px 8px;">'+data+'</table>';
	}
	else
	{
		document.getElementById("listings").innerHTML="<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center><img src='images/ajax-loader.gif'></td></tr></table>";
	}
}			
</script>
<link href="../css/bp-style.css" type="text/css" rel="stylesheet"  />
<link href="../css/rsscroll-staff.css" type="text/css" rel="stylesheet" />









<style type="text/css">
<!--
div.scroll {
	height: 100%;
	width: 100%;
	overflow: auto;
	padding: 8px;
}
.tableContent tr:hover
{
	background:#FFFFCC;
}
.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
.remind_data{
font:9px tahoma;
padding:3px;
}  
.remind_label{
font:9px tahoma;
} 
.remind_tr{
border:#CCCCCC solid 1px;
}
-->
</style>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" class="sub-bg" id="availstaffx">

<form method="POST" name="form" action="agentHome.php">

<!-- HEADER -->

<?php 
include 'header.php';
if($_SESSION['admin_id'])
{
	include 'admin_header_menu.php';
}
else
{
	include 'BP_header.php';
}
?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php
if($_SESSION['admin_id'])
{
	include 'adminleftnav.php';
}
else
{
	include 'agentleftnav.php';
}
?>

</td>
<td width=100% valign=top >
<!-- Contents Here -->
<div style="font:12px Arial; margin:3px;">
<table width="100%">
	<tr>
		<td width="10%" valign="top">
			<div style="background:#2A629F; border:#2A629F outset 1px; padding:3px;"><strong><font color="#FFFFFF">Selected Staff</font></strong></div>
		</td>		
		<td width="60%" valign="top">
			<div style="background:#2A629F; border:#2A629F outset 1px; padding:3px;"><strong><font color="#FFFFFF">Staff List</font></strong></div>
		</td>			
	</tr>	
	<tr>
		<td width="10%" valign="top">
			<div id="listings">
			<table border="0" cellspacing="0" cellpadding="0" style="margin:5px 8px 0px 8px; height:100px;"><?php echo $_SESSION["request_selected"]; ?></table>
			</div>
			<p align="center">
			<br />
			<input type="button" value="Send to Leads" class="button" onClick="javascript: email_resume('<?php echo $to; ?>');"><br /><br />
			<input type="button" value="Reset List" class="button" onClick="javascript: clear_list();">
		</td>		
		<td width="90%" valign="top" rowspan="3">

		
        <!-- ASL SEARCH FUNCTION -->
        <form action="send-resume-to-leads.php?<?php echo 'sr='.$sr.'&cl='.$cl.'&c='.$c.'&id='.$keyword; ?>" method="post" onSubmit="return validate(this)">
        <table width="98%">
            <tr>
                <td colspan="2">
                Search by Skill/ID: <?php echo $staff_skill_option; ?> or <?php echo $staff_skill_key; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                <input type="radio" name="skills_option" id="re" value="0" <?php echo $skills_option0; ?> />Search this Category Only
                <input type="radio" name="skills_option" id="re" value="1" <?php echo $skills_option1; ?> />Search in All Categories
                <input type="submit" value="Search" name="staff_skill_sumit" />
                </td>
            </tr>    
        </table>
        </form>
        <!--ENDED-->
        

		<!--LIST CONTENT-->
		<table>
			<tr>
				<td align="right" colspan="2">
						<table width="100%">
							<tr>
								<td width="70%"><?php echo $currency_option; ?><?php echo $staff_rate_option; ?></td>
								<td align="right" width="30%"><?php echo $pages; ?></td>
							</tr>
						</table>
				</td>	
			</tr>	
            
            
            
				<?php
				if ($found[0]['max'] <> 0) 
				{
					$adjuster = "";
					$total = count($found);
					for ($x=0; $x < $total; $x++) 
					{
				?>	
			<tr>
				<td>
					<table  border="0" cellspacing="0" cellpadding="0" id="astaff" width="342">
						<tr>
							<td width="342" align="center">
								<table width="342" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="left" valign="top" class="boxheader">
											<table width="342" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="10" align="left" valign="top">&nbsp;</td>
													<td width="152" align="left" valign="middle" nowrap>
														<div id="rate<?php echo $found[$x]['userid']; ?>"><font color="#FFFFFF"><?php echo $found[$x]['sr_pf']; ?></font></div>	
													</td>
													<td width="100" align="left" valign="top" class="selectstaff">select staff <input name="app_name<?php echo $found[$x]['id']; ?>" id="app_id<?php echo $found[$x]['id']; ?>" type="checkbox" value="" onchange="order('<?php echo $found[$x]['userid']; ?>','<?php echo $found[$x]['applicant_name']; ?>','<?php echo $found[$x]['id']; ?>');" <?php if($_SESSION["selection_status".$found[$x]['id']] == 1) { echo "checked"; } ?> /></td>
													<td width="10" align="left" valign="top">&nbsp;</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height="200" align="left" valign="top" class="boxcontent">
	
	
	
	
	
														<table cellspacing="0" cellpadding="0" border="0" width="342" height="200">
															<tbody>
																<tr>
																	<td align="center" width="182" valign="top"><br>
																		<img src="/available-staff-image.php?w=79&id=<?php echo $found[$x]['userid']; ?>">
																			<p class="stfname"><?php echo $found[$x]['applicant_name']; ?></p>
																			<p style="text-align: center;">
																				<a href="javascript: resume(<?php echo $found[$x]['userid']; ?>); ">Resume</a>&nbsp;
																				<?php if($found[$x]['applicant_files']) { ?>
																				|&nbsp;<a href="javascript: sample_files(<?php echo $found[$x]['userid']; ?>); ">Portfolio</a>
																				<?php } ?>
																			</p>
																	  </td>
																	<td align="left" width="10" valign="top">&nbsp;</td>
																	<td align="left" width="150" valign="top">
																		<div id="staffdescbox">
																			<h3>SKILLS</h3>
																			<?php echo $found[$x]['skills']; ?>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
	
	
	
	
	
	
										</td>
									</tr>
									<tr>
										<td align="left" valign="top" class="boxfooter">
											<table width="320" height="28" style="margin:auto; font-size:11px; line-height:20px;" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="160"><font color="#FFFFFF"><strong>Applicant ID : </strong><?php echo $found[$x]['userid']; ?></font></td>
													<td width="160" align="right" valign="middle"><font color="#FFFFFF"><?php echo $found[$x]['availability']; ?></font></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>	
							</td>	
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>	

				</td>
				<td>

					<?php 
					$x++; 
					if($x < $total)
					{
					?>				
					<table  border="0" cellspacing="0" cellpadding="0" id="astaff" width="342">
						<tr>
							<td width="342" align="center">
								<table width="342" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="left" valign="top" class="boxheader">
											<table width="342" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="10" align="left" valign="top">&nbsp;</td>
													<td width="152" align="left" valign="middle" nowrap>
														<div id="rate<?php echo $found[$x]['userid']; ?>"><font color="#FFFFFF"><?php echo $found[$x]['sr_pf']; ?></font></div>	
													</td>
													<td width="100" align="left" valign="top" class="selectstaff">select staff <input name="app_name<?php echo $found[$x]['id']; ?>" id="app_id<?php echo $found[$x]['id']; ?>" type="checkbox" value="" onchange="order('<?php echo $found[$x]['userid']; ?>','<?php echo $found[$x]['applicant_name']; ?>','<?php echo $found[$x]['id']; ?>');" <?php if($_SESSION["selection_status".$found[$x]['id']] == 1) { echo "checked"; } ?> /></td>
													<td width="10" align="left" valign="top">&nbsp;</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height="200" align="left" valign="top" class="boxcontent">
	
	
	
	
	
														<table cellspacing="0" cellpadding="0" border="0" width="342" height="200">
															<tbody>
																<tr>
																	<td align="center" width="182" valign="top"><br>
																		<img src="/available-staff-image.php?w=79&id=<?php echo $found[$x]['userid']; ?>">
																			<p class="stfname"><?php echo $found[$x]['applicant_name']; ?></p>
																			<p style="text-align: center;">
																				<a href="javascript: resume(<?php echo $found[$x]['userid']; ?>); ">Resume</a>&nbsp;
																				<?php if($found[$x]['applicant_files']) { ?>
																				|&nbsp;<a href="javascript: sample_files(<?php echo $found[$x]['userid']; ?>); ">Portfolio</a>
																				<?php } ?>
																			</p>
																	  </td>
																	<td align="left" width="10" valign="top">&nbsp;</td>
																	<td align="left" width="150" valign="top">
																		<div id="staffdescbox">
																			<h3>SKILLS</h3>
																			<?php echo $found[$x]['skills']; ?>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
	
	
	
	
	
	
										</td>
									</tr>
									<tr>
										<td align="left" valign="top" class="boxfooter">
											<table width="320" height="28" style="margin:auto; font-size:11px; line-height:20px;" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="160"><font color="#FFFFFF"><strong>Applicant ID : </strong><?php echo $found[$x]['userid']; ?></font></td>
													<td width="160" align="right" valign="middle"><font color="#FFFFFF"><?php echo $found[$x]['availability']; ?></font></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>	
							</td>	
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>				
					<?php } ?>
				
				
				</td>
			</tr>		
				<?php
						$adjuster = $adjuster."<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";
					}
				}
				?>	
			
			
			
			<tr>
				<td align="right" colspan="2">
						<table width="100%">
							<tr>
								<td width="70%"><?php echo $currency_option; ?><?php echo $staff_rate_option; ?></td>
								<td align="right" width="30%"><?php echo $pages; ?></td>
							</tr>
						</table>
				</td>	
			</tr>			
		</table>		
		<!--ENDED - LIST CONTENT-->
		
		
		
		
		
			
		</td>			
	</tr>		
	<tr>
		<td width="10%" valign="top">
			<div style="background:#2A629F; border:#2A629F outset 1px; padding:3px;"><strong><font color="#FFFFFF">Categories</font></strong></div>
		</td>
	</tr>	
	<tr>
		<td width="10%" valign="top" align="center">
		
		
					
						<table border="0" width="100" height="100%"><tr><td align="right" valign="top" height="100%">
						<div id="staffclass">
							<!--MARKETING-->
							<h4><img src="../images/avail-staff-btn-marketing-min.jpg" id="market1" onClick="listmax('asmarketingmin','market1', 'market2')"/><img src="../images/avail-staff-btn-marketing-max.jpg" id="market2" onClick="listmin('asmarketingmin','market2', 'market1')" style="display:none;" /></h4>
							<ul style="display:none;" id="asmarketingmin">
							<?php
							$counter = 0;
							//category_id = '13' OR 
							//category_id = '38'
							$sql="SELECT category_id, category_name FROM job_category WHERE 
							category_id = '7' OR 
							category_id = '4' OR 
							category_id = '10' OR 
							category_id = '37' 
							ORDER BY category_name";
							$category = mysql_query($sql);
							while(list($category_id, $category_name)=mysql_fetch_array($category))
							{
								if($counter > 1) echo "<ul></ul>";
								echo "<h3>$category_name</h3>";
								$sql="SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id='$category_id' ORDER BY sub_category_name";
								$sub_category = mysql_query($sql);
								while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($sub_category))
								{
									$queryCount = "SELECT COUNT(j.userid) FROM job_sub_category_applicants j, personal p WHERE j.userid = p.userid AND j.sub_category_id ='$sub_category_id' AND j.ratings='0'" ;
									$res =mysql_query($queryCount);
									list($count)=mysql_fetch_array($res);
									if($count > 0)
									{
										if($sub_category_id == @$_REQUEST["id"])
										{
											echo "<table bgcolor='#CCCCCC' width=100%><tr><td align='right'><li>$sub_category_name&nbsp;(".$count.")</li></td></tr></table>";				
										}
										else
										{				
											echo "<li><a href=\"?to=".$to."&sr=$sr&cl=$cl&c=1&id=$sub_category_id\">$sub_category_name&nbsp;(".$count.")</a></li>";
										}
									}	
								}
								$counter++;
							}
							?>
							</ul>
							<!--END MARKETING-->
						
						
							<!--OFFICE ADMIN-->
							<h4><img src="../images/avail-staff-btn-admin-min.jpg" id="admin1" onClick="listmax('asadminmin','admin1', 'admin2')"/><img src="../images/avail-staff-btn-admin-max.jpg" id="admin2" onClick="listmin('asadminmin','admin2', 'admin1')" style="display:none;" /></h4>
							<ul style="display:none;" id="asadminmin">
							<?php
							$counter = 0;
							//category_id = '42' 
							//category_id = '15' OR 
							//category_id = '31' OR 
							$sql="SELECT category_id, category_name FROM job_category WHERE 
							category_id = '12' OR 
							category_id = '5' OR 
							category_id = '52' 
							ORDER BY category_name";
							$category = mysql_query($sql);
							while(list($category_id, $category_name)=mysql_fetch_array($category))
							{
								if($counter > 1) echo "<ul></ul>";
								echo "<h3>$category_name</h3>";
								$sql="SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id='$category_id' ORDER BY sub_category_name";
								$sub_category = mysql_query($sql);
								while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($sub_category))
								{
									$queryCount = "SELECT COUNT(j.userid) FROM job_sub_category_applicants j, personal p WHERE j.userid = p.userid AND j.sub_category_id ='$sub_category_id' AND j.ratings='0'" ;
									$res =mysql_query($queryCount);
									list($count)=mysql_fetch_array($res);
									if($count > 0)
									{				
										if($sub_category_id == @$_REQUEST["id"])
										{
											echo "<table bgcolor='#CCCCCC' width=100%><tr><td align='right'><li>$sub_category_name&nbsp;(".$count.")</li></td></tr></table>";				
										}
										else
										{
											echo "<li><a href=\"?to=".$to."&sr=$sr&cl=$cl&c=2&id=$sub_category_id\">$sub_category_name&nbsp;(".$count.")</a></li>";					
										}
									}	
								}
								$counter++;
							}
							?>
							</ul>
							<!--END OFFICE ADMIN-->
						
						
							<!--OFFICE IT-->
							<h4><img src="../images/avail-staff-btn-it-min.jpg" id="it1" onClick="listmax('asitmax','it1', 'it2')" style="display:none;"/><img src="../images/avail-staff-btn-it-max.jpg" id="it2" onClick="listmin('asitmax','it2', 'it1')"  /></h4>
							<div id="asitmax">
							<?php
							$counter = 0;
							//category_id = '29' OR 
							//category_id = '9' OR 
							//category_id = '31'
							$sql="SELECT category_id, category_name FROM job_category WHERE 
							category_id = '2' OR 
							category_id = '48' OR 
							category_id = '32' 
							ORDER BY category_name";
							$category = mysql_query($sql);
							while(list($category_id, $category_name)=mysql_fetch_array($category))
							{
								echo "<h3>$category_name</h3>";
								echo "<ul>";
								$sql="SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id='$category_id' ORDER BY sub_category_name";
								$sub_category = mysql_query($sql);
								while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($sub_category))
								{
									$queryCount = "SELECT COUNT(j.userid) FROM job_sub_category_applicants j, personal p WHERE j.userid = p.userid AND j.sub_category_id ='$sub_category_id' AND j.ratings='0'" ;
									$res =mysql_query($queryCount);
									list($count)=mysql_fetch_array($res);		
									if($count > 0)
									{					
										if($sub_category_id == @$_REQUEST["id"])
										{
											echo "<table bgcolor='#CCCCCC' width=100%><tr><td align='right'><li>$sub_category_name&nbsp;(".$count.")</li></td></tr></table>";				
										}
										else
										{				
											echo "<li><a href=\"?to=".$to."&sr=$sr&cl=$cl&c=3&id=$sub_category_id\">$sub_category_name&nbsp;(".$count.")</a></li>";
										}	
									}	
								}
								echo "</ul>";
								$counter++;
							}
							?>	
							</div>
							<!--END IT-->
						
							
							<!--OTHER ROLES-->
							<h4><img src="../images/avail-staff-btn-other-min.jpg" id="other1" onClick="listmax('asothersmin','other1', 'other2')"/><img src="../images/avail-staff-btn-other-max.jpg" id="other2" onClick="listmin('asothersmin','other2', 'other1')" style="display:none;" /></h4>
							<ul style="display:none;" id="asothersmin">
							<?php
							$counter = 0;
							$sql="SELECT category_id, category_name FROM job_category WHERE 
							category_id = '20' OR 
							category_id = '11'
							ORDER BY category_name";
							$category = mysql_query($sql);
							while(list($category_id, $category_name)=mysql_fetch_array($category))
							{
								echo "<h3>$category_name</h3>";
								echo "<ul>";
								$sql="SELECT sub_category_id, sub_category_name FROM job_sub_category WHERE category_id='$category_id' ORDER BY sub_category_name";
								$sub_category = mysql_query($sql);
								while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($sub_category))
								{
									$queryCount = "SELECT COUNT(j.userid) FROM job_sub_category_applicants j, personal p WHERE j.userid = p.userid AND j.sub_category_id ='$sub_category_id' AND j.ratings='0'" ;
									$res =mysql_query($queryCount);
									list($count)=mysql_fetch_array($res);		
									if($count > 0)
									{					
										if($sub_category_id == @$_REQUEST["id"])
										{
											echo "<table bgcolor='#CCCCCC' width=100%><tr><td align='right'><li>$sub_category_name&nbsp;(".$count.")</li></td></tr></table>";				
										}
										else
										{				
											echo "<li><a href=\"?to=".$to."&sr=$sr&cl=$cl&c=4&id=$sub_category_id\">$sub_category_name&nbsp;(".$count.")</a></li>";
										}	
									}	
								}
								echo "</ul>";
								$counter++;
							}
							?>
							</ul>
							<!--END OTHER ROLES-->	
							<?php echo $adjuster; ?>
						</div>
						</td></tr></table>
						
						
						
						
		</td>
	</tr>			
</table>
</td>
</tr>
</table>
<? include 'footer.php';?>
</form>	
</body>
</html>