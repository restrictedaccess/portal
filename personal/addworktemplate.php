<table width=500 border=0 cellspacing=0 cellpadding=0 class=applyform>
	<tbody>
		<tr>
			<td width=200 align=right>Company Name:</td><td width=300>
			<input name="history_company_name[]" id=history_company_name size=35>
			</td>
		<tr>
			<td align=right>Position Title:</td><td>
			<input name="history_position[]" id=history_position size=35>
			</td>
		<tr>
			<td align=right>Employment Period</td><td>
			<select name="history_monthfrom[]">
				<option value=JAN>JAN<option value=FEB>FEB<option value=MAR>MAR<option value=APR>APR<option value=MAY>MAY<option value=JUN>JUN<option value=JUL>JUL<option value=AUG>AUG<option value=SEP>SEP<option value=OCT>OCT<option value=NOV>NOV<option value=DEC>DEC
			</select>
			<select name="history_yearfrom[]">
				<?php
					for($i=date("Y");$i>=1950;$i--){
						?>
							<option value="<?php echo $i?>"><?php echo $i?></option>
						<?php
					}
				
				?>
			</select>to
			<select name="history_monthto[]">
				<option value=JAN>JAN<option value=FEB>FEB<option value=MAR>MAR<option value=APR>APR<option value=MAY>MAY<option value=JUN>JUN<option value=JUL>JUL<option value=AUG>AUG<option value=SEP>SEP<option value=OCT>OCT<option value=NOV>NOV<option value=DEC>DEC
			</select>
			<select name="history_yearto[]">
				<option value="Present">Present</option>
				<?php
					for($i=date("Y");$i>=1950;$i--){
						?>
							<option value="<?php echo $i?>"><?php echo $i?></option>
						<?php
					}
				
				?>			
			</select></td>
		<tr>
			<td align=right valign=top>Responsibilities Achievement</td><td>			<textarea name="history_responsibilities[]" cols=35 rows=7 id=textfield4></textarea></td>
</table>