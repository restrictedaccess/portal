<?php
require_once dirname(__FILE__) . "/../../lib/Portal.php";
class SummaryPageView extends Portal {

	private $filter = array();

	private $filter_page_views = array();

	private $filter_type = "count";

	private $collection;
	private function formatSeconds($milliseconds) {
		$seconds = floor($milliseconds / 1000);
		$minutes = floor($seconds / 60);
		$hours = floor($minutes / 60);
		$milliseconds = $milliseconds % 1000;
		$seconds = $seconds % 60;
		$minutes = $minutes % 60;

		$format = '%u:%02u:%02u.%03u';
		$time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
		return rtrim($time, '0');

	}

	private function setFilter() {
		$db = $this -> db;
		if ($_REQUEST["client_name"]) {
			$result = $this -> db -> fetchAll($this -> db -> select() -> from(array("l" => "leads"), array("id")) -> where("CONCAT(l.fname, ' ', l.lname) LIKE '%" . addslashes($_REQUEST["client_name"]) . "%'"));
			$ids = array();
			foreach ($result as $lead) {
				$ids[] = intval($lead["id"]);
			}
			$this -> filter["client_id"] = array('$in' => $ids);
		}
		
		if ($_REQUEST["client_id"]){
			$this -> filter["client_id"] = intval($_REQUEST["client_id"]);
		}

		if ((isset($_REQUEST["date_from"]) && ($_REQUEST["date_from"])) && isset($_REQUEST["date_to"]) && ($_REQUEST["date_to"])) {
			$this -> filter_page_views["date_created"] = array('$gte' => new MongoDate(strtotime($_REQUEST["date_from"])), '$lte' => new MongoDate(strtotime("+1 day", strtotime($_REQUEST["date_to"]))));

		}

		if (isset($_REQUEST["filter_type"])) {
			$this -> filter_type = $_REQUEST["filter_type"];
		}

	}

	private function init() {
		try {
			$retries = 0;
			while(true){
				try{
					if (TEST) {
						$mongo = new MongoClient(MONGODB_TEST);
						$database = $mongo -> selectDB('prod');
					} else {
						$mongo = new MongoClient(MONGODB_SERVER);
						$database = $mongo -> selectDB('prod');
					}
					break;
				} catch(Exception $e){
					++$retries;
					
					if($retries >= 100){
						break;
					}
				}
			}
								
			$this -> collection = $database -> selectCollection('client_log_time');
		} catch(Exception $e) {

		}
	}

	public function render() {
		$db = $this -> db;

		$this -> init();
		$this -> setFilter();
		$group = array('_id' => '$client_id');
		$collection = $this -> collection;

		if (!empty($this -> filter)) {
			$aggregate = array( array('$match' => $this -> filter), array('$group' => $group));
		} else {
			$aggregate = array( array('$group' => $group));
		}

		$result = $collection -> aggregate($aggregate);

		$clients = array();
		foreach ($result["result"] as $client) {
			$lead = $db -> fetchRow($db -> select() -> from(array("l" => "leads"), array("l.fname", "l.lname", "l.id")) -> where("id = ?", $client["_id"]));
			if ($lead) {
				$group = array('_id' => '$page', "total_stay_time" => array('$sum' => '$millisecond'), "total_visit_times" => array('$sum' => 1));
				$this -> filter_page_views["client_id"] = intval($client["_id"]);
				$aggregate = array( array('$match' => $this -> filter_page_views), array('$group' => $group));
				
				
				
				$page_views = $collection -> aggregate($aggregate);
				foreach ($page_views["result"] as $key => $item) {
					$page_views["result"][$key]["formatted_total_stay"] = $this -> formatSeconds($item["total_stay_time"]);
				}
				$lead["page_views"] = $page_views;

				$clients[] = $lead;
			}

		}
		return $clients;

	}

}
