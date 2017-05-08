<?php

/**
 * @package   Rules
 * @version   2.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2011-2016, John Rayes
 * @license   proprietary
 */

namespace live627\Rules\Models;

class Rules
{
    public function checkAccess(\Symfony\Component\HttpFoundation\Request $request)
    {
            return allowedTo('view_rules');
    }
}
