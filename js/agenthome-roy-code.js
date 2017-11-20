// JavaScript Document
// roy pepito javascript code in the home page of the business developer
var chck = 0;

		var temp = '';

		var int=self.setInterval('check_schedule(temp)',9000)	

		var curSubMenu = '';	

		function check_schedule(id)

		{

			chck = 0;

			http.open("GET", "./return_schedule.php?id="+id, true);

			http.onreadystatechange = handleHttpResponse;

			http.send(null);

		}

		function hideAlarm(id)

		{

			chck = 0;

			document.getElementById('support_sound_alert').innerHTML='';

			document.getElementById('alarm').style.visibility='hidden';

			check_schedule(id);

		}

		//ajax



		function handleHttpResponse() 

		{

			if (http.readyState == 4) 

			{

				var temp = http.responseText;

				if(temp == "" || temp == '')

				{

					//do nothing

					//document.getElementById('support_sound_alert').innerHTML = "";

				}

				else

				{

					document.getElementById('alarm').innerHTML = http.responseText;			

					document.getElementById('alarm').style.visibility='visible';							

					//if(chck == 0)

					//{

						//document.getElementById('support_sound_alert').innerHTML = "<EMBED SRC='calendar/media/crawling.mid' hidden=true autostart=true loop=1>";

						//chck = 1;

					//}

				}	

			}

		}

		function getHTTPObject() 

		{

					var x 

					var browser = navigator.appName 

					if(browser == 'Microsoft Internet Explorer'){

						x = new ActiveXObject('Microsoft.XMLHTTP')

					}

					else

					{

						x = new XMLHttpRequest()

					}

					return x		

		}

		var http = getHTTPObject();		

		//ajax		

		

		//menu

		//var curSubMenu='';

		function showSubMenu(menuId){

				document.getElementById('id_two').style.visibility='visible';	

				if (curSubMenu!='') hideSubMenu();

				eval('document.all.id_two').style.visibility='visible';

				curSubMenu=menuId;

		}

		

		function hideSubMenu(){

				document.getElementById('id_two').style.visibility='hidden';

				eval('document.all.'+curSubMenu).style.visibility='hidden';

				curSubMenu='';

		}

		//menu		
