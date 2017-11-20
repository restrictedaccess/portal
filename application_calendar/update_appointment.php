
					<form method="post" action="?id=<?php echo $id; ?>&yearID=<?php if(@isset($_SESSION['yearID'])) echo $_SESSION['yearID']; ?>&dayID=<?php if(@isset($_SESSION['dayID'])) echo $_SESSION['dayID']; ?>&monthID=<?php if(@isset($_SESSION['monthID'])) echo $_SESSION['monthID']; ?>&calendar_type=<?php if(@isset($_SESSION['calendar_type'])) echo $_SESSION['calendar_type']; ?>" onSubmit="return validate(this)">
					<input type="hidden" id="update_selected_record_id" name="selected_record">
					<table width="100%" border="0" bgcolor="#666666" cellpadding="10" cellspacing="1">
                        <tr>
                          <td width="24%" align="left" valign="top" bgcolor="#F1F1F3">
								<font color="#000000"><strong>
						  
								  
									<table width="100%"  border="0" cellspacing="0" cellpadding="3">
									  <tr>
										<td colspan="5">
                                        <div id="update_leads_id"></div>
                                        <div id="update_client_id"></div>
                                        </td>
									  </tr>	
									  <tr>
										<td><font color="#000000"><strong>Subject:</strong></font></td>
										<td colspan="4" width="0"><input id="update_subject_id" name="subject" type="text" size="105" <?php echo $text_style; ?>></td>
									  </tr>
									  <tr>
										<td scope="row"><font color="#000000"><strong>Location:</strong></font></td>
										<td><input id="update_location_id" name="location" type="text" size="50%" <?php echo $text_style; ?>></td>
										<td><input type="checkbox" ID="update_type_option_id" name="type_option" value="online meeting" onClick="ToggleInput(this, 'update_type_id');"></td>
										<td>This&nbsp;is&nbsp;an&nbsp;online&nbsp;meeting&nbsp;using:</td>
										<td width="100%">
											<select name="type" ID="update_type_id" <?php echo $text_style_no_height; ?>>
												<option value="" selected></option>
												<option value="skype">Skype</option>
												<option value="rschat">RSChat</option>
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
																				<SELECT ID="update_start_month_id" NAME="start_month" <?php echo $text_style_no_height; ?>>
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
                                                                                <select ID="update_start_day_id" name="start_day" <?php echo $text_style_no_height; ?>>
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
																			  <SELECT ID="update_start_year_id" NAME="start_year" <?php echo $text_style_no_height; ?>>
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
																				<SELECT ID="update_start_hour_id" NAME="start_hour" <?php echo $text_style_no_height; ?>>
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
                                                                                <select ID="update_start_minute_id" name="start_minute" <?php echo $text_style_no_height; ?>>
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
                              <td><input id="update_all_day_id" type="checkbox" name="all_day" value="update_all_day_id" onClick="javascript: update_allday(this);"></td>
                              <td width="100%">All day</td>
                            </tr>
                            <tr>
                              <td scope="row"><font color="#000000"><strong>End&nbsp;Time:</strong></font></td>
                              <td>
							  
							  
										<table width="100" border="0">
										  <tr>
											<td>Date</td>
											<td>
																				<SELECT ID="update_end_month_id" NAME="end_month" <?php echo $text_style_no_height; ?>>
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
                                                                                <select ID="update_end_day_id" name="end_day" <?php echo $text_style_no_height; ?>>
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
																			  <SELECT ID="update_end_year_id" NAME="end_year" <?php echo $text_style_no_height; ?>>
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
																				<SELECT ID="update_end_hour_id" NAME="end_hour" <?php echo $text_style_no_height; ?>>
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
                                                                                <select ID="update_end_minute_id" name="end_minute" <?php echo $text_style_no_height; ?>>
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
								<td><input type="checkbox" id="update_any_id" name="any" value="update_any_id" onClick="javascript: update_any(this);" ></td>
                              <td width="100%">Any</td>							  
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td width="24%" align="left" valign="top" bgcolor="#FFFFFF">
						  	<textarea name="description" ID="update_description_id" cols="110" rows="15" <?php echo $text_style_no_height; ?>></textarea><br /><br />
							<input type="submit" value="Save" name="a" <?php echo $button_style; ?>>
							<input onClick="javascript: appointment_cancel('update_appointment');" type="button" value="Cancel" name="cancel" <?php echo $button_style; ?>>
						  </td>
                        </tr>
					</table>
					</form>