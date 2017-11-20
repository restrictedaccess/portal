{*  
    2011-02-23 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   removed rating column on activity tracker notes
    2011-01-17 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   copied from cronjob and modified
*}

{literal}
<style type="text/css"><!--
h3 {font-family:Verdana;}
.notes {text-indent: 1em;}
--></style>
{/literal}
{strip}
<a href="http://www.remotestaff.com.au">
<img src="cid:{$cid_logo}"  height="54" width="208" style="border-style: none;">
</a>

{*  test mode only *}
{if $email neq '' }
<pre>
email : {$email}
</pre>
{/if}

{if $cc neq '' }
<pre>
cc : {$cc}
</pre>
{/if}
{*  end of test mode *}

<h3> Daily Staff Activity Notes </h3>
<table width="600px" style="font-family:Verdana; font-size:12px;">
    <tr>
        <td>
            As a client of Remote Staff, the activity notes are a great way for you to be informed with staff work outputs, progress and priorities throughout the day. Please remind your staff to complete the activity notes in details you need when the activity note pops up on your staff screen every 20/30min.
        </td>
    </tr>
</table>
<p/>
{assign var='staff_name' value=''}
{section name=i loop=$notes}
    {assign var='fname' value=$notes[i].fname}
    {assign var='lname' value=$notes[i].lname}
    {assign var='userid' value=$notes[i].userid}
    {assign var='new_staff_name' value="$fname $lname"}
    {if $staff_name neq $new_staff_name}
        <table width="600px" style="font-family:Verdana; font-size:12px;">
            <tr style="font-size:14px;color:#0000AA;">
                <td colspan="4" width="600px"><b>Staff Name: <i>{$new_staff_name}</i></b></td>
            </tr>
        <tr bgcolor="#EEEEEE" style="font-weight:bold;"><td width="40px">Date</td><td width="68px">Time</td><td width="472px">Activity Notes</td></tr>
        {assign var='staff_name' value=$new_staff_name}
    {/if}
        <tr bgcolor="{cycle values="#CCFFCC,#EEFFEE"}">
            <td width="58px">{$notes[i].checked_in_date}</td>
            <td width="68px">{$notes[i].checked_in_time}</td>
            <td width="472px" class="notes">- {$notes[i].note|ss}</td>
        </tr>
        {assign var='fname' value=$notes[i.index_next].fname}
        {assign var='lname' value=$notes[i.index_next].lname}
        {assign var='next_staff_name' value="$fname $lname"}
        {if $staff_name neq $next_staff_name}
            {section name=j loop=$admin_notes_per_staff[$userid]}
                <tr bgcolor="#FFFFBB"><td colspan="4">{$admin_notes_per_staff[$userid][j].note}</td></tr>
            {/section}
            <tr><td colspan="4" width="600px"> <hr/> </td></tr>
        </table>
        {/if}
{/section}

{* notes from admin per staff or all goes here *}
{if count($admin_notes_all) gt 0}
<table width="600px" style="font-family:Verdana; font-size:12px;">
    {section name=i loop=$admin_notes_all}
        <tr bgcolor="#FFFFBB"><td>{$admin_notes_all[i].note}</td></tr>
    {/section}
</table>
{/if}

{if count($admin_notes_per_client) gt 0}
<table width="600px" style="font-family:Verdana; font-size:12px;">
    {section name=i loop=$admin_notes_per_client}
        <tr bgcolor="#FFFFBB"><td>{$admin_notes_per_client[i].note}</td></tr>
    {/section}
</table>
{/if}

{if count($admin_notes_per_country_city) gt 0}
<table width="600px" style="font-family:Verdana; font-size:12px;">
    {section name=i loop=$admin_notes_per_country_city}
        <tr bgcolor="#FFFFBB"><td>{$admin_notes_per_country_city[i].note}</td></tr>
    {/section}
</table>
{/if}

<table width="600px" style="font-family:Verdana; font-size:12px;">
        <tr bgcolor="#FFFFBB"><td>Should you want to view your staff member's screen captures please log in as a client <a href="https://remotestaff.com.au/portal/">HERE</a>.</td></tr>
</table>
<table width="600px" style="font-family:Verdana; font-size:12px;">
        <tr bgcolor="#FFFFBB"><td>Any questions regarding attendance and time sheet should be addressed to <a href="mailto:attendance@remotestaff.com.au">attendance@remotestaff.com.au</a>.</td></tr>
</table>
{/strip}
