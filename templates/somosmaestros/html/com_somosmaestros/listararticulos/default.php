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
$pathway = $app->getPathway();

$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;


$session =& JFactory::getSession();

//$delegacion = $session->get('delegacion');
$tipoInstitucion = $session->get('tipoInstitucion');
$segmento= $session->get('segmento');
$nivel = $session->get('nivel');
$ciudad = $session->get('ciudad');
//$area = $session->get('area');
$rol = $session->get('rol');
$nivel = $session->get('nivel');
$proyecto = $session->get('proyecto');


$idCat = JRequest::getVar('categoria');

jimport('joomla.application.component.model');
$modeloCatArticulos = JModelLegacy::getInstance( 'Categoriasarticulos', 'SomosmaestrosModel' );
$listadoCatArticulos = $modeloCatArticulos->getItems();

foreach ($listadoCatArticulos as $cat) {
	if($cat->id == $idCat){
		$pathway->addItem($cat->categoria);
		$doc->setTitle($cat->categoria);
	}
}

if ($idCat){
	jimport('joomla.application.component.model');
	$modeloArticulos = JModelLegacy::getInstance( 'Articulos', 'SomosmaestrosModel' );
	$modeloArticulos->setState('filter.categoria', (int)$idCat);
	$articulos = $modeloArticulos->getItems();
} else {
	jimport('joomla.application.component.model');
	$modeloArticulos = JModelLegacy::getInstance( 'Articulos', 'SomosmaestrosModel' );
	$articulos = $modeloArticulos->getItems();
}

?>

<div class="span10">
	<div class="blog">
		<div class="limitado">
			<div id="system-message-container"></div>
			<div class="page-header">
				<h1>Artículos</h1>
			</div>
			<div class="items-row cols-3 row-2 row-fluid clearfix">
				<div id="listId">
					 <ul class="list">
						<?php
						foreach ($articulos as $art) { ?>
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
											<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=articulo&id='.(int) $art->id); ?>" class="btn"><span class="icon-chevron-right"></span>Leer más ...</a>
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