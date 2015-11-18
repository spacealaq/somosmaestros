<?php
defined('_JEXEC') or die;

$session =& JFactory::getSession();
$cedula = $_POST['cedulaLogin'];
$contrasena = $_POST['contrasenaLogin'];
$salir = $_POST['salir'];
//$config = JFactory::getConfig(JURI::base()."templates/somosmaestros/code/connection_educasm_smeducativa.php","PHP");


if($cedula && $contrasena){
	require_once 'templates/somosmaestros/code/SMEducativa.php';
	$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );
	$query = $db->getQuery(true);
	$query
	    ->select($db->quoteName(array('documento', 'nombre', 'apellido')))
	    ->from($db->quoteName('persona', 'p'))
	    ->join('INNER', $db->quoteName('usuario', 'u') . ' ON (' . $db->quoteName('u.id') . ' = ' . $db->quoteName('p.id') . ')')
	    ->where($db->quoteName('u.contrasena') . ' = '.$db->quote(md5($contrasena)).' AND '.$db->quoteName('p.documento').' = '.$db->quote($cedula));
	$db->setQuery($query);
	$usuario = $db->loadObject();
	
	if($usuario){
		$session->set('logueado',true);
		$session->set('cedula',$cedula);
		$session->set('nombre',$usuario->nombre);
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
		<div class="span1"><img class="imgAvatarLogin" src="templates/somosmaestros/images/avatar.png"></div>
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