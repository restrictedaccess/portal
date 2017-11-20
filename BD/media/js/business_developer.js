// JavaScript Document
var PATH = 'BD/';

function ShowBDProfile(agent_no){
	
	if(!agent_no){
		alert("Business Developer ID is missing");
		return false;
	}
	var query = queryString({'agent_no' : agent_no});
	var result = doXHR(PATH + 'ShowBDProfile.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowBDProfile, OnFailShowBDProfile);
}

function OnSuccessShowBDProfile(e){
	
	
	var wd = 400;
	var hg = 100;
	
	/*var xpos = screen.availWidth/2 - wd/2; 
   	var ypos = screen.availHeight/2 - hg/2; 
	$('BD_Profile').style.left = xpos+"px";
	$('BD_Profile').style.top = ypos+"px";
	*/
	showdeadcenterdiv('BD_Profile');
	$('BD_Profile').style.display = 'block';
	$('BD_Profile').innerHTML = e.responseText;
}

function OnFailShowBDProfile(e){
	alert(e.responseText);
}

function showdeadcenterdiv(divid) { 
var Xwidth = 800 ;
var Yheight = 100;
// First, determine how much the visitor has scrolled

var scrolledX, scrolledY; 
if( self.pageYoffset ) { 
scrolledX = self.pageXoffset; 
scrolledY = self.pageYoffset; 
} else if( document.documentElement && document.documentElement.scrolltop ) { 
scrolledX = document.documentElement.scrollLeft; 
scrolledY = document.documentElement.scrolltop; 
} else if( document.body ) { 
scrolledX = document.body.scrollLeft; 
scrolledY = document.body.scrolltop; 
}

// Next, determine the coordinates of the center of browser's window

var centerX, centerY; 
if( self.innerHeight ) { 
centerX = self.innerWidth; 
centerY = self.innerHeight; 
} else if( document.documentElement && document.documentElement.clientheight ) { 
centerX = document.documentElement.clientWidth; 
centerY = document.documentElement.clientheight; 
} else if( document.body ) { 
centerX = document.body.clientWidth; 
centerY = document.body.clientheight; 
}

// Xwidth is the width of the div, Yheight is the height of the 
// div passed as arguments to the function: 
var leftoffset = scrolledX + (centerX - Xwidth) / 2; 
var topoffset = scrolledY + (centerY - Yheight) / 2; 
// the initial width and height of the div can be set in the 
// style sheet with display:none; divid is passed as an argument to // the function 
var o=document.getElementById(divid); 
var r=o.style; 
r.position='absolute'; 
r.top = topoffset + 'px'; 
r.left = leftoffset + 'px'; 
r.display = "block"; 
} 