<?php

namespace MadeByPrisma\Flotilla;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class GridElement extends BaseElement {
	private static $singular_name = "flotilla_grid";
	private static $table_name = "MadeByPrisma_Flotilla_GridElement";
	private static $inline_editable = false;

	private static $gap = "8px";
	private static $columns = 12;
	private static $rows = 1;
	private static $breakpoint = "700px";
	private static $spacing = [
		"None" => "0px",
		"Small" => "20px",
		"Medium" => [
			"desktop" => "50px",
			"mobile" => "30px"
		],
		"Large" => [
			"desktop" => "100px",
			"mobile" => "60px"
		]
	];

	private static $db = [
		"Columns" => "Int",
		"Rows" => "Int",
		"Gap" => "Varchar(16)",
		"Alignment" => "Varchar(64)",
		"MarginTop" => "Varchar(64)",
		"MarginBottom" => "Varchar(64)"
	];

	private static $has_many = [
		"Items" => GridItem::class
	];

	private static $owns = [
		"Items"
	];

	public function getValidItems() {
		$items = [];

		foreach (ClassInfo::subclassesFor(GridItem::class, false) as $class) {
			if ($singleton = singleton($class)) {
				$items[$class] = $singleton->getType();
			}
		}

		return $items;
	}

	public function populateDefaults() {
		$this->Columns = max(Config::inst()->get(GridElement::class, "columns"), 1);
		$this->Rows = max(Config::inst()->get(GridElement::class, "rows"), 1);
		$this->Gap = Config::inst()->get(GridElement::class, "gap");
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeByName("Items");
		$fields->removeByName("MarginTop");
		$fields->removeByName("MarginBottom");

		$fields->addFieldsToTab("Root.GridLayout", [
			new DropdownField("Alignment", "Alignment", [
				"flex-start" => "Top",
				"center" => "Center",
				"flex-end" => "Bottom"
			]),
			new NumericField("Rows", "Rows"),
			new NumericField("Columns", "Columns"),
			new TextField("Gap", "Gap")
		]);

		$spacing = [];
		$spacingConfig = Config::inst()->get(GridElement::class, "spacing");

		foreach ($spacingConfig as $opt => $px) {
			if (is_string($px)) {
				$spacing[$opt] = "$opt [$px]";
			}
			else if (is_array($px)) {
				$desktop_px = $px["desktop"];
				$mobile_px = $px["mobile"];

				$spacing[$opt] = "$opt [$desktop_px/$mobile_px]";
			}
		}

		$fields->addFieldToTab("Root.Main", new DropdownField("MarginTop", "Top Spacing", $spacing));
		$fields->addFieldToTab("Root.Main", new DropdownField("MarginBottom", "Bottom Spacing", $spacing));

		$config = new GridFieldConfig_RecordEditor();

		$config->removeComponentsByType(GridFieldAddNewButton::class);

		$adder = Injector::inst()->create(GridFieldAddNewMultiClass::class);
		$adder->setClasses($this->getValidItems());

		$config->addComponent($adder);
		$config->addComponent(new GridFieldOrderableRows("SortOrder"));

		$fields->addFieldToTab("Root.Main", new GridField("Items", "Items", $this->Items(), $config));

		return $fields;
	}

	public function getStyle() {
		$style = "";

		if ($this->Columns !== Config::inst()->get(GridElement::class, "columns")) {
			$style .= "--flo-columns: $this->Columns;";
		}

		if ($this->Rows !== Config::inst()->get(GridElement::class, "rows")) {
			$style .= "--flo-rows: $this->Rows;";
		}

		if ($this->Gap !== Config::inst()->get(GridElement::class, "gap")) {
			$style .= "--flo-gap: $this->Gap;";
		}

		if ($this->Alignment !== "flex-start") {
			$style .= "--flo-alignment: $this->Alignment;";
		}
		
		$spacingConfig = Config::inst()->get(GridElement::class, "spacing");

		if ($this->MarginTop) {
			$marginTop = $spacingConfig[$this->MarginTop];
			
			if (is_string($marginTop)) $style .= "--flo-margin-top: $marginTop;";
			else $style .= "--flo-margin-top-desktop: " . $marginTop["desktop"] . ";--flo-margin-top-mobile:" . $marginTop["mobile"] . ";";
		}

		if ($this->MarginBottom) {
			$marginBottom = $spacingConfig[$this->MarginBottom];

			if (is_string($marginBottom)) $style .= "--flo-margin-bottom: $marginBottom;";
			else $style .= "--flo-margin-bottom-desktop: " . $marginBottom["desktop"] . ";--flo-margin-bottom-mobile:" . $marginBottom["mobile"] . ";";
		}

		return $style;
	}

	public function getType() {
		return "Grid";
	}
}
