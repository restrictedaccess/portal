<tr bgcolor="#ffffff">



<td class="sorted item" >
{$counter}
{if $show_checkbox eq True }
<input type='checkbox' onClick='check_val()' name='users' value='{$lead.id}' >
{else}
<input type='checkbox' disabled="disabled" >
{/if}
<div align="center">
{if $lead.mark_lead_for eq 'unmark'}
<span id="mark_link_{$lead.id}" class="mark_unmark_link" onclick="mark_unmark_lead({$lead.id})" mode='mark' leads_name="#{$lead.id} {$lead.fname|capitalize}  {$lead.lname|capitalize}">Add Pin</span>
{else}
<span id="mark_link_{$lead.id}" class="mark_unmark_link" onclick="mark_unmark_lead({$lead.id})" mode='unmark' leads_name="#{$lead.id} {$lead.fname|capitalize}  {$lead.lname|capitalize}">Remove Pin</span>
{ /if }
</div>
{if $lead.marked eq 'yes'} <img src="./media/images/important_icon2.gif" title="Marked" />{ /if }
<!--{if $lead.custom_recruitment_order eq 'yes'} <img src="./media/images/custom-flag.png" title="Confirmed Custom Recruitment Order" />{/if}-->
{if $lead.ask_question eq 'yes'} <img src="./media/images/question-flag.png" title="Ask A Question" />{/if}
</td>

<td class="ids">
{$lead.id}
</td>

<td class="sorted name" style="padding-left:5px;" ><a href="../leads_information.php?id={$lead.id}&lead_status={$lead.status}">{$lead.fname|capitalize}  {$lead.lname|capitalize} </a>
</td>

<td class="email" style="padding-left:3px;"><span style="color:#006600;">{$lead.email}</span><br />
{if $lead.tracking_no}{$lead.tracking_no}<br />{/if}
{if $lead.officenumber}Office No. {$lead.officenumber}<br />{/if}
{if $lead.mobile}Mobile {$lead.mobile}{/if}
</td>

<td class="sorted date_updated" >{if $lead.last_updated_date}{$lead.last_updated_date|date_format:"%Y-%m-%d"}{/if}</td>

<td class="sorted timestamp">
<span {if $date_today eq $lead.timestamp|date_format:"%Y-%m-%d"} style="font-weight:bold" {/if}>{$lead.timestamp|date_format:"%Y-%m-%d"}</span>
</td>


<td class="actions">
<div class="identical">{$identical_str}</div>
{if $star}{$star}<br />{/if}
{$lead.status}<br />
<div align="center">{$registered_domain}</div>
<div>{$leads_order_str}</div>
<!--
<div>
{if $lead.custom_recruitment_order eq 'yes'} <p style='font-weight:bold; color: red; clear:both; text-align:center;'>Job Specification Form filled up</p>{/if}
</div>
-->
<div class="pin">
{ if $lead.mark_lead_for eq 'Replacement Requests'}
<img src="./images/pin_red.png" title="{$lead.mark_lead_for}" align="texttop" />
<span>{$lead.mark_lead_for}</span>
{ /if }

{ if $lead.mark_lead_for eq 'CSR Concerns'}
<img src="./images/pin_yellow.png" title="{$lead.mark_lead_for}" align="texttop" />
<span>{$lead.mark_lead_for}</span>
{ /if }

{ if $lead.mark_lead_for eq 'Sales Follow Up'}
<img src="./images/pin_blue.png" title="{$lead.mark_lead_for}" align="texttop" />
<span>{$lead.mark_lead_for}</span>
{ /if }

</div>
</td>
<td class="others">
<div align='right' ><a href="javascript: toggle('note_form_{$lead.id}');">Temporary Note</a></div>
<div class="others_div">
<div id="note_form_{$lead.id}" class='add_notes_form'>
<p><textarea style='width:270px; height:100px;' name='remarks' id='remarks_{$lead.id}'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick="javascript:saveNote({$lead.id});">
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick="javascript:toggle('note_form_{$lead.id}');">
</div>
<div id='{$lead.id}_latest_notes'>{$remark}</div>
<div>{$leads_active_staff}</div>
<div class='steps_list_section'>{$steps_taken}</div>
</div>
</td>
</tr>