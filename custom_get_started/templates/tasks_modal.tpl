<div id="addTaskListModal" class="modal fade" role="dialog" aria-labelledby="addTaskListModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="addTaskListHeader" class="modal-title">Tasks Available on <span class="selected_job_title"></span></h4>
      </div>
      <div class="modal-body">
		<input type="hidden" id="required_task_sub_category_id" name="required_task_sub_category_id" value="" />
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="search_task">Search Task:</label>
					<input type="input" id="search_task" name="search_task" class="form-control">
				</div>
			</div>
		</div>
		 
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div style="overflow-y: auto; max-height: 256px; height:auto; margin: 0px 0px 20px;"> 
					<form id="task-select-form">
						<table class="table table-bordered table-striped">
							<tbody>
								
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<form id="add-new-task">
					<div class="well" style="margin:0px;">
						<input type="hidden" name="type" id="updateTypeTask" value="task"/>
						<input type="hidden" class="sub_category_id" name="sub_category_id" id="updateSubCategoryIdTask"/>       
						<div class="form-group">
							<label for="updateNameSkill">Name of task:</label>
							<div class="input-group">
								<input name="value" type="text" id="updateNameTask" class="form-control" placeholder="Not on the list? Add it."/>
								<span class="input-group-btn">
									<button class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Add Task</button>
								</span>
							</div><!-- /input-group -->
						</div>
					</div>
				</form>
			</div>
		</div>
		
      </div>
      
	  <div class="modal-footer">
		<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="glyphicon glyphicon-remove"></i> Close</button>
		<button class="btn btn-primary" id="select-tasks"><i class="glyphicon glyphicon-ok"></i> Select Tasks</button>
	  </div>
	  
    </div>
  </div>
</div>
