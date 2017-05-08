<?php
// Version 1.0: Rules.php

if (!defined('SMF'))
	die('Hacking attempt...');

function Rules()
{
	global $boarddir, $context, $modSettings, $scripturl, $settings, $sourcedir, $txt;

	isAllowedTo('view_rules');

	$context['current_page'] = isset($_REQUEST['area']) ? $_REQUEST['area'] : 'rules';

	switch ($context['current_page'])
	{
		case 'agreement':
			$context['page_title'] = !empty($modSettings['Rules_agreement_display_name']) ? $modSettings['Rules_agreement_display_name'] : $txt['agreement'];
			$context['page_contents'] = file_exists($boarddir . '/agreement.txt') ? parse_bbc(file_get_contents($boarddir . '/agreement.txt')) : $txt['Rules_not_configured'];
			break;

		case 'additional':
			$context['page_title'] = !empty($modSettings['Rules_additional_display_name']) ? $modSettings['Rules_additional_display_name'] : $txt['additional'];
			$context['page_contents'] = !empty($modSettings['Rules_additional_text']) ? parse_bbc($modSettings['Rules_additional_text']) : $txt['Rules_not_configured'];
			break;

		case 'rules':
		default:
			$context['page_title'] = !empty($modSettings['Rules_display_name']) ? $modSettings['Rules_display_name'] : $txt['rules'];
			$context['page_contents'] = !empty($modSettings['Rules_text']) ? parse_bbc($modSettings['Rules_text']) : $txt['Rules_not_configured'];
	}

	require_once($sourcedir . '/Subs-Menu.php');

	// Define all the menu structure - see Subs-Menu.php for details!
	$rules_areas = array(
		'forum' => array(
			'title' => !empty($modSettings['Rules_display_name']) ? $modSettings['Rules_display_name'] : $txt['rules'],
			'areas' => array(
				'rules' => array(
					'label' => !empty($modSettings['Rules_display_name']) ? $modSettings['Rules_display_name'] : $txt['rules'],
					'enabled' => true,
				),
				'agreement' => array(
					'label' => !empty($modSettings['Rules_agreement_display_name']) ? $modSettings['Rules_agreement_display_name'] : $txt['agreement'],
					'enabled' => !empty($modSettings['Rules_enable_agreement']),
				),
				'additional' => array(
					'label' => !empty($modSettings['Rules_additional_display_name']) ? $modSettings['Rules_additional_display_name'] : $txt['additional'],
					'enabled' => !empty($modSettings['Rules_enable_additional']),
				),
			),
		),
	);
	$menuOptions = array(
		'disable_url_session_check' => true,
	);

	// Any files to include?
	if (!empty($modSettings['integrate_rules_include']))
	{
		$rules_includes = explode(',', $modSettings['integrate_rules_include']);
		foreach ($rules_includes as $include)
		{
			$include = strtr(trim($include), array('$boarddir' => $boarddir, '$sourcedir' => $sourcedir, '$themedir' => $settings['theme_dir']));
			if (file_exists($include))
				require_once($include);
		}
	}

	// Let them modify rules areas easily.
	call_integration_hook('integrate_rules_areas', array(&$rules_areas));

	// Actually create the menu!
	$rules_include_data = createMenu($rules_areas, $menuOptions);
	unset($rules_areas);

	// Nothing valid?
	if ($rules_include_data == false)
		fatal_lang_error('no_access', false);

	// Build the link tree.
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=rules',
		'name' => !empty($modSettings['Rules_display_name']) ? $modSettings['Rules_display_name'] : $txt['rules'],
	);
	if (isset($rules_include_data['current_area']) && $rules_include_data['current_area'] != 'rules')
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=rules;area=' . $rules_include_data['current_area'],
			'name' => $rules_include_data['label'],
		);

	loadTemplate('Rules');
}

?>