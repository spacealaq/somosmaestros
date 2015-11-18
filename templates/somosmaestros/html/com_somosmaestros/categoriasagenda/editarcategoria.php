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

$idCategoria = JRequest::getVar('id');

jimport('joomla.application.component.model');
$modeloCatAgenda = JModelLegacy::getInstance( 'Categoriasagenda', 'SomosmaestrosModel' );
$parametrosCat = $modeloCatAgenda->getItems();

if($user->get('id') ){ 
	$doc = JFactory::getDocument();
	$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
	$doc->addScript('templates/somosmaestros/js/loading.js');
	$doc->addScript('templates/somosmaestros/js/uploadfile.js');
	$doc->addStyleSheet('templates/somosmaestros/css/uploadfile.css');

	foreach ($parametrosCat as $p) { 
 		if($p->id == $idCategoria){
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
							<form id="formEditarCategoria" class="row form-crear">
								<div class="span5">
									<label for="categoriaAgenda">Categoría:</label>
									<input name="categoriaAgenda" id="categoriaAgenda" type="text" value="<?php echo $p->categoria; ?>">
								</div>	
								<div class="span5">
									<label for="colorCatAgenda">Color (Hexadecimal omitiendo el #)</label>
									<input name="colorCatAgenda" id="colorCatAgenda" type="text" value="<?php echo $p->color; ?>">
								</div>
								<div class="span5">
									<label for="anchoCatAgenda">Ancho (escribir el ancho en pixeles, solo el número)</label>
									<input name="anchoCatAgenda" id="anchoCatAgenda" type="text" value="<?php echo $p->ancho; ?>">
								</div>	
								<div class="span5"></div>	
								<div class="span10">
									<label>Icono - Tamaño Recomendado: 25 x 27</label>
									<img id="imagenCatAgenda">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status1"></div>
									<img src="<?php echo $p->imagen ?>" />
								</div>
								<div class="span5"></div>
								<div class="span10">
									<a href="javascript: guardarCategoria(<?php echo $p->id; ?>);">
					  					<div id="btn_categoriaAgenda" class="btn btn-primary">
											<i class="icon-bookmark icon-white"></i> Guardar Categoría
										</div>
									</a>
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
		}
	}
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
			var imagen1;
		var settings1 = {
		    url: "<?php echo JURI::base(); ?>subirImagen.php",
		    formData: {
		    	"tipo":"blog",
		    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
		    },
			onSuccess:function(files,data,xhr){
		       console.log(jQuery(this));
		       imagen1=data;
		       jQuery("#imagenCatAgenda").attr("src","<?php echo JURI::base(); ?>"+data);
		       jQuery("#imagenCatAgenda").fadeIn();
		    },
		    deleteCallback: function(data,pd){
			    for(var i=0;i<data.length;i++){
			        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
			        function(resp, textStatus, jqXHR){
			            jQuery("#imagenCatAgenda").fadeOut();
			            alert("Archivo borrado");  
			        });
			    }      
			    pd.statusbar.hide(); //You choice to hide/not.
			}
		}
		
	var uploadObj1 = jQuery("#multiplefileuploader1").uploadFile(settings1);

			jQuery("#btn_categoriaAgenda").click(function(){
				jQuery.ajax({
					type: "GET",
					url: "index.php?option=com_functions&task=guardarCategoriaAgenda",
					data: { 
						id: <?php echo $idCategoria; ?>,
						categoria: jQuery("#categoriaAgenda").val(),
						color: jQuery("#colorCatAgenda").val(),
						ancho: jQuery("#anchoCatAgenda").val(),
						imagen: imagen1
					},
					success: function( response ) {
						if( response ){
							alert("Tu categoria se ha modificado correctamente");
							location.assign("index.php?option=com_somosmaestros&view=categoriasagenda&Itemid=405");
						};
					}
				});
			});
		});

</script>