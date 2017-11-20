<style type="text/css">
/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */




#markermenu{

 width:auto;
}
#markermenu ul{
list-style-type: none;
padding: 0;
width:230px;
margin:5px;

}
#markermenu li {
   margin-bottom:5px;
   
   
}
#markermenu li a{
/*
font: bold 11px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: #00014e;
display: block;
padding: 3px 0;
padding-left: 20px;
text-decoration: none;
border: 3px solid #E7F0F5;
margin-top:2px;
height:30px;
line-height:30px;
*/
    border:#d0e8ff solid 1px;
    background: #e3f3ff;
    /* Mozilla: */
    background: -moz-linear-gradient(top, #FFFFFF, #d0e8ff);
	
    /* Chrome, Safari:*/
    background: -webkit-gradient(linear,
                left top, left bottom, from(#FFFFFF), to(#d0e8ff));
    /* MSIE */
    filter: progid:DXImageTransform.Microsoft.Gradient(
                StartColorStr='#FFFFFF', EndColorStr='#d0e8ff', GradientType=0);
				
	height:30px;
	line-height:30px;
	display:block;
	text-decoration:none;
   	border-left:#a6c8e1 solid 1px;
	border-right:#a6c8e1 solid 1px;

	padding-left:3px;
	padding-right:2px;
	text-align:center;
	color:#333333;			
}

#markermenu li img{
    float:left;
	
}



#markermenu li a:hover{
/*
color: black;
background:#ffffcb url(images/arrow-list-red.gif) no-repeat left ;
*/
background: #a6c8e1;
	/*background: #e3f3ff;*
    /* Mozilla: */
    background: -moz-linear-gradient(top, #FFFFFF, #a6c8e1);
	
    /* Chrome, Safari:*/
    background: -webkit-gradient(linear,
                left top, left bottom, from(#FFFFFF), to(#a6c8e1));
    /* MSIE */
    filter: progid:DXImageTransform.Microsoft.Gradient(
                StartColorStr='#FFFFFF', EndColorStr='#a6c8e1', GradientType=0);
}

#markermenu li a:active{
background:#ffffcb;
}
#markermenu li a:focus{
background:#ffffcb;
}

* html #markermenu li a{ /*IE only. Actual menu width minus left padding of LINK (20px) */
margin-bottom:0px;
margin-top:0px;
}
</style>
<div id="markermenu" >
<ul>
<li> <a href="myaccount.php" class="link12b" >My Account</a></li>
<li> <a href="screenrecorder_client.php" class="link12b" >Screen Recorder</a></li>
<li> <a href="screenlist_client.php" class="link12b">Screen Recording Links</a></li>
<li> <a href="screenshare_client.php" class="link12b" >Share My Screen</a></li>
<li> <a href="/portal/django/client_managers/" class="link12b" target="_blank" >Account Managers</a></li>
<li> <a href="myremotestaff.php" class="link12b" >My RemoteStaff</a></li>
<li> <a href="/portal/django/workflow/" class="link12b" >My Remote Staff's Work Tasks</a></li>
<li> <a href="mypayroll.php" class="link12b" >My Invoice</a></li>
<!--<li> <a href="myjobposting.php" class="link12b" >Post New Job Ad</a></li>-->
<li> <a href="client_testimonials.php" class="link12b" >Add Testimonials</a></li>
<li> <a href="myjobspecifications.php" class="link12b" >My Job Ads / Post a New Job Ad</a></li>
<li> <a href="leave_request_management.php" class="link12b" >My Remote Staff Leave Requests</a></li>
<li> <a href="/portal/aclog/" class="link12b" >Activity Logger</a></li>
<li> <a href="clientFAQs.php" class="link12b" >FAQs</a></li>
</ul>
</div>
