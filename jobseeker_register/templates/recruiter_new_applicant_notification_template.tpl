<p> Dear Recruiters, </p>

<br>

<p> We have new candidate! </p>

<br>

<p> Candidate name: {$candidate_fullname} </p>

<br>

<p> Latest job title: {$latest_job_title} </p>

<br>

<p> Date register: {$date_register} </p>

{if $skills}

<br>

<p> Set of skills: </p>

<ul>

	{foreach from=$skills item=skill}
	
		<li> {$skill.skill} - {$skill.experience} - {$skill.proficiency} </li>
	
	{/foreach}

</ul>

{/if}

<br>

<p> Please see attachment for candidate's resume </p>

<br>

<p> Remotestaff System </p>
