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
$cedula = $_POST['cedulaLogin'];
$contrasena = $_POST['contrasenaLogin'];
$salir = $_POST['salir'];

if($cedula && $contrasena){
	
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query
		->select($db->quoteName(array('usuario', 'password', 'perfil', 'nombre')))
	    ->from($db->quoteName('#__somosmaestros_sm_personas'))
	    ->where($db->quoteName('password') . ' = '.$db->quote($contrasena).' AND '.$db->quoteName('usuario').' = '.$db->quote($cedula));
	$db->setQuery($query);
	$usuario = $db->loadObject();
	if($usuario){
		$session->set('logueado',true);
		$session->set('cedula',$usuario->usuario);
		$session->set('nombre',$usuario->nombre);
		$session->set('perfil',$usuario->perfil);

	}

	
}

if($salir == "Salir"){
	$session->destroy();
	header( "Location: ".JURI::base() );
}


$doc = JFactory::getDocument();
$doc->addScript("templates/somosmaestros/js/datepicker.js");
$doc->addStyleSheet("templates/somosmaestros/css/datepicker.css");
$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
$doc->addScript('templates/somosmaestros/js/password.js');
$doc->addScript('templates/somosmaestros/js/passwordplus.js');
$doc->addScript('templates/somosmaestros/js/loading.js');



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

$cedula = JRequest::getVar('id');

$db3 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
$querySeg = $db3->getQuery(true);
$querySeg = 'SELECT informacioncomplementariapersonas.IcEmail AS correo, valorizacioninstituciones.VieTipoInstitucion, tipossector.TcNombre, institucioneseducativas.IeId AS id_institucion, institucioneseducativas.IeNombre AS institucion, ciudades.CiNombre, niveleseducativospais.NvNombre, asignaturas.AsNombre AS Area, agrupaciones.AcNombre, rolescontacto.RcNombre, gradosnivelpais.GnNombre AS grado, personas.PeNombres AS nombre, personas.PePrimerApellido AS apellido1, personas.PeSegundoApellido AS apellido2, personas.PeIdentificacion AS cedula, regionales.ReNombre AS Delegacion, informacioncomplementariapersonas.IcTelefono, informacioncomplementariapersonas.IcNacimiento, informacioncomplementariapersonas.IcGenero FROM adopciones INNER JOIN institucioneseducativas ON adopciones.ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN asignaturasparalelo ON adopciones.ApAsignaturaParalelo = asignaturasparalelo.AuId INNER JOIN asignaturasgradosperiodoinstitucioneducativa ON asignaturasparalelo.AuAsignaturaGradoPeriodoInstitucionEducativa = asignaturasgradosperiodoinstitucioneducativa.AdId INNER JOIN gradosnivelperiodoinstitucioneducativa ON asignaturasgradosperiodoinstitucioneducativa.AdGradoNivelPeriodoInstitucionEducativa = gradosnivelperiodoinstitucioneducativa.GiId INNER JOIN gradosnivelpais ON gradosnivelperiodoinstitucioneducativa.GiGradoNivelPais = gradosnivelpais.GnId INNER JOIN adopcionproductos ON adopcionproductos.AoAdopcion = adopciones.ApId INNER JOIN productos ON adopcionproductos.AoProducto = productos.PcId INNER JOIN asignaturasgradopaisdefecto ON asignaturasgradosperiodoinstitucioneducativa.AdAsignaturaGradoPais = asignaturasgradopaisdefecto.AgId INNER JOIN asignaturas ON asignaturasgradopaisdefecto.AgAsignatura = asignaturas.AsId LEFT JOIN contactosadopcion ON adopciones.ApId = contactosadopcion.CpAdopcion LEFT JOIN contactosinstitucioneducativa ON contactosadopcion.CpContactoInstitucionEducativa = contactosinstitucioneducativa.CnId LEFT JOIN personas ON contactosinstitucioneducativa.CnPersona = personas.PeId INNER JOIN valorizacioninstituciones ON valorizacioninstituciones.VieInstitucionEducativa = institucioneseducativas.IeId AND adopciones.ApTemporadaNegocio = valorizacioninstituciones.VieTemporadaNegocio INNER JOIN tipossector ON institucioneseducativas.IeSector = tipossector.TcId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON personas.PeCiudadResidencia = ciudades.CiId AND localidades.LoCiudad = ciudades.CiId INNER JOIN niveleseducativospais ON gradosnivelpais.GnNivelEducativo = niveleseducativospais.NvId INNER JOIN agrupaciones ON productos.PcAgrupacion = agrupaciones.AcId INNER JOIN rolescontacto ON contactosinstitucioneducativa.CnRolContacto = rolescontacto.RcId INNER JOIN tmp_resumenadopcionproducto ON tmp_resumenadopcionproducto.rap_ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN regionales ON tmp_resumenadopcionproducto.rap_Distrito = regionales.ReId INNER JOIN informacioncomplementariapersonas ON informacioncomplementariapersonas.IcPersona = personas.PeId WHERE adopciones.ApTemporadaNegocio = 10 AND adopcionproductos.AoEstatus <> "P" AND personas.PeIdentificacion = "'.$cedula.'" GROUP BY productos.PcId';
$db3->setQuery($querySeg);
$segmentacion = $db3->loadObject();


$nombres = $segmentacion->nombre;
$delegacion = $segmentacion->Delegacion;
$tipoInstitucion = $segmentacion->VieTipoInstitucion;
$segmento = $segmentacion->TcNombre;
$nivel = $segmentacion->NvNombre;
$ciudad = $segmentacion->CiNombre;
$area = $segmentacion->Area;
$rol = $segmentacion->RcNombre;
$proyecto = $segmentacion->AcNombre;


$apellido1= $segmentacion->apellido1;
$apellido2= $segmentacion->apellido2;
$telefono= $segmentacion->IcTelefono;
$fecha_nacimiento= $segmentacion->IcNacimiento;
$genero= $segmentacion->IcGenero;
$institucion= $segmentacion->institucion;
$correo= $segmentacion->correo;

?>

<?php if (!$session->get('logueado')) { ?>	
<form class="row" id="formLoginSM" action="" method="POST">
	<div class="span3">
		<div class="input-append">
			<label for="cedulaLogin">Cédula</label>
			<input type="text" id="usuarioLogin" placeholder="Identificación" name="cedulaLogin">
		</div>
	</div>
	<div class="span3">
		<div class="input-append">
			<label for="contrasenaLogin">Contraseña</label>
			<input type="password" id="passwordLogin" placeholder="Contraseña" name="contrasenaLogin">
		</div>
	</div>
	<div class="span3">
		<input type="submit" class="btn btn-primary" id="enviarLogin" value="Ingresar">
	</div>
</form>
<?php }else{ ?>

	<div class="row">
		<div class="span12">
			<div class="row">
				<div class="offset2 span10">
					<a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a>
				</div>
				<div class="span2">
					<div id="menuAdministradores">
					<?php
						jimport('joomla.application.module.helper');
						// this is where you want to load your module position
						$modules2 = JModuleHelper::getModules('menuFun');
						foreach($modules2 as $module2){
							echo JModuleHelper::renderModule($module2);
						} 
					?>
					</div>
				</div>
				<div class="span10">
					<form id="formDatosActualizar" method="POST" action="index.php?option=com_somosmaestros&view=funcionarios&layout=actualizar&Itemid=2177">
						<div class="row">
							<div class="span2">Cédula</div>
							<div class="span2"><strong><?php echo $cedula; ?></strong></div>
							<div class="span1"></div>
							<div class="span2">Fecha de Nacimiento</div>
							<div class="span2"><input class="datepicker" id="fecha_nacimiento" type="text" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>"></div>
						</div>
						<div class="row">
							<div class="span2">Nombres</div>
							<div class="span2"><input type="text" id="nombres" name="nombres" value="<?php echo $nombres; ?>"></div>
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
						<div class="span2">
							<input type="hidden" value="<?php echo $cedula; ?>" name="cedula" />
							<input class="btn btn-primary" type="submit" value="Actualizar datos">
						</div>
					</form>
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
</script>

