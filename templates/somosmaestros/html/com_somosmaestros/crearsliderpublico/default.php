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
	$doc->addScript('templates/somosmaestros/js/uploadfile.js');
	$doc->addStyleSheet('templates/somosmaestros/css/uploadfile.css');
	require_once 'templates/somosmaestros/code/SMBrujula.php';

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
							<form id="formCrearArticulo" class="row form-crear">

								<div class="span5">
									<label for="tituloSliderPublico">Título:</label>
									<input name="tituloSliderPublico" id="tituloSliderPublico" type="text">
								</div>	
								<div class="span5">
									<label for="linkSliderPublico">URL:</label>
									<input name="linkSliderPublico" id="linkSliderPublico" type="text">
								</div>							
								<div class="span10">
									<label for="descripcionSliderPublico">Descripción:</label>
									<input name="descripcionSliderPublico" id="descripcionSliderPublico" type="text">
								</div>
								<div class="span10">
									<label>Imagen - Tamaño Recomendado: 1642 x 497</label>
									<img id="imageSliderPublico">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status1"></div>
								</div>
								<div class="span5"></div>
								<div class="span10">
									<div id="btn_crearSliderPublico" class="btn btn-primary">
										<i class="icon-bookmark icon-white"></i> Crear Slider
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

jQuery(document).ready(function(){
	var imagen1;
	var settings1 = {
	    url: "<?php echo JURI::base(); ?>subirImagen.php",
	    formData: {
	    	"tipo":"sliderPrincipal",
	    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
	    },
		onSuccess:function(files,data,xhr){
	       console.log(jQuery(this));
	       imagen1=data;
	       jQuery("#imageSliderPublico").attr("src","<?php echo JURI::base(); ?>"+data);
	       jQuery("#imageSliderPublico").fadeIn();
	    },
	    deleteCallback: function(data,pd){
		    for(var i=0;i<data.length;i++){
		        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
		        function(resp, textStatus, jqXHR){
		            jQuery("#imageSliderPublico").fadeOut();
		            alert("Archivo borrado");  
		        });
		    }      
		    pd.statusbar.hide(); //You choice to hide/not.
		}
	}

	var uploadObj1 = jQuery("#multiplefileuploader1").uploadFile(settings1);

		jQuery("#btn_crearSliderPublico").click(function(){
				jQuery.ajax({
				type: "GET",
				url: "index.php?option=com_functions&task=crearSliderPublico",
				data: { 
					titulo: jQuery("#tituloSliderPublico").val(),
					link: jQuery("#linkSliderPublico").val(),
					descripcion: jQuery("#descripcionSliderPublico").val(),
					imagen: imagen1
				},
				success: function( response ) {
					if( response ){
						alert("Tu slider público se ha creado correctamente");
						location.assign("index.php?option=com_somosmaestros&view=sliderpublicos&Itemid=407");
					};
				}
			});
		});

});

</script>