<?php
include 'config.php';
include 'conf.php';
include 'time.php';

require_once('./lib/paginator.class.php');

if($_SESSION['admin_id']=="")
{
  header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
putenv("TZ=Philippines/Manila");
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$pages = new Paginator;


//////////// SEND MESSAGE /////////////
$message=$_REQUEST['message'];
$message=str_replace("\n","<br>",$message);
$emails=$_REQUEST['emails'];
$subj="MESSAGE FROM REMOTESTAFF.COM.AU";
$applicant=explode(",",$emails);
$agent_email=$admin_email;

//////// DELETE USERS //////
$applicants=$_REQUEST['applicants'];
//echo "Applicants ".$applicants;
$users=explode(",",$applicants);
if(isset($_POST['delete']))
{
  for ($i=0; $i<count($users);$i++)
  {  //personal , currentjob, education, skills, language
    $sqlDeletePersonal ="DELETE FROM personal WHERE userid =".$users[$i];
    $sqlDeleteCurrentjob ="DELETE FROM currentjob WHERE userid =".$users[$i];
    $sqlDeleteEducation ="DELETE FROM education WHERE userid =".$users[$i];
    $sqlDeleteSkills ="DELETE FROM skills WHERE userid =".$users[$i];
    $sqlDeleteLanguage ="DELETE FROM language WHERE userid =".$users[$i];
    mysql_query($sqlDeletePersonal);
    mysql_query($sqlDeleteCurrentjob);
    mysql_query($sqlDeleteEducation);
    mysql_query($sqlDeleteSkills);
    mysql_query($sqlDeleteLanguage);
  }
}

///////QUERY ---------------------------------------------------------------------- >
  $rt = @$_GET['rt'];
  $status = @$_GET['status'];
  $type = @$_GET['type'];
  $position = @$_GET['position'];
  $client = @$_GET['client'];
  
    //reporting code
      switch ($rt) 
      {
        case "today" :
          $a_1 = time();
          $b_1 = time() + (1 * 24 * 60 * 60);
          $a_ = date("Y-m-d"); 
          $b_ = date("Y-m-d",$b_1);
          $title = "Today (".date("M d, Y").")";
          break;
        case "yesterday" :
          $a_1 = time() - (1 * 24 * 60 * 60);
          $b_1 = time() - (1 * 24 * 60 * 60);
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Yesterday (".date("M d, Y",$a_1).")";
          break;
        case "curmonth" :
          $a_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
          $b_1 = mktime(0, 0, 0, date("n"), 31, date("Y"));
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Current Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "curweek" :
          $wd_arr = array('Mo ', 'Tu ', 'We ', 'Th ', 'Fr ', 'Sa ', 'Su ');
          $a_1 = mktime(0, 0, 0,(int)date('m'),(int)date('d')+(1-(int)date('w')),(int)date('Y'));
          $b_1 = time();
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Current Week (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "lmonth" : 
          $a_1 = mktime(0, 0, 0, date("n"), -31, date("Y"));
          $b_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Last Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "last7" :
          $a_1 = time() - (14 * 24 * 60 * 60);
          $b_1 = time() - (7 * 24 * 60 * 60);
          $a_ = date("Y-m-d",$a_1);
          $b_ = date("Y-m-d",$b_1);
          $title = "Last 7 Days (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
          break;
        case "alltime" :
          $a_1 = mktime(0, 0, 0, 1, 11, 2006);
          $b_1 = time();
          $a_ = date("Y-m-d",$a_1);      
          $b_ = date("Y-m-d",$b_1);
          $title = "All time (".date("M d, Y").")";      
          break;
        default :
          $a_ = date("Y-m-d"); 
          $b_ = date("Y-m-d",time() + (1 * 24 * 60 * 60));
          $title = "Today (".date("M d, Y").")";  
      }


  if($status == "ACTIVE")
  {
    $sub_query = "pos.status='ACTIVE' AND (DATE(pos.date_created) BETWEEN '$a_' AND '$b_')";
  }
  elseif($status == "ARCHIVE")
  {
    $sub_query = "pos.status='ARCHIVE' AND (DATE(pos.date_created) BETWEEN '$a_' AND '$b_')";
  }
  elseif($status == "NEW")
  {
    $sub_query = "pos.status='NEW' AND (DATE(pos.date_created) BETWEEN '$a_' AND '$b_')";
  }    
  else
  {
    $sub_query = "(DATE(pos.date_created) BETWEEN '$a_' AND '$b_')";
  }    

  switch($type)
  {
    case "Pre-Screened":
      $query = "SELECT DISTINCT(a.userid)
      FROM applicants a, posting pos 
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='Pre-Screen' AND pos.lead_id='$client' AND pos.id='$position'";
                    
      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM applicants a, posting pos   
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='Pre-Screen' AND pos.lead_id='$client' AND pos.id='$position'";  
      break;
    case "Unprocessed":
      $query = "SELECT DISTINCT(a.userid)
      FROM applicants a, posting pos 
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='Unprocessed' AND pos.lead_id='$client' AND pos.id='$position'";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM applicants a, posting pos   
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='Unprocessed' AND pos.lead_id='$client' AND pos.id='$position'";      
      break;
    case "Shortlist":
      $query = "SELECT DISTINCT(s.userid)
      FROM tb_shortlist_history s, posting pos 
      WHERE $sub_query AND s.position=pos.id AND pos.lead_id='$client' AND pos.id='$position'";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM tb_shortlist_history s, posting pos 
      WHERE $sub_query AND s.position=pos.id AND pos.lead_id='$client' AND pos.id='$position'";
      break;
    case "Subcontracted":
      $query = "SELECT DISTINCT(s.userid)
      FROM subcontractors s, posting pos 
      WHERE $sub_query AND s.posting_id=pos.id AND pos.lead_id='$client' AND pos.id='$position'";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM subcontractors s, posting pos 
      WHERE $sub_query AND s.posting_id=pos.id AND pos.lead_id='$client' AND pos.id='$position'";
      break;
    case "No Potential":
      $query = "SELECT DISTINCT(a.userid)
      FROM applicants a, posting pos 
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='No Potential' AND pos.lead_id='$client' AND pos.id='$position'";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM applicants a, posting pos   
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='No Potential' AND pos.lead_id='$client' AND pos.id='$position'";      
      break;
    case "Endorsed":
      $query = "SELECT DISTINCT(e.userid)
      FROM tb_endorsement_history e, posting pos 
      WHERE $sub_query AND e.position=pos.id AND pos.lead_id='$client' AND pos.id='$position'";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM tb_endorsement_history e, posting pos 
      WHERE $sub_query AND e.position=pos.id AND pos.lead_id='$client' AND pos.id='$position'";
      break;
    case "Right_Total":
      $query = "SELECT DISTINCT(a.userid)
      FROM applicants a, posting pos 
      WHERE $sub_query AND a.posting_id=pos.id AND pos.lead_id='$client' AND pos.id='$position'";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM applicants a, posting pos   
      WHERE $sub_query AND a.posting_id=pos.id AND pos.lead_id='$client' AND pos.id='$position'";
      break;
      
      
      
      
    case "Below_Pre-Screened":
      $query = "SELECT DISTINCT(a.userid)
      FROM applicants a, posting pos 
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='Pre-Screen'";
                    
      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM applicants a, posting pos   
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='Pre-Screen'";  
      break;
    case "Below_Unprocessed":
      $query = "SELECT DISTINCT(a.userid)
      FROM applicants a, posting pos 
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='Unprocessed'";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM applicants a, posting pos   
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='Unprocessed'";      
      break;
    case "Below_Shortlist":
      $query = "SELECT DISTINCT(s.userid)
      FROM tb_shortlist_history s, posting pos 
      WHERE $sub_query AND s.position=pos.id";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM tb_shortlist_history s, posting pos 
      WHERE $sub_query AND s.position=pos.id";
      break;
    case "Below_Subcontracted":
      $query = "SELECT DISTINCT(s.userid)
      FROM subcontractors s, posting pos 
      WHERE $sub_query AND s.posting_id=pos.id";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM subcontractors s, posting pos 
      WHERE $sub_query AND s.posting_id=pos.id";
      break;
    case "Below_No Potential":
      $query = "SELECT DISTINCT(a.userid)
      FROM applicants a, posting pos 
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='No Potential'";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM applicants a, posting pos   
      WHERE $sub_query AND a.posting_id=pos.id AND a.status='No Potential'";      
      break;
    case "Below_Endorsed":
      $query = "SELECT DISTINCT(e.userid)
      FROM tb_endorsement_history e, posting pos 
      WHERE $sub_query AND e.position=pos.id";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM tb_endorsement_history e, posting pos 
      WHERE $sub_query AND e.position=pos.id";
      break;
    case "Below_Total":
      $query = "SELECT DISTINCT(a.userid)
      FROM applicants a, posting pos 
      WHERE $sub_query AND a.posting_id=pos.id";

      $query2 = "SELECT COUNT(a.userid) AS numrows
      FROM applicants a, posting pos   
      WHERE $sub_query AND a.posting_id=pos.id";
      break;
  }
///////END QUERY ------------------------------------------------------------------ >

        
$_SESSION['last_query'] = $query;
$_SESSION['last_query2'] = $query2;  
$posted_data = "t10_category_id=".$t10;
$_SESSION['lim'] = $lim;
//END

if($mark=="")
{
  $mark="Mark/Remember";
}

?>

<html><head>
<title>Administrator - Job Category Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
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
        case "popup":
          previewPath = "application_apply_action.php?userid="+id+"&page_type=popup";
          break;            
      }  
      window.open(previewPath,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
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
<tr>
<td valign="top"  style="width:100%;">
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
  <div id="category_applicants">
  <div class="pagination">
<ul>


<?php
$result_total = mysql_query($query2);
$items = mysql_fetch_row($result_total);
$pages->items_total = $items[0];
$pages->mid_range = 7;
$pages->items_per_page = 100;
$pages->paginate();

$show_last = ($pages->items_total > $pages->high) ? $pages->high+1 : $pages->items_total;

// display number of records and navigation link
echo "<table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>".
    "<tr><td style='color:#FF0000'>Total Record: ".$pages->items_total ." &nbsp; &nbsp;</td>".
    "<td style='color:#642'> [ Showing ".($pages->low+1)." - ".$show_last." ]</td>".
    "<td> &nbsp; ".$pages->display_pages()."</td><td> &nbsp; ".$pages->display_items_per_page()." &nbsp; </td>".
    "<td>".$pages->display_jump_menu()."</td>".
    "</tr></table>";

?>
</ul>
</div>
<table width=98% id='tabledesign' cellspacing=1 cellpadding=1 align=center border=0 bgcolor="" >
<tr bgcolor="#666666" >
<td width="4%"   align=left><b><font color="#FFFFFF" size='1'>#</font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/email.gif" alt="Send Message"  onClick="checkAll(document.form.users)" style="cursor: pointer; "></font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/delete.png" alt="Delete This Applicant"></font></b></td>
<td width="2%"   align=center><b><font color="#FFFFFF" size='1'><img src="images/documentsorcopy16.png" alt="mark Applicants"></font></b></td>
<td width="28%"  align=left><b><font color="#FFFFFF" size='1'>NAME</font></b></td>
<td width="12%"  align=left><b><font color="#FFFFFF" size='1'>DATE REGISTERED</font></b></td>
<td width="25%" align="center"><b><font color="#FFFFFF" size='1'>SKILLS</font></b></td>
<td width="25%" align="center"><b><font color="#FFFFFF" size='1'>MOVE</font></b></td>
</tr>

<?php
$counter=$offset;
$counter=0;
$curr_id = 0;
//$bgcolor="#f5f5f5";

$bgcolor="#ECEBF3";

$r_s = mysql_query($query . $pages->limit);
while ($row = @mysql_fetch_assoc($r_s)) 
{
  $userid = $row["userid"];
  if ($userid == 0) continue;
  $sql = "SELECT p.userid, p.lname, p.fname, p.email, p.skype_id, p.image, DATE_FORMAT(p.datecreated,'%D %b %Y') date,"
  . "p.status p_status, p.voice_path, c.latest_job_title, a.id , a.status a_status "
  . "FROM personal p LEFT JOIN currentjob c ON p.userid=c.userid "
  . "LEFT JOIN applicants a ON a.userid=c.userid "
  . "WHERE p.userid=".$userid ." ORDER BY date DESC LIMIT 1";
  
  $query_object = mysql_query($sql);
  $result = mysql_fetch_array($query_object);  
      
  $lname = $result['lname'];
  $fname = $result['fname'];
  $email = $result['email'];

  $skype_id = $result['skype_id'];
    
  $image= $result['image'];
  $date = $result['date'];
  $status = $result['status'];
  $voice_path = $result['voice_path'];
  $latest_job_title = $result['latest_job_title'];
  $skill = $result['skill'];
  $a_id = $result['a_id'];
  $a_status = $result['a_status'];
  
  
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
    
    <tr bgcolor=<?php echo $bgcolor;?>>
    <td width="4%"  align=left valign="top"><font size='1'><?php echo $counter+$pages->low; ?>) </font></td>
    <td width="2%"  align=center valign="top"><font size='1'> 
      <input name="users" id="users"type="checkbox" onClick="check_val();" value="<?php echo $email;?>" title="Send Email to Applicant <?php echo $fname." ".$lname;?>"  >
    </font></td>
    <td width="2%"   align=center valign="top"><font size='1'>
      <div id='action<?php echo $userid; ?>'><input name="userss" id="userss" type="checkbox" onClick="action_delete('profile',<?php echo $userid;?>);" value="<?php echo $userid;?>" title="Delete Applicant <?php echo $fname." ".$lname;?>"></div>
      </font></td>
    <td width="2%"   align=center valign="top"><font size='1'>
      <input name="mark_applicants" id="mark_applicants" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'popup'); " value="<?php echo $userid;?>" title="<?php echo $mark;?> Applicant <?php echo $fname." ".$lname;?>&nbsp; as a Reserve Staff for future Employment "  >
    
      </font></td>  
    <td width="28%"  align=left valign="top">
    <div style="background-color:#FEFDE2; margin-bottom:0px; float:left;">
    <div style="cursor:pointer;" onMouseOut="hideddrivetip();" onMouseOver="ddrivetip('<?php echo $pic;?>')" class='jobCompanyName' onClick= "javascript:window.location='./application_apply_action.php?userid=<?php echo $userid;?>';" ><?php echo "<b>".$fname." ".$lname."</b>";?></div>
    
    
    </div>
    <div style="float:right">
    <?php if($status=="MARK")
    {
      echo "<img src='images/hot.gif' alt='Marked Applicants'>";
    }
    else { echo "&nbsp;";}
    ?></div>
    <div style=" font-size:11px; margin-top:18px;">
    <b style='color:#FF0000'>
    <?php echo $latest_job_title."<br>"; ?>
    </b>
    <?php echo $email."<br>"."SkypeId : ".$skype_id;?>
    </div>
      <?php
    if ($voice_path!="") 
    { 
      ?>
      <br>
      <a href="./<?php echo $voice_path;?>">Download</a>
      <?php
    } 
    ?>
    
    </td>
    <td width="12%"  align=left valign="top"><font size='1'><?php echo $date;?></font></td>
    <td valign="top">
    <div style="margin-left:10px; text-align:center">
      <i>
  <?php
    
    $sql_query = mysql_query("SELECT skill FROM skills WHERE userid=".$userid);
    $skill_str = '';
    while ($skillset = mysql_fetch_array($sql_query)) {
      if ($skill_str) $skill_str .= ",&nbsp;&nbsp;";
      
      $skill_str .= $skillset['skill'];
    }
    echo $skill_str;  
  
  ?>
    </i>
    </div>
    </td>
    
    
    <td>
        
      <table>
        <tr>
          <td><input name="temp<?php echo $counter; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'No Potential'); " value="No Potential" <?php if($a_status == "No Potential") echo "checked"; ?>></td>
          <td><font size="1">No&nbsp;Potential</font></td>    
          <td><input name="temp<?php echo $counter; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Pre-Screen'); " value="Pre-Screen" <?php if($a_status == "Pre-Screen") echo "checked"; ?>></td>
          <td><font size="1">Pre-Screen</font></td>
        </tr>    
        <tr>
          <td><input name="temp<?php echo $counter; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Unprocessed'); " value="Unprocessed" <?php if($a_status == "Unprocessed") echo "checked"; ?>></td>
          <td><font size="1">Unprocessed</font></td>
          <td><input name="temp<?php echo $counter; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Shortlist'); " value="Shorlisted" <?php if($a_status == "Shortlisted") echo "checked"; ?>></td>
          <td><font size="1">Shorlisted</font></td>
        </tr>  
        <tr>
          <td><input name="temp<?php echo $counter; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Endorse to Client'); " value="Endorsed" <?php if($a_status == "Endorse to Client") echo "checked"; ?>></td>
          <td><font size="1">Endorse to Client</font></td>
          <td><input name="temp<?php echo $counter; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Select'); " value="Select" <?php if($a_status == "Select") echo "checked"; ?>></td>
          <td><font size="1">Select</font></td>      
        </tr>
        <tr>
          <td><input name="temp<?php echo $counter; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Become a Staff'); " value="Become a Staff" <?php if($a_status == "Sub Contracted") echo "checked"; ?>></td>
          <td><font size="1">Become a Staff</font></td>
          <td><input name="temp<?php echo $counter; ?>" type="radio" onChange="javascript: move(<?php echo $userid; ?>, 'Category'); " value="Become a Staff"></td>
          <td><font size="1">Add to Categories <br />/ Evaluate</font></td>        
        </tr>    
      </table>
    </td>
    
    
    </tr>
  <?php
    
    if($bgcolor=="#ECEBF3"){$bgcolor="#E6E6F0";}else{$bgcolor="#ECEBF3";}
    $curr_id = $result[$i]['userid'];
  
}
  
// display number of records and navigation link
echo "<table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>".
    "<tr><td style='color:#FF0000'>Total Record: ".$pages->items_total ." &nbsp; &nbsp;</td>".
    "<td style='color:#642'> [ Showing ".($pages->low+1)." - ".$show_last." ]</td>".
    "<td> &nbsp; ".$pages->display_pages()."</td><td> &nbsp; ".$pages->display_items_per_page()." &nbsp; </td>".
    "<td>".$pages->display_jump_menu()."</td>".
    "</tr></table>";


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

</body>
</html>



