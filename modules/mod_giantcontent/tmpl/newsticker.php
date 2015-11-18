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

// Add parameters
$newsticker_control = $params->get('newsticker_control', 1);
$newsticker_visible = $params->get('newsticker_visible', 3);
$newsticker_duration = $params->get('newsticker_duration', 500);
$newsticker_interval = $params->get('newsticker_interval', 5000);
$newsticker_animation = $params->get('newsticker_animation', 'swing');
$newsticker_direction = $params->get('newsticker_direction', 'down');

// Add layout script
$doc->addScript(''.$js_path.'/easing.js');
$doc->addScript(''.$js_path.'/newsticker.js');
$js = "
	jQuery(document).ready(function($) {
		$('#gc-newsticker-".$module->id."').newsticker({
			visible: ".$newsticker_visible.",
			duration: ".$newsticker_duration.",
			interval: ".$newsticker_interval.",
			animation: '".$newsticker_animation."',
			direction: '".$newsticker_direction."',
			controls: {
				up: '#gc-up-".$module->id."',
				down: '#gc-down-".$module->id."',
				toggle: '#gc-toggle-".$module->id."'
			}
		});
	});
";
$doc->addScriptDeclaration($js);
?>
<?php if ($newsticker_control) : ?>
<div class="gc-controls">
	<a href="#" id="gc-toggle-<?php echo $module->id; ?>" class="control-toggle"></a>
	<a href="#" id="gc-up-<?php echo $module->id; ?>" class="control-up"></a>
	<a href="#" id="gc-down-<?php echo $module->id; ?>" class="control-down"></a>
</div><div class="clearfix"></div>
<?php endif; ?>
<div id="gc-newsticker-<?php echo $module->id; ?>" class="gc-newsticker">
	<div class="gc-items">
		<?php foreach ($list as $item) : ?>
		<div class="gc-item">

			<?php if ($item->image) : ?>
			<div class="gc-image">
				<?php echo $item->image; ?>
			</div>
			<?php endif; ?>

			<?php if ($item->title) : ?>
			<div class="gc-title">
				<?php echo $item->title; ?>
			</div>
			<?php endif; ?>

			<?php if ($item->author || $item->date || $item->category || $item->hits || $item->comments || $item->rating) : ?>
			<div class="gc-info">
				<?php if ($item->author) : ?>
				<span class="gc-author">
					<?php echo $item->author; ?>
				</span>
				<?php endif; ?>

				<?php if ($item->date) : ?>
				<span class="gc-date">
					<?php echo $item->date; ?>
				</span>
				<?php endif; ?>

				<?php if ($item->category) : ?>
				<span class="gc-category">
					<?php echo $item->category; ?>
				</span>
				<?php endif; ?>

				<?php if ($item->hits) : ?>
				<span class="gc-hits">
					<?php echo $item->hits; ?>
				</span>
				<?php endif; ?>

				<?php if ($item->comments) : ?>
				<span class="gc-comments">
					<?php echo $item->comments; ?>
				</span>
				<?php endif; ?>

				<?php if ($item->rating) : ?>
				<span class="gc-rating">
					<?php echo $item->rating; ?>
				</span>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if ($item->intro) : ?>
			<div class="gc-intro">
				<?php echo $item->intro; ?>
				<?php if ($item->readmore) : ?>
				<span class="gc-readmore">
					<?php echo $item->readmore; ?>
				</span>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="clearfix"></div>
		</div>
		<?php endforeach; ?>
	</div>
</div>