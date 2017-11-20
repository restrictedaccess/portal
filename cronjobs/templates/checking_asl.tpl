<div style="text-align:center;margin:0">
	<table border="0" background="{$url}/portal/jobseeker/images/90_days_bg.png" height="818" width="800" style="margin:auto;text-align:left;color:#FFFFFF;">
		<tr>
			<td valign="top">
				<div style="padding-left:151px;padding-top:302px;padding-right:18px">
					<p style="margin-left:84px;margin-bottom:21px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;margin-top:0">Hi {$first_name}, </p>
					<p style="margin-left:84px;margin-top:0;margin-bottom:21px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;">You have been part of our Available Staff List for the past {$days} Days.</p>
                    {if $days eq '90'}
                        <p style="margin-left:84px;margin-top:0;margin-bottom:21px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;">This email is to confirm and follow up on your work availability. Please Click on the following Options Below. </p>
                        <p style="text-align: center">
                            <a href="{$url}/portal/jobseeker/still_available.php?u={$userid}&c={$mass_responder_code}" target="_blank"><img src="{$url}/portal/jobseeker/images/still_available.png"/></a>&nbsp;<a href="{$url}/portal/jobseeker/not_interested_anymore.php?u={$userid}&c={$mass_responder_code}" target="_blank"><img src="{$url}/portal/jobseeker/images/not_available.png"/></a>
                        </p>
                       <p style="margin-left:84px;margin-top:0;margin-bottom:21px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;">We will assume you are no longer available. Please be informed that your account will be on Inactive status.</p>
                    {else}
                        <p style="margin-left:84px;margin-top:0;margin-bottom:21px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;">This email is to confirm and follow up on your work availability. Please Click on the following Options Below. </p>
                        <p style="text-align: center">
                            <a href="{$url}/portal/jobseeker/still_available.php?u={$userid}&c={$mass_responder_code}" target="_blank"><img src="{$url}/portal/jobseeker/images/still_available.png"/></a>&nbsp;<a href="{$url}/portal/jobseeker/not_interested_anymore.php?u={$userid}&c={$mass_responder_code}" target="_blank"><img src="{$url}/portal/jobseeker/images/not_available.png"/></a>
                        </p>
                    {/if}

					
					<p style="margin-left:84px;margin-top:0;margin-bottom:21px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;"><strong>Hope to Hear From you Soon!</strong></p>
					<p style="margin-left:84px;margin-top:0;margin-bottom:21px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;">Remote Staff Recruitment Team</p>
														
				</div>
				<div style="padding-left:103px;padding-top:68px;">
					<p style="margin:0;font-family:Arial, Helvetica, sans-serif;font-size:10pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;">
						<a href="http://remotestaff.com.ph" target="_blank" style="color:#ffffff;text-decoration: none">www.remotestaff.com.ph</a><br/>
						<a href="http://www.facebook.com/RemoteStaffPhilippines" target="_blank" style="color:#ffffff;text-decoration: none">www.facebook.com/RemoteStaffPhilippines</a><br/>
						<a href="mailto:recruitment@remotestaff.com.ph" target="_blank" style="color:#ffffff;text-decoration: none">recruitment@remotestaff.com.ph</a><br/>
						
					</p>
				</div>					
			</td>
		</tr>
	</table>
	
</div>
