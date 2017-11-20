{*  
    2011-10-10 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   ticket 1004, italicized and made the footer messages smaller
    2011-09-19 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   added status
    2011-05-13 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   increased font size
    2011-02-23 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   removed rating column
    2010-12-30 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   attached the images on the email
    2010-12-21 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   Add rating
    2010-04-14 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   use the new email/cc field on tb_client_account_settings table
    2010-04-06  Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   Add footer
    -   Add note when staff has no login
    -   Fixed link for the support team
    2010-03-26  Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   Typo error
    2010-02-22  Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   resized logo
    2010-02-10  Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   modified notes, verbosely set the width of the notes column
    2010-02-08  Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   add notes at the beginning of header, change date time format
    2010-01-24  Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   added per country city settings
    2010-01-13  Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   template being used by time_recording/ActivityNotesMailer.php and cronjobs/activity_tracker_notes.php
    2010-01-12  Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   Moving notes at the bottom 
*}

<a href="http://www.remotestaff.com.au">
    <img src="cid:logo"  height="54" width="208" style="border-style: none;" />
</a>

<h3 style="font-family:Verdana;"> Daily Staff Activity Notes </h3>
<table style="font-family:Verdana; font-size:14px; width:600px;">
    <tr>
        <td>
            As a client of Remote Staff, the activity notes are a great way for you to be informed with staff work outputs, progress and priorities throughout the day. Please remind your staff to complete the activity notes in details you need when the activity note pops up on your staff screen every 20/30min.
        </td>
    </tr>
</table>
<br/>
<div style="font-family:Verdana;">Timezone reference is set to <b><i>{$client_timezone}</i></b>.</div>
<p/>
{section name=i loop=$subcontractors}
    <table style="font-family:Verdana; font-size:14px; width:600px;">
        <tr style="font-size:14px;color:#0000AA;">
            <td colspan="4" style="width:600px;"><b>Staff Name: <i>{$subcontractors[i].fname|ss} {$subcontractors[i].lname|ss}</i></b></td>
        </tr>
        <tr>
            <td colspan="4" style="width:600px;">

                {if count($subcontractors[i].time_records) eq 0}
                    <table style="font-family:Verdana; font-size:14px; background-color: #EEEEEE;">
                        <tr style="background-color:#FFFFCC;">
                            <td>
                                Your staff member, <b><i>{$subcontractors[i].fname|ss} {$subcontractors[i].lname|ss}</i></b>, is absent today.
                            </td>
                        </tr>
                        <tr style="background-color:#FFFFEE;">
                            <td>
                                If you haven't been informed by the <a href="http://www.remotestaff.com.au/portal/support_team_contact_details.php">support team</a> about this absence earlier, please email &nbsp; <a href="mailto:attendance@remotestaff.com.au"> attendance@remotestaff.com.au </a>
                            </td>
                        </tr>
                    </table>

                {else}
                    <table style="font-family:Verdana; font-size:14px; background: #888888;">
                        <tr style="font-weight:bold; background-color:#EEEEEE;">
                            <td>
                                Time In
                            </td>
                            <td>
                                Time Out
                            </td>
                            <td>
                                Start Lunch
                            </td>
                            <td>
                                Fin Lunch
                            </td>
                        </tr>
                        {section name=j loop=$subcontractors[i].time_records}
                            <tr style="background-color:{cycle values="#FFFFCC,#FFFFEE"};">
                                <td>
                                    {$subcontractors[i].time_records[j].time_in}
                                </td>
                                <td>
                                    {$subcontractors[i].time_records[j].time_out}
                                </td>
                                <td>
                                    {$subcontractors[i].time_records[j].lunch_start}
                                </td>
                                <td>
                                    {$subcontractors[i].time_records[j].lunch_fin}
                                </td>
                            </tr>
                        {/section}
                    </table>
                {/if}
            </td>
        </tr>
        {if count($subcontractors[i].activity_tracker_notes) neq 0}
            <tr style="font-weight:bold; background-color:#EEEEEE;"><td style="width:40px;">Date</td><td style="width:72px;">Time</td><td style="width:368px;">Activity Notes</td><td style="width:100px;">Status</td></tr>
        {/if}
        {section name=j loop=$subcontractors[i].activity_tracker_notes}
            <tr style="background-color:{cycle values="#CCFFCC,#EEFFEE"};">
                <td style="width:58px;">{$subcontractors[i].activity_tracker_notes[j].checked_in_date}</td>
                <td style="width:72px;">{$subcontractors[i].activity_tracker_notes[j].checked_in_time}</td>
                <td style="width:368px; text-indent: 1em;">- {$subcontractors[i].activity_tracker_notes[j].note|ss}</td>
                <td style="width:100px;">{$subcontractors[i].activity_tracker_notes[j].status|ss}</td>
            </tr>
        {/section}
        {section name=j loop=$subcontractors[i].admin_notes_per_staff}
            <tr style="background-color:#FFFFBB;"><td colspan="4">{$subcontractors[i].admin_notes_per_staff[j].note}</td></tr>
        {/section}
        <tr><td colspan="4" style="width:600px;"> <hr /> </td></tr>
    </table>
{/section}

{* notes from admin per staff or all goes here *}
{if count($admin_notes_all) gt 0}
<table style="font-family:Verdana; font-size:12px; width:600px;">
    {section name=i loop=$admin_notes_all}
        <tr style="background-color:#FFFFBB;"><td>{$admin_notes_all[i].note}</td></tr>
    {/section}
</table>
{/if}

{if count($admin_notes_per_client) gt 0}
<table style="font-family:Verdana; font-size:12px; width:600px;">
    {section name=i loop=$admin_notes_per_client}
        <tr style="background-color:#FFFFBB;"><td>{$admin_notes_per_client[i].note}</td></tr>
    {/section}
</table>
{/if}

{if count($admin_notes_per_country_city) gt 0}
<table style="font-family:Verdana; font-size:12px; width:600px;">
    {section name=i loop=$admin_notes_per_country_city}
        <tr style="backround-color:#FFFFBB;"><td>{$admin_notes_per_country_city[i].note}</td></tr>
    {/section}
</table>
{/if}

<table style="font-family:Verdana; font-size:12px; width:600px; font-style:italic;">
        <tr style="background-color:#FFFFEE;"><td>Should you want to view your staff member's screen captures side by side with their activity notes, please log in as a Client <a href="https://remotestaff.com.au/portal/">HERE</a>. Click on the Screen Shots, Timesheet and Activity Tracker Tab and then click on the Screen Shot Sub Tab.</td></tr>
</table>
<table style="font-family:Verdana; font-size:12px; width:600px; font-style:italic;">
        <tr style="background-color:#FFFFCC;"><td>For any questions, comments and suggestions, there's a lot of ways to contact us once logged in to your Client Portal:
            <ol>
                <li>You can text/voice chat with our Client support team via the Remote Staff Chat. Just click on the Chat link on the upper right hand corner of your Client portal.
                </li>
                <li>The direct phone numbers, email addresses and Skype IDs of our contact support team can be found on Support Team Contact Details tab.
                </li>
                <li>For questions regarding attendance and time sheet please email <a href="mailto:attendance@remotestaff.com.au">attendance@remotestaff.com.au</a>.
                </li>
            </ol></td></tr>
</table>
