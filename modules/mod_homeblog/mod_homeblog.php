<?php
/**
 * @copyright	Copyright © Emerald Studio 2015 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	hhp://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

// $doc = JFactory::getDocument();
// $width 			= $params->get("width");

	$db = JFactory::getDBO();
	$query='SELECT * FROM #__somosmaestros_blogs WHERE publico = 1 AND destacado = 1 LIMIT 3';
	$db->setQuery($query);
	$listaBlogsPub = $db->loadObjectList();


require JModuleHelper::getLayoutPath('mod_homeblog', $params->get('layout', 'default'));