<?php

/*
 * BP Profile Search - form template 'bps-form-sample-1'
 *
 * See http://dontdream.it/bp-profile-search/form-templates/ if you wish to modify this template or develop a new one.
 *
 */

	$F = bps_escaped_form_data ();

	$toggle_id = 'bps_toggle'. $F->id;
	$form_id = 'bps_'. $F->location. $F->id;

	if ($F->location != 'directory')
	{
		echo "<div id='buddypress'>";
	}
	else
	{
?>
	<div class="item-list-tabs bps_header">
	  <ul>
		<li><?php esc_html( $F->header ); ?></li>
<?php
		if ($F->toggle)
		{
?>
		<li class="last">
		  <input id="<?php echo esc_attr( $toggle_id ); ?>" type="submit" value="<?php echo esc_attr( $F->toggle_text ); ?>">
		</li>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#<?php echo esc_attr( $form_id ); ?>').hide();
				$('#<?php echo esc_attr( $toggle_id ); ?>').click(function(){
					$('#<?php echo esc_attr( $form_id ); ?>').toggle();
				});
			});
		</script>
<?php
		}
?>
	  </ul>
	</div>
<?php
	}

	echo "<form action='$F->action' method='$F->method' id='$form_id' class='jvbpd_bp_profile_search_inline standard-form form-inline'>\n";

	$j = 0;
	foreach ($F->fields as $f)
	{
		if ($f->display == 'hidden')
		{
			echo "<input type='hidden' name='$f->code' value='$f->value'>\n";
			continue;
		}

		$name = sanitize_title ($f->name);
		$alt = ($j++ % 2)? 'alt': '';
		$class = "form-group editfield $f->code field_$name $alt";

		echo "<div class='$class'>\n";

		switch ($f->display)
		{
			case 'range':
				if ($f->type == 'datebox')
				{
					echo "<label for='$f->code'>$f->label</label>\n";

					echo __('from', 'jvfrmtd' ). " <select style='width: auto;' name='{$f->code}_min' id='$f->code'>\n";
					echo "<option  value=''>". __('min', 'jvfrmtd' ). "</option>\n";
					for ($k=18; $k<100; $k++)
					{
						$selected = ($k == $f->min)? "selected='selected'": "";
						echo "<option $selected value='$k'>$k</option>\n";
					}
					echo "</select>\n";

					echo __('to', 'jvfrmtd' ). " <select style='width: auto;' name='{$f->code}_max'>\n";
					echo "<option  value=''>". __('max', 'jvfrmtd' ). "</option>\n";
					for ($k=18; $k<100; $k++)
					{
						$selected = ($k == $f->max)? "selected='selected'": "";
						echo "<option $selected value='$k'>$k</option>\n";
					}
					echo "</select>\n";

					break;
				}
				echo "<label for='$f->code'>$f->label</label>\n";
				echo "<input style='width: 10%; display: inline;' type='text' name='{$f->code}_min' id='$f->code' value='$f->min' class='form-control'>";
				echo '&nbsp;-&nbsp;';
				echo "<input style='width: 10%; display: inline;' type='text' name='{$f->code}_max' value='$f->max' class='form-control'>\n";
				break;

			case 'textbox':
			case 'textarea':
				echo "<input type='text' name='$f->code' id='$f->code' placeholder='$f->label' value='$f->value' class='form-control'>\n";
				break;

			case 'number':
				echo "<label for='$f->code'>$f->label</label>\n";
				echo "<input type='number' name='$f->code' id='$f->code' value='$f->value' class='form-control'>\n";
				break;

			case 'url':
				echo "<input type='text' inputmode='url' name='$f->code' id='$f->code' placeholder='$f->label' value='$f->value' class='form-control'>\n";
				break;

			case 'selectbox':
			case 'radio':
				echo "<select name='$f->code' id='$f->code' class='form-control custom-select'>\n";

				$no_selection = apply_filters ('bps_field_selectbox_no_selection', $f->label, $f);
				if (is_string ($no_selection))
					echo "<option  value=''>$no_selection</option>\n";

				foreach ($f->options as $key => $label)
				{
					$selected = in_array ($key, $f->values)? "selected='selected'": "";
					echo "<option $selected value='$key'>$label</option>\n";
				}
				echo "</select>\n";
				break;

			case 'multiselectbox':
			case 'checkbox':
				echo "<label for='$f->code'>$f->label</label>\n";
				echo "<select name='{$f->code}[]' id='$f->code' multiple='multiple' class='form-control'>\n";

				foreach ($f->options as $key => $label)
				{
					$selected = in_array ($key, $f->values)? "selected='selected'": "";
					echo "<option $selected value='$key'>$label</option>\n";
				}
				echo "</select>\n";
				break;			

			default:
				echo "<p>BP Profile Search: don't know how to display the <em>$f->display</em> field type.</p>\n";
				break;
		}

		if (!empty ($f->description) && $f->description != '-')
			echo "<p class='description'>$f->description</p>\n";

		echo "</div>\n";
	}

	echo "<div class='submit'>\n";
	echo "<input type='submit' value='". __('Search', 'jvfrmtd' ). "'>\n";
	echo "</div>\n";
	echo "</form>\n";

	if ($F->location != 'directory')  echo "</div>\n";

// BP Profile Search - end of template
