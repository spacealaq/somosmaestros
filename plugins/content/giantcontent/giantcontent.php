<?php
/**
 *------------------------------------------------------------------------------
 * @version		1.0.0
 * @package		Giant Content
 *------------------------------------------------------------------------------
 * @copyright	Copyright (C) 2014 GiantTheme. All Rights Reserved.
 * @license     GNU General Public License version 2 only, see LICENSE.txt
 * @author      GiantTheme <support@gianttheme.com> - http://www.gianttheme.com
 *------------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

class plgContentGiantContent extends JPlugin {

	public function onContentPrepare($context, &$article, &$params, $limitstart) {

		// Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer') {
			return true;
		}

		$regex   = '/\{giantcontent-(\d{1,})(.*)\}/i';
		$matches = array();
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);

		if (!empty($matches)) {
			foreach ($matches as $match) {

				$module_id     = $match[1];
				$match_params  = $match[2];
				$module_params = array();

				if (isset($match_params)) {
					$param_match = array();
					preg_match_all('/((\w+)\=(\w+))/i', $match_params, $param_match, PREG_SET_ORDER);
					foreach ($param_match as $pmatch) {
						$module_params[$pmatch[2]] = $pmatch[3];
					}
				}

				$module_output = $this->loadGiantContent($module_id, $module_params);
				$module_output_error = '<div style="color: #a94442; border: 1px solid #ebccd1; padding: 15px; background: #f2dede; border-radius: 4px;"><span>Giant Content plugin can not displaying Giant Content module with ID <strong>'.$module_id.'</strong>, please check Giant Content module ID in the module manager.</span></div>';
				if ($module_output) {
					$article->text = preg_replace($regex, $module_output, $article->text, 1);
				} else {
					$article->text = preg_replace($regex, $module_output_error, $article->text, 1);
				}
			}
		}
	}

	protected function loadGiantContent($module_id, $params) {
		$db = JFactory::getDBO();
		$db->setQuery('SELECT * FROM #__modules WHERE id = '.$module_id.' AND module = "mod_giantcontent" AND published = 1');
		$module = $db->loadObject();

		if ($module) {
			return JModuleHelper::renderModule($module, $params);
		} else {
			return false;
		}
	}
}
