<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<link href="/portal/jobseeker/js/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="css/sms_sender.css" type="text/css" rel="stylesheet"/>
		<title>SMS Communication Logs of {$candidate.fname} {$candidate.lname}</title>
		{literal}
		<style>
			body{
				font-family:Arial, Helvetica, sans-serif;
			}
		</style>
		{/literal}
	</head>
	<body>
		<div class="container main_container">
			<h4 style="text-align: center"> SMS Communication Logs of {$candidate.fname} {$candidate.lname} </h4>
			<small>
				<table class="table table-striped table-bordered" style="max-width: 900px;">
					<thead>
						<tr>
							<th style="background-color:#d9edf7">#</th>
							<th style="background-color:#d9edf7">Sender</th>
							<th style="background-color:#d9edf7">Date &amp; Time</th>
							<th style="background-color:#d9edf7">Mobile No</th>
							<th style="background-color:#d9edf7">Message</th>
						</tr>

					</thead>

					<tbody>
						{foreach from=$sms item=message name=sms_list}
						<tr>
							<td>{$smarty.foreach.sms_list.iteration}</td>
							<td> {if $message.message_type eq "admin"}
							Admin: {$message.sender}
							{else}
							Staff: {$message.sender}
							{/if} </td>
							<td>{$message.date_created}</td>
							<td>{$message.mobile_number}</td>
							<td>
							<div style="word-wrap: break-word;width:380px">
								{$message.message}
							</div></td>

						</tr>
						{/foreach}
					</tbody>

				</table> </small>

		</div>
	</body>
</html>