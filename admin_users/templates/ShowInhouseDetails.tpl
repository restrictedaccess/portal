{if $personal.image}
	<img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=60&id={$personal.userid}' border='0' align='texttop'  />
{else}
	<img src='./images/Client.png' border='0' align='texttop' style="width:50px;"  />
{/if}
<span id="personal" fname="{$personal.fname}" lname="{$personal.lname}" userid="{$personal.userid}"></span>