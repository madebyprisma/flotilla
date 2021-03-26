<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class GridItem extends DataObject {
	private static $table_name = "MadeByPrisma_Flotilla_GridItem";
	private static $db = [
		"SortOrder" => "Int",
		"Placement" => "Varchar(64)"
	];

	private static $summary_fields = [
		"Title"
	];

	private static $has_one = [
		"Grid" => GridElement::class
	];

	private static $extensions = [
        Versioned::class
    ];

	protected $template = false;

	public function getTitle() {
		if ($title = $this->getField("Title")) {
			return $title;
		}
		else {
			return "Untitled " . $this->getType() . " Item";
		}
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeByName([
			"SortOrder",
			"GridID"
		]);
		
		$fields->addFieldsToTab("Root.Main", [
			new AreaField("Placement", "Placement", $this->Grid()->Columns, $this->Grid()->Rows, new Rect($this->Placement)),
		]);

		return $fields;
	}

	public function getLayout() {
		$rect = new Rect($this->Placement);

		$sx = $rect->getField("StartX") + 1;
		$sy = $rect->getField("StartY") + 1;
		$ex = $rect->getField("EndX") + 2;
		$ey = $rect->getField("EndY") + 2;

		return "--start-x: $sx; --start-y: $sy; --end-x: $ex; --end-y: $ey;";
	}

	public function setTemplate($template) {
		$this->template = $template;
	}

	public function getTemplate() {
		return $this->template;
	}

	public function Render() {
		return $this->template ? $this->renderWith($this->template) : $this->renderWith($this->ClassName);
	}

	public function getType() {
		return "Grid Item";
	}
}