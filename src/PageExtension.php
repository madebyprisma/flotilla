<?php

namespace MadeByPrisma\Flotilla;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Requirements;

class PageExtension extends DataExtension {
	public function onAfterInit() {
		$breakpoint = Config::inst()->get(GridElement::class, "breakpoint");

$css = "/** Flotilla Grid Stylesheet */

@media not screen and (max-width: $breakpoint) {
	.madebyprisma__flotilla__gridelement .grid {
		display: grid;
		grid-template-rows: repeat(var(--rows), 1fr);
		grid-template-columns: repeat(var(--columns), 1fr);
		gap: var(--gap);
	}

	.madebyprisma__flotilla__gridelement .grid-item {
		grid-column: var(--start-x) / var(--end-x);
		grid-row: var(--start-y) / var(--end-y);
	}
}

@media screen and (max-width: $breakpoint) {
	.madebyprisma__flotilla__gridelement .grid {
		display: grid;
		grid-template-rows: repeat(var(--rows), auto);
		grid-template-columns: 1fr;
		align-items: center;
		gap: var(--gap);
	}
}
";
		Requirements::customCSS($css);
	}
}