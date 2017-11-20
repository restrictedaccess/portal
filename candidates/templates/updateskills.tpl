<!DOCTYPE html>
<html>
	<head>
		<title>Remotestaff - Update Skills</title>

		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/updateskill.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>

		<link rel="stylesheet" type="text/css" href="/portal/candidates/css/index.css"/>
	</head>
	<body>

		<div class="container">
			<h2 class="jobseeker-header">Update Skills</h2>
			<p>Enter your top skills (e.g. Project Management, Cost Accounting, C++, Oracle8), years of experience and proficiency. Maximum 10 skills allowed. what should I enter?</p>
			<form class="well form-horizontal" method="POST" id="skill-form">
				<legend>Add Skill</legend>
				{$form->userid->renderViewHelper()}
				<div class="control-group">
					<label class="control-label">Skill</label>
					<div class="controls">
						{$form->skill->renderViewHelper()}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Years of Experience</label>
					<div class="controls">
						{$form->experience->renderViewHelper()}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Proficiency</label>
					<div class="controls">
						{$form->proficiency->renderViewHelper()}
					</div>
				</div>
				<button id="save_add_more_skill" class="btn btn-primary">
					Save and add more skill
				</button>
			
			</form>
			
			
			<h4>Applicant's Save Skill</h4>
			<table id="applicant_skill_list" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							Skill Name
						</th>
						<th>
							Years of Experience
						</th>
						<th>
							Proficiency
						</th>
						<th>
							&nbsp;
						</th>
					</tr>
				</thead>
				<tbody>
					{ foreach from=$skills item=skill name=skill_list}
						<tr>
							<td>
								{$smarty.foreach.skill_list.iteration}
							</td>
							<td>
								{$skill.skill}
							</td>
							<td>
								{ if $skill.experience eq 0.5 }
									Less than 6 months
								{ elseif $skill.experience eq 0.75}
									More than 6 months
								{ elseif $skill.experience eq 1}
									1 year
								{ elseif $skill.experience > 10}
									More than 10 years
								{ else }
									{$skill.experience} years
								{/if}
							</td>
							<td>
								{if $skill.proficiency eq 3}
									Advance
								{elseif $skill.proficiency eq 2}
									Intermediate
								{elseif $skill.proficiency eq 1}
									Beginner
								{/if}
								
							</td>
							
							<td>
								<a href="/portal/candidates/edit_skill.php?id={$skill.id}" class="edit_skill">Edit</a> | <a href="/portal/candidates/delete_skill.php?id={$skill.id}"  class="delete_skill">Delete</a>
							</td>
							
						</tr>
					{ /foreach }
				</tbody>
			</table>
			
		</div>


		

	</body>
</html>
