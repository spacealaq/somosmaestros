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

$idPremio = JRequest::getVar('id');

jimport('joomla.application.component.model');
$modeloPremios = JModelLegacy::getInstance( 'Premios', 'SomosmaestrosModel' );
$parametrosPre = $modeloPremios->getItems();

if($user->get('id') ){ 
	$doc = JFactory::getDocument();
	$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
	$doc->addScript('templates/somosmaestros/js/loading.js');
	$doc->addScript('templates/somosmaestros/js/uploadfile.js');
	$doc->addStyleSheet('templates/somosmaestros/css/uploadfile.css');
	$doc->addScript('templates/somosmaestros/js/chosen.jquery.min.js');
	$doc->addStyleSheet('templates/somosmaestros/css/chosen.min.css');
	require_once 'templates/somosmaestros/code/SMBrujula.php';

	foreach ($parametrosPre as $p) { 
 		if($p->id == $idPremio){
?>
	<div class="span2">
		<a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a>
	</div>
	<div class="span10">
		<div class="row">
			<div class="span10">
							<form id="formCrearPremio" class="row form-crear">
								<div class="span5">
									<label for="nombrePremio">Premio:</label>
									<input name="nombrePremio" id="nombrePremio" type="text" value="<?php echo $p->premio ?>">
								</div>				
								<div class="span5">
									<label for="puntosPremio">Puntos:</label>
									<input name="puntosPremio" id="puntosPremio" type="text" value="<?php echo $p->puntos ?>">
								</div>		
								<div class="span5">
									<label for="cantidadPremio">Cantidad:</label>
									<input name="cantidadPremio" id="cantidadPremio" type="text" value="<?php echo $p->cantidad ?>">
								</div>					
								<div class="span5">
									<label for="descripcionPremio">Descripción:</label>
									<input name="descripcionPremio" id="descripcionPremio" type="text" value="<?php echo $p->descripcion ?>">
								</div>
								<div class="span10"></div>
								<div class="span5">
									<label>Imagen Pequeña - Tamaño Recomendado 400 x 400</label>
									<img id="imagenPremio" class="imagenPequeña">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status2"></div>
									<img class="imagenPequeña" src="<?php echo $p->imagen ?>" />
								</div>				
								<div class="span10">
									<h5>Segmentación:</h5>
								</div>								
								<div class="span5">
									<label for="rolPremio">Rol:</label>
									<?php echo $p->rol ?>
									<select class="chosen-choices" name="rolPremio" id="rolPremio" multiple>
										<?php
											$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
											$query = $db->getQuery(true);
											$query = 'SELECT * FROM smbrujul_produccion.rolescontacto';
											$db->setQuery($query);
											$roles = $db->loadObjectList();
											foreach ($roles as $r) {
												echo '<option value="'.$r->RcNombre.'">'.$r->RcNombre.'</option>';
											}
										?>
									</select>
								</div>		
								<div class="span10">
									<div id="btn_guardarPremio" style="margin-top:10px;"class="btn btn-primary">
										<i class="icon-bookmark icon-white"></i> Moficar Premio
									</div>
								</div>
							</form>
						</div>
		</div>
		<div class="row"> 
		    <div class="premio premio-<?php echo $p->id; ?> span6">
		    		<div class="span10">
		    			<div class="row">
							<div class="span3" >
								<div class="contPuntosPremioInterna">
									<?php echo $p->puntos; ?><br>
									Puntos
								</div>
							</div>
							<div class="span7" id="contDetPremioInterna">
								<h2><?php echo $p->premio; ?></h2>
								<div class="row contDetPremioInterna">
									<div class="span4 contDescPremioInter">
										<?php echo $p->descripcion; ?><br>
										
										
										<div class="row" data-trigger="spinner" id="spinner">
											<div class="span3">
												<div class="row">
													<div class="span1 textoCantidad">Cantidad</div>
													<div class="span2"><input type="text" value="1" data-rule="quantity"></div>
												</div>
												
											</div>
											<div class="span1 controlCant">
										  		<a href="javascript:;" class="cantidadArriba" data-spin="up"></a>
										  		<a href="javascript:;" class="cantidadAbajo" data-spin="down"></a>
											</div>
										</div>
										<div class="row">
											<div class="span3">
												<div class="row">
													<div class="span1 textoCantidad">Valor a redimir</div>
													<div class="span2"><input type="text" value="<?php echo $p->puntos; ?>" id="valorRedimir"></div>
												</div>
												
											</div>
										</div>
										<div class="row">
											<div class="span4">
												<div class="row">
													<div class="span6">
														<div id="botonRedimir" class="btn btn-primary pull-right"><i class="fa fa-exchange"></i>
			 Redimir</div>
													</div>
												</div>
												
											</div>
										</div>
									</div>
									<div class="span3">
										<img src="<?php echo $p->imagen; ?>">
										
									</div>
									
								</div>
							</div>
						</div>    	
		    		</div>


		    		<div class="span10">
		    			<div class="span2 contenedorImgPremio"><img src="<?php echo $p->imagen; ?>" class="img-circle"></div>
		    		<div class="span4 contenedorInfoPremio">
		    			<div class="titPremio"><?php echo $p->premio; ?> <div class="botonToogle btn btn-primary btn-mini pull-right"><i class="icon-plus icon-white"></i> <span>Más</span> detalles</div></div>
		    			<div class="contenedorDesp">
			    			<div class="descPremio"><?php echo substr($p->descripcion, 0, 35)."... "; ?><!--<a href="<?php // echo JRoute::_('index.php?option=com_somosmaestros&view=premio&id='.(int) $p->id); ?>">Más info</a>--></div>
			    			<div class="puntosPremio"><?php echo $p->puntos; ?> Puntos</div>
			    			
		    			</div>
		    		</div>
		    		</div>
					
			</div> 
		</div>
	</div>
	<?php
		}
	}
	?>
<?php
}else{ ?>

	<div class="alert alert-error">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Permiso denegado! </strong> Área restringida
	</div>
	<?php

};

?>
<script type="text/javascript" src="templates/somosmaestros/js/spinedit.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	jQuery(".chosen-choices").chosen();
		jQuery(".titPremio").toggle(function() {
			jQuery(this).parent().find(".contenedorDesp").slideDown('fast');
			jQuery(this).find('.botonToogle').find('i').removeClass('icon-plus').addClass('icon-minus');
			jQuery(this).find('.botonToogle').find('span').text('Menos');
			jQuery(this).addClass('premioActivo');
		}, function() {
			jQuery(this).parent().find(".contenedorDesp").slideUp('fast');
			jQuery(this).find('.botonToogle').find('i').removeClass('icon-minus').addClass('icon-plus');
			jQuery(this).find('.botonToogle').find('span').text('Más');
			jQuery(this).removeClass('premioActivo');
		});

	
	var imagen1;
	var settings1 = {
	    url: "<?php echo JURI::base(); ?>subirImagen.php",
	    formData: {
	    	"tipo":"premios",
	    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
	    },
		onSuccess:function(files,data,xhr){
	       console.log(jQuery(this));
	       imagen1=data;
	       jQuery("#imagenPremio").attr("src","<?php echo JURI::base(); ?>"+data);
	       jQuery("#imagenPremio").fadeIn();
	    },
	    deleteCallback: function(data,pd){
		    for(var i=0;i<data.length;i++){
		        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
		        function(resp, textStatus, jqXHR){
		            jQuery("#imagenPremio").fadeOut();
		            alert("Archivo borrado");  
		        });
		    }      
		    pd.statusbar.hide(); //You choice to hide/not.
		}
	}

	var uploadObj1 = jQuery("#multiplefileuploader1").uploadFile(settings1);

		jQuery("#btn_guardarPremio").click(function(){
				jQuery.ajax({
				type: "GET",
				url: "index.php?option=com_functions&task=guardarPremio",
				data: { 
					id: <?php echo $idPremio; ?>,
					premio: jQuery("#nombrePremio").val(),
					puntos: jQuery("#puntosPremio").val(),
					cantidad: jQuery("#cantidadPremio").val(),
					descripcion: jQuery("#descripcionPremio").val(),
					imagen: imagen1,
					rol: jQuery("#rolPremio").val()
				},
				success: function( response ) {
					if( response ){
						alert("Tu premio se ha modificado correctamente");
						location.reload();
					};
				}
			});
		});

		/*jQuery("#spinner")
		.spinner('delay', 200) //delay in ms
		.spinner('changed', function(e, newVal, oldVal){
		//trigger lazed, depend on delay option.
		})
		.spinner('changing', function(e, newVal, oldVal){
			jQuery("#valorRedimir").val( <?php echo $this->item->puntos; ?>*newVal);
		});
*/

	});
</script>
