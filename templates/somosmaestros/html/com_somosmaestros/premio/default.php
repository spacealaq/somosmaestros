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
$doc = JFactory::getDocument();
$doc->addStyleSheet('templates/somosmaestros/css/spinedit.css');
$doc->setTitle($this->item->premio);

$app    = JFactory::getApplication();
$pathway = $app->getPathway();
$pathway->addItem($this->item->premio);
?>
<?php if ($this->item) : ?>

	<div class="row">
		<div class="span1"></div>
		<div class="span10">
			<div class="row">
				<div class="span3" >
					<div class="contPuntosPremioInterna">
						<?php echo $this->item->puntos; ?><br>
						Puntos
					</div>
				</div>
				<div class="span7" id="contDetPremioInterna">
					<h2><?php echo $this->item->premio; ?></h2>
					<div class="row contDetPremioInterna">
						<div class="span4 contDescPremioInter">
							<?php echo $this->item->descripcion; ?><br>
							
							
							<div class="row" data-trigger="spinner" id="spinner">
								<div class="span3">
									<div class="row">
										<div class="span1 textoCantidad">Cantidad</div>
										<div class="span2"><input type="text" value="1" data-rule="quantity"></div>
									</div>
									
								</div>
								<div class="span1 controlCant">
							  		<a href="javascript:;" class="cantidadArriba" data-spin="up"></a>
							  		<a href="javascript:;" class="cantidadAbajo" data-spin="down"></a>
								</div>
							</div>
							<div class="row">
								<div class="span3">
									<div class="row">
										<div class="span1 textoCantidad">Valor a redimir</div>
										<div class="span2"><input type="text" value="<?php echo $this->item->puntos; ?>" id="valorRedimir"></div>
									</div>
									
								</div>
							</div>
							<div class="row">
								<div class="span4">
									<div class="row">
										<div class="span6">
											<div id="botonRedimir" class="btn btn-primary pull-left"><i class="fa fa-exchange"></i>
 Redimir</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<div class="span3">
							<img src="<?php echo $this->item->imagen; ?>">
							
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="span1"></div>
	</div>
	<script type="text/javascript" src="templates/somosmaestros/js/spinedit.js"></script>
	<script type="text/javascript">
	jQuery("#spinner")
		.spinner('delay', 200) //delay in ms
		.spinner('changed', function(e, newVal, oldVal){
		//trigger lazed, depend on delay option.
	})
	.spinner('changing', function(e, newVal, oldVal){
		jQuery("#valorRedimir").val( <?php echo $this->item->puntos; ?>*newVal);
	});
	</script>
<?php
else:
    echo JText::_('COM_SOMOSMAESTROS_ITEM_NOT_LOADED');
endif;
?>
