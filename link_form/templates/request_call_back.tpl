<!-- Modal -->
<div class="modal fade" id="modal-leads-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content callback callback-modal">

			<div class="custom_container">
				<div class="modal-body">

					<div class = "request-callback request-callback-modal">
						<button type="button" class="close rcb-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<div class = "new-ribbon new-ribbon-modal">
							<p class="new-ribbon-content new-ribbon-content-modal">
								REQUEST A CALL BACK
							</p>
						</div>

						<h3>We are eager to discuss your business needs, and answer any questions you may have </h3>

						<form class="form-request-call-back form-leads" method="post" name="leads-form">
							<input type="hidden" name="registered_in">
							<input type="hidden" name="section">
							<input type="hidden" name="registered_url">

							<input type="hidden" name="leads_country" id="leads_country" value="{$location.leads_country}" >
							<input type="hidden" name="leads_ip" id="leads_ip" value="{$location.leads_ip}" >
							<input type="hidden" name="registered_domain" id="registered_domain" value="{$location.location_id}" >
							<input type="hidden" name="location_id" id="location_id" value="{$location.location_id}" >
							<input type="hidden" name="tracking_no" id="tracking_no" value="{$tracking_no}" >
							 
							<div class="form-group rcb-form-group">
								<input type="text" class="form-control rcb-input rcb-input-modal" placeholder="*Name:" name="name" id="name" required="required"  />
							</div>
							
							<div class="form-group rcb-form-group">
								<input type="text" class="form-control rcb-input rcb-input-modal" placeholder="*Email:" name="email" id="email" required="required"  />
							</div>

							<div class="form-group rcb-form-group">
								<input type="text" class="form-control rcb-input rcb-input-modal" placeholder="*Phone:" name="mobile" id="mobile" required="required"  />
							</div>

							<div class="form-group rcb-form-group">
								<textarea class="form-control rcb-input rcb-input-modal" name="question" id="question" rows="2" placeholder="Comment:"></textarea>
							</div>

							<div class="form-group btn-verify">
								<div style="display: none;">
									<input type="text" name="honeypot" id="honeypot" />
								</div>

								<button type="submit" name="btn-save" class="btn btn-primary rcb-submit rcb-submit-modal cta_tracker_btn" id="request_a_callback_modal_portal_button">
									Submit
								</button>

								<p class="rcb-or rcb-or-modal">
									<span>Or</span>
								</p>

								<a href="{$url}/portal/link_form/job_specification_form.php" class="btn btn-info rcb-jobspec rcb-jobspec-modal cta_tracker_btn" id="recruitment_briefing_modal_portal_button" role="button">Complete A Recruitment Briefing Form</a>
							</div>
						</form>
					</div>

				</div>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- /Modal -->

<input type="hidden" id="url_link" value="{$url}">
