<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$status} List</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">
</head>

<body> 

<table align="center" class='sortable' cellspacing="0" style="width:98%;border:2px solid #d9d9d9;margin: 10px;">
	<thead>
		<tr>
			<th colspan='4' style="font:Verdana; font-size:14px; color:#FFFFFF; padding: 10px 0px; background:#158cba;">{$applicant.fname} {$applicant.lname}</th>
		</tr>
		<tr style="text-align:left;background:#75caeb;padding:5px 0px;font:Verdana; font-size:13px; color:#666666;">
			<th>Lead</th>
			<th>Job Advertisement</th>
			<th>Date {$status}</th>
			<th>Admin</th>
		</tr>
	</thead> 

	<tbody>
		{foreach from=$list item=list}
		<tr style="vertical-align:top;background:{cycle values='#f9f9f9,#FFFFFF'}; font-size:12px;" >  
			<td>{$list.fname} {$list.lname}</td>
			<td>{if $list.jobposition neq ''}{$list.jobposition}{else}{$list.sub_category_name}{/if}</td>
			<td>{$list.date_listed}</td>
			<td>{$list.admin_fname} {$list.admin_lname}</td>
		</tr>
		{/foreach}
	</tbody>
	 
</table>
	
</body>

</html>