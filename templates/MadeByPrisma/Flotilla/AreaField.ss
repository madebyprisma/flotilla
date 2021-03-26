<input type="hidden" class="value" name="$Name" value="$Rect.Value"/>
<div style="display: grid; grid-template-rows: repeat($Rows, 13px); grid-template-columns: repeat($Columns, 13px); gap: 2px;">
	<% loop Options %>
		<input type="checkbox" data-x="$X" data-y="$Y" <% if $X == $Top.Rect.StartX && $Y == $Top.Rect.StartY %>checked<% else_if $X == $Top.Rect.EndX && $Y == $Top.Rect.EndY %>checked<% end_if %> />
	<% end_loop %>
</div>
$ReadyBehavior