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
$mosaic_width			= $params->get('mosaic_width', 200);
$mosaic_animate			= $params->get('mosaic_animate', 1);
$mosaic_gutterx			= $params->get('mosaic_gutterx', 20);
$mosaic_guttery			= $params->get('mosaic_guttery', 20);

// Add layout script
$doc->addScript(''.$js_path.'/freewall.js');
$js = "
	jQuery(document).ready(function($) {
		var wall = new freewall('#gc-mosaic-".$module->id."');
		wall.reset({
			cellW: ".$mosaic_width.",
			cellH: 'auto',
			animate: ".$mosaic_animate.",
			gutterX: ".$mosaic_gutterx.",
			gutterY: ".$mosaic_guttery.",
			selector: '.gc-item',
			onResize: function() {
				wall.refresh();
			}
		});
		wall.fitWidth();
	});
";
$doc->addScriptDeclaration($js);
?>
<div id="gc-mosaic-<?php echo $module->id; ?>" class="gc-mosaic">
	<?php foreach ($list as $item) : ?>
	<div class="gc-item" style="width: <?php echo $mosaic_width; ?>px">

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

		<?php if ($item->author || $item->date || $item->category) : ?>
		<div class="gc-info-top">
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
		</div>
		<?php endif; ?>

		<?php if ($item->intro) : ?>
		<div class="gc-intro">
			<?php echo $item->intro; ?>
		</div>
		<?php endif; ?>

		<?php if ($item->hits || $item->comments || $item->rating) : ?>
		<div class="gc-info-bottom">
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

		<?php if ($item->readmore) : ?>
		<div class="gc-readmore">
			<?php echo $item->readmore; ?>
		</div>
		<?php endif; ?>

	</div>
	<?php endforeach; ?>
</div>