<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Client RemoteStaff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/functions.js"></script>
	
	<!-- 
		include flashembed - which is a general purpose tool for 
		inserting Flash on your page. Following line is required.
	-->
	<script type="text/javascript" src="swf/flashembed.min.js"></script>
	<script type="text/javascript">
	 /*
		use flashembed to place flowplayer into HTML element 
		whose id is "example" (below this script tag)
	 */
	 flashembed("player", 
	
		/* 
			first argument supplies standard Flash parameters. See full list:
			http://kb.adobe.com/selfservice/viewContent.do?externalId=tn_12701
		*/
		{
			src:'swf/FlowPlayerDark.swf',
			 width: 852,
        	 height:480 
		},
		
		/*
			second argument is Flowplayer specific configuration. See full list:
			http://flowplayer.org/player/configuration.html
		*/
		{config: {   
			autoPlay: false,
			autoBuffering: true,
			controlBarBackgroundColor:'0x2e8860',
			initialScale: 'scale',
			videoFile: 'http://www.jmcim.org/webstream/meyc.flv'
		}} 
	);
	</script>	

	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div id="player">If there's no video on the screen. Please try to Refresh(F5) your Page....</div>
</body>
</html>
