<?  

$histories=unserialize($_GET['query']);
array_push ($histories,array());


$current_year = date('Y');

$month_options = '<option value="JAN">JAN </option>
    <option value="FEB">FEB </option> 
    <option value="MAR">MAR </option>
    <option value="APR">APR </option>
    <option value="MAY">MAY </option> 
    <option value="JUN">JUN </option>
    <option value="JUL">JUL </option> 
    <option value="AUG">AUG </option>
    <option value="SEP">SEP </option>
    <option value="OCT">OCT </option>
    <option value="NOV">NOV </option>
    <option value="DEC">DEC </option>';
	
$year_options = "";
for($i=$current_year;$i>=1950;$i--){
	$year_options .= '<option value="'.$i.'">'.$i.'</option>';
}
	
$i=0;		
foreach($histories as $history){	
?>
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">Company Name:</td>
<td width="300"><input name="history_company_name[]" type="text" id="history_company_name" value="<?=$history['company']?>" size="35" /></td>
</tr>
<tr>
  <td align="right">Position Title:</td>
  <td><input name="history_position[]" type="text" id="history_position" value="<?=$history['position']?>" size="35" /></td>
</tr>
<tr>
  <td align="right">Employment Period</td>
  <td>
	<select name="history_monthfrom[]"> 
		<?=str_replace('value="'.$history['monthfrom'].'"','value="'.$history['monthfrom'].'" selected ',$month_options)?>
    </select>
	<select name="history_yearfrom[]" >
        <?=str_replace('value="'.$history['yearfrom'].'"','value="'.$history['yearfrom'].'" selected ',$year_options)?>  
    </select>
	<select name="history_monthto[]" >  
		<?   
		if($i==0){
			if($history['monthto']=='Present') echo '<option value="Present" selected > Present </option>';
			else echo '<option value="Present"> Present </option>';
		}
		?> 
		<?=str_replace('value="'.$history['monthto'].'"','value="'.$history['monthto'].'" selected ',$month_options)?>
    </select>
	<select name="history_yearto[]" >
		<?
		if($i==0){
			if($history['yearto']=='Present') echo '<option value="Present" selected > Present </option>';
			else echo '<option value="Present"> Present </option>';
		}
		?>
        <?=str_replace('value="'.$history['yearto'].'"','value="'.$history['yearto'].'" selected ',$year_options)?>
    </select>
</td>
</tr>
<tr>
  <td align="right" valign="top">Responsibilities Achievement</td>
  <td><textarea name="history_responsibilities[]" cols="35" rows="7" id="textfield4"><?=$history['responsibilities']?></textarea></td>
</tr>
</table>
<?
$i++;
}
?>