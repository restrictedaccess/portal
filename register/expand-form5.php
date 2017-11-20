<?  
 
$skills=unserialize($_GET['query']);
array_push ($skills,array());

$experience_options='<option value="" >-</option>';
for($i=1;$i<12;$i++){
	if($i==1){$years="Year";}
	else{$years="Years";}
	if($i==11){$i ="more than 10";}
	$experience_options .= '<option value="'.$i.'" > '.$i.' '.$years.'</option>';
	if($i=="more than 10"){$i = 11;}
}

$proficiency_array = array('Advanced','Intermediate','Beginner');
$proficiency_options ='<option value="" >-</option>';
for($i=1;$i<=count($proficiency_array);$i++){
	$proficiency_options .= '<option value="'.$i.'" > '.$proficiency_array[$i-1].'</option>';
}

foreach($skills as $skill){	
?>
<table border="0" cellspacing="0" cellpadding="0" id="applyform">
		<tr>
			<td width="200" align="right" valign="top">Skill:</td>
			<td width="300"><textarea name="skill[]" cols="35" rows="3" id="skill[]"><?=$skill['skill']?></textarea></td>
		</tr>
	<tr>
		<td width="200" align="right">Years of Experience:</td>
		<td width="300">
			<select name="skill_exp[]" id="skill_exp[]">
				<?=str_replace('value="'.$skill['skill_exp'].'"','value="'.$skill['skill_exp'].'" selected ',$experience_options)?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">Proficiency:</td>
		<td>
			<select name="skill_proficiency[]" id="skill_proficiency[]">
				<?=str_replace('value="'.$skill['skill_proficiency'].'"','value="'.$skill['skill_proficiency'].'" selected ',$proficiency_options)?>
			</select>  
		</td>
	</tr>
</table>
<br>
<br>
<?
}
?>