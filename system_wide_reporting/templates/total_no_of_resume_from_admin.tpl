<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>List of Resume From Admin</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../system_wide_reporting/media/css/system_wide_reporting.css">
</head>
<body id="applicant_list" style="margin-top:0; margin-left:0">
<form name="form" method="post">
<h3 align="center">RESUME FROM ADMIN</h3>
<div class='pagination'>{$paging}<b>{$row_results} records</b></div>
<table align="center" border="1" cellpadding="5">
{foreach from=$applicants name=applicant item=applicant}
<tr>        
	<td><!--{$smarty.foreach.applicant.iteration}-->{$applicant.counter}</td>
    <td>{$applicant.fname} {$applicant.lname}</td>
    <td>{$applicant.email}</td>
    <td>{$applicant.date_created}</td>
</tr>
{/foreach}
</table>
</form>
</body>
</html>