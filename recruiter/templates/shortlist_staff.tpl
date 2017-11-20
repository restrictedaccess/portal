<html>
<head><title>Move Applicant</title>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="js/shortlist.js"></script>

<link rel="stylesheet" type="text/css" href="css/sortable.css"/>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="../category/category.css">
<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<form id="shortlist-staff" method="post" action="?userid={ $userid }">

<div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Shortlist Staff</strong></font></td></tr></table></div>

<table cellpadding="3" cellspacing="3" width="100%">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td><input style="width:100%" id="keyword" type="text" name="keyword" placeholder="Enter Job Post Title or Client's Name"/></td>
					<td width="8%"><button style="width:100%" id="search">Search</button></td>
				</tr>
			</table>
		</td>
	</tr>
    <tr>
        <td id="list">{ $output }</td>
    </tr>
    <tr>
        <td><input type="submit" value="Move to Shortlist Now" name="shortlist"></td>
    </tr>						
</table>

</form>					
</body>
</html>