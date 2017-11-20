<div class="comment_div">
<div style=" background:#CA0000; color:#FFFFFF; font-weight:bold; padding:3px;">Comments / Note</div>
<table width='100%'>
<tr><td valign="top" colspan='2'>
<div style="height:300px; overflow-y:scroll; overflow-x:hidden; border:#fff solid 1px;">
<table class='mess_box' width='100%'>
{$comments_result}
</table>
</div>
</td></tr>
<tr><td colspan='2'>
<b>Add Comment / Note</b><br />
<textarea name="message2" id="message2"  style="width:590px; height:100px;" ></textarea><br />
<input type="button" value="Add & Save" class="lsb" onclick="AddComment2({$id})" /> <input type="button" class="lsb" value="close" onclick="toggle('comment_div2')" />
</td></tr>
</table>
</div>