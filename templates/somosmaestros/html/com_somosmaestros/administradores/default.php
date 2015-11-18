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

jimport('joomla.application.component.model');
$modeloCampanas = JModelLegacy::getInstance( 'Capaas', 'SomosmaestrosModel' );
$listadoCampanas = $modeloCampanas->getItems();

require_once 'templates/somosmaestros/code/SMBrujula.php';
$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );

/*
$query = $db->getQuery(true);
$query = 'SELECT valorizacioninstituciones.VieTipoInstitucion, tipossector.TcNombre, institucioneseducativas.IeId AS id_institucion, institucioneseducativas.IeNombre AS institucion, ciudades.CiNombre, niveleseducativospais.NvNombre, asignaturas.AsNombre AS asignatura, agrupaciones.AcNombre, rolescontacto.RcNombre, gradosnivelpais.GnNombre AS grado, CONCAT_WS ("",personas.PeNombres,personas.PePrimerApellido,personas.PeSegundoApellido) AS contacto, personas.PeIdentificacion AS cedula, mkPuntos.idtipopuntos, mkPuntos.cantidadpuntos FROM adopciones INNER JOIN institucioneseducativas ON adopciones.ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN asignaturasparalelo ON adopciones.ApAsignaturaParalelo = asignaturasparalelo.AuId INNER JOIN asignaturasgradosperiodoinstitucioneducativa ON asignaturasparalelo.AuAsignaturaGradoPeriodoInstitucionEducativa = asignaturasgradosperiodoinstitucioneducativa.AdId INNER JOIN gradosnivelperiodoinstitucioneducativa ON asignaturasgradosperiodoinstitucioneducativa.AdGradoNivelPeriodoInstitucionEducativa = gradosnivelperiodoinstitucioneducativa.GiId INNER JOIN gradosnivelpais ON gradosnivelperiodoinstitucioneducativa.GiGradoNivelPais = gradosnivelpais.GnId INNER JOIN adopcionproductos ON adopcionproductos.AoAdopcion = adopciones.ApId INNER JOIN productos ON adopcionproductos.AoProducto = productos.PcId INNER JOIN asignaturasgradopaisdefecto ON asignaturasgradosperiodoinstitucioneducativa.AdAsignaturaGradoPais = asignaturasgradopaisdefecto.AgId INNER JOIN asignaturas ON asignaturasgradopaisdefecto.AgAsignatura = asignaturas.AsId LEFT JOIN contactosadopcion ON adopciones.ApId = contactosadopcion.CpAdopcion LEFT JOIN contactosinstitucioneducativa ON contactosadopcion.CpContactoInstitucionEducativa = contactosinstitucioneducativa.CnId LEFT JOIN personas ON contactosinstitucioneducativa.CnPersona = personas.PeId INNER JOIN valorizacioninstituciones ON valorizacioninstituciones.VieInstitucionEducativa = institucioneseducativas.IeId AND adopciones.ApTemporadaNegocio = valorizacioninstituciones.VieTemporadaNegocio INNER JOIN tipossector ON institucioneseducativas.IeSector = tipossector.TcId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON personas.PeCiudadResidencia = ciudades.CiId AND localidades.LoCiudad = ciudades.CiId INNER JOIN niveleseducativospais ON gradosnivelpais.GnNivelEducativo = niveleseducativospais.NvId INNER JOIN agrupaciones ON productos.PcAgrupacion = agrupaciones.AcId INNER JOIN rolescontacto ON contactosinstitucioneducativa.CnRolContacto = rolescontacto.RcId INNER JOIN mkPuntos ON personas.PeIdentificacion = mkPuntos.documentopuntos WHERE adopciones.ApTemporadaNegocio = 10 AND adopcionproductos.AoEstatus <> "P" and personas.PeIdentificacion = "50505050" GROUP BY productos.PcId';
$db->setQuery($query);
$proyectos = $db->loadObjectList();
print_r($proyectos);
*/
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
						<div class="span2 offset8">
							<a href="index.php?option=com_somosmaestros&view=crearcampaa&Itemid=237" class="btn btn-primary"><i class="fa fa-plus"></i> Crear campaña</a>
						</div>
					</div>
					<div class="row"> 
						<div class="span10">
							<table class="table table-striped table-hover" id="tablaContenido">
								<tr>
									<td>Id</td>
									<td>Nombre</td>
									<td>Fecha inicio</td>
									<td>Fecha fin</td>
									<td>Puntos</td>
									<td>Meta</td>
									<td></td>
								</tr>
							<?php foreach ($listadoCampanas as $camp) {
								echo '<tr>';
									echo '<td>'.$camp->id.'</td>';
									echo '<td>'.$camp->nombre.'</td>';
									echo '<td>'.$camp->fecha_inicio.'</td>';
									echo '<td>'.$camp->fecha_fin.'</td>';
									echo '<td>'.$camp->puntos.'</td>';								
									echo '<td>'.$camp->meta.'</td>';
								?>
									<td>
								 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/administradores/generarExcel.php"> 
								 			<input  class="btn btn-info" id="editar" type="submit"  value="Generar Informe - Excel" />
								 			<input id="campana" name="campana" class="hidden" type="text"  value="<?php echo $camp->id; ?>" />
								 			<input id="tipo" name="tipo" class="hidden" type="text"  value="<?php echo $camp->tipo; ?>" />
								 			<input id="publicacion" name="publicacion" class="hidden" type="text"  value="<?php echo $camp->publicacion; ?>" />
							           	</form>
							    		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=administradores&layout=editarcampana&id='.(int) $camp->id); ?>"  class="btn btn-warning">
						  					<i class="icon-edit icon-white"></i>
										</a>
										<a href="javascript: borrarCampana(<?php echo $camp->id; ?>);"  class="btn btn-danger">
						  					<i class="icon-remove icon-white"></i>
										</a>
								<?php
									echo '</td>';
									} 
								?>
								</tr>
							</table>
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
	function borrarCampana(id){
				if(confirm("¿Está seguro de borrar esta campaña?")){
					jQuery.ajax({
						type: "GET",
				url: "index.php?option=com_functions&task=eliminarCampana",
						data: { id: id }
					}).done(function( respBorrar ) {
						if(respBorrar){
							alert("Su campaña ha sido eliminada correctamente");
							location.reload(); 
						}
					});
				};
			}
</script>