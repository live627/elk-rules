<?php

/**
 * @package   Rules
 * @version   1.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2016, John Rayes
 * @license   proprietary
 */

namespace live627\Rules;

use live627\AddonHelper\Ohara;

class Integration
{
    public static function admin_areas(&$admin_areas)
    {
	global $txt;

        loadLanguage('Rules');
	$admin_areas['config']['areas']['addonsettings']['subsections']['rules'] = array($txt['mods_cat_rules']);
    }

    public static function actions(&$actionArray)
    {
        // Following the action, the action, the action
        // We're following the action wherever it may go
        $actionArray['rules'] = ['BoardIndex.controller.php', __NAMESPACE__.'\\Rules', 'actionIndex'];
    }

    public static function menu_buttons(&$buttons)
    {
	global $txt, $context, $modSettings, $scripturl;

        loadLanguage('Rules');
        $ohara = new Ohara(new \Simplex\Container);
        $ohara->name = 'Rules';
        $buttons['home']['sub_buttons'] = elk_array_insert(
            $buttons['home']['sub_buttons'],
            'help',
            [
                'rules' => [
		'title' => !empty($modSettings['rules_tab_label']) ? $modSettings['rules_tab_label'] : $txt['rules'],
		'href' => $scripturl . '?action=rules',
		'show' => allowedTo('view_rules'),
		'sub_buttons' => array(
			'rules' => array(
				'title' => !empty($modSettings['Rules_display_name']) ? $modSettings['Rules_display_name'] : $txt['rules_title'],
				'href' => $scripturl . '?action=rules',
				'show' => true,
			),
			'agreement' => array(
				'title' => !empty($modSettings['Rules_agreement_display_name']) ? $modSettings['Rules_agreement_display_name'] : $txt['agreement'],
				'href' => $scripturl . '?action=rules;area=agreement',
				'show' => !empty($modSettings['Rules_enable_agreement']),
			),
			'additional' => array(
				'title' => !empty($modSettings['Rules_additional_display_name']) ? $modSettings['Rules_additional_display_name'] : $txt['additional'],
				'href' => $scripturl . '?action=rules;area=additional',
				'show' => !empty($modSettings['Rules_enable_additional']),
			),
		),
                ],
            ],
            'after'
        );
    }

    /**
     * Global permissions used by this mod per user group
     *
     * @param array $permissionGroups An array containing all possible permissions groups.
     * @param array $permissionList   An associative array with all the possible permissions.
     *
     * @return void
     */
    public static function load_permissions(
        &$permissionGroups,
        &$permissionList
    ) {
	$permissionList['membergroup'] += array(
		'view_rules' => array(false, 'general', 'view_basic_info'),
	);
    }

    public static function sa_modify_modifications(&$sub_actions)
{
	$sub_actions['rules'] = [
                    'permission' => ['admin_forum'],
                    'function' => function () {
                        new Controllers\Permissions(new Models\Permissions);
                    },
                ];
    }

    /**
     * @return string[]
     */
    public static function illegal_guest_permissions()
    {
        global $context;

        $context['non_guest_permissions'] = array_merge(
            $context['non_guest_permissions'],
            array('view_rules')
        );
    }
}
