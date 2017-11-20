<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<style type="text/css">
    
.animatedtabs{
border-bottom: 1px solid gray;
overflow: hidden;
width: 100%;
font-size: 14px; /*font of menu text*/
}


.animatedtabs ul{
list-style-type: none;
margin: 0;
margin-left: 10px; /*offset of first tab relative to page left edge*/
padding: 0;
}

.animatedtabs li{
float: left;
margin: 0;
padding: 0;
}

.animatedtabs a{
float: left;
position: relative;
top: 5px; /* 1) Number of pixels to protrude up for selected tab. Should equal (3) MINUS (2) below */
background: url(media/tab-blue-left.gif) no-repeat left top;
margin: 0;
margin-right: 3px; /*Spacing between each tab*/
padding: 0 0 0 9px;
text-decoration: none;

}

.animatedtabs a span{
float: left;
position: relative;
display: block;
background: url(media/tab-blue-right.gif) no-repeat right top;
padding: 5px 14px 3px 5px; /* 2) Padding within each tab. The 3rd value, or 3px, should equal (1) MINUS (3) */
font-weight: bold;
color: black;
}

/* Commented Backslash Hack hides rule from IE5-Mac \*/
.animatedtabs a span {float:none;}
/* End IE5-Mac hack */


.animatedtabs .selected a{
background-position: 0 -125px;
top: 0;
}

.animatedtabs .selected a span{
background-position: 100% -125px;
color: black;
padding-bottom: 8px; /* 3) Bottom padding of selected tab. Should equal (1) PLUS (2) above */
top: 0;
}

.animatedtabs a:hover{
background-position: 0% -125px;
top: 0;
}

.animatedtabs a:hover span{
background-position: 100% -125px;
padding-bottom: 8px; /* 3) Bottom padding of selected tab. Should equal (1) PLUS (2) above */
top: 0;
}

</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Animated Tab</title>
</head>

<body>
<div class="animatedtabs">
<ul>
<li><a href="http://www.dynamicdrive.com" title="Home"><span>Home</span></a></li>
<li class="selected"><a href="http://www.dynamicdrive.com/style/" title="CSS Examples"><span>CSS</span></a></li>
<li><a href="http://www.dynamicdrive.com/new.htm" title="New"><span>New</span></a></li>
<li><a href="http://www.dynamicdrive.com/revised.htm" title="Revised"><span>Revised</span></a></li>
<li><a href="http://tools.dynamicdrive.com" title="Tools"><span>Tools</span></a></li>	
<li><a href="http://www.dynamicdrive.com/forums/" title="DHTML Forums"><span>Forums</span></a></li>
</ul>
</div>

</body>
</html>
