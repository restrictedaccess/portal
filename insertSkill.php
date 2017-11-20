<?php
include 'config.php';

$userid = $_GET["u"];;
$skill=$_GET["skill"];
$yoe=$_GET["yoe"];
$pro=$_GET["pro"];

//echo $userid."<br>".$skill."<br>".$yoe."<br>".$pro."<br>";
echo "<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr>
<td align=center>#</td><td align=center><b>Skill</b></td><td align=center><b>Year(s) of Experience</b></td><td align=center><b>Level</b></td>
</tr>
</table>";
			   
?>


