<style type='text/css'>
.test {padding:12px;}
label.block{display:block;font-weight:bold;margin-right:12%;text-align:right;}[dir=rtl] .test label.block{text-align:left;}
label.block select,
.test label.block input.edit{width:50%;}
.test label span{vertical-align:middle;padding: 8px 13px 8px 8px;}
.test fieldset{width:400px;text-align:center;border:1px solid #ccc;padding-top:1em;margin:auto;}
.test input.edit,.test select.edit{vertical-align:middle;}.test select.edit{padding:0.1em 0;}.test input.button,
.test button.button{vertical-align:middle;}
.button {
    font: bold 12px Arial;
    text-decoration: none;
    background-color: #006DCC;
    color: #fff;
    padding: 4px 6px;
    border-top: 2px solid #0088CC;
    border-right: 2px solid #0044CC;
    border-bottom: 2px solid #0044CC;
    border-left: 1px solid #0088CC;
	cursor:pointer;
   }
</style>

<div id="fb-root"></div>
<div class="main-container" style="width:85%">
<p class="lastNode">Log in, Take a Test and hear from us in 2 business days!</p><br/>
<p>You are currently not logged in! Enter your authentication credentials below to log in.</p>
	<div class="centeralign">
		
			<div class="test">
			<input type="hidden" name="logintype" value="jobseeker" />
			<form id="session" method="post" action="?/userlogin" target="ajaxframe" accept-charset="utf-8">
			<fieldset ><legend>Login using your Remotestaff account</legend>
			<label class="block" for="focus__this"><span>Email Address</span><input type="text" id="focus__this" name="email" class="inputbox" style="width:170px" /></label><br />
			<label class="block"><span>Password</span>&nbsp;<input type="password" name="password" class="inputbox" style="width:170px"/></label><br />
			 
			<input type="submit" value="Login" class="inputbtn" />
			<div class="error">&nbsp;</div>
			<!--<div class='smallbox_header'>Forgotten your password? Get a new one:</small> <a href="/dokuwiki/doku.php?id=sidebar:subcon&amp;do=resendpwd"  rel="nofollow" title="Set new password">Set new password</a></div>-->
			</fieldset>
			</form>
			
			<p>&nbsp;</p>
			
			<fieldset ><legend>Facebook Login</legend>
			<button class="button" id="fb-login">Login using your Facebook account</button>
			</fieldset>
			<p>&nbsp;</p>
			<p>You don't have an account yet? <a href="http://www.remotestaff.com.ph/register/" class="action register" rel="nofollow" title="Register">Register Now!</a></p>
			
			</div>
			
			
		

	</div>
<script type="text/javascript">
(function(){
	document.getElementById('fb-login').onclick = function() {
		window.location.href='/portal/skills_test/?/fb_login';
		return false;
	};
}());

function loginResult(msg) {
	if(msg) jQuery('div.error').text(msg);
	else location.href = '/portal/skills_test/';
}
</script>
<div id="footer_divider"></div>
</div>