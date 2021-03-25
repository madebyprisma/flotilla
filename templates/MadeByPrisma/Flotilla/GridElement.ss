<div class="grid" style="--columns: $Columns; --rows: $Rows; --gap: $Gap;">
	<% loop Items.Sort(SortOrder) %>
		$Render
	<% end_loop %>
</div>