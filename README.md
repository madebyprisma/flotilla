# Flotilla

A rapid, robust, grid-based element for SilverStripe Elemental

## Installation

Just install from composer and run `/dev/build` and you're good to go!

## Configuration

Example yaml configuration:
```yaml
MadeByPrisma\Flotilla\GridElement:
  gap: 8px # Specifies the grid gap used on all grids
  columns: 12 # Specifies the default column count, which can be changed for each grid
  rows: 5 # Same as columns, except rows
  breakpoint: 700px # Specifies the breakpoint between normal and vertical layouts on all grids
```

## Extension

Custom `GridItem`'s:

```php
<?php

namespace Elements\GridItems;

use MadeByPrisma\Flotilla\GridItem;

class CustomItem extends GridItem {
	...

	public function getType() {
		return "Custom";
	}
}
```

**Note:** Each GridItem is rendered based on it's class and namespace, so in this example our item would try and render `Elements\GridItems\CustomItem.ss`.