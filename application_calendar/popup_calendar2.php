<html>
<head>
<style type="text/css">
body{
	width:550px;
	font-family:Arial;
}
.world_clock_container{
	width:530px;;
	height: 70px;
	background: #F1F7FD;
	padding: 10px;
}
.world_clock{
	float:left;	
	width:260px;
	margin:0px;
}
.world_clock embed{
	float:right;
} 
.world_clock img{
	margin-top:-2px;
	margin-right:-10px;
}
.planner{
	margin-top:20px;
}
table {
	width:100%;
	border-top:1px solid #999999;
	border-left:1px solid #999999;
}
td {
	text-align:left;
	border-right:1px solid #999999;
	border-bottom:1px solid #999999;
	font:12px Arial;
	padding:5px;
}

.th{
	background:#6699CC;
	font-weight:bold;
	text-align:center;
	color:#ffffff;
}
.rh{
	font-weight:bold;
	text-align:center;
}
.planner_actions{
	text-align:center;
}
#date_picker{
	margin:5px; 
	width:205px; 
	height:230px;
}
.date_picker_container{
	border: 1px solid #999999;
	padding:0px 8px 0px 5px;
	width:205px;
	margin-top:20px;
}

.planner_options{
	height:310px;
}

</style>  

<link rel="stylesheet" type="text/css" media="all" href="/portal/date_picker/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="/portal/date_picker/jsDatePick.min.1.3.js"></script>

<script type="text/javascript">

	window.onload = function(){
		g_globalObject = new JsDatePick({
			useMode:1,
			isStripped:true,
			target:"date_picker"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/

		});		

		g_globalObject.setOnSelectedDelegate(function(){
			var obj = g_globalObject.getSelectedDay();
			alert("a date was just selected and the date is : " + obj.day + "/" + obj.month + "/" + obj.year);
			//document.getElementById("div3_example_result").innerHTML = obj.day + "/" + obj.month + "/" + obj.year;
		});
	};

</script>


</head>
<body>
 
<!--world clock-->
<div class="world_clock_container">  

	<div class="world_clock">
	<img src="http://www.printableworldflags.com/icon-flags/24/Philippines.png" title="Manila" > 
	<embed src="http://www.clocklink.com/clocks/5001-blue.swf?TimeZone=GMT0800&Place=&DateFormat=YYYY-MM-DD&"  width="240" height="20"  wmode="transparent" type="application/x-shockwave-flash">
	</div>

	<div class="world_clock">
	<img src="http://www.printableworldflags.com/icon-flags/24/United%20States%20of%20America.png" title="San Francisco" >
	<embed src="http://www.clocklink.com/clocks/5001-blue.swf?TimeZone=USA_SanFrancisco&Place=&DateFormat=YYYY-MM-DD&"  width="240" height="20" wmode="transparent" type="application/x-shockwave-flash">
	</div>

	<div class="world_clock">
	<img src="http://www.printableworldflags.com/icon-flags/24/Australia.png" title="Sydney" >
	<embed src="http://www.clocklink.com/clocks/5001-blue.swf?TimeZone=Australia_Sydney&Place=&DateFormat=YYYY-MM-DD&"  width="240" height="20" wmode="transparent" type="application/x-shockwave-flash">
	</div>


	<div class="world_clock">
	<img src="http://www.printableworldflags.com/icon-flags/24/United%20States%20of%20America.png" title="New York">
	<embed src="http://www.clocklink.com/clocks/5001-blue.swf?TimeZone=USA_NewYork&Place=&DateFormat=YYYY-MM-DD&"  width="240" height="20"  wmode="transparent" type="application/x-shockwave-flash">
	</div>

	<div class="world_clock">
	<img src="http://www.printableworldflags.com/icon-flags/24/United%20Kingdom.png" title="London" >
	<embed src="http://www.clocklink.com/clocks/5001-blue.swf?TimeZone=UnitedKingdom_London&Place=&DateFormat=YYYY-MM-DD&"  width="240" height="20" wmode="transparent" type="application/x-shockwave-flash">
	</div>
				   
</div>

<div class="planner_options" >

	<div style="float:left;">
		<img src="iconss/timezone.png" style="margin:20px 0px -20px 10px;">
		<select >
			<option>- Select Timezone -</option>
		</select>
		<div class="date_picker_container">
			<div id="date_picker" ></div>
		</div>
	</div>
	
	<div style="float:right;width:300px;margin-top:75px;">
		<table cellspacing="0" cellpadding="0" style="height:240px;">
			<tr style="height:20px;">
				<td class="th" style="background:#D72020;">Active Meeting Schedule</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
	
</div>


<!--planner-->
<div class="planner">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td width="15%" class="th">Time</td>
			<td class="th" >Appointment/Event Details</td>
			<td width="10%" class="th">Action</td>
		</tr>
		<?for($i=1;$i<=12;$i++){?>
		<tr <?if($i%2 == 0) echo 'style="background:#F1F7FD;"';?>>
			<td class="rh" ><?=$i?>:00 AM</th>
			<td>&nbsp;</td>
			<td class="planner_actions" ><img src="/portal/images/add.png" title="Add appointment"></td>
		</tr>
		<?}?>
		<?for($i=1;$i<=12;$i++){?>
		<tr <?if($i%2 == 0) echo 'style="background:#F1F7FD;"';?>>
			<td class="rh" ><?=$i?>:00 PM</th>
			<td>&nbsp;</td>
			<td class="planner_actions" ><img src="/portal/images/add.png" title="Add appointment"></td>
		</tr>
		<?}?>
	</table>
</div>


 


</body>
</html>