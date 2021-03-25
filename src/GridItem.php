<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class GridItem extends DataObject {
	private static $table_name = "MadeByPrisma_Flotilla_GridItem";
	private static $db = [
		"SortOrder" => "Int",
		"Start" => "Varchar(64)",
		"End" => "Varchar(64)"
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
			new AreaField("Start", "Start", $this->Grid()->Columns, $this->Grid()->Rows, $this->Start),
			new AreaField("End", "End", $this->Grid()->Columns, $this->Grid()->Rows, $this->End)
		]);

		return $fields;
	}

	public function getLayout() {
		$start = explode(",", $this->Start);
		$end = explode(",", $this->End);

		$sx = count($start) > 0 ? (int)$start[0] + 1 : 1;
		$sy = count($start) > 1 ? (int)$start[1] + 1 : 1;

		$ex = count($end) > 0 ? (int)$end[0] + 1 : 1;
		$ey = count($end) > 1 ? (int)$end[1] + 1 : 1;

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