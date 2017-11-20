<!--
<ul class="nav nav-tabs">
  <li class="active"><a href="#recruiters-table" data-toggle="tab">Recruiters</a></li>
</ul> 

 <div class="tab-content">
  <div class="tab-pane active" id="recruiters-table"> -->
  	<table class="table table-striped table-bordered">
		<caption>{$caption}</caption>
		<thead>
			<tr>
				<th>
					Recruiter
				</th>
				<th>
					Number of<br/> Candidate
				</th>
				<th>
					Email Sent
				</th>
				<th>
					Initial Call
				</th>
				<th>
					Notes
				</th>
				<th>
					Evaluation<br/>Comments
				</th>
				
				<th>
					Face to Face<br/> Interview
				</th>
				<th>
					Number of<br/> Opened Resume
				</th>
				<th>
					Number of resume<br/> added to the system 
				</th>
				<th>SMS Sent</th>
				<th>Total</th>
			</tr>
			
		</thead>
		<tbody>
			
			{foreach from=$recruiters item=recruiter}
				<tr>
					<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
					<td id="number_of_candidates_{$recruiter.admin_id}">0</td>
					<td id="email_sent_{$recruiter.admin_id}">0</td>
					<td id="initial_call_{$recruiter.admin_id}">0</td>
					<td id="evaluated_{$recruiter.admin_id}">0</td>
					<td id="evaluation_comments_{$recruiter.admin_id}">0</td>
					
					<td id="face_to_face_interview_{$recruiter.admin_id}">0</td>
					<td id="number_of_opened_resume_{$recruiter.admin_id}">0</td>
					<td id="number_of_resume_added_to_the_system_{$recruiter.admin_id}">0</td>
					<td id="sms_sent_{$recruiter.admin_id}">0</td>
					<td id="total_{$recruiter.admin_id}">0</td>
					
				</tr>
			{/foreach}
			
		</tbody>
	</table>	
  	
   <!--</div>
  <div class="tab-pane" id="recsupport-table">
  	<table class="table table-striped table-bordered">
		<caption>{$caption}</caption>
		<thead>
			<tr>
				<th>
					Recruiter
				</th>
				<th>
					Number of<br/> Candidate
				</th>
				<th>
					Email Sent
				</th>
				<th>
					Initial Call
				</th>
				<th>
					Notes
				</th>
				<th>
					Evaluation<br/>Comments
				</th>
				
				<th>
					Face to Face<br/> Interview
				</th>
				<th>
					Number of<br/> Opened Resume
				</th>
				<th>
					Number of resume<br/> added to the system 
				</th>
				<th>SMS Sent</th>
				<th>Total</th>
			</tr>
			
		</thead>
		<tbody>
			
			{foreach from=$recruitment_support item=recruiter}
				<tr>
					<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
					<td id="number_of_candidates_{$recruiter.admin_id}">0</td>
					<td id="email_sent_{$recruiter.admin_id}">0</td>
					<td id="initial_call_{$recruiter.admin_id}">0</td>
					<td id="evaluated_{$recruiter.admin_id}">0</td>
					<td id="evaluation_comments_{$recruiter.admin_id}">0</td>
					
					<td id="face_to_face_interview_{$recruiter.admin_id}">0</td>
					<td id="number_of_opened_resume_{$recruiter.admin_id}">0</td>
					<td id="number_of_resume_added_to_the_system_{$recruiter.admin_id}">0</td>
					<td id="sms_sent_{$recruiter.admin_id}">0</td>
					<td id="total_{$recruiter.admin_id}">0</td>
					
				</tr>
			{/foreach}
			<tr>
				<td></td>
				<td id="total_rec_number_of_candidates">0</td>
				<td id="total_rec_email_sent">0</td>
				<td id="total_rec_initial_call">0</td>
				<td id="total_rec_evaluated">0</td>
				<td id="total_rec_evaluation_comments">0</td>
				
				<td id="total_rec_face_to_face_interview">0</td>
				<td id="total_rec_number_of_opened_resume">0</td>
				<td id="total_rec_number_of_resume_added_to_the_system">0</td>
				<td id="total_rec_sms_sent">0</td>
				<td id="total_rec_total">0</td>
					
			</tr>
		</tbody>
	</table>	
  	
  	
  </div> 
</div> -->




