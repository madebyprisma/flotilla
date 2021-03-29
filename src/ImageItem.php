<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\Assets\Image;

class ImageItem extends GridItem {
	private static $table_name = "MadeByPrisma_Flotilla_ImageItem";

	private static $has_one = [
		"Image" => Image::class
	];

	private static $owns = [
		"Image"
	];

	public function getTitle() {
		return $this->ImageID ? $this->Image()->getTitle() : "No Image";
	}

	public function getType() {
		return "Image";
	}
}