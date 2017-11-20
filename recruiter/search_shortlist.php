<?php
include_once '../conf/zend_smarty_conf.php';
if (isset($_POST["keyword"])){
	$keyword = addslashes($_POST["keyword"]);
	
	$index_jobposition = "";
	$index_date = "";
	$index_client = "";
	$index_companyname = "";
	if (!empty($_POST["sorters"])){
		foreach($_POST["sorters"] as $sorter){
			if ($sorter["column"]=="jobposition"){
				$index_jobposition = $sorter["sorting"];
			}else if ($sorter["column"]=="date"){
				$index_date = $sorter["sorting"];				
			}else if ($sorter["column"]=="client"){
				$index_client = $sorter["sorting"];
			}else if ($sorter["column"]=="companyname"){
				$index_companyname = $sorter["sorting"];
			}
		}
	}
	
	$output="
	<table width=100% cellspacing=1 cellpadding=2>
	<tr>
		<td width='5%' class='td_info td_la'>#</td>
		<td width='17%' class='td_info td_la'><a href='#' class='sortable' data-column='jobposition' data-sorting='$index_jobposition'>Job Position <span class='ui-icon'></span></a></td>
		<td width='21%' class='td_info td_la'><a href='#' class='sortable' data-column='companyname' data-sorting='$index_companyname'>Company Name</a></td>
		<td width='12%' class='td_info td_la'><a href='#' class='sortable' data-column='client' data-sorting='$index_client'>Client</a></td>
		<td width='12%' class='td_info td_la'><a href='#' class='sortable' data-column='date' data-sorting='$index_date'>Date <span class='ui-icon'></span></a></td>
		<td width='14%' class='td_info td_la'>Outsourcing Model</td>
		<td width='10%' class='td_info td_la'>Status</td>
	</tr>";
	$sorters = array();
	if ($keyword!=""){
		
		$query="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y') as date,p.outsourcing_model, p.companyname, p.jobposition,p.status,l.fname,l.lname,p.lead_id, CONCAT(l.fname, ' ', l.lname) AS full_clientname, UNIX_TIMESTAMP(p.date_created) AS timestamp_date  
		FROM posting p JOIN leads l ON l.id = p.lead_id WHERE p.status='ACTIVE' AND (p.jobposition LIKE '%{$keyword}%' OR CONCAT(l.fname, ' ', l.lname) LIKE '%{$keyword}%' OR l.fname LIKE '%{$keyword}%' OR l.lname LIKE '%{$keyword}%') GROUP BY p.date_created ";
		
	}else{
		$query="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y') as date,p.outsourcing_model, p.companyname, p.jobposition,p.status,l.fname,l.lname,p.lead_id, CONCAT(l.fname, ' ', l.lname) AS full_clientname, UNIX_TIMESTAMP(p.date_created) AS timestamp_date   
			FROM posting p JOIN leads l ON l.id = p.lead_id WHERE p.status='ACTIVE' GROUP BY p.date_created ";	
	}
	if (!empty($_POST["sorters"])){
		foreach($_POST["sorters"] as $sorter){
			if ($sorter["column"]=="jobposition"){
				if ($sorter["sorting"]!=""){
					$sorters[] = "jobposition ".$sorter["sorting"];
				}
			}else if ($sorter["column"]=="date"){
				if ($sorter["sorting"]!=""){
					$sorters[] = "timestamp_date ".$sorter["sorting"];				
				}
			}else if ($sorter["column"]=="client"){
				if ($sorter["sorting"]!=""){
					$sorters[] = "full_clientname ".$sorter["sorting"];
				}
			}else if ($sorter["column"]=="companyname"){
				if ($sorter["sorting"]!=""){
					$sorters[] = "companyname ".$sorter["sorting"];
				}
			}
		}
	}
	if (count($sorters)>0){
		$query.=" ORDER BY ".implode(",", $sorters);
	}else{
		$query.=" ORDER BY p.date_created DESC;";
	}
	$result = $db->fetchAll($query);
	$counter = 0;
	foreach($result as $r)
	{
		$counter++;
		$output.="
		<tr>
			<td width='5%' class='td_info td_la'><font size='1'>".$counter.") <input type='radio' name='position' value='".$r['id']."' onClick='fillAds(this.value)' /></font></td>
			<td width='17%' class='td_info'><font size='1'><a href='/portal/ads.php?id=".$r['id']."' target='_blank' >".$r['jobposition']."</a></font></td>
			<td width='21%' class='td_info'>".$r['companyname']."</td>
			<td width='12%' class='td_info'><b><font size='1'>
				<a href='#'onClick=javascript:popup_win('./../leads_information.php?id=".$r['lead_id']."',800,600);>".$r['fname']."&nbsp;".$r['lname']."</td>
			<td width='12%' class='td_info'>".$r['date']."</td>
			<td width='14%' class='td_info'>".$r['outsourcing_model']."</td>
			<td width='10%' class='td_info'>".$r['status']."</td>
		</tr>";
	}
	if($counter == 0)
	{
		$output.="<tr><td colspan=7 height=100>Sorry, No results found.</td></tr>";
	}
	$output .= "</table>";
	echo $output;
}else{
	echo "";
}