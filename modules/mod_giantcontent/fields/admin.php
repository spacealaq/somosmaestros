<?php
/**
 *------------------------------------------------------------------------------
 * @version		1.1.0
 * @package		Giant Content
 *------------------------------------------------------------------------------
 * @copyright	Copyright (C) 2014 GiantTheme. All Rights Reserved.
 * @license     GNU General Public License version 2 only, see LICENSE.txt
 * @author      GiantTheme <support@gianttheme.com> - http://www.gianttheme.com
 *------------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldAdmin extends JFormField {
	protected $type = 'Admin';

	protected function getInput() {
		$doc = JFactory::getDocument();

		$doc->addStyleSheet('../modules/mod_giantcontent/admin/css/admin.css');
		$doc->addScript('../modules/mod_giantcontent/admin/js/admin.js');

		return '<div class="gc-admin"></div>';
	}

	protected function getLabel() {
		return '<div class="gc-admin"></div>';
	}
}