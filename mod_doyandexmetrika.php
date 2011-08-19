<?php
/**
 * @version	1.1.0
 * @package	Joomla.Site
 * @subpackage  mod_doyandexmetrika
 * @author	Sergey Donin
 * @author mail	dostrog@gmail.com	
 * @copyright	Copyright (C) 2011 Open Source Matters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once(dirname(__FILE__).DS.'helper.php');

// get a code-injection
$inject = ModDoyandexmetrikaHelper::getCode($params);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_doyandexmetrika', $params->get('layout', 'default'));
