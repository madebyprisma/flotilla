<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\Core\Convert;

class TextItem extends GridItem {
	private static $table_name = "MadeByPrisma_Flotilla_TextItem";
	private static $db = [
		"Content" => "HTMLText"
	];

	public function getTitle() {
		$raw = Convert::html2raw($this->Content);
		$summary = str_replace("\n", " ", substr($raw, 0, 50));

		return $summary . (strlen($summary) < strlen($raw) ? "..." : "");
	}

	public function getType() {
		return "Text";
	}
}