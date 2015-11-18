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
$slideshow_width		= $params->get('slideshow_width', '');
$slideshow_height		= $params->get('slideshow_height', '');
$slideshow_autoplay		= $params->get('slideshow_autoplay', 1);
$slideshow_duration		= $params->get('slideshow_duration', 1000);
$slideshow_interval		= $params->get('slideshow_interval', 5000);
$slideshow_animation	= $params->get('slideshow_animation', 'fade');
$slideshow_navigation	= $params->get('slideshow_navigation', 1);
$slideshow_pagination	= $params->get('slideshow_pagination', 1);
$slideshow_thumbnails	= $params->get('slideshow_thumbnails', 1);
$slideshow_startslide	= $params->get('slideshow_startslide', 0);

// Add layout script
$doc->addScript(''.$js_path.'/slideshow.js');
$js = "
	jQuery(document).ready(function($){
		$('#gc-slideshow-".$module->id."').slideshow({
			autoPlay: ".$slideshow_autoplay.",
			duration: ".$slideshow_duration.",
			interval: ".$slideshow_interval.",
			animation: '".$slideshow_animation."',
			navigation: ".$slideshow_navigation.",
			pagination: ".$slideshow_pagination.",
			thumbnails: ".$slideshow_thumbnails.",
			startSlide: ".$slideshow_startslide."
		});
	});
";
$doc->addScriptDeclaration($js);
?>
<?php if (!empty($slideshow_width) || ($slideshow_height)) : ?>
<div style="<?php if (!empty($slideshow_width)) : ?>max-width:<?php echo $slideshow_width; ?>px;<?php endif; ?><?php if (!empty($slideshow_height)) : ?>max-height:<?php echo $slideshow_height; ?>px;<?php endif; ?>">
<?php endif; ?>

<ul id="gc-slideshow-<?php echo $module->id; ?>" class="gc-slideshow">
	<?php foreach ($list as $item) : ?>
	<li class="gc-item">

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

	</li>
	<?php endforeach; ?>
</ul>

<?php if (!empty($slideshow_width) || ($slideshow_height)) : ?>
</div>
<?php endif; ?>