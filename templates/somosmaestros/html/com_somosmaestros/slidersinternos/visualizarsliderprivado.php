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
$modeloSliderInt = JModelLegacy::getInstance( 'Slidersinternos', 'SomosmaestrosModel' );
$parametrosSlider = $modeloSliderInt->getItems();

if($user->get('id') ){ 
	$doc = JFactory::getDocument();
	$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
	$doc->addScript('templates/somosmaestros/js/loading.js');
	$doc->addScript('templates/somosmaestros/js/jquery.bxslider.min.js');
	$doc->addStyleSheet('templates/somosmaestros/css/jquery.bxslider.css');
	$doc->addScript('templates/somosmaestros/js/uploadfile.js');
	$doc->addStyleSheet('templates/somosmaestros/css/uploadfile.css');
	$doc->addScript('templates/somosmaestros/js/chosen.jquery.min.js');
	$doc->addStyleSheet('templates/somosmaestros/css/chosen.min.css');
	require_once 'templates/somosmaestros/code/SMBrujula.php';

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
						<div class="span10" id="bxslider-interno">
							<ul class="bxslider">
							  <li><a target="_blank" href="<?php echo $p->link ?>"><img src="<?php echo $p->imagen_interno ?>" <?php if($p->titulo && $p->descripcion){ ?>title="<?php echo $p->titulo ?><br/><?php echo $p->descripcion ?>" <?php } ?>/></a></li>
							</ul>
						</div>
						<div class="span10">
							<form id="formCrearSliderInterno" class="row form-crear">

								<div class="span5">
									<label for="tituloSliderInterno">Título:</label>
									<input name="tituloSliderInterno" id="tituloSliderInterno" type="text" value="<?php echo $p->titulo ?>">
								</div>	
								<div class="span5">
									<label for="linkSliderInterno">URL:</label>
									<input name="linkSliderInterno" id="linkSliderInterno" type="text" value="<?php echo $p->link ?>">
								</div>			
								<div class="span5">
									<label for="publicoSliderInterno">¿Slider Público?</label>
									<select name="publicoSliderInterno" id="publicoSliderInterno">
										<option selected value="<?php echo $p->publico ?>"><?php if($p->publico != 0){echo 'SI';} else {echo 'NO';}?></option>
										<?php
											if($p->publico != 0){
												echo '<option value="0">NO</option>';
											} else {
												echo '<option value="1">SI</option>';
											}										
										?>
									</select>
								</div>						
								<div class="span10">
									<label for="descripcionSliderInterno">Descripción:</label>
									<input name="descripcionSliderInterno" id="descripcionSliderInterno" type="text" value="<?php echo $p->descripcion ?>">
								</div>
								<div class="span10">
									<label>Imagen - Tamaño Recomendado: 1642 x 497</label>
									<img id="imageSliderInterno">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status1"></div>
								</div>
								<div class="span5"></div>				
								<div id="segmentacion">
									<div class="span10">
										<h5 class="segmentacion">Segmentación:</h5>
									</div>								
									<div class="span5">
										<label for="delegacionSliderInterno">Delegación</label>
										<?php echo $p->delegacion ?>
										<select class="chosen-choices" name="delegacionSliderInterno" id="delegacionSliderInterno" multiple>
											<?php
												$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
												$query = $db->getQuery(true);
												$query = 'SELECT * FROM smbrujul_produccion.regionales;';
												$db->setQuery($query);
												$regionales = $db->loadObjectList();
												foreach ($regionales as $r) {
													echo '<option value="'.$r->ReNombre.'">'.$r->ReNombre.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="tipoSliderInterno">Tipo de Institución: </label>
										<?php echo $p->tipo_institucion ?>
										<select class="chosen-choices" name="tipoSliderInterno" id="tipoSliderInterno" multiple>
											<?php
												$db = JFactory::getDbo();
												$query = 'SELECT * FROM #__somosmaestros_tipo_institucion WHERE state = 1';
												$db->setQuery($query);
												$tipoInstitucion = $db->loadObjectList();
												foreach ($tipoInstitucion as $t) {
													echo '<option value="'.$t->tipo.'">'.$t->tipo.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="segmentoSliderInterno">Segmento: </label>
										<?php echo $p->segmento ?>
										<select class="chosen-choices" name="segmentoSliderInterno" id="segmentoSliderInterno" multiple>
											<?php
												$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
												$query = $db->getQuery(true);
												$query = 'SELECT * FROM smbrujul_produccion.tipossector;';
												$db->setQuery($query);
												$tipossector = $db->loadObjectList();
												foreach ($tipossector as $s) {
													echo '<option value="'.$s->TcNombre.'">'.$s->TcNombre.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="nivelSliderInterno">Nivel:</label>
										<?php echo $p->nivel ?>
										<select class="chosen-choices" name="nivelSliderInterno" id="nivelSliderInterno" multiple>
											<?php
												$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
												$query = $db->getQuery(true);
												$query = 'SELECT * FROM smbrujul_produccion.niveleseducativospais';
												$db->setQuery($query);
												$niveles = $db->loadObjectList();
												foreach ($niveles as $n) {
													echo '<option value="'.$n->NvNombre.'">'.$n->NvNombre.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="ciudadSliderInterno">Ciudad:</label>
										<?php echo $p->ciudad ?>
										<select class="chosen-choices" name="ciudadSliderInterno" id="ciudadSliderInterno" multiple>
											<?php
												$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
												$query = $db->getQuery(true);
												$query = 'SELECT * FROM smbrujul_produccion.ciudades';
												$db->setQuery($query);
												$ciudades = $db->loadObjectList();
												foreach ($ciudades as $c) {
													echo '<option value="'.$c->CiNombre.'">'.$c->CiNombre.'</option>';
												}
											?>
										</select>
									</div>			
									<div class="span5">
										<label for="areaSliderInterno">Área</label>
										<?php echo $p->area ?>
										<select class="chosen-choices" name="areaSliderInterno" id="areaSliderInterno" multiple>
											<?php
												$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
												$query = $db->getQuery(true);
												$query = 'SELECT * FROM smbrujul_produccion.areas';
												$db->setQuery($query);
												$areas = $db->loadObjectList();
												foreach ($areas as $a) {
													echo '<option value="'.$a->AeNombre.'">'.$a->AeNombre.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="rolSliderInterno">Rol</label>
										<?php echo $p->rol ?>
										<select class="chosen-choices" name="rolSliderInterno" id="rolSliderInterno" multiple>
											<?php
												$query = $db->getQuery(true);
												$query = 'SELECT rolescontacto.RcId, rolescontacto.RcNombre FROM smbrujul_produccion.rolescontacto WHERE rolescontacto.RcId IN ("C", "P", "R") ORDER BY rolescontacto.RcNombre ';
												$db->setQuery($query);
												$roles = $db->loadObjectList();
												foreach ($roles as $r) {
													echo '<option value="'.$r->RcNombre.'">'.$r->RcNombre.'</option>';
												}
											?>
										</select>
									</div>

									<div class="span5">
										<label for="proyectoSliderInterno">Proyecto</label>
										<?php echo $p->proyecto ?>
										<select class="chosen-choices" name="proyectoSliderInterno" id="proyectoSliderInterno" multiple>
											<?php
												$query = $db->getQuery(true);
												$query = 'SELECT agrupaciones.AcNombre, agrupaciones.AcId FROM smbrujul_produccion.productos INNER JOIN smbrujul_produccion.agrupaciones ON productos.PcAgrupacion = agrupaciones.AcId WHERE productos.PcId IN (7504, 7417, 7480, 7551, 9129, 10215, 13013, 7492, 1980, 13406, 12982, 13079, 8940, 13022, 13072, 2014, 7545, 6010, 13036, 7486, 13060, 7515, 8931, 13066, 2016, 12936, 12960,4098, 6049, 1921, 8858, 8995, 8905, 5920, 12997, 12924, 6061, 13017, 8934, 13048, 7467, 12985) ORDER BY agrupaciones.AcNombre';
												$db->setQuery($query);
												$proyectos = $db->loadObjectList();
												print_r($proyectos);
												foreach ($proyectos as $pr) {
													echo '<option value="'.$pr->AcNombre.'">'.$pr->AcNombre.'</option>';
												}
											?>


										</select>
									</div>	
								</div>
								<div class="span10">
									<div id="btn_guardarSliderInterno" class="btn btn-primary">
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

	var tipo = jQuery('#publicoSliderInterno').val();
		if(tipo === '1'){
			jQuery('#segmentacion').slideUp();
			jQuery('.segmentacion').slideUp();
		}

	jQuery('#publicoSliderInterno').change(function(){
		var tipo = jQuery('#publicoSliderInterno').val();
		if(tipo === '1'){
			jQuery('#segmentacion').slideUp();
			jQuery('.segmentacion').slideUp();
		}else{
			jQuery('.segmentacion').slideDown();
			jQuery('#segmentacion').slideDown();
		}
	});

  jQuery(".chosen-choices").chosen();
  jQuery('.bxslider').bxSlider({
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
		       jQuery("#imageSliderInterno").attr("src","<?php echo JURI::base(); ?>"+data);
		       jQuery("#imageSliderInterno").fadeIn();
		    },
		    deleteCallback: function(data,pd){
			    for(var i=0;i<data.length;i++){
			        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
			        function(resp, textStatus, jqXHR){
			            jQuery("#imageSliderInterno").fadeOut();
			            alert("Archivo borrado");  
			        });
			    }      
			    pd.statusbar.hide(); //You choice to hide/not.
			}
		}
		
		var uploadObj1 = jQuery("#multiplefileuploader1").uploadFile(settings1);

		jQuery("#btn_guardarSliderInterno").click(function(){
				jQuery.ajax({
				type: "POST",
				url: "index.php?option=com_functions&task=guardarSliderInterno",
				data: { 
					id: <?php echo $idSlider; ?>,
					titulo: jQuery("#tituloSliderInterno").val(),
					publico: jQuery("#publicoSliderInterno").val(),
					link: jQuery("#linkSliderInterno").val(),
					descripcion: jQuery("#descripcionSliderInterno").val(),
					imagen: imagen1,
					delegacion: jQuery("#delegacionSliderInterno").val(),
					tipoInstitucion: jQuery("#tipoSliderInterno").val(),
					segmento: jQuery("#segmentoSliderInterno").val(),
					nivel: jQuery("#nivelSliderInterno").val(),
					ciudad: jQuery("#ciudadSliderInterno").val(),
					area: jQuery("#areaSliderInterno").val(),
					rol: jQuery("#rolSliderInterno").val(),
					proyecto: jQuery("#proyectoSliderInterno").val()
				},
				success: function( response ) {
					if( response ){
						alert("Tu slider interno se ha modificado correctamente");
						location.reload();
					};
				}
			});
		});
	
});


</script>