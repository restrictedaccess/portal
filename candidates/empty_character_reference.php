<div class="character_reference">
	<div class="control-group">
		<button class="btn btn-mini remove_character_reference" style="float:right">
			<i class="icon-remove"></i>Delete
		</button>
	</div>
	<div class="control-group">
		<label class="control-label">Name</label>
		<div class="controls">
			<input type="text" class="span6" name="name[]"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Contact Details</label>
		<div class="controls">
			<textarea name="contact_details[]" rows="8" class="span6"></textarea>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Contact Number</label>
		<div class="controls">
			<input type="text" class="span6" name="contact_number[]"/>
		</div>
	</div>
	<div class="control-group" style="margin-bottom:3em">
		<label class="control-label">Email Address</label>
		<div class="controls">
			<input type="text" class="span6 character_email_address" name="email_address[]"/>
		</div>
	</div>
</div>
<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",

    theme : "simple",
});
</script>