<?php

namespace MadeByPrisma\Flotilla;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class GridElement extends BaseElement {
	private static $singular_name = "flotilla_grid";
	private static $table_name = "MadeByPrisma_Flotilla_GridElement";
	private static $inline_editable = false;

	private static $db = [
		"Columns" => "Int",
		"Rows" => "Int"
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

	public function getGap() {
		return Config::inst()->get(GridElement::class, "gap");
	}

	public function populateDefaults() {
		$this->Columns = Config::inst()->get(GridElement::class, "columns");
		$this->Rows = Config::inst()->get(GridElement::class, "rows");
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$config = new GridFieldConfig_RecordEditor();

		$config->removeComponentsByType(GridFieldAddNewButton::class);

		$adder = Injector::inst()->create(GridFieldAddNewMultiClass::class);
		$adder->setClasses($this->getValidItems());

		$config->addComponent($adder);
		$config->addComponent(new GridFieldOrderableRows("SortOrder"));

		$fields->addFieldToTab("Root.Main", new GridField("Items", "Items", $this->Items(), $config));

		return $fields;
	}

	public function getType() {
		return "Grid";
	}
}