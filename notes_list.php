<?php
	putenv("TZ=Australia/Sydney");
	
	//ADVANCE SEARCH
	$month_a = @$_POST["month_a"];
	$day_a = @$_POST["day_a"];
	$year_a = @$_POST["year_a"];
	$month_b = @$_POST["month_b"];
	$day_b = @$_POST["day_b"];
	$year_b = @$_POST["year_b"];
	$category = @$_POST["category"];
	$key = @$_POST["key"];
	$type = @$_POST["type"];
	$date_check = @$_POST["date_check"];
	$key_check = @$_POST["key_check"];
	$view = @$_POST["view"];

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
	
	if($type== "" || $type== NULL){
		$type = @$_GET["type"];
	}	
	
	if($key== "" || $key== NULL){
		$key = @$_GET["key"];
	}	
	
	if($type== "" || $type== NULL){
		$type = @$_GET["type"];
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
	
	$page = @$_GET["page"];
	if($page== "" || $page== NULL){
		$page = 0;
	}
	else
	{
		$page = @$_GET["page"];
	}			
	//ENDED
	
	//STATUS
	if($view=="Archive") { $status = 1; } else { $status = 0; }
	//END STATUS
	
	//PAGE
	$page_type = @$_GET["page_type"];
	if($page == 0)
	{
		$condition = "status='$status'";
	}
	else
	{
		if($page_type == "next" || $page_type == "Next" || $page_type == "" || $page_type == NULL)
		{
			$condition = "id > '$page' AND $status='$status'";
		}
		else
		{
			$condition = "id < '$page' AND $status='$status'";
		}	
	}		
	//END PAGE
	
	
	
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
?>








<?php	
	require_once("conf/connect.php");
	$db=connsql();
	$counter = 0;	
												
	if($search_type == "quick")
	{
		if($view_a=="Issues") { $status = 0; } else { $status = 1; }	
		if($category_a == "Any")
		{
			$condition = $condition." AND (date_posted BETWEEN '$a_' AND '$b_')";
		}
		else
		{
			$condition = $condition." AND category='$category_a' AND (date_posted BETWEEN '$a_' AND '$b_')";
		}	
		$q = "SELECT * FROM tb_calendar_notes WHERE $condition ORDER BY id LIMIT 20";
		$c = mysql_query($q);															
	}
	elseif($search_type == "advance")
	{
		$date_a = $year_a."-".$month_a."-".$day_a;
		$date_b = $year_b."-".$month_b."-".$day_b;
		
		//KEY CHECK
		if($key_check == "" || $key_check == NULL)
		{
			$condition = $condition." AND user_id LIKE '%$key%'";
		}
		//END KEY CHECK
		
		//KEY DATE
		if($date_check == "" || $date_check == NULL)
		{
			$condition = $condition." AND (date_posted BETWEEN '$date_a' AND '$date_b')";
		}
		//END KEY DATE		
		
		//KEY CATEGORY
		if($category != "Any")
		{
			$condition = $condition." AND category='$category'";
		}
		//END CATEGORY
		
		//KEY TYPE
		if($type != "Any")
		{
			$condition = $condition." AND type='$type'";
		}
		//END TYPE		
		
		$q = "SELECT * FROM tb_calendar_notes WHERE $condition ORDER BY id LIMIT 20";
		$c = mysql_query($q);	
	} 
	else
	{
		$title = "All time (".date("M d, Y").")";	
		$q = "SELECT * FROM tb_calendar_notes WHERE $condition ORDER BY id LIMIT 20";
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
		$r_id = $row["id"];
		$r = mysql_query("SELECT id FROM tb_remarks WHERE notes_id='$r_id'");	
		$r_result = mysql_num_rows($r);												
		$a_name = $row["user_id"];

		$arr_category[$i] = $row["category"];
		$arr_date_posted[$i] = $row["date_posted"];
		$arr_user_id[$i] = $row["user_id"];
		
		$temp = str_split($row["notes"],30);
		$arr_temp_notes[$i] = $temp[0]."...";
		$arr_notes[$i] = $row["notes"];
		
		$arr_type[$i] = $row["type"];
		$arr_id[$i] = $row["id"];
																		
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
			previewPath = "notes_details.php?id="+id;
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
</head>
<body bgcolor="#CCCCCC">
											<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#666666>
												<tr>
													<td bgcolor=#FFFFFF valign="top" width="90%">		
																	<form action="?total_views=0&view_a=<?php echo @$view_a; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&type=<?php echo $type; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">											
																	<strong>Quick Search</strong><br /><br />
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
															<select name="category_a" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																<?php
																	switch($category_a)
																	{
																		case "Affiliate Issue":
																			echo "<option value='Affiliate Issue'>Affiliate Issue</option>";
																			break;
																		case "Business Partner Issue":
																			echo "<option value='Business Partner Issue' selected>Business Partner Issue</option>";
																			break;
																		case "RSSC IT System":
																			echo "<option value='RSSC IT System' selected>RSSC IT System</option>";
																			break;
																		case "Customer Care Issue":
																			echo "<option value='Customer Care Issue' selected>Customer Care Issue</option>";
																			break;
																		case "Sub Contractor Issue":
																			echo "<option value='Sub Contractor Issue' selected>Sub Contractor Issue</option>";
																			break;
																		case "Client Tax Invoice Issue":
																			echo "<option value='Client Tax Invoice Issue' selected>Client Tax Invoice Issue</option>";
																			break;
																		case "Sub Con Invoice Issue":
																			echo "<option value='Sub Con Invoice Issue' selected>Sub Con Invoice Issue</option>";
																			break;
																		case "Commission Issue":
																			echo "<option value='Commission Issue' selected>Commission Issue</option>";
																			break;
																		case "Staff Replacement Issue":
																			echo "<option value='Staff Replacement Issue' selected>Staff Replacement Issue</option>";
																			break;
																		case "Internet Connection Issue":
																			echo "<option value='Internet Connection Issue' selected>Internet Connection Issue</option>";
																			break;
																		case "VOIP Phone Issues":
																			echo "<option value='VOIP Phone Issues' selected>OIP Phone Issues</option>";
																			break;
																		case "Other":
																			echo "<option value='Other' selected>Other</option>";
																			break;					
																		default:
																			echo "<option value='Any' selected>Any</option>";
																			break;																																																								
																	}
																?>
																<option value='Any'>Any</option>
																<option value='Affiliate Issue'>Affiliate Issue</option>
																<option value='Business Partner Issue'>Business Partner Issue</option>																
																<option value="RSSC IT System">RSSC IT System</option>
																<option value="Customer Care Issue">Customer Care Issue</option>
																<option value="Sub Contractor Issue">Sub Contractor Issue</option>
																<option value="Client Tax Invoice Issue">Client Tax Invoice Issue</option>
																<option value="Sub Con Invoice Issue">Sub Con Invoice Issue</option>
																<option value="Commission Issue">Commission Issue</option>
																<option value="Staff Replacement Issue">Staff Replacement Issue</option>
																<option value="Internet Connection Issue">Internet Connection Issue</option>
																<option value="VOIP Phone Issues">VOIP Phone Issues</option>
															</select>		
																				<select name="view_a" id="view_id_a" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																					<?php
																						switch($view_a)
																						{
																							case "Issues":
																								echo "<option value='Issues' selected>Issues</option>";
																								break;
																							case "Archive":
																								echo "<option value='Archive' selected>Archive</option>";
																								break;
																							default:
																								echo "<option value='Issues' selected>Issues</option>";
																								break;
																								
																						}
																					?>
																					<option value="Issues">Issues</option>
																					<option value="Archive">Archive</option>
																				</select>																	
															<input type="submit" value="View Result" name="quick_search" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>	
															</form>
													</td>
												</tr>
												
												
												
												
												<tr>
													<td bgcolor=#FFFFFF valign="top" width="90%">
													
														<p><strong>Advance Search</strong></p>
														<form action="?total_views=0&view_a=<?php echo @$view_a; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&category=<?php echo $category; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&type=<?php echo $type; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>" method="post" name="formtable" onSubmit="return validate(this); ">
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
																						switch($category)
																						{
																							case "Affiliate Issue":
																								echo "<option value='Affiliate Issue'>Affiliate Issue</option>";
																								break;
																							case "Business Partner Issue":
																								echo "<option value='Business Partner Issue</option>";
																								break;
																							case "RSSC IT System":
																								echo "<option value='RSSC IT System' selected>RSSC IT System</option>";
																								break;
																							case "Customer Care Issue":
																								echo "<option value='Customer Care Issue' selected>Customer Care Issue</option>";
																								break;
																							case "Sub Contractor Issue":
																								echo "<option value='Sub Contractor Issue' selected>Sub Contractor Issue</option>";
																								break;
																							case "Client Tax Invoice Issue":
																								echo "<option value='Client Tax Invoice Issue' selected>Client Tax Invoice Issue</option>";
																								break;
																							case "Sub Con Invoice Issue":
																								echo "<option value='Sub Con Invoice Issue' selected>Sub Con Invoice Issue</option>";
																								break;
																							case "Commission Issue":
																								echo "<option value='Commission Issue' selected>Commission Issue</option>";
																								break;
																							case "Staff Replacement Issue":
																								echo "<option value='Staff Replacement Issue' selected>Staff Replacement Issue</option>";
																								break;
																							case "Internet Connection Issue":
																								echo "<option value='Internet Connection Issue' selected>Internet Connection Issue</option>";
																								break;
																							case "VOIP Phone Issues":
																								echo "<option value='VOIP Phone Issues' selected>OIP Phone Issues</option>";
																								break;
																							default:
																								echo "<option value='Any' selected>Any</option>";
																								break;																																																								
																						}
																					?>
																					<option value='Any'>Any</option>
																					<option value='Affiliate Issue'>Affiliate Issue</option>
																					<option value='Business Partner Issue'>Business Partner Issue</option>																
																					<option value="RSSC IT System">RSSC IT System</option>
																					<option value="Customer Care Issue">Customer Care Issue</option>
																					<option value="Sub Contractor Issue">Sub Contractor Issue</option>
																					<option value="Client Tax Invoice Issue">Client Tax Invoice Issue</option>
																					<option value="Sub Con Invoice Issue">Sub Con Invoice Issue</option>
																					<option value="Commission Issue">Commission Issue</option>
																					<option value="Staff Replacement Issue">Staff Replacement Issue</option>
																					<option value="Internet Connection Issue">Internet Connection Issue</option>
																					<option value="VOIP Phone Issues">VOIP Phone Issues</option>
																				</select>															
																			</td>
																			<td>&nbsp;Type&nbsp;</td>
																			<td colspan="7">
																				<select name="type" id="type_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																					<?php
																						switch($type)
																						{
																							case "High":
																								echo "<option value='High' selected>High</option>";
																								break;
																							case "Medium":
																								echo "<option value='Medium' selected>Medium</option>";
																								break;
																							case "Low":
																								echo "<option value='Low' selected>Low</option>";
																								break;					
																							default:
																								echo "<option value='Any' selected>Any</option>";
																								break;																																																								
																						}
																					?>
																					<option value="Any">Any</option>
																					<option value="High">High</option>
																					<option value="Medium">Medium</option>
																					<option value="Low">Low</option>
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
																		<td><i><font size="1">(by Who Made the Note)</font></i></td>
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
																						switch($view)
																						{
																							case "Issues":
																								echo "<option value='Issues' selected>Issues</option>";
																								break;
																							case "Archive":
																								echo "<option value='Archive' selected>Archive</option>";
																								break;
																							default:
																								echo "<option value='Issues' selected>Issues</option>";
																								break;
																								
																						}
																					?>
																					<option value="Issues">Issues</option>
																					<option value="Archive">Archive</option>
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
																<td colspan="6" bgcolor=#FFFFFF>
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
																<td colspan="6" bgcolor=#FFFFFF>
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
																<td width="30%"><strong>Problem/Issue</strong></td>
																<td width="300"><strong>Category&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
																<td width="15%"><strong>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
																<td width="15%"><strong>Remarks</strong></td>
															</tr>
																	<?php				
																	for($i = 1; $i <= $result_counter; $i++)
																	{
																		$r_id = $arr_id[$i]; 
																		$r = mysql_query("SELECT id FROM tb_remarks WHERE notes_id='$r_id'");	
																		$r_result = mysql_num_rows($r);												
																		$a_name = $arr_user_id[$i];
																	?>
															<tr>
																<td bgcolor="#FFFFFF"><strong><?php echo $arr_id[$i]; ?></strong></td>
																<td bgcolor="#FFFFFF"><strong><?php echo $arr_user_id[$i]; ?></strong></td>
																<td onMouseOver="javascript:this.style.background='#F1F1F3'; showSubMenu('notes_<?php echo $i; ?>'); " onMouseOut="javascript:this.style.background='#ffffff'; " bgcolor=#FFFFFF valign="top" width="90%"><?php echo @$arr_temp_notes[$i]; ?><i>(<?php echo $arr_type[$i]; ?> priority)</i><div id="notes_<?php echo $i; ?>" STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'><table bgcolor="#FFFFCC" width="300" cellpadding="5" cellspacing="5"><tr><td align="right"><font size="1"><i>(<a href="javascript: hideSubMenu(); ">Close</a>)</i></font></td></tr><tr><td><font size="1"><?php echo $arr_notes[$i]; ?></font></td></tr></table></div></td>
																<td bgcolor="#FFFFFF"><?php echo $arr_category[$i]; ?></td>
																<td bgcolor="#FFFFFF"><?php echo $arr_date_posted[$i]; ?></td>
																<td bgcolor="#FFFFFF" align="center"><a href="javascript: view_notes(<?php echo $arr_id[$i]; ?>); "><strong><i><?php echo $r_result; ?></i></strong></a></td>
															</tr>
																	<?php
																	}	
																	?>
															<tr>
																<td colspan="6">
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
