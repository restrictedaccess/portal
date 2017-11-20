<?php

//ROY - csro files upload: line 695 - 749
if(@isset($_POST["upload_file"]))
{
			if(basename($_FILES['fileimg']['name']) != NULL || basename($_FILES['fileimg']['name']) != "")
			{
				$bp_id = $_SESSION['agent_no'];
				$notes = $_POST["notes"];
				$type = $_POST["type"];
				$staff = $_POST["staff"];
				if($staff == "" || $staff == NULL)
				{
					$file_owner = "client";
				}
				elseif($staff == "all")
				{
					$file_owner = "all_staff";
				}
				else
				{
					$file_owner = $staff;
				}
				$name = $leads_id."(".$file_owner.")-".basename($_FILES['fileimg']['name']);
				
				$name = str_replace(" ", "_", $name);
				$name = str_replace("'", "", $name);
				$name = str_replace("-", "_", $name);
				$name = str_replace("#", "", $name);
				$name = str_replace("php", "php.txt", $name);								
				
				$file = "uploads/csro_files/".$leads_id."(".$file_owner.")-".basename($_FILES['fileimg']['name']);
				
				$file = str_replace(" ", "_", $file);
				$file = str_replace("'", "", $file);
				$file = str_replace("-", "_", $file);
				$file = str_replace("#", "", $file);
				$file = str_replace("php", "php.txt", $file);	

				//check if file exist
				$sql=$db->select()
				->from('csro_files')
				->where('name = ?' ,$name);
				$ad = $db->fetchRow($sql);
				$existing_file = $ad['name'];
				//ended
										
				if($existing_file == $name)
				{	
					$upload_status = '
					<script language="javascript">
						alert("File already exist.---'.$ad['name'].'");
					</script>
					';					
				}
				else
				{
					$result= move_uploaded_file($_FILES['fileimg']['tmp_name'],$file); 
					if (!$result)
					{
						$upload_status = '
						<script language="javascript">
							alert("Error uploading file, file type is not allowed.");
						</script>						
						';
					}
					else
					{
						$filename_ = "uploads/csro_files/".$leads_id."(".$file_owner.")-".basename($_FILES['fileimg']['name']);
						
						$filename_ = str_replace(" ", "_", $filename_);
						$filename_ = str_replace("'", "", $filename_);
						$filename_ = str_replace("-", "_", $filename_);
						
						$file_p = pathinfo($filename_);
						extract(pathinfo($filename_));
						chmod($filename_, 0777);
						
						if($staff == 'all')
						{
											//add files for each subcontractors
											$queryAllStaff = "SELECT DISTINCT(s.userid), p.fname, p.lname 
												FROM personal p, subcontractors s
												WHERE p.userid = s.userid AND s.leads_id = '$leads_id'";
												$result = $db->fetchAll($queryAllStaff);
												foreach($result as $result)
												{
													$u_id=$result['userid'];
													//mysql_query("INSERT INTO csro_files SET admin_id='$admin_id', bp_id='$bp_id', leads_id='$leads_id', userid='$u_id', type='$type', name='$name', comment='$notes', status='ACTIVE', date='".date("Y-m-d")."'");
													$data=array(
														'admin_id' => $admin_id,
														'bp_id' => $bp_id,
														'leads_id' => $leads_id,
														'userid' => $u_id,
														'type' => $type,
														'name' => $name,
														'comment' =>$notes,
														'status' => 'ACTIVE',
														'date' => date("Y-m-d")
													);
													$db->insert('csro_files', $data);
												}
											//ended
						}
						else
						{
							//mysql_query("INSERT INTO csro_files SET admin_id='$admin_id', bp_id='$bp_id', leads_id='$leads_id', userid='$staff', type='$type', name='$name', comment='$notes', status='ACTIVE', date='".date("Y-m-d")."'");
							$data=array(
								'admin_id' => $admin_id,
								'bp_id' => $bp_id,
								'leads_id' => $leads_id,
								'userid' => $staff,
								'type' => $type,
								'name' => $name,
								'comment' =>$notes,
								'status' => 'ACTIVE',
								'date' => date("Y-m-d")
							);
							$db->insert('csro_files', $data);
						}
						$upload_status = '
						<script language="javascript">
							alert("File uploaded.");
						</script>						
						';	
					}
				}
			}
}
//ENDED


//ROY - generate list of hired staff
$queryAllStaff = "SELECT p.userid, p.fname, p.lname 
	FROM personal p, subcontractors s
	WHERE p.userid = s.userid AND s.leads_id = '$leads_id'";

$result = $db->fetchAll($queryAllStaff);
foreach($result as $result)
{
	$hired_staff_Options.="<option value=".$result['userid'].">".$result['fname']." ".$result['lname']."</option>";
}
$hired_staff_Options.="<option value='all'>All Staff</option>";
//ENDED
?>