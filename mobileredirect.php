<?php
/**
 * @Enterprise: Bandhosting.nl
 * @author: bandhosting.nl
 * @url: http://www.bandhosting.nl
 * @license: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @copyright: bandhosting.nl
 *
 * Mobile redirect plugin using the Mobile-Detect Library:
 * https://github.com/serbanghita/Mobile-Detect
 * License: MIT License 
 */
defined('_JEXEC') or die;

class plgSystemMobileredirect extends JPlugin
{
	public function onAfterInitialise()
	{
		# include our library
		require_once 'libs/Mobile_Detect/Mobile_Detect.php';

		# init class
		$detect = new Mobile_Detect;
		
		# get application
		$app = JFactory::getApplication();
		
		# see if cookie is set 
		$skip_mobile_redirect = $app->input->cookie->get('smr', 0, 'int');
		
		# see if redirect should be skipped?
		if($app->input->get('smr') == 1)
		{
			$_COOKIE['smr'] = $skip_mobile_redirect = 1;
		}
		
		# if this is not a mobile device, redirect to url
		if($detect->isMobile() && $skip_mobile_redirect == 0)
		{
			$app->redirect($this->params->get('url'), 301);
		}
	}
}