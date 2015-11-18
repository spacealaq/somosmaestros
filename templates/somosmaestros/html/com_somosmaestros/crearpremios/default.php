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
	$doc->addScript('templates/somosmaestros/js/chosen.jquery.min.js');
	$doc->addStyleSheet('templates/somosmaestros/css/chosen.min.css');
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
							<form id="formCrearPremio" class="row form-crear">
								<div class="span5">
									<label for="nombrePremio">Premio:</label>
									<input name="nombrePremio" id="nombrePremio" type="text">
								</div>				
								<div class="span5">
									<label for="puntosPremio">Puntos:</label>
									<input name="puntosPremio" id="puntosPremio" type="text">
								</div>			
								<div class="span5">
									<label for="cantidadPremio">Cantidad:</label>
									<input name="cantidadPremio" id="cantidadPremio" type="text">
								</div>					
								<div class="span5">
									<label for="descripcionPremio">Descripción:</label>
									<input name="descripcionPremio" id="descripcionPremio" type="text">
								</div>
								<div class="span10"></div>
								<div class="span5">
									<label>Imagen Pequeña - Tamaño Recomendado 400 x 400</label>
									<img id="imagenPremio" class="imagenPequeña">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status2"></div>
								</div>	
								<div class="span10">
									<h5>Segmentación:</h5>
								</div>								
								<div class="span5">
									<label for="rolPremio">Rol:</label>
									<select class="chosen-choices" name="rolPremio" id="rolPremio" multiple>
										<?php
											$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
											$query = 'SELECT rolescontacto.RcId, rolescontacto.RcNombre FROM smbrujul_produccion.rolescontacto WHERE rolescontacto.RcId IN ("C", "P", "R") ORDER BY rolescontacto.RcNombre ';
											$db->setQuery($query);
											$roles = $db->loadObjectList();
											foreach ($roles as $r) {
												echo '<option value="'.$r->RcNombre.'">'.$r->RcNombre.'</option>';
											}
										?>
									</select>
								</div>		
								<div class="span10">
									<div id="btn_crearPremio" style="margin-top:10px;"class="btn btn-primary">
										<i class="icon-bookmark icon-white"></i> Crear Premio
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
	jQuery(".chosen-choices").chosen();
	var imagen1;
	var settings1 = {
	    url: "<?php echo JURI::base(); ?>subirImagen.php",
	    formData: {
	    	"tipo":"premios",
	    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
	    },
		onSuccess:function(files,data,xhr){
	       console.log(jQuery(this));
	       imagen1=data;
	       jQuery("#imagenPremio").attr("src","<?php echo JURI::base(); ?>"+data);
	       jQuery("#imagenPremio").fadeIn();
	    },
	    deleteCallback: function(data,pd){
		    for(var i=0;i<data.length;i++){
		        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
		        function(resp, textStatus, jqXHR){
		            jQuery("#imagenPremio").fadeOut();
		            alert("Archivo borrado");  
		        });
		    }      
		    pd.statusbar.hide(); //You choice to hide/not.
		}
	}

	var uploadObj1 = jQuery("#multiplefileuploader1").uploadFile(settings1);

		jQuery("#btn_crearPremio").click(function(){
				jQuery.ajax({
				type: "GET",
				url: "index.php?option=com_functions&task=crearPremio",
				data: { 
					premio: jQuery("#nombrePremio").val(),
					puntos: jQuery("#puntosPremio").val(),
					cantidad: jQuery("#cantidadPremio").val(),
					descripcion: jQuery("#descripcionPremio").val(),
					imagen: imagen1,
					rol: jQuery("#rolPremio").val()
				},
				success: function( response ) {
					if( response ){
						alert("Tu premio se ha creado correctamente");
						location.assign("index.php?option=com_somosmaestros&view=premios&Itemid=227");
					};
				}
			});
		});
</script>