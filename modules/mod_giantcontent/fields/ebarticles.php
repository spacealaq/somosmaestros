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

if (JFile::exists(JPATH_SITE.'/components/com_easyblog/easyblog.php')) {
	class JFormFieldEBArticles extends JFormField {
		protected $type = 'EBArticles';

		function getInput() {
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query
				->select('a.id, a.title')
				->from('#__easyblog_post AS a')
				->where('published = 1')
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
} else {
	class JFormFieldEBArticles extends JFormField {
		protected $type = 'EBArticles';

		protected function getInput() {
			return null;
		}

		protected function getLabel() {
			return '<div id="'.$this->id.'" class="gc-caption caption-error"><span>'.JText::_('MOD_GIANTCONTENT_CAPTION_WARNING_EASYBLOG').'</span></div>';
		}
	}
}