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
$doc->setTitle("Recuperar contraseña");
$emailRecuperar = $_POST['emailRecuperar'];
$establecer = $_POST['establecer'];
$primerPaso = $_POST['primerPaso'];
$key = $_GET['key'];

?>
<div class="row">
	<div class="span2">
		<img src="templates/somosmaestros/images/lock.png">
	</div>
	<div class="span10">

<?php	

if($emailRecuperar && $primerPaso == "si"){
	require_once 'templates/somosmaestros/code/SMEducativa.php';
	$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );
	$query = $db->getQuery(true);
	$query
	    ->select($db->quoteName(array('correo')))
	    ->from($db->quoteName('usuario'))
	    ->where($db->quoteName('correo') . ' = '.$db->quote($emailRecuperar));
	$db->setQuery($query);
	$usuario = $db->loadResult();
	//Si retorna un usuario,enviar correo
	if($usuario){
		$nowt = time();
		date_default_timezone_set("America/Bogota");
		$rutaRecuperar = "index.php?option=com_somosmaestros&view=recuperarcontrasena";
		$fecha = $fechitas=strftime("%Y-%m-%d") . ' ' . date ("H:i:s", $nowt);
		$encriptar = base64_encode($email.$fecha);                                  
		$link = JURI::base().$rutaRecuperar."&key=".$encriptar;
		require_once 'mailing/Mandrill.php';                                                           
		$mandrill = new Mandrill('5SSigV7BVBsowortfgV7Dw');
		try{
			$message = array(
				'subject' => 'Recuperar Contraseña',
				'text' => 'aca va el html', // O simplemente usar 'html ' para apoyar el formato HTML
				'from_email' => 'soporte.conecta@grupo-sm.com',
				'from_name' => 'Ediciones SM Colombia', //optional
				'to' => array(
					array( // añadir más subconjuntos de destinatarios adicionales
						'email' => $emailRecuperar,
						'name' => '', // optional
						'type' => 'to' //optional. Default is 'to'. Other options: cc & bcc
					)
				),
				'html' => '
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Documento sin título</title>
					</head>
					<body>
						<table table-layout:"fixed" width="600" border="0" align="center"  cellspacing="10" cellpadding="0" background="http://sm-educacion.com.co/email-marketing/imagenes/0.png" style="background-repeat: no-repeat; width= 600px" >
							<tr>
								<td width="10%" align="left">
									<a href="http://sm-educacion.com.co/" target="_blank"><img src="http://sm-educacion.com.co/email-marketing/imagenes/1.png" width="85" height="88"  align="left" hspace="15"  alt="Logo SM" longdesc="Ediciones SM" /></a><strong><br />
									Ediciones SM S.A.</strong> <br />
									<strong>Teléfono:</strong> <br />
									<strong>Correo electrónico: </strong><a href="mailto:servicioalclientecol@grupo-sm.com"></a>
								</td>
								<td width="80%"><p><br />
									<br />
									<strong>018000429191 <a href="mailto:servicioalclientecol@grupo-sm.com"><br />
									servicioalclientecol@grupo-sm.com</a></strong><a href="mailto:servicioalclientecol@grupo-sm.com"><br />
									<br />
									</a></p>
								</td>
							</tr>
							<tr>
								<td width="10%" align="left"><p></p>
									<p></p>
									<p></p>
									<p></p>
									<p></p>
									<img src="http://sm-educacion.com.co/email-marketing/imagenes/2.jpg" width="260" height="394" />
								</td>
								<td width="300px"> <p>&nbsp;</p> <p>&nbsp;</p>
									<p style= "background-color: #1cadd8; font-family: Arial Black, Gadget, sans-serif; font-size: 13px; color: #FFF; font-weight: bold; text-align: center; border: thin solid #2379ae; border-radius: 10px; width: 80%; margin-left: 10%;">Recuperar Contrasena</p>
									<p align="justify">Acontinuación encontrara un link de activación para recuperar su contraseña.</p>
									<p align="justify">'.$link.'</p>
									<p align="justify">Si usted no solicito este cambio por favor omita este correo..</p>
									<p align="justify">&nbsp;</p>
									<p align="justify"><p align="center">Para cualquier duda adicional comuníquese con la línea nacional gratuita <strong>018000429191</strong> o escribanos al correo electrónico:<br />
									<strong><a href="mailto:servicioalclientecol@grupo-sm.com">servicioalclientecol@grupo-sm.com</a></strong><br />
									<br />
									Por favor no responda a este correo. <br>
									<a href="http://www.ediciones-sm.com.co/" target="_blank"><img src="http://sm-educacion.com.co/email-marketing/imagenes/logo-ediciones-sm.png"></a></p>
								</td>
							</tr>
						</table>
					</body>
				</html>',
				'track_opens' => TRUE,
				'track_clicks' => TRUE,
				'auto_text' => TRUE, // auto-converts html formatted emails to text
			);
			$result = $mandrill->messages->send($message);
			if($result[0]['status'] == "sent"){
				// Create and populate an object.
				$actualizar = new stdClass();
				$actualizar->email = $emailRecuperar;
				$actualizar->variable= $encriptar;
				$actualizar->fecha= $fecha;
				
				// Insert the object into the user profile table.
				$result = $db->insertObject('actualiza_contrasena', $actualizar);
				//echo $link;

			 ?>
				<div class="alert alert-success">
					<p>Se ha enviado correctamente el link al correo electrónico <strong><?php echo $emailRecuperar; ?></strong></p>
				</div>
				<?php }else{ ?>
				<div class="alert alert-error">
					<p>Hubo un error enviando el correo</p>
				</div>
			<?php }
			//print_r( $result );
		}catch(Mandrill_Error $e) {
			echo 'Ha ocurrido un error: ' . get_class($e) . ' - ' . $e->getMessage();
			throw $e;
		}

	}else{ ?>
		<div class="alert alert-error">
	    	<p>Lo sentimos, tu correo no se encuentra en el sistema</p>
	    </div>
	    <form method="post" action="">
			<label for="emailRecuperar" id="labelRecuperar">Ingresa el email de tu cuenta</label>
			<p>Enviaremos un link a tu correo para que restaures tu contraseña</p>
			<input required type="email" id="emailRecuperar" name="emailRecuperar" placeholder="Tu E-mail">
			<input type="submit" value="Recuperar" class="btn btn-primary">
		</form>
		
	<?php }

	
}else if($key){
	$doc->setTitle("Reestablecer contraseña");
	$nowt = time();
	date_default_timezone_set("America/Bogota");
	$fecha = $fechitas=strftime("%Y-%m-%d") . ' ' . date ("H:i:s", $nowt);
	$encriptado = $key;
	if ($encriptado <> '') { 
		require_once 'templates/somosmaestros/code/SMEducativa.php';
		$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );
		$query = $db->getQuery(true);
		$query
		    ->select($db->quoteName(array('email')))
		    ->from($db->quoteName('actualiza_contrasena'))
		    ->where($db->quoteName('variable') . ' = '.$db->quote($key).' AND '.$db->quoteName('cambio').' = '.$db->quote("NO"));
		$db->setQuery($query);
		$encontrado = $db->loadResult();
		if($encontrado){ 
			$doc->addScript('templates/somosmaestros/js/password.js');
			$doc->addScript('templates/somosmaestros/js/passwordplus.js');
		?>
		<form method="post" id="formRee" action="index.php?option=com_somosmaestros&view=recuperarcontrasena">
			<label for="password1" id="labelRecuperar">Establece una contraseña para tu cuenta</label>
			<p>Define una nueva contraseña e ingresala en los siguientes campos</p>
			<input type="password" id="password1" name="password1" placeholder="Ingresa tu contraseña"><br>
			<input type="password" id="password2" name="password2" placeholder="Confirma tu contraseña">
			<input type="hidden" id="emailRecuperar" name="emailRecuperar" value="<?php echo $encontrado; ?>">
			<input type="hidden" id="establecer" name="establecer" value="si">
			<input type="submit" value="Cambiar contraseña" class="btn btn-primary">
		</form>
		<script type="text/javascript">
		jQuery.validator.setDefaults({
		    submitHandler: function(form) {
				jQuery(form).submit();
			}
		});
		jQuery.validator.addMethod(
	        "regex",
	        function(value, element, regexp) {
	            var re = new RegExp(regexp);
	            return this.optional(element) || re.test(value);
	        },
	        "Su contraseña debe contener mínimo 5 caracteres, minimo un número, una letra mayúscula y otra minúscula"
		);

		jQuery("#formRee").validate({
		    rules: {
		        password1: {
		            required: true,
		        },
		        password2: {
		            required: true,
		            equalTo: "#password1"
		        },

		    },
		    messages: {
		        password1: {
		            required: "Por favor ingresa tu contraseña",
		        },
		        password2: {
		            required: "Debes confirmar tu contraseña",
		            equalTo: "La contraseña no coincide"
		        }
		    }
		});
		jQuery("#password1").rules("add", { regex: "(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{6,})" })
		</script>
		<?php };
		
	}
}else if($establecer == "si"){
	$doc->setTitle("Confirmación de contraseña");
	require_once 'templates/somosmaestros/code/SMEducativa.php';
	$db = JDatabaseDriver::getInstance( SMEducativa::getConexion() );
		
	$nuevo = new stdClass();
 	$nuevo->correo = $emailRecuperar;
	$nuevo->contrasena = md5($_POST['password1']);
	$nuevo->text_pwd = $_POST['password1'];
	// Update their details in the users table using id as the primary key.
	$result = $db->updateObject('usuario', $nuevo, 'correo');
	if($result){ ?>
		<div class="alert alert-success">
			<p>La contraseña se ha reestablecido correctamente, ya puedes ingresar usando tu nueva contraseña</p>

		</div>
	<?php } ;
}else{
?>

		<form method="post" action="">
			<label for="emailRecuperar" id="labelRecuperar">Ingresa el email de tu cuenta</label>
			<p>Enviaremos un link a tu correo para que restaures tu contraseña</p>
			<input type="email" id="emailRecuperar" name="emailRecuperar" placeholder="Tu E-mail">
			<input type="hidden" name="primerPaso" value="si">
			<input type="submit" value="Recuperar" class="btn btn-primary">
		</form>
	
<? } ?>
	</div>
</div>
