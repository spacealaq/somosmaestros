<?php defined('_JEXEC') or die; 

$app    = JFactory::getApplication();
$pathway = $app->getPathway();
$pathway->addItem($this->item->titulo);

// Add current user information
$session =& JFactory::getSession();
$user = JFactory::getUser();


$doc = JFactory::getDocument();
$doc->setTitle($this->item->titulo);

$doc->addScript('templates/somosmaestros/js/template.js');

$doc->addStyleSheet('templates/somosmaestros/css/awesome.css');
$doc->addStyleSheet('templates/somosmaestros/css/template.css');


$doc->setTitle($this->item->titulo);

jimport('joomla.application.component.model');
$modeloCatArticulos = JModelLegacy::getInstance( 'Categoriasarticulos', 'SomosmaestrosModel' );
$idCategoria = $modeloCatArticulos->getItems();

foreach ($idCategoria as $categoria) {
	if($this->item->categoria == $categoria->categoria){
		jimport('joomla.application.component.model');
		$modeloArticulos = JModelLegacy::getInstance( 'Articulos', 'SomosmaestrosModel' );
		$modeloArticulos->setState('filter.categoria', (int)$categoria->id);
		$articulosRecomendados = $modeloArticulos->getItems();
	}
}


jimport('joomla.application.component.model');
$modeloArticulos = JModelLegacy::getInstance( 'Articulos', 'SomosmaestrosModel' );
$articulosContenido = $modeloArticulos->getItems();

?>

<div class="row">
	<div class="span8">
		<h1>
			<div class="row">
				<div id="redes" class="span8">
					<span style="float:left;" class='st_facebook_large' displayText='Facebook'></span>
					<span style="float:left;" class='st_twitter_large' displayText='Tweet'></span>
					<span style="float:left;" class='st_email_large' displayText='Email'></span>					
			 		<form id="printPDF" target="_blank" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/articulo/generarPdf.php"> 
						<input id="articulo" name="articulo" class="hidden" type="text"  value="<?php echo $this->item->id; ?>" />
			 			<input id="pdf" style="float:left;" name="pdf" class="iconPdf btn btn-primary" type="submit" value="PDF" />
		           	</form>
					<a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a><br/>
				</div>
			</div>
		</h1>
		<div class="row">
			<div class="textoFull_blog span8">
				<h1><?php echo $this->item->titulo; ?></h1>
				<img src="<?php echo $this->item->imagen_grande; ?>">
				<?php if ($session->get('logueado')) { 
					 echo $this->item->contenido;
					 echo '<h5>Fuente: <a href="'.$this->item->fuente.'" target="_blank">'.$this->item->fuente.'</a></h5>';
					?>
					<div id="masContenidos">
						<h3>MÁS CONTENIDOS</h3>
						<div>
							<div id="masContenidosArt">
								<?php 
									$tmp = 0;
									foreach ($articulosContenido as $ar) if ($tmp++ < 3){
								?>
								<div id="masContenidosOne" class="span2">
									<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=articulo&id='.(int) $ar->id); ?>"><img src="<?php echo $ar->imagen_pequena; ?>" /><p><?php echo $ar->titulo; ?></p></a>
								</div>
								<?php
									}
								?>
							</div>
						</div>
					</div>
					<?php
				 } else { 
					 echo strip_tags(substr($this->item->contenido,0,1500)).'...';
					 jimport('joomla.application.module.helper');
					// this is where you want to load your module position
					$modules = JModuleHelper::getModules('loginSm');
					?>
					<div class="span8" id="cuenta">
						<h4>Para conocer más de este contenido ingresa, usuario y contraseña</h4>
						<?php
						foreach($modules as $module){
						 echo JModuleHelper::renderModule($module);
						}
						?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="span3" id="recomendados">
		<img id="recomendadosImg" src="<?php echo JURI::base(); ?>templates/somosmaestros/images/icon_recomendados.png" />
		<div id="recomendamosTitulo" class="span3">
			<h5>También te recomendamos</h5>
		</div>
		<div class="span3">
			<div id="recomendadosArt">
				<?php 
					$tmp = 0;
					foreach ($articulosRecomendados as $ar) if ($tmp++ < 3){
				?>
					<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=articulo&id='.(int) $ar->id); ?>"><img src="<?php echo JURI::base(); ?>templates/somosmaestros/images/icon_recomendado.png" /><p><?php echo $ar->titulo; ?></p></a>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "0a5fbb5b-480e-4963-a198-8a1c87113b4a", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
