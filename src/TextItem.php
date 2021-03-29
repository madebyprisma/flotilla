<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\Core\Convert;

class TextItem extends GridItem {
	private static $table_name = "MadeByPrisma_Flotilla_TextItem";
	private static $db = [
		"Content" => "HTMLText"
	];

	public function getTitle() {
		return substr(Convert::html2raw($this->Content), 0, 50);
	}

	public function getType() {
		return "Text";
	}
}