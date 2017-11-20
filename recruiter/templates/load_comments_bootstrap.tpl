<div>
	<div class="notes_list {if $hm}col-xs-6{else}col-xs-12{/if}">
		<ul class="list-group">
			{foreach from=$comments item=comment}
				<li class="list-group-item">
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
	<div class="col-xs-6">
		<form class="form-horizontal" role="form" id="add_new_comment">
		  <div class="form-group">
		    <label for="inputSubject" class="col-sm-2 control-label">Subject</label>
		    <div class="col-sm-10">
		      <input type="text" name="subject" class="form-control" id="inputSubject" placeholder="Subject">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">Note</label>
		    <div class="col-sm-10">
		    	<textarea name="comment" rows="10" class="form-control" placeholder="Note"></textarea>
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-default">Add Notes</button>
		    </div>
		  </div>
		</form>
	</div>
	{/if}
</div>
