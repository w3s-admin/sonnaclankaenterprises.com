<?php

class Paginator
{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $default_ipp = 6;
	var $querystring;
	var $selfUrl;

	function __construct()
	{
		$this->current_page = 1;
		$this->mid_range = 7;
		$this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp'] : $this->default_ipp;
	}

	function paginate()
	{
		if (($_GET['ipp'] ?? null) == 'All') {
			$this->num_pages = ceil($this->items_total / $this->default_ipp);
			$this->items_per_page = $this->default_ipp;
		} else {
			if (!is_numeric($this->items_per_page) || $this->items_per_page <= 0) {
				$this->items_per_page = $this->default_ipp;
			}
			// Cast after the numeric check so a value like "1e2" (accepted by
			// is_numeric but not valid in a SQL LIMIT clause) can't reach the
			// query built below.
			$this->items_per_page = (int) $this->items_per_page;
			if ($this->items_per_page <= 0) {
				$this->items_per_page = $this->default_ipp;
			}
			$this->num_pages = ceil($this->items_total / $this->items_per_page);
		}

		$this->current_page = (int) ($_GET['page'] ?? 0); // must be numeric > 0
		if ($this->current_page < 1 || !is_numeric($this->current_page)) {
			$this->current_page = 1;
		}
		if ($this->current_page > $this->num_pages) {
			$this->current_page = $this->num_pages;
		}
		$prev_page = $this->current_page - 1;
		$next_page = $this->current_page + 1;

		// $_SERVER['PHP_SELF'] can carry attacker-controlled extra path info
		// (e.g. /page.php/"><script>...</script>), and it ends up embedded both
		// in plain HTML attributes AND inside inline-JS string literals further
		// down (display_items_per_page/display_jump_menu) - htmlspecialchars()
		// alone isn't enough for that second context (the browser HTML-decodes
		// attribute values before JS ever sees them, so an escaped quote can
		// still break out of a JS string). A real PHP_SELF is always a plain
		// filesystem/URL path, so it's simplest and safest to just strip it
		// down to that regardless of where it gets used.
		$this->selfUrl = preg_replace('/[^a-zA-Z0-9\/_\-\.]/', '', $_SERVER['PHP_SELF']);
		$selfUrl = $this->selfUrl;

		// Rebuilt from $_GET/$_POST via http_build_query() (which percent-encodes
		// every value) rather than raw QUERY_STRING/`$key=$val` concatenation -
		// the old version copied attacker-controlled request data straight into
		// HTML attributes and inline JS strings below with no escaping at all,
		// making every pagination link a reflected-XSS vector.
		$extraParams = array();
		if ($_GET) {
			$extraParams = $_GET;
		}
		if ($_POST) {
			$extraParams = array_merge($extraParams, $_POST);
		}
		unset($extraParams['page'], $extraParams['ipp']);
		$this->querystring = $extraParams ? '&' . http_build_query($extraParams) : '';

		$this->return = '<ul class="page-nav list-style">';

		if ($this->num_pages > 10) {
			// Add previous page link
			if ($this->current_page != 1 && $this->items_total >= 10) {
				$this->return .= '<li><a class="paginate" href="' . $selfUrl . '?page=' . $prev_page . '&ipp=' . $this->items_per_page . $this->querystring . '">&laquo; Previous</a></li>';
			} else {
				$this->return .= '<li><a class="inactive" href="#">&laquo; Previous</a></li>';
			}

			$this->start_range = $this->current_page - floor($this->mid_range / 2);
			$this->end_range = $this->current_page + floor($this->mid_range / 2);

			if ($this->start_range <= 0) {
				$this->end_range += abs($this->start_range) + 1;
				$this->start_range = 1;
			}
			if ($this->end_range > $this->num_pages) {
				$this->start_range -= $this->end_range - $this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range, $this->end_range);

			for ($i = 1; $i <= $this->num_pages; $i++) {
				if ($this->range[0] > 2 && $i == $this->range[0]) {
					$this->return .= " ... ";
				}
				// loop through all pages. if first, last, or in range, display
				if ($i == 1 || $i == $this->num_pages || in_array($i, $this->range)) {
					if ($i == $this->current_page && $_GET['page'] != 'All') {
						$this->return .= '<li><a title="Go to page ' . $i . ' of ' . $this->num_pages . '" class="current active" href="#">' . $i . '</a></li>';
					} else {
						$this->return .= '<li><a class="paginate" title="Go to page ' . $i . ' of ' . $this->num_pages . '" href="' . $selfUrl . '?page=' . $i . '&ipp=' . $this->items_per_page . $this->querystring . '">' . $i . '</a></li>';
					}
				}
				if ($this->range[$this->mid_range - 1] < $this->num_pages - 1 && $i == $this->range[$this->mid_range - 1]) {
					$this->return .= " ... ";
				}
			}

			// Add next page link
			if (($this->current_page != $this->num_pages && $this->items_total >= 10) && ($_GET['page'] != 'All')) {
				$this->return .= '<li><a class="paginate" href="' . $selfUrl . '?page=' . $next_page . '&ipp=' . $this->items_per_page . $this->querystring . '">Next &raquo;</a></li>';
			} else {
				$this->return .= '<li><a class="inactive" href="#">&raquo; Next</a></li>';
			}

			$this->return .= ($_GET['page'] == 'All') ? '<li><a class="current active" style="margin-left:10px" href="#">All2</a></li>' : '<li><a class="paginate" style="margin-left:10px" href="' . $selfUrl . '?page=1&ipp=All' . $this->querystring . '">All</a></li>';
		} else {
			for ($i = 1; $i <= $this->num_pages; $i++) {
				$this->return .= ($i == $this->current_page) ? '<li><a class="current active" href="#">' . $i . '</a></li>' : '<li><a class="paginate" href="' . $selfUrl . '?page=' . $i . '&ipp=' . $this->items_per_page . $this->querystring . '">' . $i . '</a></li>';
			}
			$this->return .= '<li><a class="paginate" href="' . $selfUrl . '?page=1&ipp=All' . $this->querystring . '">All</a></li>';
		}

		$this->return .= '</ul>';

		$this->low = ($this->current_page - 1) * $this->items_per_page;
		$this->high = (($_GET['ipp'] ?? null) == 'All') ? $this->items_total : ($this->current_page * $this->items_per_page) - 1;
		$this->limit = (($_GET['ipp'] ?? null) == 'All') ? "" : " LIMIT $this->low,$this->items_per_page";
	}


	function display_items_per_page()
	{
		$items = '';
		$ipp_array = array(10, 25, 50, 100);
		foreach ($ipp_array as $ipp_opt)	$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n" : "<option value=\"$ipp_opt\">$ipp_opt</option>\n";
		$self = $this->selfUrl ?: preg_replace('/[^a-zA-Z0-9\/_\-\.]/', '', $_SERVER['PHP_SELF']);
		return "<span class=\"paginate\">Items per page:</span><select class=\"paginate span1\" onchange=\"window.location='$self?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
	}

	function display_jump_menu()
	{
		for ($i = 1; $i <= $this->num_pages; $i++) {
			$option .= ($i == $this->current_page) ? "<option value=\"$i\" selected>$i</option>\n" : "<option value=\"$i\">$i</option>\n";
		}
		$self = $this->selfUrl ?: preg_replace('/[^a-zA-Z0-9\/_\-\.]/', '', $_SERVER['PHP_SELF']);
		return "<span class=\"paginate\">Page:</span><select class=\"paginate span1\" onchange=\"window.location='$self?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
	}

	function display_pages()
	{
		return $this->return;
	}
}
