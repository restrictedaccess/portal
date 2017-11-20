<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Admin {$name} has beed removed from Admin Section</title>
<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel=stylesheet type=text/css href="/portal/site_media/rsadmin/css/rsadmin.css" />
</head>
<body style="margin:0;">
<div id="logo"><a href="/portal/adminHome.php"><img src="/portal/images/remote-staff-we-make-it-work.jpg" align="absmiddle" border="0" /></a></div>

<div id="content">
<div id="path_links">

<a href="/portal/adminHome.php">Admin Home</a> -> <a href="/portal/django/rsadmin/">List of Administrators</a> -> <a href="/portal/django/rsadmin/profile/{$admin_id}">{$name}</a>

</div>
<h2 align="center">Admin Users Management</h2>

<fieldset>
<legend>Admin Removed</legend>
<div class="admin_list">
<p align="center">Admin {$name} has beed removed from Admin Section.</p>
<p align="center"><input type="button" value="Back" onclick="location.href='/portal/django/rsadmin/'" /></p>
</div>
</fieldset>
<div style="height:30px; display:block;"></div>


</div>
</body>
</html>