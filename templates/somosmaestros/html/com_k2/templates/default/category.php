<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
$app = JFactory::getApplication();
$idCat   = $app->input->getCmd('id', '');



?>

<!-- Start K2 Category Layout -->
<div id="k2Container" class="itemListView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title') && $idCat != "5" ): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>

	<?php if($this->params->get('catFeedIcon')): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php if(isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )): ?>
	<!-- Blocks for current category and subcategories -->
	<div class="itemListCategoriesBlock">

		<?php if($idCat != "5" && isset($this->category) && ( $this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->event->K2CategoryDisplay )): ?>
		<!-- Category block -->
		<div class="itemListCategory">

			<?php if(isset($this->addLink)): ?>
			<!-- Item add link -->
			<span class="catItemAddLink">
				<a class="modal" rel="{handler:'iframe',size:{x:990,y:650}}" href="<?php echo $this->addLink; ?>">
					<?php echo JText::_('K2_ADD_A_NEW_ITEM_IN_THIS_CATEGORY'); ?>
				</a>
			</span>
			<?php endif; ?>

			<?php if($this->params->get('catImage') && $this->category->image): ?>
			<!-- Category image -->
			<img alt="<?php echo K2HelperUtilities::cleanHtml($this->category->name); ?>" src="<?php echo $this->category->image; ?>" style="width:<?php echo $this->params->get('catImageWidth'); ?>px; height:auto;" />
			<?php endif; ?>

			<?php if($this->params->get('catTitle')): ?>
			<!-- Category title -->
			<h2><?php echo $this->category->name; ?></h2>
			<?php endif; ?>

			<?php if($this->params->get('catDescription')): ?>
			<!-- Category description -->
			<p><?php echo $this->category->description; ?></p>
			<?php endif; ?>

			<!-- K2 Plugins: K2CategoryDisplay -->
			<?php echo $this->category->event->K2CategoryDisplay; ?>

			<div class="clr"></div>
		</div>
		<?php endif; ?>

		<?php if($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)): ?>
		<!-- Subcategories -->
		<div class="itemListSubCategories">
			

			<?php if($idCat == "5"){ ?>
			<div id="va-accordion" class="va-container">
				<div class="va-wrapper">	
			<?php foreach ($this->subCategories as $key=>$subCategory) { ?>
					<div class="va-slice va-slice-<?php echo $cat->id; ?>" style="
						background-image:url('<?php echo $subCategory->image; ?>'); background-repeat:none;
						background-size:100%;
						height:300px;">
						<h3 class="va-title"><?php echo $subCategory->name; ?></h3>
						<div class="va-content">
							<?php echo $subCategory->description; ?>
							<div class="va-category-link">
								<a href="<?php echo $subCategory->link; ?>">Más información ></a>
							</div>
						</div>
					</div>
			<?php } ?>
				</div>
			</div>
			<script type="text/javascript" src="templates/somosmaestros/js/easing.js"></script>
			<!--<script type="text/javascript" src="templates/somosmaestros/js/mousewheel.js"></script>-->
			<script type="text/javascript" src="templates/somosmaestros/js/vaccordion.js"></script>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				var anchoSpan = jQuery('#va-accordion').parent().width();
				//jQuery('#va-accordion').vaccordion();
				jQuery('#va-accordion').vaccordion({
					visibleSlices	: <?php echo sizeof($this->subCategories); ?>,
					accordionW		: anchoSpan,
					// the accordion's height
					accordionH		: 450,
				});
			});
			</script>
			<?php } ?>
			

			<div class="clr"></div>
		</div>
		<?php endif; ?>

	</div>
	<?php endif; ?>



	<?php if($idCat != "5" &&  (isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))): ?>
	<!-- Item list -->
	<div class="itemList">

		<?php if(isset($this->leading) && count($this->leading)): ?>
		<!-- Leading items -->
		<div id="itemListLeading">
			<?php foreach($this->leading as $key=>$item): ?>

			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_leading_columns'))==0) || count($this->leading)<$this->params->get('num_leading_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
			?>
			
			<div class="itemContainer<?php echo $lastContainer; ?>"<?php echo (count($this->leading)==1) ? '' : ' style="width:'.number_format(100/$this->params->get('num_leading_columns'), 1).'%;"'; ?>>
				<?php
					// Load category_item.php by default
					$this->item=$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php if(($key+1)%($this->params->get('num_leading_columns'))==0): ?>
			<div class="clr"></div>
			<?php endif; ?>
			<?php endforeach; ?>
			<div class="clr"></div>
		</div>
		<?php endif; ?>

		<?php if(isset($this->primary) && count($this->primary)): ?>
		<!-- Primary items -->
		<div id="itemListPrimary">
			<?php foreach($this->primary as $key=>$item): ?>
			
			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_primary_columns'))==0) || count($this->primary)<$this->params->get('num_primary_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
			?>
			
			<div class="itemContainer<?php echo $lastContainer; ?>"<?php echo (count($this->primary)==1) ? '' : ' style="width:'.number_format(100/$this->params->get('num_primary_columns'), 1).'%;"'; ?>>
				<?php
					// Load category_item.php by default
					$this->item=$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php if(($key+1)%($this->params->get('num_primary_columns'))==0): ?>
			<div class="clr"></div>
			<?php endif; ?>
			<?php endforeach; ?>
			<div class="clr"></div>
		</div>
		<?php endif; ?>

		<?php if(isset($this->secondary) && count($this->secondary)): ?>
		<!-- Secondary items -->
		<div id="itemListSecondary">
			<?php foreach($this->secondary as $key=>$item): ?>
			
			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_secondary_columns'))==0) || count($this->secondary)<$this->params->get('num_secondary_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
			?>
			
			<div class="itemContainer<?php echo $lastContainer; ?>"<?php echo (count($this->secondary)==1) ? '' : ' style="width:'.number_format(100/$this->params->get('num_secondary_columns'), 1).'%;"'; ?>>
				<?php
					// Load category_item.php by default
					$this->item=$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php if(($key+1)%($this->params->get('num_secondary_columns'))==0): ?>
			<div class="clr"></div>
			<?php endif; ?>
			<?php endforeach; ?>
			<div class="clr"></div>
		</div>
		<?php endif; ?>

		<?php if(isset($this->links) && count($this->links)): ?>
		<!-- Link items -->
		<div id="itemListLinks">
			<h4><?php echo JText::_('K2_MORE'); ?></h4>
			<?php foreach($this->links as $key=>$item): ?>

			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_links_columns'))==0) || count($this->links)<$this->params->get('num_links_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
			?>

			<div class="itemContainer<?php echo $lastContainer; ?>"<?php echo (count($this->links)==1) ? '' : ' style="width:'.number_format(100/$this->params->get('num_links_columns'), 1).'%;"'; ?>>
				<?php
					// Load category_item_links.php by default
					$this->item=$item;
					echo $this->loadTemplate('item_links');
				?>
			</div>
			<?php if(($key+1)%($this->params->get('num_links_columns'))==0): ?>
			<div class="clr"></div>
			<?php endif; ?>
			<?php endforeach; ?>
			<div class="clr"></div>
		</div>
		<?php endif; ?>

	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php if($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>

	<?php endif; ?>
</div>
<!-- End K2 Category Layout -->

