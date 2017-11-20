//Splash Page script- http://www.dynamicdrive.com/
//Created: August 17th, 2007'
var flag = document.getElementById('flag').value;


var splashpage={
// Splash Page Script Activation (1=enabled, 0=completely disabled!)
mode : flag,
splashenabled: flag,

//1) URL to file on your server to display as the splashpage
splashpageurl: "hsbc.php",

//2) Enable frequency control? (1=yes, 0=no)
enablefrequency: 0,

//3) display freqency: "sessiononly" or "x days" (string value). Only applicable if 3) above is enabled
displayfrequency: "2 days",

//4) HTML for the header bar portion of the Splash Page
// Make sure to create a link that calls "javascript:splashpage.closeit()")
// An IE bug means you should not right align any image within the bar, but instead use "position:absolute" and the "right" attribute

defineheader: '<div style="padding: 5px; color: white; font: bold 16px Verdana; background: black url(blockdefault.gif) center center repeat-x;"><a style="position:absolute; top: 2px; right: 5px" href="javascript:splashpage.closeit()" title="Skip to Content"><img src="images/skip.gif" border="0" width="114px" height="23px" /></a>Important Letter about Payroll from Admin</div>',

//5) cookie setting: ["cookie_name", "cookie_path"]
cookiename: ["splashpagecookie", "path=/"],

//6) Auto hide Splash Page after x seconds (Integer value, 0=no)?
autohidetimer: 0,

////No need to edit beyond here//////////////////////////////////

launch:false,
browserdetectstr: (window.opera&&window.getSelection) || (!window.opera && window.XMLHttpRequest), //current browser detect string to limit the script to be run in (Opera9 and other "modern" browsers)

output:function(){
	document.write('<div id="slashpage" style="position: absolute; z-index: 100; color: white; background-color:white">') //Main splashpage container
	document.write(this.defineheader) //header portion of splashpage
	document.write('<iframe name="splashpage-iframe" src="about:blank" style="margin:0; padding:0; width:100%; height: 100%"></iframe>') //iframe
	document.write('<br />&nbsp;</div>')
	this.splashpageref=document.getElementById("slashpage")
	this.splashiframeref=window.frames["splashpage-iframe"]
	this.splashiframeref.location.replace(this.splashpageurl) //Load desired URL into splashpage iframe
	this.standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body
	if (!/safari/i.test(navigator.userAgent)) //if not Safari, disable document scrollbars
	this.standardbody.style.overflow="hidden"
	this.splashpageref.style.left=0
	this.splashpageref.style.top=0
	this.splashpageref.style.width="100%"
	this.splashpageref.style.height="100%"
	this.moveuptimer=setInterval("window.scrollTo(0,0)", 50)
},

closeit:function(){
	clearInterval(this.moveuptimer)
	this.splashpageref.style.display="none"
	this.splashiframeref.location.replace("about:blank")
	this.standardbody.style.overflow="auto"
},

init:function(){
	if (this.enablefrequency==1){ //if frequency control turned on
		if (/sessiononly/i.test(this.displayfrequency)){ //if session only control
			if (this.getCookie(this.cookiename[0]+"_s")==null){ //if session cookie is empty
				this.setCookie(this.cookiename[0]+"_s", "loaded")
				this.launch=true
			}
		}
		else if (/day/i.test(this.displayfrequency)){ //if persistence control in days
			if (this.getCookie(this.cookiename[0])==null || parseInt(this.getCookie(this.cookiename[0]))!=parseInt(this.displayfrequency)){ //if persistent cookie is empty or admin has changed number of days to persist from that of the stored value (meaning, reset it)
				this.setCookie(this.cookiename[0], parseInt(this.displayfrequency), parseInt(this.displayfrequency))
				this.launch=true
			} 
		}
	}
	else //else if enablefrequency is off
		this.launch=true
	if (this.launch){
		this.output()
		if (parseInt(this.autohidetimer)>0)
			setTimeout("splashpage.closeit()", parseInt(this.autohidetimer)*1000)
	}
},

getCookie:function(Name){
	var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
	if (document.cookie.match(re)) //if cookie found
		return document.cookie.match(re)[0].split("=")[1] //return its value
	return null
},

setCookie:function(name, value, days){
	var expireDate = new Date()
	//set "expstring" to either an explicit date (past or future)
	if (typeof days!="undefined"){ //if set persistent cookie
		var expstring=expireDate.setDate(expireDate.getDate()+parseInt(days))
		document.cookie = name+"="+value+"; expires="+expireDate.toGMTString()+"; "+splashpage.cookiename[1] //last portion sets cookie path
	}
else //else if this is a session only cookie setting
	document.cookie = name+"="+value+"; "+splashpage.cookiename[1] //last portion sets cookie path
}

}


if (splashpage.browserdetectstr && splashpage.splashenabled==1 && flag == 1)
splashpage.init()

