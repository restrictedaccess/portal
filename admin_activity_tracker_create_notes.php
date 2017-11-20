<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include('conf/zend_smarty_conf.php');

$admin_id = @$_SESSION['admin_id'];	
$submit = @$_REQUEST["submit"];
if($admin_id == "")
{
	 header("location:../");
}


	if(@isset($submit))
	{
			$date_to_execute = @$_REQUEST["date_to_execute"];
					switch ($date_to_execute) 
					{
						case "today" :
							$a_1 = time();
							$b_1 = time() + (1 * 24 * 60 * 60);
							$a_ = date("Y-m-d"); 
							$b_ = date("Y-m-d",$b_1);
							$title = "Today (".date("M d, Y").")";
							break;
						case "nextday" :
							$a_1 = time() + (1 * 24 * 60 * 60);
							$b_1 = time() + (1 * 24 * 60 * 60);
							$a_ = date("Y-m-d",$a_1);
							$b_ = date("Y-m-d",$b_1);
							$title = "Next Day (".date("M d, Y",$a_1).")";
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
						case "nextmonth" : 
							$a_1 = mktime(0, 0, 0, date("n"), +31, date("Y"));
							$b_1 = mktime(0, 0, 0, date("n"), +60, date("Y"));
							$a_ = date("Y-m-d",$a_1);
							$b_ = date("Y-m-d",$b_1);
							$title = "Next Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
							break;
						case "next7days" :
							$a_1 = time() + (7 * 24 * 60 * 60);
							$b_1 = time() + (14 * 24 * 60 * 60);
							$a_ = date("Y-m-d",$a_1);
							$b_ = date("Y-m-d",$b_1);
							$title = "Next 7 Days (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
							break;
						case "alltime" :
							$a_ = "2010-01-01";
							$b_ = "2011-01-01";
							$title = "All time";			
							break;
						case "everymonth":
							$a_ = @$_REQUEST["day_from"];
							$b_ = @$_REQUEST["day_to"];
							$title = "Every Month";		
							break;	
						case "moreoptions":
							$a_ = @$_REQUEST["start_year"]."-".@$_REQUEST["start_month"]."-".@$_REQUEST["start_day"];
							$b_ = @$_REQUEST["end_year"]."-".@$_REQUEST["end_month"]."-".@$_REQUEST["end_day"];
							$title = "More Option (".$a_." to ".$b_.")";		
							break;								
						default:
							$title = $date_to_execute;
							break;	
					}
		
			
			$client_id = @$_REQUEST["client_id"];	
			$subcon_id = @$_REQUEST["subcon_id"];	
			$country = @$_REQUEST["country"];	

			if($client_id == "")
			{
				$client_id = 11;
			}
			if($subcon_id == "")
			{
				$subcon_id = 69;
			}
			if($admin_id == "")
			{
				$admin_id = 2;
			}	
		
			$note = @$_REQUEST["note"];	
			$method = @$_REQUEST["method"];	
			$status = "ACTIVE";
			$date_to_execute_from = $a_;
			$date_to_execute_to	= $b_;	
			$date_details = $title;
			$date_added = date("Y-m-d");	
	
			mysqli_query($link2, "INSERT INTO tb_admin_activity_tracker_notes SET admin_id='$admin_id', client_id='$client_id', subcon_id='$subcon_id', note='$note', country_city='$country', method='$method', status='$status', date_to_execute_from='$date_to_execute_from', date_to_execute_to='$date_to_execute_to', date_details='$date_details', date_added='$date_added'");	
	}		
?>

	
	
<html><head>
<title>Administrator - Job Category Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">

<script type="text/javascript" src="media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
<script type="text/javascript">
tinyMCE.init({

    // General options

    mode : "textareas",

    theme : "advanced",

    plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",



    // Theme options

    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",

    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",

    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",

    theme_advanced_toolbar_location : "top",

    theme_advanced_toolbar_align : "left",

    theme_advanced_statusbar_location : "bottom",

    theme_advanced_resizing : true,



    // Example content CSS (should be your site CSS)

    content_css : "css/example.css",



    // Drop lists for link/image/media/template dialogs

    template_external_list_url : "js/template_list.js",

    external_link_list_url : "js/link_list.js",

    external_image_list_url : "js/image_list.js",

    media_external_list_url : "js/media_list.js",



    // Replace values for the template plugin

    template_replace_values : {

        username : "Some User",

        staffid : "991234"

    }

});
</script>


<script language="javascript">
		var curSubMenu = '';
		
			// s t a r t   a j a x
			function makeObject(){
				var x 
				var browser = navigator.appName 
				if(browser == 'Microsoft Internet Explorer'){
					x = new ActiveXObject('Microsoft.XMLHTTP')
				}else{
					x = new XMLHttpRequest()
				}
				return x
			}
			var request = makeObject()
			var notes = "";

				//client settings
				function check_client_settings(id) 
				{
					request.open('get', 'admin_activity_tracker_validate_settings.php?id='+id)
					request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
					request.onreadystatechange = get_client_settings 
					request.send(1)
				}
				function get_client_settings()
				{
					var data = request.responseText
					if(request.readyState == 4)
					{
						notes = data
						load_subcon(document.getElementById('c_id').value,document.getElementById('method_id').value)
					}
					else
					{
						document.getElementById("loading_div").innerHTML="<img src='images/ajax-loader.gif'>";
					}
				}			
				//end client settings
				
				//load subcontractors
				function load_subcon(client_id,method) 
				{
					request.open('get', 'admin_activity_tracker_load_subcon.php?method='+method+'&client_id='+client_id)
					request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
					request.onreadystatechange = get_subcon_dropdown 
					request.send(1)
				}
				function get_subcon_dropdown()
				{
					var data = request.responseText
					if(request.readyState == 4)
					{
						document.getElementById("subcon_div").innerHTML=data
						document.getElementById("loading_div").innerHTML="<font color='#FF0000'><strong>"+notes+"</strong></font>"
					}
					else
					{
						document.getElementById("loading_div").innerHTML="<img src='images/ajax-loader.gif'>";
					}					
				}
				//end load subcontractors
			// e n d   a j a x
			
			function validate_client_sub(data)
			{
				if(data == "PER STAFF")
				{
					document.getElementById('c_id').disabled = false
					document.getElementById('s_id').disabled = false			
					document.getElementById('country_id').disabled = true
				}
				if(data == "ALL")
				{
					document.getElementById('c_id').disabled = true
					document.getElementById('s_id').disabled = true
					document.getElementById('country_id').disabled = true
				}
				if(data == "PER CLIENT")
				{
					document.getElementById('c_id').disabled = false
					document.getElementById('s_id').disabled = true			
					document.getElementById('country_id').disabled = true
				}
				if(data == "PER COUNTRY CITY")
				{
					document.getElementById('country_id').disabled = false				
					document.getElementById('c_id').disabled = true
					document.getElementById('s_id').disabled = true
				}				
			}
			
			function validate_day_to_execute(data)
			{
				if(data == "everymonth")
				{
					document.getElementById("day").innerHTML= "<table><tr><td><em><font size='1'>Day from</font></em></td><td><select name='day_from' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'><option value='1'>01</option><option value='2'>02</option><option value='3'>03</option><option value='4'>04</option><option value='5'>05</option><option value='6'>06</option><option value='7'>07</option><option value='8'>08</option><option value='9'>09</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option></select></td><td><em><font size='1'>Day to</font></em></td><td><select name='day_to' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'><option value='1'>01</option><option value='2'>02</option><option value='3'>03</option><option value='4'>04</option><option value='5'>05</option><option value='6'>06</option><option value='7'>07</option><option value='8'>08</option><option value='9'>09</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option></select></td></tr></table>";				
				}		
				else if(data == "moreoptions")
				{
					document.getElementById("day").innerHTML= "<table width='100' border='0'><tr><td><font size='1'><em>from</em></font></td><td><SELECT NAME='start_month' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'><OPTION VALUE='1'>Jan</OPTION><OPTION VALUE='2'>Feb</OPTION><OPTION VALUE='3'>Mar</OPTION><OPTION VALUE='4'>Apr</OPTION><OPTION VALUE='5'>May</OPTION><OPTION VALUE='6'>Jun</OPTION><OPTION VALUE='7'>Jul</OPTION><OPTION VALUE='8'>Aug</OPTION><OPTION VALUE='9'>Sep</OPTION><OPTION VALUE='10'>Oct</OPTION><OPTION VALUE='11'>Nov</OPTION><OPTION VALUE='12'>Dec</OPTION></SELECT></td><td><select name='start_day' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'><option value='1'>01</option><option value='2'>02</option><option value='3'>03</option><option value='4'>04</option><option value='5'>05</option><option value='6'>06</option><option value='7'>07</option><option value='8'>08</option><option value='9'>09</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option></select></td><td><SELECT NAME='start_year' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'><OPTION VALUE='2010'>2010</OPTION><OPTION VALUE='2011'>2011</OPTION></SELECT></td><td><font size='1'><em>to</em></font></td><td><SELECT NAME='end_month' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'><OPTION VALUE='1'>Jan</OPTION><OPTION VALUE='2'>Feb</OPTION><OPTION VALUE='3'>Mar</OPTION><OPTION VALUE='4'>Apr</OPTION><OPTION VALUE='5'>May</OPTION><OPTION VALUE='6'>Jun</OPTION><OPTION VALUE='7'>Jul</OPTION><OPTION VALUE='8'>Aug</OPTION><OPTION VALUE='9'>Sep</OPTION><OPTION VALUE='10'>Oct</OPTION><OPTION VALUE='11'>Nov</OPTION><OPTION VALUE='12'>Dec</OPTION></SELECT></td><td><select name='end_day' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'><option value='1'>01</option><option value='2'>02</option><option value='3'>03</option><option value='4'>04</option><option value='5'>05</option><option value='6'>06</option><option value='7'>07</option><option value='8'>08</option><option value='9'>09</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option></select></td><td><SELECT NAME='end_year' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'><OPTION VALUE='2010'>2010</OPTION><OPTION VALUE='2011'>2011</OPTION></SELECT></td></tr></table>";
				}
				else
				{
					document.getElementById("day").innerHTML= "";
				}
			}

</script>
<script type="text/javascript" src="js/tooltip.js"></script>
<script type='text/javascript' language='JavaScript' src='audio_player/audio-player.js'></script>
<style type="text/css">
<!--
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

                          <form action="" method="post" name="formtable">
							<table width="0%"  border="0" cellspacing="3" cellpadding="3">
								<tr>
									<td></td>
									<td>
									<div id="loading_div"></div>									
									</td>
								</tr>
                              <tr>
								<td><font color="#000000">Method</font></td>							  
                                <td colspan="2">
                                  <select size="1" id="method_id" onChange="javascript: validate_client_sub(this.value); " name="method" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
									<option value=''>Please Select</option>
									<option value='PER CLIENT'>Per Client</option>
									<option value='PER STAFF'>Per Staff</option>
									<option value='PER COUNTRY CITY'>Per Country/City</option>
									<option value='ALL'>All</option>
                                  </select>
								</td>
							  </tr>			
                              <tr>
								<td><font color="#000000">Country/City</font></td>							  
                                <td colspan="2">
                                  <select size="1" disabled name="country" id="country_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
									<?php
														$is_executed = 0;
														$queryAllTimezone = "SELECT * FROM timezone_lookup";
														$tz_result = $db->fetchAll($queryAllTimezone);
														foreach($tz_result as $tz_result)
														{
															switch($tz_result['timezone'])
															{
																case "PST8PDT":
																	$admin_timezone_display = "America/San Francisco";
																	break;
																case "NZ":
																	$admin_timezone_display = "New Zealand/Wellington";
																	break;
																case "NZ-CHAT":
																	$admin_timezone_display = "New Zealand/Chatham_Islands";
																	break;
																default:
																	$admin_timezone_display = $tz_result['timezone'];
																	break;
															}			
															echo "<OPTION VALUE='".$tz_result['timezone']."'>".$admin_timezone_display."</OPTION>";
														}
														if($is_executed == 0)
														{
															echo "<OPTION VALUE='' SELECTED></OPTION>";
														}									
									?>
                                  </select>
								</td>
							  </tr>							  					
                              <tr>
								<td><font color="#000000">Client</font></td>							  
                                <td colspan="2">
                                  <select size="1" disabled name="client_id" id="c_id" onChange="javascript: check_client_settings(this.value); " style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                    						<?php
																$query = "SELECT id, fname, lname FROM leads WHERE status='CLIENT'";
																$r_e = mysqli_query($link2, $query);
																$is_true = 0;
																echo "<option value=''></option>";
																while ($row = mysqli_fetch_assoc($r_e)) 
																{
																	echo "<option value='".$row["id"]."'>".$row["fname"]." ".$row["lname"]."</option>";
																}
															?>																	
                                  </select>
								</td>
							  </tr>							
                              <tr>
								<td><font color="#000000">Subcontractor</font></td>							  
                                <td colspan="2">
									<div id="subcon_div">
										<select size="1" disabled name="subcon_id" id="s_id" style=\'color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;\'>									
											<option></option>
										</select>
									</div>
								</td>
							  </tr>
                              <tr>
								<td><font color="#000000">Date&nbsp;to&nbsp;Execute</font></td>							  
                                <td width="0%">
										  <select size="1" name="date_to_execute" onChange="javascript: validate_day_to_execute(this.value); " style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
											<option value="today">today</option>
											<option value="nextday">next day</option>
											<option value="curweek">current week</option>
											<option value="curmonth">current month</option>
											<option value="nextmonth">next month</option>
											<option value="next7days">next 7 days</option>
											<option value="everymonth">every month</option>
											<option value="alltime">all time</option>
											<option value="moreoptions">more options</option>
										  </select>
								</td>
								<td width="100%">
										  <div id="day">
										  </div>
								</td>
							  </tr>
							  <tr><td colspan="3">&nbsp;</td></tr>		
							  <tr><td colspan="3"><font color="#000000">Notes</font></td></tr>		
                              <tr>
                                <td colspan="3">
									<textarea id="contents" name="note" cols="30" rows="5" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></textarea>
									<script language="javascript1.2">
									  generate_wysiwyg('contents');
									</script>
								</td>
							  </tr>									  
							  <tr>
								<td colspan="3"><input type="submit" value="Create Note" name="submit" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
							  </tr>	
                            </table>                            
                          </form>

</body>
</html>



