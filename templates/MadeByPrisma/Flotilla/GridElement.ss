<div class="grid" style="--columns: $Columns; --rows: $Rows; --gap: $Gap; --alignment: $Alignment;">
	<% loop Items.Sort(SortOrder) %>
		$Render
	<% end_loop %>
</div>