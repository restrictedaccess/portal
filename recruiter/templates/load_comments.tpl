<h3 style="color:#333;margin-bottom:5px">Notes on {$tracking_code}</h3>
<div class="notes_list" style="float: left;{if $hm}width:450px;{else}width:98%{/if}">
	<ul>
		{foreach from=$comments item=comment}
		<li style="border-bottom:1px dotted #312E27;{if $hm}width:431px;{else}width:100%;{/if}word-wrap:break-word">
			<strong>By: </strong>{$comment.admin_fname} {$comment.admin_lname}<br/>
			<strong>Date Created: </strong>{$comment.date_created}<br/>
			<strong>Subject:</strong>{$comment.subject}<br/>
			<strong>Note:</strong>
			<p style="margin-top:0">{$comment.comment}</p> 
		</li>
		{/foreach}
	</ul>
</div>
{if $hm}
<form class="add_new_comment" style="float: left;width:247px;">
	<fieldset style="border-style:dotted">
		<legend>Add New Note</legend>
		<input type="hidden" name="tracking_code" value="{$tracking_code}"/>
		<table border="0">
			<tr>
				<td>Subject: </td>
				<td><input type="text" name="subject" style="width:100%"/></td>
			</tr>
			
			<tr>
				<td>Note: </td>
				<td><textarea name="comment" style="width:247px;height:117px;"></textarea></td>
			</tr>
			
		</table>
		<button type="submit">
			Add
		</button>	
	</fieldset>
	
	
</form>

{/if}
