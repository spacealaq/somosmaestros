<?php defined('_JEXEC') or die; 
$app    = JFactory::getApplication();
$pathway = $app->getPathway();
$pathway->addItem($this->item->titulo);

// Add current user information
$session =& JFactory::getSession();
$user = JFactory::getUser();


$doc = JFactory::getDocument();
$doc->setTitle($this->item->titulo);

jimport('joomla.application.component.model');
$comentariosModel = JModelLegacy::getInstance( 'Comentariosblogs', 'SomosmaestrosModel' );
$comentariosModel->setState("filter.blog",$this->item->id);
$comentarios = $comentariosModel->getItems();

$doc->addScript('templates/somosmaestros/js/template.js');

$doc->addStyleSheet('templates/somosmaestros/css/awesome.css');
$doc->addStyleSheet('templates/somosmaestros/css/template.css');

$cc = $session->get('cedula');

if($cc) {

	// Get a db connection.
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select($db->quoteName(array('id')));
	$query->from($db->quoteName('#__somosmaestros_campana_blog'));
	$query->where($db->quoteName('blog') . ' = '. $this->item->id. ' AND '.$db->quoteName('cedula').' = '.$cc);
	 
	// Reset the query using our newly populated query object.
	$db->setQuery($query);
	 
	// Load the results as a list of stdClass objects (see later for more options on retrieving data).
	$results = $db->loadObjectList();

	$puntosCampana = sizeof($results);

	if($puntosCampana == 0) {
		// Get a db connection.
		$db2 = JFactory::getDbo();
		$query2 = $db2->getQuery(true);
		$query2->select($db2->quoteName(array('id')));
		$query2->from($db2->quoteName('#__somosmaestros_capanas'));
		$query2->where($db2->quoteName('blog') . ' = '. $this->item->id);

		// Reset the query using our newly populated query object.
		$db2->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results2 = $db2->loadObjectList();

		$campanaActiva = sizeof($results2);

		$idCampana = 0;

		foreach ($results2 as $r) {
			$idCampana = $r->id;
		}
	}
}
?>

<div class="row">
	<div class="contFull_blog offset1 span8">
		<div class="clipBlog">	
			<?php
			jimport('joomla.application.component.model');
			$modeloCatBlog = JModelLegacy::getInstance( 'Categoriasblog', 'SomosmaestrosModel' );
			$categorias = $modeloCatBlog->getItems();
			foreach ($categorias as $categoria) {
				if($this->item->categoria == $categoria->categoria){
					echo '<img src="'.$categoria->icono.'" />';
				}
			}
			?>
		</div>
		<h1>
			<div class="row">
				<div id="redes" class="span8">
					<span style=" margin-left: 30px; float:left;" class='st_facebook_large' displayText='Facebook'></span>
					<span style="float:left;" class='st_twitter_large' displayText='Tweet'></span>
					<span style="float:left;" class='st_email_large' displayText='Email'></span>					
			 		<form id="printPDF" target="_blank" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/blog/generarPdf.php"> 
						<input id="blog" name="blog" class="hidden" type="text"  value="<?php echo $this->item->id; ?>" />
			 			<input id="pdf" style="float:left;" name="pdf" class="iconPdf btn btn-primary" type="submit" value="PDF" />
		           	</form>
					<a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a><br/>
				</div>
			</div>
		</h1>
		<div class="textoFull_blog">
			<h1><?php echo $this->item->titulo; ?></h1>
			<img src="<?php echo $this->item->imagen_grande; ?>">
			<?php if ($session->get('logueado')) { 
				 echo $this->item->contenido;
				 echo '<h5>Fuente: <a href="'.$this->item->fuente.'" target="_blank">'.$this->item->fuente.'</a></h5>';	
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

<div class="span10">
	<?php if ($session->get('logueado')) { ?>

		<div class="comFull_blog offset2 span6">
			<textarea id="campoComentarioBlog" placeholder="Escribe aquí tu comentario"></textarea>
			<?php
				if($campanaActiva == 0){
					echo '<button class="btn btn-primary pull-right" id="enviarComentario" type="button">Comentar</button>';
				} else if ($campanaActiva > 0){
					echo '<button class="btn btn-primary pull-right" id="comentarCampana" type="button">Comentar</button>';
				}
			?>
		</div>					
		<?php
	    if($comentarios){
	    	foreach ($comentarios as $c) { 
	    		$user = $session->get('nombre');
	    		?>
				<div class="offset1 span1">
					<img class="imgAvatarLogin" src="templates/somosmaestros/images/icon_comentario.png">
				</div>
				<div class="comentarFull_blog span6">
		    		<div class="separadorMensaje">
		    			<h4><?php echo $c->nombre ?></h4>
						<?php echo $c->comentario ?>
			    	</div>
			    </div>
		<?php }  
		}
	} ?>
</div>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "0a5fbb5b-480e-4963-a198-8a1c87113b4a", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>


<script type="text/javascript">
jQuery("#enviarComentario").click(function(event) {
	var cedula = <?php echo $session->get('cedula');?>;
	var nombre = '<?php echo $session->get("nombre");?>';
	var blog = <?php echo $this->item->id;?>;
	var comentario = jQuery("#campoComentarioBlog").val();
	if(confirm("¿Realmente deseas enviar este comentario?")){
		jQuery.ajax( {
			type: "GET",
			url: 'index.php?option=com_functions&task=comentarioBlog',
			data: {
				cedula:cedula,
				nombre:nombre,
				blog:blog,
				comentario: encodeURIComponent(comentario)
			},
			success: function( response ) {
				if( response ){
					//alert("Tu mensaje se ha enviado correctamente");
					location.reload(); 
				};
			}
		} );
	};
});


jQuery("#comentarCampana").click(function(event) {
	var cedula = <?php echo $session->get('cedula');?>;
	var nombre = '<?php echo $session->get("nombre");?>';
	var campana = <?php echo $idCampana; ?>;
	var blog = <?php echo $this->item->id;?>;
	var comentario = jQuery("#campoComentarioBlog").val();
	if(confirm("¿Realmente deseas enviar este comentario?")){
		jQuery.ajax( {
			type: "GET",
			url: 'index.php?option=com_functions&task=campanaBlog',
			data: {
				cedula:cedula,
				nombre:nombre,
				campana:campana,
				blog:blog,
				comentario: encodeURIComponent(comentario)
			},
			success: function( response ) {
				if( response ){
					alert("Tu comentario se ha publicado correctamente y has obtenido nuevos puntos");
					location.reload(); 
				};
			}
		} );
	};
});

</script>