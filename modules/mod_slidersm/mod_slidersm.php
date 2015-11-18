<?php
/**
 * @copyright	Copyright © Emerald Studio 2015 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	hhp://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

   $doc = JFactory::getDocument();
// $width 			= $params->get("width");


	$db = JFactory::getDBO();
	$query='SELECT * FROM #__somosmaestros_slider_publico WHERE state = 1 LIMIT 4';
	$db->setQuery($query);
	$listadoSliderPub = $db->loadObjectList();


require JModuleHelper::getLayoutPath('mod_slidersm', $params->get('layout', 'default'));
?>


<script type="text/javascript">
</script>