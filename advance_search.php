<?php
	putenv("TZ=Australia/Sydney");
	
	//ADVANCE SEARCH
	$page_type = @$_GET["page_type"];
	$month_a = @$_POST["month_a"];
	$day_a = @$_POST["day_a"];
	$year_a = @$_POST["year_a"];
	$month_b = @$_POST["month_b"];
	$day_b = @$_POST["day_b"];
	$year_b = @$_POST["year_b"];
	$category = @$_POST["category"];
	$key = @$_POST["key"];
	$by = @$_POST["by"];
	$date_check = @$_POST["date_check"];
	$view = @$_POST["view"];
	$rating = @$_POST["rating"];

	if(@$_GET["total_views"] == "" || @$_GET["total_views"] == NULL)
	{
		$total_views = 0;
	}
	else
	{
		$total_views = $_GET["total_views"];
	}
	
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
	
	if($rating== "" || $rating== NULL){
		$rating = @$_GET["rating"];
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
	}
	
	if($view== "" || $view== NULL){
		$view = @$_GET["view"];
	}
		
	$page = @$_GET["page"];
	if($page== "" || $page== NULL){
		$page = 0;
	}
	else
	{
		$page = @$_GET["page"];
	}			
	//ENDED
	
	
	
	//QUICK SEARCH
	$rating_a = @$_POST["rating_a"];
	if($rating_a== "" || $rating_a== NULL){
		$rating_a = @$_GET["rating_a"];
	}	
	
	$rt = @$_POST['rt'];
	if($rt == "" || $rt == NULL){
		$rt = @$_GET["rt"];
	}
	
	$view_a = @$_POST["view_a"];
	if($view_a== "" || $view_a== NULL){
		$view_a = @$_GET["view_a"];
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
					$a_1 = mktime(0, 0, 0, 1, 11, 2006);
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



	require_once("conf/connect.php");
	$db=connsql();
	$counter = 0;	
	if($search_type == "quick")
	{
		//PAGE
		if($page == 0 || $page == NULL)
		{
			if($view_a == "Any" || $view_a == "" || $view_a == NULL)
			{
				$condition = "";
			}
			else
			{
				$condition = "status='$view_a'";
			}
		}
		else
		{
			if($page_type == "next" || $page_type == "Next" || $page_type == "" || $page_type == NULL)
			{
				if($view_a == "Any")
				{
					$condition = "id > '$page'";
				}
				else
				{
					$condition = "id > '$page' AND $status='$view_a'";
				}		
			}
			else
			{
				if($view_a == "Any")
				{
					$condition = "id < '$page'";
				}
				else
				{
					$condition = "id < '$page' AND $status='$view_a'";
				}		
			}	
		}		
		//END PAGE	
		
		
		if($rating_a == "Any")
		{
			if($condition == "")
			{
				$condition = "(DATE(timestamp) BETWEEN '$a_' AND '$b_')";		
			}
			else
			{
				$condition = $condition." AND (DATE(timestamp) BETWEEN '$a_' AND '$b_')";		
			}	
		}
		else
		{
			if($condition == "")
			{
				$condition = "rating='$rating_a' AND (DATE(timestamp) BETWEEN '$a_' AND '$b_')";
			}
			else
			{
				$condition = $condition." AND rating='$rating_a' AND (DATE(timestamp) BETWEEN '$a_' AND '$b_')";	
			}			
		}	
		$q = "SELECT * FROM leads WHERE $condition ORDER BY id LIMIT 20";
		$c = mysql_query($q);															
	}
	
	
	
	elseif($search_type == "advance")
	{
		//PAGE
		$page_type = @$_GET["page_type"];
		if($page == 0 || $page == NULL)
		{
			if($view == "Any" || $view == "" || $view == NULL)
			{
				$condition = "";
			}
			else
			{
				$condition = "status='$view'";
			}
		}
		else
		{
			if($page_type == "next" || $page_type == "Next" || $page_type == "" || $page_type == NULL)
			{
				if($view == "Any")
				{
					$condition = "id > '$page'";
				}
				else
				{
					$condition = "id > '$page' AND $status='$view'";
				}
			}
			else
			{
				if($view_a == "Any")
				{
					$condition = "id < '$page'";
				}
				else
				{
					$condition = "id < '$page' AND $status='$view'";
				}		
			}	
		}		
		//END PAGE	
		
			
		$date_a = $year_a."-".$month_a."-".$day_a;
		$date_b = $year_b."-".$month_b."-".$day_b;
		
		//BY
		switch($by)
		{
			case "lname":
				if($condition == "")
				{
					$condition = "lname LIKE '%$key%'";
				}
				else
				{
					$condition = $condition." AND lname LIKE '%$key%'";
				}				
				break;
			case "fname":
				if($condition == "")
				{
					$condition = "fname LIKE '%$key%'";
				}
				else
				{
					$condition = $condition." AND fname LIKE '%$key%'";
				}				
				break;
			case "company_name":
				if($condition == "")
				{
					$condition = "company_name LIKE '%$key%'";
				}
				else
				{
					$condition = $condition." AND company_name LIKE '%$key%'";
				}				
				break;
			case "company_address":
				if($condition == "")
				{
					$condition = "company_address LIKE '%$key%'";
				}
				else
				{
					$condition = $condition." AND company_address LIKE '%$key%'";
				}					
				break;
			case "email":
				if($condition == "")
				{
					$condition = "email LIKE '%$key%'";
				}
				else
				{
					$condition = $condition." AND email LIKE '%$key%'";
				}			
				break;
			case "leads_country":
				if($condition == "")
				{
					$condition = "leads_country LIKE '%$key%'";
				}
				else
				{
					$condition = $condition." AND leads_country LIKE '%$key%'";
				}			
				break;
		}
		//END BY
		
		//KEY DATE
		if($date_check == "" || $date_check == NULL)
		{
			if($condition == "")
			{
				$condition = "(DATE(timestamp) BETWEEN '$date_a' AND '$date_b')";
			}
			else
			{
				$condition = $condition." AND (DATE(timestamp) BETWEEN '$date_a' AND '$date_b')";
			}
		
			
		}
		//END KEY DATE		
				
		//RATING
		if($rating != "Any")
		{
			if($condition == "")
			{
				$condition = "rating='$rating'";
			}
			else
			{
				$condition = $condition." AND rating='$rating'";
			}
		}
		//END RATING
		
		if($condition == "" || $condition == NULL)
		{
			$q = "SELECT * FROM leads ORDER BY id LIMIT 20";
		}
		else
		{
			$q = "SELECT * FROM leads WHERE $condition ORDER BY id LIMIT 20";
		}
		$c = mysql_query($q);	
	} 
	else
	{
		$title = "All time (".date("M d, Y").")";	
		if(@$condition == "" || @$condition == NULL)
		{
			$q = "SELECT * FROM leads ORDER BY id LIMIT 20";
		}
		else	
		{
			$q = "SELECT * FROM leads WHERE $condition ORDER BY id LIMIT 20";			
		}
		$c = mysql_query($q);			
	}
	
	//RESULT
	$i = 0;
	$page_prev = 0;
	$result_counter = 0;
	while ($row = @mysql_fetch_assoc($c)) 
	{
		if($i == 1) $page_prev = $row["id"];
		$i++;

		$name[$i] = $row["fname"]." ".$row["lname"];
		$company_name[$i] = $row["company_name"];
		$email[$i] = $row["email"];
		$leads_country[$i] = $row["leads_country"];
		$arr_id[$i] = $row["id"];
		$timestamp[$i] = $row["timestamp"];
		$tracking_no[$i] = $row["tracking_no"];
		$leads_id[$i] = $row["agent_id"];

		$result_counter++;
		$page = $row["id"];
		
		if($page_type == "next" || $page_type == "Next")
		{
			$total_views = $total_views + 1;
		}
		elseif($page_type == "previous" || $page_type == "Previous")
		{
			if($total_views > 0) $total_views = $total_views - 1;
		}
		else
		{
			$total_views = $total_views + 1;
		}
	}
	//END RESULT
?>




<html>
<head>
<title>Notes List</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<script type="text/javascript">

		var curSubMenu = '';
		
		function view_notes(id) 
		{
			previewPath = "leads_remarks.php?id="+id;
			window.open(previewPath,'_blank','width=500,height=400,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
	
		function showSubMenu(menuId)
		{
			if (curSubMenu!='') 
				hideSubMenu();
			
			eval('document.all.'+menuId).style.visibility='visible';
			curSubMenu=menuId;
		}
		
		function hideSubMenu()
		{
			eval('document.all.'+curSubMenu).style.visibility='hidden';
			curSubMenu='';
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
		
		function by_(check)
		{
			if(check == "Any")
				document.getElementById('key_id').disabled = true;
			else
				document.getElementById('key_id').disabled = false;				
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
</head>
<body bgcolor="#CCCCCC">
											<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#666666>
												<tr>
													<td bgcolor=#FFFFFF valign="top" width="90%">	
																	<form action="?rating_a=<?php echo $rating_a; ?>&rating=<?php echo $rating; ?>&total_views=0&view_a=<?php echo @$view_a; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&by=<?php echo $by; ?>" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">																								
																	<table>
																		<tr>
																			<td colspan="4"><strong>Quick Search</strong><br /><br /></td>
																		</tr>																	
																		<tr>
																			<td><font size="1"><em>Date</em></font></td>
																			<td><font size="1"><em>Status</em></font></td>
																			<td><font size="1"><em>Rating</em></font></td>
																			<td></td>
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
																						<select name="view_a" id="view_a_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																							<?php
																								switch($view_a)
																								{
																									case "New Leads":
																										echo "<option value='New Leads' selected>New Leads</option>";
																										break;
																									case "Keep in Touch":
																										echo "<option value='Keep in Touch' selected>Keep in Touch</option>";
																										break;
																									case "Follow Up":
																										echo "<option value='Follow Up' selected>Follow Up</option>";
																										break;
																									case "Client":
																										echo "<option value='Client' selected>Client</option>";
																										break;																								
																									case "Active":
																										echo "<option value='Active' selected>Active</option>";
																										break;		
																									case "In Active":
																										echo "<option value='In Active' selected>In Active</option>";
																										break;																																																		
																									default:
																										echo "<option value='Any' selected>Any</option>";
																										break;
																										
																								}
																							?>
																							<option value='New Leads'>New Leads</option>
																							<option value='Keep in Touch'>Keep in Touch</option>
																							<option value='Follow Up'>Follow Up</option>
																							<option value='Client'>Client</option>
																							<option value='Active'>Active</option>
																							<option value='In Active'>In Active</option>
																						</select>																					
																			</td>
																			<td>
																						<select name="rating_a" id="rating_a_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																							<?php
																								switch($rating_a)
																								{
																									case "1":
																										echo "<option value='1' selected>1</option>";
																										break;
																									case "2":
																										echo "<option value='2' selected>2</option>";
																										break;
																									case "3":
																										echo "<option value='3' selected>3</option>";
																										break;				
																									case "4":
																										echo "<option value='4' selected>4</option>";
																										break;																													
																									case "5":
																										echo "<option value='5' selected>5</option>";
																										break;																												
																									default:
																										echo "<option value='Any' selected>Any</option>";
																										break;																																																								
																								}
																							?>
																							<option value="1">1</option>
																							<option value="2">2</option>
																							<option value="3">3</option>
																							<option value="4">4</option>
																							<option value="5">5</option>
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
													<td bgcolor=#FFFFFF valign="top" width="90%">
													
														<p><strong>Advance Search</strong></p>
														<form action="?rating_a=<?php echo $rating_a; ?>&rating=<?php echo $rating; ?>&total_views=0&view_a=<?php echo @$view_a; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&by=<?php echo $by; ?>" method="post" name="formtable" onSubmit="return validate(this); ">
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
                                                            <td>Keyword</td>
                                                            <td>
															
																	<table width="0%"  border="0" cellspacing="0" cellpadding="0">
																	  <tr>
																		<td><input type="text" id="key_id" name="key" value="<?php echo $key; ?>" <?php if($by == "Any") echo "disabled"; ?> style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;' disabled></td>
																		<td>&nbsp;by&nbsp;</td>
																		<td>
																				<select name="by" id="by_id" onChange="javascript: by_(this.value);" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																					<?php
																						switch($by)
																						{
																							case "lname":
																								echo "<option value='lname' selected>Last Name</option>";
																								break;
																							case "fname":
																								echo "<option value='fname' selected>First Name</option>";
																								break;
																							case "company_name":
																								echo "<option value='company_name' selected>Company Name</option>";
																								break;					
																							case "company_address":
																								echo "<option value='company_address' selected>Company Address</option>";
																								break;		
																							case "email":
																								echo "<option value='email' selected>Email</option>";
																								break;		
																							case "leads_country":
																								echo "<option value='leads_country' selected>Country</option>";
																								break;		
																							default:
																								echo "<option value='Any' selected>Any</option>";
																								break;																																																								
																						}
																					?>
																					<option value='lname'>Last Name</option>
																					<option value='fname'>First Name</option>
																					<option value='company_name'>Company Name</option>
																					<option value='company_address'>Company Address</option>
																					<option value='email'>Email</option>
																				</select>																		
																		</td>
																			<td>&nbsp;Rating&nbsp;</td>
																			<td>
																				<select name="rating" id="rating_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																					<?php
																						switch($rating)
																						{
																							case "1":
																								echo "<option value='1' selected>1</option>";
																								break;
																							case "2":
																								echo "<option value='2' selected>2</option>";
																								break;
																							case "3":
																								echo "<option value='3' selected>3</option>";
																								break;				
																							case "4":
																								echo "<option value='4' selected>4</option>";
																								break;																													
																							case "5":
																								echo "<option value='5' selected>5</option>";
																								break;																												
																							default:
																								echo "<option value='Any' selected>Any</option>";
																								break;																																																								
																						}
																					?>
																					<option value="1">1</option>
																					<option value="2">2</option>
																					<option value="3">3</option>
																					<option value="4">4</option>
																					<option value="5">5</option>
																				</select>																																			
																			</td>																			
																	  </tr>
																	</table>
																
															</td>
                                                          </tr>	
                                                          <tr>
                                                            <td>View</td>
                                                            <td>
															
																	<table width="0%"  border="0" cellspacing="0" cellpadding="0">
																	  <tr>
																		<td>
																				<select name="view" id="view_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																					<?php
																						switch(@$view)
																						{
																							case "New Leads":
																								echo "<option value='New Leads' selected>New Leads</option>";
																								break;
																							case "Keep in Touch":
																								echo "<option value='Keep in Touch' selected>Keep in Touch</option>";
																								break;
																							case "Follow Up":
																								echo "<option value='Follow Up' selected>Follow Up</option>";
																								break;
																							case "Client":
																								echo "<option value='Client' selected>Client</option>";
																								break;																								
																							case "Active":
																								echo "<option value='Active' selected>Active</option>";
																								break;		
																							case "In Active":
																								echo "<option value='In Active' selected>In Active</option>";
																								break;																																																		
																							default:
																								echo "<option value='Any' selected>Any</option>";
																								break;
																								
																						}
																					?>
																					<option value='New Leads'>New Leads</option>
																					<option value='Keep in Touch'>Keep in Touch</option>
																					<option value='Follow Up'>Follow Up</option>
																					<option value='Client'>Client</option>
																					<option value='Active'>Active</option>
																					<option value='In Active'>In Active</option>
																				</select>																			
																		</td>
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
													<td valign="top" bgcolor="#FFFFFF">
														<table width=100% cellspacing=1 border=0 cellpadding=5 bgcolor=#cccccc>
															<tr>
																<td colspan="7" bgcolor=#FFFFFF>
																	<strong>
																		<?php 
																			if(@isset($_POST["advance_search"]))
																				echo @$view;	
																			else
																				echo @$view_a; 
																		?>
																		<br /><br />
																	</strong></td>
															</tr>														
															<tr>
																<td colspan="7" bgcolor=#FFFFFF>
																	<table>
																		<tr>
																			<td width="100%">
																				<i>
																					<?php
																						if(@isset($_POST["advance_search"]))
																							echo "Showing Result between: ".$date_a." & ".$date_b; 
																						else
																							echo "Showing Result for: ".$title; 
																					?>
																				</i>
																			</td>
																			<td align="right">
																				<a href="?total_views=<?php echo $total_views; ?>&search_type=<?php echo $search_type; ?>&page_type=previous&page=<?php echo $page_prev; ?>&view_a=<?php echo @$view_a; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&type=<?php echo $type; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>">Previous</a>&nbsp;/&nbsp;<a href="?total_views=<?php echo $total_views; ?>&search_type=<?php echo $search_type; ?>&page_type=next&page=<?php echo $page; ?>&view_a=<?php echo @$view_a; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&type=<?php echo $type; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>">Next</a>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>														
															<tr>
																<td width="0%"><strong>ID</strong></td>
																<td width="20%"><strong>Name</strong></td>
																<td width="20%"><strong>Email</strong></td>
																<td width="30%"><strong>Company&nbsp;Name</strong></td>
																<td width="300"><strong>Date&nbsp;Registered</strong></td>
																<td width="15%"><strong>Promotional&nbsp;Code</strong></td>
																<td width="15%" align="center"><strong>Remarks</strong></td>
															</tr>
																	<?php				
																	for($i = 1; $i <= $result_counter; $i++)
																	{
																		$l_id = $arr_id[$i]; 
																		$r = mysql_query("SELECT id FROM leads_remarks WHERE leads_id='$l_id'");	
																		$r_result = mysql_num_rows($r);												
																	?>
															<tr>
																<td bgcolor="#FFFFFF"><strong><?php echo $arr_id[$i]; ?></strong></td>
																<td bgcolor="#FFFFFF"><strong><?php echo $name[$i]; ?></strong></td>
																<td bgcolor="#FFFFFF"><?php echo $email[$i]; ?></td>
																<td bgcolor="#FFFFFF"><?php echo $company_name[$i]; ?></td>
																<td bgcolor="#FFFFFF"><?php echo $timestamp[$i]; ?></td>
																<td bgcolor="#FFFFFF"><?php echo $tracking_no[$i]; ?></td>
																<td bgcolor="#FFFFFF" align="center"><a href="javascript: view_notes(<?php echo $arr_id[$i]; ?>); "><strong><i><?php echo $r_result; ?></i></strong></a></td>
															</tr>
																	<?php
																	}	
																	?>
															<tr>
																<td colspan="7">
																	<table>
																		<tr>
																			<td width="100%"><strong>Total Showing: <?php echo $result_counter; ?></strong></td>
																			<td align="right">
																				<a href="?total_views=<?php echo $total_views; ?>&search_type=<?php echo $search_type; ?>&page_type=previous&page=<?php echo $page_prev; ?>&view_a=<?php echo @$view_a; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&type=<?php echo $type; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>">Previous</a>&nbsp;/&nbsp;<a href="?total_views=<?php echo $total_views; ?>&search_type=<?php echo $search_type; ?>&page_type=next&page=<?php echo $page; ?>&view_a=<?php echo @$view_a; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&type=<?php echo $type; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>">Next</a>																		
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
													</table>
												</td>
											</tr>								
										</table>	
										</form>	

</body>
</html>
