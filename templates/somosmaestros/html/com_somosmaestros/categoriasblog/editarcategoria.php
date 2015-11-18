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
$modeloCatBlog = JModelLegacy::getInstance( 'Categoriasblog', 'SomosmaestrosModel' );
$parametrosCat = $modeloCatBlog->getItems();

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
								<div class="span10">
									<label for="categoriaBlog">Categoría:</label>
									<input name="categoriaBlog" id="categoriaBlog" type="text" value="<?php echo $p->categoria; ?>">
								</div>			
								<div class="span10">
									<label for="descripcionBlog">Descripción:</label>
									<input name="descripcionBlog" id="descripcionBlog" type="text" value="<?php echo $p->descripcion; ?>">
								</div>							
								<div class="span5">
									<label>Imagen Grande - Tamaño Recomendado: 1170 x 450</label>
									<img id="imagenCatBlog">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status1"></div>
									<img src="<?php echo $p->imagen ?>" />
								</div>
								<div class="span5">
									<label>Icono - Tamaño Recomendado: 35 x 98</label>
									<img id="iconoCatBlog">
									<div id="multiplefileuploader2">Subir</div>
									<div id="status2"></div>
									<img src="<?php echo $p->icono ?>" />
								</div>
								<div class="span5"></div>
								<div class="span10">
									<a href="javascript: guardarCategoria(<?php echo $p->id; ?>);">
					  					<div id="btn_categoriaBlog" class="btn btn-primary">
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
			var imagen1, imagen2;
		var settings1 = {
		    url: "<?php echo JURI::base(); ?>subirImagen.php",
		    formData: {
		    	"tipo":"blog",
		    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
		    },
			onSuccess:function(files,data,xhr){
		       console.log(jQuery(this));
		       imagen1=data;
		       jQuery("#imagenCatBlog").attr("src","<?php echo JURI::base(); ?>"+data);
		       jQuery("#imagenCatBlog").fadeIn();
		    },
		    deleteCallback: function(data,pd){
			    for(var i=0;i<data.length;i++){
			        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
			        function(resp, textStatus, jqXHR){
			            jQuery("#imagenCatBlog").fadeOut();
			            alert("Archivo borrado");  
			        });
			    }      
			    pd.statusbar.hide(); //You choice to hide/not.
			}
		}
		var settings2 = {
	    url: "<?php echo JURI::base(); ?>subirImagen.php",
	    formData: {
	    	"tipo":"blog",
	    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
	    },
		onSuccess:function(files,data,xhr){
	       console.log(jQuery(this));
	       imagen2=data;
	       jQuery("#iconoCatBlog").attr("src","<?php echo JURI::base(); ?>"+data);
	       jQuery("#iconoCatBlog").fadeIn();
	    },
	    deleteCallback: function(data,pd){
		    for(var i=0;i<data.length;i++){
		        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
		        function(resp, textStatus, jqXHR){
		            jQuery("#iconoCatBlog").fadeOut();
		            alert("Archivo borrado");  
		        });
		    }      
		    pd.statusbar.hide(); //You choice to hide/not.
		}
	}
	
	var uploadObj1 = jQuery("#multiplefileuploader1").uploadFile(settings1);
	var uploadObj2 = jQuery("#multiplefileuploader2").uploadFile(settings2);

			jQuery("#btn_categoriaBlog").click(function(){
					jQuery.ajax({
					type: "GET",
					url: "index.php?option=com_functions&task=guardarCategoriaBlog",
					data: { 
						id: <?php echo $idCategoria; ?>,
						categoria: jQuery("#categoriaBlog").val(),
						descripcion: jQuery("#descripcionBlog").val(),
						imagen: imagen1,
						icono: imagen2
					},
					success: function( response ) {
						if( response ){
							alert("Tu categoria se ha modificado correctamente");
							location.assign("index.php?option=com_somosmaestros&view=categoriasblog&Itemid=403");
						};
					}
				});
			});
		});
</script>