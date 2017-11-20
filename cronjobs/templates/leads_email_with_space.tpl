{*  
   2011-02-04 Normaneil Macutay <normanm@remotestaff.com.au>
    -   email template for the leads email with trailing spaces
*}

<h3>LEADS WITH EMAIL LEADING and TRAILING SPACES</h3>
TOTAL NO. OF LEADS EMAIL WITH LEADING / TRAILING SPACE : ({$ctr})<br />


<table style="font-family:Verdana; font-size:12px;" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
    <tr style="font-size:14px;color:#0000AA;">
        <td><b>ID:</b></td><td><b>LEAD FULLNAME:</b></td><td><b>EMAIL:</b></td><td>&nbsp;</td>
    </tr>
{foreach from=$leads item=lead name=lead}
    <tr bgcolor="{cycle values="#FFFFCC,#FFFFEE"}">
        <td>{$lead.id}</td>
        <td>{$lead.fname} {$lead.lname}</td>
        <td>{$lead.email}</td>
        <td>{if $lead.resolve}{$lead.resolve}{/if}</td>
        
    </tr>
{/foreach}
</table>