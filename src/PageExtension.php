<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Requirements;

class PageExtension extends DataExtension {
	public function onAfterInit() {
		// We need to generate the CSS here so that default configuration can be dynamic

		$gap = Config::inst()->get(GridElement::class, "gap");
		$rows = max(Config::inst()->get(GridElement::class, "rows"), 1);
		$columns = max(Config::inst()->get(GridElement::class, "columns"), 1);
		$breakpoint = Config::inst()->get(GridElement::class, "breakpoint");

$css = "/** Flotilla Grid Stylesheet */

:root {
	--flo-gap: $gap;
	--flo-rows: $rows;
	--flo-columns: $columns;
	--flo-alignment: flex-start;
}

@media not screen and (max-width: $breakpoint) {
	.madebyprisma__flotilla__gridelement .grid {
		display: grid;
		grid-template-rows: repeat(var(--flo-rows), 1fr);
		grid-template-columns: repeat(var(--flo-columns), 1fr);
		gap: var(--flo-gap);
		align-items: var(--flo-alignment);
		margin-top: var(--flo-margin-top-desktop, var(--flo-margin-top, 0px));
		margin-bottom: var(--flo-margin-bottom-desktop, var(--flo-margin-bottom, 0px));
	}

	.madebyprisma__flotilla__gridelement .grid-item {
		grid-column: var(--flo-sx) / var(--flo-ex);
		grid-row: var(--flo-sy) / var(--flo-ey);
	}
}

@media screen and (max-width: $breakpoint) {
	.madebyprisma__flotilla__gridelement .grid {
		display: grid;
		grid-template-rows: repeat(var(--flo-rows), auto);
		grid-template-columns: 1fr;
		align-items: center;
		gap: var(--flo-gap);
		margin-top: var(--flo-margin-top-mobile, var(--flo-margin-top, 0px));
		margin-bottom: var(--flo-margin-bottom-mobile, var(--flo-margin-bottom, 0px));
	}
}
";
		Requirements::customCSS($css);
	}
}