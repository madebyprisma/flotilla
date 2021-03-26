jQuery(() => {
	const update = area => {
		let start = null;
		let end = null;

		jQuery(area).find("input:checked").each((_index, input) => {
			let x = parseInt(input.dataset.x);
			let y = parseInt(input.dataset.y);

			if (!start) {
				start = {
					x: x,
					y: y
				}
			}

			if (!end) {
				end = {
					x: x,
					y: y
				}
			}

			if (start.x > x) start.x = x;
			if (start.y > y) start.y = y;
			if (end.x < x) end.x = x;
			if (end.y < y) end.y = y;
		});

		if (start && end) {
			jQuery(area).find(".value").val(`${start.x},${start.y}:${end.x},${end.y}`);
		}
		else {
			start = {
				x: 0,
				y: 0
			}

			end = {
				x: 0,
				y: 0
			}

			jQuery(area).find(".value").val(`0,0:0,0`);
		}

		jQuery(area).find("input").each((_index, input) => {
			let x = parseInt(input.dataset.x);
			let y = parseInt(input.dataset.y);

			input.classList.toggle("inner", !input.checked && x >= start.x && y >= start.y && x <= end.x && y <= end.y);
		});
	}

	const updateAll = () => {
		jQuery(".field.area").each((_index, element) => update(element));
	}

	jQuery(document).on("change", ".field.area", event => update(event.currentTarget));
	
	jQuery(document).on("aftersubmitform afterstatechange", updateAll);

	updateAll();
});