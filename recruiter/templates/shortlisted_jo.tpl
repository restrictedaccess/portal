<!DOCTYPE html>
<html>
	<head>
		<title>{$admin_name} - {if $shortlist_type}{$shortlist_type}{else}All{/if} - Recruitment Team Shortlist</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>
		
		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		{literal}
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(".popup").live("click", function(e){
					var href = jQuery(this).attr("href")
					window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
					e.preventDefault()
				})
			})
		</script>	
		{/literal}
	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">{$admin_name} - {if $shortlist_type}{$shortlist_type}{else}All{/if}</h2>

		<table id='contract_list_table'>
			<thead>
				<tr>
					<th>#</th>
					<th>Staff Name</th>
					<th>Date Shortlisted</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$shortlisted_staff item=staff name=shortlisted}
					<tr>
						<td>{$smarty.foreach.shortlisted.iteration}</td>
						<td><a href='/portal/recruiter/staff_information.php?userid={$staff.userid}&page_type=popup' class='popup'>{$staff.fullname}</a></td>
						<td>{$staff.date}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</body>
</html>