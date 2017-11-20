<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
class PricingListRender extends Portal{
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$categories = $db->fetchAll($db->select()->from(array("c"=>"job_category"))->where("status = ?", "posted")->order("category_name"));
		foreach($categories as $key=>$category){
			$subcategories = $db->fetchAll($db->select()->from(array("s"=>"job_sub_category"))->where("category_id = ?", $category["category_id"]));
			$categories[$key]["subcategories"] = $subcategories;
		}
		$smarty->assign("currencies", array("AUD", "GBP", "USD"));
		$smarty->assign("categories", $categories);
		$smarty->display("index.tpl");
	}
	
	public function getSubCategories(){
		$db = $this->db;
		$category_id = $_REQUEST["category_id"];
		$subcategories = $db->fetchAll($db->select()->from(array("s"=>"job_sub_category"), array("sub_category_id", "sub_category_name"))->where("category_id = ?", $category_id));
		return $subcategories;
	}
	private function addSinglePrice($level){
		$db = $this->db;
		
		$subcategory_id = $_REQUEST["sub_category_id"];
		$currencies = $_REQUEST["currency"];
		foreach($currencies as $key=>$currency){
			$value = $_REQUEST[$level."_price"][$key];
			$active = 1;
			if (!$value){
				continue;
			}
			$subcategory_name = $db->fetchOne($db->select()->from("job_sub_category", array("sub_category_name"))->where("sub_category_id = ?", $subcategory_id));
			
			$data = array(
				"sub_category_id"=>$subcategory_id,
				"value"=>$value,
				"currency"=>$currency,
				"level"=>$level,
				"active"=>$active,
			);
			
			$price = $db->fetchRow($db->select()
								->from("job_sub_categories_new_prices")
								->where("sub_category_id = ?", $subcategory_id)
								->where("currency = ?", $currency)
								->where("level = ?", $level));
			if ($price){
				$id = $price["id"];
			}
			if (!$id){		
				$data["date_created"] = date("Y-m-d H:i:s");
				$db->insert("job_sub_categories_new_prices", $data);
	
				$data["id"] = $db->lastInsertId("job_sub_categories_new_prices");		
				
				$retries = 0;
				while(true){
					try{
						if (TEST){
							$mongo2 = new MongoClient(MONGODB_TEST);
							$database2 = $mongo2->selectDB('prod_logs');
						}else{
							$mongo2 = new MongoClient(MONGODB_SERVER);
							$database2 = $mongo2->selectDB('prod_logs');
						}
					
						break;
					} catch(Exception $e){
						++$retries;
						
						if($retries >= 100){
							break;
						}
					}
				}	
					
				$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
				$history_log_price = $database2->selectCollection("price_history_logs");
				$history_log_price->insert(array("log"=>"A new pricing for ".$subcategory_name." has been added with details : ".json_encode($data), "price_details"=>$data, "admin"=>$admin, "date_updated"=>date("Y-m-d H:i:s")));
				
			}else{
				$old_price = $db->fetchRow($db->select()->from("job_sub_categories_new_prices")->where("id = ?", $id));		
				$db->update("job_sub_categories_new_prices", $data, $db->quoteInto("id = ?", $id));
				$new_price = $db->fetchRow($db->select()->from("job_sub_categories_new_prices")->where("id = ?", $id));
				$difference = array_diff_assoc($old_price,$new_price);
				$history_changes = "Updates has been updated on <span style='color:#ff0000'>".$subcategory_name." - {$new_price["level"]} - {$new_price["currency"]}</span> with the following changes: ";
				$retries = 0;
				while(true){
					try{
						if (TEST){
							$mongo = new MongoClient(MONGODB_TEST);
							$database2 = $mongo->selectDB('prod_logs');
						}else{
							$mongo2 = new MongoClient(MONGODB_SERVER);
							$database2 = $mongo2->selectDB('prod_logs');
						}
						break;
					} catch(Exception $e){
						++$retries;
						
						if($retries >= 100){
							break;
						}
					}
				}
					
				if( count($difference) > 0){
					foreach(array_keys($difference) as $array_key){
						$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old_price[$array_key] , $new_price[$array_key]);
					}						
					$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
					$history_log_price = $database2->selectCollection("price_history_logs");
					$history_log_price->insert(array("log"=>$history_changes, "old_price_details"=>$old_price, "new_price_details"=>$new_price, "price_details"=>$new_price, "admin"=>$admin, "date_updated"=>date("Y-m-d H:i:s")));				
				}
				
			}
		}
	}
	
	public function multiAddPrice(){
	    $subcategory_id = $_REQUEST["sub_category_id"];
        if (!$subcategory_id){
            return array("success"=>false, "error"=>"Please select job position");
        }
		$this->addSinglePrice("entry");
		$this->addSinglePrice("mid");
		$this->addSinglePrice("advanced");
		return array("success"=>true);
	}
	
	public function updatePrice(){
		
		$db = $this->db;
		
		$subcategory_id = $_REQUEST["sub_category_id"];
		$value = $_REQUEST["value"];
		$currency = $_REQUEST["currency"];
		$level = $_REQUEST["level"];
		$active = 1;
		$id = $_REQUEST["id"];
		
		if (!$level){
			return array("success"=>false, "error"=>"Level is required");
		}
		if (!$value){
			return array("success"=>false, "error"=>"Price is required");
		}
		if (!$subcategory_id){
			return array("success"=>false, "error"=>"Job Position is required");
		}
		if (!$currency){
			return array("success"=>false, "error"=>"Currency is required");
		}
		
		$subcategory_name = $db->fetchOne($db->select()->from("job_sub_category", array("sub_category_name"))->where("sub_category_id = ?", $subcategory_id));
			
		$data = array(
			"sub_category_id"=>$subcategory_id,
			"value"=>$value,
			"currency"=>$currency,
			"level"=>$level,
			"active"=>$active,
		);
		
		$price = $db->fetchRow($db->select()
							->from("job_sub_categories_new_prices")
							->where("sub_category_id = ?", $subcategory_id)
							->where("currency = ?", $currency)
							->where("level = ?", $level));
		if ($price){
			$id = $price["id"];
		}
		if (!$id){		
			$data["date_created"] = date("Y-m-d H:i:s");
			$db->insert("job_sub_categories_new_prices", $data);

			$data["id"] = $db->lastInsertId("job_sub_categories_new_prices");
			$retries = 0;
			while(true){
				try{
					if (TEST){
						$mongo2 = new MongoClient(MONGODB_TEST);
						$database2 = $mongo2->selectDB('prod_logs');
					}else{
						$mongo2 = new MongoClient(MONGODB_SERVER);
						$database2 = $mongo2->selectDB('prod_logs');
					}
					break;
				} catch(Exception $e){
					++$retries;
					
					if($retries >= 100){
						break;
					}
				}
			}	
				
			$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
			$history_log_price = $database2->selectCollection("price_history_logs");
			$history_log_price->insert(array("log"=>"A new pricing for ".$subcategory_name." has been added with details : ".json_encode($data), "price_details"=>$data, "admin"=>$admin, "date_updated"=>date("Y-m-d H:i:s")));
			
		}else{
			$old_price = $db->fetchRow($db->select()->from("job_sub_categories_new_prices")->where("id = ?", $id));
			$db->update("job_sub_categories_new_prices", $data, $db->quoteInto("id = ?", $id));
			$new_price = $db->fetchRow($db->select()->from("job_sub_categories_new_prices")->where("id = ?", $id));
			$difference = array_diff_assoc($old_price,$new_price);
			$history_changes = "Updates has been updated on ".$subcategory_name." - {$new_price["level"]} with the following changes: ";
			$retries = 0;
			while(true){
				try{
					if (TEST){
						$mongo2 = new MongoClient(MONGODB_TEST);
						$database2 = $mongo2->selectDB('prod_logs');
					}else{
						$mongo2 = new MongoClient(MONGODB_SERVER);
						$database2 = $mongo2->selectDB('prod_logs');
					}
					break;
				} catch(Exception $e){
					++$retries;
					
					if($retries >= 100){
						break;
					}
				}
			}
				
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old_price[$array_key] , $new_price[$array_key]);
				}						
				$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
				$history_log_price = $database2->selectCollection("price_history_logs");
				$history_log_price->insert(array("log"=>$history_changes, "old_price_details"=>$old_price, "new_price_details"=>$new_price, "price_details"=>$new_price, "admin"=>$admin, "date_updated"=>date("Y-m-d H:i:s")));				
			}
			
		}
		return array("success"=>true);
	}
	
	public function getHistory(){
	    $db = $this->db;
		$retries = 0;
		while(true){
			try{
				if (TEST){
					$mongo2 = new MongoClient(MONGODB_TEST);
					$database2 = $mongo2->selectDB('prod_logs');
				}else{
					$mongo2 = new MongoClient(MONGODB_SERVER);
					$database2 = $mongo2->selectDB('prod_logs');
				}
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
		
		$history_log_price = $database2->selectCollection("price_history_logs");
		$cursor = $history_log_price->find();
		$logs = array();
		$cursor->limit(1000);
		while($cursor->hasNext()){
			$logs[] = $cursor->getNext();
		}
		$logs = array_reverse($logs);
		return $logs;
	}
	
	public function getPriceDetails(){
		$db = $this->db;
		$id = $_REQUEST["id"];
		if (!$id){
			return array("success"=>false);
		}
		$price = $db->fetchRow($db->select()->from("job_sub_categories_new_prices")->where("id = ?", $id));
		if ($price){
			return array("success"=>true, "price"=>$price);
		}else{
			return array("success"=>false);
		}
	}
	public function getPriceDetailsByPosition(){
		$db = $this->db;
		$id = $_REQUEST["id"];
		if (!$id){
			return array("success"=>false);
		}
		$prices = $db->fetchAll($db->select()->from("job_sub_categories_new_prices")->where("sub_category_id = ?", $id));
		if ($prices){
			return array("success"=>true, "prices"=>$prices);
		}else{
			return array("success"=>false);
		}
	}
	
	
	
	public function deletePrice(){
		$db = $this->db;
		$id = $_REQUEST["id"];
		if (!$id){
			return array("success"=>false);
		}
		$old_price = $db->fetchRow($db->select()->from("job_sub_categories_new_prices")->where("id = ?", $id));
		$db->delete("job_sub_categories_new_prices", $db->quoteInto("id = ?", $id));
		$retries = 0;
		while(true){
			try{
				if (TEST){
					$mongo = new MongoClient(MONGODB_TEST);
					$database2 = $mongo2->selectDB('prod_logs');
				}else{
					$mongo2 = new MongoClient(MONGODB_SERVER);
					$database2 = $mongo2->selectDB('prod_logs');
				}
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
			
		$subcategory_id = $old_price["sub_category_id"];
		$subcategory_name = $db->fetchOne($db->select()->from("job_sub_category", array("sub_category_name"))->where("sub_category_id = ?", $subcategory_id));
		
		$history_changes = "Pricing for ".$subcategory_name." has been deleted with the following details:\n".json_encode($old_price);
		
		$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
		$history_log_price = $database2->selectCollection("price_history_logs");
		$history_log_price->insert(array("log"=>$history_changes, "old_price_details"=>$old_price, "price_details"=>$old_price, "admin"=>$admin, "date_updated"=>date("Y-m-d H:i:s")));				
	
		return array("success"=>true);
	}
	
	public function loadPrices(){
		$db = $this->db;
		if (!$_REQUEST["currency"]){
			$currency = "AUD";
		}else{
			$currency = $_REQUEST["currency"];
		}
		
		$category_id = $_REQUEST["category_id"];
		$sub_category_id = $_REQUEST["sub_category_id"];
		
		
		$final_list = array();
		if ($category_id){
			$categories = $db->fetchAll($db->select()->from(array("c"=>"job_category"), array("category_name", "category_id"))->where("status = ?", "posted")->where("category_id = ?", $category_id)->order("category_name"));		
		}else{
			$categories = $db->fetchAll($db->select()->from(array("c"=>"job_category"), array("category_name", "category_id"))->where("status = ?", "posted")->order("category_name"));
		}
		foreach($categories as $key=>$category){
			$empty = true;
			if ($sub_category_id){
				$subcategories = $db->fetchAll($db->select()->from(array("s"=>"job_sub_category"), array("sub_category_name", "sub_category_id"))->where("category_id = ?", $category["category_id"])->where("sub_category_id = ?", $sub_category_id));			
			}else{
				$subcategories = $db->fetchAll($db->select()->from(array("s"=>"job_sub_category"), array("sub_category_name", "sub_category_id"))->where("category_id = ?", $category["category_id"]));
			}
			$unempty_subcategories = array();
			foreach($subcategories as $key_sub=>$subcategory){
				$subcategories[$key_sub]["prices"] = $db->fetchAll($db->select()->from("job_sub_categories_new_prices")->where("currency = ?", $currency)->where("sub_category_id = ?", $subcategory["sub_category_id"]));
				if (!empty($subcategories[$key_sub]["prices"])){
					$empty = false;
					$unempty_subcategories[]  = $subcategories[$key_sub];
				}
			}
			if (!$empty){
				$categories[$key]["subcategories"] = $unempty_subcategories;
				$final_list[] = $categories[$key];
			}
		}
		
		
		foreach($final_list as $key_cat=>$category){
			foreach($category["subcategories"] as $key_sub_cat=>$subcategory){
					
				
				foreach($subcategory["prices"] as $key_price=>$price){
					if ($price["level"]=="entry"){
						$price["level"] = "Entry Level";
					}else if ($price["level"]=="mid"){
						$price["level"] = "Mid Level";
					}else{
						$price["level"] = "Expert Level";
					}
					$final_list[$key_cat]["subcategories"][$key_sub_cat]["prices"][$key_price]["value"] = number_format($price["value"], 2);
					$final_list[$key_cat]["subcategories"][$key_sub_cat]["prices"][$key_price]["level"] = $price["level"];
					
				}
			}
		}
		return $final_list;
	}
}
