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
$accordion_autoplay		= $params->get('accordion_autoplay', 0);
$accordion_duration		= $params->get('accordion_duration', 500);
$accordion_interval		= $params->get('accordion_interval', 5000);
$accordion_animation	= $params->get('accordion_animation', 'swing');
$accordion_startslide	= $params->get('accordion_startslide', 1);
$accordion_width		= $params->get('accordion_width', 'auto');
$accordion_height		= $params->get('accordion_height', 'auto');
$accordion_direction	= $params->get('accordion_direction', 'horizontal');

// Add layout script
$doc->addScript(''.$js_path.'/easing.js');
$doc->addScript(''.$js_path.'/accordion.js');
$js = "
	jQuery(document).ready(function($){
		$('#gc-accordion-".$module->id."').accordion({
			autoPlay: ".$accordion_autoplay.",
			duration: ".$accordion_duration.",
			interval: ".$accordion_interval.",
			animation: '".$accordion_animation."',
			startSlide: ".$accordion_startslide."
		});
	});
";
$doc->addScriptDeclaration($js);
?>
<ul id="gc-accordion-<?php echo $module->id; ?>" class="gc-accordion <?php echo $accordion_direction; ?>" style="width: <?php echo $accordion_width; ?>; height: <?php echo $accordion_height; ?>;">
	<?php foreach ($list as $item) : ?>
	<li class="gc-item">

		<?php if ($item->title) : ?>
		<div class="gc-title">
			<?php echo $item->title_name; ?>
		</div>
		<?php endif; ?>

		<div class="gc-content">
			<?php if ($item->image) : ?>
			<div class="gc-image">
				<?php echo $item->image; ?>
			</div>
			<?php endif; ?>

			<?php if ($item->author || $item->date || $item->category || $item->hits || $item->comments || $item->rating || $item->intro) : ?>
			<div class="gc-caption">
				<div class="gc-padding">

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

	</li>
	<?php endforeach; ?>    
</ul>