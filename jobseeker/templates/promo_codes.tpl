<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Your Promo Codes - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>

		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/promo_codes.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<p>
							Help us share the word about remotestaff.com.ph and the benefits of working remotely by creating links that can be shared anywhere in the web. When someone registers via clicking on the link you shared and was successfully hired, we offer 500 Pesos incentive for back office admin hires and 1000 Pesos incentive to IT Professional hires (Optional).
						</p>
						<form class="well form-horizontal" method="POST" id="promocode-form">
							<div class="alert alert-success" style="display:none;">
								<strong>Well done!</strong> You have successfully added a link.
							</div>
							{$form->userid->renderViewHelper()}
							<div class="control-group">
								<label class="control-label">Link</label>
								<div class="controls">
									http://remotestaff.com.ph/ {$form->promocode->renderViewHelper()}

								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<button id="save_add_more_promocodes" class="btn btn-primary">
										Save and add more links
									</button>

								</div>
							</div>

						</form>
					</div>
					<ul class="nav nav-tabs" id="myTab">
						<li class="active">
							<a href="#promocode_tab">Links</a>
						</li>
						<li>
							<a href="#registered_jobseeker">Registered Jobseekers</a>
						</li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="promocode_tab">
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>Link</th>
										<th>Number of Hits</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									{foreach from=$promocodes item=promocode}
									<tr>
										<td>{$promocode.i}</td>
										<td><a href="http://remotestaff.com.ph/{$promocode.promocode}" target="_blank">http://remotestaff.com.ph/{$promocode.promocode}</a></td>
										<td>{$promocode.count}</td>
										<td><a href="#" class="btn btn-mini edit_promocode" data-id="{$promocode.id}">Edit</a>&nbsp;<a href="/portal/jobseeker/delete_promo_code.php?id={$promocode.id}"  data-id="{$promocode.id}" class="delete_promo_code btn btn-mini btn-danger">Delete</a></td>
									</tr>
									{/foreach}
								</tbody>

							</table>
						</div>
						<div class="tab-pane" id="registered_jobseeker">
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>User ID</th>
										<th>Name</th>
										<th>Link Used for Registration</th>
										<th>Date Registered</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									{foreach from=$referrals item=referral name=referral_list}
										<tr>
											<td>{$smarty.foreach.referral_list.iteration}</td>
											<td>{$referral.jobseeker_id}</td>
											<td>{$referral.referee}</td>
											<td><a href="http://remotestaff.com.ph/{$referral.promotional_code}" target="_blank">http://remotestaff.com.ph/{$referral.promotional_code}</a></td>
											<td>{$referral.date_registered}</td>
											<td>{$referral.status}</td>
										</tr>
									{/foreach}
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>

			{include file="footer.tpl"}
		</div>

		<!-- Update Promo Code Modal -->
		<div id="updatePromoCode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
				<h3 id="updatePromoCodeLabel">Update Promo Code</h3>
			</div>
			<div class="modal-body">
				<form method="POST" class="form-horizontal" id="update_promocode_form">
					<input type="hidden" name="id" id="update_id">
					<input type="hidden" name="userid" id="update_userid">

					<div class="control-group">
						<label class="control-label" for="update_promocode">Promo Code</label>
						<div class="controls">
							<input type="text" name="promocode" id="update_promocode" placeholder="Promo Code">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">
					Close
				</button>
				<button class="btn btn-primary" id="update_promocode_save">
					Save Changes
				</button>
			</div>
		</div>
	</body>
</html>