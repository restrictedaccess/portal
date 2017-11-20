<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Remotestaff Skills Test</title>

<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />


<link rel=stylesheet type=text/css href="/portal/ticketmgmt/css/tabs.css">
<link rel=stylesheet type=text/css href="/portal/css/global_styles.css">
<link rel=stylesheet type=text/css href="css/skilltest.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/portal/js/jquery.js"><\/script>')</script>
</head>
<body>
<iframe id='ajaxframe' name='ajaxframe' style='display:none;height:10px;' src='javascript:false;'></iframe>

<table cellpadding='0' cellspacing='0' border='0' width='100%'>
<tr><td valign="top">
<?php if(!$nologo):?>
<img src='/portal/images/remote-staff-logo2.jpg'/>
<?php endif;?>
</td>
</tr>

<tr bgcolor="#7a9512"><td style="width:23%;font:8pt verdana;height:20px;border-bottom:1px solid #7a9512;">
<div style='float:left;width:100%;color:#000;padding-top:2px;'>&#160;&#160;<b>RS - SKILLS TESTS</b></div></td>
<td style="width:77%;font:8pt verdana;height:20px;border-bottom:1px solid #7a9512;">
<div style='float:left;width:100%;font: 8pt verdana;'>
  <table width="100%" border='0'>
	<tr><td align="right" style="font: 8pt verdana;">
	<?php if(!$leads):?>
	<div style="font: 8pt verdana;color:#fff;"></div>
	<?php endif;?>
	</td></tr>
</table>
</div>
</td></tr>
<tr><td style='width:100%'>
<div style='float:left;width:99%;padding:7px;'>
	
	
	<form id='search_form' action='' method='post'>
		<input type='hidden' name='status' id='status' value=''/>		
	
		<div id='testbar' style="float:left;width:100%;border:1px solid #aaa;background:#ddd;">
			<?php
				if(!$report && empty($_SESSION['client_id'])):
			?>
	
			<div style='width:auto;margin-left:auto;margin-right:auto;'>
				<div class='nav main'>
					<ul>
						<?php if($start_test):?>
						<li<?php echo $class1;?>><a <?php echo $color1;?>href='#'>Start Assessment</a></li>
						<li><a href='/portal/skills_test/?/index'>Remote Staff Test</a></li>
						<?php else:?>
						<li<?php echo $class1;?>><a <?php echo $color1;?>href='/portal/skills_test/?/index'>Remote Staff Test</a></li>
						<li<?php echo $class2;?>><a <?php echo $color2;?>href='/portal/skills_test/?/whytaketest/'>Why take a test?</a></li>
						<li<?php echo $class4;?>><a <?php echo $color4;?>href='/portal/skills_test/?/testlist800plus'>800+ Tests Lists</a></li>
						<?php endif;?>
					</ul>
				</div>
				
				
			</div>
			<?php endif;?>
		<!--<div style='float:right;width:150px;right:10px;'>
			<input type='text' class='inputbox' id='keyword' size='5' name='keyword'/>&nbsp;
			<input type='submit' class='button' value="Search" name='submit' title="Filter data"/>
		</div>-->
			<span style='float:right;font-size:11px;line-height:24px;'><?php echo $emailaddr;?> &nbsp;</span>
		</div>
	</form>
	

</div>
</td></tr>
</table>