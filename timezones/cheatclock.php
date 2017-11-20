<?php

$dt = new DateTime("now", new DateTimeZone('Europe/London'));
$offset_london = $dt->format('O')/100;
$dst_london = '';
if ($dt->format('I')) {
    $dst_london = 'DST';
}

$dt = new DateTime("now", new DateTimeZone('PST8PDT'));
$offset_sf = $dt->format('O')/100;
$dst_sf = '';
if ($dt->format('I')) {
    $dst_sf = 'DST';
}

$dt = new DateTime("now", new DateTimeZone('America/New_York'));
$offset_ny = $dt->format('O')/100;
$dst_ny = '';
if ($dt->format('I')) {
    $dst_ny = 'DST';
}

$dt = new DateTime("now", new DateTimeZone('Australia/Sydney'));
$offset_syd = $dt->format('O')/100;
$dst_syd = '';
if ($dt->format('I')) {
    $dst_syd = 'DST';
}

$dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
$offset_ph = $dt->format('O')/100;
$dst_ph = '';
if ($dt->format('I')) {
    $dst_ph = 'DST';
}


// SETUP SECTION
//site references about the timezones
// - http://www.timeanddate.com/worldclock/city.html?n=224
$clocks=array(
	"london" => array("code" => $dst_london, "offset" => $offset_london), // 0 no DST GMT/ +1 BST with DST march 28 2010 to oct 31 2010
	"sanfran" => array("code" => $dst_sf, "offset" => $offset_sf), // -8 PST no DST / -7 PDT with DST	march 14 2010 to nov 7 2010
	"newyork" => array("code" => $dst_ny, "offset" => $offset_ny),  // -5 EST no DST / -4 EDT with DST	march 14 2010 to nov 7 2010
	"sydney" => array("code" => $dst_syd, "offset" => $offset_syd), //+11 daylight savings DST / GMT +10
	"manila"=> array("code" => $dst_ph, "offset" => $offset_ph)
);
// END OF SETUP SECTION

header("content-type: application/x-javascript");

?>

// ==============================================
//              Timezone Cheat Clock
// ==============================================
//          Version "Echo"  (2008-01-24)
//
//  http://www.6times9.com/javascript/cheatclock
//
//        Copyright 2006  Richard Winskill
// ==============================================

<?php 

$utc=time()-date("Z"); //Timecode for UTC

echo "function run_cheatclock(){\n";
foreach($clocks as $id => $details){
	$timecode=$utc+($details["offset"]*3600);
	echo "\t".'cheatclock('.date("G, i, s", $timecode).', "'.$details["code"].'", "'.$id.'", '.date("w", $timecode).');'."\n";
}
echo "}\n";

?>

cheatdays=new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun");

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
	document.getElementById(chtid).innerHTML=outday+outhour+":"+minz+chtmin+":"+secz+chtsec+" "+ap+" "+chtzone;
//Tell the function to repeat every 1000ms (1 second)
	setTimeout('cheatclock('+chthour+', '+chtmin+', '+chtsec+', "'+chtzone+'", "'+chtid+'", "'+chtday+'")',1000);
}

//Handle other window.onload's
var prevonload=window.onload;
if(typeof(prevonload)=="function"){window.onload=function(){prevonload();run_cheatclock()}; }else{ window.onload=function(){run_cheatclock()}; }
