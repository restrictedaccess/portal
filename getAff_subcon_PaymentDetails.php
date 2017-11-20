<?
include 'time.php';

class Payments
{

	function PaymentsSubTotal()
	{
		//echo $this->leads_id;
		//$thismonth = ( int ) date( "m" );
		$thismonth = $this->month;
		//$thismonth = $this->year;
		//echo $thismonth;
		$thisyear = $this->year;
    	// find out the number of days in the month
    	$numdaysinmonth = cal_days_in_month( CAL_GREGORIAN, $thismonth, $thisyear );
		//$numberofdayswork=0;
			
		$sql="SELECT userid FROM subcontractors  WHERE leads_id = $this->leads_id AND agent_id = $this->agent_no  ORDER BY id ASC;";
		$result= mysql_query($sql);
		$count=@mysql_num_rows($result); // no. of subcon
		while(list($userid)=mysql_fetch_array($result))
		{
			//check the subcon dayswork in this current month
			for( $i = 01; $i <= $numdaysinmonth; $i++ )
		    {
			if(strlen($i)==1) $i="0".$i;
			if(strlen($thismonth)==1) $thismonth="0".$thismonth;
			$date_today_str = $thisyear."-".$thismonth."-".$i;
			$date_end_str = $thisyear."-".$thismonth."-".$i;
			$query = "SELECT * FROM timerecord t
				   WHERE t.userid = $userid 
				   AND DATE(time_in) 
				  BETWEEN '$date_today_str' 
				  AND '$date_end_str' 
				  AND mode='regular' 
				  ORDER by time_in";
				  
			//echo $query;	  
			$res = mysql_query($query);
			$check=@mysql_num_rows($res);
				if($check > 0)
				{
					$numberofdayswork++;
				}
			}	
			
		}
		
		$dayswork = $numberofdayswork;
		$query="SELECT * FROM agent  WHERE agent_no = $this->agent_no";
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		$commission_type =$row['commission_type'];
		if($commission_type == "LOCAL")
		{
			$commission_rate = 90;
			$percent = 0;
			$GST ="0.00";
		}
		elseif($commission_type == "INTERNATIONAL")
		{
		
			$commission_rate = 90;
			//$percent = .10;
			$GST =  ($commission_rate / 11); // Getting the figure of 10%;
			$commission_rate = ($commission_rate - $GST);
		}
		else
		{
			$commission_rate = 0;
			$percent = 0;
		}
     	//echo c; // no. of subcon
		//echo $dayswork;
		$commission = (((($commission_rate *  12 ) / 52 ) / 5) * $dayswork);
		//$GST = ($commission * $percent);
		
		//echo "\$ ".$commission."<br>";
		//echo "Commission rate ".$commission_rate;
		$total_commission = number_format(( $commission  ),2);
		echo "<span style='width:120px;background:#D2FFD2; float:left;margin-left:1px; padding:1px; ' ><small><img src='images/subcon10.png' />Sub-Contractor : ".$count."</small></span>";
		echo "<span style='width:80px;background:#D2FFD2; float:left;margin-left:1px; padding:1px; ' ><small>Total Days : ".$dayswork."</small></span>";
		echo "<span style='width:100px;background:#D2FFD2; float:left;margin-left:1px; padding:1px; text-align:right ' ><small><b>\$ ".$total_commission."</b></small></span>";
		
	}
	function PaymentsTotal()
	{
		//echo $this->agent_no;
		//$thismonth = ( int ) date( "m" );
		$thismonth = $this->month;
		$thisyear = $this->year;
    	// find out the number of days in the month
    	$numdaysinmonth = cal_days_in_month( CAL_GREGORIAN, $thismonth, $thisyear );
		
		
		$query="SELECT DISTINCT(l.id)
				FROM leads l
				JOIN subcontractors s ON s.leads_id = l.id
				WHERE l.status = 'Client' AND l.agent_id =$this->agent_no ORDER BY timestamp DESC;;";
		$result=mysql_query($query);
		$ctr=@mysql_num_rows($result);
		while(list($leads_id)=mysql_fetch_array($result))
		{
			$sql="SELECT userid FROM subcontractors  WHERE leads_id = $leads_id AND agent_id = $this->agent_no  ORDER BY id ASC;";
			$result2 = mysql_query($sql);
			while(list($userid)=mysql_fetch_array($result2))
			{
				//check the subcon dayswork in this current month
				
				for( $i = 01; $i <= $numdaysinmonth; $i++ )
			    {
					if(strlen($i)==1) $i="0".$i;
					if(strlen($thismonth)==1) $thismonth="0".$thismonth;
					$date_today_str = $thisyear."-".$thismonth."-".$i;
			        $date_end_str = $thisyear."-".$thismonth."-".$i;
					$sql2 = "SELECT * FROM timerecord t
					      WHERE t.userid = $userid 
				   		  AND DATE(time_in) 
						  BETWEEN '$date_today_str' 
						  AND '$date_end_str' 
						  AND mode='regular' 
				  		 ORDER by time_in";
					$result3 = mysql_query($sql2);
					$check=@mysql_num_rows($result3);
					if($check > 0)
					{
						$numberofdayswork++;
					}
				}	
				$dayswork = $numberofdayswork;
			}
		}
		//echo $dayswork;
		$query="SELECT * FROM agent  WHERE agent_no = $this->agent_no";
		//echo $query;
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		$commission_type =$row['commission_type'];
		if($commission_type == "LOCAL")
		{
			$commission_rate = 90;
			$percent = 0;
			$GST ="0.00";
		}
		elseif($commission_type == "INTERNATIONAL")
		{
		
			$commission_rate = 90;
			//$percent = .10;
			$GST =  ($commission_rate / 11); // Getting the figure of 10%;
			$commission_rate = ($commission_rate - $GST);
		}
		else
		{
			$commission_rate = 0;
			$percent = 0;
		}
		//echo $GST;
		$commission = (((($commission_rate *  12 ) / 52 ) / 5) * $dayswork);
		//echo number_format($commission,2);
		$net = number_format($commission,2);
		echo "\$ ".$net;
		echo "<br> + GST ".number_format($GST,2);
		echo "<br>---------------";
		echo "<br><b>" .number_format(($commission + $GST),2)."</b>";
	}
	//
	function CheckSubconSalary()
	{
		//global $a;
		$query="SELECT php_daily FROM subcontractors WHERE userid = $this->userid";
		$result = mysql_query($query);
		if(!$result){
			echo mysql_error();
		}
		else{
			//echo $userid;
			list($daily) = mysql_fetch_array($result);
			if($daily == null){
			    echo "<span style='float:left;'>".$this->subcon_name."</span>";
				echo "<span style='float:right; color:#999999'><small>No Salary Details</small></span>";
			}else{
				echo "<span >".$this->subcon_name."</span>";
			}
	
		}
	
	}
	/// Determine the Commission rate type of the Affiliate
	/*
	function CommissionType()
	{
		$query="SELECT * FROM agent  WHERE agent_no = $this->agent_no";
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		$commission_type =$row['commission_type'];
		if($commission_type == "LOCAL")
		{
			$_SESSION['commission_rate'] = 81;
		}
		elseif($commission_type == "INTERNATIONAL")
		{
			$_SESSION['commission_rate'] = 90;
		}
		else
		{
			$_SESSION['commission_rate']=0;
		}
		
	}
	*/
	///
	
	function checkTimeSheets()
	{
		//$thismonth = ( int ) date( "m" );
		$thismonth = $this->month;
	    $thisyear = $this->year;
        // find out the number of days in the month
    	$numdaysinmonth = cal_days_in_month( CAL_GREGORIAN, $thismonth, $thisyear );
		$numberofdayswork=0;
		for( $i = 01; $i <= $numdaysinmonth; $i++ )
		{
			//echo $i."<br>";
			if(strlen($i)==1) $i="0".$i;
			if(strlen($thismonth)==1) $thismonth="0".$thismonth;
			$date_today_str = $thisyear."-".$thismonth."-".$i;
			$date_end_str = $thisyear."-".$thismonth."-".$i;
			$query = "SELECT * FROM timerecord t
				   WHERE t.userid = $this->userid 
				   AND DATE(time_in) 
				  BETWEEN '$date_today_str' 
				  AND '$date_end_str' 
				  AND mode='regular' 
				  ORDER by time_in";
				  
			$result = mysql_query($query);

			if(!$result){
				echo mysql_error();
			}
			else{
				$check=@mysql_num_rows($result);
				if($check > 0)
				{
					$numberofdayswork++;
				}
				
			}
			
		}
		///
		$query="SELECT * FROM agent  WHERE agent_no = $this->agent_no";
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		$commission_type =$row['commission_type'];
		if($commission_type == "LOCAL")
		{
			$commission_rate = 90;
			$percent = 0;
			$GST ="0.00";
		}
		elseif($commission_type == "INTERNATIONAL")
		{
		
			$commission_rate = 90;
			//$percent = .10;
			$GST =  ($commission_rate / 11); // Getting the figure of 10%;
			$commission_rate = ($commission_rate - $GST);
		}
		else
		{
			$commission_rate = 0;
			$percent = 0;
		}
		$rate = number_format(((($commission_rate *  12 ) / 52 ) / 5),2);
		echo "<span style='float:left; width:110px;  ' >Days Work/Month : ".$numberofdayswork."</span>";
		echo "<span style='float:right; width:100px;  text-align:right; '>(".$numberofdayswork." X " .$rate." + ".$gst.")</span>";
		
	}
	
	
	
	function ProcessAffiliatesCommission()
	{
		// Determine the Subcon day work in a month
		//$thismonth = ( int ) date( "m" );
		$thismonth = $this->month;
	    $thisyear = $this->year;
        // find out the number of days in the month
    	$numdaysinmonth = cal_days_in_month( CAL_GREGORIAN, $thismonth, $thisyear );
		$numberofdayswork=0;
		for( $i = 01; $i <= $numdaysinmonth; $i++ )
		{
			//echo $i."<br>";
			if(strlen($i)==1) $i="0".$i;
			if(strlen($thismonth)==1) $thismonth="0".$thismonth;
			$date_today_str = $thisyear."-".$thismonth."-".$i;
			$date_end_str = $thisyear."-".$thismonth."-".$i;
			$query = "SELECT * FROM timerecord t
				   WHERE t.userid = $this->userid 
				   AND DATE(time_in) 
				  BETWEEN '$date_today_str' 
				  AND '$date_end_str' 
				  AND mode='regular' 
				  ORDER by time_in";
				  
			$result = mysql_query($query);

			if(!$result){
				echo mysql_error();
			}
			else{
				$check=@mysql_num_rows($result);
				if($check > 0)
				{
					$numberofdayswork++;
				}
				
			}
			
		}
		$dayswork = $numberofdayswork;
		
		// NOte : mUst get the commission rate if the Affiliate is LOCAL = $81 + GST? or INTERNATIONAL = $90 + GST?
		$query="SELECT * FROM agent  WHERE agent_no = $this->agent_no";
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		$commission_type =$row['commission_type'];
		if($commission_type == "LOCAL")
		{
			$commission_rate = 90;
			$percent = 0;
			$GST ="0.00";
		}
		elseif($commission_type == "INTERNATIONAL")
		{
		
			$commission_rate = 90;
			//$percent = .10;
			$GST =  ($commission_rate / 11); // Getting the figure of 10%;
			$commission_rate = ($commission_rate - $GST);
		}
		else
		{
			$commission_rate = 0;
			$percent = 0;
		}
		
		
		
		//$dayswork = $_SESSION['dayswork'];
		$commission = (((($commission_rate *  12 ) / 52 ) / 5) * $dayswork);
		$GST = ($commission * $percent);
		
		//echo "\$ ".$commission."<br>";
		//echo "Commission rate ".$commission_rate;
		$total_commission = number_format(( $commission + $GST ),2);
		echo "<small><span style='width:78px;' ><b>\$ ".$total_commission."</b></span></small>";
		 // clear the session background:#D2FFD2;
		//$_SESSION['dayswork']="";
		//$_SESSION['daily'] ="";
		//$_SESSION['commission_rate']="";
	}
	
	
	
	
	
	
	
	
	
	
///
}
?>