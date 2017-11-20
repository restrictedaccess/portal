{*
2014-04-02 Normaneil E. Macutay    
*}
<div style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">

    <div align='justify' style='padding:15px;margin-top:10px;' >{$mess}</div>
    <div align='justify' style='padding:15px;margin-top:10px;' >{$text}</div>

<div style="margin-top:30px;">
{if $admin}
	{if $admin.signature_notes}<div style="color:#999; font-style:italic; margin-bottom:23px;">{$admin.signature_notes}</div>{/if}
{/if}
<a href="http://remotestaff.com.au/{$agent_code}" >
  <img style="height:43px;" border="0" src="https://remotestaff.com.au/portal/site_media/client_portal/images/rs_logo.png" alt="Remote Staff Home">
</a><br />
<strong>The Home of Remote Working</strong><br />
<p>
{if $agent} {$agent.fname} {$agent.lname} {/if}
{if $admin} {$admin.admin_fname} {$admin.admin_lname} {/if}
<br />

{if $agent}
	<strong><em>{$title}</em></strong><br />
{else}
	{if $subcon}
    	<strong><em>{$subcon.job_designation}</em></strong><br />
    {else}
        <strong><em>Admin</em></strong><br />
    {/if}   
{/if}


{if $agent}
	<strong>Contact No.</strong> {$agent.agent_contact} | <strong>Email:</strong> <a href="mailto:{$agent.email}" target="_blank">{$agent.email}</a>
{/if}
{if $admin}
    <strong>Contact No.</strong> {$admin.signature_contact_nos} | <strong>Skype:</strong> {if $admin.skype_id}{$admin.skype_id}{else}-{/if}| <strong>Email:</strong> <a href="mailto:{$admin.admin_email}" target="_blank">{$admin.admin_email}</a> <br />
    <strong>For general queries:</strong> <a href="mailto:clientsupport@remotestaff.com.au" target="_blank">clientsupport@remotestaff.com.au</a>    
{/if}

<br /><br />
<a href="http://www.facebook.com/RemoteStaff"><img border="0" src="https://remotestaff.com.au/portal/images/email_sig/facebook_thumbnail.jpg" alt="" /></a> <a href="http://www.linkedin.com/company/remotestaff-limited"><img border="0" src="https://remotestaff.com.au/portal/images/email_sig/linkedin_thumbnail.jpg" alt="" /></a> <a href="https://twitter.com/remote_staff"><img border="0" src="https://remotestaff.com.au/portal/images/email_sig/twitter_thumbnail.jpg" alt="" /></a> <a href="https://plus.google.com/+RemotestaffAus/"><img border="0" src="https://remotestaff.com.au/portal/images/email_sig/googleplus_thumbnail.jpg" alt="" /></a> <a href="http://feeds.feedburner.com/RemoteStaffAU"><img border="0" src="https://remotestaff.com.au/portal/images/email_sig/rss_thumbnail.jpg" alt="" /></a>   
</p>

</div>
</div>


