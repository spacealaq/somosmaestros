<?php
defined('_JEXEC') or die;

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
?>
<div class="row">
	<div class="span10 offset1">
		<h3 class="tituloGris">Registro</h3>
		<form id="formDatosRegistro" class="cajaGris" method="POST" action="index.php?option=com_somosmaestros&view=registrar&layout=envio&Itemid=206">
			<div class="row">
				<div class="span2">Cédula</div>
				<div class="span2"><input type="text" name="cedula"></div>
				<div class="span1"></div>
				<div class="span2">Fecha de Nacimiento</div>
				<div class="span2"><input class="datepicker" type="text" name="fecha_nacimiento"></div>
			</div>
			<div class="row">
				<div class="span2">Nombres</div>
				<div class="span2"><input type="text" name="nombres"></div>
				<div class="span1"></div>
				<div class="span2">Apellidos</div>
				<div class="span2"><input type="text" name="apellidos"></div>
			</div>
			<div class="row">
				<div class="span2">Teléfono</div>
				<div class="span2"><input type="text" name="telefono"></div>
				<div class="span1"></div>
				<div class="span2">E-mail</div>
				<div class="span2"><input type="email" name="email"></div>
				
			</div>
			<div class="row">
				<div class="span2">Departamento</div>
				<div class="span2">
					<select name="departamentos" id="departamentos">
						<option value="">Selecciona un departamento</option>
						<?php foreach ($departamentos as $d) {
							echo '<option value="'.$d->DeId.'">'.$d->DeNombre.'</option>';
							
						} ?>
					</select>
				</div>
				<div class="span1"></div>
				<div class="span2">Ciudad</div>
				<div class="span2">
					<select name="ciudad" id="ciudades">
						<option value="">Selecciona una ciudad</option>
					</select>
				</div>
				
				
				
			</div>
			<div class="row">
				<div class="span2">Institución</div>
				
				<div class="span2">
					<select id="instituciones" name="institucion">
						<option value="">Selecciona una institución</option>
					</select>
				</div>
				<div class="span1"></div>
				<div class="span2">Género</div>
				<div class="span2">
					<select name="genero">
						<option value="">Selecciona</option>
						<option value="H">Hombre</option>
						<option value="M">Mujer</option>
					</select>
				</div>
			</div>
			<div class="row ">
				<div class="span2 pull-right"><input class="btn btn-primary" type="submit" value="Regístrate"></div>
			</div>
			<!--
			<div class="row">
				<div class="span2">Contraseña</div>
				<div class="span2"><input type="password" name="password" id="password"></div>
				<div class="span1"></div>
				<div class="span2">Confirmar Contraseña</div>
				<div class="span2"><input type="password" name="password2" id="password2"></div>
			</div>
			-->
		</form>
	</div>
</div>
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
	/*
	jQuery.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Su contraseña debe contener mínimo 5 caracteres, minimo un número, una letra mayúscula y otra minúscula"
	);


	        password: {
	            required: true,
	        },
	        password2: {
	            required: true,
	            equalTo: "#password"
	        },


	    messages: {
	        password2: {
	            equalTo: "La contraseña no coincide"
	        }
	    }
		
	jQuery("#password").rules("add", { regex: "(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{6,})" })
	   */

	jQuery("#formDatosRegistro").validate({
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
	        	required:true
	        }

	    }
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