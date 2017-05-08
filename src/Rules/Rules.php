<?php

/**
 * @package   Rules
 * @version   2.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2011-2016, John Rayes
 * @license   proprietary
 */

namespace live627\Rules;

use live627\AddonHelper\Controller;
use live627\AddonHelper\Menu;
use live627\AddonHelper\MenuArea;
use live627\AddonHelper\MenuSection;
use live627\AddonHelper\MenuSubsection;

class Rules extends Controller
{
    public $name = 'Rules';

    public function __construct()
    {
        // Hey man, what happened? /stoner voice
        parent::__construct(new \Simplex\Container);
    }

    public function getServiceLayer()
    {
        return $this->util;
    }

    public function actionIndex()
    {
        global $db_show_debug, $context, $modSettings, $txt;

        $menu = (new Menu($this))->addSection(
            'rules',
            MenuSection::buildFromArray(
                [
                    'title' => $this->text('title'),
                    'permission' => ['view_rules'],
                    'areas' => [
				'rules' =>  MenuArea::buildFromArray(array(
					'label' => !empty($modSettings['Rules_display_name']) ? $modSettings['Rules_display_name'] : $txt['rules'],
					'enabled' => true,
                                'function' => function () {
                                    new Controllers\Rules(new Models\Rules);
                                },
				)),
				'agreement' =>  MenuArea::buildFromArray( array(
					'label' => !empty($modSettings['Rules_agreement_display_name']) ? $modSettings['Rules_agreement_display_name'] : $txt['agreement'],
					'enabled' => !empty($modSettings['Rules_enable_agreement']),
                                'function' => function () {
                                    new Controllers\Rules(new Models\Rules);
                                },
				)),
				'additional' =>  MenuArea::buildFromArray( array(
					'label' => !empty($modSettings['Rules_additional_display_name']) ? $modSettings['Rules_additional_display_name'] : $txt['additional'],
					'enabled' => !empty($modSettings['Rules_enable_additional']),
                                'function' => function () {
                                    new Controllers\Rules(new Models\Rules);
                                },
				)),] ]
                        )
        );
        $menu->addOption('disable_url_session_check', true);
        $menu->addOption('hook', 'rules');
        $menu->addOption('layer_name', 'no_menu');
        try {
            $menu->execute();
        } catch (\Exception $e) {
            if (isset($db_show_debug) && $db_show_debug === true)
            fatal_error(nl2br($e), false);
            else
            fatal_error($e->getMessage(), false);
        }
    }

    /**
     * Noise.
     *
     * @access public
     * @abstracting \Action_Controller
     * @return void
     */
    public function action_index()
    {
    }

    /**
     * More noise.
     *
     * @access public
     * @return void
     */
    public function pre_dispatch()
    {
    }

    /**
     * Returns the name of the hook for the dispatcher to call.
     *
     * @access public
     * @return string
     */
    public function getHook()
    {
        return 'rules';
    }
}
