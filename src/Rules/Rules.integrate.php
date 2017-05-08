<?php

/**
 * @package   Rules
 * @version   1.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2016, John Rayes
 * @license   proprietary
 */
class Rules_Integrate
{
    protected static $fqcn = 'live627\\Rules\\Integration';

    /**
     * Register hooks to the system
     *
     * @return array
     */
    public static function registerAll()
    {
foreach (array_merge(self::register(),self::settingsRegister()) as list($hook, $function))
	add_integration_function($hook, $function,'',false);
    }

    /**
     * Register hooks to the system
     *
     * @return array
     */
    public static function register()
    {
        // Hello Composer, my old friend. It's nice to be with you again.
        require_once __DIR__.'/vendor/autoload.php';

        // $hook, $function, $file
        return [
            ['integrate_actions', self::$fqcn.'::actions'],
            ['integrate_menu_buttons', self::$fqcn.'::menu_buttons'],
        ];
    }

    /**
     * Register ACP config hooks for setting values
     *
     * @return array
     */
    public static function settingsRegister()
    {
        // $hook, $function, $file
        return [
            ['integrate_admin_areas', self::$fqcn.'::admin_areas'],
            ['integrate_load_permissions', self::$fqcn.'::load_permissions'],
            ['integrate_sa_modify_modifications', self::$fqcn.'::sa_modify_modifications'],
            ['integrate_load_illegal_guest_permissions', self::$fqcn.'::illegal_guest_permissions'],
        ];
    }
}
