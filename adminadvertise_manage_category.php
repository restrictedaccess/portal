<?
include 'config.php';
include 'conf.php';
include 'time.php';
?>	
	
	
	
	
	
	
<html><head>
<title>Administrator - Job Category Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">
<script type="text/javascript" src="category/category.js"></script>

<script type="text/javascript" src="js/tooltip.js"></script>
<script type='text/javascript' language='JavaScript' src='audio_player/audio-player.js'></script>


	
	
	
	
	
<style type="text/css">
<!--
.style2 {color: #666666}
#dhtmltooltip{
position: absolute;
font-family:Verdana;
font-size:11px;
left: -300px;
width: 110px;
height:150px;
border: 5px solid #6BB4C2;
background: #F7F9FD;
padding: 2px;

visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}
#searchbox
{
 padding-left:30px; padding-bottom:5px; padding-top:5px; margin-left:10px;
 border: 8px solid #E7F0F5;
 
}

#searchbox p
{
	margin-top:5px; margin-bottom:5px;
}


.pagination{
padding: 2px;
margin-top:10px; 
text-align:center;

}

.pagination ul{
margin: 0;
padding: 0;
text-align: center; /*Set to "right" to right align pagination interface*/
font-family: tahoma; font-size: 11px;
}

.pagination li{
list-style-type: none;
display: inline;
padding-bottom: 1px;
}

.pagination a, .pagination a:visited{
padding: 0 5px;
border: 1px solid #9aafe5;
text-decoration: none; 
color: #2e6ab1;
}

.pagination a:hover, .pagination a:active{
border: 1px solid #2b66a5;
color: #000;
background-color: #FFFF80;
}

.pagination a.currentpage{
background-color: #2e6ab1;
color: #FFF !important;
border-color: #2b66a5;
font-weight: bold;
cursor: default;
}

.pagination a.disablelink, .pagination a.disablelink:hover{
background-color: white;
cursor: default;
color: #929292;
border-color: #929292;
font-weight: normal !important;
}

.pagination a.prevnext{
font-weight: bold;
}

#tabledesign{
border:#666666 solid 1px;
}
#tabledesign tr:hover{
background-color:#FFFFCC;
}
-->
</style>
</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- HEADER -->

<? include 'header.php';?>
<? include 'admin_header_menu.php';?>



<table width="106%">
<tr>
	<td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">
		<? include 'applicationsleftnav.php';?>
	</td>
	<td valign="top"  style="width:100%;">
		<div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
			<b>
				<strong>Manage Category</strong>
			</b>
		</div>
		<br />




<table width="102%">
<tr>
<td valign="top" >
<div id="create_category_form" ><img src="images/ajax-loader.gif"> Loading Create Category Form....</div>
<div style="margin-top:20px; font:12px Arial;">
	<div style="padding:5px;"><B>CATEGORIES</b> <font size="1">( <a href="javascript: show_hide('create_category_form');getCreateCategoryForm();"><em>Add Category</em></a> )</font></div>
	<div id="category_list"></div>
	<div style="margin:10px;"></div>
</td>
</tr>
</table>





	</td>
</tr>
</table>



</td>
</tr>
</table>
<input type='hidden' id='applicants' name="applicants" >
<script type="text/javascript">
function makeObj()
{
	var x ; 
	var browser = navigator.appName ;
	if(browser == 'Microsoft Internet Explorer')
	{
		x = new ActiveXObject('Microsoft.XMLHTTP')
	}
	else
	{
		x = new XMLHttpRequest()
	}
	return x ;
}
var request = makeObj()
function editSubCat(name,id)
{
	var temp = "<table width='0' border='0' cellspacing='2' cellpadding='2'>"
		temp +="<tr>"
			temp +="<td valign='top'><strong>UPDATE SUB CATEGORIES</strong></td>"
			temp +="<td valign='top'>:</td>"
			temp +="<td valign='top'><input type='text' id='sub_name' value="+name+" /></td>"
			temp +='<td><input type="button" value="Update" onClick="javascript: UpdateSubcategoryName(document.getElementById(\'sub_name\').value,'+id+');" /></td>'
		temp +="</tr>"
	temp +="</table>"
	document.getElementById('EditSubCat').innerHTML=temp;
}
function UpdateSubcategoryName(name,id)
{
	request.open('get', 'category/updateSubCategory.php?name='+name+'&id='+id)
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	//request.onreadystatechange = active_listings 
	request.send(1)
	
	alert("Changes has been applied.");
	document.getElementById('EditSubCat').innerHTML = "";
	getAllCategory();
}



<!--
function goto(id,stat) 
{
	location.href = "mark_applicantsphp_bycategory.php?stat=<?php echo $stat; ?>&t10_category_id=<?php echo $t10; ?>&t10_category_name=<?php echo $t10_category_name; ?>&main_category_id=<?php echo $main_category_id; ?>&sub_category_id=<?php echo $sub_category_id; ?>&stat=<?php echo $stat; ?>&action=<?php echo $action; ?>&category_a=<?php echo @$category_a; ?>&view_a=<?php echo @$view_a; ?>&rt=<?php echo @$rt; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>
&id="+id;
}
	
function check_val()
{
	var ins = document.getElementsByName('users')
	var i;
	var x;
	var j=0;
	var vals= new Array();
	var vals2 =new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true)
		{
			if(ins[i].value!="" || ins[i].value!="undefined")
			{
				vals[j]=ins[i].value;
				//vals2[j]=id;
				j++;
			}		
		}
	}
document.getElementById("emails").value =(vals);
}

function check_val2()
{

userval =new Array();
var userlen = document.form.userss.length;
for(i=0; i<userlen; i++)
{
	if(document.form.userss[i].checked==true)
	{	
	//	document.getElementById("applicants").value+=(id);
		//push.userval=(id);
		userval.push(document.form.userss[i].value);
	}
}
document.getElementById("applicants").value=(userval);
}

-->
</script>



<script type="text/javascript">
<!--
getAllCategory();
-->
</script>

<? include 'footer.php';?>	
</body>
</html>



