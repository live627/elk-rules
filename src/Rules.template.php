<?php
// Version 1.0: Rules.template.php

function template_index()
{
	global $context;

	// Which menu are we rendering?
	$context['cur_menu_id'] = isset($context['cur_menu_id']) ? $context['cur_menu_id'] + 1 : 1;
	$menu_context = &$context['menu_data_' . $context['cur_menu_id']];

	echo '
<div class="pagesection" role="application">
	<ul role="menubar" class="buttonlist">';

	foreach ($menu_context['sections'] as $section)
	{
		foreach ($section['areas'] as $i => $area)
		{
			// Not supposed to be printed?
			if (empty($area['label']))
				continue;

			echo '
						<li role="menuitem">
							<a class="linklevel1';

			// Is this the current area, or just some area?
			if ($i == $menu_context['current_area'])
			{
				echo ' active';
			}
			echo '" href="', (isset($area['url']) ? $area['url'] : $menu_context['base_url'] . ';area=' . $i), $menu_context['extra_parameters'], '">', $area['label'], '</a>
					</li>';
		}
	}

	echo '
	</ul>
</div>
	<div class="category_header">
		<h3>
			', $context['page_title'], '
		</h3>
	</div>
	<div class="roundframe">
		', $context['page_contents'], '
	</div>';
}

function template_agreement()
{
 template_index();
}

function template_additional()
{
 template_index();
}
