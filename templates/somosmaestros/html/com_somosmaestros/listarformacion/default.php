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
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;


$session =& JFactory::getSession();

jimport('joomla.application.component.model');
$modeloFormacion = JModelLegacy::getInstance( 'Formacions', 'SomosmaestrosModel' );
$formacion = $modeloFormacion->getItems();


?>

<div class="span10">
	<div class="blog">
		<div class="limitado">
			<div id="system-message-container"></div>
			<div class="page-header">
				<h1>Formación</h1>
			</div>
			<div class="items-row cols-3 row-2 row-fluid clearfix">
				<div id="listId">
					 <ul class="list">
						<?php
						foreach ($formacion as $art) { ?>
							<li>
								<div id="item-or">
									<div class="item column-1">
										<div class="espacio2em"></div>
										<div class="pull-none item-image">
											<img style="width: 100%; max-height:150px;" src="<?php echo $art->imagen_pequena; ?>" />
										</div>
										<div class="tituloEnCategoria">
											<div class="page-header">
												<h5>
													<?php echo $art->titulo; ?>
												</h5>
											</div>
										</div>
										<p><?php echo substr($art->preview,0,250).'...'; ?></p>
										<p class="readmore">
											<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=formacion&id='.(int) $art->id); ?>" class="btn"><span class="icon-chevron-right"></span>Leer más ...</a>
										</p>
									</div>
								</div>
							</li>
						<?php 
							} 
						?>
					</ul>
  					<ul class="pagination"></ul>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var options = {
	    valueNames: [ 'name', 'category' ],
	    page: 6,
	    plugins: [
	      ListPagination({left:3, right: 3,})
	    ]
	  };

	  var listObj = new List('listId', options);
 </script>