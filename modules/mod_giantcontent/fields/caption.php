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

class JFormFieldCaption extends JFormField {
	protected $type = 'Caption';

	protected function getInput() {
		return null;
	}

	protected function getLabel() {
		$label = $this->element['label'] ? $this->element['label'] : '';
		$class = $this->element['class'] ? $this->element['class'] : '';
		$description = $this->element['description'] ? $this->element['description'] : '';

		return '
			<div id="'.$this->id.'" class="gc-caption '.$class.'">
				<div class="gc-name"><span>'.JText::_($label).'</span></div>
				'.($description ? '<div class="gc-description"><span>'.JText::_($description).'</span></div>' : '').'
			</div>
		';
	}
}