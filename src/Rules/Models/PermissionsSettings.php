<?php

/**
 * @package   Rules
 * @version   2.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2011-2016, John Rayes
 * @license   proprietary
 */

namespace live627\Rules\Models;

use live627\Rules\Settings;

class PermissionsSettings extends Settings
{
    /**
     * Configuration variables and values, for this settings form.
     *
     * @var array
     */
    protected $config_vars = [
		array('text', 'rules_tab_label', '20'),
	'',
		array('text', 'Rules_display_name', '20'),
		array('large_text', 'Rules_text', '12'),
	'',
		array('check', 'Rules_enable_agreement'),
		array('text', 'Rules_agreement_display_name', '20'),
	'',
		array('check', 'Rules_enable_additional'),
		array('text', 'Rules_additional_display_name', '20'),
		array('large_text', 'Rules_additional_text', '12'),
    ];

    function __construct()
    {
        global $scripturl, $txt;

        //~ // We'll need this for loading up the names of each group.
        //~ loadLanguage('ManageBoards');
        //~ $groups = [0 => $txt['parent_members_only']];

        //~ // Load them... load them!!
        //~ require_once(SUBSDIR.'/Membergroups.subs.php');
        //~ $groups += accessibleGroups();

        //~ $this->config_vars[2][2] = $groups;
        $this->config_vars[6][ 'postinput' ]= $txt['Rules_edit_agreement_pre_html'] . $scripturl .
			'?action=admin;area=regcenter;sa=agreement">' . $txt['Rules_edit_name'] . $txt['Rules_edit_agreement_post_html'];

        parent::__construct();
    }
}
