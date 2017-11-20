<table width="100%" cellpadding="1" style="border: 1px #62A4D5 solid ;">

<!--<tr>

<td ><b>Staff Timezone</b></td>

<td colspan="6"><select name="staff_timezone" id="staff_timezone" class="select">

<option value="0">Select Staff Timezone</option>

{$timezones_Options2}

</select>

<input type="button" value="convert" onclick="convertToStaffTimeZone()" />

</td>

</tr>-->

					

					<tr class="rate_tr_hdr">

						<td width="19%" height="25"></td>

						<td colspan="3" align="center" class="rate_td_hdr">Working Hours</td>

						<td colspan="3" align="center" class="rate_td_hdr">Lunch</td>

						

					</tr>

					<tr>

						<td class="rate_td3"><b>Day</b></td>

						<td width="15%" class="rate_td2"><strong>Start</strong></td>

						<td width="14%" class="rate_td2"><strong>Finish</strong></td>

						<td width="11%" class="rate_td2"><strong>Hours</strong></td>

						<td width="15%" class="rate_td2"><strong>Start</strong></td>

						<td width="14%" class="rate_td2"><strong>Finish</strong></td>

						<td width="11%" class="rate_td2"><strong>Hours</strong></td>

					</tr>

					

					<!-- list here-->

					{$working_days}

					

					<tr>

						<td >&nbsp;<input type="hidden" name="work_days" id="work_days" /><input type="text" readonly id="days" name="days" class="select_small" value="5" />&nbsp;<b>No.work days</b></td>

						<td colspan="2" align="right" ><b>Total Weekly hours</b>&nbsp;</td>

						<td align="center" ><b><span><input type="text" readonly id="total_weekly_hrs" name="total_weekly_hrs" class="select_small" /></span></b></td>

						<td colspan="2"></td>

						<td align="center" ><input type="text" readonly id="total_lunch_hrs" name="total_lunch_hrs" class="select_small" /></td>

						

					</tr>

				</table>

