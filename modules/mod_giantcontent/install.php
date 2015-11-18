<?php
/**
 *------------------------------------------------------------------------------
 * @version		1.1.1
 * @package		Giant Content
 *------------------------------------------------------------------------------
 * @copyright	Copyright (C) 2014 GiantTheme. All Rights Reserved.
 * @license     GNU General Public License version 2 only, see LICENSE.txt
 * @author      GiantTheme <support@gianttheme.com> - http://www.gianttheme.com
 *------------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

class mod_giantcontentInstallerScript {
	function preflight($type, $parent) {
		$this->installGiantExtensionsPlugin();
		$type = strtolower($type);
		if ($type == 'install' || $type == 'update')
			$this->updateManifest($parent);
	}

	function postflight($type, $parent) {
		$type = strtolower($type);
		if ($type == 'install' || $type == 'update')
			$this->deleteHelpManifest($parent);
	}

	private function updateManifest($parent) {
		jimport('joomla.filesystem.file');
		$installer         = $parent->getParent();
		$manifestFile      = basename($installer->getPath('manifest'));
		$cleanManifestFile = preg_replace('/^\_+/i', '', $manifestFile);
		$dir               = dirname(__FILE__) . '/mod_giantcontent/';
		JFile::delete($dir . $cleanManifestFile);
		JFile::copy($dir . '../' . $cleanManifestFile, $dir . $cleanManifestFile);
	}

	private function deleteHelpManifest($parent) {
		jimport('joomla.filesystem.file');
		$installer    = $parent->getParent();
		$manifestFile = basename($installer->getPath('manifest'));
		JFile::delete(JPATH_ROOT . '/modules/mod_giantcontent/' . $manifestFile);
	}

	private function installGiantExtensionsPlugin() {
		$pluginPath    = dirname(__FILE__) . '/plg_content_giantcontent.zip';
		$installResult = JInstallerHelper::unpack($pluginPath);

		if (empty($installResult)) {
			$app = JFactory::getApplication();
			$app->enqueueMessage('Giant Content can not install "Content - Giant Content" plugin. Please install plugin manually inside package.', 'error');
			return false;
		}

		$installer = new JInstaller();
		$installer->setOverwrite(true);

		if (!$installer->install($installResult['extractdir'])) {
			$app = JFactory::getApplication();
			$app->enqueueMessage('Giant Content can not install "Content - Giant Content" plugin. Please install plugin manually inside package.', 'error');
			return false;
		}

		$db = JFactory::getDBO();
		$db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE type = "plugin" AND folder = "content" AND element = "giantcontent"');
		$db->query();

		if ($db->getErrorNum()) {
			$app = JFactory::getApplication();
			$app->enqueueMessage('Giant Content can not enable "Content - Giant Content" plugin. Please enable plugin manually in the plugin manager.', 'warning');
		}

		return true;
	}
}