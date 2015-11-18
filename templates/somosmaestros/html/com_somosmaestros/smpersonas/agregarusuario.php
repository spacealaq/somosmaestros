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
							<form id="formCrearCategoria" class="row form-crear">
								<div class="span5">
									<label for="nombreUsuario">Nombre:</label>
									<input name="nombreUsuario" id="nombreUsuario" type="text">
								</div>
								<div class="span5">
									<label for="cedulaUsuario">Cédula:</label>
									<input name="cedulaUsuario" id="cedulaUsuario" type="text">
								</div>	
								<div class="span5">
									<label for="contraseñaUsuario">Contraseña: (igual al documento de identidad)</label>
									<input name="contraseñaUsuario" id="contraseñaUsuario" type="text">
								</div>	
								<div class="span5">
									<label for="perfilUsuario">Perfil:</label>
									<select class="chosen-choices" name="perfilUsuario" id="perfilUsuario">
										<option value="PR">Asesor</option>
										<option value="CO">Coordinador</option>
										<option value="RE">Gerente Regional</option>
										<option value="GN">Gerente Nacional</option>
										<option value="SM">Asesor Pedagógico</option>
									</select>
								</div>							
								<div class="span5">
									<label for="delegacionUsuario">Delegación</label>
									<select class="chosen-choices" name="delegacionUsuario" id="delegacionUsuario">
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
									<label for="ciudadUsuario">Ciudad:</label>
									<select class="chosen-choices" name="ciudadUsuario" id="ciudadUsuario">
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
								<div class="span5"></div>
								<div class="span10">
									<div id="btn_usuarios" class="btn btn-primary">
										<i class="icon-bookmark icon-white"></i> Crear Usuario
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
	jQuery(document).ready(function($) {
		jQuery("#btn_usuarios").click(function(){
				jQuery.ajax({
				type: "GET",
				url: "index.php?option=com_functions&task=crearUsuarioSM",
				data: { 
					nombre: jQuery("#nombreUsuario").val(),
					usuario: jQuery("#cedulaUsuario").val(),
					perfil: jQuery("#perfilUsuario").val(),
					password: jQuery("#contraseñaUsuario").val(),
					delegacion: jQuery("#delegacionUsuario").val(),
					ciudad: jQuery("#ciudadUsuario").val(),
				},
				success: function( response ) {
					if( response ){
						alert("Tu usuario se ha creado correctamente");
						location.assign("index.php?option=com_somosmaestros&view=smpersonas&Itemid=1468");
					};
				}
			});
		});
	});
</script>