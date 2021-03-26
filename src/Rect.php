<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\View\ArrayData;

class Rect extends ArrayData {
	public function __construct($db) {
		if (is_string($db)) {
			$corners = explode(":", $db);
			$start = explode(",", $corners[0]);
			$end = explode(",", $corners[1]);

			parent::__construct([
				"StartX" => min($end[0], $start[0]),
				"StartY" => min($end[1], $start[1]),
				"EndX" => max($start[0], $end[0]),
				"EndY" => max($start[1], $end[1]),
				"Value" => $db
			]);
		}
		else {
			parent::__construct([
				"StartX" => 0,
				"StartY" => 0,
				"EndX" => 0,
				"EndY" => 0,
				"Value" => "0,0:0,0"
			]);
		}
	}
}