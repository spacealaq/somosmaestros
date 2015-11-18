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

$doc->addScript('templates/somosmaestros/js/list.js');
$doc->addScript('templates/somosmaestros/js/template.js');

$doc->addStyleSheet('templates/somosmaestros/css/awesome.css');
$doc->addStyleSheet('templates/somosmaestros/css/template.css');

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
					<?php 


						require_once 'templates/somosmaestros/code/SMBrujula.php';

						$db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
						$query2 = $db2 ->getQuery(true);
						$query2 = 'SELECT tiposusuarios.TuId, tiposusuarios.TuDescripcion, usuarios.UsId FROM usuarios INNER JOIN tiposusuarios ON usuarios.UsTipo = tiposusuarios.TuId WHERE usuarios.UsIdentificacion = "'.$session->get('cedula').'" AND usuarios.UsPwdSomosM = "'.$session->get('cedula').'"';
						$db2->setQuery($query2);
						$tipo = $db2->loadObject();


						$UsId=$tipo->UsId;
						$UsTipo=$tipo->TuId;
						
						if($UsTipo == 'PR'){
							$db3 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
							$query3 = $db3 ->getQuery(true);
							$query3 = 'SELECT valorizacioninstituciones.VieTipoInstitucion, tipossector.TcNombre, institucioneseducativas.IeId AS id_institucion, institucioneseducativas.IeNombre AS institucion, ciudades.CiNombre, niveleseducativospais.NvNombre, asignaturas.AsNombre AS Area, agrupaciones.AcNombre, rolescontacto.RcNombre, gradosnivelpais.GnNombre AS grado, personas.PeNombres AS nombres, personas.PePrimerApellido AS primerApellido, personas.PeSegundoApellido AS segundoApellido, personas.PeIdentificacion AS cedula, regionales.ReNombre AS Delegacion, informacioncomplementariapersonas.IcTelefono, informacioncomplementariapersonas.IcNacimiento, informacioncomplementariapersonas.IcGenero FROM adopciones INNER JOIN institucioneseducativas ON adopciones.ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN asignaturasparalelo ON adopciones.ApAsignaturaParalelo = asignaturasparalelo.AuId INNER JOIN asignaturasgradosperiodoinstitucioneducativa ON asignaturasparalelo.AuAsignaturaGradoPeriodoInstitucionEducativa = asignaturasgradosperiodoinstitucioneducativa.AdId INNER JOIN gradosnivelperiodoinstitucioneducativa ON asignaturasgradosperiodoinstitucioneducativa.AdGradoNivelPeriodoInstitucionEducativa = gradosnivelperiodoinstitucioneducativa.GiId INNER JOIN gradosnivelpais ON gradosnivelperiodoinstitucioneducativa.GiGradoNivelPais = gradosnivelpais.GnId INNER JOIN adopcionproductos ON adopcionproductos.AoAdopcion = adopciones.ApId INNER JOIN productos ON adopcionproductos.AoProducto = productos.PcId INNER JOIN asignaturasgradopaisdefecto ON asignaturasgradosperiodoinstitucioneducativa.AdAsignaturaGradoPais = asignaturasgradopaisdefecto.AgId INNER JOIN asignaturas ON asignaturasgradopaisdefecto.AgAsignatura = asignaturas.AsId LEFT JOIN contactosadopcion ON adopciones.ApId = contactosadopcion.CpAdopcion LEFT JOIN contactosinstitucioneducativa ON contactosadopcion.CpContactoInstitucionEducativa = contactosinstitucioneducativa.CnId LEFT JOIN personas ON contactosinstitucioneducativa.CnPersona = personas.PeId INNER JOIN valorizacioninstituciones ON valorizacioninstituciones.VieInstitucionEducativa = institucioneseducativas.IeId AND adopciones.ApTemporadaNegocio = valorizacioninstituciones.VieTemporadaNegocio INNER JOIN tipossector ON institucioneseducativas.IeSector = tipossector.TcId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON personas.PeCiudadResidencia = ciudades.CiId AND localidades.LoCiudad = ciudades.CiId INNER JOIN niveleseducativospais ON gradosnivelpais.GnNivelEducativo = niveleseducativospais.NvId INNER JOIN agrupaciones ON productos.PcAgrupacion = agrupaciones.AcId INNER JOIN rolescontacto ON contactosinstitucioneducativa.CnRolContacto = rolescontacto.RcId INNER JOIN tmp_resumenadopcionproducto ON tmp_resumenadopcionproducto.rap_ApInstitucionEducativa = institucioneseducativas.IeId AND adopciones.ApId = tmp_resumenadopcionproducto.rap_ApId INNER JOIN regionales ON tmp_resumenadopcionproducto.rap_Distrito = regionales.ReId INNER JOIN informacioncomplementariapersonas ON informacioncomplementariapersonas.IcPersona = personas.PeId WHERE adopciones.ApTemporadaNegocio = 10 AND tmp_resumenadopcionproducto.rap_TdNombre = "Propia" AND tmp_resumenadopcionproducto.rap_ApUsuario = "'.$UsId.'" AND rolescontacto.RcNombre = "DOCENTE" GROUP BY productos.PcId'; 
							$db3->setQuery($query3);
							$docentes = $db3->loadObjectList();
					?>
							<div id="users">
								  <div class="row">
								  	<div class="span3">
								 		<input class="search" placeholder="Nombre/Cédula/Ciudad" />
								 	</div>
								 	<div class="span10">
								 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/funcionarios/generarExcel.php"> 
								 			<input id="editar" type="submit"  value="Generar Excel - Usuarios" />
								 			<input id="usuario" name="usuario" class="hidden" type="text"  value="<?php echo $session->get('cedula'); ?>" />
								 			<input id="id" name="id" class="hidden" type="text"  value="<?php echo $UsId; ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $UsTipo; ?>" />
							           	</form>
								 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/funcionarios/generarLogs.php"> 
								 			<input id="editar" type="submit"  value="Generar Logs - Todos" />
								 			<input id="usuario" name="usuario" class="hidden" type="text"  value="<?php echo $session->get('cedula'); ?>" />
								 			<input id="id" name="id" class="hidden" type="text"  value="<?php echo $UsId; ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $UsTipo; ?>" />
							           	</form>
							        </div>
							      </div>
								  <table>
								  	<thead>
								  		<th>Nombres</th>
								  		<th>Primer Apellido</th>
								  		<th>Segundo Apellido</th>
								  		<th>Cédula</th>
								  		<th>Teléfono</th>
								  		<th>Fecha Nacimiento</th>
								  		<th>Género</th>
								  		<th>Ciudad</th>
								  		<th>Delegación</th>
								  		<th></th>
								  	</thead>
								    <!-- IMPORTANT, class="list" have to be at tbody -->
								    <tbody class="list">
								   		<?php 
											foreach ($docentes as $d) {
										?>
									      <tr>
									        <td class="nombres"><?php echo $d->nombres;?></td>
									        <td class="apellido1"><?php echo $d->primerApellido;?></td>
									        <td class="apellidos2"><?php echo $d->segundoApellido;?></td>
									        <td class="cedula"><?php echo $d->cedula?></td>
									        <td class="telefono"><?php echo $d->IcTelefono?></td>
									        <td class="nacimiento"><?php echo $d->IcNacimiento?></td>
									        <td class="genero"><?php echo $d->IcGenero?></td>
									        <td class="ciudad"><?php echo $d->CiNombre?></td>
									        <td class="delegacion"><?php echo $d->Delegacion?></td>
											<td>
									    		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=funcionarios&layout=editar&id='.(int) $d->cedula); ?>"  class="btn btn-warning">
								  					<i class="icon-edit icon-white"></i>
												</a>
											</td>
									      </tr>
									    <?php } ?>
								    </tbody>
								  </table>
							</div>
					<? } else if ($UsTipo == 'CO') {
							$db4 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
							$query4 = $db4 ->getQuery(true);
							$query4 = 'SELECT institucioneseducativas.IeId AS IdInterno, institucioneseducativas.IeNombre AS Institucion, institucioneseducativas.IeTipoCalendario AS Calendario, institucioneseducativas.IeIdentificacion AS Dane, ciudades.CiNombre AS Ciudad, departamentos.DeNombre AS Departamento, CONCAT(Usu1.UsNombres," ",Usu1.UsApellidos) AS Asesor, CONCAT(Usu2.UsNombres," ",Usu2.UsApellidos) AS Coordinador, regionales.ReNombre AS Regional FROM institucioneseducativas INNER JOIN territoriosinstitucioneducativa ON institucioneseducativas.IeId = territoriosinstitucioneducativa.ToInstitucionEducativa INNER JOIN territorios ON territoriosinstitucioneducativa.ToTerritorio = territorios.TsId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON localidades.LoCiudad = ciudades.CiId INNER JOIN departamentos ON ciudades.CiDepartamento = departamentos.DeId INNER JOIN usuarios AS Usu1 ON territorios.TsUsuarioResponsable = Usu1.UsId INNER JOIN coordinaciones ON territorios.TsCoordinacion = coordinaciones.CoId INNER JOIN usuarios AS Usu2 ON coordinaciones.CoResponsable = Usu2.UsId INNER JOIN regionales ON coordinaciones.CoRegional = regionales.ReId WHERE Usu2.UsId = "'.$UsId.'" ORDER BY Asesor ASC, Coordinador ASC, Institucion ASC';
							$db4->setQuery($query4);
							$coordinadores = $db4->loadObjectList();
							?>
							<div id="asesors">
								<div class="row">
								  	<div class="span3">
								  		<input class="search" placeholder="Asesor/Institución/Ciudad/DANE" />
								 	</div>
								 	<div class="span10">
								 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/funcionarios/generarExcel.php"> 
								 			<input id="editar" type="submit"  value="Generar Excel - Usuarios" />
								 			<input id="usuario" name="usuario" class="hidden" type="text"  value="<?php echo $session->get('cedula'); ?>" />
								 			<input id="id" name="id" class="hidden" type="text"  value="<?php echo $UsId; ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $UsTipo; ?>" />
							           	</form>
								 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/funcionarios/generarLogs.php"> 
								 			<input id="editar" type="submit"  value="Generar Logs - Todos los usuarios" />
								 			<input id="usuario" name="usuario" class="hidden" type="text"  value="<?php echo $session->get('cedula'); ?>" />
								 			<input id="id" name="id" class="hidden" type="text"  value="<?php echo $UsId; ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $UsTipo; ?>" />
							           	</form>
							        </div>
								  <table>
								  	<thead>
								  		<th>Asesor</th>
								  		<th>Coordinador</th>
								  		<th>Institucion</th>
								  		<th>Departamento</th>
								  		<th>Ciudad</th>
								  		<th>Dane</th>
								  		<th></th>
								  	</thead>
								    <!-- IMPORTANT, class="list" have to be at tbody -->
								    <tbody class="list">
								   		<?php 
											foreach ($coordinadores as $d) {
										?>
									      <tr>
									        <td class="asesor"><?php echo $d->Asesor;?></td>
									        <td class="coordinador"><?php echo $d->Coordinador;?></td>
									        <td class="institucion"><?php echo $d->Institucion;?></td>
									        <td class="departamento"><?php echo $d->Departamento;?></td>
									        <td class="ciudad"><?php echo $d->Ciudad;?></td>
									        <td class="dane"><?php echo $d->Dane;?></td>
											<td>
									    		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=funcionarios&layout=editar&id='.(int) $d->cedula); ?>"  class="btn btn-warning">
									    			<i class="icon-edit icon-white"></i>
												</a>
											</td>
									      </tr>
									    <?php } ?>
								    </tbody>
								  </table>

								</div>
							</div>
					<? }  else if ($UsTipo == 'RE') {
							$db5 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
							$query5 = $db5 ->getQuery(true);
							$query5 = 'SELECT Usu1.UsId AS IDCoordinador, CONCAT(Usu1.UsNombres," ",Usu1.UsApellidos) AS Coordinador, ciudades.CiNombre AS Ciudad, departamentos.DeNombre, CONCAT(usuarios.UsNombres," ",usuarios.UsApellidos) AS Gerente, regionales.ReNombre, regionales.ReGerenteResponsable AS IDGerente FROM usuarios AS Usu1 LEFT JOIN territorios ON Usu1.UsId = territorios.TsUsuarioResponsable LEFT JOIN ciudades ON Usu1.UsCiudad = ciudades.CiId LEFT JOIN coordinaciones ON territorios.TsCoordinacion = coordinaciones.CoId LEFT JOIN usuarios ON coordinaciones.CoResponsable = usuarios.UsId LEFT JOIN regionales ON coordinaciones.CoRegional = regionales.ReId INNER JOIN departamentos ON ciudades.CiDepartamento = departamentos.DeId WHERE Usu1.UsTipo = "PR" AND Usu1.UsEstado ="A" AND usuarios.UsTipo = "CO" AND usuarios.UsEstado = "A" AND regionales.ReGerenteResponsable = "'.$UsId.'" ORDER BY Coordinador ASC, Ciudad ASC';
							$db5->setQuery($query5);
							$gerentes = $db5->loadObjectList();
							?>
							<div id="coordinadores">
								<div class="row">
								  	<div class="span3">
								  		<input class="search" placeholder="Coordinador/Gerente/Departamento/Ciudad" />
								 	</div>
								 	<div class="span10">
								 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/funcionarios/generarExcel.php"> 
								 			<input id="editar" type="submit"  value="Generar Excel - Usuarios" />
								 			<input id="usuario" name="usuario" class="hidden" type="text"  value="<?php echo $session->get('cedula'); ?>" />
								 			<input id="id" name="id" class="hidden" type="text"  value="<?php echo $UsId; ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $UsTipo; ?>" />
							           	</form>
								 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/funcionarios/generarLogs.php"> 
								 			<input id="editar" type="submit"  value="Generar Logs - Todos" />
								 			<input id="usuario" name="usuario" class="hidden" type="text"  value="<?php echo $session->get('cedula'); ?>" />
								 			<input id="id" name="id" class="hidden" type="text"  value="<?php echo $UsId; ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $UsTipo; ?>" />
							           	</form>
							        </div>
								  <table>
								  	<thead>
								  		<th>Coordinador</th>
								  		<th>Ciudad</th>
								  		<th>Departamento</th>
								  		<th>Gerente</th>
								  		<th>Delegacion</th>
								  		<th></th>
								  	</thead>
								    <!-- IMPORTANT, class="list" have to be at tbody -->
								    <tbody class="list">
								   		<?php 
											foreach ($gerentes as $d) {
										?>
									      <tr>
									        <td class="coordinador"><?php echo $d->Coordinador;?></td>
									        <td class="ciudad"><?php echo $d->Ciudad;?></td>
									        <td class="departamento"><?php echo $d->DeNombre;?></td>
									        <td class="gerente"><?php echo $d->Gerente;?></td>
									        <td class="delegacion"><?php echo $d->ReNombre;?></td>
									      </tr>
									    <?php } ?>
								    </tbody>
								  </table>

								</div>
							</div>
					<? } else if ($session->get('perfil') == 'GN') {
							$db6 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
							$query6 = $db6 ->getQuery(true);
							$query6 = 'SELECT Usu1.UsId AS IDGerente, CONCAT(Usu1.UsNombres," ",Usu1.UsApellidos) AS GerenteReg, ciudades.CiNombre AS Ciudad, departamentos.DeNombre FROM usuarios AS Usu1 LEFT JOIN territorios ON Usu1.UsId = territorios.TsUsuarioResponsable LEFT JOIN ciudades ON Usu1.UsCiudad = ciudades.CiId LEFT JOIN coordinaciones ON territorios.TsCoordinacion = coordinaciones.CoId LEFT JOIN usuarios ON coordinaciones.CoResponsable = usuarios.UsId LEFT JOIN regionales ON coordinaciones.CoRegional = regionales.ReId INNER JOIN departamentos ON ciudades.CiDepartamento = departamentos.DeId WHERE Usu1.UsTipo = "RE" AND Usu1.UsEstado ="A" ORDER BY GerenteReg ASC';
							$db6->setQuery($query6);
							$gerente = $db6->loadObjectList();
							?>
							<div id="gerentes">
								<div class="row">
								  	<div class="span3">
								  		<input class="search" placeholder="Gerente/Departamento/Ciudad" />
								 	</div>
								 	<div class="span10">
								 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/funcionarios/generarExcel.php"> 
								 			<input id="editar" type="submit"  value="Generar Excel - Usuarios" />
								 			<input id="usuario" name="usuario" class="hidden" type="text"  value="<?php echo $session->get('cedula'); ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $session->get('perfil'); ?>" />
							           	</form>
								 		<form id="informeLogsUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/funcionarios/generarLogs.php"> 
								 			<input id="logs" type="submit"  value="Generar Logos - Todos" />
								 			<input id="usuario" name="usuario" class="hidden" type="text"  value="<?php echo $session->get('cedula'); ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $session->get('perfil'); ?>" />
							           	</form>
							        </div>
								  <table>
								  	<thead>
								  		<th>Gerente Regional</th>
								  		<th>Ciudad</th>
								  		<th>Departamento</th>
								  		<th></th>
								  	</thead>
								    <!-- IMPORTANT, class="list" have to be at tbody -->
								    <tbody class="list">
								   		<?php 
											foreach ($gerente as $d) {
										?>
									      <tr>
									        <td class="gerente"><?php echo $d->GerenteReg;?></td>
									        <td class="ciudad"><?php echo $d->Ciudad;?></td>
									        <td class="departamento"><?php echo $d->DeNombre;?></td>
									      </tr>
									    <?php } ?>
								    </tbody>
								  </table>

								</div>
							</div>
					<? } else if($session->set('perfil') == 'SM') { ?>
							<div class="span12">USTED NO TIENE USUARIOS ASIGNADOS</div>
					<? } ?>
            	</div>
            </div>
   		</div>
	<?php } ?>


<script type="text/javascript">

var options = {
  valueNames: [ 'nombres', 'apellido1', 'apellido2', 'cedula', 'ciudad' ]
};

var options2 = {
  valueNames: [ 'asesor', 'institucion', 'ciudad', 'dane' ]
};

var options3 = {
  valueNames: [ 'coordinador', 'ciudad', 'gerente', 'departamento' ]
};

var options4 = {
  valueNames: [ 'gerente', 'ciudad', 'departamento' ]
};

var userList = new List('users', options);
var userList = new List('asesors', options2);
var userList = new List('coordinadores', options3);
var userList = new List('gerentes', options4);

</script>