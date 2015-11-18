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
$grid_columns			= $params->get('grid_columns', 3);
$grid_show_sort			= $params->get('grid_show_sort', 1);
$grid_show_filter		= $params->get('grid_show_filter', 1);
$grid_filter_name1		= $params->get('grid_filter_name1', '');
$grid_filter_name2		= $params->get('grid_filter_name2', '');
$grid_filter_name3		= $params->get('grid_filter_name3', '');
$grid_filter_name4		= $params->get('grid_filter_name4', '');
$grid_filter_name5		= $params->get('grid_filter_name5', '');
$grid_filter_alias1		= $params->get('grid_filter_alias1', '');
$grid_filter_alias2		= $params->get('grid_filter_alias2', '');
$grid_filter_alias3		= $params->get('grid_filter_alias3', '');
$grid_filter_alias4		= $params->get('grid_filter_alias4', '');
$grid_filter_alias5		= $params->get('grid_filter_alias5', '');

// Add layout script
$doc->addScript(''.$js_path.'/equate.js');
$doc->addScript(''.$js_path.'/mixitup.js');
$js = "
	jQuery(document).ready(function($){
		$('#gc-grid-".$module->id."').mixItUp({
			load: {
				sort: 'default'
			},
			selectors: {
				sort: '.sort',
				target: '.mix',
				filter: '.filter'
			}
		});
		$('#gc-grid-".$module->id." .gc-col').equate();
	});
";
$doc->addScriptDeclaration($js);
?>
<?php if ($grid_show_sort) : ?>
<div class="gc-sort">
    <span class="sort" data-sort="default"><?php echo JText::_('MOD_GIANTCONTENT_DEFAULT'); ?></span>
    <span class="sort" data-sort="random"><?php echo JText::_('MOD_GIANTCONTENT_RANDOM'); ?></span>
	<span class="sort" data-sort="id:asc"><?php echo JText::_('MOD_GIANTCONTENT_ASCENDING'); ?></span>
    <span class="sort" data-sort="id:desc"><?php echo JText::_('MOD_GIANTCONTENT_DESCENDING'); ?></span>
</div>
<?php endif; ?>
<?php if ($grid_show_filter) : ?>
<div class="gc-filter">
	<span class="filter" data-filter="all"><?php echo JText::_('MOD_GIANTCONTENT_SHOWALL'); ?></span>
	<?php if (!empty($grid_filter_name1) && ($grid_filter_alias1)) : ?>
		<span class="filter" data-filter=".<?php echo $grid_filter_alias1; ?>"><?php echo $grid_filter_name1; ?></span>
	<?php endif; ?>
	<?php if (!empty($grid_filter_name2) && ($grid_filter_alias2)) : ?>
		<span class="filter" data-filter=".<?php echo $grid_filter_alias2; ?>"><?php echo $grid_filter_name2; ?></span>
	<?php endif; ?>
	<?php if (!empty($grid_filter_name3) && ($grid_filter_alias3)) : ?>
		<span class="filter" data-filter=".<?php echo $grid_filter_alias3; ?>"><?php echo $grid_filter_name3; ?></span>
	<?php endif; ?>
	<?php if (!empty($grid_filter_name4) && ($grid_filter_alias4)) : ?>
		<span class="filter" data-filter=".<?php echo $grid_filter_alias4; ?>"><?php echo $grid_filter_name4; ?></span>
	<?php endif; ?>
	<?php if (!empty($grid_filter_name5) && ($grid_filter_alias5)) : ?>
		<span class="filter" data-filter=".<?php echo $grid_filter_alias5; ?>"><?php echo $grid_filter_name5; ?></span>
	<?php endif; ?>
</div>
<?php endif; ?>
<?php if ($grid_show_sort || $grid_show_filter) : ?>
<div class="clearfix"></div>
<?php endif; ?>
<div id="gc-grid-<?php echo $module->id; ?>" class="gc-grid gc-row clearfix">
	<?php foreach ($list as $item) : ?>
	<div class="gc-col gc-scol-<?php echo $grid_columns; ?> mix <?php echo $item->category_alias; ?>" data-id="<?php echo $item->id; ?>">
		<div class="gc-item">
			<?php if ($item->title) : ?>
			<div class="gc-title">
				<?php echo $item->title; ?>
			</div>
			<?php endif; ?>
			<?php if ($item->image) : ?>
			<div class="gc-image">
				<?php echo $item->image; ?>
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
	</div>
	<?php endforeach; ?>
</div>