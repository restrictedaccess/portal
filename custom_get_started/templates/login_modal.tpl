<div id="login_modal" class="modal fade" role="dialog" aria-labelledby="loginModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="loginModal">Login</h4>
      </div> 
      <div class="modal-body">
		<form id="login_form_modal" class="form-horizontal">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
				  <div class="form-group">
					<label for="leads_email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-9">
					 <input type="text" name="leads_email" id="leads_email" class="form-control" placeholder="Email">
					</div>
				  </div>
				  <div class="form-group">
					<label for="leads_password" class="col-sm-3 control-label">Password</label>
					<div class="col-sm-9">
					  <input type="password" class="form-control" name="leads_password" id="leads_password" placeholder="Password">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button id="login_form_modal_btn" type="submit" class="btn btn-primary">Sign in <i class="glyphicon glyphicon-log-in"></i></button>
					</div>
				  </div>
				</div>
			</div>
		</form>
      </div>
    </div>
  </div>
</div>
