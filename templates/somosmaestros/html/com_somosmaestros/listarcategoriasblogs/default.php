<?php
/**
 * @version     1.0.0
 * @package     com_somosmaestros
 * @copyright   Copyright (C) 2015. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Daniel Gustavo Álvarez Gaitán <info@danielalvarez.com.co> - http://danielalvarez.com.co
 */
// no direct access
defined('_JEXEC') or die;

$app = JFactory::getApplication();

jimport('joomla.application.component.model');
$modeloCatBlog = JModelLegacy::getInstance( 'Categoriasblog', 'SomosmaestrosModel' );
$CatBlog = $modeloCatBlog->getItems();

?>

<div id="va-accordion" class="va-container">
	<div class="va-wrapper">				
<?php
foreach ($CatBlog as $bc) { ?>
		<div class="va-slice va-slice-<?php echo $bc->id; ?>" style="
			background-image:url('<?php echo $bc->imagen; ?>'); background-repeat:none;
			background-size:100%;
			height:300px;">
			<h3 class="va-title"><?php echo $bc->categoria; ?></h3>
			<div class="va-content">
				<?php echo $bc->descripcion; ?>
				<div class="va-category-link">
					<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=listar_blogs&Itemid=199&categoria='.$bc->id); ?>">Más información ></a>
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
	var anchoSpan = jQuery('#va-accordion2').parent().width();
	//jQuery('#va-accordion').vaccordion();
	jQuery('#va-accordion').vaccordion({
		visibleSlices	: <?php echo sizeof($CatBlog); ?>,
		accordionW		: anchoSpan,
		// the accordion's height
		accordionH		: 450,
	});
});
</script>


