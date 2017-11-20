<?
include 'config.php';
include 'conf.php';
include 'time.php';
  
    $query = $_SESSION['last_query']." ".$_SESSION['lim'];
    $query2 = $_SESSION['last_query2']." ".$_SESSION['lim'];
    $sub_category_title = $_SESSION['sub_category_title'];
  if (isset($_POST['userid'])) $userid = $_POST['userid']; elseif (isset($_GET['userid'])) $userid = $_GET['userid']; else $userid=0;
//END

//$result=mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());
if($mark=="")
{
  $mark="Mark/Remember";
}

?>

<html><head>
<title>Administrator - Job Category Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">
<script type="text/javascript" src="category/category.js"></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript" src="js/tooltip.js"></script>
<script type='text/javascript' language='JavaScript' src='audio_player/audio-player.js'></script>




<script type="text/javascript">

function checkAll(field)
{
  userval2 =new Array();
  if (field==null)
  {
    alert("There is no Selection to be Processed!");
    return false;
  }
  else
  {
    if((field.length)!=undefined)
    {
      for (i = 0; i < field.length; i++)
      {
        field[i].checked = true ;
        userval2.push(field[i].value);  
      }
      document.getElementById("emails").value=(userval2);
    }
    else
    {
      document.getElementById("emails").value = document.getElementById("list").value;
      document.getElementById("users").checked = true ;
    }
  }
}

function setSearchDate()
{
  //date_apply
  if(document.form.date_apply.value!="")
  {
    document.form.submit();
    //alert(document.form.date_apply.value);
  }
  
}


function l(action,main_category_id,sub_category_id)
{
  window.location="?stat=<?php echo @$stat; ?>&action="+action+"&main_category_id="+main_category_id+"&sub_category_id="+sub_category_id+"&category_a=<?php echo @$category_a; ?>&view_a=<?php echo @$view_a; ?>&rt=<?php echo @$rt; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>";
}


    function move(id, status) 
    {
      switch(status)
      {
        case "Pre-Screen":
          previewPath = "move_pre-screen.php?userid="+id;
          break;
        case "Unprocessed":
          previewPath = "move_unprocessed.php?userid="+id;
          break;
                          
        case "Shortlist":
          previewPath = "move_shortlist.php?userid="+id;
          break;
        case "Select":
          previewPath = "move_select.php?userid="+id;
          break;
        case "Become a Staff":
          previewPath = "move_become_a_staff.php?userid="+id;
          break;
        case "Edit":
          previewPath = "move_edit.php?userid="+id;
          break;
        case "No Potential":
          previewPath = "move_no_potential.php?userid="+id;
          break;
        case "Endorse to Client":
          previewPath = "move_endorse_to_client.php?userid="+id;
          break;
        case "Category":
          previewPath = "adminadvertise_add_to_category.php?userid="+id;
          break;          
      }  
      window.open(previewPath,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
    }

</script>  
  
  
  
  
  
  
  
  
  
<script type="text/javascript">

function any_date(check)
{
  document.getElementById('month_a_id').disabled = (check.checked);
  document.getElementById('day_a_id').disabled = (check.checked);
  document.getElementById('year_a_id').disabled = (check.checked);
  document.getElementById('month_b_id').disabled = (check.checked);
  document.getElementById('day_b_id').disabled = (check.checked);
  document.getElementById('year_b_id').disabled = (check.checked);
}      
    
function any_key(check)
{
  document.getElementById('key_id').disabled = (check.checked);
}      
  
function validate(form) 
{
  if(!form.date_check.checked)
  {
    if (form.month_a.value == '') { alert("You forgot to select the 'month field'."); form.month_a.focus(); return false; }  
    if (form.day_a.value == '') { alert("You forgot to select the 'day field'."); form.day_a.focus(); return false; }  
    if (form.year_a.value == '') { alert("You forgot to select the 'year field'."); form.year_a.focus(); return false; }  
    if (form.month_b.value == '') { alert("You forgot to select the 'month field'."); form.month_b.focus(); return false; }  
    if (form.day_b.value == '') { alert("You forgot to select the 'day field'."); form.day_b.focus(); return false; }  
    if (form.year_b.value == '') { alert("You forgot to select the 'year field'."); form.year_b.focus(); return false; }        
  }
  if(!form.key_check.checked)
  {
    if (form.key.value == '') { alert("You forgot to enter the 'keyword'."); form.month_a.focus(); return false; }  
  }
}


</script>    
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
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
<script language=javascript src="js/functions.js"></script>



<!-- HEADER -->


<table width="106%">

<td valign="top"  style="width:100%;">

  <div id="category_applicants">
    <b>
      <strong><?php echo $sub_category_title; ?></strong>
    </b>
  </div>
  <div class="pagination">
</div>
<table width=98% id='tabledesign' cellspacing=1 cellpadding=1 align=center border=0 bgcolor="" >
<tr bgcolor="#666666" >
<td width="4%"   align=left><b><font color="#FFFFFF" size='1'>#</font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/email.gif" alt="Send Message"  onClick="checkAll(document.form.users)" style="cursor: pointer; "></font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/delete.png" alt="Delete This Applicant"></font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/adduser16.png" alt="mark Applicants"></font></b></td>
<td width="28%"  align=left><b><font color="#FFFFFF" size='1'>NAME</font></b></td>
<td width="12%"  align=left><b><font color="#FFFFFF" size='1'>DATE REGISTERED</font></b></td>
<td width="25%" align="center"><b><font color="#FFFFFF" size='1'>SKILLS</font></b></td>
<td width="25%" align="center"><b><font color="#FFFFFF" size='1'>MOVE</font></b></td>
</tr>
<?
$counter=$offset;
//$counter=0;
//$bgcolor="#f5f5f5";
$bgcolor="#ECEBF3";

$per = mysql_query("SELECT userid, lname, fname, email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1,  postcode, country_id, state, city, skype_id, image, DATE_FORMAT(datecreated,'%D %b %Y'),status,voice_path
  FROM personal WHERE userid = '$userid' LIMIT 1");

while(list($userid, $lname, $fname, $email, $handphone_country_code, $handphone_no, $tel_area_code, $tel_no, $address1,  $postcode, $country_id, $state, $city, $skype_id, $image, $date,$status,$voice_path)=mysql_fetch_array($per))
  {
    $counter++;
    if($status=="MARK")
    {
      $mark="Unmark";
    }
    else
    {
      $mark="Mark/Remember";
    }
    /// applicants image
    if ($image!="")
    {
      $filename = $image;
      if (file_exists($filename))
      {
        //echo "The file $filename exists";
        $pic= "<img border=0 src=$image width=110 height=150>";
      } 
      else 
      {
        $image="http://www.remotestaff.com.au/".$image;
        //echo $image;
        $pic= "<img border=0 src=$image width=110 height=150>";
        //echo "The file $filename does not exist";
      }
    }
    else
    {
      $pic= "<img border=0 src=images/Client.png width=110 height=150>";
    } 
    //
  
  ?>
  <tr bgcolor=<? echo $bgcolor;?>>
  <td width="4%"   align=left valign="top"><font size='1'><?=$counter;?>) </font></td>
  <td width="2%"   align=center valign="top"><font size='1'> 
    <input name="users" id="users"type="checkbox" onClick="check_val();" value="<? echo $email;?>" title="Send Email to Applicant <?=$fname." ".$lname;?>"  >
  </font></td>
  <td width="2%"   align=center valign="top"><font size='1'>
    <input name="userss" id="userss" type="checkbox" onClick="check_val2(<? echo $userid;?>);" value="<? echo $userid;?>" title="Delete Applicant <?=$fname." ".$lname;?>"  >
    </font></td>
  <td width="2%"   align=center valign="top"><font size='1'>
    <input name="mark_applicants" id="mark_applicants" type="radio" onclick ="goto(<? echo $userid;?>,'<?=$status;?>'); return false;" value="<? echo $userid;?>" title="<?=$mark;?> Applicant <?=$fname." ".$lname;?>&nbsp; as a Reserve Staff for future Employment "  >
  
    </font></td>  
  <td width="28%"  align=left valign="top">
  <div style="background-color:#FEFDE2; margin-bottom:0px; float:left;">
  <div style="cursor:pointer;" onMouseOut="hideddrivetip();" onMouseOver="ddrivetip('<?=$pic;?>')" class='jobCompanyName';" ><a href="./application_apply_action.php?userid=<? echo $userid;?>&t10_category_id=<?php echo $t10; ?>" target="_parent"><?="<b>".$fname." ".$lname."</b>";?></a></div>
  
  
  </div>
  <div style="float:right">
  <? if($status=="MARK")
  {
    echo "<img src='images/hot.gif' alt='Marked Applicants'>";
  }
  else { echo "&nbsp;";}
  ?></div>
  <div style=" font-size:11px; margin-top:18px;">
  <b style='color:#FF0000'>
  <? 
  $sql="SELECT latest_job_title FROM currentjob c WHERE c.userid= $userid;";
  $result2=mysql_query($sql);
  list($latest_job_title)=mysql_fetch_array($result2);
  if ($latest_job_title!=""){ echo $latest_job_title."<br>";}
  ?>
  </b>
  <?=$email."<br>"."SkypeId : ".$skype_id;?>
  </div>
    <?
  if ($voice_path!="") 
  { //echo $voice_path;
    ?>
    <br>
    <a href="./<?=$voice_path;?>">Download</a>
    <?
  } 
  ?>
  
  </td>
  <td width="12%"  align=left valign="top"><font size='1'><?=$date;?></font></td>
  <td valign="top">
  <div style="margin-left:10px; text-align:center">
  <i>
  <?
  $sqlSkill="SELECT skill FROM skills WHERE userid=$userid $AND;";
  //echo $sqlSkill."<br>";
  
  //echo "<b>".$skills."</b>";
  $resultSkill=mysql_query($sqlSkill);
  while(list($skill) = mysql_fetch_array($resultSkill))
  {
    if((strtolower($skill)) == (strtolower($skills)))
    {
      echo "<span style='background-color:#FFFFCC;'>".$skill."</span> ,&nbsp;";
    }  
    else
    {
      echo $skill.",&nbsp;&nbsp;";
    }
  }
  ?>
  </i>
  </div>
  </td>
  <td>
    <?php
      $app_stat = mysql_query("SELECT id, userid, status FROM applicants WHERE userid='$userid' LIMIT 1");
      $stat = mysql_result($app_stat,0,"status");
      $u_id = mysql_result($app_stat,0,"userid");
      $id = mysql_result($app_stat,0,"id");
    ?>    
    <table>
      <tr>
        <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'No Potential'); " value="No Potential" <?php if($stat == "No Potential") echo "checked"; ?>></td>
        <td><font size="1">No&nbsp;Potential</font></td>    
        <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Pre-Screen'); " value="Pre-Screen" <?php if($stat == "Pre-Screen") echo "checked"; ?>></td>
        <td><font size="1">Pre-Screen</font></td>
      </tr>    
      <tr>
        <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Unprocessed'); " value="Unprocessed" <?php if($stat == "Unprocessed") echo "checked"; ?>></td>
        <td><font size="1">Unprocessed</font></td>
        <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Shortlist'); " value="Shorlisted" <?php if($stat == "Shortlisted") echo "checked"; ?>></td>
        <td><font size="1">Shorlisted</font></td>
      </tr>  
      <tr>
        <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Endorse to Client'); " value="Endorsed" <?php if($stat == "Endorse to Client") echo "checked"; ?>></td>
        <td><font size="1">Endorse to Client</font></td>
        <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Select'); " value="Select" <?php if($stat == "Select") echo "checked"; ?>></td>
        <td><font size="1">Select</font></td>      
      </tr>
      <tr>
        <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Become a Staff'); " value="Become a Staff" <?php if($stat == "Sub Contracted") echo "checked"; ?>></td>
        <td><font size="1">Become a Staff</font></td>
        <td><input name="status<?php echo $u_id; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Category'); " value="Become a Staff" <?php if($stat == "Sub Contracted") echo "checked"; ?>></td>
        <td><font size="1">Add to Categories <br />/ Evaluate</font></td>        
      </tr>    
    </table>
  </td>
  
  
  </tr>
  <? 
    if($bgcolor=="#ECEBF3"){$bgcolor="#E6E6F0";}else{$bgcolor="#ECEBF3";}
  
  }

// how many rows we have in database
//$query   = "SELECT COUNT(eid) AS numrows FROM employer";
//echo $query2;

/*$result  = mysql_query($query2) or die('Error, query failed');
$row     = mysql_fetch_array($result);
$numrows = $row['numrows'];

//echo $numrows;
// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);

// print the link to access each page
$self = "./adminadvertise_positions.php?audio=$audio&status=$status_search&date_apply=$date_apply&month=$month&keysearch=$keysearch";
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
  if ($page == $pageNum)
  {
    $nav .= " $page ";   // no need to create a link to current page
  }
  else
  {
    $nav .= " <a href=\"$self&page=$page\">$page</a> ";
  }
}

// creating previous and next link
// plus the link to go straight to
// the first and last page

if ($pageNum > 1)
{
  $page = $pageNum - 1;
  $prev = " <a href=\"$self&page=$page\">[Prev]</a> ";

  $first = " <a href=\"$self&page=1\">[First Page]</a> ";
}
else
{
  $prev  = '&nbsp;'; // we're on page one, don't print previous link
  $first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage)
{
  $page = $pageNum + 1;
  $next = " <a href=\"$self&page=$page\">[Next]</a> ";

  $last = " <a href=\"$self&page=$maxPage\">[Last Page]</a> ";
}
else
{
  $next = '&nbsp;'; // we're on the last page, don't print next link
  $last = '&nbsp;'; // nor the last page link
}*/

?>

</table>
</div>
</td>
</tr>
</table>










</td>
</tr>
</table>
<input type='hidden' id='applicants' name="applicants" >
<script type="text/javascript">
<!--
function goto(id,stat) 
{
  location.href = "mark_applicantsphp_bycategory_action.php?stat=<?php echo $stat; ?>&t10_category_id=<?php echo $t10; ?>&t10_category_name=<?php echo $t10_category_name; ?>&main_category_id=<?php echo $main_category_id; ?>&sub_category_id=<?php echo $sub_category_id; ?>&stat=<?php echo $stat; ?>&action=<?php echo $action; ?>&category_a=<?php echo @$category_a; ?>&view_a=<?php echo @$view_a; ?>&rt=<?php echo @$rt; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>
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
  //  document.getElementById("applicants").value+=(id);
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

</body>
</html>



