<?php
defined('_JEXEC') or die;

if($_POST['cedula'] && $_POST['nombres'] && $_POST['apellidos'] && $_POST['telefono'] && $_POST['ciudad'] && $_POST['institucion'] && $_POST['genero'] && $_POST['fecha_nacimiento']){

//Buscar campañas sobre perfil



$usuario = new stdClass();
$usuario->state = 1;
$usuario->cedula=$_POST['cedula'];
$usuario->nombres=$_POST['nombres'];
$usuario->apellidos=$_POST['apellidos'];
$usuario->telefono=$_POST['telefono'];
$usuario->correo=$_POST['email'];
$usuario->ciudad=$_POST['ciudad'];
$usuario->departamento=$_POST['departamentos'];
$usuario->institucion=$_POST['institucion'];
$usuario->genero=$_POST['genero'];
$usuario->fecha=$_POST['fecha_nacimiento'];
$usuario->observaciones=$_POST['observaciones'];
$result = JFactory::getDbo()->insertObject('#__somosmaestros_sm_actualizacion', $usuario);
/*

require_once 'templates/somosmaestros/code/SMEducativa.php';

$id = 0;
date_default_timezone_set('America/Bogota');
$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );

$usuario = new stdClass();
$usuario->tipo=3;
$usuario->documento=$_POST['cedula'];
$usuario->nombre=$_POST['nombres'];
$usuario->apellido=$_POST['apellidos'];
$usuario->telefono=$_POST['telefono'];
$usuario->ciudad=$_POST['ciudad'];
$usuario->institucion=$_POST['institucion'];
$usuario->genero=$_POST['genero'];
$usuario->fecha_nacim=$_POST['fecha_nacimiento'];
$usuario->form=1;
$usuario->fecha_registro=date('Y-m-d');


//print_r($usuario);
// Insert the object into the user profile table.
$resultado = $db->updateObject('persona', $usuario,'documento');


if($resultado){
	$db2 = JDatabaseDriver::getInstance( SMEducativa::getConexion() );
	$usuario2 = new stdClass();
	$usuario2->email=$_POST['cedula'];
	$usuario2->contrasena=md5($_POST['password']);
	$usuario2->fecha=date('Y-m-d');
	$usuario2->cedula=$_POST['cedula'];
	$usuario2->text_pwd=$_POST['password'];
	$usuario2->correo=$_POST['email'];
	$resultado2 = $db2->updateObject('usuario', $usuario2,'cedula');


	require_once 'templates/somosmaestros/code/SMBrujula.php';
	$dbB = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
	$queryB = $dbB->getQuery(true);
	$queryB = 'SELECT idtipopuntos, puntostipopuntos FROM smbrujul_produccion.mkTipoPuntos WHERE nombretipopuntos = "ACTUALIZAR PERFIL"';
	$dbB->setQuery($queryB);
	$puntosDisponibles = $dbB->loadObject();
	

	$dbB = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
	$queryB = $dbB->getQuery(true);
	$queryB = 'INSERT INTO smbrujul_produccion.mkPuntos (`documentopuntos`, `idtipopuntos`, `cantidadpuntos`) VALUES ("'.$_POST['cedula'].'", '.(int)$puntosDisponibles->idtipopuntos.', '.(int)$puntosDisponibles->puntostipopuntos.')';
	$dbB->setQuery($queryB);
	$dbB->execute();
}


*/

//print_r($_POST);
?>
<div class="row">
	<div class="span10 offset1">
		<h3 class="tituloGris">Actualizar datos</h3>
		<div class="cajaGris">
			<?php if($result){ ?>
				<div class="alert alert-success">
					<p>Tu solicitud de actualización ha sido enviado correctamente</p>
				</div>
				<a href="index.php?option=com_somosmaestros&view=miperfil&Itemid=121" class="btn">Volver</a>
			<?php }else{ ?>
				<div class="alert alert-error">
					<p>Hubo un error enviando tu solicitud</p>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php }else{ ?>
<div class="row">
	<div class="span10 offset1">
		<div class="alert alert-error">
			<p>No existen datos para el registro</p>
		</div>
	</div>
</div>
<?php } ?>
