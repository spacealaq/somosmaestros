<?php

$app = JFactory::getApplication();
$itemid   = $app->input->getCmd('Itemid', '');
$db = JFactory::getDbo();
$query = $db->getQuery(true);
 
$query->select($db->quoteName(array('id', 'name', 'image', 'description', 'alias')));
$query->from($db->quoteName('#__k2_categories'));
$query->where($db->quoteName('published') . '= 1');
$query->order('ordering ASC');
$db->setQuery($query);
$results = $db->loadObjectList();
?>

<div id="va-accordion" class="va-container">
	<div class="va-wrapper">				
<?php
foreach ($results as $cat) { ?>
		<div class="va-slice va-slice-<?php echo $cat->id; ?>" style="
			background-image:url('media/k2/categories/<?php echo $cat->image; ?>'); background-repeat:none;
			background-size:100%;
			height:300px;">
			<h3 class="va-title"><?php echo $cat->name; ?></h3>
			<div class="va-content">
				<?php echo $cat->description; ?>
				<div class="va-category-link">
					<a href="index.php?option=com_k2&view=itemlist&task=category&id=<?php echo $cat->id; ?>:<?php echo $cat->alias; ?>&Itemid=<?php echo $itemid; ?>">Más información ></a>
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
		visibleSlices	: <?php echo sizeof($results); ?>,
		accordionW		: anchoSpan,
		// the accordion's height
		accordionH		: 450,
	});
});
</script>

