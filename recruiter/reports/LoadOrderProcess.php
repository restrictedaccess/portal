<?php
class LoadOrderProcess{
	
	private $db;
	
	public function __construct($db){
		$this->db = $db;
	}
	
	public function loadChainOrder($children_id){
		$db = $this->db;
		$items = array();
		$id = $children_id;
		do{
			try{
				$item = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $id));
				if ($item){
					$items[] = $item;
					if (isset($item["link_order_id"])){
						$found = true;
						$id = $item["link_order_id"];	
					}else{
						$found = false;
					}
				}else{
					$found = false;
				}
			}catch(Exception $e){
				break;
			}
		}while($found);
		return $items;
	}
	
}