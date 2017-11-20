<?
include '../../conf.php';
include '../../config.php';
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year) ; 

//echo $num_days;

$month_reg_days=0;
for($x=1; $x<=$num_days; $x++)										
{																	
		if($x<=9){													
			$x="0".$x;															
		}																
		$compare_date2 = $year."-".$month."-".$x;	
		$sqlDateCheck2="SELECT DAYNAME('$compare_date2');";	
		//echo $sqlDateCheck2;	
		$resultDateCheck2 = mysql_query($sqlDateCheck2);			
		list($dayname2) = mysql_fetch_array($resultDateCheck2);	
		if($dayname2=="Saturday" or $dayname2=="Sunday"){			
			//$previous_month_sat_sun++;											
		}else{													
			$month_reg_days++;
		}	
}
	echo $month_reg_days. " Regular Working Days";

?>
