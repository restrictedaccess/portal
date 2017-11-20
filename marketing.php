<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));
mysql_query('SET time_zone='.$timeZone);
$agent_no = $_SESSION['agent_no'];
/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['fname']." ".$row['lname'];
	$agent_code = $row['agent_code'];
	$length=strlen($agent_code);
}

?>
<html>
<head>
<title>Business Partner - Marketing</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">


<script type="text/javascript">
<!--
-->
</script>	
<style type="text/css">
<!--
div.scroll {
	height: 100%;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }

.img{
border:#666666 solid 3px;
margin-left:10px;
}
.imglink:hover{
border:#FFFF00 inset 3px;
}
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="agentHome.php">
<!-- HEADER -->
<? include 'header.php';?>

<? include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'agentleftnav.php';?>
</td>
<td width=100% valign=top >
<table width=100%  cellspacing=2 cellpadding=2 border=0 align=left >
<tr><td bgcolor="#666666" height="20" colspan=3><font color='#FFFFFF'><b>Marketing</b></font></td></tr>
<tr><td height="51" colspan=3 style="border:#CCCCCC solid 1px;"><font color="#999999">Banners &amp; Templates that can be used in Marketing :</font></td></tr>

<tr><td height="51" colspan=3>
<!--IMAGES HERE -->
<p><a href="marketing2.php?img=1" class="imglink"><img src="images/banner2/JPEG/proposed_final_layout.gif" alt="Image 1" class="img" ></a>
<a href="marketing2.php?img=2" class="imglink"><img src="images/banner2/JPEG/125x125_wlogo.jpg" alt="Image 2" class="img"></a>
<a href="marketing2.php?img=3" class="imglink"><img src="images/banner2/JPEG/125x125.jpg" alt="Image 3" class="img"></a>

<a href="marketing2.php?img=4" class="imglink"><img src="images/banner2/JPEG/125x125.jpg" alt="Image 8" class="img"></a>
<a href="marketing2.php?img=5" class="imglink"><img src="images/banner2/JPEG/125x125_wlogo.jpg" alt="Image 7" class="img"></a></p>

<div style="margin-top:5px; ">
<p style=" float:left"><a href="marketing2.php?img=6" class="imglink"><img src="images/banner2/JPEG/300x250_wlogo.jpg" alt="Image 10" class="img"></a></p>
<p style=" float:left; width:400px; ">
<a href="marketing2.php?img=7" class="imglink"><img src="images/banner2/JPEG/468x60.jpg" alt="Image 11" class="img"  ></a><br><br>
<a href="marketing2.php?img=8" class="imglink"><img src="images/banner2/JPEG/468x60_wlogo.jpg" alt="Image 12" class="img" ></a><br><br>

<a href="marketing2.php?img=9" class="imglink"><img src="images/banner2/JPEG/120x60.jpg" alt="Image 4" class="img"></a></p>
<p style="float:right; margin-right:130px;"><a href="marketing2.php?img=10" class="imglink"><img src="images/banner2/JPEG/120x240.jpg" alt="Image 5" class="img" ></a></p>
</div>


<div style="margin-top:320px;">

<p >
<a href="marketing2.php?img=11" class="imglink"><img src="images/banner2/JPEG/728x90.jpg" alt="Image 12" class="img"></a>
<br>
<br>
<a href="marketing2.php?img=12" class="imglink"><img src="images/banner2/JPEG/728x90_wlogo.jpg" alt="Image 13" class="img"></a><br>
<br>


<a href="marketing2.php?img=13" class="imglink"><img src="images/banner2/JPEG/banner_remote1.jpg" alt="Image 13" class="img"></a>
<a href="marketing2.php?img=14" class="imglink"><img src="images/banner2/JPEG/banner_remote1b.jpg" alt="Image 13" class="img"></a>
<a href="marketing2.php?img=15" class="imglink"><img src="images/banner2/JPEG/banner_remote2.jpg" alt="Image 13" class="img"></a><br>
<br>

<a href="marketing2.php?img=16" class="imglink"><img src="images/banner2/JPEG/banner_remote_set2a.jpg" alt="Image 13" class="img"></a>
<a href="marketing2.php?img=17" class="imglink"><img src="images/banner2/JPEG/banner_remote_set2b.jpg" alt="Image 13" class="img"></a>
<a href="marketing2.php?img=18" class="imglink"><img src="images/banner2/JPEG/proposed_final_layout.gif" alt="Image 9" class="img" ></a></p>

<p></p>
</div>









<!-- IMAGES ENDS HERE -->
</td></tr>
</table>





</td>
</tr>
</table>
<!-- LIST HERE --><!-- LIST HERE -->
<? include 'footer.php';?>
</form>	
</body>
</html>
