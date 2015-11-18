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

jimport('joomla.form.formfield');

class JFormFieldUsers extends JFormField {
	protected $type = 'Users';

	function getInput() {
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query
			->select('u.id, u.name')
			->from('#__users AS u')
			->order('name ASC');

		$db->setQuery($query);
		$rows	= $db->loadObjectList();

		$attr	= '';
		$attr	.= $this->multiple ? 'multiple="multiple"' : '';
		$attr	.= $this->element['size'] ? 'size="'.$this->element['size'].'"' : '';
		$attr	.= $this->element['class'] ? 'class="'.$this->element['class'].'"' : '';

		return JHtml::_('select.genericlist', $rows, $this->name, $attr, 'id', 'name', $this->value, $this->id);
	}
}