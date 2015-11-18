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
	$doc->addScript("templates/somosmaestros/js/datepicker.js");
	$doc->addScript("templates/somosmaestros/js/datepicker_es.js");
	$doc->addStyleSheet("templates/somosmaestros/css/datepicker.css");
	$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
	$doc->addScript('templates/somosmaestros/js/loading.js');	
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
							<form id="formCrearCampana" class="row form-crear">

								<div class="span5">
									<label for="nombreCampana">Nombre:</label>
									<input name="nombreCampana" id="nombreCampana" type="text">
								</div>		
								<div class="span10">
									<label for="tipoCampana">Tipo:</label>
									<select name="tipoCampana" id="tipoCampana">
										<option value="0" selectedt="selected">Selecciona el tipo</option>
										<option value="1">Formación</option>
										<option value="2">Blog</option>
										<option value="3">Perfil</option>
									</select>
								</div>		
								<div class="span5">
									<label for="inicioCampana">Fecha de inicio</label>
									<input name="inicioCampana" id="inicioCampana" class="datepicker">
								</div>
								<div class="span5">
									<label for="finCampana">Fecha de finalización</label>
									<input name="finCampana" id="finCampana" class="datepicker">
								</div>	

								<div class="span5">
									<label id="labelCampana" for="publicoCampana">Campaña Pública?</label>
									<select name="publicoCampana" id="publicoCampana">
										<option value="<?php echo 0; ?>">NO</option>
										<option value="<?php echo 1; ?>">SI</option>
									</select>
								</div>
								<div id="segmentacion">
									<div class="span10">
										<h5>Segmentación:</h5>
									</div>								
									<div class="span5">
										<label for="delegacionCampana">Delegación</label>
										<select class="chosen-choices" name="delegacionCampana" id="delegacionCampana" multiple>
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
										<label for="institucionCampana">Tipo de Institución: </label>
										<select class="chosen-choices" name="institucionCampana" id="institucionCampana" multiple>
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
										<label for="segmentoCampana">Segmento: </label>
										<select class="chosen-choices" name="segmentoCampana" id="segmentoCampana" multiple>
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
										<label for="nivelCampana">Nivel:</label>
										<select class="chosen-choices" name="nivelCampana" id="nivelCampana" multiple>
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
										<label for="ciudadCampana">Ciudad:</label>
										<select class="chosen-choices" name="ciudadCampana" id="ciudadCampana" multiple>
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
										<label for="areaCampana">Área</label>
										<select class="chosen-choices" name="areaCampana" id="areaCampana" multiple>
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
										<label for="rolCampana">Rol</label>
										<select class="chosen-choices" name="rolCampana" id="rolCampana" multiple>
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
										<label for="proyectoCampana">Proyecto</label>
										<select class="chosen-choices" name="proyectoCampana" id="proyectoCampana" multiple>
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
									<label for="publicacionCampana" class="labelPublicacion">Publicación</label>
									<select name="publicacionCampana" id="publicacionCampana">
										<option value="0" selected="selected">Selecciona la publicación</option>
									</select>
								</div>
								<div class="span5">
									<label for="puntosCampana">Puntos:</label>
									<input name="puntosCampana" id="puntosCampana" type="text">
								</div>
								<div class="span5">
									<label for="metaCampana">Meta:</label>
									<input name="metaCampana" id="metaCampana" type="text">
								</div>		
								<div class="span5">
									<label for="metarCampana" class="metarCampana">Meta Reservas:</label>
									<input name="metarCampana" id="metarCampana" type="text">
								</div>						
								
								<div class="span5"></div>
								<div class="span10">
									<div id="btn_crearCampana" class="btn btn-primary btn-publicar">
										<i class="icon-bookmark icon-white"></i> Crear Campaña
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
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

	jQuery(".chosen-choices").chosen();

	jQuery('.datepicker').datepicker({
			language: "es",
			format:'yyyy-mm-dd'
		});

	jQuery('#tipoCampana').change(function(){
			jQuery('#publicacionCampana').html('<option value="0" selected="selected">Selecciona la publicación</option>');
			var tipo = jQuery(this).val();
			if(tipo === '3'){
				jQuery('#publicacionCampana').slideUp();
				jQuery('.labelPublicacion').slideUp();
				jQuery('#metarCampana').slideUp();
				jQuery('.metarCampana').slideUp();
				jQuery('#publicoCampana').slideDown();
				jQuery('#labelCampana').slideDown();
			}else{
				jQuery('.labelPublicacion').slideDown();
				jQuery('#publicacionCampana').slideDown();
				jQuery('#publicoCampana').slideUp();
				jQuery('#labelCampana').slideUp();
				jQuery('#metarCampana').slideUp();
				jQuery('.metarCampana').slideUp();
				Pace.track(function(){
					jQuery.ajax({
						url: 'index.php?option=com_functions&task=obtenerPublicacionesCampanas',
						type: 'GET',
						dataType: 'json',
						data: {tipo: tipo},
					})
					.done(function(publicaciones) {
						jQuery.each(publicaciones, function(ix, vx) {
							jQuery('#publicacionCampana').append('<option value="'+vx.id+'">'+vx.titulo+'</option>');
						});
					});
				});
			}
			
		});

	jQuery('#publicoCampana').change(function(){
		var tipo = jQuery(this).val();
		if(tipo == 0){
				jQuery('#segmentacion').slideDown();
		} else if (tipo == 1) {
				jQuery('#segmentacion').slideUp();		
		}
	});

	jQuery("#btn_crearCampana").click(function(){			
		jQuery.ajax({
			type: "POST",
			url: "index.php?option=com_functions&task=crearCampana",
			data: { 
				nombre: jQuery("#nombreCampana").val(),
				tipo: jQuery("#tipoCampana").val(),
				fechaInicio: jQuery("#inicioCampana").val(),
				fechaFin: jQuery("#finCampana").val(),
				delegacion: jQuery("#delegacionCampana").val(),
				tipoInstitucion: jQuery("#institucionCampana").val(),
				segmento: jQuery("#segmentoCampana").val(),
				nivel: jQuery("#nivelCampana").val(),
				ciudad: jQuery("#ciudadCampana").val(),
				area: jQuery("#areaCampana").val(),
				rol: jQuery("#rolCampana").val(),
				proyecto: jQuery("#proyectoCampana").val(),
				publicacion: jQuery('#publicacionCampana').val(),
				puntos: jQuery('#puntosCampana').val(),
				meta: jQuery('#metaCampana').val(),
				meta_reservas: jQuery('#metarCampana').val()
			},
			success: function( response ) {
				if( response ){
					alert("La campaña se ha creado correctamente");
					location.assign("index.php?option=com_somosmaestros&view=administradores&Itemid=225");
				};
			}
		});
	});

});
</script>