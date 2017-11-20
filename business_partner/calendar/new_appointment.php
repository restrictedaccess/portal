
					<form method="post" action="?yearID=<?php if(@isset($_SESSION['yearID'])) echo $_SESSION['yearID']; ?>&dayID=<?php if(@isset($_SESSION['dayID'])) echo $_SESSION['dayID']; ?>&monthID=<?php if(@isset($_SESSION['monthID'])) echo $_SESSION['monthID']; ?>&calendar_type=<?php if(@isset($_SESSION['calendar_type'])) echo $_SESSION['calendar_type']; ?>" onSubmit="return validate(this)">
					<table width="100%" border="0" bgcolor="#666666" cellpadding="10" cellspacing="1">
                        <tr>
                          <td width="24%" align="left" valign="top" bgcolor="#F1F1F3">
								<font color="#000000"><strong>
						  
								  
									<table width="100%"  border="0" cellspacing="0" cellpadding="3">
									  <tr>
										<td><a href="#"><img src="iconss/move.gif" onDblClick="javascript: mouse_state='on';" border="0"></a></td>
										<td colspan="4" width="0" valign="middle" align="left"><strong>DOUBLE</strong> click to move. <strong>SINGLE</strong> click to hold.</td>
									  </tr>				
									  <tr>
										<td colspan="2">&nbsp;</td>
									  </tr>											
									  <tr>
										<td><font color="#000000"><strong>Subject:</strong></font></td>
										<td colspan="4" width="0"><input name="subject" type="text" size="105" <?php echo $text_style; ?>></td>
									  </tr>
									  <tr>
										<td scope="row"><font color="#000000"><strong>Location:</strong></font></td>
										<td><input name="location" type="text" size="50%" <?php echo $text_style; ?>></td>
										<td><input type="checkbox" id="type_option_id" name="type_option" value="online meeting" onClick="ToggleInput(this, 'type_id');"></td>
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
                                                                                <select id="start_day_id" name="start_day" <?php echo $text_style_no_height; ?>>
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
																			  <SELECT ID="start_year_id" NAME="start_year" <?php echo $text_style_no_height; ?>>
																				<OPTION VALUE="<?php echo $yearID; ?>" selected><?php echo $yearID; ?></OPTION>
																				<OPTION VALUE="2006">2005</OPTION>																				  
																				<OPTION VALUE="2006">2006</OPTION>
																				<OPTION VALUE="2007">2007</OPTION>
																				<OPTION VALUE="2008">2008</OPTION>
																				<OPTION VALUE="2009">2009</OPTION>
																				<OPTION VALUE="2009">2010</OPTION>
																			  </SELECT>											
											</td>
											
											
											
											
											<td>&nbsp;&nbsp;Time</td>
											<td>
																				<SELECT ID="start_hour_id" NAME="start_hour" <?php echo $text_style_no_height; ?>>
																					<OPTION VALUE="" SELECTED>Hour</OPTION>
																					<OPTION VALUE="1">01 AM</OPTION>
																					<OPTION VALUE="2">02 AM</OPTION>
																					<OPTION VALUE="3">03 AM</OPTION>
																					<OPTION VALUE="4">04 AM</OPTION>
																					<OPTION VALUE="5">05 AM</OPTION>
																					<OPTION VALUE="6">06 AM</OPTION>
																					<OPTION VALUE="7">07 AM</OPTION>
																					<OPTION VALUE="8">08 AM</OPTION>
																					<OPTION VALUE="9">09 AM</OPTION>
																					<OPTION VALUE="10">10 AM</OPTION>
																					<OPTION VALUE="11">11 AM</OPTION>
																					<OPTION VALUE="12">12 AM</OPTION>
																					<OPTION VALUE="13">01 PM</OPTION>
																					<OPTION VALUE="14">02 PM</OPTION>
																					<OPTION VALUE="15">03 PM</OPTION>
																					<OPTION VALUE="16">04 PM</OPTION>
																					<OPTION VALUE="17">05 PM</OPTION>
																					<OPTION VALUE="18">06 PM</OPTION>
																					<OPTION VALUE="19">07 PM</OPTION>
																					<OPTION VALUE="20">08 PM</OPTION>
																					<OPTION VALUE="21">09 PM</OPTION>
																					<OPTION VALUE="22">10 PM</OPTION>
																					<OPTION VALUE="23">11 PM</OPTION>
																					<OPTION VALUE="24">12 PM</OPTION>																					
																				</SELECT>											
											</td>
											<td>
                                                                                <select id="start_minute_id" name="start_minute" <?php echo $text_style_no_height; ?>>
																				  <option value="" selected>Minute</option>
																				  <option value="0">00</option>
                                                                                  <option value="30">30</option>
                                                                                </select>												
											</td>
										  </tr>
										</table>

							  
							  </td>
                              <td><input type="checkbox" name="all_day" value="checkbox"></td>
                              <td width="100%">All day</td>
                            </tr>
                            <tr>
                              <td scope="row"><font color="#000000"><strong>End&nbsp;Time:</strong></font></td>
                              <td colspan="3">
							  
							  
										<table width="100" border="0">
										  <tr>
											<td>Date</td>
											<td>
																				<SELECT ID="end_month_id" NAME="end_month" <?php echo $text_style_no_height; ?>>
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
                                                                                <select id="end_day_id" name="end_day" <?php echo $text_style_no_height; ?>>
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
																			  <SELECT ID="end_year_id" NAME="end_year" <?php echo $text_style_no_height; ?>>
																				<OPTION VALUE="<?php echo $yearID; ?>" selected><?php echo $yearID; ?></OPTION>
																				<OPTION VALUE="2006">2005</OPTION>																				  
																				<OPTION VALUE="2006">2006</OPTION>
																				<OPTION VALUE="2007">2007</OPTION>
																				<OPTION VALUE="2008">2008</OPTION>
																				<OPTION VALUE="2009">2009</OPTION>
																				<OPTION VALUE="2009">2010</OPTION>
																			  </SELECT>											
											</td>
											
											
											
											
											<td>&nbsp;&nbsp;Time</td>
											<td>
																				<SELECT ID="end_hour_id" NAME="end_hour" <?php echo $text_style_no_height; ?>>
																					<OPTION VALUE="" SELECTED>Hour</OPTION>
																					<OPTION VALUE="1">01 AM</OPTION>
																					<OPTION VALUE="2">02 AM</OPTION>
																					<OPTION VALUE="3">03 AM</OPTION>
																					<OPTION VALUE="4">04 AM</OPTION>
																					<OPTION VALUE="5">05 AM</OPTION>
																					<OPTION VALUE="6">06 AM</OPTION>
																					<OPTION VALUE="7">07 AM</OPTION>
																					<OPTION VALUE="8">08 AM</OPTION>
																					<OPTION VALUE="9">09 AM</OPTION>
																					<OPTION VALUE="10">10 AM</OPTION>
																					<OPTION VALUE="11">11 AM</OPTION>
																					<OPTION VALUE="12">12 AM</OPTION>
																					<OPTION VALUE="13">01 PM</OPTION>
																					<OPTION VALUE="14">02 PM</OPTION>
																					<OPTION VALUE="15">03 PM</OPTION>
																					<OPTION VALUE="16">04 PM</OPTION>
																					<OPTION VALUE="17">05 PM</OPTION>
																					<OPTION VALUE="18">06 PM</OPTION>
																					<OPTION VALUE="19">07 PM</OPTION>
																					<OPTION VALUE="20">08 PM</OPTION>
																					<OPTION VALUE="21">09 PM</OPTION>
																					<OPTION VALUE="22">10 PM</OPTION>
																					<OPTION VALUE="23">11 PM</OPTION>
																					<OPTION VALUE="24">12 PM</OPTION>																					
																				</SELECT>											
											</td>
											<td>
                                                                                <select id="end_minute_id" name="end_minute" <?php echo $text_style_no_height; ?>>
																				  <option value="" selected>Minute</option>
																				  <option value="0">00</option>
                                                                                  <option value="30">30</option>
                                                                                </select>												
											</td>
										  </tr>
										</table>				  
							  
							  
							  
							  </td>
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
