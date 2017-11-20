

					<form method="post" action="?id=<?php echo $id; ?>&yearID=<?php if(@isset($_SESSION['yearID'])) echo $_SESSION['yearID']; ?>&dayID=<?php if(@isset($_SESSION['dayID'])) echo $_SESSION['dayID']; ?>&monthID=<?php if(@isset($_SESSION['monthID'])) echo $_SESSION['monthID']; ?>&calendar_type=<?php if(@isset($_SESSION['calendar_type'])) echo $_SESSION['calendar_type']; ?>" onSubmit="return validate(this)">

					<table width="100%" border="0" bgcolor="#666666" cellpadding="10" cellspacing="1">

                        <tr>

                          <td width="24%" align="left" valign="top" bgcolor="#F1F1F3">

								<font color="#000000"><strong>

						  

								  

									<table width="100%"  border="0" cellspacing="0" cellpadding="3">

									

									<?php 

										if(@$page_sel == "popup")

										{

									?>	

									  <tr>

										<td colspan="5">

										

											<table>
															<?php
																$db=connsql();

																$id = $l_id;
																$temp = "../application_apply_action.php?userid=".$l_id;
																if(@$_SESSION['back_link'] == $temp)
																{
																	$get_leads = mysql_query("SELECT userid, lname, fname, email FROM personal WHERE userid='$id' ORDER BY lname LIMIT 1");
																	$counter = 0;
																	while ($row = @mysql_fetch_assoc($get_leads)) 
	
																	{
	
																		$counter++;
	
																		echo '<input type="hidden" name="leads" value="'.$row['userid'].'">';
																		echo '<input type="hidden" name="email" value="'.$row['email'].'">';
																		echo '<input type="hidden" name="full_name" value="'.$row['fname'].' '.$row['lname'].'">';
																		$selected_name = "<strong>".$row['fname'].' '.$row['lname']."</strong>";
	
																	}																
																}
																else
																{
																	$get_leads = mysql_query("SELECT id, lname, fname, email FROM leads WHERE id='$id' ORDER BY lname LIMIT 1");
																	$counter = 0;
																	while ($row = @mysql_fetch_assoc($get_leads)) 
	
																	{
	
																		$counter++;
	
																		echo '<input type="hidden" name="leads" value="'.$row['id'].'">';
																		echo '<input type="hidden" name="email" value="'.$row['email'].'">';
																		echo '<input type="hidden" name="full_name" value="'.$row['fname'].' '.$row['lname'].'">';
																		$selected_name = "<strong>".$row['fname'].' '.$row['lname']."</strong>";
	
																	}																
																}
																dieSql($db);
															?>
												<!--<td><input type="checkbox" id="leads_option_id" name="leads_option" value="leads meeting" onClick="ToggleInput(this, 'leads_id');"></td>-->
												<td><!-- Send&nbsp;Autoresponder: --></td>
												<td><input type="hidden" name="autoresponder" value="No">
												<!--
													<select name="autoresponder" id="autoresponder_id" <?php echo $text_style_no_height; if($counter == 0) { echo "disabled"; } ?>>
														<?php
															if($counter == 0)
															{
																echo '<option value="Yes">Yes</option>';
																echo '<option value="No" selected>No</option>';					
															}
															else
															{
																echo '<option value="Yes" selected>Yes</option>';
																echo '<option value="No">No</option>';					
															}
														?>
													</select>	
													-->											
												</td>
												<td>&nbsp;</td>
												<td>Assign&nbsp;this&nbsp;meeting&nbsp;to: </td>

												<td>

													

														<?php
																echo $selected_name;
																if($counter == 0) echo "<strong><font color='red'>NO SELECTED</font></strong>";
														?>
												</td>										

											</table>

											

												

										</td>

									  </tr>			

									  <?php } ?>

									  

									  								

									  <tr>

										<td><font color="#000000"><strong>Subject:</strong></font></td>

										<td colspan="4" width="0"><input name="subject" type="text" size="105" value="<?php echo @$_SESSION['s_name']; ?>" <?php echo $text_style; ?>></td>

									  </tr>

									  <tr>

										<td scope="row"><font color="#000000"><strong>Location:</strong></font></td>

										<td><input name="location" type="text" size="50%" <?php echo $text_style; ?>></td>

										<td><input type="checkbox" id="type_option_id" name="type_option" value="online meeting" onClick="javascript: ToggleInput(this, 'type_id');"></td>

										<td>This&nbsp;is&nbsp;an&nbsp;online&nbsp;meeting&nbsp;using:</td>

										<td width="100%">

											<select name="type" id="type_id" <?php echo $text_style_no_height; ?> disabled>

												<option value="" selected></option>

												<option value="skype">Skype</option>

												<option value="other">Other</option>

											</select>

										</td>

									  </tr>									  

									</table>

								  

							

								</strong></font>

						  </td>

                        </tr>

                        <tr>

                          <td width="24%" align="left" valign="top" bgcolor="#F1F1F3"><table width="100%"  border="0" cellspacing="0" cellpadding="3">

                            <tr>

                              <td><font color="#000000"><strong>Start&nbsp;Time:</strong></font></td>

                              <td>





										<table width="100" border="0">

										  <tr>

											<td>Date</td>

											<td>

																				<SELECT ID="start_month_id" NAME="start_month" <?php echo $text_style_no_height; ?>>

																					<OPTION VALUE="<?php echo $monthID; ?>" selected><?php echo get_string_day($monthID); ?></OPTION>																				

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

                                                                                <select id="start_day_id" name="start_day" <?php echo $text_style_no_height; ?>>

																				  <option value="<?php echo $dayID; ?>" selected><?php echo $dayID; ?></option>

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

                                                                                </select>												

											</td>

											<td>

																			  <SELECT ID="start_year_id" NAME="start_year" <?php echo $text_style_no_height; ?>>

																				<OPTION VALUE="<?php echo $yearID; ?>" selected><?php echo $yearID; ?></OPTION>

																				<OPTION VALUE="2006">2005</OPTION>																				  

																				<OPTION VALUE="2006">2006</OPTION>

																				<OPTION VALUE="2007">2007</OPTION>

																				<OPTION VALUE="2008">2008</OPTION>

																				<OPTION VALUE="2009">2009</OPTION>

																				<OPTION VALUE="2010">2010</OPTION>

																			  </SELECT>											

											</td>

											

											

											

											

											<td>&nbsp;&nbsp;Time</td>

											<td>

																				<SELECT ID="start_hour_id" NAME="start_hour" <?php echo $text_style_no_height; ?>>

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

																				</SELECT>											

											</td>

											<td>

                                                                                <select id="start_minute_id" name="start_minute" <?php echo $text_style_no_height; ?>>

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

                                                                                </select>												

											</td>

										  </tr>

										</table>



							  

							  </td>

                              <td><input type="checkbox" id="all_day_id" name="all_day" value="all_day_id" onClick="javascript: allday(this);"></td>

                              <td width="100%">All day</td>

                            </tr>

                            <tr>

                              <td scope="row"><font color="#000000"><strong>End&nbsp;Time:</strong></font></td>

                              <td>

							  

							  

										<table width="100" border="0">

										  <tr>

											<td>Date</td>

											<td>

																				<SELECT ID="end_month_id" NAME="end_month" <?php echo $text_style_no_height; ?> disabled>

																					<OPTION VALUE="<?php echo $monthID; ?>" selected><?php echo get_string_day($monthID); ?></OPTION>																				

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

																				</SELECT>											

											</td>

											<td>

                                                                                <select id="end_day_id" name="end_day" <?php echo $text_style_no_height; ?> disabled>

																				  <option value="<?php echo $dayID; ?>" selected><?php echo $dayID; ?></option>

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

                                                                                </select>												

											</td>

											<td>

																			  <SELECT ID="end_year_id" NAME="end_year" <?php echo $text_style_no_height; ?> disabled>

																				<OPTION VALUE="<?php echo $yearID; ?>" selected><?php echo $yearID; ?></OPTION>

																				<OPTION VALUE="2006">2005</OPTION>																				  

																				<OPTION VALUE="2006">2006</OPTION>

																				<OPTION VALUE="2007">2007</OPTION>

																				<OPTION VALUE="2008">2008</OPTION>

																				<OPTION VALUE="2009">2009</OPTION>

																				<OPTION VALUE="2010">2010</OPTION>

																			  </SELECT>											

											</td>

											

											

											

											

											<td>&nbsp;&nbsp;Time</td>

											<td>

																				<SELECT ID="end_hour_id" NAME="end_hour" onChange="javascript: check_hour('new');" <?php echo $text_style_no_height; ?> disabled>

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

																				</SELECT>											

											</td>

											<td>

                                                                                <select id="end_minute_id" name="end_minute" disabled <?php echo $text_style_no_height; ?> onChange="javascript: check_minute('new');">

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

                                                                                </select>												

											</td>

										  </tr>

										</table>				  

							  

							  

							  

							  </td>

                              <td><input type="checkbox" id="any_id" name="any" value="any_id" checked onClick="javascript: new_any(this);" ></td>

                              <td width="100%">Any</td>							  

                            </tr>

                          </table></td>

                        </tr>

                        <tr>

                          <td width="24%" align="left" valign="top" bgcolor="#FFFFFF">

						  	<textarea name="description" cols="110" rows="15" <?php echo $text_style_no_height; ?>="<?php echo $text_style; ?>"></textarea><br /><br />

							<input type="submit" value="Save" name="new" <?php echo $button_style; ?>>

							<input onClick="javascript: appointment_cancel('new_appointment');" type="button" value="Cancel" name="cancel" <?php echo $button_style; ?>>

						  </td>

                        </tr>

					</table>

					</form>

