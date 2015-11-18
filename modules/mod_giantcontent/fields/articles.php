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

class JFormFieldArticles extends JFormField {
	protected $type = 'Articles';

	function getInput() {
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query
			->select('a.id, a.title')
			->from('#__content AS a')
			->where('state = 1')
			->order('title ASC');

		$db->setQuery($query);
		$rows	= $db->loadObjectList();

		$attr	= '';
		$attr	.= $this->multiple ? 'multiple="multiple"' : '';
		$attr	.= $this->element['size'] ? 'size="'.$this->element['size'].'"' : '';
		$attr	.= $this->element['class'] ? 'class="'.$this->element['class'].'"' : '';

		return JHtml::_('select.genericlist', $rows, $this->name, $attr, 'id', 'title', $this->value, $this->id);
	}
}