{*
2012-02-20 Normaneil E. Macutay    
*}
<div style='font-family: "lucida grande",tahoma,verdana,arial,sans-serif; font-size: 11px;'>
<div style="margin-bottom:20px;"><img src="https://remotestaff.com.au/images/remote-staff-logo2.jpg"></div>

<p style="text-transform:capitalize;">Dear {$lead.fname} {$lead.lname},</p>


<p>Please follow the link below to check the quote for </p>

<ol>
{foreach from=$quote_details item=s name=s}
<li style="padding:5px;">
<span style="text-transform:capitalize;">{$s.work_position}</span> working <em>{$s.work_status}</em>
</li>
{/foreach}
</ol>

<p><a href="http://{$site}/portal/pdf_report/service_agreement/service_agreement_online_form.php?ran={$ran}">http://{$site}/portal/pdf_report/service_agreement/service_agreement_online_form.php?ran={$ran}</a></p>

<p>Please read and accept full Remote Staff Service agreement. </p>

<p>Should you have any questions regarding the Pro Forma Request for Service Form and the Remote Staff Service Agreement, please don’t hesitate to contact me. </p>

 
<p>&nbsp;</p>
{$signature_notes}
</div>