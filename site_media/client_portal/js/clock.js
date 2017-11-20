jQuery(document).ready(function() {
	run_cheatclock();
});

cheatdays=new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun");
function run_cheatclock(){
	//get client and staff timezone	
	//var tz = new Array('Europe/London', 'PST8PDT', 'America/New_York', 'Australia/Sydney', 'Asia/Manila');
	var tz = new Array('America/New_York', 'Asia/Manila');
	var query = {'tz' : tz};
	var url = djangoBase + '/run_cheatclock/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			jQuery.each(data, function(i, item){
	       		console.log(item.year)
				cheatclock(item.hour, item.minute, item.seconds, item.timezone, item.timezone, item.weekday);
	        });
			//console.log(data[0].year)
		},
		error: function(data) {
			console.log("There's a problem in running digital clock.");
		}
	});
}


function cheatclock(chthour, chtmin, chtsec, chtzone, chtid, chtday){
	//Add 1 to the seconds
	chtsec=chtsec+1;
	//When seconds reach 60, reset seconds to 0 and increase minutes by 1
	if(chtsec>59){chtsec=0; chtmin=chtmin+1;}
	//When minutes reach 60, reset minutes to 0 and increase hour by 1
	if(chtmin>59){chtmin=0; chthour=chthour+1;}
	//If hour is 0, make hour 24 (easier maths)
	if(chthour==0){chthour=24;}
	//When hour passes 24, reset hour to 1. And update day
	if(chthour>24){chthour=1;}
	//If hour is before noon or hour is midnight, it's AM; otherwise it's PM
	if(chthour<12 || chthour==24){ap="am";} else {ap="pm";}
	//Create "outhour" variable to display a 12-hour time but keep the maths right by remembering 24-hour "chthour" variable
	outhour=chthour
	if(outhour>12){outhour=outhour-12;}
	//Add a leading zero to seconds a minutes if they are less than 10
	if(chtsec<10){secz="0";}else{secz="";}
	if(chtmin<10){minz="0";}else{minz="";}
	//Handle Sunday=0
	if(chtday==0){chtday=7;}
	//Update the day at midnight
	if(chthour>23 && chtmin==0 && chtsec==0 && chtday>0){chtday++;}
	//If day is greater than 7, reset it to 1
	if(chtday>7){chtday=1;}
	//Convert day-number to day-name
	if(chtday>0){outday=cheatdays[chtday]+" ";}else{outday="";}
	//Output the time string to the HTML element with ID CHTID
	if(chtzone == 'America/New_York'){
		jQuery('#new_york').html(outday+outhour+":"+minz+chtmin+":"+secz+chtsec+" "+ap+" USA");
	}
	if(chtzone == 'Asia/Manila'){
		jQuery('#manila').html(outday+outhour+":"+minz+chtmin+":"+secz+chtsec+" "+ap+" PHL");
	}
	//console.log(outday+outhour+":"+minz+chtmin+":"+secz+chtsec+" "+ap+" "+chtzone);
	//Tell the function to repeat every 1000ms (1 second)
	setTimeout('cheatclock('+chthour+', '+chtmin+', '+chtsec+', "'+chtzone+'", "'+chtid+'", "'+chtday+'")',1000);
}