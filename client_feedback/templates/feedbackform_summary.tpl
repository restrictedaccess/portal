<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	<title>Client Feedback Summary Report</title>
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
		<form id='summary_filter' action='' method='get' style='float:left;'>
			<!--input type='hidden' name='item' value='myactivity'/>-->
			<span id='show_count'>Date from:</span>
			<input type="text" id="from_date" name="from_date" value="{$from_date}" class="inputbox2" readonly style="width:100px;"/>
			&nbsp;&nbsp;
			<span id='show_count'>Date to:</span>
			<input type="text" id="to_date" name="to_date" value="{$to_date}" class="inputbox2" readonly style="width:100px;"/>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' id="filter" value='Filter' title="Submit Filter"/> &nbsp;&nbsp;
		</form>
	</div>
	<br/>
		
	<div id="staff" style="float:left;width:100%;padding-right:20px;">
		<div class='tableheader'>Client Feedback Summary<br/></div>
		
		<div class='staffname'></div>
		<div class='date_range'>{$results|@count} record/s found.  Date range: {$from_date} to {$to_date}</div>
		
		<div id="tabular">
			<table summary="ActivityListing" id="myactivity">
			<tbody>
           	<tr>
				<!--<th scope="col" class="data">
				<span class="hidden">Data Name</span>
				</th>-->
				<th scope="col">Staffing Consultant</th>
				<th scope="col">Overall Score</th>
				<th scope="col">Filled Feedback Form </th>
				<th scope="col">Total Number of feedback Form </th>
			</tr>
				{if $results|@count > 0}
				{foreach from=$results key=k item=result}
				{assign var='total_score' value=0}
					{foreach from=$result.scores item=score name=i}
						{math equation="x+y" x=$total_score y=$score assign='total_score'}
					{/foreach}
					<tr>
						<!--<td class="number"></td>-->
						<td><a href='/portal/django/rsadmin/profile/{$k}' target='_blank'>{$result.name}</a></td>
						<td>{$total_score} </td>
						<td>{if $result.filled}<a href='/portal/client_feedback/?/reports/&csro={$k}&status=1'>{$result.filled}</a>{else}0{/if}</td>
						<td><a href='/portal/client_feedback/?/reports/&csro={$k}'>{$result.scores|@count}</a></td>
					</tr>
				
				{foreachelse}
				<td colspan='7'>No Records found!</td>
				{/foreach}
				{/if}
			
			</tbody>
                    
            </table>
		</div>
		
    </div>
</div>
	<!--<div style="float:left;width:80px"><span style='color:#ff0000'>*</span></div>-->
	{literal}
	<style type='text/css'>
	div.container { padding: 20px 10%;}
	</style>
	{/literal}
</body>
</html>