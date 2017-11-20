<div id='search_div' STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
	<table cellpadding="1" cellspacing="0" bgcolor="#003366">
		<tr>
			<td>
			<div id="listings_div">
				<table cellpadding="2" cellspacing="2" bgcolor="#FFFF99">
						<td colspan="2">(Keyword: <font color="#FF0000"><strong>ALL</strong> </font> '<em>displays all leads</em>')</td>
					</tr>
					<tr>
						<td colspan="2">
						<input name="key" id="key_id" type="text"
						value="(fname/lname/email)"
						onMouseOut="javascript: if(this.value=='') { this.value='(fname/lname/email)'; } "
						onClick="javascript: if(this.value=='(fname/lname/email)') { this.value=''; } ">
						<input type="button" value="Search" class="button"
						onClick="javascript: SL_query_lead(this.value); ">
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right"><a href="javascript: SL_hideSubMenu(); "><img
						src="../images/action_delete.gif" border="0"> </a></td>
					</tr>
				</table>
			</div></td>
		</tr>
	</table>
</div>
<form enctype="multipart/form-data" id="new-appointment" method="post"
action="?id=<?php echo $id;?>&yearID=<?php
	if (@isset($_SESSION['yearID']))
		echo $_SESSION['yearID'];
 ?>&dayID=<?php
	if (@isset($_SESSION['dayID']))
		echo $_SESSION['dayID'];
 ?>&monthID=<?php
	if (@isset($_SESSION['monthID']))
		echo $_SESSION['monthID'];
 ?>&calendar_type=<?php
	if (@isset($_SESSION['calendar_type']))
		echo $_SESSION['calendar_type'];
 ?>">
	<input type="hidden" name="view_type"
	value="<?php echo $_GET["view_type"]?>" />
	<input type="hidden"
	name="selected_admin" value="<?php echo $_GET["selected_admin"]?>" />
	<table width="840" border="0" bgcolor="#666666" cellpadding="10"
	cellspacing="1">
		<tr>
			<td width="24%" align="left" valign="top" bgcolor="#F1F1F3"><font
			color="#000000"><strong>
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
					<?php

					//if(@$page_sel == "popup")

					//{
					?>

					<tr>
						<td colspan="5">
						<table>
							<?php
							$id = $l_id;
							$candidate_options = "<option value='' selected></option>";
							$temp = "../application_apply_action.php?userid=" . $l_id;
							$get_leads = mysql_query("SELECT DISTINCT j.userid, p.fname, p.lname FROM job_sub_category_applicants j, personal p WHERE j.userid=p.userid AND j.ratings='0' ORDER BY p.fname");
							$counter = 0;
							$is_selected = 0;
							while ($row = @mysql_fetch_assoc($get_leads)) {
								$app_id = $row['userid'];
								if ($app_id == $id) {
									$candidate_options = $candidate_options . "<option value='" . $row['userid'] . "' selected>" . $row['fname'] . ' ' . $row['lname'] . "</option>";
									//echo '<input type="hidden" name="applicant_email" value="'.$row_p['email'].'">';
									//echo '<input type="hidden" name="applicant_full_name" value="'.$row_p['fname'].' '.$row_p['lname'].'">';
									$is_selected = 1;
								} else {
									$candidate_options = $candidate_options . "<option value='" . $row['userid'] . "'>" . $row['fname'] . ' ' . $row['lname'] . "</option>";
								}
							}
							if ($is_selected == 0) {
								$get_per = mysql_query("SELECT userid, lname, fname, email FROM personal WHERE userid='$id' LIMIT 1");
								while ($row_p = @mysql_fetch_assoc($get_per)) {
									$candidate_options = $candidate_options . "<option value='" . $row_p['userid'] . "' selected>" . $row_p['fname'] . ' ' . $row_p['lname'] . "</option>";
									//echo '<input type="hidden" name="applicant_email" value="'.$row_p['email'].'">';
									//echo '<input type="hidden" name="applicant_full_name" value="'.$row_p['fname'].' '.$row_p['lname'].'">';
								}
							}
							?>
							<td>Send&nbsp;Autoresponder:</td>
							<td>
							<select name="autoresponder" id="autoresponder_id"
							<?php echo $text_style_no_height;?>>
								<?php
								if ($counter == 0) {
									echo '<option value="Yes" selected>Yes</option>';
									echo '<option value="No">No</option>';
								} else {
									echo '<option value="Yes" selected>Yes</option>';
									echo '<option value="No">No</option>';
								}
								?>
							</select></td>
							<td>&nbsp;</td>
							<td>Time Zone</td>
							<td>
							<select name="time_zone" id="time_zone_id"
							<?php echo $text_style_no_height;?>
							onchange="javascript: populate_autoresponder(); ">
								<?php
								$is_executed = 0;
								$queryAllTimezone = "SELECT * FROM timezone_lookup ORDER BY timezone";
								$tz_result = $db -> fetchAll($queryAllTimezone);
								foreach ($tz_result as $tz_result) {
									if ($tz_result['timezone'] == "Pacific/Chatham" || $tz_result['timezone'] == "Asia/Kolkata") {
										continue;
									}
									switch($tz_result['timezone']) {
										case "PST8PDT" :
											$admin_timezone_display = "America/San Francisco";
											break;
										case "NZ" :
											$admin_timezone_display = "New Zealand/Wellington";
											break;
										case "NZ-CHAT" :
											$admin_timezone_display = "New Zealand/Chatham_Islands";
											break;
										default :
											$admin_timezone_display = $tz_result['timezone'];
											break;
									}
									if ($default_timezone == $tz_result['timezone']) {
										$is_executed = 1;
										echo "<OPTION VALUE='" . $tz_result['timezone'] . "' SELECTED>" . $default_timezone_display . "</OPTION>";
									} else {
										echo "<OPTION VALUE='" . $tz_result['timezone'] . "'>" . $admin_timezone_display . "</OPTION>";
									}
								}
								if ($is_executed == 0) {
									echo "<OPTION VALUE='' SELECTED></OPTION>";
								}
								?>
							</select></td>
						</table></td>
					</tr>
					<?php //}?>

					<tr>
						<td><font color="#000000"><strong>Subject:</strong> </font></td>
						<td colspan="4" width="0">
						<input name="subject" id="subject"
						type="text" size="105"
						value="<?php echo trim(@$_SESSION['s_name']);?>"
						<?php echo $text_style;?>>
						</td>
					</tr>
					<tr>
						<td scope="row"><font color="#000000"><strong>Location:</strong> </font></td>
						<td>
						<input name="location" type="text" size="50%"
						<?php echo $text_style;?>>
						</td>
						<td>
						<input type="checkbox" id="type_option_id"
						name="type_option" value="online meeting"
						onClick="javascript: ToggleInput(this, 'type_id');">
						</td>
						<td>This&nbsp;is&nbsp;an&nbsp;online&nbsp;meeting&nbsp;using:</td>
						<td width="100%">
						<select name="type" id="type_id"
						<?php echo $text_style_no_height;?>
						onchange="javascript: populate_autoresponder(); " disabled>
							<option value="" selected></option>
							<option value="skype">Skype</option>
							<option value="rschat">RSChat</option>
							<option value="other">Other</option>
						</select></td>
					</tr>
					<tr>
						<td><strong>Assign&nbsp;to:</strong></td>
						<td colspan="4">
						<table>
							<tr>
								<td>
								<SELECT ID="assign_to_id" NAME="assign_to"
								<?php echo $text_style_no_height;?>
								onchange="javascript: get_admin_name(this.value); ">
									<OPTION VALUE="<?php echo $_SESSION['admin_id'];?>"
									selected>Me</OPTION>
									<?php
									$get_a = mysql_query("SELECT admin_id, admin_fname, admin_lname FROM admin WHERE status <> 'REMOVED' AND admin_id NOT IN (67, 134) ORDER BY admin_fname");
									while ($row = @mysql_fetch_assoc($get_a)) {
										echo "<OPTION VALUE='" . $row['admin_id'] . "'>" . $row['admin_fname'] . " " . $row['admin_lname'] . "</OPTION>";
									}
									?>
								</SELECT></td>
								<td><strong>Candidate:</strong></td>
								<td>
								<SELECT ID="leads_id" NAME="leads"
								<?php echo $text_style_no_height;?>
								onchange="javascript: get_applicant_name(this.value); ">
									<?php echo $candidate_options;?>
								</SELECT></td>
								<td><strong>Client:</strong></td>
								<td style="white-space: nowrap"><?php
								if (@isset($client_id)) {
									$result = mysql_query("SELECT fname, lname FROM leads WHERE id='$client_id' LIMIT 1");
									while ($r = mysql_fetch_assoc($result)) {
										$full_name = $r['fname'] . " " . $r['lname'];
									}
								}
								?>
								<input type="hidden" ID="client_id" NAME="client"
								value="<?php echo $client_id;?>" />
								<input type="text"
								id="client_id_display" name="client_display"
								readonly="readonly" value="<?php echo @$full_name;?>"
								<?php echo $text_style;?> />
								<a
								href="javascript: SL_search_lead(); "><img
								src="../images/view.gif" border="0"> </a><span
								style="display: inline-block; vertical-align: middle;">
									<input
									type="checkbox" class="no-require-check" id="initial"
									name="initial" />
									Initial Interview
									<br />
									<input
									type="checkbox" class="no-require-check"
									id="contract_signing" name="contract_signing" />
									Contract
									Signing
									<br />
									<input type="checkbox"
									class="no-require-check" id="new_hire"
									name="new_hire_orientation" />
									New Hire Orientation
									<br />
									<input
									type="checkbox" class="no-require-check" id="meeting"
									name="meeting" />
									Meeting
									<br />
								</span></td>
							</tr>
						</table></td>
					</tr>
				</table> </strong> </font></td>
		</tr>
		<tr>
			<td width="24%" align="left" valign="top" bgcolor="#F1F1F3">
			<table
			width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td><font color="#000000"><strong>Start&nbsp;Time:</strong> </font></td>
					<td>
					<table width="100" border="0">
						<tr>
							<td>Date</td>
							<td>
							<SELECT ID="start_month_id" NAME="start_month"
							<?php echo $text_style_no_height;?>
							onchange="javascript: populate_autoresponder(); ">
								<OPTION VALUE="<?php echo $monthID;?>" selected><?php echo get_string_day($monthID);?></OPTION>
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
							</SELECT></td>
							<td>
							<select id="start_day_id" name="start_day"
							<?php echo $text_style_no_height;?>
							onchange="javascript: populate_autoresponder(); ">
								<option value="<?php echo $dayID;?>" selected><?php echo $dayID;?></option>
								<option value="1">01</option>
								<option value="2">02</option>
								<option value="3">03</option>
								<option value="4">04</option>
								<option value="5">05</option>
								<option value="6">06</option>
								<option value="7">07</option>
								<option value="8">08</option>
								<option value="9">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							</select></td>
							<td>
							<SELECT ID="start_year_id" NAME="start_year"
							<?php echo $text_style_no_height;?>
							onchange="javascript: populate_autoresponder(); ">
								<OPTION VALUE="<?php echo $yearID;?>" selected><?php echo $yearID;?></OPTION>
								<OPTION VALUE="2006">2005</OPTION>
								<OPTION VALUE="2006">2006</OPTION>
								<OPTION VALUE="2007">2007</OPTION>
								<OPTION VALUE="2008">2008</OPTION>
								<OPTION VALUE="2009">2009</OPTION>
								<OPTION VALUE="2009">2010</OPTION>
							</SELECT></td>
							<td>&nbsp;&nbsp;Time</td>
							<td>
							<SELECT ID="start_hour_id" NAME="start_hour"
							<?php echo $text_style_no_height;?>
							onchange="javascript: populate_autoresponder(); ">
								<OPTION VALUE='' SELECTED>Hour</OPTION>
								<OPTION VALUE=1>1 AM</OPTION>
								<OPTION VALUE=2>2 AM</OPTION>
								<OPTION VALUE=3>3 AM</OPTION>
								<OPTION VALUE=4>4 AM</OPTION>
								<OPTION VALUE=5>5 AM</OPTION>
								<OPTION VALUE=6>6 AM</OPTION>
								<OPTION VALUE=7>7 AM</OPTION>
								<OPTION VALUE=8>8 AM</OPTION>
								<OPTION VALUE=9>9 AM</OPTION>
								<OPTION VALUE=10>10 AM</OPTION>
								<OPTION VALUE=11>11 AM</OPTION>
								<OPTION VALUE=12>12 AM</OPTION>
								<OPTION VALUE=13>1 PM</OPTION>
								<OPTION VALUE=14>2 PM</OPTION>
								<OPTION VALUE=15>3 PM</OPTION>
								<OPTION VALUE=16>4 PM</OPTION>
								<OPTION VALUE=17>5 PM</OPTION>
								<OPTION VALUE=18>6 PM</OPTION>
								<OPTION VALUE=19>7 PM</OPTION>
								<OPTION VALUE=20>8 PM</OPTION>
								<OPTION VALUE=21>9 PM</OPTION>
								<OPTION VALUE=22>10 PM</OPTION>
								<OPTION VALUE=23>11 PM</OPTION>
								<OPTION VALUE=24>12 PM</OPTION>
							</SELECT></td>
							<td>
							<select id="start_minute_id" name="start_minute"
							<?php echo $text_style_no_height;?>
							onchange="javascript: populate_autoresponder(); ">
								<option value="" selected>Minute</option>
								<option value="0">00</option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
								<option value="32">32</option>
								<option value="33">33</option>
								<option value="34">34</option>
								<option value="35">35</option>
								<option value="36">36</option>
								<option value="37">37</option>
								<option value="38">38</option>
								<option value="39">39</option>
								<option value="40">40</option>
								<option value="41">41</option>
								<option value="42">42</option>
								<option value="43">43</option>
								<option value="44">44</option>
								<option value="45">45</option>
								<option value="46">46</option>
								<option value="47">47</option>
								<option value="48">48</option>
								<option value="49">49</option>
								<option value="50">50</option>
								<option value="51">51</option>
								<option value="52">52</option>
								<option value="53">53</option>
								<option value="54">54</option>
								<option value="55">55</option>
								<option value="56">56</option>
								<option value="57">57</option>
								<option value="58">58</option>
								<option value="59">59</option>
								<option value="60">60</option>
							</select></td>
						</tr>
					</table></td>
					<td>
					<input type="checkbox" id="all_day_id" name="all_day"
					value="all_day_id" onClick="javascript: allday(this);">
					</td>
					<td width="100%">All day</td>
					<td rowspan="2">
					<table>
						<tr>
							<td><div id="loading_div"></div></td>
						</tr>
					</table></td>
				</tr>
				<tr>
					<td scope="row"><font color="#000000"><strong>End&nbsp;Time:</strong> </font></td>
					<td>
					<table width="100" border="0">
						<tr>
							<td>Date</td>
							<td>
							<SELECT ID="end_month_id" NAME="end_month"
							<?php echo $text_style_no_height;?> disabled>
								<OPTION VALUE="<?php echo $monthID;?>" selected><?php echo get_string_day($monthID);?></OPTION>
								<OPTION VALUE="01">Jan</OPTION>
								<OPTION VALUE="02">Feb</OPTION>
								<OPTION VALUE="03">Mar</OPTION>
								<OPTION VALUE="04">Apr</OPTION>
								<OPTION VALUE="05">May</OPTION>
								<OPTION VALUE="06">Jun</OPTION>
								<OPTION VALUE="07">Jul</OPTION>
								<OPTION VALUE="08">Aug</OPTION>
								<OPTION VALUE="09">Sep</OPTION>
								<OPTION VALUE="10">Oct</OPTION>
								<OPTION VALUE="11">Nov</OPTION>
								<OPTION VALUE="12">Dec</OPTION>
							</SELECT></td>
							<td>
							<select id="end_day_id" name="end_day"
							<?php echo $text_style_no_height;?> disabled>
								<option value="<?php echo $dayID;?>" selected><?php echo $dayID;?></option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							</select></td>
							<td>
							<SELECT ID="end_year_id" NAME="end_year"
							<?php echo $text_style_no_height;?> disabled>
								<OPTION VALUE="<?php echo $yearID;?>" selected><?php echo $yearID;?></OPTION>
								<OPTION VALUE="2006">2005</OPTION>
								<OPTION VALUE="2006">2006</OPTION>
								<OPTION VALUE="2007">2007</OPTION>
								<OPTION VALUE="2008">2008</OPTION>
								<OPTION VALUE="2009">2009</OPTION>
								<OPTION VALUE="2009">2010</OPTION>
							</SELECT></td>
							<td>&nbsp;&nbsp;Time</td>
							<td>
							<SELECT ID="end_hour_id" NAME="end_hour"
							onChange="javascript: check_hour('new');"
							<?php echo $text_style_no_height;?> disabled>
								<OPTION VALUE="" SELECTED>Hour</OPTION>
								<OPTION VALUE=1>1 AM</OPTION>
								<OPTION VALUE=2>2 AM</OPTION>
								<OPTION VALUE=3>3 AM</OPTION>
								<OPTION VALUE=4>4 AM</OPTION>
								<OPTION VALUE=5>5 AM</OPTION>
								<OPTION VALUE=6>6 AM</OPTION>
								<OPTION VALUE=7>7 AM</OPTION>
								<OPTION VALUE=8>8 AM</OPTION>
								<OPTION VALUE=9>9 AM</OPTION>
								<OPTION VALUE=10>10 AM</OPTION>
								<OPTION VALUE=11>11 AM</OPTION>
								<OPTION VALUE=12>12 AM</OPTION>
								<OPTION VALUE=13>1 PM</OPTION>
								<OPTION VALUE=14>2 PM</OPTION>
								<OPTION VALUE=15>3 PM</OPTION>
								<OPTION VALUE=16>4 PM</OPTION>
								<OPTION VALUE=17>5 PM</OPTION>
								<OPTION VALUE=18>6 PM</OPTION>
								<OPTION VALUE=19>7 PM</OPTION>
								<OPTION VALUE=20>8 PM</OPTION>
								<OPTION VALUE=21>9 PM</OPTION>
								<OPTION VALUE=22>10 PM</OPTION>
								<OPTION VALUE=23>11 PM</OPTION>
								<OPTION VALUE=24>12 PM</OPTION>
							</SELECT></td>
							<td>
							<select id="end_minute_id" name="end_minute" disabled
							<?php echo $text_style_no_height;?>
							onChange="javascript: check_minute('new');">
								<option value="" selected>Minute</option>
								<option value="0">00</option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
								<option value="32">32</option>
								<option value="33">33</option>
								<option value="34">34</option>
								<option value="35">35</option>
								<option value="36">36</option>
								<option value="37">37</option>
								<option value="38">38</option>
								<option value="39">39</option>
								<option value="40">40</option>
								<option value="41">41</option>
								<option value="42">42</option>
								<option value="43">43</option>
								<option value="44">44</option>
								<option value="45">45</option>
								<option value="46">46</option>
								<option value="47">47</option>
								<option value="48">48</option>
								<option value="49">49</option>
								<option value="50">50</option>
								<option value="51">51</option>
								<option value="52">52</option>
								<option value="53">53</option>
								<option value="54">54</option>
								<option value="55">55</option>
								<option value="56">56</option>
								<option value="57">57</option>
								<option value="58">58</option>
								<option value="59">59</option>
								<option value="60">60</option>
							</select></td>
						</tr>
					</table></td>
					<td>
					<input type="checkbox" id="any_id" name="any" value="any_id"
					checked onClick="javascript: new_any(this);">
					</td>
					<td width="100%">Any</td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td width="24%" align="left" valign="top" bgcolor="#FFFFFF"><strong>Message
			to Client</strong>
			<br />
			<textarea id="description_id"
					name="description" cols="116" rows="10"
					<?php echo $text_style_no_height;?>="<?php echo $text_style;?>"></textarea>
<br />			
			<div class="cc">
				<label>
					CC:
				</label>
				<input type="text" name="cc_client" class="cc_client" id="cc_client" style="width:250px;margin-bottom: 5px;margin-top:5px"/>
			</div>

			<div id="file_client_container">
				<label>Attach File</label>
				<input type="file" name="file_client[]" /><br/>
			</div>
			<button class="addMore" id="addMoreFileClient">
				Add
			</button>
			<br />
			<strong>Message to
			Candidate</strong>
			<br />
			<textarea id="description2_id"
					name="description2" cols="116" rows="10"
					<?php echo $text_style_no_height;?>="<?php echo $text_style;?>"></textarea>
<br />			<br />
			<div id="file_candidates_container">
				<label>Attach File</label>
				<input type="file" name="file_candidate[]" /><br/>
			</div>
			<button class="addMore" id="addMoreFileCandidate">
				Add
			</button>
			<br />
			<input type="submit"
			value="Save" name="new" <?php echo $button_style;?>>
			<input
			onClick="javascript: appointment_cancel('new_appointment');"
			type="button" value="Cancel" name="cancel"
			<?php echo $button_style;?>>
			</td>
		</tr>
	</table>
</form>
