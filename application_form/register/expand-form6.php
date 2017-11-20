<?  

$languages=unserialize($_GET['query']);
array_push ($languages,array());

$language_options='<option value="" >-</option>'; 
$language_array=array("Arabic","Bahasa Indonesia","Bahasa Malaysia","Bengali","Chinese","Dutch","English","Filipino","French","German","Hebrew","Hindi","Italian","Japanese","Korean","Portuguese","Russian","Spanish","Tamil","Thai","Vietnamese");
for($i=0;$i<count($language_array);$i++){
	$language_options .= '<option value="'.$language_array[$i].'" >'.$language_array[$i].'</option>';
}

$spoken_options="";
for($i=0;$i<=10;$i++){
	$spoken_options .= '<option value="'.$i.'" >'.$i.'</option>';
}

$written_options="";
for($i=0;$i<=10;$i++){
	$written_options .= '<option value="'.$i.'" >'.$i.'</option>';
}
	
				
foreach($languages as $language){	
?>

	<table border="0" cellspacing="0" cellpadding="0" id="applyform">  
		<tr>
			<td width="200" align="right">Language:</td>
			<td width="300">
				<select name="language[]" id="language[]">
					<?=str_replace('value="'.$language['language'].'"','value="'.$language['language'].'" selected ',$language_options)?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">Spoken:</td>
			<td width="300">
				<select name="spoken[]" id="spoken[]">
					<?=str_replace('value="'.$language['spoken'].'"','value="'.$language['spoken'].'" selected ',$spoken_options)?>
				</select>
			</td>
		</tr>
		<tr>
		  <td align="right">Written:</td>
		  <td>
			<select name="written[]" id="written[]"> 
				<?=str_replace('value="'.$language['written'].'"','value="'.$language['written'].'" selected ',$written_options)?>
			</select>
		  </td>
		</tr>
	</table>
	<br>
	<br>

<?
}
?>