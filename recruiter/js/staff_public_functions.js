		//var calendar_directory_temp = APP_CALENDAR_directory_set("../");
		
		//START: divs menu
		var curSubMenu='';
		
		function showSubMenu(menuId)
		{
			if (curSubMenu!='') hideSubMenu();
			eval('document.all.'+menuId).style.visibility='visible';
			curSubMenu=menuId;
		}
		function hideSubMenu()
		{
			eval('document.all.'+curSubMenu).style.visibility='hidden';
			curSubMenu='';
		}
		//ENDED: divs menu
		
		
		//START: left nav.
		function applicationsleftnav_show() 
		{
			document.getElementById("applicationsleftnav").innerHTML = document.getElementById("applicationsleftnav_container").innerHTML;
		}	
		function applicationsleftnav_hide()
		{
			document.getElementById("applicationsleftnav").innerHTML='<table><tr><td background="images/close_left_menu_bg.gif"><a href="javascript: applicationsleftnav_show(); "><img src="images/open_left_menu.gif" border="0" /></a></td></tr></table>';
		}		
		//ENDED: left nav.