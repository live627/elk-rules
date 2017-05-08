<?php

/**
 * @package   Rules
 * @version   2.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2011-2016, John Rayes
 * @license   proprietary
 */

namespace live627\Rules\Controllers;

use live627\AddonHelper\Ohara;
use live627\AddonHelper\Controller;
use live627\Rules\DataValidator;
use live627\Rules\Nonce;

class Rules extends Controller
{
    public $name = 'Rules';
    private $util;

    public function __construct($util)
    {
        $this->util = $util;
        parent::__construct(new \Simplex\Container);
        $request = $this->getContainer()->get('requestStack')->getCurrentRequest();
        $request->query->set('sa', $request->query->get('area'));
        $this->container->get('dispatcher')->dispatch($this);
    }

    public function getServiceLayer()
    {
        return $this->util;
    }

    public function actionIndex()
    {
        global $context, $txt;

			$context['page_title'] = $this->setting('display_name') ?: $txt['rules'];
			$context['page_contents'] = !empty($this->setting('text')) ? parse_bbc($this->setting('text')) : $txt['Rules_not_configured'];
    }

    public function actionAgreement()
    {
        global $context, $txt, $user_info,  $language;

			$context['page_title'] = $this->setting('agreement_display_name') ?: $txt['agreement'];

			if(file_exists(BOARDDIR . '/agreement.' . $user_info['language'] . '.txt'))
			$context['page_contents'] = nl2br(htmlspecialchars(file_get_contents(BOARDDIR . '/agreement.' . $user_info['language'] . '.txt'), ENT_COMPAT, 'UTF-8'));
			elseif(file_exists(BOARDDIR . '/agreement.' . $language. '.txt'))
			$context['page_contents'] = nl2br(htmlspecialchars(file_get_contents(BOARDDIR . '/agreement.' . $language . '.txt'), ENT_COMPAT, 'UTF-8'));
			elseif(file_exists(BOARDDIR . '/agreement.txt'))
			$context['page_contents'] = nl2br(htmlspecialchars(file_get_contents(BOARDDIR . '/agreement.txt'), ENT_COMPAT, 'UTF-8'));
			else
			$context['page_contents'] = $txt['Rules_not_configured'];
    }

    public function actionAdditional()
    {
        global $context, $modSettings;

			$context['page_title'] = $this->setting('additional_display_name') ?: $txt['additional'];
			$context['page_contents'] = !empty($this->setting('additional_text')) ? parse_bbc($this->setting('additional_text')) : $txt['Rules_not_configured'];
    }
}
