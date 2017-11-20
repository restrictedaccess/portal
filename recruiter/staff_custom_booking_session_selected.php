<?php
if (!isset($db)){
	include('../conf/zend_smarty_conf.php');
}
if (!isset($_SESSION["allstaff_request_selected"])){
	session_start();
}

//START: generate output box from selected order
		$return_output = "";
		$a = explode(",",$_SESSION["allstaff_request_selected"]) ;
		for($i=0; $i < $_SESSION["allstaff_request_counter"]; $i++)
		{
					//start: validate array
					if(@$a[$i] <> "" && @$a[$i] <> NULL)
					{
							$userid = $a[$i];
							$skill_selected = "";
							
							//start: get skill
							if($userid <> "" && $userid <> NULL)
							{
								$sql = $db->select()
									->from('skills')
									->where('userid =?' , $userid);
								$skills = $db->fetchRow($sql);
								$skill_selected = str_replace(",", ", ", $skills['skill']);
							}
							//ended: get skill							
								
							//start: generate staff name
							if($userid == "")
							{
								$name = $userid;
							}
							else
							{
								$sql = $db->select()
								->from('personal')
								->where('userid =?' , $userid);
								$personal = $db->fetchRow($sql);
								$name = $personal['fname'];
							}	
							//ended: generate staff name			
								
							//start: setup output result
							$return_output = $return_output.'
                        	<tr>
                            	<td class="td_info"><a href="javascript: cancel_selected_order('.$userid.'); "><img src="../images/action_delete.gif" border="0" /></a></td>
                                <td width="30%" class="td_info"><a href="javascript: open_popup_profile('.$userid.'); ">'.$name.'</a></td>
                                <td width="70%" class="td_info">'.$skill_selected.'</td>
                            </tr>';						
							//ended: setup output result
					}
					//ended: validate array
					
		}
		//ENDED: generate output box from selected order
?>