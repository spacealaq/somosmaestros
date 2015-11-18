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
$tab_autoplay			= $params->get('tab_autoplay', 1);
$tab_duration			= $params->get('tab_duration', 500);
$tab_interval			= $params->get('tab_interval', 5000);
$tab_animation			= $params->get('tab_animation', 'swing');
$tab_direction			= $params->get('tab_direction', 'horizontal');

// Add layout script
$doc->addScript(''.$js_path.'/easing.js');
$doc->addScript(''.$js_path.'/tab.js');
$js = "
	jQuery(document).ready(function($){
		$('#gc-tab-".$module->id."').tab({
			autoPlay: ".$tab_autoplay.",
			duration: ".$tab_duration.",
			interval: ".$tab_interval.",
			animation: '".$tab_animation."',
			direction: '".$tab_direction."'
		});
	});
";
$doc->addScriptDeclaration($js);
?>
<div id="gc-tab-<?php echo $module->id; ?>" class="gc-tab">
	<ul class="gc-title">
	<?php foreach ($list as $item) : ?>
		<?php if ($item->title) : ?>
		<li><a href="#gc-item-<?php echo $item->id; ?>"><?php echo $item->title_name; ?></a></li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>

	<?php foreach ($list as $item) : ?>
	<div id="gc-item-<?php echo $item->id; ?>">
		<div class="gc-item">

			<?php if ($item->image) : ?>
			<div class="gc-image">
				<?php echo $item->image; ?>
			</div>
			<?php endif; ?>

			<?php if ($item->intro) : ?>
			<div class="gc-intro">
				<?php echo $item->intro; ?>
			</div>
			<?php endif; ?>

			<div class="clearfix"></div>

			<?php if ($item->author || $item->date || $item->category || $item->hits || $item->comments || $item->rating || $item->readmore) : ?>
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

				<?php if ($item->readmore) : ?>
				<span class="gc-readmore">
					<?php echo $item->readmore; ?>
				</span><div class="clearfix"></div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

		</div>
	</div>
	<?php endforeach; ?>

</div>