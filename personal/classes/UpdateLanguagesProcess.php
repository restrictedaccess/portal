<?php
class UpdateLanguagesProcess extends AbstractProcess{
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION['userid'];

		//load user from db
		$user = $this->getUser();

		$userid=$_SESSION['userid'];
		if($userid!="" or $userid!=NULL){

			$sql=$db->select()
			->from('language')
			->where('userid = ?' ,$userid);
			$rows = $db->fetchAll($sql);

			$i=0;
			$languages = array();
			foreach ($rows as $row){
				$languages[$i]['language']=$row['language'];
				$languages[$i]['spoken']=$row['spoken'];
				$languages[$i]['written']=$row['written'];
				$i++;
			}

		}


		$language_options='<option value="" >-</option>';
		$language_array=array("Arabic","Bahasa Indonesia","Bahasa Malaysia","Bengali","Chinese","Dutch","English","Filipino","French","German","Hebrew","Hindi","Italian","Japanese","Korean","Portuguese","Russian","Spanish","Tamil","Thai","Vietnamese");
		for($i=0;$i<count($language_array);$i++){
			$language_options .= '<option value="'.$language_array[$i].'" >'.$language_array[$i].'</option>';
		}

		$spoken_options="<option value='0'>-</option>";
		for($i=1;$i<=10;$i++){
			$spoken_options .= '<option value="'.$i.'" >'.$i.'</option>';
		}

		$written_options="<option value='0'>-</option>";
		for($i=1;$i<=10;$i++){
			$written_options .= '<option value="'.$i.'" >'.$i.'</option>';
		}


		$language_HTML = "";
		$languages = array();
		if($languages != null){
			foreach($languages as $key=>$language){
				if($language['language'] == ''){
					unset($languages[$key]);
				}
			}
		}
		array_push ($languages,array());

		if($languages != NULL){
			foreach($languages as $language){
				$language_HTML .= '	<table border="0" cellspacing="0" cellpadding="0" id="applyform">
					<tr>
						<td width="200" align="right">Language:</td>
						<td width="300">
							<select name="language" id="language">';
							$language_HTML .= str_replace('value="'.$language['language'].'"','value="'.$language['language'].'" selected ',$language_options);
							$language_HTML .= '</select>
						</td>
					</tr>
					<tr>
						<td width="200" align="right">Spoken:</td>
						<td width="300">
							<select name="spoken" id="spoken">';
							$language_HTML .= str_replace('value="'.$language['spoken'].'"','value="'.$language['spoken'].'" selected ',$spoken_options);
							$language_HTML .= '</select>
						</td>
					</tr>
					<tr>
					  <td align="right">Written:</td>
					  <td>
						<select name="written" id="written">';
							$language_HTML .= str_replace('value="'.$language['written'].'"','value="'.$language['written'].'" selected ',$written_options);
							$language_HTML .= '</select>
					  </td>
					</tr>
				</table>
				<br>
				<br>';
			}
		}
		$query="SELECT id,language,spoken,written FROM language WHERE userid=$userid;";
		//echo $query;
		$languages = $db->fetchAll($query);
		$bgcolor="#f5f5f5";
		$i=1;
		$output = "";
		foreach($languages as $language){
			$output.="<tr bgcolor=$bgcolor>
			  <td width='6%' align=center><font size='1'>".$i.".</font></td>
			  <td width='33%' align=left><font size='1'>".$language["language"]."</font></td>
			  <td width='26%' align=center><font size='1'>".$language["spoken"]."yr.</font></td>
			  <td width='35%' align=center><font size='1'>".$language["written"]."</font></td>
			  <td width='26%' align=center><font size='1'><a href='#' class='delete-language' data-id='{$language["id"]}'>delete</a></font></td>
			 </tr>";
			$i++;
		}
		
		$smarty->assign('fname',$user["fname"]);
		$smarty->assign('language_HTML',$language_HTML);
		$smarty->assign("languages", $output);
		$smarty->assign("userid", $userid);
		$smarty->display("updatelanguage.tpl");
	}

	public function process(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION['userid'];

		//load user from db
		$user = $this->getUser();


	}
}