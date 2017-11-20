<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add evaluation notes</title>
	<script type="text/javascript" src="../media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/add_evaluation_comments.js"></script>
	
</head>

<body>
	<form id="add-evaluation-comments" method="POST">
		<label style="margin-bottom:0.5em">Evaluation notes for: {$fname}</label><br/>
		<input type="hidden" value="{$userid}" name="userid"/>
		<textarea style="margin-bottom:0.5em;width:400px;height:141px;" rows="5" cols="20" name="notes"></textarea><br/>
		<button type="submit" id="add" style="padding:0.2em">Add evaluation note</button>
	</form>
	<script type="text/javascript">
	{literal}
		tinyMCE.init({
		    mode : "textareas",
		    theme : "simple",
		});
	{/literal}
	</script>
</body>
</html>