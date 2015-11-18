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
$blog_items				= $params->get('blog_items', 3);
$blog_pager				= $params->get('blog_pager', 1);
$blog_pager_align		= $params->get('blog_pager_align', 'center');
$blog_pager_position	= $params->get('blog_pager_position', 'bottom');

// Add layout script
if ($blog_pager) {
	$doc->addScript(''.$js_path.'/pagination.js');
	$js = "
		jQuery(document).ready(function($){
			$('#gc-pagination-".$module->id."').pagination({
				items: '#gc-blog-".$module->id."',
				perPage: ".$blog_items.",
				prev: '".JText::_('MOD_GIANTCONTENT_PREV')."',
				next: '".JText::_('MOD_GIANTCONTENT_NEXT')."'
			});
		});
	";
	$doc->addScriptDeclaration($js);
}
?>
<?php if ($blog_pager && $blog_pager_position == 'top') : ?>
	<div id="gc-pagination-<?php echo $module->id; ?>" class="gc-pagination pager-top pager-<?php echo $blog_pager_align; ?>"></div>
<?php endif; ?>

<div id="gc-blog-<?php echo $module->id; ?>" class="gc-blog">
	<?php foreach ($list as $item) : ?>
	<div class="gc-item">
		<?php
		if($params->get('type')=="k2"){
		$cat = explode(':', $item->category);
		$cat = $cat[1];
		$cat = explode('&',$cat);
		$cat = $cat[0];
		 ?>
			<div class="clipBlog"><img src="templates/somosmaestros/images/clip_<?php echo $cat; ?>.png"></div>
		<?php } ?>
		<?php if ($item->avatar || $item->title || $item->author || $item->date || $item->category) : ?>
		<div class="gc-info clearfix <?php if($params->get('type')=="k2"){ echo 'paddingBlog'; }?>">
			<?php if ($item->avatar) : ?>
			<div class="gc-avatar">
				<?php echo $item->avatar; ?>
			</div>
			<?php endif; ?>

			<?php if ($item->title) : ?>
			<div class="gc-title">
				<?php echo $item->title; ?>
				<?php if ($item->featured) : ?>
					<?php echo $item->featured; ?>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if ($item->author || $item->date || $item->category) : ?>
			<div class="gc-info-top">
				<?php if ($item->author) : ?>
				<span class="gc-author">
					<?php echo JText::_('MOD_GIANTCONTENT_WRITTEN_BY'); ?> <?php echo $item->author; ?>
				</span>
				<?php endif; ?>

				<?php if ($item->date) : ?>
				<span class="gc-date">
					<?php echo JText::_('MOD_GIANTCONTENT_ON'); ?> <?php echo $item->date; ?>
				</span>
				<?php endif; ?>

				<?php if ($item->category) : ?>
				<span class="gc-category">
					<?php echo JText::_('MOD_GIANTCONTENT_IN'); ?> <?php echo $item->category; ?>
				</span>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if ($item->image) : ?>
		<div class="gc-image <?php if($params->get('type')=="k2"){ echo 'imagenDerecha'; }?>">
			<?php echo $item->image; ?>
		</div>
		<?php endif; ?>

		<?php if ($item->intro) : ?>
		<div class="gc-intro <?php if($params->get('type')=="k2"){ echo 'paddingBlog'; }?>" >
			<?php echo $item->intro; ?>
		</div>
		<?php endif; ?>

		<div class="clearfix"></div>

		<?php if ($item->tags) : ?>
		<div class="gc-tags">
			<?php echo $item->tags; ?>
		</div>
		<?php endif; ?>

		<?php if ($item->hits || $item->comments || $item->rating || $item->readmore) : ?>
		<div class="gc-info-bottom">

			<?php if ($item->hits) : ?>
			<span class="gc-hits">
				<?php echo JText::_('MOD_GIANTCONTENT_HITS'); ?> <?php echo $item->hits; ?>
			</span>
			<?php endif; ?>

			<?php if ($item->rating) : ?>
			<span class="gc-rating">
				<?php echo $item->rating; ?>
				<?php if ($item->rating_count > 0) : ?>
					<?php echo $item->rating_count; ?>
					<?php echo $item->rating_count > 1 ? JText::_('MOD_GIANTCONTENT_VOTES') : JText::_('MOD_GIANTCONTENT_VOTE'); ?>
				<?php else : ?>
					<?php echo JText::_('MOD_GIANTCONTENT_NO_VOTE'); ?>
				<?php endif; ?>
			</span>
			<?php endif; ?>

			<?php if ($item->readmore) : ?>
			<span class="gc-readmore">
				<span class="cajaLeerMas"><i class="fa fa-caret-right"></i></span><?php echo $item->readmore; ?>
			</span>
			<?php endif; ?>

			<?php if ($item->comments) : ?>
			<span class="gc-comments">
				<a href="<?php echo $item->comments_link; ?>">
					<?php if ($item->comments_count > 0) : ?>
						<?php echo $item->comments_count; ?>
						<?php echo $item->comments_count > 1 ? JText::_('MOD_GIANTCONTENT_COMMENTS') : JText::_('MOD_GIANTCONTENT_COMMENT'); ?>
					<?php else : ?>
						<?php echo JText::_('MOD_GIANTCONTENT_NO_COMMENT'); ?>
					<?php endif; ?>
				</a>
			</span>
			<?php endif; ?>
		</div><div class="clearfix"></div>
		<?php endif; ?>

	</div>
	<?php endforeach; ?>
</div>

<?php if ($blog_pager && $blog_pager_position == 'bottom') : ?>
	<div id="gc-pagination-<?php echo $module->id; ?>" class="gc-pagination pager-bottom pager-<?php echo $blog_pager_align; ?>"></div>
<?php endif; ?>