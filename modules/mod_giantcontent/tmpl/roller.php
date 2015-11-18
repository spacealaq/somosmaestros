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
$roller_autoplay		= $params->get('roller_autoplay', 1);
$roller_duration		= $params->get('roller_duration', 1000);
$roller_interval		= $params->get('roller_interval', 5000);
$roller_animation		= $params->get('roller_animation', 'swing');
$roller_navigation		= $params->get('roller_navigation', 1);
$roller_pagination		= $params->get('roller_pagination', 1);

// Add layout script
$doc->addScript(''.$js_path.'/easing.js');
$doc->addScript(''.$js_path.'/roller.js');
$js = "
	jQuery(document).ready(function($){
		var roll = new roller ({
			items: '#gc-roller-".$module->id."',
			autoPlay: ".$roller_autoplay.",
			duration: ".$roller_duration.",
			interval: ".$roller_interval.",
			animation: '".$roller_animation."',
			navigation: ".$roller_navigation.",
			pagination: ".$roller_pagination.",
			startHeight: ".$params->get('image_height')."
		});
	});
";
$doc->addScriptDeclaration($js);
?>
<div id="gc-roller-<?php echo $module->id; ?>" class="gc-roller">
	<?php foreach ($list as $item) : ?>
	<div class="gc-item">

		<?php if ($item->image) : ?>
		<div class="gc-image">
			<?php echo $item->image; ?>
		</div>
		<?php endif; ?>

		<?php if ($item->author || $item->date || $item->category || $item->hits || $item->comments || $item->rating || $item->intro) : ?>
		<div class="gc-caption">
			<div class="gc-padding">

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

			</div>
		</div>
		<?php endif; ?>

	</div>
	<?php endforeach; ?>
</div>