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
require_once 'templates/somosmaestros/code/SMBrujula.php';
//Recibiendo datos

if($_GET['crearCampana']){
	$campana = new stdClass();
	$campana->state = 1;
	$campana->tipo=$_GET['tipoCampana'];
	$campana->fecha_inicio=$_GET['inicioCampana'];
	$campana->fecha_fin= $_GET['finCampana'];
	$campana->delegacion=$_GET['delegacionCampana'];
	$campana->ciudad=$_GET['ciudadCampana'];
	$campana->nivel=$_GET['nivelCampana'];
	$campana->area=$_GET['areaCampana'];
	$campana->proyecto=$_GET['proyectoCampana'];
	$campana->rol=$_GET['rolCampana'];
	$campana->publicacion=$_GET['publicacionCampana'];
	$campana->puntos=$_GET['puntosCampana'];
	$campana->meta=$_GET['metaCampana'];
	 
	// Insert the object into the user profile table.
	$result = JFactory::getDbo()->insertObject('#__somosmaestros_capanas', $campana);

	if($result){ 
		if ($_GET['tipoCampana'] == '4') {
			$nombreCampana = 'ACTUALIZAR PERFIL';
		}elseif ($_GET['tipoCampana'] == '3') {
			$nombreCampana = 'AGENDA';
		}elseif ($_GET['tipoCampana'] == '2') {
			$nombreCampana = 'BLOG';
		}elseif ($_GET['tipoCampana'] == '1') {
			$nombreCampana = 'FORMACION';
		}

		$db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
		$query2 = $db2->getQuery(true);
 		$columns = array('idtipopuntos','nombretipopuntos', 'puntostipopuntos');
		$values = array('NULL',$db2->quote($nombreCampana), (int)$_GET['puntosCampana']);
		$query2
		    ->insert($db2->quoteName('mkTipoPuntos'))
		    ->columns($db2->quoteName($columns))
		    ->values(implode(',', $values));
		 
		// Set the query using our newly populated query object and execute it.
		$db2->setQuery($query2);
		$db2->execute();



		?>
		<div class="alert alert-success">
		  <h3>Datos guardados</h3>
		  <strong>Felicidades! </strong> Tu campaña se creó correctamente
		</div>

	<?php }else{ ?>
		<div class="alert alert-error">
		  <strong>Error! </strong> Hubo un problema almacenando la campaña
		</div>
	<?php }
}



?>


	<div class="row">
		<div class="span12">
			<div class="row">
				<div class="span2">
					<a href="index.php?option=com_somosmaestros&view=administradores&Itemid=225" class="btn">Volver</a>
				</div>
				<div class="span10">
					<div class="row"> 
						<div class="span10">
							<form id="formCrearCampana" class="row form-crear" method="GET" action="index.php">
								<div class="span10">
									<label for="tipoCampana">Tipo</label>
									<select name="tipoCampana" id="tipoCampana">
										<option value="0" selectedt="selected">Selecciona el tipo</option>
										<option value="1">Formación</option>
										<option value="2">Blog</option>
										<option value="3">Agenda</option>
										<option value="4">Perfil</option>
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
									<label for="delegacionCampana">Delegación</label>
									<select name="delegacionCampana" id="delegacionCampana">
										<option value="0" selected="selected">Selecciona la delegacion</option>
										<?php
											$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
											$query = $db->getQuery(true);
											$query = 'SELECT * FROM smbrujul_produccion.regionales;';
											$db->setQuery($query);
											$regionales = $db->loadObjectList();
											foreach ($regionales as $r) {
												echo '<option value="'.$r->ReId.'">'.$r->ReNombre.'</option>';
											}
										?>
									</select>
								</div>
								<div class="span5">
									<label for="ciudadCampana">Ciudad</label>
									<select name="ciudadCampana" id="ciudadCampana">
										<option value="0" selected="selected">Selecciona la ciudad</option>
										<?php
											//require_once 'templates/somosmaestros/code/SMBrujula.php';
											$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
											$query = $db->getQuery(true);
											$query = 'SELECT * FROM smbrujul_produccion.ciudades';
											$db->setQuery($query);
											$ciudades = $db->loadObjectList();
											foreach ($ciudades as $c) {
												echo '<option value="'.$c->CiId.'">'.$c->CiNombre.'</option>';
											}
										?>
									</select>
								</div>
								<div class="span5">
									<label for="nivelCampana">Nivel</label>
									<select name="nivelCampana" id="nivelCampana">
										<option value="0" selected="selected">Selecciona el nivel</option>
										<?php
											//require_once 'templates/somosmaestros/code/SMBrujula.php';
											$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
											$query = $db->getQuery(true);
											$query = 'SELECT * FROM smbrujul_produccion.niveleseducativospais';
											$db->setQuery($query);
											$niveles = $db->loadObjectList();
											foreach ($niveles as $n) {
												echo '<option value="'.$n->NvId.'">'.$n->NvNombre.'</option>';
											}
										?>
									</select>
								</div>
								<div class="span5">
									<label for="areaCampana">Área</label>
									<select name="areaCampana" id="areaCampana">
										<option value="0" selected="selected">Selecciona el área</option>
										<?php
											//require_once 'templates/somosmaestros/code/SMBrujula.php';
											$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
											$query = $db->getQuery(true);
											$query = 'SELECT * FROM smbrujul_produccion.areas';
											$db->setQuery($query);
											$areas = $db->loadObjectList();
											foreach ($areas as $a) {
												echo '<option value="'.$a->AeId.'">'.$a->AeNombre.'</option>';
											}
										?>
									</select>
								</div>
								<div class="span5">
									<label for="proyectoCampana">Proyecto</label>
									<select name="proyectoCampana" id="proyectoCampana">
										<option value="0" selected="selected">Selecciona el proyecto</option>
										
									</select>
								</div>
								<div class="span5">
									<label for="rolCampana">Rol</label>
									<select name="rolCampana" id="rolCampana">
										<option value="0" selected="selected">Selecciona el rol</option>
										<?php
											//require_once 'templates/somosmaestros/code/SMBrujula.php';
											$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
											$query = $db->getQuery(true);
											$query = 'SELECT * FROM smbrujul_produccion.rolescontacto';
											$db->setQuery($query);
											$roles = $db->loadObjectList();
											foreach ($roles as $r) {
												echo '<option value="'.$r->RcId.'">'.$r->RcNombre.'</option>';
											}
										?>
									</select>
								</div>
								<div class="span10">
									<label for="publicacionCampana" class="labelPublicacion">Publicación</label>
									<select name="publicacionCampana" id="publicacionCampana">
										<option value="0" selected="selected">Selecciona la publicación</option>
									</select>
								</div>
								<div class="span5">
									<label for="puntosCampana">Puntos</label>
									<input name="puntosCampana" id="puntosCampana" type="text">
								</div>
								<div class="span5">
									<label for="metaCampana">Meta</label>
									<input name="metaCampana" id="metaCampana" type="text">
								</div>
								<div class="span5"></div>
								<div class="span5">
									<input id="guardarCampana" type="submit" value="Guardar Campaña" class="btn btn-primary">
								</div>
								

								<input type="hidden" value="com_somosmaestros" name="option" />
								<input type="hidden" value="crearcampaa" name="view" />
								<input type="hidden" value="237" name="Itemid" />
								<input type="hidden" value="1" name="crearCampana" />
							</form>
						</div>
					</div>
				    <?php

				    /*require_once 'templates/somosmaestros/code/SMEducativa.php';
					$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );*/

					/*$cedula = $session->get('cedula'); 
					// Create a new query object.
					$query = $db->getQuery(true);
					  
					// Select all records from the user profile table where key begins with "custom.".
					// Order it by the ordering field.
					$query = "SELECT
					smbrujul_produccion.rolescontacto.RcNombre,
					smbrujul_produccion.personas.PeIdentificacion,
					smbrujul_produccion.rolescontacto.RcId
					FROM
					smbrujul_produccion.contactosinstitucioneducativa
					INNER JOIN smbrujul_produccion.rolescontacto ON smbrujul_produccion.rolescontacto.RcId = smbrujul_produccion.contactosinstitucioneducativa.CnRolContacto
					INNER JOIN smbrujul_produccion.personas ON smbrujul_produccion.contactosinstitucioneducativa.CnPersona = smbrujul_produccion.personas.PeId
					WHERE
					smbrujul_produccion.personas.PeIdentificacion = '10545151'";

					$db->setQuery($query);

					$result = $db->loadObject();
					echo 'Consulta 1: ';
					print_r($result);
					echo '<br>';

					if($result->RcNombre == "RECTOR" || $result->RcNombre == "COORDINADOR ACADEMICO"){
						
						$db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
						$querySec = $db2->getQuery(true);
						$querySec = "SELECT
							personas.PeNombres,
							personas.PePrimerApellido,
							personas.PeIdentificacion,
							rolescontacto.RcNombre,
							ciudades.CiNombre,
							institucioneseducativas.IeNombre,
							valorizacioninstituciones.VieTipoInstitucion
							FROM
							rolescontacto
							INNER JOIN contactosinstitucioneducativa ON contactosinstitucioneducativa.CnRolContacto = rolescontacto.RcId
							INNER JOIN personas ON contactosinstitucioneducativa.CnPersona = personas.PeId
							INNER JOIN ciudades ON personas.PeCiudadResidencia = ciudades.CiId
							INNER JOIN localidades ON localidades.LoCiudad = ciudades.CiId
							INNER JOIN barrios ON barrios.BaLocalidad = localidades.LoId
							INNER JOIN institucioneseducativas ON institucioneseducativas.IeBarrio = barrios.BaId AND contactosinstitucioneducativa.CnInstitucionEducativa = institucioneseducativas.IeId
							INNER JOIN adopciones ON adopciones.ApInstitucionEducativa = institucioneseducativas.IeId
							INNER JOIN valorizacioninstituciones ON valorizacioninstituciones.VieInstitucionEducativa = institucioneseducativas.IeId AND valorizacioninstituciones.VieTemporadaNegocio = adopciones.ApTemporadaNegocio
							WHERE
							adopciones.ApTemporadaNegocio = 10
							AND rolescontacto.RcId = '".$result->RcId."'
							AND personas.PeIdentificacion = '10545151'
							GROUP BY
							personas.PeIdentificacion
							";

						
						$db2->setQuery($querySec);
						$result2 = $db2->loadObject();
						
						if($result2){
							echo "Consulta 2: ";
							print_r($result2);
							echo '<br>';
							
						}else{
							echo "Consulta2: NO".'<br>'; 
						}

					}*/




				    ?>
				</div>
			</div>
		</div>
		<div class="span5"></div>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery('.datepicker').datepicker({
			language: "es",
			format:'yyyy-mm-dd'
		});
		jQuery('#tipoCampana').change(function(){
			jQuery('#publicacionCampana').html('<option value="0" selected="selected">Selecciona la publicación</option>');
			var tipo = jQuery(this).val();
			if(tipo === '4'){
				jQuery('#publicacionCampana').slideUp();
				jQuery('.labelPublicacion').slideUp();
			}else{
				jQuery('.labelPublicacion').slideDown();
				jQuery('#publicacionCampana').slideDown();
				Pace.track(function(){
					jQuery.ajax({
						url: 'index.php?option=com_functions&task=obtenerPublicaciones',
						type: 'GET',
						dataType: 'json',
						data: {tipo: tipo},
					})
					.done(function(publicaciones) {
						jQuery.each(publicaciones, function(ix, vx) {
							jQuery('#publicacionCampana').append('<option value="'+vx.id+'">'+vx.title+'</option>');
						});
					});
				});
			}
			
		});
	});
	</script>


<?php
	
}else{ ?>

	<div class="alert alert-error">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Permiso denegado! </strong> Área restringida
	</div>
	<?php

};



?>

