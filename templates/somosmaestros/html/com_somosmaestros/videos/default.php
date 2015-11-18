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

jimport('joomla.application.component.model');
$modeloVideo = JModelLegacy::getInstance( 'Videos', 'SomosmaestrosModel' );
$video = $modeloVideo->getItems();

if($user->get('id') ){ 
	$doc = JFactory::getDocument();
	$doc->addScript('templates/somosmaestros/js/uploadfile.js');
	$doc->addStyleSheet('templates/somosmaestros/css/uploadfile.css');
	foreach ($video as $v) { 
?>

	<div class="row">
		<div class="span12">
			<div class="row">
				<div class="span2">
					<?php
						jimport('joomla.application.module.helper');
						// this is where you want to load your module position
						$modules = JModuleHelper::getModules('loginJoomla');
						foreach($modules as $module){
							echo JModuleHelper::renderModule($module);
						} 
					?>
					<div id="menuAdministradores">
					<?php
						jimport('joomla.application.module.helper');
						// this is where you want to load your module position
						$modules2 = JModuleHelper::getModules('menuAdmin');
						foreach($modules2 as $module2){
							echo JModuleHelper::renderModule($module2);
						} 
					?>
					</div>
				</div>
				<div class="span10">
					<div class="row"> 
						<div class="span10">
							<form id="formPublicarVideo" class="row form-crear">

								<div class="span5">
									<label for="tituloVideo">Título:</label>
									<input name="tituloVideo" id="tituloVideo" type="text" value="<?php echo $v->titulo ?>">
								</div>
								<div class="span5">
									<label for="linkVideo">URL - Ej: <b>npBAvWWcF0Q</b></label>
									<input name="linkVideo" id="linkVideo" type="text" value="<?php echo $v->url ?>">
								</div>				
								<div class="span10">
									<label>Imagen Pequeña - Tamaño Recomendado 300 x 171</label>
									<img id="imageVideo">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status1"></div>
								</div>
								<div class="span5">
									<img src="<?php echo $v->imagen ?>" />
								</div>
								<div class="span10">
									<div id="btn_publicarVideo" class="btn btn-primary">
										<i class="icon-bookmark icon-white"></i> Publicar Video
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
		
		var imagen1;
		var settings1 = {
		    url: "<?php echo JURI::base(); ?>subirImagen.php",
		    formData: {
		    	"tipo":"articulos",
		    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
		    },
			onSuccess:function(files,data,xhr){
		       console.log(jQuery(this));
		       imagen1=data;
		       jQuery("#imageVideo").attr("src","<?php echo JURI::base(); ?>"+data);
		       jQuery("#imageVideo").fadeIn();
		    },
		    deleteCallback: function(data,pd){
			    for(var i=0;i<data.length;i++){
			        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
			        function(resp, textStatus, jqXHR){
			            jQuery("#imageVideo").fadeOut();
			            alert("Archivo borrado");  
			        });
			    }      
			    pd.statusbar.hide(); //You choice to hide/not.
			}
		}
		
		var uploadObj1 = jQuery("#multiplefileuploader1").uploadFile(settings1);

		jQuery("#btn_publicarVideo").click(function(){
				jQuery.ajax({
				type: "GET",
				url: "index.php?option=com_functions&task=guardarVideo",
				data: { 
					id:'1',
					titulo: jQuery("#tituloVideo").val(),
					link: jQuery("#linkVideo").val(),
					imagen: imagen1
				},
				success: function( response ) {
					if( response ){
						alert("Tu video se ha publicado correctamente");
						location.reload();
					};
				}
			});
		});
	
});


</script>