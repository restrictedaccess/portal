<div id="formbox">
<h1 class="formtitle" style="padding-top:3px; font-size:14px; font-weight:bold">Got an Inquiry about Remote Staff,<br /> Ask your Questions here</h1>
<p>Name:<br /><input name="fullname" id="fullname" type="text" class="tfields" /></p>
<p>Email Address:<br /><input name="email_address" id="email_address" type="text" /></p>
<p>Mobile Number:<br /><input name="mobile" id="mobile" type="text" /></p>

<p>Ask a Question<br /><textarea name="question" id="question"></textarea></p>
<p align="center">
<span style="text-align:center;color:#55707e;font-size:11px;">For validation, type the numbers you see</span> <br />
<?php  $rv2 = $passGen->password(0, 1); ?>
<input type="hidden" value="<?php  echo $rv2 ?>" name="rv2" id="rv2">
<?php  echo $passGen->images('./font', 'gif', 'f_', '20', '20'); ?>	  
<input type="text" value="" name="pass3" id="pass3"  style="width:80px;" maxlength="5">
</p>
<div id="send_result" style="text-align:center; font-weight:bold;"></div>
<p id="send_btn" style="text-align:center"><img src="images/btn-submit.png" style="cursor:pointer;" onclick="SendInquiry()"  /></p>
</div>