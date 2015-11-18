<?php
defined('_JEXEC') or die;

$session =& JFactory::getSession();
$cedula = $_POST['cedulaLogin'];
$contrasena = $_POST['contrasenaLogin'];
$salir = $_POST['salir'];

if($cedula && $contrasena){
	require_once 'templates/somosmaestros/code/SMBrujula.php';
	$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
	$query = $db->getQuery(true);
	$query
		->select($db->quoteName(array('PeIdentificacion', 'PeNombres', 'PePrimerApellido')))
	    ->from($db->quoteName('smbrujul_produccion.personas'))
	    ->where($db->quoteName('PeContrasenaCMS') . ' = '.$db->quote($contrasena).' AND '.$db->quoteName('PeIdentificacion').' = '.$db->quote($cedula));
	$db->setQuery($query);
	$usuario = $db->loadObject();

	$db4 = JFactory::getDbo();
	$query4 = $db4->getQuery(true);
	$query4
		->select($db->quoteName(array('usuario', 'password', 'perfil', 'nombre')))
	    ->from($db->quoteName('#__somosmaestros_sm_personas'))
	    ->where($db->quoteName('password') . ' = '.$db->quote($contrasena).' AND '.$db->quoteName('usuario').' = '.$db->quote($cedula).' AND '.$db->quoteName('perfil').' = "SM"');
	$db4->setQuery($query4);
	$usuarioSM = $db4->loadObject();
	
	if($usuario){
		$session->set('logueado',true);
		$session->set('cedula',$cedula);
		$session->set('nombre',$usuario->PeNombres);


		$db3 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
		$querySeg = $db3->getQuery(true);
		$querySeg = 'SELECT informacioncomplementariapersonas.IcEmail AS correo, valorizacioninstituciones.VieTipoInstitucion, tipossector.TcNombre, institucioneseducativas.IeId AS id_institucion, institucioneseducativas.IeNombre AS institucion, ciudades.CiNombre, niveleseducativospais.NvNombre, asignaturas.AsNombre AS Area, agrupaciones.AcNombre, rolescontacto.RcNombre, gradosnivelpais.GnNombre AS grado, personas.PeNombres AS nombre, personas.PePrimerApellido AS apellido1, personas.PeSegundoApellido AS apellido2, personas.PeIdentificacion AS cedula, regionales.ReNombre AS Delegacion, informacioncomplementariapersonas.IcTelefono, informacioncomplementariapersonas.IcNacimiento, informacioncomplementariapersonas.IcGenero FROM adopciones INNER JOIN institucioneseducativas ON adopciones.ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN asignaturasparalelo ON adopciones.ApAsignaturaParalelo = asignaturasparalelo.AuId INNER JOIN asignaturasgradosperiodoinstitucioneducativa ON asignaturasparalelo.AuAsignaturaGradoPeriodoInstitucionEducativa = asignaturasgradosperiodoinstitucioneducativa.AdId INNER JOIN gradosnivelperiodoinstitucioneducativa ON asignaturasgradosperiodoinstitucioneducativa.AdGradoNivelPeriodoInstitucionEducativa = gradosnivelperiodoinstitucioneducativa.GiId INNER JOIN gradosnivelpais ON gradosnivelperiodoinstitucioneducativa.GiGradoNivelPais = gradosnivelpais.GnId INNER JOIN adopcionproductos ON adopcionproductos.AoAdopcion = adopciones.ApId INNER JOIN productos ON adopcionproductos.AoProducto = productos.PcId INNER JOIN asignaturasgradopaisdefecto ON asignaturasgradosperiodoinstitucioneducativa.AdAsignaturaGradoPais = asignaturasgradopaisdefecto.AgId INNER JOIN asignaturas ON asignaturasgradopaisdefecto.AgAsignatura = asignaturas.AsId LEFT JOIN contactosadopcion ON adopciones.ApId = contactosadopcion.CpAdopcion LEFT JOIN contactosinstitucioneducativa ON contactosadopcion.CpContactoInstitucionEducativa = contactosinstitucioneducativa.CnId LEFT JOIN personas ON contactosinstitucioneducativa.CnPersona = personas.PeId INNER JOIN valorizacioninstituciones ON valorizacioninstituciones.VieInstitucionEducativa = institucioneseducativas.IeId AND adopciones.ApTemporadaNegocio = valorizacioninstituciones.VieTemporadaNegocio INNER JOIN tipossector ON institucioneseducativas.IeSector = tipossector.TcId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON personas.PeCiudadResidencia = ciudades.CiId AND localidades.LoCiudad = ciudades.CiId INNER JOIN niveleseducativospais ON gradosnivelpais.GnNivelEducativo = niveleseducativospais.NvId INNER JOIN agrupaciones ON productos.PcAgrupacion = agrupaciones.AcId INNER JOIN rolescontacto ON contactosinstitucioneducativa.CnRolContacto = rolescontacto.RcId INNER JOIN tmp_resumenadopcionproducto ON tmp_resumenadopcionproducto.rap_ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN regionales ON tmp_resumenadopcionproducto.rap_Distrito = regionales.ReId INNER JOIN informacioncomplementariapersonas ON informacioncomplementariapersonas.IcPersona = personas.PeId WHERE adopciones.ApTemporadaNegocio = 10 AND adopcionproductos.AoEstatus <> "P" AND personas.PeIdentificacion = "'.$cedula.'" GROUP BY productos.PcId';
		$db3->setQuery($querySeg);
		$segmentacion = $db3->loadObject();

		$session->set('delegacion',$segmentacion->Delegacion);
		$session->set('tipoInstitucion',$segmentacion->VieTipoInstitucion);
		$session->set('segmento',$segmentacion->TcNombre);
		$session->set('nivel',$segmentacion->NvNombre);
		$session->set('ciudad',$segmentacion->CiNombre);
		$session->set('area',$segmentacion->Area);
		$session->set('rol',$segmentacion->RcNombre);
		$session->set('proyecto',$segmentacion->AcNombre);
		//$session->set('grado',$segmentacion->¿?);


		$session->set('apellido1',$segmentacion->apellido1);
		$session->set('apellido2',$segmentacion->apellido2);
		$session->set('telefono',$segmentacion->IcTelefono);
		$session->set('fecha_nacimiento',$segmentacion->IcNacimiento);
		$session->set('genero',$segmentacion->IcGenero);
		$session->set('institucion',$segmentacion->institucion);
		$session->set('correo',$segmentacion->correo);

		//header('Location: index.php?option=com_somosmaestros&view=miperfil&Itemid=121');
		require_once 'templates/somosmaestros/code/SMBrujula.php';
		$db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
		$query = $db2->getQuery(true);
		$query
		    ->select($db2->quoteName(array('cantidadpuntos')))
		    ->from($db2->quoteName('mkPuntos'))
		    ->where($db2->quoteName('documentopuntos') . ' = '.$db2->quote($cedula));
		$db2->setQuery($query);
		$puntosDB = $db2->loadObjectList();
		$puntos = 0;
		foreach ($puntosDB as $p) {
			if((int)$p->cantidadpuntos > 0){
				$puntos = $puntos + ($p->cantidadpuntos);
			}
		}
		$session->set('puntos',$puntos);
		header("Refresh:0");
	} else if ($usuarioSM) {
		$session->set('logueado',true);	
		$session->set('cedula',$cedula);
		$session->set('nombre',$usuarioSM->nombre);
		$session->set('perfil',$usuarioSM->perfil);	
	}

	
}

if($salir == "Salir"){
	$session->destroy();
	header( "Location: ".JURI::base() );
}

?>


<form class="row" id="formLoginSM" action="" method="POST">
	<?php if ($session->get('logueado')) { ?>
		<div class="span3 offset2 bienvenidaUsuario">
			<div class="holaUsuario">Hola <?php echo $session->get('nombre'); ?></div>
			<div class="puntosDisponibles"><img width="25" src="templates/somosmaestros/images/punticos.png"> Puntos disponibles <span><?php echo $session->get('puntos'); ?></span></div>
			<div class="salirUsuario"><input class="btn btn-small" type="submit" value="Salir" name="salir"></div>
		</div>
		<div class="span1"><?php if($session->get('genero') == 'M'){?><img class="imgAvatarLogin" src="templates/somosmaestros/images/avatar_nino.png"><? } else if($session->get('genero') == 'F'){ ?><img class="imgAvatarLogin" src="templates/somosmaestros/images/avatar_nina.png"> <? } else { ?> <img class="imgAvatarLogin" src="templates/somosmaestros/images/avatar_nino.png"> <?php } ?></div>
	<?php }else{ ?>
		<div class="span2">
			<div class="input-append">
				<input type="text" id="usuarioLogin" placeholder="Identificación" name="cedulaLogin">
				<span class="add-on"><i class="icon-user"></i></span>
			</div>
			<br>
			<a href="index.php?option=com_somosmaestros&view=recuperarcontrasena&Itemid=207">¿Olvidó su contraseña?</a>
		</div>
		<div class="span2">
			<div class="input-append">
				<input type="password" id="passwordLogin" placeholder="Contraseña" name="contrasenaLogin">
				<span class="add-on"><i class="fa fa-lock"></i></span>
			</div>
			<br>
			<a class="linkCrearCuenta" href="index.php?option=com_somosmaestros&view=registrar&Itemid=206">¡Regístrese!</a>
		</div>
		<div class="span2">
			<input type="submit" class="btn btn-primary" id="enviarLogin" value="Ingresar">
		</div>
	<?php } ?>
</form>