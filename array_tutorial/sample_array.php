<?php
include "../conf/zend_smarty_conf.php";

$clients = array("RemoteStaff Client", "Remote Staff Inc.", "Real Estate");

for ($i = 0; $i < count($clients); $i++) {
	echo $clients[$i] . "<br/>";
}

foreach ($clients as $client) {
	echo $client . "<br/>";
}

foreach ($clients as $key => $client) {
	echo $key . ":" . $client . "<br/>";
}

$numbers = array();
$numbers[] = array(1, 3, 4, 9);
$numbers[] = array(4, 5, 6);
$numbers[] = array(90, 20, 3);
$numbers[] = array(20, 4, 5);
?>

<table>
	<?php
		for($babe=0;$babe<count($numbers);$babe++){
	?>
		<tr>
			<?php 
				for($faith=0; $faith<count($numbers[$babe]); $faith++){
					?>
					<td><?php echo $numbers[$babe][$faith]?></td>
					<?php } ?>
		</tr>
	<?php } ?>
</table>

<?php $candidates = $db -> fetchAll($db -> select() -> from("personal", array("userid", "fname", "lname")) -> order("userid DESC") -> limit(100)); ?>

<table border="2">
		<?php
			foreach($candidates as $key=>$candidate){
		?>	
		<tr>
			<td><?php echo $candidate["userid"]?></td>
			<td><?php echo $candidate["fname"]?></td>
			<td><?php echo $candidate["lname"]?></td>
				
		</tr>	
		<?php } ?>
		
</table><br/>
<?php $personal = $db -> fetchAll($db -> select() -> from("personal", array("userid", "fname", "lname", "datecreated")) -> where("userid=?",37555)->where("gender=?", "Male") -> order("userid DESC") -> limit(100)); 
	//fixing raw data
	foreach($personal as $key=>$person){
		$personal[$key]["datecreated"] = date("F d, Y h:i A", strtotime($person["datecreated"]));
		
		$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $person["userid"]));
		
		$filtered_skills = array();
		
		foreach($skills as $skill){
			if ($skill["proficiency"]==3){
				$filtered_skills[] = $skill;
			}
		}
		
		$personal[$key]["skills"] = $filtered_skills;
		
		$educ =$db->fetchRow($db->select()->from("education")->where("userid = ?", $person["userid"]));
		$personal[$key]["educ"] = $educ;
	}

	
	echo "<pre>";
	print_r($personal);
	echo "</pre>";

?>



<table border=3 color="pink">
		<?php
		
		//displaying
		foreach($personal as $key=>$person){
			
	?>    <tr>
		       <td><?php echo $person ["userid"]?></td>
		       <td><?php echo strtoupper($person ["fname"])?></td>
		       <td><?php echo strtoupper($person ["lname"])?></td>
		       <td><?php echo $person ["datecreated"]?></td>		       
	</tr>
	 <?php
		}
		?>
</table>

		
		
		
		
		
		
