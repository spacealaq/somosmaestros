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

if (JFile::exists(JPATH_SITE.'/components/com_k2/k2.php')) {
	class JFormFieldK2Categories extends JFormField {
		protected $type = 'K2Categories';

		function getInput() {
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query
				->select('c.id, c.name, c.parent')
				->from('#__k2_categories AS c')
				->where('trash = 0')
				->order('parent, ordering');

			$db->setQuery($query);
			$list = $db->loadAssocList();

			$rows = array();
			$children = array();

			foreach ($list as $c) {
				$children[$c['parent']][] = $c;
			}

			$tree = self::checkParent(0, '', array(), $children, 9999, 0);

			$rows[] = JHTML::_('select.option', '', JText::_('JOPTION_ALL_CATEGORIES'));
			foreach ($tree as $item) {
				$rows[] = JHTML::_('select.option',  $item['id'], $item['tree'] );
			}

			$attr	= '';
			$attr	.= $this->multiple ? ' multiple="multiple"' : '';
			$attr	.= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
			$attr	.= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';

			return JHTML::_('select.genericlist', $rows, $this->name, $attr, 'value', 'text', $this->value, $this->id);
		}

		function checkParent($id, $indent, $list, &$children, $maxlevel = 9999, $level = 0) {
			if (@$children[$id] && $level <= $maxlevel) {
				foreach ($children[$id] as $v) {
					$id = $v['id'];
					$list[$id] = $v;
					$list[$id]['tree'] = ($v['parent'] == 0) ? $v['name'] : $indent.$v['name'];

					$list = self::checkParent($id, $indent.'-&nbsp;', $list, $children, $maxlevel, $level + 1);
				}
			}
			return $list;
		}
	}
} else {
	class JFormFieldK2Categories extends JFormField {
		protected $type = 'K2Categories';

		protected function getInput() {
			return null;
		}

		protected function getLabel() {
			return '<div id="'.$this->id.'" class="gc-caption caption-error"><span>'.JText::_('MOD_GIANTCONTENT_CAPTION_WARNING_K2').'</span></div>';
		}
	}
}