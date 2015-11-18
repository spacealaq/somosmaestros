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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$db = JFactory::getDBO();
$query='SELECT * FROM #__somosmaestros_premios WHERE state = 1';
$db->setQuery($query);
$premios = $db->loadObjectList();

$user = JFactory::getUser();
$userId = $user->get('id');
$contador = 1;
?>
<!-- Comenzando el foreach-->
<?php foreach ($premios as $item) : ?>
    <?php if($contador == 1){ ?>
	<div class="row">
	<?php } ?>
    <div class="premio premio-<?php echo $item->id; ?> span6">
    	<div class="row">
			<div class="span2 contenedorImgPremio"><img src="<?php echo $item->imagen; ?>" class="img-circle"></div>
    		<div class="span4 contenedorInfoPremio">
    			<div class="titPremio"><?php echo $item->premio; ?> <div class="botonToogle btn btn-primary btn-mini pull-right"><i class="icon-plus icon-white"></i> <span>Más</span> detalles</div></div>
    			<div class="contenedorDesp">
	    			<div class="descPremio"><?php echo substr($item->descripcion, 0, 35)."... "; ?><a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=premio&id='.(int) $item->id); ?>">Más info</a></div>
	    			<div class="puntosPremio"><?php echo $item->puntos; ?> Puntos</div>
	    			
    			</div>
    		</div>
    	</div>    	
	</div> 
    <?php 
    if($contador == 2){ $contador=1; ?>
	</div>
	<?php }else{
		$contador++;
	} ?>
<?php endforeach; ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery(".titPremio").toggle(function() {
			jQuery(this).parent().find(".contenedorDesp").slideDown('fast');
			jQuery(this).find('.botonToogle').find('i').removeClass('icon-plus').addClass('icon-minus');
			jQuery(this).find('.botonToogle').find('span').text('Menos');
			jQuery(this).addClass('premioActivo');
		}, function() {
			jQuery(this).parent().find(".contenedorDesp").slideUp('fast');
			jQuery(this).find('.botonToogle').find('i').removeClass('icon-minus').addClass('icon-plus');
			jQuery(this).find('.botonToogle').find('span').text('Más');
			jQuery(this).removeClass('premioActivo');
		});
	});
</script>


