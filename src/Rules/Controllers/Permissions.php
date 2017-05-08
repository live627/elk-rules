<?php

/**
 * @package   Rules
 * @version   2.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2011-2016, John Rayes
 * @license   proprietary
 */

namespace live627\Rules\Controllers;

use live627\AddonHelper\Controller;
use live627\Rules\Models\PermissionsSettings;

class Permissions extends Controller
{
    public $name = 'RulesPermissions';
    private $util;
    protected $url = 'action=admin;area=addonsettings;sa=rules';

    /**
     * @var PermissionsSettings
     */
    protected $settings;

    public function __construct($util)
    {
        $this->util = $util;

        parent::__construct(new \Simplex\Container);
        $this->container->get('dispatcher')->dispatch($this);
    }

    public function getServiceLayer()
    {
        return $this->util;
    }

    /**
     * A screen to set some general settings for permissions.
     */
    public function actionIndex()
    {
        global $context, $modSettings, $txt, $scripturl;

        $this->settings = new PermissionsSettings;
        $context['sub_template'] = 'show_settings';
        $context['post_url'] = $this->scriptUrl.'?'.$this->url.';save';
        //~ $context['permissions_excluded'] = array(-1);

        // Saving the settings?
        if ($this->request->query->has('save')) {
            checkSession('post');
            $this->settings->save();

            redirectexit($this->url);
        }

        // We need this for the in-line permissions
        createToken('admin-mp');

        $this->settings->prepare();
    }
}
