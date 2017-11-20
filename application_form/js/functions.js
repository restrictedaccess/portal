
function popup_win( loc, wd, hg ) {
   var remote = null;
   var xpos = screen.availWidth/2 - wd/2; 
   var ypos = screen.availHeight/2 - hg/2; 
   remote = window.open('','','width=' + wd + ',height=' + hg + ',resizable=0,scrollbars=1,screenX=0,screenY=0,top='+ypos+',left='+xpos);
   if (remote != null) {
      if (remote.opener == null) {
         remote.opener = self;
      }
      remote.location.href = loc;
      remote.focus();
   } 
   else { 
      self.close(); 
   }
}

function popup_win2( loc, wd, hg ) {
   var remote = null;
   var xpos = screen.availWidth/2 - wd/2; 
   var ypos = screen.availHeight/2 - hg/2; 
   remote = window.open('','','width=' + wd + ',height=' + hg + ',resizable=1,scrollbars=1,toolbar=1,menubar=1,screenX=0,screenY=0,top='+ypos+',left='+xpos);
   if (remote != null) {
      if (remote.opener == null) {
         remote.opener = self;
      }
      remote.location.href = loc;
      remote.focus();
   } 
   else { 
      self.close(); 
   }
}

function popup_win3( loc ) {
   var remote = null;
   var wd = 680;
   var hg = screen.availHeight * 0.8;
   var xpos = screen.availWidth/2 - wd/2; 
   var ypos = (screen.availHeight/2 - hg/2) - 64; 
   remote = window.open(loc, "newwindow", "toolbar=1,menubar=0,scrollbars=1,resizable=1,location=top,status=0,width="+wd+",height="+hg+",screenX=0,screenY=0,top="+ypos+",left="+xpos);
   if (remote != null) {
      if (remote.opener == null) {
         remote.opener = self;
      }
      remote.location.href = loc;
      remote.focus();
   } 
   else { 
      self.close(); 
   }
}

function popup_win4( loc, wd, hg ) {
   var remote = null;
   var xpos = screen.availWidth/2 - wd/2; 
   var ypos = screen.availHeight/2 - hg/2; 
   remote = window.open('','','width=' + wd + ',height=' + hg + ',resizable=1,toolbar=1,scrollbars=1,screenX=0,screenY=0,top='+ypos+',left='+xpos);
   if (remote != null) {
      if (remote.opener == null) {
         remote.opener = self;
      }
      remote.location.href = loc;
      remote.focus();
   } 
   else { 
      self.close(); 
   }
}

function popup_win5( loc, wd, hg ) {
   var remote = null;
   var xpos = screen.availWidth/2 - wd/2; 
   var ypos = screen.availHeight/2 - hg/2; 
   remote = window.open(loc,"newwindow",'width=' + wd + ',height=' + hg + ',resizable=0,toolbar=0,scrollbars=1,screenX=0,screenY=0,top='+ypos+',left='+xpos);
   if (remote != null) {
      if (remote.opener == null) {
         remote.opener = self;
      }
      remote.location.href = loc;
      remote.focus();
   } 
   else { 
      self.close(); 
   }
}

function popup_win6( loc, wn ) {
  var remote = null;
   var wd = 680;
   var hg = screen.availHeight * 0.8;
   var xpos = screen.availWidth/2 - wd/2; 
   var ypos = (screen.availHeight/2 - hg/2) - 64; 
   
   remote = window.open(loc, wn, "toolbar=1,menubar=0,scrollbars=1,resizable=1,location=top,status=0,width="+wd+",height="+hg+",screenX=0,screenY=0,top="+ypos+",left="+xpos);
   if (remote != null) {
      remote.location.href = loc;
      remote.focus();
   } 
   else { 
      self.close(); 
   }
}

function open_url(url, x) {
   if ((x==1) && (window.opener!=null)) {
      window.self.close();
      window.opener.focus();
      window.opener.location.href = url;
   }
   else {
      var w = window.open(url, '_new');
      w.focus();
      w.opener = self;
   }
}

function open_url2(url) {
	if (window.opener==null) {
		window.location.href = url
	}
	else {
      var w = window.open(url, '_new');
      w.focus();
      w.opener = self;
      window.self.close();
	}
}

//popup window with popup blocker check
function popup_win7( loc, wd, hg ) {
    var remote = null;
    var xpos = screen.availWidth/2 - wd/2; 
    var ypos = screen.availHeight/2 - hg/2; 
    remote = window.open(loc,'','width=' + wd + ',height=' + hg + ',resizable=0,scrollbars=1,screenX=0,screenY=0,top='+ypos+',left='+xpos);
	try{
		remote.focus();
	} 
	catch(e){ 
		alert('The page you clicked could not be opened!\nDo you have any pop-up blocker installed?\n\nIf so, please disable the pop-up blocker or \nadd this site to the "allow pop-up" list.');
	}
}

//hide/show div section
//element id to hide/show, action, image id to change, imgExpand, imgCollapse
function toggleDiv(id, newClass, imgId, imgE, imgC) 
{ 
	var identity=document.getElementById(id); 
	if (identity.className == "toggleshow") {
		identity.className="toggle";
		if (imgId != null || imgId != "")
			document.images[imgId].src = imgE;		
	}
	else{
		identity.className= newClass;
		if (imgId != null || imgId != "") 
			document.images[imgId].src = imgC;		
	}
}

//session expiry alert
var sessionTimeoutAlert = function(intMinutes, intOffset) {
	if (!isNaN(intMinutes) && intMinutes > intOffset){ 
		intMinutes = (intMinutes - intOffset) * 60 * 1000;
		var strMsg = "WARNING: To ensure security of your resume, this session will expire in " + intOffset + " minutes. If you have made changes on this page, please save them NOW. Otherwise, the changes will be lost. You can continue to update after you have saved the changes.";	
		setTimeout("alert('" + strMsg + "')",intMinutes);
	}
}

//check lina profile against work profile
function chkLN(field, strEPL, strPL, strESP, strSP, strPLName, strSPName) 
{
	var cf;
	var updateLina = 0;
	if (String(strEPL).indexOf(strPL - 1) < 0 && String(strEPL).indexOf(strPL) < 0) 
	{
		updateLina = 1;
		cf = confirm("Would you like to receive job alerts for your current position level - " + strPLName.replace(/&amp;/gi, '&') + "? Click \"OK\" to add it in your LiNa profile now, or \"Cancel\" to continue updating your resume.");
	}
	else if (String(strESP).indexOf(strSP) < 0) 
	{
		updateLina = 2;
		cf = confirm("Would you like to receive job alerts for your current Job Specialization - " + strSPName.replace(/&amp;/gi, '&') + "? Click \"OK\" to add it in your LiNa profile now, or \"Cancel\" to continue updating your resume.");
	}
	else
		cf = false;
	
	if (cf)	{	
		if (field != null) field.value = updateLina;
		return true;
	} else
		return false;
}

//-->
