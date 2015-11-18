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
?>
<?php foreach ($list as $item) : ?>

	<!-- Show title -->
	<?php if ($item->title) : ?>
		<?php echo $item->title; ?>
	<?php endif; ?>

	<!-- Show image -->
	<?php if ($item->image) : ?>
		<?php echo $item->image; ?>
	<?php endif; ?>

	<!-- Show avatar -->
	<?php if ($item->avatar) : ?>
		<?php echo $item->avatar; ?>
	<?php endif; ?>

	<!-- Show author -->
	<?php if ($item->author) : ?>
		<?php echo $item->author; ?>
	<?php endif; ?>

	<!-- Show date -->
	<?php if ($item->date) : ?>
		<?php echo $item->date; ?>
	<?php endif; ?>

	<!-- Show hits -->
	<?php if ($item->hits) : ?>
		<?php echo $item->hits; ?>
	<?php endif; ?>

	<!-- Show intro -->
	<?php if ($item->intro) : ?>
		<?php echo $item->intro; ?>
	<?php endif; ?>

	<!-- Show rating -->
	<?php if ($item->rating) : ?>
		<?php echo $item->rating; ?>
	<?php endif; ?>

	<!-- Show category -->
	<?php if ($item->category) : ?>
		<?php echo $item->category; ?>
	<?php endif; ?>

	<!-- Show comments -->
	<?php if ($item->comments) : ?>
		<?php echo $item->comments; ?>
	<?php endif; ?>

	<!-- Show readmore -->
	<?php if ($item->readmore) : ?>
		<?php echo $item->readmore; ?>
	<?php endif; ?>

	<!-- Show tags -->
	<?php if ($item->tags) : ?>
		<?php echo $item->tags; ?>
	<?php endif; ?>

	<!-- Show featured -->
	<?php if ($item->featured) : ?>
		<?php echo $item->featured; ?>
	<?php endif; ?>

<?php endforeach; ?>