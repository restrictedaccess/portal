<html>
	<head><title>None</title>
		<script language="javascript">

		var int=self.setInterval('check_schedule()',5000)	
		var curSubMenu = '';	
		
		function check_schedule()
		{
			http.open("GET", "return_schedule.php", true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function showAlarm(menuId, data)
		{
			if (curSubMenu!='') hideSubMenu();
			
			curSubMenu=menuId;
			eval('document.all.'+menuId).style.visibility='visible';
			document.getElementById(menuId).innerHTML = data;
		}
		
		function hideAlarm(id)
		{
			eval('document.all.'+curSubMenu).style.visibility='hidden';
			curSubMenu='';
			
			http.open("GET", "return_schedule.php?id="+id, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);			
		}
		
				
		
		
		//ajax
		function handleHttpResponse() 
		{
			if (http.readyState == 4) 
			{
				if(http.responseText != "")
				{
					showAlarm('alarm', http.responseText);
				}	
			}
		}
		
		function getHTTPObject() 
		{
					var x 
					var browser = navigator.appName 
					if(browser == 'Microsoft Internet Explorer'){
						x = new ActiveXObject('Microsoft.XMLHTTP')
					}else{
						x = new XMLHttpRequest()
					}
					return x		
		}
		var http = getHTTPObject();		
		//ajax		
		</script>		
		
	<link rel=stylesheet type=text/css href="../css/font.css">		
	</head>
<body>


<!-- ALARM BOX -->
<DIV ID='alarm' STYLE='POSITION: Absolute; LEFT: 5px; TOP: 5px; width: 150px; VISIBILITY: HIDDEN'></DIV>
<!-- ALARM BOX -->


</body>
</html>