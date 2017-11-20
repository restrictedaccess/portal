<div id="addSkillListModal" class="modal fade" role="dialog" aria-labelledby="addSkillListModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="addSkillListHeader" class="modal-title">Skills Available on <span class="selected_job_title"></span></h4>
      </div>
      <div class="modal-body">
		<input type="hidden" id="required_skill_sub_category_id" name="required_skill_sub_category_id" value="" />
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="search_skill">Search Skill:</label>
					<input type="input" id="search_skill" name="search_skill" class="form-control">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div style="overflow-y: auto; max-height: 256px; height:auto; margin: 0px 0px 20px;"> 
					<form id="skill-select-form">
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
				<form id="add-new-skill">
					<div class="well" style="margin:0px;">
						<input type="hidden" name="type" id="updateTypeSkill" value="skill"/>
						<input type="hidden" class="sub_category_id" name="sub_category_id" id="updateSubCategoryIdSkill"/>            
						<div class="form-group">
							<label for="updateNameSkill">Name of skill:</label>
							<div class="input-group">
								<input name="value" type="text" id="updateNameSkill" class="form-control" placeholder="Not on the list? Add it."/>
								<span class="input-group-btn">
									<button class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Add Skill </button>
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
		<button class="btn btn-primary" id="select-skill" data-gs_job_titles_details_id=""><i class="glyphicon glyphicon-ok"></i> Select Skills</button>
	  </div>
	  
    </div>
  </div>
</div>
