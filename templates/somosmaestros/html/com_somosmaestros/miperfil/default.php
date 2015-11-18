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

$doc = JFactory::getDocument();
$doc->addScript("templates/somosmaestros/js/datepicker.js");
$doc->addStyleSheet("templates/somosmaestros/css/datepicker.css");
$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
$doc->addScript('templates/somosmaestros/js/password.js');
$doc->addScript('templates/somosmaestros/js/passwordplus.js');
$doc->addScript('templates/somosmaestros/js/loading.js');



$session =& JFactory::getSession();
require_once 'templates/somosmaestros/code/SMEducativa.php';
$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );

$cedula = $session->get('cedula');
$fecha = $session->get('fecha_nacimiento');
$nombre = $session->get('nombre');
$apellido1 = $session->get('apellido1');
$apellido2 = $session->get('apellido2');
$telefono = $session->get('telefono');
$correo = $session->get('correo');
$departamento = $session->get('departamento');
$ciudad = $session->get('ciudad');
$institucion = $session->get('institucion');
$genero = $session->get('genero');


/*
// Create a new query object.
$query = $db->getQuery(true);
 
// Select all records from the user profile table where key begins with "custom.".
// Order it by the ordering field.
$query->select($db->quoteName(array('documento', 'nombre','apellido','genero','telefono','fecha_nacim','ciudad','institucion','grado','curso')));
$query->from($db->quoteName('persona'));
$query->where($db->quoteName('documento') . ' = '. $cedula);
// Reset the query using our newly populated query object.
$db->setQuery($query);
 
// Load the results as a list of stdClass objects (see later for more options on retrieving data).
$query->select($db->quoteName(array('correo','text_pwd')));
$query->from($db->quoteName('usuario'));
$query->where($db->quoteName('cedula') . ' = '. $cedula);
// Reset the query using our newly populated query object.
$db->setQuery($query);
 
// Load the results as a list of stdClass objects (see later for more options on retrieving data).
$infoUsuario = $db->loadObject();
*/
require_once 'templates/somosmaestros/code/SMBrujula.php';
$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
$query = $db->getQuery(true);
$query->select($db->quoteName(array('DeId','DeNombre')));
$query->from($db->quoteName('departamentos'));
// Reset the query using our newly populated query object.
$db->setQuery($query);
$departamentos = $db->loadObjectList();

$db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
$query2 = $db2->getQuery(true);
$query2->select($db2->quoteName(array('CiId','CiNombre','CiDepartamento')));
$query2->from($db2->quoteName('ciudades'));
// Reset the query using our newly populated query object.
$db2->setQuery($query2);
$ciudades = $db2->loadObjectList();

$db3 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
$query3 = $db3->getQuery(true);
$query3->select($db3->quoteName(array('IeId','IeNombre')));
$query3->from($db3->quoteName('institucioneseducativas'));
// Reset the query using our newly populated query object.
$db3->setQuery($query3);
$colegios = $db3->loadObjectList();

//$departamentoActual
foreach ($ciudades as $ci) {
	if($ci->CiId == $infoUsuario->ciudad){
		$departamentoActual = $ci->CiDepartamento;
	}
}

//Obtener Detalle Puntos
$db4 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
$query4 = $db4->getQuery(true);
$query4->select($db4->quoteName(array('idtipopuntos','cantidadpuntos')));
$query4->from($db4->quoteName('mkPuntos'));
$query4->where($db4->quoteName('documentopuntos') . ' = '. $db->quote($infoUsuario->documento));
$db4->setQuery($query4);
$puntos = $db4->loadObjectList();
$ptsPositivos = array();
$ptsNegativos = array();
foreach ($puntos as $pt) {
	$db5 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
	$query5 = $db5->getQuery(true);
	$query5->select($db5->quoteName(array('nombretipopuntos')));
	$query5->from($db5->quoteName('mkTipoPuntos'));
	$query5->where($db5->quoteName('idtipopuntos') . ' = '. $db->quote($pt->idtipopuntos));
	$db5->setQuery($query5);
	$pt->nombretipopuntos = $db5->loadResult();
	if((int)$pt->cantidadpuntos > 0){
		array_push($ptsPositivos, $pt);
	}else{
		array_push($ptsNegativos, $pt);
	}
} 


$cc = $session->get('cedula');

// Get a db connection.
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('id')));
$query->from($db->quoteName('#__somosmaestros_campana_perfil'));
$query->where($db->quoteName('cedula').' = '.$cc);
 
// Reset the query using our newly populated query object.
$db->setQuery($query);
 
// Load the results as a list of stdClass objects (see later for more options on retrieving data).
$results = $db->loadObjectList();

$puntosCampana = sizeof($results);


if($puntosCampana == 0) {
	// Get a db connection.
	$db2 = JFactory::getDbo();
	$query2 = $db2->getQuery(true);
	$query2->select($db2->quoteName(array('id')));
	$query2->from($db2->quoteName('#__somosmaestros_capanas'));
	$query2->where($db2->quoteName('tipo') . ' = 3');

	// Reset the query using our newly populated query object.
	$db2->setQuery($query);

	// Load the results as a list of stdClass objects (see later for more options on retrieving data).
	$results2 = $db2->loadObjectList();

	$campanaActiva = sizeof($results2);

	$idCampana = 0;

	foreach ($results2 as $r) {
		$idCampana = $r->id;
	}
}


// Ocultar para usuarios SM

$perfil = $session->get('perfil');

if($perfil){
?>
<div class="row">USUARIO SM</div>
<?php
} else{
?>
<div class="row">
	<div class="span7 offset1">
		<div class="row">
			<div class="span3">
			<?php if($session->get('genero') == 'M'){?><img src="templates/somosmaestros/images/avatar_nino.png"><? } else if($session->get('genero') == 'F'){ ?><img src="templates/somosmaestros/images/avatar_nina.png"> <? } else { ?> <img src="templates/somosmaestros/images/avatar_nino.png"> <? } ?>
			</div>
			<div class="span4">
			    <table class="table">
			   		<tr>
			   			<td><strong><?php echo $nombre.' '.$apellido1.' '.$apellido2; ?></strong></td>
			   		</tr>
			   		<tr>
			   			<td><strong>CC:</strong> <?php echo $cedula; ?></td>
			   		</tr>
			   		<tr>
			   			<td><strong>Mail:</strong> <?php echo $correo; ?></td>
			   		</tr>
			   		<tr>
			   			<td><strong>Tel:</strong> <?php echo $telefono; ?></td>
			   		</tr>
			    </table>
			</div>
		</div>
	</div>
	<div class="span5"></div>
</div>
<div class="row">
	<div class="span10 offset1">
	    <div class="tabbable"> <!-- Only required for left/right tabs -->
			<ul class="nav nav-tabs" id="tabsPerfil">
				<li class="active"><a href="#tab1" data-toggle="tab">Actualización de datos</a></li>
				<li><a href="#tab2" data-toggle="tab">Mis puntos</a></li>
				<li><a href="#tab4" data-toggle="tab">Redenciones</a></li>
			</ul>
			<div class="tab-content" id="contenidoPerfil">
				<div class="tab-pane active" id="tab1">
					<div class="tabbable"> <!-- Only required for left/right tabs -->
						<ul class="nav nav-tabs" id="tabsDatos">
							<li class="active"><a href="#tab1-1" data-toggle="tab">Datos básicos</a></li>
							<!--<li><a href="#tab1-2" data-toggle="tab">Hijos</a></li>-->
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab1-1">
								
								<h3>Profesor</h3>
								<form id="formDatosActualizar" method="POST" action="index.php?option=com_somosmaestros&view=miperfil&layout=actualizar&Itemid=121">
									<div class="row">
										<div class="span2">Cédula</div>
										<div class="span2"><strong><?php echo $cedula; ?></strong></div>
										<div class="span1"></div>
										<div class="span2">Fecha de Nacimiento</div>
										<div class="span2"><input class="datepicker" id="fecha_nacimiento" type="text" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>"></div>
									</div>
									<div class="row">
										<div class="span2">Nombres</div>
										<div class="span2"><input type="text" id="nombres" name="nombres" value="<?php echo $nombre; ?>"></div>
										<div class="span1"></div>
										<div class="span2">Apellidos</div>
										<div class="span2"><input type="text" id="apellidos" name="apellidos" value="<?php echo $apellido1.''.$apellido2;?>"></div>
									</div>
									<div class="row">
										<div class="span2">Teléfono</div>
										<div class="span2"><input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>"></div>
										<div class="span1"></div>
										<div class="span2">E-mail</div>
										<div class="span2"><input type="email" id="email" name="email" value="<?php echo $correo; ?>"></div>
										
									</div>
									<div class="row">
										<div class="span2">Departamento</div>
										<div class="span2">
											<select name="departamentos" id="departamentos">
												<option value="">Selecciona un departamento</option>
												<?php 
													if($departamento){
														echo '<option selected="selected" value="'.$departamento.'">'.$departamento.'</option>';
													}
													foreach ($departamentos as $d) {
														echo '<option value="'.$d->DeId.'">'.$d->DeNombre.'</option>';
												
												} ?>
											</select>
										</div>
										<div class="span1"></div>
										<div class="span2">Ciudad</div>
										<div class="span2">
											<select name="ciudad" id="ciudades">
												<option value="">Selecciona una ciudad</option>
												<?php if($ciudad){
														echo '<option selected="selected" value="'.$ciudad.'">'.$ciudad.'</option>';
													}
												foreach ($ciudades as $c) {													
														echo '<option value="'.$c->CiId.'">'.$c->CiNombre.'</option>';													
												} ?>
											</select>
										</div>
										
										
										
									</div>
									<div class="row">
										<div class="span2">Institución</div>
										
										<div class="span2">
											<select id="instituciones" name="institucion">
												<option value="">Selecciona una institución</option>
												<?php 
													if($institucion){
														echo '<option selected="selected" value="'.$institucion.'">'.$institucion.'</option>';
													}
													foreach ($colegios as $co) {
													
														echo '<option value="'.$co->IeId.'">'.$co->IeNombre.'</option>';
													
												} ?>
											</select>
										</div>
										<div class="span1"></div>
										<div class="span2">Género</div>
										<div class="span2">
											<select name="genero">
												<option value="">Selecciona</option>
												<option value="H" <?php if($genero == 'H'){ echo 'selected="selected"';} ?>>Hombre</option>
												<option value="F" <?php if($genero == 'F'){ echo 'selected="selected"';} ?>>Mujer</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="span5">Observaciones</div>
										<div class="span6"><textarea id="observaciones" width="100%" name="observaciones"></textarea></div>
									</div>

									<div class="row ">
										<?php
											if($campanaActiva == 0){
										?>
											<div class="span2">
												<input type="hidden" value="<?php echo $cedula; ?>" name="cedula" />
												<input class="btn btn-primary" type="submit" value="Actualizar datos">
											</div>
										<?php
											} else if ($campanaActiva > 0){
												echo '<button class="btn btn-primary" id="perfilCampana" type="button">Actualizar Datos</button>';
											}
										?>
									</div>

								</form>

							</div>
							<div class="tab-pane" id="tab1-2">
								<h3>Hijos</h3>
							</div>
						</div>
			    	</div>
				</div>
				<div class="tab-pane" id="tab2">
					<h3>Mis puntos</h3>
					    <table class="table table-hover table-bordered">
					    	<tbody>
								<tr class="titulosTabla">
									<td>Comportamiento</td>
									<td>Puntos</td>
								</tr>
								<?php 
								$sumaPos = 0;
								foreach ($ptsPositivos as $pp) {
									$sumaPos += (int)$pp->cantidadpuntos;
								?>
								<tr>
									<td><?php echo $pp->nombretipopuntos; ?></td>
									<td class="cantidadPuntos"><?php echo $pp->cantidadpuntos; ?></td>
								</tr>
								<?php } ?>
								
								<tr>
									<td><strong>Total</strong></td>
									<td class="cantidadPuntos"><strong><?php echo $sumaPos; ?></strong></td>
								</tr>
							</tbody>
					    </table>

				</div>
				<div class="tab-pane" id="tab4">
					<h3>Redenciones</h3>
					<table class="table table-hover table-bordered">
				    	<tbody>
							<tr class="titulosTabla">
								<td>Comportamiento</td>
								<td>Puntos</td>
							</tr>
							<?php 
							$sumaNeg = 0;
							foreach ($ptsNegativos as $pn) {
								$sumaNeg += (int)$pn->cantidadpuntos;
							?>
							<tr>
								<td><?php echo $pn->nombretipopuntos; ?></td>
								<td class="cantidadPuntos"><?php echo $pn->cantidadpuntos; ?></td>
							</tr>
							<?php } ?>
							
							<tr>
								<td><strong>Total</strong></td>
								<td class="cantidadPuntos"><strong><?php echo $sumaNeg; ?></strong></td>
							</tr>
						</tbody>
				    </table>
				</div>
			</div>
    	</div>
	</div>
</div>

<?php } ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery('.datepicker').datepicker({
			format:'yyyy-mm-dd'
		})
	});
	jQuery.extend(jQuery.validator.messages, {
	    required: "Este campo es obligatorio.",
	    email: "Por favor ingresa un e-mail válido",
	    digits: "Debes ingresar sólo números",
	});
	jQuery.validator.setDefaults({
	    submitHandler: function(form) {
			jQuery(form).submit();
		}
	});
	jQuery("#formDatosActualizar").validate({
	    rules: {
	    	cedula:{
	    		required:true,
	    		digits: true
	    	},
	        fecha_nacimiento: {
	        	required:true
	        },
	        nombres: {
	        	required:true
	        },
	        apellidos: {
	        	required:true
	        },
	        telefono: {
	        	required:true,
	        	digits: true
	        },
	        ciudad: {
	        	required:true
	        },
	        genero: {
	        	required:true	        
	        },
	        email: {
	        	required:true,
	        	email: true
	        },
	        institucion:{
	        	required:true
	        },
	        departamentos:{
	        	requiered:true
	        },
	        observaciones: {
	        	required:false
	        },

	    },
	});
	jQuery("#departamentos").change(function(event) {
		jQuery('#ciudades').html('<option value="">Selecciona una ciudad</option>');
		var departamento = jQuery(this).val();
		Pace.track(function(){
			jQuery.ajax({
				url: 'index.php?option=com_functions&task=obtenerCiudades',
				type: 'GET',
				dataType: 'json',
				data: {departamento: departamento},
			})
			.done(function(ciudades) {
				jQuery.each(ciudades, function(ix, vx) {
					jQuery('#ciudades').append('<option value="'+vx.CiId+'">'+vx.CiNombre+'</option>');
				});
			});
		});
	});
	jQuery("#ciudades").change(function(event) {
		jQuery('#instituciones').html('<option value="">Selecciona una institución</option>');
		var ciudad = jQuery(this).val();
		Pace.track(function(){
			jQuery.ajax({
				url: 'index.php?option=com_functions&task=obtenerInstituciones',
				type: 'GET',
				dataType: 'json',
				data: {ciudad: ciudad},
			})
			.done(function(instituciones) {
				jQuery.each(instituciones, function(ix, vx) {
					jQuery('#instituciones').append('<option value="'+vx.IeId+'">'+vx.IeNombre+'</option>');
				});
			});
		});
	});

	jQuery("#perfilCampana").click(function(event) {
	var cedula = <?php echo $session->get('cedula');?>;
	var campana = <?php echo $idCampana; ?>;
	var nombre = jQuery('#nombres').val();
	var fecha = jQuery('#fecha_nacimiento').val();
	var apellidos = jQuery('#apellidos').val();
	var telefono = jQuery('#telefono').val();
	var correo = jQuery('#correo').val();
	var departamento = jQuery('#departamentos').val();
	var ciudad = jQuery('#ciudades').val();
	var institucion = jQuery('#instituciones').val();
	var genero = jQuery('#genero').val();
	var observaciones = jQuery('#observaciones').val();


	if(confirm("¿Realmente deseas enviar este comentario?")){
		jQuery.ajax( {
			type: "POST",
			url: 'index.php?option=com_functions&task=campanaPerfil',
			data: {
		        cedula: cedula,
		        campana: campana,
		        nombre: nombre,
		        apellidos: apellidos,
		        telefono: telefono,
		        correo: email,
		        ciudad: ciudad,
		        departamento: departamentos,
		        institucion: institucion,
		        genero: genero,
		        fecha: fecha_nacimiento,
		        observaciones: observaciones,
			},
			success: function( response ) {
				if( response ){
					alert("Tu comentario se ha publicado correctamente y has obtenido nuevos puntos");
					location.reload(); 
				};
			}
		} );
	};
});
</script>

