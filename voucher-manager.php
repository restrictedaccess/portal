<?php
include 'config.php';
include 'conf.php';
include 'time.php';
//error_reporting(E_ALL);


//REDUCE THE SIZE OF COMMENTS
function truncate_comment($string) 
{
	return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[19].'...';
}
//ENDED


if($_SESSION['agent_no'] == "" || $_SESSION['agent_no']==NULL){
	header("Location: index.php");
}
 
$agent_no = $_SESSION['agent_no'];


//POST
$f_code_number = $_REQUEST['f_code_number']; if($f_code_number == "") $f_code_number = "Any";
$f_date_expire = $_REQUEST['f_date_expire']; if($f_date_expire == "") $f_date_expire = "Any";
$f_date_created = $_REQUEST["f_date_created"]; if($f_date_created == "") $f_date_created = "Any";
$f_admin_id = $_REQUEST["f_admin_id"]; if($f_admin_id == "") $f_admin_id = "Any";
$f_comment = @$_REQUEST["f_comment"]; if($f_comment == "") $f_comment = "Any";
$f_limit_of_use = @$_REQUEST["f_limit_of_use"]; if($f_limit_of_use == "") $f_limit_of_use = "1";
$p = @$_REQUEST["p"];
//ENDED


//INSERT VOUCHER
if(@isset($_REQUEST["create"]))
{
	mysql_query("INSERT INTO voucher SET
	admin_id = '0',
	bp_id = '$agent_no',
	code_number = '$f_code_number',
	comment = '$f_comment',
	limit_of_use = '$f_limit_of_use',
	date_expire = '$f_date_expire',
	date_created = '$f_date_created'
	");
}	
//ENDED


//FUNCTIONS
function search($f_code_number,$f_date_expire,$f_date_created,$f_admin_id,$p,$maxp,$max) 
{
	$set = ($p-1)*$maxp ;
	
	$from = "FROM voucher";
	$order_by = "ORDER BY date_created DESC LIMIT $set, $maxp";	
	$fields = "*";

	//default	
	$date_today = date('Y-m-d');
	$where = "WHERE date_created='$date_today' AND bp_id='".$_SESSION['agent_no']."'";
	$query = "SELECT $fields $from $where $order_by";
	//ended
	
	if($f_code_number != "Any" || $f_date_expire != "Any" || $f_date_created != "Any" || $f_admin_id != "Any")
	{	
		$where = "bp_id='".$_SESSION['agent_no']."'";
		if($f_code_number != "Any")
		{
			$where = $where." AND code_number = '$f_code_number'";
		}
		if($f_date_expire != "Any")
		{
			$where = $where." AND date_expire = '$f_date_expire'";
		}
		if($f_date_created != "Any")
		{
			$where = $where." AND date_created = '$f_date_created'";
		}		
		$where = "WHERE ".$where;
		$query = "SELECT $fields $from $where $order_by";
	}

	$result =  mysql_query($query);
	
	if(!isset($max))
	{
		$m =  mysql_query("SELECT id $from $where");
		$max = mysql_num_rows($m);
	}
	
	$x = 0 ;	
	while ($r = mysql_fetch_assoc($result)) 
	{
		$temp[$x]['title'] = $title;
		$temp[$x]['max'] = $max;
		$temp[$x]['id'] = $r['id'];
		$temp[$x]['admin_id'] = $r['admin_id'];
		$temp[$x]['bp_id'] = $r['bp_id'];
		if($temp[$x]['bp_id'] == 0)
		{
			$temp[$x]['bp_name'] = "System Generated";
		}
		else
		{
			$q = "SELECT agent_no,fname,lname FROM agent WHERE agent_no='".$temp[$x]['bp_id']."'";
			$r_e = mysql_query($q);
			while ($rr = mysql_fetch_assoc($r_e)) 
			{
				$temp[$x]['bp_name'] = $rr["fname"]." ".$rr["lname"];
			}		
		}	
		$temp[$x]['code_number'] = $r['code_number'];
		$temp[$x]['comment'] = $r['comment'];
		$temp[$x]['date_expire'] = $r['date_expire'];
		$temp[$x]['date_created'] = $r['date_created'];
		$x++ ;
	}
	return $temp ;
}

function linkpage($f_code_number,$f_date_expire,$f_date_created,$f_admin_id,$p,$size,$d) 
{
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="?f_limit_of_use='.$f_limit_of_use.'&f_code_number='.$f_code_number.'&f_date_expire='.$f_date_expire.'&f_date_created='.$f_date_created.'&f_admin_id='.$f_admin_id.'&max='.$max.'&p='.($p-1).'"><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="?f_limit_of_use='.$f_limit_of_use.'&f_code_number='.$f_code_number.'&f_date_expire='.$f_date_expire.'&f_date_created='.$f_date_created.'&f_admin_id='.$f_admin_id.'&max='.$max.'&p='.($p + 1).'"><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ENDED - FUNCTIONS



//GENERATE REPORT
if (!isset($p)) $p = 1 ;
$maxp = 20 ;
$found = search($f_code_number,$f_date_expire,$f_date_created,$f_admin_id,$p,$maxp,$max) ;
$pages = linkpage($f_code_number,$f_date_expire,$f_date_created,$f_admin_id,$p,$maxp,$found[0]['max']) ;
//ENDED


//GENERATE VOUCHER NUMBER
	$l = rand(1000, 2000);
	$gen_f_code_number = $l.rand(10000000, 20000000) ;
	for($i=0; $i < 2; $i++)
	{
		$q=mysql_query("SELECT id FROM voucher WHERE code_number = '$gen_f_code_number' LIMIT 1");
		$n = mysql_num_rows($q);
		if ($n > 0) 
		{
			$i = 0;
			$l = rand(1000, 2000);
			$gen_f_code_number = $l.rand(10000000, 20000000) ;
		}
		else
		{
			$i = 3; //break the loop
		}
	}
//ENDED
?>   
<html>
<head>
<title>Voucher Manager</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">

<!--calendar picker - setup-->
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<script language="javascript">
		var curSubMenu = '';
		var selected_x_id = 0;
		
		function lead(id) 
		{
			previewPath = "viewLead.php?id="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			

		function voucher_details(id) 
		{
			previewPath = "admin_request_for_interview_popup.php?v="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			
		
		function update(id) 
		{
			previewPath = "update_endorse_to_client.php?id="+id;
			window.open(previewPath,'_blank','width=500,height=400,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
	
		function showSubMenu(menuId)
		{
			if (curSubMenu!='') 
				hideSubMenu();
			
			eval('document.all.'+menuId).style.visibility='visible';
			curSubMenu=menuId;
		}
		
		function hideSubMenu()
		{
			eval('document.all.'+curSubMenu).style.visibility='hidden';
			curSubMenu='';
		}
		
		function makeObject()
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
		var voucher_obj = makeObject()
		function update_voucher(id,voucher)
		{
			selected_x_id = id;
			var comments = document.getElementById('comments_'+id).value;
			var date_expire = document.getElementById('date_expire_'+id).value;
			voucher_obj.open('get', 'admin_request_for_interview_voucher_update.php?code_number='+voucher+'&date_expire='+date_expire+'&comment='+comments)
			voucher_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			voucher_obj.onreadystatechange = voucher_details_preview 
			voucher_obj.send(1)
			hideSubMenu();
		}
		function voucher_details_preview()
		{
			var data;
			data = voucher_obj.responseText
			if(voucher_obj.readyState == 4)
			{
				document.getElementById('voucher_details_'+selected_x_id).innerHTML = data;
			}
			else
			{
				document.getElementById('voucher_details_'+selected_x_id).innerHTML="<img src='images/ajax-loader.gif'>";
			}
		}			
		
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="">
<form name="form">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php include 'agentleftnav.php';?>
<br></td>
<td width=100% valign=top >
<h3 style="padding:5px;">Voucher Manager</h3>


<!-- REPORT CONTAINER -->
<table width="100%" border="0" bgcolor="#2A629F" cellpadding="10" cellspacing="2">
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff" colspan="2">

						
					<table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="10" cellspacing="1">
                      <tr>
							<td align="left" valign="top" bgcolor="#ffffff"> <font color="#000000"><strong>
								<form action="?" method="post" name="formtable">
								<table width="0%"  border="0" cellspacing="3" cellpadding="3">
									<tr>
										<td>	  
											<strong>Voucher</strong><em>(optional)</em>
										</td>
										<td><input type="text" id="f_code_number_id" name="f_code_number" value="<?php if($f_code_number == "") echo "Any"; else echo $f_code_number; ?>" class="select" /></td>							  
									</tr>
									<tr>
										<td scope="row"><font color="#000000"><strong>Date&nbsp;Created</strong></font></td>
										<td>
													<table>
                                                    	<tr>
                                                        	<td><img align="absmiddle" src="../images/date-picker.gif" id="id_f_date_created_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                            <td>
                                        					<input type="text" name="f_date_created" id="id_f_date_created" class="text" value="<?php if($f_date_created == "") echo "Any"; else echo $f_date_created; ?>">
															<script type="text/javascript">
																Calendar.setup({
																		inputField	: "id_f_date_created",
																		ifFormat	: "%Y-%m-%d",
																		button		: "id_f_date_created_button",
																		align		: "Tl",
																		showsTime	: false, 
																		singleClick	: true
																});
															</script>                                         
                                                            </td>
                                                        </tr>
													</table>                                        
                                        </td>
									</tr>
									<tr>
										<td scope="row"><font color="#000000"><strong>Date&nbsp;Expire</strong></font></td>
										<td>
													<table>
                                                    	<tr>
                                                        	<td><img align="absmiddle" src="../images/date-picker.gif" id="id_f_date_expire_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                            <td>
                                        					<input type="text" name="f_date_expire" id="id_f_date_expire" class="text" value="<?php if($f_date_expire == "") echo "Any"; else echo $f_date_expire; ?>">
															<script type="text/javascript">
																Calendar.setup({
																		inputField	: "id_f_date_expire",
																		ifFormat	: "%Y-%m-%d",
																		button		: "id_f_date_expire_button",
																		align		: "T2",
																		showsTime	: false, 
																		singleClick	: true
																});
															</script>                                         
                                                            </td>
                                                        </tr>
													</table>                                        
                                        </td>
									</tr>									
									<tr>
										<td></td><td valign="top"><font color="#000000"><input type="submit" value="Search" name="submit" class="button">									
									</tr>
								</table>
								</form>
							</td>
						<tr />
					</table>
						
						
						
						
						
						</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF" colspan="3">
						
								<table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="10" cellspacing="1">
                      <tr>
							<td align="left" valign="top" bgcolor="#ffffff"> <font color="#000000"><strong>
								<form action="?" method="post" name="formtable">
								<table width="0%"  border="0" cellspacing="3" cellpadding="3">
									<tr>
										<td>	  
											<strong>Voucher</strong>
										</td>
										<td><input type="text" id="f_code_number_id" name="f_code_number" value="<?php echo $gen_f_code_number; ?>" class="select" /></td>							  
										<td rowspan="1" align="center"><strong>Notes</strong></td>
									</tr>
									<tr>
										<td scope="row"><font color="#000000"><strong>Date&nbsp;Created</strong></font></td>
										<td>
													<table>
                                                    	<tr>
                                                        	<td><img align="absmiddle" src="../images/date-picker.gif" id="id_f_date_created_c_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                            <td>
                                        					<input type="text" name="f_date_created" id="id_f_date_created_c" class="text" value="<?php echo date('Y-m-d'); ?>">
															<script type="text/javascript">
																Calendar.setup({
																		inputField	: "id_f_date_created_c",
																		ifFormat	: "%Y-%m-%d",
																		button		: "id_f_date_created_c_button",
																		align		: "T3",
																		showsTime	: false, 
																		singleClick	: true
																});
															</script>                                         
                                                            </td>
                                                        </tr>
													</table>
										</td>
										<td rowspan="4" align="center" valign="top">
											<textarea name="f_comment" rows="4" class="text" id="id_f_comment"><?php echo $gen_f_comment; ?></textarea>										
										</td>
									</tr>
									<tr>
										<td scope="row"><font color="#000000"><strong>Date&nbsp;Expire</strong></font></td>
										<td>
													<table>
                                                    	<tr>
                                                        	<td><img align="absmiddle" src="../images/date-picker.gif" id="id_f_date_expire_c_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                            <td>
                                        					<input type="text" name="f_date_expire" id="id_f_date_expire_c" class="text" value="<?php $a = mktime(0, 0, 0, date("n"), +30, date("Y")); echo date("Y-m-d",$a); ?>">
															<script type="text/javascript">
																Calendar.setup({
																		inputField	: "id_f_date_expire_c",
																		ifFormat	: "%Y-%m-%d",
																		button		: "id_f_date_expire_c_button",
																		align		: "T4",
																		showsTime	: false, 
																		singleClick	: true
																});
															</script>                                         
                                                            </td>
                                                        </tr>
													</table>                                        
                                        </td>
									</tr>	
									<tr>
										<td scope="row"><font color="#000000"><strong>Limit</strong></font></td>
										<td><input type="text" name="f_limit_of_use" id="id_f_limit_of_use" class="text" value="<?php echo $f_limit_of_use; ?>" size="2" maxlength="2"></td>
									</tr>                                    								
									<tr>
										<td scope="row"><font color="#000000"><strong>Source</strong></font></td>
									  <td>
											  <select size="1" class="text" name="f_admin_id" id="id_f_admin_id">
												<?php
													echo "<option value='".$_SESSION['agent_no']."' selected>BP Account</option>";
													echo "<option value='0'>System Generated</option>";
												?>
											  </select>
										</td>							
									</tr>
									<tr>
										<td></td><td valign="top"><font color="#000000"><input type="submit" value="Create" name="create" class="button">									
									</tr>
								</table>
								</form>
							</td>
						<tr />
					</table>
						
						</td>
                      </tr>
					  <tr>
						<td align="left" valign="middle" bgcolor="#2A629F" colspan="4"><font color="#FFFFFF"><strong>Showing Result for: <?php echo $found[0]['title']; ?></strong></font></td>
						<td colspan="1" align="right"><font color="#FFFFFF"><strong><?php echo $pages; ?></strong></font></td>
					  </tr>						  

	
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong>Source</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong>Voucher&nbsp;Number</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date&nbsp;Expire</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date&nbsp;Created</strong></font></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3" width="100%"><font color="#000000"><strong>Notes</strong></font></td>
                      </tr>	

					  
					  
<!----------------------------------------------------------------------------------------->
<?php
$x = 0;
if ($found[0]['max'] <> 0) 
{
	$total = count($found);
	for ($x=0; $x < $total; $x++) 
	{
?>

						  <tr>
							<td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<?php 
									echo $found[$x]['bp_name'];
								?>
								
								
								<!-- NOTES BOX -->	
								<div id="notes_<?php echo $x; ?>" STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
								<table bgcolor="#2A629F" width="300" cellpadding="1" cellspacing="1"><tr><td>
									<table bgcolor="#FFFFCC" width="300" cellpadding="5" cellspacing="5">
										<tr>
											<td align="right"><a href="javascript: hideSubMenu(); "><img src="images/action_delete.png" border="0"></a></td>
										</tr>
										<tr>
											<td>
												<font size="1"><?php echo $found[$x]['comment']; ?></font>
											</td>
										</tr>
									</table>
								</td></tr>	
								</table>	
								</div>
								<!-- ENDED - NOTES BOX -->	
																
																
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<?php echo $found[$x]['code_number']; ?>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['date_expire']; ?>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['date_created']; ?>
							</td>							
							<td align="left" valign="top" bgcolor="#FFFFFF">
							<?php $temp = truncate_comment($found[$x]['comment']); ?>
							<a href="javascript: showSubMenu('notes_<?php echo $x; ?>'); "><?php echo $temp; ?></a>
							</td>
						  </tr>
<?php 
	}
}				
?>
<!------------------------------------------------------------------------------->
					

					
                      <tr>
                        <td align="left" valign="top" bgcolor="#2A629F"><font color="#FFFFFF"><strong>Total(<?php echo $x; ?>)</strong></font></td>
						<td align="right" valign="top" bgcolor="#2A629F" colspan="4"><font color="#FFFFFF"><strong><?php echo $pages; ?></strong></font></td>
                      </tr>
		
                    </table>
<!-- ENDED - REPORT CONTAINER -->



</td>
</tr>
</table>
<?php include 'footer.php';?>		
</form>	
</body>
</html>
