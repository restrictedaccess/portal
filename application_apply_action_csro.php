<?php
//2011-07-29  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   updated csro files link
putenv("TZ=Philippines/Manila");
include('conf/zend_smarty_conf.php');
include 'config.php';
include 'function.php';
include 'conf.php';

if(@isset($_REQUEST["delete_id"]))
{
	$r = $db->fetchAll("SELECT name FROM csro_files WHERE id='".$_REQUEST["delete_id"]."'");	
	foreach($r as $r)
	{	
		$f_name = $r['name'];
		$d_id = $_REQUEST["delete_id"];
		mysql_query("DELETE FROM csro_files WHERE id='".$_REQUEST["delete_id"]."'");	
		unlink("uploads/csro_files/".$f_name);
	}
	header("location: ?userid=".$_REQUEST["userid"]);
}

if(!isset($_SESSION['admin_id']) && !isset($_SESSION['agent_no']))
{
	echo '
	<script language="javascript">
		alert("Session expired...'.$_SESSION['admin_id'].'");
		window.location="index.php";
	</script>
	';
}

$userid=$_GET['userid'];
?>



<html>

<head>

<title>Applications</title>
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

function check_val()
{
	var ins = document.getElementsByName('recruitment_job_order_form')
	var i;
	var j=0;
	var vals="without"; //= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			//vals[j]=ins[i].value;
			//j++;
			vals="with";
		}
	}
	document.form.job_order.value=(vals);
}
function leadsNavigation(direction){
	var selObj = document.getElementById("leads");
	current_index = selObj.selectedIndex;
	if(direction!="direct"){
		if(direction == "back"){
			if(current_index >0){
				current_index = current_index-1;
			}else{
				current_index =0 ;
			}	
		}
		if(direction == "forward"){
			current_index = current_index+1;
		}
		value = selObj.options[current_index].value;
	}else{
		value = selObj.value;
	}
	location.href = "<?=basename($_SERVER['SCRIPT_FILENAME']);?>?id="+value;
}

function checkFields()
{
	if(document.form.star.selectedIndex==0)
	{
		missinginfo = "";
		if(document.form.txt.value=="")
		{
			missinginfo += "\n     -  There is no message or details to be save or send \t \n Please enter details.";
		}
		if (document.form.mode.value =="")
		{
			if (document.form.fill.value=="" )
			{
				missinginfo += "\n     -  Please choose actions.";
			}
			if (document.form.fill.value=="EMAIL" )
			{
				if (document.form.subject.value=="" )
				{
					missinginfo += "\n     -  Please enter a subject in your Email.";
				}
				if (document.form.templates[0].checked==false && document.form.templates[1].checked==false && document.form.templates[2].checked==false)
				{
					missinginfo += "\n     -  Please choose email templates.";
				}
			}
		}	
		if (missinginfo != "")
		{
			missinginfo =" " + "You failed to correctly fill in the required information:\n" +
			missinginfo + "\n\n";
			alert(missinginfo);
			return false;
		}
		else return true;
	}
}



	function popup_calendar(id) 



	{



		previewPath = "application_calendar/popup_calendar.php?id="+id;



		window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');



	}


	function admin_edit(userid,p)
	{
		previewPath = p+"?userid="+userid;
		window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
	function bank_accounts(userid)
	{
		previewPath = "admin_bank_account_details.php?userid="+userid;
		window.open(previewPath,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
	
</script>	









<!-- ROY'S CODE ------------------->

		<script language="javascript">

		var chck = 0;

		var temp = '';

		var int=self.setInterval('check_schedule(temp)',9000)	

		var curSubMenu = '';	

		function check_schedule(id,a)

		{

			chck = 0;

			http.open("GET", "app_return_schedule.php?a="+a+"&id="+id, true);

			http.onreadystatechange = handleHttpResponse;

			http.send(null);

		}

		function hideAlarm(id,a)

		{
			
			a = a;
			
			chck = 0;

			document.getElementById('alarm').style.visibility='hidden';

			check_schedule(id,a);

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

		
		
		//delete top 10
		var request = getHTTPObject()
		var pull_time_rate_var;	
		var part_time_rate_var;		
		function action_delete(type,id)
		{
			request.open('get', 'application_apply_action_delete.php?type='+type+'&id='+id)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.send(1)
			alert("Selected record has been deleted.");
			document.getElementById("action"+id).innerHTML="<FONT color='#FF0000' size=1><strong>DELETED</strong></FONT>";
		}		
		//end delete
		

		function update_staff_rate(userid)
		{
			pull_time_rate_var = document.getElementById('pull_time_rate_id').value;
			part_time_rate_var = document.getElementById('part_time_rate_id').value;
			//if(pull_time_rate_var == '' && part_time_rate_var == '')
			//{
				//alert("Please select the staff rate.");
			//}
			//else
			//{	
				request.open('get', 'application_apply_action_update_category.php?pull_time_rate='+pull_time_rate_var+'&part_time_rate='+part_time_rate_var+'&userid='+userid)
				request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				request.send(1)
				alert("Changes has been saved");
			//}	
		}		


		//var curSubMenu='';
		function showSubMenu(menuId){

				if (curSubMenu!='') hideSubMenu();

				eval('document.all.'+menuId).style.visibility='visible';

				curSubMenu=menuId;

		}

		

		function hideSubMenu(){

				eval('document.all.'+curSubMenu).style.visibility='hidden';

				curSubMenu='';

		}


		function leadsNavigation(direction)
		{
			var selObj = document.getElementById("leads");
			current_index = selObj.selectedIndex;
			if(direction!="direct"){
				if(direction == "back"){
					if(current_index >0){
						current_index = current_index-1;
					}else{
						current_index =0 ;
					}	
				}
				if(direction == "forward"){
					current_index = current_index+1;
				}
				value = selObj.options[current_index].value;
			}else{
				value = selObj.value;
			}
			location.href = "<?=basename($_SERVER['SCRIPT_FILENAME']);?>?userid="+value;
		}


		function change_rating(id, rating) 
		{
			previewPath = "change_rating.php?rating="+rating+"&userid="+id;
			window.open(previewPath,'_blank','width=300,height=300,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			

		function change_top10(id, rating) 
		{
			previewPath = "change_top10.php?rating="+rating+"&userid="+id;
			window.open(previewPath,'_blank','width=300,height=300,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}	
		
		function move(id, status) 
		{
			switch(status)
			{
				case "Category":
					previewPath = "adminadvertise_add_to_category.php?userid="+id;
					break;			
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
			}	
			window.open(previewPath,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		
		function send_sample(id) 
		{
			previewPath = "applicants_sample_send_email.php?userid="+id;
			window.open(previewPath,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}		
		//menu		

		function bank_accounts(userid)
		{
			previewPath = "admin_bank_account_details.php?userid="+userid;
			window.open(previewPath,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}		
		function asl_checker(path) 
		{
			window.open(path,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		

		</script>		

<!-- ROY'S CODE ------------------->			





<style type="text/css">

<!--

	div.scroll {
		height: 200px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		font-family:Tahoma, Verdana; 
		font-size:12px;
	}

	.scroll p{

		margin-bottom: 10px;

		margin-top: 4px;

	}

	.spanner

	{

		float: right;

		text-align: right;

		padding:5px 0 5px 10px;

	

	

	}

	.spannel

	{

		float: left;

		text-align:left;

		padding:5px 0 5px 10px;

		border:#f2cb40 solid 1px;

		

	}	

.l {

	float: left;

	}	



.r{

	float: right;

	}

	

.btn{
	font:11px Tahoma;
}	

-->

</style>	

</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<form method="POST" name="form" action="application_apply_actionphp.php?userid=<?php echo $userid; ?>" enctype="multipart/form-data"  onsubmit="return checkFields();">
<input type="hidden" name="userid" value="<? echo $userid?>">
<input type="hidden" name="id" id="leads_id" value="<? echo $userid;?>">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="fill" value="">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<input type="hidden" name="hid" value="<? echo $hid;?>">
<input type="hidden" name="fullname" value="<? echo $fname." ".$lname;?>">
<input type="hidden" name="email" value="<? echo $email;?>">
<input type="hidden" name="job_order" id="job_order" >


<!-- HEADER -->

<script language=javascript src="js/functions.js"></script>


<?php
if(@$_GET["page_type"] != "popup")
{
include 'header.php';
include 'admin_header_menu.php';
}
?>

<table width=100% cellpadding=0 cellspacing=0 border=0 >
	<?php
    if(@$_GET["page_type"] != "popup")
    {
    ?>
	<tr>
    	<td width="173" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '><? include 'applicationsleftnav.php';?></td>
		<?php } ?>
		<td valign=top align=left>
			<table width="100%">
				<tr>
					<td valign="top">
                        <table width=100% cellpadding=3 cellspacing="3" border=0 align=left>
                        <tr>
                            <td width=100%>
                                <div class="subtab">
                                    <ul>
                                        <li id="cp"><a href="application_apply_action.php?userid=<?php echo $userid; ?>"><span>Candidate's Profile Manager</span></a></li>
                                        <li id="csro" class="selected"><a href="application_apply_action_csro.php?userid=<?php echo $userid; ?>"><span>CSRO Report</span></a></li>
                                    </ul>
                                </div> 
                            </td>
                        </tr>
                        <tr>
                            <td width=100%>
                                <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
                                        <input type="button" class="button" value="ASL Staff Checker" onClick="javascript: asl_checker('tools/AvailableStaffChecker/AvailableStaffChecker.html'); "/>
                                        <input type="button" class="button" value="Bank Accounts" onClick="javascript: bank_accounts(<?php echo $userid; ?>); "/>
                                    </div>
                                </div>		
                            </td>
                        </tr>
                        <tr>
                            <td width=100%>
                                <table cellspacing=1 cellpadding=3 width=100% >
                                    <tr>
                                        <td colspan="2"><font color='#000000'><b>FILES&nbsp;UPLOADED</b></font></td>
                                    </tr>
                                    
                                    <?php
										$queryAllStaff = "SELECT DISTINCT(s.leads_id), l.fname, l.lname 
											FROM leads l, subcontractors s
											WHERE l.id = s.leads_id AND s.userid = '$userid'";
											$result = $db->fetchAll($queryAllStaff);
											foreach($result as $result)
											{
                                                $r = $db->fetchAll("SELECT * FROM csro_files WHERE userid ='$userid' AND leads_id='".$result['leads_id']."'");	
												$output = "";
												$counter = 0;
												foreach($r as $r)
												{
													
													if($r["admin_id"] > 0)
													{
														$sql=$db->select()
															->from('admin')
															->where('admin_id = ?' ,$r["admin_id"]);
														$ad = $db->fetchRow($sql);
														$uploaded_by = $ad['admin_fname']." ".$ad['admin_lname'];
													}
													else
													{
														$sql=$db->select()
															->from('agent')
															->where('agent_no = ?' ,$r["bp_id"]);
														$bp = $db->fetchRow($sql);
														$uploaded_by = $bp['fname']." ".$bp['lname'];
													}
													
													$output = $output.'	
                                                    <tr>
                                                    	<td align="right">&nbsp;<strong>></strong>&nbsp;Uploaded&nbsp;by: </td>
                                                        <td width=100%>
                                                            '.$uploaded_by.' 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="right">
															<a href="application_apply_action_csro.php?userid='.$userid.'&delete_id='.$r['id'].'"><img src="images/delete.png" border=0></a>
                                                        </td>
                                                        <td width=100%>
                                                            '.$r['type'].':&nbsp;<i><a href="get_csro_files.php?file_id='.$r["id"].'" target="_blank">'.$r["name"].'</a></i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>&nbsp;</td>
                                                        <td width=100%>
                                                            "'.$r['comment'].'"<br /><br />
                                                        </td>
                                                    </tr>													
													';
													$counter++;
                                                }
												
												//display output
												echo "
												<tr>
													<td colspan=2><strong>".$result['fname']." ".$result['lname']."</strong>(".$counter.")</td>
												</tr>
												".$output;
												//ended											
											}
									?>		
										
                                </table>
                            </td>
                        </tr>
                        </table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<script type="text/javascript">

<!--

showProductForm();

--> 

</script>

<?php
if(@$_GET["page_type"] != "popup")
{
include 'footer.php';
}
?>

</form>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
</body>
</html>

