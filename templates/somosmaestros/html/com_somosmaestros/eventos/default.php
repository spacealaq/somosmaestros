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
	<?php }else{ 


jimport('joomla.application.component.model');
$modelosFormaciones = JModelLegacy::getInstance( 'Formacions', 'SomosmaestrosModel' );
$listadoFormaciones = $modelosFormaciones->getItems();


require_once 'templates/somosmaestros/code/SMBrujula.php';

?>
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
					<div class="row"> 
						<div class="span10">
							<table class="table table-striped table-hover" id="tablaContenido">
								<tr>
									<td>Id</td>
									<td>Título</td>
									<td>Disponibilidad</td>
									<td>Público</td>
									<td>Destacado</td>
									<td></td>
								</tr>
							<?php foreach ($listadoFormaciones as $frm) {
								echo '<tr>';
								echo '<td>'.$frm->id.'</td>';
								echo '<td>'.$frm->titulo.'</td>';
								echo '<td>'.$frm->disponibilidad.'</td>';
								?>
								<td>
							 		<form id="informeUsuarios" method="post" action="http://somosmaestros.co/templates/somosmaestros/html/com_somosmaestros/eventos/generarExcel.php"> 
							 			<input  class="btn btn-info" id="editar" type="submit"  value="Generar Excel - Asistentes" />
							 			<input id="formacion" name="formacion" class="hidden" type="text"  value="<?php echo $frm->id; ?>" />
						           	</form>
                                    <a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=eventos&layout=verasistentes&id='.(int) $frm->id); ?>"  class="btn btn-success">
                                        <i class="icon-user icon-white"></i>
                                    </a>
								</td>
								<?php
								echo '</tr>';
							} ?>
							</table>
						</div>
					</div>
				    <?php

				    /*require_once 'templates/somosmaestros/code/SMEducativa.php';
					$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );*/
					require_once 'templates/somosmaestros/code/SMBrujula.php';
					$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
				    ?>
				</div>
			</div>
		</div>
		<div class="span5"></div>
	</div>


<?php } ?>

