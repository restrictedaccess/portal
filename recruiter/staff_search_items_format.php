<?php
	//start: report formating
	if($status == "SENT") 
	{ 
		$sent_field = "<td class=\"td_info td_la\" width=\"50%\">Date/Time Sent</td>"; 
		$pages_div = "<div id='sent_items_pages'>".$pages."</div>";
	}
	else
	{
		$pages_div = "<div id='waiting_items_pages'>".$pages."</div>";
	}
	$data_items .= '
	<table width=100% cellpadding=3 cellspacing="0" border=0>
		<tr>
			<td class="td_info td_la" width="0" colspan=4 align=right>'.$pages_div.'</td>
		</tr>
		<tr>
			<td class="td_info td_la" width="0">#</td>
			<td class="td_info td_la" width="25%">Name</td>
			<td class="td_info td_la" width="25%">Email</td>
			'.$sent_field.'
		</tr>';
		
	$set = ($p-1)*$maxp ;
	if ($found[0]['max'] <> 0) 
	{
		$total = count($found);
		for ($x=0; $x < $total; $x++) 
		{
			$date_sent = "";
			if($status == "SENT")
			{
				$date_sent = "<td class=\"td_info\">".$found[$x]['mass_emailing_date_executed']."</td>";
			}
			$num = $set + $x + 1;
			$data_items .= '
			<tr>
				<td class="td_info td_la">'.$num.'</td>
				<td class="td_info">'.$found[$x]['fname']." ".$found[$x]['lname'].'</td>
				<td class="td_info">'.$found[$x]['email'].'</td>
				'.$date_sent.'
			</tr>';	
		}
	} 
	$data_items .= '
		<tr>
			<td class="td_info td_la" width="0" colspan=4 align=right>'.$pages_div.'</td>
		</tr>	
	</table>';
	//ended: report formating
?>