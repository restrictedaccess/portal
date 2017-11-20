
function emtf() {
  window.open('http://db2.jobstreet.com/referral/refer.asp?t=1&link=' + location.href, '_mail', config='height=420,width=500,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no');
}


function opwin(url,h,w)
{
XPos = screen.availWidth/2 - w/2; 
YPos = (screen.availHeight/2 - h/2) - 50; 
var opwin = window.open(url, "newwindow", "toolbar=yes,menubar=no,scrollbars=yes,resizable=yes,location=top,status=no,width="+w+",height="+h+",ScreenX=0,ScreenY=0,Top="+YPos+",Left="+XPos); 
opwin.focus();
}

function ow(url,lk)
{
h = 550; 
w = 680;
XPos = screen.availWidth/2 - w/2; 
YPos = (screen.availHeight/2 - h/2) - 85; 
var ow = window.open(url, "newwindow", "toolbar=yes,menubar=no,scrollbars=yes,resizable=yes,location=top,status=no,width="+w+",height="+h+",ScreenX=0,ScreenY=0,Top="+YPos+",Left="+XPos); 
if (!(navigator.appName.indexOf("Netscape")!= -1 && parseInt(navigator.appVersion) == 4)) {lk.style.color = '#800080';}
ow.focus();
}

function opwin1(url,h,w)
{
theHeight = h; 
XPosition = screen.availWidth/2 - w/2; 
YPosition = screen.availHeight/2 - theHeight/2; 
	window.open(url, "newwindow", "toolbar=no,menubar=no,scrollbars=no,resizable=no,location=top,status=no,width="+w+",height="+theHeight+",ScreenX=0,ScreenY=0,Top="+YPosition+",Left="+XPosition);
}

function opwin2(url,h,w)
{
theHeight = h; 
XPosition = screen.availWidth/2 - w/2; 
YPosition = screen.availHeight/2 - theHeight/2; 
window.open(url, "newwindow", "toolbar=yes,menubar=no,scrollbars=yes,resizable=yes,location=top,status=no,width="+w+",height="+theHeight+",ScreenX=0,ScreenY=0,Top="+YPosition+",Left="+XPosition); 
}

function opwin3(url,h,w)
{
theHeight = h; 
XPosition = screen.availWidth/2 - w/2; 
YPosition = screen.availHeight/2 - theHeight/2; 
window.open(url, "newwindow", "toolbar=yes,menubar=no,scrollbars=yes,resizable=yes,location=yes,status=no,width="+w+",height="+theHeight+",ScreenX=0,ScreenY=0,Top="+YPosition+",Left="+XPosition); 
}

function popup(c,url,e) {
	var r = null;
	if(getCookie(c) == null) {
		setCookie(c, "true", e);
		r = window.open('', 'special','width=320,height=320,resizable=0');
		if (r != null) {
			if (r.opener == null) {
				r.opener = self;
			}
			r.location.href = url;
		}
	}
}

function popup2(c,url,e,wn,h,w) {
	var r = null;
	if(getCookie(c) == null) {
		setCookie(c, "true", e);
		r = window.open('', wn,'width='+w+',height='+h+',resizable=0');
		if (r != null) {
			if (r.opener == null) {
				r.opener = self;
			}
			r.location.href = url;
		}
	}
}

function popup3(url,h,w)
{
	var x= screen.availWidth/2 - w/2; 
	var y= screen.availHeight/2 - h/2; 
	window.open(url, "newwindow", "toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=top,status=no,width="+w+",height="+h+",ScreenX=0,ScreenY=0,Top="+y+",Left="+x); 
}

function getCookie(name) { 
	var re = new RegExp(name + "=([^;]+)");
	var value = re.exec(document.cookie);
	return (value != null) ? unescape(value[1]) : null;
}

function setCookie(name, value, e) { 
	// e = in minutes
	var today = new Date();
	var expiry = new Date(today.getTime() + e * 60 * 1000); // plus 1 hour
	document.cookie=name + "=" + escape(value) + "; expires=" + expiry.toGMTString();
}

function fdbk(site) {
	var s;
	if ((site==null) || (site=="")) {
		var h=location.href; 
		if ((h.indexOf("my.jobstreet.com") > 0) || (h.indexOf("www.jobstreet.com.my") > 0)) {s="my"}
		else if (h.indexOf("ph.jobstreet.com") > 0) {s="ph"} 
		else if (h.indexOf("sg.jobstreet.com") > 0) {s="sg"} 
		else if (h.indexOf("id.jobstreet.com") > 0) {s="id"} 
		else if (h.indexOf("bd.jobstreet.com") > 0) {s="bd"} 
		else if (h.indexOf("th.jobstreet.com") > 0) {s="th"} 
		else if (h.indexOf("vn.jobstreet.com") > 0) {s="vn"} 
		else if (h.indexOf("jp.jobstreet.com") > 0) {s="jp"} 
		else if ((h.indexOf("in.jobstreet.com") > 0) || (h.indexOf("www.jobstreet.co.in") > 0)) {s="in"} 
		else {s="sg"}
	}
	else {
		s=site;
	}
	popup3('http://myjobstreet.jobstreet.com/help/feedback.asp?site='+s,520,650);
}
