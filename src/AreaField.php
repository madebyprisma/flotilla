<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\Forms\FormField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class AreaField extends FormField {
	protected $columns;
	protected $rows;

	public static function normalize($value) {
		return str_replace(" ", "", $value);
	}

	public function getRows() {
		return $this->rows;
	}

	public function getColumns() {
		return $this->columns;
	}

	public function getOptions() {
		$list = new ArrayList([]);

		for ($y = 0; $y < $this->rows; $y++) {
			for ($x = 0; $x < $this->columns; $x++) {
				$list->push(new ArrayData(["X" => $x, "Y" => $y, "Value" => "$x,$y"]));
			}
		}

		return $list;
	}

	public function __construct($name, $title, $columns, $rows) {
		parent::__construct($name, $title);

		$this->setTemplate("MadeByPrisma\\Flotilla\\AreaField");

		$this->columns = max($columns, 1);
		$this->rows = max($rows, 1);
	}
}