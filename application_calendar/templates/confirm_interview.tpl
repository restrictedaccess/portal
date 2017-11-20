{if $client eq ""}
	<p style='font-style:italic'>Dear Interview Facilitator {$name}</p>
	<p></p>
	<p style='font-style:italic;text-indent:5em'>{$recipient} have read your email confirmation for the initial interview scheduled on {$schedule}. Please ensure that everything is in place before the interview. </p>
	<p></p>
	<p style='font-style:italic'>A friendly reminder from Remote Staff Systems.</p>
{else}
	<p style='font-style:italic'>Dear Interview Facilitator {$name}</p>
	<p></p>
	<p style='font-style:italic;text-indent:5em'>{$recipient} have read your email confirmation about the interview between {$client} and {$applicant} on {$schedule}. Please ensure that everything is in place before the interview. </p>
	<p></p>
	<p style='font-style:italic;text-indent:5em'>Please contact the other party if you haven't received any confirmation yet</p>
	<p></p>
	<p></p>
	<p style='font-style:italic'>A friendly reminder from Remote Staff Systems.</p>
{/if}