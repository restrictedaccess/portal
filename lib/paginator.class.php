<?php

class Paginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $default_ipp = 50;
	var $querystring;
	var $anchor_name = '';
	var $page_name = 'page';
	var $ipp_name = 'ipp';
	var $cur_querystring;

	function Paginator()
	{
		$this->current_page = 1;
		$this->mid_range = 7;
		//$this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;
		$this->items_per_page = (!empty($_GET[$this->ipp_name])) ? $_GET[$this->ipp_name]:$this->default_ipp;
		
		
		
		
	}

	function paginate()
	{
		$this->items_per_page = (!empty($_GET[$this->ipp_name])) ? $_GET[$this->ipp_name]:$this->default_ipp;
		//if($_GET['ipp'] == 'All')
		if($_GET[$this->ipp_name] == 'All')
		{
			$this->num_pages = 1;//ceil($this->items_total/$this->default_ipp);
			$this->items_per_page = $this->items_total;//$this->default_ipp;
		}
		else
		{
			if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
			$this->num_pages = ceil($this->items_total/$this->items_per_page);
		}
		
		$this->current_page = (int) $_GET[$this->page_name]; // must be numeric > 0
		if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;

		if($_GET)
		{
			$args = explode("&",$_SERVER['QUERY_STRING']);

			foreach($args as $arg)
			{
				$keyval = explode("=",$arg);
				//if($keyval[0] != "page" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
				if($keyval[0] != $this->page_name And $keyval[0] != $this->ipp_name) $this->querystring .= "&" . $arg;
			}
		}

		if($_POST)
		{
			foreach($_POST as $key=>$val)
			{
				//if($key != "page" And $key != "ipp") $this->querystring .= "&$key=$val";
				if($key != $this->page_name And $key != $this->ipp_name) $this->querystring .= "&$key=$val";
			}
		}
		
		// add #name 5-20-09
		$this->querystring .= $this->anchor_name;

		if($this->num_pages > 5)
		{
			$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?$this->page_name=$prev_page&$this->ipp_name=$this->items_per_page$this->querystring\">&laquo; Previous</a> ":"<span class=\"inactive\" href=\"#\">&laquo; Previous</span> ";

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0)
			{
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages)
			{
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);

			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
				// loop through all pages. if first, last, or in range, display
				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
				{
					$this->return .= ($i == $this->current_page And $_GET[$this->page_name] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" style=\"margin-left:10px;color:#92C3FF;font-weight:bold;\" href=\"#\">$i</a>&nbsp;&nbsp;":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"$_SERVER[PHP_SELF]?$this->page_name=$i&$this->ipp_name=$this->items_per_page$this->querystring\">$i</a>&nbsp;&nbsp;";
					
					// ADDED -2009/05/20 (used if you want to get the current link)
					if ($i == $this->current_page And $_GET[$this->page_name] != 'All')
						$this->cur_querystring = "$this->page_name=$i&$this->ipp_name=$this->items_per_page$this->querystring";
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";
			}
			$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET[$this->page_name] != 'All')) ? "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?$this->page_name=$next_page&$this->ipp_name=$this->items_per_page$this->querystring\">Next &raquo;</a>\n":"<span class=\"inactive\" href=\"#\">&raquo; Next</span>\n";
			// $this->return .= ($_GET['page'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"paginate\" style=\"margin-left:10px\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a> \n";
		}
		else
		{
			for($i=1;$i<$this->num_pages;$i++)
			{
				// $this->return .= ($i == $this->current_page) ? "<a class=\"current\" style=\"margin-left:10px;color:#92C3FF;font-weight:bold;\" href=\"#\">$i</a>&nbsp;&nbsp;":"<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a>&nbsp;&nbsp;";
				$this->return .= ($i == $this->current_page) ? "<a style=\"margin-left:10px;color:#92C3FF;font-weight:bold;\" href=\"#\">$i</a>&nbsp;&nbsp;":"<a style=\"margin-left:10px;\" href=\"$_SERVER[PHP_SELF]?$this->page_name=$i&$this->ipp_name=$this->items_per_page$this->querystring\">$i</a>&nbsp;&nbsp;";
			}
			
			$this->return .= ($this->num_pages == $this->current_page) ? "<a style=\"margin-left:10px;color:#92C3FF;font-weight:bold;\" href=\"#\">$i</a>":"<a style=\"margin-left:10px;\" href=\"$_SERVER[PHP_SELF]?$this->page_name=$i&$this->ipp_name=$this->items_per_page$this->querystring\">$i</a>";
			
			
			// $this->return .= ($this->num_pages == $this->current_page) ? "<a class=\"current\" style=\"margin-left:10px;color:#92C3FF;font-weight:bold;\" href=\"#\">$i</a>":"<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a>";
			// $this->return .= "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a> \n";
		}
		$this->low = ($this->current_page-1) * $this->items_per_page;
		$this->high = ($_GET[$this->ipp_name] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
		if ($this->items_total== 0) $this->low = 0;
		$this->limit = ($_GET[$this->ipp_name] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
		
	}

	function display_items_per_page()
	{
		$items = '';
		$ipp_array = array(10,25,50,100,'All');
		foreach($ipp_array as $ipp_opt)	{
			$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":
			( ($this->items_per_page == $this->items_total && $ipp_opt == 'All') ? "<option selected value=\"All\">All</option>\n" : "<option value=\"$ipp_opt\">$ipp_opt</option>\n");
		}
		return "<span class=\"paginate\">Items per page:</span>&nbsp;<select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?$this->page_name=1&$this->ipp_name='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
	}

	function display_jump_menu()
	{
		for($i=1;$i<=$this->num_pages;$i++)
		{
			$option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
		}
		return "<span class=\"paginate\">Page:</span>&nbsp;<select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?$this->page_name='+this[this.selectedIndex].value+'&$this->ipp_name=$this->items_per_page$this->querystring';return false\">$option</select>\n";
	}

	function display_pages()
	{
		return $this->return;
	}
}