<?php
defined('_JEXEC') or die;

if($_POST['cedula'] && $_POST['nombres'] && $_POST['apellidos'] && $_POST['telefono'] && $_POST['ciudad'] && $_POST['departamentos'] && $_POST['institucion'] && $_POST['genero'] && $_POST['fecha_nacimiento']){

//require_once 'templates/somosmaestros/code/SMEducativa.php';

//$id = 0;
//date_default_timezone_set('America/Bogota');
//$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );

$usuario = new stdClass();
$usuario->state = 1;
//$usuario->tipo=3;
$usuario->cedula=$_POST['cedula'];
//$usuario->password=md5($_POST['password']);
$usuario->nombres=$_POST['nombres'];
$usuario->apellidos=$_POST['apellidos'];
$usuario->telefono=$_POST['telefono'];
$usuario->correo=$_POST['email'];
$usuario->ciudad=$_POST['ciudad'];
$usuario->departamento=$_POST['departamentos'];
$usuario->institucion=$_POST['institucion'];
$usuario->genero=$_POST['genero'];
$usuario->fecha=$_POST['fecha_nacimiento'];
//$usuario->form=1;
//$usuario->fecha_registro=date('Y-m-d');

//print_r($usuario);
// Insert the object into the user profile table.
//$resultado = $db->insertObject('persona', $usuario);
$result = JFactory::getDbo()->insertObject('#__somosmaestros_sm_registro', $usuario);
//$id = $db->insertid();
/*
if($id != 0){
	$db2 = JDatabaseDriver::getInstance( SMEducativa::getConexion() );
	$usuario2 = new stdClass();
	$usuario2->id=$id;
	$usuario2->email=$_POST['cedula'];
	$usuario2->contrasena=md5($_POST['password']);
	$usuario2->fecha=date('Y-m-d');
	$usuario2->cedula=$_POST['cedula'];
	$usuario2->text_pwd=$_POST['password'];
	$usuario2->correo=$_POST['email'];
	$resultado2 = $db2->insertObject('usuario', $usuario2);

	if($resultado2){
		$db3 = JDatabaseDriver::getInstance( SMEducativa::getConexion() );
		$usuario3 = new stdClass();
		$usuario3->usuario=$id;
		$usuario3->documento=$_POST['cedula'];
		$resultado3 = $db3->updateObject('persona', $usuario3, 'documento');
	}
}

*/


//print_r($_POST);
?>
<div class="row">
	<div class="span10 offset1">
		<h3 class="tituloGris">Registro</h3>
		<div class="cajaGris">
			<?php if($result){

				//header( "Location: ".JURI::base()."?registro=ok" );
				?>

				<div class="alert alert-error">
					<p>Registro envíado correctamente</p>
				</div>
			<?php }else{ ?>
				<div class="alert alert-error">
					<p>Hubo un error creando tu cuenta</p>
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
