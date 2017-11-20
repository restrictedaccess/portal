<div id="fieldcontents" class="character_reference_box">
	<div id="resultarea">
		<input type="hidden" value="{$character_reference.id}" name="id[]"/>
		<table border="0" cellspacing="0" cellpadding="0" id="applyform">
			<tr>
				<td width="200" align="right">Name:</td>
				<td width="300">
				<input type="text" class="name" value="{$character_reference.name}" name="name[]"  size="35" style="margin-bottom:10px"/>
				</td>
			</tr>
			<tr>
				<td width="200" align="right">Contact Details:</td>
				<td width="300"><textarea  class="contact_details" name="contact_details[]" cols="30" rows="5" style="margin-bottom:10px">{$character_reference.contact_details}</textarea></td>
			</tr>
			<tr>
				<td width="200" align="right">Contact Number:</td>
				<td width="300">
				<input type="text" class="contact_number" name="contact_number[]"   value="{$character_reference.contact_number}" size="35" style="margin-bottom:10px"/>
				</td>
			</tr>
			<tr>
				<td width="200" align="right">Email Address:</td>
				<td width="300">
				<input type="text"  class="email_address" name="email_address[]"  value="{$character_reference.email_address}" size="35" style="margin-bottom:10px"/>
				</td>
			</tr>
			<tr>
				<td width="200">&nbsp;</td>
				<td width="300">
				<button class="delete-character-reference" >
					Delete
				</button></td>
			</tr>

		</table>
	</div>
</div>