<?php

/**
 * @package   Rules
 * @version   2.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2011-2016, John Rayes
 * @license   proprietary
 */

namespace live627\Rules;

		require_once(SUBSDIR . '/SettingsForm.class.php');
class Settings extends \Settings_Form
{
    /**
     * Configuration variables and values, for this settings form.
     *
     * @var array
     */
    protected $config_vars = [];

    /**
    * @return array
    */
    public function getConfigVars()
    {
    return $this->config_vars;
    }

    /**
    * @param array $config_vars
    */
    public function setConfigVars($config_vars)
    {
    $this->config_vars = $config_vars;
    }

    /**
    * This method saves the settings.
    */
    public function save()
    {
    parent::save_db($this->config_vars);
    }
    public function __construct()
    {
        global $txt;

        foreach ($this->config_vars as &$config_var) {
            if (isset($config_var[1], $txt[$config_var[1].'_desc'])) {
                $config_var['subtext'] = $txt[$config_var[1].'_desc'];
            }
        }
        //~ parent::__construct(parent::DB_ADAPTER);
        //~ parent::setConfigVars($this->config_vars);
    }

    /**
     * This method prepares the settings.
     */
    public function prepare()
    {
        parent::prepare_db($this->config_vars);
        //~ parent::prepare();
    }
}
