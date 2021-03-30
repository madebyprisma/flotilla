# Flotilla

A rapid, robust, grid-based element for SilverStripe Elemental

## Installation

Just install from composer and run `/dev/build` and you're good to go!

## Configuration

Example yaml configuration:
```yaml
MadeByPrisma\Flotilla\GridElement:
  gap: 8px # Specifies the default grid gap
  columns: 12 # Specifies the default column count, which can be changed for each grid
  rows: 5 # Same as columns, except rows
  breakpoint: 700px # Specifies the breakpoint between normal and vertical layouts on all grids
  spacing: # Spacing options
    None: "0px" # Use any CSS measurement, which will be used at all sizes
    Small: "20px"
    Medium:
      desktop: "50px" # Add "desktop" _and_ "mobile" properties to allow for responsive spacing
      mobile: "30px"
    Large:
      desktop: "100px"
      mobile: "60px"
```

## Extension

Custom `GridItem`'s:

```php
<?php

namespace Elements\GridItems;

use MadeByPrisma\Flotilla\GridItem;

class CustomItem extends GridItem {
	public function getTitle() {
		return "...";
	}

	public function getType() {
		return "Custom";
	}
}
```

**Note:** Each GridItem is rendered based on it's class and namespace, so in this example our item would try and render `Elements\GridItems\CustomItem.ss`.

`GridElement` extensions:

```php
<?php

use SilverStripe\ORM\DataExtension;

class GridElementExtension extends DataExtension {
	public function getExtraStyles() {
		return "...";
	}
}
```
