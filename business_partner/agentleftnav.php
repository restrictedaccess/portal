<?
$sqlWorkS


?>
<style type="text/css">
/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */


#markermenu{
width: 230px; /*width of menu*/
}
#markermenu ul{
list-style-type: none;
margin: 5px 0;
padding: 0;
width:220px;
}
#markermenu li a{
background: white url(media/arrow-list.gif) no-repeat 2px center;
font: bold 11px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: #00014e;
display: block;
padding: 3px 0;
padding-left: 20px;
text-decoration: none;
border: 3px solid #E7F0F5;
margin-bottom:5px;
margin-top:2px;
}

#markermenu li a:visited, #markermenu ul li a:active{
color: #00014e;
}

#markermenu li a:hover{
color: black;
background:#ffffcb url(images/arrow-list-red.gif) no-repeat left ;
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
<?
//agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status, hosting, work_status, access_aff_leads
$sqlCheckAgentsAccess="SELECT * FROM agent a WHERE  a.agent_no = $agent_no;";
$result_access=mysql_query($sqlCheckAgentsAccess);
$rows=mysql_fetch_array($result_access);
$access=$rows['access_aff_leads'];
?>
<div id="markermenu" >
<ul>
<li><a href="agentHome.php" > Business Partner Home</a></li>
<li><a href="marketing.php" >Marketing</a></li>
<li><a href="sendAds.php" >Email Campaigns</a></li>
<li><a href="addtracking.php" >Create Tracking</a></li>
<li><a href="organizer.php" >Calendar Events</a></li>
<li><a href="#" onClick="javascript:popup_win('./todo.php?agentno=<? echo $agent_no;?>',950,600);">To Do's</a></li>
<li><a href="addnewlead.php">Add New Lead</a></li>
<li><a href="inactiveList.php"  >No Longer a Prospects List</a>
<?
if($access=="YES") { 
echo "<li><a href='agent_aff_leads.php' >Affiliates Leads</a></li>";
}
?>
<li><a href="../logout.php" >Logout</a></li>
</ul>
</div>
