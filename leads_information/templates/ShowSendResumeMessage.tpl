<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$comments.subject}</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="./media/css/leads_information.css">

</head>
<body style="margin-top:0; margin-left:0; padding:0px;">
<img src="../images/remote-staff-logo.jpg" />
<hr />
<table width='100%'>
<tr>
<td width="10%">Subject</td>
<td width="90%">: {$comments.subject}</td>
</tr>

<tr>
<td width="10%">To</td>
<td width="90%">: {$comments.email}</td>
</tr>
<tr><td colspan="2"><hr /></td></tr>
<tr>
<td colspan="2" valign="top" >
	<table class='mess_box' width='100%'>
	{$comments_result}
	</table>
</td></tr>
</table>
</body>
</html>
