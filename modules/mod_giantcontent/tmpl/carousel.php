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
$carousel_items			= $params->get('carousel_items', 4);
$carousel_autoplay		= $params->get('carousel_autoplay', 1);
$carousel_interval		= $params->get('carousel_interval', 5000);
$carousel_duration		= $params->get('carousel_duration', 500);
$carousel_animation		= $params->get('carousel_animation', 'swing');
$carousel_navigation	= $params->get('carousel_navigation', 1);
$carousel_pagination	= $params->get('carousel_pagination', 1);
$carousel_singleitem	= $params->get('carousel_singleitem', 0);
$carousel_scrollperpage	= $params->get('carousel_scrollperpage', 0);

// Add layout script
$doc->addStyleSheet(''.$css_path.'/bxslider.css');
$doc->addScript(''.$js_path.'/easing.js');
$doc->addScript(''.$js_path.'/bxslider.js');
$js = "
	jQuery(document).ready(function($){
		jQuery('#gc-carousel-".$module->id."').bxSlider({
			minSlides: 3,
			maxSlides: 3,
			slideWidth: 340,
			slideMargin: 10,
			pager:false,
			moveSlides:1
		});
	});
";
$doc->addScriptDeclaration($js);
?>
<div id="gc-carousel-<?php echo $module->id; ?>" class="gc-carousel">
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

			<?php if ($item->hits || $item->comments || $item->rating || $item->readmore) : ?>
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

				<?php if ($item->readmore) : ?>
				<span class="gc-readmore">
					<span class="cajaLeerMas"><i class="fa fa-caret-right"></i></span><?php echo $item->readmore; ?>
				</span><div class="clearfix"></div>
				<?php endif; ?>
			</div>
			<?php endif; ?>


	</div>
	<?php endforeach; ?>
</div>