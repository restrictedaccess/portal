<?php
include 'conf.php';
include 'config.php';
include('conf/zend_smarty_conf.php');

function load_setting($client_id,$tz,$status)
{
	global $db;
	$body = '
						<br />
						';
						$body = $body.'
						Select Your Time Zone:
						<SELECT name="tz" onChange="javascript: timezone_setting(this.value,'.$client_id.'); " id="tz_id" style=\'color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;\'>';
							if($tz == "") $body = $body. "<OPTION VALUE='' selected>Select Time Zone</OPTION>"; else $body = $body. "<OPTION VALUE='".$tz."' selected>".$tz."</OPTION>";
							$body = $body.'
							<OPTION VALUE="Australia/Sydney">Australia/Sydney</OPTION>
							<OPTION VALUE="Asia/Manila">Asia/Manila</OPTION>
							<OPTION VALUE="Europe/London">Europe/London</OPTION>
							<OPTION VALUE="America/New_York">America/New_York</OPTION>
						</SELECT><br /><br />';
						$orig_status = $status;
						$body = $body.'
						<table width="100%" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC" border="0">
						';
								$counter = 0;
								
								//check the number of records
								//$queryCheck="SELECT id FROM tb_client_account_settings WHERE client_id='$client_id' AND (status='ALL' OR status='ONE');";
								//$result=mysql_query($queryCheck);
								//$ctr=@mysql_num_rows($result);
								$ctr = $db -> fetchRow("SELECT id FROM tb_client_account_settings WHERE client_id='$client_id' AND (status='ALL' OR status='ONE');");
								//end
								
								$result=$db -> fetchAll("SELECT id, status, hour, minute, client_timezone, email, cc FROM tb_client_account_settings WHERE client_id='$client_id' AND (status='ALL' OR status='ONE');");
								//$query="SELECT id, status, hour, minute, client_timezone, email, cc FROM tb_client_account_settings WHERE client_id='$client_id' AND (status='ALL' OR status='ONE');";
								//$result=mysql_query($query);
								//while(list($id,$status,$h,$m,$client_timezone,$email,$cc) = mysql_fetch_array($result))
								foreach ($result as $r)
								{
								
									$id = $r["id"];
									$status = $r["status"];
									$h = $r["hour"];
									$m = $r["minute"];
									$client_timezone = $r["client_timezone"];
									$email = $r["email"];
									$cc = $r["cc"];
									
									//date formating
									$tm = $h.":".$m.":00";
									$date_time = new DateTime($tm);
									$time = $date_time->format('h:i:a');	
									$date = $date_time->format('M-d');
									//ended										
								
									$body = $body. "<tr>";	
									$body = $body. "<td width='80%' bgcolor='#ffffff'>";
									
										if($status == "ALL")
										{
															$body = $body."<strong>Email:&nbsp;</strong><em>".$email."</em>";
															if($cc != "")
															{
																$body = $body.",&nbsp;<strong>CC:</strong>&nbsp;<em>".$cc."</em>";
															}
															if($time != "")
															{
																$body = $body.",&nbsp;<strong>Time:</strong>&nbsp;<em>".$time."</em>";
															}									
										}
										else
										{
															$body = $body."<strong>Email:&nbsp;</strong><em>".$email."</em>";
															if($cc != "")
															{
																$body = $body.",&nbsp;<strong>CC:</strong>&nbsp;<em>".$cc."</em>";
															}
										}

										
										$body = $body."
										<div id='notes_".$id."' STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
											<table bgcolor='#cccccc' width='300' cellpadding='0' cellspacing='2'><tr><td>
												<table bgcolor='#FFFFCC' width='300' cellpadding='3' cellspacing='3'>
													<tr>
														<td colspan=2>";
														
														
														
														
																if($status=="ALL")
																{							
																		$body = $body."							
																		<table border=\"0\">
																			<tr>
																				<td>Email</td><td><INPUT type='text' ID='email_id".$id."' NAME='email".$id."' value='".$email."' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																				<td>CC</td><td><INPUT type='text' ID='cc_id".$id."' NAME='cc".$id."' value='".$cc."' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																				<td>
																					<SELECT ID=\"hour_id".$id."\" NAME=\"hour".$id."\" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>";
																							switch($h)
																							{
																								case "12":
																									$hour_display = "<OPTION VALUE=12 selected>12 PM</OPTION>";
																									break;																							
																								case "13":
																									$hour_display = "<OPTION VALUE=13 selected>01 PM</OPTION>";
																									break;
																								case "14":		
																									$hour_display = "<OPTION VALUE=14 selected>02 PM</OPTION>";
																									break;
																								case "15":
																									$hour_display = "<OPTION VALUE=15 selected>03 PM</OPTION>";
																									break;
																								case "16":		
																									$hour_display = "<OPTION VALUE=16 selected>04 PM</OPTION>";
																									break;
																								case "17":		
																									$hour_display = "<OPTION VALUE=17 selected>05 PM</OPTION>";
																									break;
																								case "18":		
																									$hour_display = "<OPTION VALUE=18 selected>06 PM</OPTION>";
																									break;
																								case "19":		
																									$hour_display = "<OPTION VALUE=19 selected>07 PM</OPTION>";
																									break;
																								case "20":		
																									$hour_display = "<OPTION VALUE=20 selected>08 PM</OPTION>";
																									break;
																								case "21":		
																									$hour_display = "<OPTION VALUE=21 selected>09 PM</OPTION>";
																									break;
																								case "22":		
																									$hour_display = "<OPTION VALUE=22 selected>10 PM</OPTION>";
																									break;
																								case "23":		
																									$hour_display = "<OPTION VALUE=23 selected>11 PM</OPTION>";
																									break;
																								case "24":		
																									$hour_display = "<OPTION VALUE=24 selected>12 AM</OPTION>";
																									break;
																								default:
																									if($h < 10)
																									{
																										$hour_display = "<OPTION VALUE=".$h." selected>0".$h." AM</OPTION>";
																									}
																									else
																									{
																										$hour_display = "<OPTION VALUE=".$h." selected>".$h." AM</OPTION>";
																									}
																									break;
																							}	
																																											
																							if($h == "")
																								$body = $body. "<OPTION VALUE='' SELECTED>Hour</OPTION>";
																							else
																								$body = $body. $hour_display;
																						
																						$body = $body."																						
																						<OPTION VALUE=1>01 AM</OPTION>
																						<OPTION VALUE=2>02 AM</OPTION>
																						<OPTION VALUE=3>03 AM</OPTION>
																						<OPTION VALUE=4>04 AM</OPTION>
																						<OPTION VALUE=5>05 AM</OPTION>
																						<OPTION VALUE=6>06 AM</OPTION>
																						<OPTION VALUE=7>07 AM</OPTION>
																						<OPTION VALUE=8>08 AM</OPTION>
																						<OPTION VALUE=9>09 AM</OPTION>
																						<OPTION VALUE=10>10 AM</OPTION>
																						<OPTION VALUE=11>11 AM</OPTION>
																						<OPTION VALUE=12>12 PM</OPTION>
																						<OPTION VALUE=13>01 PM</OPTION>
																						<OPTION VALUE=14>02 PM</OPTION>
																						<OPTION VALUE=15>03 PM</OPTION>
																						<OPTION VALUE=16>04 PM</OPTION>
																						<OPTION VALUE=17>05 PM</OPTION>
																						<OPTION VALUE=18>06 PM</OPTION>
																						<OPTION VALUE=19>07 PM</OPTION>
																						<OPTION VALUE=20>08 PM</OPTION>
																						<OPTION VALUE=21>09 PM</OPTION>
																						<OPTION VALUE=22>10 PM</OPTION>
																						<OPTION VALUE=23>11 PM</OPTION>
																						<OPTION VALUE=24>12 AM</OPTION>	
																					</SELECT>											
	
																			</td>
																			<td>
	
																					<select id=\"minute_id".$id."\" name=\"minute".$id."\" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>";
																							if($m == "")
																								$body = $body. '<option value="" selected>Minute</option>';
																							else
																							{
																								if($m < 10)
																								{
																									$body = $body. "<option value='".$m."' selected>0".$m."</option>";
																								}
																								else
																								{
																									$body = $body. "<option value='".$m."' selected>".$m."</option>";
																								}
																							}	
																					$body = $body.'
																					  <option value="0">00</option>
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
																					</select>												
																			</td>
																			<td><input type="button" value="Save" onClick="javascript: update_setting(\''.$id.'\',\''.$client_id.'\',\''.$client_timezone.'\',\'ALL\');" id="save_id'.$id.'" name="save'.$id.'" style=\'color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;\'></td>
																			<td><a href="javascript: hideSubMenu();">Close</a></td>
																		</tr>
																	</table>';
																	
														}
														else
														{			
																	$body = $body."
																	<INPUT type='hidden' ID='hour_id".$id."' NAME='hour".$id."' value='".$h."'>
																	<INPUT type='hidden' id='minute_id".$id."' NAME='minute".$id."' value='".$m."'>
																	<table border='0'>
																		<tr>
																			<td>Email</td><td><INPUT type='text' ID='email_id".$id."' NAME='email".$id."' value='".$email."' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																			<td>CC</td><td><INPUT type='text' ID='cc_id".$id."' NAME='cc".$id."' value='".$cc."' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																			<td><input type='button' value='Save' onClick=\"javascript: update_setting('".$id."','".$client_id."','".$client_timezone."','ONE');\" id='save_id".$id."' name='save".$id."' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																			<td><a href=\"javascript: hideSubMenu();\">Close</a></td>
																		</tr>
																	</table>	
																	";																	
														}			
																	

							$body = $body. "
														</td>
													</tr>
												</table>	
											</td></tr></table>
										</div>";									
									
									
									$body = $body. "</td>";
									$body = $body. "<td width='10%' onclick=\"showSubMenu('notes_".$id."'); \" onMouseOver=\"javascript:this.style.background='#F1F1F3';\" onMouseOut=\"javascript:this.style.background='#ffffff'; \" bgcolor=#FFFFFF valign='top'>
										<a href=\"javascript: showSubMenu('notes_".$id."'); \">Edit</a>
										</td>
										";
									$body = $body. "<td width='10%'onclick=\"remove('".$id."'); \" onMouseOver=\"javascript:this.style.background='#F1F1F3';\" onMouseOut=\"javascript:this.style.background='#ffffff'; \" bgcolor=#FFFFFF valign='top' width='90%'>";
									if($ctr > 1)
									{
										$body = $body."<a href=\"javascript: delete_setting('".$id."','".$client_id."','".$client_timezone."','".$orig_status."'); \">Remove</a></td>";
									}	
									$body = $body. "</tr>";
								}				
												

									
						$body = $body.'
						</table>
						';
									if($orig_status=="ALL")
									{
										$body = $body.'<br />Click <a href="javascript: showSubMenu(\'notes'.$client_id.'\'); ">Here</a> to Add the Time you want to receive the note.';
									}
									else
									{
										$body = $body.'<br />Click <a href="javascript: showSubMenu(\'notes_one'.$client_id.'\'); ">Here</a> to Add the Schedule when Sub-Contractor Finishes work.';
									}
															
						
	return $body."THE STATUS IS: ".$orig_status;					
}


$status = @$_REQUEST["status"];
$delete_type = @$_REQUEST["delete_type"];
$add_type = @$_REQUEST["add_type"];
$update_type = @$_REQUEST["update_type"];
$id = @$_REQUEST["id"];
$hour = @$_REQUEST["hour"];
$minute = @$_REQUEST["minute"];
$tz = @$_REQUEST["tz"];
$client_id = @$_REQUEST["client_id"];
$email = @$_REQUEST["email"];
$cc = @$_REQUEST["cc"];

//timezone setup
if(!isset($tz) || $tz == "")
{
	$counter = 0;
	//$r=mysql_query("SELECT client_timezone FROM tb_client_account_settings WHERE client_id='$client_id' LIMIT 1");
	//while(list($client_timezone) = mysql_fetch_array($r))
	$r = $db -> fetchRow("SELECT client_timezone FROM tb_client_account_settings WHERE client_id='$client_id'");
	foreach($r as $rows)
	{
		$client_timezone = $rows["client_timezone"];
		$tz = $client_timezone;
		$counter++;
	}
	if($counter == 0)
	{
		$tz = "Australia/Sydney";
	}
}
//end timezone setup


if($status=='ALL' || $status=='NONE' || $status=='ONE')
{
	$t = "20:00:00";
	$hour = "20";
	$minute = "00";
    date_default_timezone_set($tz);
	
	//$default_email = mysql_fetch_array(mysql_query("SELECT email as e FROM leads WHERE id='$client_id' LIMIT 1"));
	$default_email = $db -> fetchRow("SELECT email as e FROM leads WHERE id='$client_id'");
	$default_email = $default_email["e"];
	$cc = "";
			
	if($status == "NONE" || $status == "ONE")
	{
		$hour = "00";
		$minute = "00";
		$send_time = "00:00:00";
	}
	else
	{
		//convert to manila time
		$phl_tz = new DateTimeZone('Asia/Manila');
		$date_time_asia_manila = new DateTime($t);
		$date_time_asia_manila->setTimezone($phl_tz);
		$send_time = $date_time_asia_manila->format('H:i:s');
	}

	if($status == "ALL")
	{
		//$queryCheck="SELECT status FROM tb_client_account_settings WHERE client_id='$client_id' AND status='ALL' LIMIT 1";
		//$result=mysql_query($queryCheck);
		//$ctr=@mysql_num_rows($result);
		$ctr=$db -> fetchRow("SELECT status FROM tb_client_account_settings WHERE client_id='$client_id' AND status='ALL'");
		if(!$ctr)
		{
			/* $query="DELETE FROM tb_client_account_settings WHERE type='ACTIVITY NOTES' AND client_id='$client_id'";
			$result=mysql_query($query);	
			
			$query="INSERT INTO tb_client_account_settings SET client_id='$client_id', type='ACTIVITY NOTES', hour='$hour', minute='$minute', client_timezone='$tz', send_time='$send_time', status='$status', email='$default_email', cc='$cc'";
			$result=mysql_query($query); */
			$db->delete("tb_client_account_settings",$db->quoteInto('type="ACTIVITY NOTES" AND client_id=?',$client_id));
			$data = array();
			$data['client_id'] = $client_id;
			$data['type'] = "ACTIVITY NOTES";
			$data['hour'] = $hour;
			$data['minute'] = $minute;
			$data['client_timezone'] = $tz;
			$data['send_time'] = $send_time;
			$data['status'] = $status;
			$data['email'] = $default_email;
			$data['cc'] = $cc;
			$db->insert("tb_client_account_settings",$data);
		}
	}
	else
	{
		$db->delete("tb_client_account_settings",$db->quoteInto('type="ACTIVITY NOTES" AND client_id=?',$client_id));
		$data = array();
		$data['client_id'] = $client_id;
		$data['type'] = 'ACTIVITY NOTES';
		$data['hour'] = $hour;
		$data['minute'] = $minute;
		$data['client_timezone'] = $tz;
		$data['send_time'] = $send_time;
		$data['status'] = $status;
		$data['email'] = $default_email;
		$data['cc'] = $cc;
		$db->insert("tb_client_account_settings",$data);
	}

	echo load_setting($client_id,$tz,$status);
	
}
elseif($status=='ADD')
{
	$t = $hour.":".$minute.":00";
    date_default_timezone_set($tz);
	
	//convert to manila time
	$phl_tz = new DateTimeZone('Asia/Manila');
	$date_time_asia_manila = new DateTime($t);
	$date_time_asia_manila->setTimezone($phl_tz);
	$send_time = $date_time_asia_manila->format('H:i:s');
		
	if($add_type == "ALL")
	{
		//$query="INSERT INTO tb_client_account_settings SET client_id='$client_id', type='ACTIVITY NOTES', hour='$hour', minute='$minute', client_timezone='$tz', send_time='$send_time', status='ALL', email='$email', cc='$cc'";	
		$data = array("client_id"=>$client_id,
											  "type"=>"ACTIVITY NOTES",
											  "hour"=>$hour,
											  "minute"=>$minute,
											  "client_timezone"=>$tz,
											  "send_time"=>$send_time,
											  "status"=>"ALL",
											  "email"=>$email,
											  "cc"=>$cc);
		//$db -> insert("tb_client_account_settings",$data);
		
	}
	else
	{
		//$query="INSERT INTO tb_client_account_settings SET client_id='$client_id', type='ACTIVITY NOTES', hour='$hour', minute='$minute', client_timezone='$tz', send_time='$send_time', status='ONE', email='$email', cc='$cc'";	
		$data = array("client_id"=>$client_id,
											  "type"=>"ACTIVITY NOTES",
											  "hour"=>$hour,
											  "minute"=>$minute,
											  "client_timezone"=>$tz,
											  "send_time"=>$send_time,
											  "status"=>"ONE",
											  "email"=>$email,
											  "cc"=>$cc); 
		//$db -> insert("tb_client_account_settings",$data); */
		
	}		
	//$result=mysql_query($query);
	$db -> insert("tb_client_account_settings",$data);
	echo load_setting($client_id,$tz,$add_type);
}
elseif($status=='UPDATE')
{
	$t = $hour.":".$minute.":00";
    date_default_timezone_set($tz);
	
	//convert to manila time
	$phl_tz = new DateTimeZone('Asia/Manila');
	$date_time_asia_manila = new DateTime($t);
	$date_time_asia_manila->setTimezone($phl_tz);
	$send_time = $date_time_asia_manila->format('H:i:s');
	
	//$query="UPDATE tb_client_account_settings SET hour='$hour', minute='$minute', send_time='$send_time', email='$email', cc='$cc' WHERE id='$id'";
	//$result=mysql_query($query);
	 $db -> update("tb_client_account_settings", 
	  								array("hour"=>$hour,
	  									  "minute"=>$minute,
	  									  "send_time"=>$send_time,
										  "email"=>$email,
										  "cc"=>$cc),
									$db -> quoteInto("id=?",$id));
	
	echo load_setting($client_id,$tz,$update_type);
}
elseif($status=='DELETE')
{
	//$query="DELETE FROM tb_client_account_settings WHERE id='$id'";
	//$result=mysql_query($query);
	$db -> delete("tb_client_account_settings", $db -> quoteInto("id=?",$id));
	echo load_setting($client_id,$tz,$delete_type);
}
elseif($status=='TZ')
{
	//convert to manila time
	//$query="UPDATE tb_client_account_settings SET client_timezone='$tz' WHERE client_id='$client_id'";
	//$result=mysql_query($query);
	$db -> update("tb_client_account_settings", array("client_timezone"=>$tz), $db -> quoteInto("client_id=?",$client_id));
}

?>
