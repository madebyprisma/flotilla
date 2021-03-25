<?php

namespace MadeByPrisma\Flotilla;

class TextItem extends GridItem {
	private static $table_name = "MadeByPrisma_Flotilla_TextItem";
	private static $db = [
		"Content" => "HTMLText"
	];

	public function getType() {
		return "Text";
	}
}