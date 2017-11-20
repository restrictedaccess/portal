<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Update your Skill Details - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>
		
		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/updateskill.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Update Skills</h2>
						<p class="label label-info">Enter your top skills (e.g. Project Management, Cost Accounting, C++, Oracle8), years of experience and proficiency.</p>
						<form class="well form-horizontal" method="POST" id="skill-form">
							<div class="alert alert-success" style="display:none;">
								<strong>Well done!</strong> You have successfully added a skill.
							</div>
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
						<h4>My Skills</h4>
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
											<a href="/portal/jobseeker/edit_skill.php?id={$skill.id}" class="edit_skill">Edit</a> | <a href="/portal/jobseeker/delete_skill.php?id={$skill.id}"  class="delete_skill">Delete</a>
										</td>
										
									</tr>
								{ /foreach }
							</tbody>
						</table>
									
						
						
					</div>
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>