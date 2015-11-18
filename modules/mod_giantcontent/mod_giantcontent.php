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

$doc	= JFactory::getDocument();
$app	= JFactory::getApplication();
$type	= $params->get('type', 'joomla');

// Hide module on content
if ($type == 'k2' && $params->get('hide_module', 1)) {
	if ($app->input->getCmd('option') == 'com_k2' && $app->input->getCmd('view') == 'item') {
		return;
	}
} else if ($type == 'joomla' && $params->get('hide_module', 1)) {
	if ($app->input->getCmd('option') == 'com_content' && $app->input->getCmd('view') == 'article') {
		return;
	}
} else if ($type == 'easyblog' && $params->get('hide_module', 1)) {
	if ($app->input->getCmd('option') == 'com_easyblog' && $app->input->getCmd('view') == 'entry') {
		return;
	}
}

// Helper file
require_once 'modules/mod_giantcontent/assets/libraries/helpers/'.$type.'.php';

// Less compiler
require_once 'modules/mod_giantcontent/assets/libraries/includes/lessc.php';
$less	= new GiantContentCompiler;

// Get layout name
$layout				= $params->get('layout', 'blog');
$layout_name		= explode(':', $layout);
$layout_name		= $layout_name[1];

// Get current template
$template			= 'templates/'.$app->getTemplate();

// Module js and css path
$js_path			= 'modules/mod_giantcontent/assets/js';
$css_path			= 'modules/mod_giantcontent/assets/css';
$less_path			= 'modules/mod_giantcontent/assets/less';

// Template js and css path
$js_tmpl			= $template.'/html/mod_giantcontent/js';
$css_tmpl			= $template.'/html/mod_giantcontent/css';
$less_tmpl			= $template.'/html/mod_giantcontent/less';

// General module parameters
$preloader			= $params->get('preloader', 0);
$preloader_fade		= $params->get('preloader_fade', 500);
$preloader_delay	= $params->get('preloader_delay', 500);
$shadowbox			= $params->get('shadowbox', 0);
$fontawesome		= $params->get('fontawesome', 1);
$custom_top_text	= $params->get('custom_top_text', '');
$custom_top_link	= $params->get('custom_top_link', '');
$custom_bottom_text	= $params->get('custom_bottom_text', '');
$custom_bottom_link	= $params->get('custom_bottom_link', '');

// Add preloader
if ($preloader) {
	$doc->addScript(''.$js_path.'/preloader.js');
	$js = "
		jQuery(document).ready(function($){
			$('#giantcontent-".$module->id." .gc-image').preloader({
				fadeIn: ".$preloader_fade.",
				imageDelay: ".$preloader_delay."
			});
		});
	";
	$doc->addScriptDeclaration($js);
}

// Add shadowbox
if ($shadowbox) {	
	$doc->addScript(''.$js_path.'/shadowbox.js');
	$doc->addScript(''.$js_path.'/shadowinit.js');
	$doc->addStyleSheet(''.$css_path.'/shadowbox.css');
}

// Add font awesome
if ($fontawesome) {
	$doc->addStyleSheet(''.$css_path.'/fontawesome.css');
}

// Add and compile general style
$doc->addStyleSheet($css_path.'/giantcontent.css');
$less->checkedCompile($less_path.'/giantcontent.less', $css_path.'/giantcontent.css');

// Add and compile module layout style
if (JFile::exists($css_tmpl.'/layout-'.$layout_name.'.css')) {
	$doc->addStyleSheet($css_tmpl.'/layout-'.$layout_name.'.css');
} else if (JFile::exists($less_tmpl.'/layout-'.$layout_name.'.less')) {
	JFolder::create($css_tmpl);

	$less_input		= $less_tmpl.'/layout-'.$layout_name.'.less';
	$less_output	= $css_tmpl.'/layout-'.$layout_name.'.css';

	$less->checkedCompile($less_input, $less_output);
	$doc->addStyleSheet($css_tmpl.'/layout-'.$layout_name.'.css');
} else {
	$less_input		= $less_path.'/layout-'.$layout_name.'.less';
	$less_output	= $css_path.'/layout-'.$layout_name.'.css';	

	$less->checkedCompile($less_input, $less_output);
	$doc->addStyleSheet($css_path.'/layout-'.$layout_name.'.css');
}

if ($type == 'k2') {
	$list = ModGiantContentK2::getList($params);
} else if ($type == 'easyblog') {
	$list = ModGiantContentEasyBlog::getList($params);
} else {
	$list = ModGiantContentJoomla::getList($params);
}
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

if ($list) {
	echo '<div id="giantcontent-'.$module->id.'" class="giantcontent type-'.$type.' layout-'.$layout_name.' '.$moduleclass_sfx.' clearfix">';

	// Custom top text
	if ($custom_top_text && $custom_top_link) {
		echo '<div class="gc-top-text"><a href="'.$custom_top_link.'"><span>'.$custom_top_text.'</span></a></div>';
	} else if ($custom_top_text) {
		echo '<div class="gc-top-text"><span>'.$custom_top_text.'</span></div>';
	}

	require JModuleHelper::getLayoutPath('mod_giantcontent', $layout);

	// Custom bottom text
	if ($custom_bottom_text && $custom_bottom_link) {
		echo '<div class="gc-bottom-text"><a href="'.$custom_bottom_link.'"><span>'.$custom_bottom_text.'</span></a></div>';
	} else if ($custom_bottom_text) {
		echo '<div class="gc-bottom-text"><span>'.$custom_bottom_text.'</span></div>';
	}

	echo '</div>';
}