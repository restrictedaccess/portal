<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	<title>Compliance Reports</title>
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
<!--<span id='loading'>LOADING...</span>-->
<a href='/portal/adminHome.php'><div id='imghead'></div></a>
<div class='container'>
	<div style='float:right;padding:10px;'>
		<form id='form_filter' action='' method='get' style='float:left;'>
			<!--input type='hidden' name='item' value='myactivity'/>-->
			<span id='notice'>Reason:</span>
			<select name='notice' id='notice'>
				<option value=''>All</option>
				<option value='notlogin'>Not Logged In</option>
				<option value='runninglate'>Running Late</option>
				<option value='absent'>Absent</option>
				<option value='lunch_breaks'>Over Lunch Break</option>
				<option value='quick_breaks'>Over Short Break</option>
				<option value='disconnected'>Disconnected</option>
			</select>
			&nbsp;&nbsp;&nbsp;
			<span id='staff'>Subcontractor:</span>
			<select name='subcon' id='subcon' style='width:140px'>
				<option value=''>All</option>
				{if $subcons|@count > 0}
				{section name=idx loop=$subcons}
				<option value='{$subcons[idx].userid}'>{$subcons[idx].fname} {$subcons[idx].lname}</option>
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
		<div class='tableheader'>Compliance Reports based on Auto SMS<br/></div>
		
			
		
		<div class='staffname'></div>
		<div class='date_range'>{$results|@count} record/s found.  {$from_date} to {$to_date}</div>
		
		<div id="tabular">
			<table summary="ReportsListing">
			<tbody>
           	<tr>
				<th scope="col" class="data">
				<span class="hidden">Data Name</span>
				</th>
				<th scope="col">Staff Name</th>
				<th scope="col">Mobile Number</th>
				<th scope="col">Reason</th>
				<th scope="col">Date Occured</th>
			</tr>
				{if $results|@count > 0}
				{section name=idx loop=$results}			
					<tr>
						<td class="number">{$results[idx].date_created}</td>
						<td><a target='_blank' href='/portal/recruiter/staff_information.php?userid={$results[idx].userid}'>{$results[idx].fname} {$results[idx].lname}</a></td>
						<td>{$results[idx].mobileno}</td>
						<td>{$results[idx].notice}</td>
						<td>{$results[idx].date_reported}</td>
					</tr>
				{/section}
				{else}
				<td colspan='5'>No Records found!</td>
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
		$("select#notice option[value={/literal}{$notice}{literal}]").attr('selected', true);
		$("select#subcon option[value={/literal}{$userid}{literal}]").attr('selected', true);
	});
	</script>
	{/literal}
</body>
</html>