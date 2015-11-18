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

$idSlider = JRequest::getVar('id');

jimport('joomla.application.component.model');
$modeloSliderPub = JModelLegacy::getInstance( 'Sliderpublicos', 'SomosmaestrosModel' );
$parametrosSlider = $modeloSliderPub->getItems();

if($user->get('id') ){ 
	$doc = JFactory::getDocument();
	$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
	$doc->addScript('templates/somosmaestros/js/loading.js');
	$doc->addScript('templates/somosmaestros/js/jquery.bxslider.min.js');
	$doc->addStyleSheet('templates/somosmaestros/css/jquery.bxslider.css');
	$doc->addScript('templates/somosmaestros/js/uploadfile.js');
	$doc->addStyleSheet('templates/somosmaestros/css/uploadfile.css');

	foreach ($parametrosSlider as $p) { 
 		if($p->id == $idSlider){
?>
<div class="row">
		<div class="span12">
			<div class="row">
				<div class="span2">
					<a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a>
				</div>
				<div class="span10">
					<div class="row"> 
						<div class="span10" id="bxslider_publico">
							<ul id="bxslider-p">
							  <li><a target="_blank" href="<?php echo $p->link ?>"> <img src="<?php echo $p->imagen_publico ?>" <?php if($p->titulo && $p->descripcion){ ?>title="<?php echo $p->titulo ?><br/><?php echo $p->descripcion ?>" <?php } ?>/></a></li>
							</ul>
						</div>
						<div class="span10">
							<form id="formCrearSliderPublico" class="row form-crear">

								<div class="span5">
									<label for="tituloSliderPublico">Título:</label>
									<input name="tituloSliderPublico" id="tituloSliderPublico" type="text" value="<?php echo $p->titulo ?>">
								</div>
								<div class="span5">
									<label for="linkSliderPublico">URL:</label>
									<input name="linkSliderPublico" id="linkSliderPublico" type="text" value="<?php echo $p->link ?>">
								</div>										
								<div class="span10">
									<label for="descripcionSliderPublico">Descripción:</label>
									<input name="descripcionSliderPublico" id="descripcionSliderPublico" type="text" value="<?php echo $p->descripcion ?>">
								</div>
								<div class="span10">
									<label>Imagen - Tamaño Recomendado: 1642 x 497</label>
									<img id="imageSliderPublico">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status1"></div>
								</div>
								<div class="span5"></div>
								<div class="span10">
									<div id="btn_guardarSliderPublico" class="btn btn-primary">
										<i class="icon-bookmark icon-white"></i> Guardar Slider
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
jQuery(document).ready(function($){
  jQuery('#bxslider-p').bxSlider({
	  mode: 'fade',
	  captions: true,
	  resize: true
	});
		
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

		jQuery("#btn_guardarSliderPublico").click(function(){
				jQuery.ajax({
				type: "GET",
				url: "index.php?option=com_functions&task=guardarSliderPublico",
				data: { 
					id: <?php echo $idSlider; ?>,
					titulo: jQuery("#tituloSliderPublico").val(),
					link: jQuery("#linkSliderPublico").val(),
					descripcion: jQuery("#descripcionSliderPublico").val(),
					imagen: imagen1
				},
				success: function( response ) {
					if( response ){
						alert("Tu slider público se ha modificado correctamente");
						location.reload();
					};
				}
			});
		});
	
});


</script>