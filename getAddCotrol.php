<?
$control = $_GET['q'];
if($control==1)
{
    $ouput= "<a href='#' class='link17' onClick="."show_addControl('2');".">Hide Manually Action Record</a><br>";
	$ouput.="<table width='97%'>
<tr><td width='32%' valign='top'><table width='100%'>
<tr><td colspan='3'><b>Manual Records</b></td></tr>
<tr><td width='21%' align='right'>Quantity</td>
<td width='3%'>:</td>
<td width='76%'><input type='text' name='quantity' id='quantity' style='width:30' class='text'></td></tr>

<tr><td width='21%' align='right'>Actions</td>
<td width='3%'>:</td>
<td width='76%'>
<select name='action_record' id='action_record' class='text'>
<option value='0'>-</option>
<option value='EMAIL'>EMAIL</option>
<option value='CALL'>CALL</option>
<option value='MAIL'>NOTES</option>
<option value='MEETING FACE TO FACE'>MEETING FACE TO FACE</option>
</select></td></tr>

<tr><td width='21%' align='right' valign='top'>Records</td>
<td width='3%' valign='top'>:</td>
<td width='76%'><textarea name='txt' cols='48' rows='5' wrap='physical' class='text'  style='width:100%'></textarea></td></tr>
<tr><td colspan='3' align='center'><input type='submit' name='save' id='save' value='Save' class='button' onclick='return checkFields();' ></td></tr>
</table></td>
<td width='68%' valign='top'></td>
</tr>
</table>";
}
if($control==2)
{
	$ouput= "<a href='#' class='link17' onClick="."show_addControl('1');".">Add Manually Action Record</a>";
	
}
 echo $ouput;

?>
