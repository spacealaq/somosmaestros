<?php
/**
 * @copyright	Copyright © 2014 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	hhp://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

// $doc = JFactory::getDocument();
/* Available fields:"tipo","color_sombra","titulo","imagen","texto", */
// $width 			= $params->get("width");

/*
	$db = JFactory::getDBO();
	$db->setQuery("SELECT * FROM #__mod_caja_home where del=0 and module_id=".$module->id);
	$objects = $db->loadAssocList();
*/
require JModuleHelper::getLayoutPath('mod_caja_home', $params->get('layout', 'default'));