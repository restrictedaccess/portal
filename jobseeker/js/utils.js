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