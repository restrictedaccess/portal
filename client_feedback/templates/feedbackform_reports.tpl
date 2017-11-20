<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	<title>Client Feedback Reports</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<!--<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />-->
    <link rel="stylesheet" type="text/css" href="static/styles.css" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="/portal/js/jquery.js"><\/script>')</script>

	<script type="text/javascript" src="/portal/js/jscal2.js"></script>
	<script type="text/javascript" src="/portal/js/lang/en.js"></script>
	<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
	
	<link rel="stylesheet" type="text/css" href="/portal/aclog/css/styles.css" />
	<script type="text/javascript" src="static/reports.js"></script>
</head>
<body>
<iframe id='ajaxframe' name='ajaxframe' style='display:none;height:10px;' src='javascript:false;'></iframe>
<span id='loading'>LOADING...</span>
<a href='/portal/adminHome.php'><div id='imghead'></div></a>
<div class='container'>
	<div style='float:right;padding:10px;'>
		<form id='filter_form' action='' method='get' style='float:left;'>
			<!--input type='hidden' name='item' value='myactivity'/>-->
			<span id='cat'>Client:</span>
			<select name='client' id='client' style='width:150px'>
				<option value=''>All</option>
				{if $clients|@count > 0}
				{section name=idx loop=$clients}
				<option value='{$clients[idx].id}'>{$clients[idx].fname} {$clients[idx].lname}</option>
				{/section}
				{/if}
			</select>
			&nbsp;&nbsp;&nbsp;
			<span id='status'>Status:</span>
			<select name='status' id='status'>
				<option value=''>All</option>
				<option value='1'>Filled</option>
				<option value='0'>Not Filled</option>
			</select>
			&nbsp;&nbsp;&nbsp;
			<span id='cat'>CSRO:</span>
			<select name='csro' id='csro' style='width:140px'>
				<option value=''>All</option>
				{if $csro|@count > 0}
				{section name=idx loop=$csro}
				<option value='{$csro[idx].admin_id}'>{$csro[idx].admin_fname} {$csro[idx].admin_lname}</option>
				{/section}
				{/if}
			</select>
			&nbsp;&nbsp;
			<span id='show_count'>Date from:</span>
			<input type="text" id="from_date" name="from_date" value="{$from_date}" class="inputbox2" readonly style="width:100px;"/>
			&nbsp;&nbsp;
			<span id='show_count'>Date to:</span>
			<input type="text" id="to_date" name="to_date" value="{$to_date}" class="inputbox2" readonly style="width:100px;"/>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' id="filter" value='Filter' title="Submit Filter"/> &nbsp;&nbsp;
			<!--<input type='button' id="reset" value='Reset' title="Reset filter"/>
			<a href='javascript:void(0);' onclick='class_seat.daycount(1);'>1 day</a>
			<input type='button' class='button' value="Filter Date" name='submit' id='filterdate'/>-->
		</form>
	</div>
	<br/>
		
	<div id="staff" style="float:left;width:100%;padding-right:20px;">
		<div class='tableheader'>Client Feedback Form Reports<br/></div>
		
			
		
		<div class='staffname'></div>
		<div class='date_range'>{$result|@count} generated feedback found.  Status {$status}, from {$from_date} to {$to_date}</div>
		
		<div id="tabular">
			<table summary="ActivityListing" id="myactivity">
			<tbody>
           	<tr>
				<th scope="col" class="data">
				<span class="hidden">Data Name</span>
				</th>
				<th scope="col">Client Name</th>
				<th scope="col">Staffing Consultant</th>
				<th scope="col">Feedback Form Link</th>
				<th scope="col">Form Status</th>
				<th scope="col">Ticket#</th>
				<th scope="col" style='width:20%'>Need Reply</th>
				<th scope="col">Score</th>
			</tr>
			
				{if $result|@count > 0}
				{section name=idx loop=$result}
				{assign var='score' value=0}
					{assign var='answers' value=$result[idx].answers|unserialize}
					{assign var='clunder' value=$answers.clunder}
					
					{if $answers}
					{math equation="x+y" x=$score y=$scoring[$answers.clunder] assign='score'}
					{math equation="x+y" x=$score y=$scoring[$answers.poprof] assign='score'}
					{math equation="x+y" x=$score y=$scoring[$answers.cleardef] assign='score'}
					{math equation="x+y" x=$score y=$scoring[$answers.rate] assign='score'}
					{math equation="x+y" x=$score y=$scoring[$answers.ovrallcustxp] assign='score'}
					{/if}
					
					<tr>
						<td class="number">{$result[idx].form_created}</td>
						<td><a target='_blank' href='/portal/leads_information.php?id={$result[idx].leads_id}'>{$result[idx].fname} {$result[idx].lname}</a></td>
						<td><a href='/portal/django/rsadmin/profile/{$result[idx].admin_id}' target='_blank'>{$result[idx].admin_fname} {$result[idx].admin_lname}</a></td>
						<td><a target='_blank' href='{$rs_site}/portal/client_feedback/?/form/{$result[idx].hash}'>{$result[idx].hash}</a></td>
						<td>{$result[idx].status}</td>
						<td><a target='_blank' href='{$rs_site}/portal/ticketmgmt/ticket.php?/ticketinfo/{$result[idx].ticket_id}'>{$result[idx].ticket_id}</a></td>
						<td>{if $result[idx].reply eq 'yes'}<a href='mailto:{$answers.email}'>{$answers.email}</a>{else}No{/if}</td>
						<td>{$score}</td>
					</tr>
				
				{sectionelse}
				<td colspan='7'>No Records found!</td>
				{/section}
				{/if}
			
			</tbody>
                    
            </table>
		</div>
		
    </div>
</div>
	<!--<div style="float:left;width:80px"><span style='color:#ff0000'>*</span></div>-->
	{literal}
	<script type='text/javascript'>
	jQuery(document).ready(function($) {
		console.log('{/literal}{$status}{literal}');
		//$("select#status").val('{/l');
		$("select#client option[value={/literal}{$leads_id}{literal}]").attr('selected', true);
		$("select#csro option[value={/literal}{$csro_val}{literal}]").attr('selected', true);
		$("select#status option").filter(function() {
			return $(this).text() == '{/literal}{$status}{literal}'; 
		}).attr('selected', true);
	});
	</script>
	{/literal}
</body>
</html>