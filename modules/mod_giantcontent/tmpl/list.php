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
$list_duration			= $params->get('list_duration', 500);
$list_animation			= $params->get('list_animation', 'swing');

// Add layout script
$doc->addScript(''.$js_path.'/easing.js');
$doc->addScript(''.$js_path.'/list.js');
$js = "
	jQuery(document).ready(function($){
		$('#gc-list-".$module->id."').list({
			duration: ".$list_duration.",
			animation: '".$list_animation."'
		});
	});
";
$doc->addScriptDeclaration($js);
?>
<div id="gc-list-<?php echo $module->id; ?>" class="gc-list">
	<?php foreach ($list as $item) : ?>
	<div class="gc-item">

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

	</div>
	<?php endforeach; ?>
</div>