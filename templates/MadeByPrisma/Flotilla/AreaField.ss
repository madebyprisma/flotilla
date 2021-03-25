<div style="display: grid; grid-template-rows: repeat($Rows, 13px); grid-template-columns: repeat($Columns, 13px); gap: 2px;">
	<% loop Options %>
		<input type="radio" name="$Top.Name" id="{$Top.ID}_$X-$Y" value="$Value" <% if $Top.Value == $Value %>checked<% end_if %> />
	<% end_loop %>
</div>