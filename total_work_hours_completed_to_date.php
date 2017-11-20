<?php
include('./conf/zend_smarty_conf.php');


$sql = "SELECT id, time_out, time_in , mode FROM timerecord  WHERE time_out IS NOT NULL;";
$timerecords = $db->fetchAll($sql);
$regular_hours_work =0;
$total_lunch_hours = 0;

foreach($timerecords as $timerecord){
			if($timerecord['mode'] == 'regular'){
				//time_in
				$det = new DateTime($timerecord['time_in']);
				$time_in_unix = $det->format('U');
				
				//time_out
				$det = new DateTime($timerecord['time_out']);
				$time_out_unix = $det->format('U');
				
				$work_hrs = $time_out_unix - $time_in_unix;
				$work_hrs = $work_hrs / 3600.0;
				
			    $regular_hours_work = $regular_hours_work + $work_hrs; 
				
			}else{
				//time_in
				$det = new DateTime($timerecord['time_in']);
				$time_in_unix = $det->format('U');
				
				//time_out
				$det = new DateTime($timerecord['time_out']);
				$time_out_unix = $det->format('U');
				
				$lunch_hrs = $time_out_unix - $time_in_unix;
				$lunch_hrs = $lunch_hrs / 3600.0;
				
				$total_lunch_hours = $total_lunch_hours + $lunch_hrs;
			}
}

//echo sprintf('%s %s',number_format($regular_hours_work,2,'.',','),number_format($total_lunch_hours,2,'.',','));
echo number_format(($regular_hours_work - $total_lunch_hours),2,'.',',');
exit;					
?>