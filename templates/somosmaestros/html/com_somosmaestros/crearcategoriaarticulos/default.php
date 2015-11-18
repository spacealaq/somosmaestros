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


$session =& JFactory::getSession();
$user = JFactory::getUser();

if($user->get('id') ){ 
	$doc = JFactory::getDocument();
	$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
	$doc->addScript('templates/somosmaestros/js/loading.js');

?>
<div class="row">
		<div class="span12">
			<div class="row">
				<div class="span2">
					<a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a>
				</div>
				<div class="span10">
					<div class="row"> 
						<div class="span10">
							<form id="formCrearCategoria" class="row form-crear">
								<div class="span5">
									<label for="categoriaArticulo">Categoría:</label>
									<input name="categoriaArticulo" id="categoriaArticulo" type="text">
								</div>	
								<div class="span5"></div>
								<div class="span10">
									<div id="btn_categoriaArticulo" class="btn btn-primary">
										<i class="icon-bookmark icon-white"></i> Crear Categoría
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="span5"></div>
	</div>
<?php
}else{ ?>

	<div class="alert alert-error">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Permiso denegado! </strong> Área restringida
	</div>
	<?php

};

?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery("#btn_categoriaArticulo").click(function(){
				jQuery.ajax({
				type: "GET",
				url: "index.php?option=com_functions&task=crearCategoriaArticulo",
				data: { 
					categoria: jQuery("#categoriaArticulo").val(),
				},
				success: function( response ) {
					if( response ){
						alert("Tu categoria se ha creado correctamente");
						location.assign("index.php?option=com_somosmaestros&view=categoriasarticulos&Itemid=401");
					};
				}
			});
		});
	});
</script>