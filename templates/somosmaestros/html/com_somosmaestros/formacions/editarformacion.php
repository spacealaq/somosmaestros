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

$idFormacion = JRequest::getVar('id');

jimport('joomla.application.component.model');
$modeloFormaciones = JModelLegacy::getInstance( 'Formacions', 'SomosmaestrosModel' );
$parametrosForm = $modeloFormaciones->getItems();

if($user->get('id') ){ 
	$doc = JFactory::getDocument();
	$doc->addScript("templates/somosmaestros/js/datepicker.js");
	$doc->addScript("templates/somosmaestros/js/datepicker_es.js");
	$doc->addStyleSheet("templates/somosmaestros/css/datepicker.css");
	$doc->addStyleSheet("templates/somosmaestros/css/loading.css");
	$doc->addScript('templates/somosmaestros/js/loading.js');	
	$doc->addScript('templates/somosmaestros/js/uploadfile.js');
	$doc->addStyleSheet('templates/somosmaestros/css/uploadfile.css');
	$doc->addScript('templates/somosmaestros/js/chosen.jquery.min.js');
	$doc->addStyleSheet('templates/somosmaestros/css/chosen.min.css');
	$doc->addScript('templates/somosmaestros/js/bootstrap-wysiwyg.js');
	$doc->addScript('templates/somosmaestros/js/jquery.hotkeys.js');
	$doc->addStyleSheet('templates/somosmaestros/css/awesome.css');
	require_once 'templates/somosmaestros/code/SMBrujula.php';
	foreach ($parametrosForm as $p) { 
 		if($p->id == $idFormacion){
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
							<form id="formCrearFormacion" class="row form-crear">

								<div class="span5">
									<label for="tituloFormacion">Título:</label>
									<input name="tituloFormacion" id="tituloFormacion" type="text" value="<?php echo $p->titulo ?>">
								</div>			
								<div class="span5">
									<label for="disponibilidadFormacion">Disponibilidad:</label>
									<input name="disponibilidadFormacion" id="disponibilidadFormacion" type="text" value="<?php echo $p->disponibilidad ?>">
								</div>		
								<div class="span5">
									<label for="fuenteFormacion">Fuente:</label>
									<input name="fuenteFormacion" id="fuenteFormacion" type="text" value="<?php echo $p->fuente ?>">
								</div>
								<div class="span5">
									<label for="publicoFormacion">Formación Pública?</label>
									<select name="publicoFormacion" id="publicoFormacion">
										<option selected value="<?php echo $p->publico ?>"><?php if($p->publico != 0){echo 'SI';} else {echo 'NO';}?></option>
										<?php
											if($p->publico != 0){
												echo '<option value="0">NO</option>';
											} else {
												echo '<option value="1">SI</option>';
											}										
										?>
									</select>
								</div>	
								<div class="span10">
									<label for="previewFormacion">Preview</label>
									<textarea name="previewFormacion" id="previewFormacion"><?php echo $p->preview ?></textarea>
								</div>	
								<div class="span5"></div>					
								<div class="span10">
									<label for="contenidoFormacion">Contenido:</label><div class="btn-toolbar" data-role="editor-toolbar" data-target="#contenidoFormacion">
								      <div class="btn-group">
								        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
								          <ul class="dropdown-menu">
								          <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
								      </div>
								      <div class="btn-group">
								        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
								          <ul class="dropdown-menu">
								          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
								          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
								          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
								          </ul>
								      </div>
								      <div class="btn-group">
								        <a class="btn btn-primary" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
								        <a class="btn btn-primary" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
								        <a class="btn btn-primary" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="fa fa-text-width"></i></a>
								      </div>
								      <div class="btn-group">
								        <a class="btn btn-primary" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="fa fa-list"></i></a>
								        <a class="btn btn-primary" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="fa fa-list-alt"></i></a>
								        <a class="btn btn-primary" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="fa fa-outdent"></i></a>
								        <a class="btn btn-primary" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="fa fa-indent"></i></a>
								      </div>
								      <div class="btn-group">
								        <a class="btn btn-primary" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
								        <a class="btn btn-primary" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
								        <a class="btn btn-primary" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
								        <a class="btn btn-primary" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
								      </div>
								      <!--
								      <div class="btn-group">
								      <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="fa fa-link"></i></a>
								        <div class="dropdown-menu input-append">
								          <input class="span2" placeholder="URL" data-edit="createLink" type="text">
								          <button class="btn" type="button">Add</button>
								        </div>
								        <a class="btn btn-primary" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="fa fa-unlink"></i></a>

								      </div>
								      <div class="btn-group">
								        <a class="btn btn-primary" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="fa fa-file-image-o"></i></a>
								        <input data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 37px; height: 30px;" type="file">
								      </div>-->
								      <div class="btn-group">
								        <a class="btn btn-primary" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
								        <a class="btn btn-primary" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
								      </div>
								    </div>
								    <div id="contenidoFormacion">
								      <?php echo $p->contenido ?>
								    </div>
								</div>
								</div>
								<div class="span5">
									<label>Imagen Grande - Tamaño Recomendado: 700 x 400</label>
									<img id="imagenFormacion1" class="imagenGrande">
									<div id="multiplefileuploader1">Subir</div>
									<div id="status1"></div>
									<img src="<?php echo $p->imagen_grande ?>" />
								</div>
								<div class="span5">
									<label>Imagen Pequeña - Tamaño Recomendado 300 x 171</label>									<img id="imagenFormacion2" class="imagenPequeña">
									<div id="multiplefileuploader2">Subir</div>
									<div id="status2"></div>
									<img src="<?php echo $p->imagen_pequena ?>" />
								</div>

								<div id="segmentacion">
									<div class="span10">
										<h5 class="segmentacion">Segmentación:</h5>
									</div>								
									<div class="span5">
										<label for="delegacionFormacion">Delegación</label>
										<?php echo $p->delegacion ?>
										<select class="chosen-choices" name="delegacionFormacion" id="delegacionFormacion" multiple>
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
										<label for="tipoFormacion">Tipo de Institución: </label>
										<?php echo $p->tipo_institucion ?>
										<select class="chosen-choices" name="tipoFormacion" id="tipoFormacion" multiple>
											<?php
												$db = JFactory::getDbo();
												$query = 'SELECT * FROM #__somosmaestros_tipo_institucion WHERE state = 1';
												$db->setQuery($query);
												$tipoInstitucion = $db->loadObjectList();
												foreach ($tipoInstitucion as $t) {
													echo '<option value="'.$t->tipo.'">'.$t->tipo.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="segmentoFormacion">Segmentos: </label>
										<?php echo $p->segmento ?>
										<select class="chosen-choices" name="segmentoFormacion" id="segmentoFormacion" multiple>
											<?php
												$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
												$query = $db->getQuery(true);
												$query = 'SELECT * FROM smbrujul_produccion.tipossector;';
												$db->setQuery($query);
												$tipossector = $db->loadObjectList();
												foreach ($tipossector as $s) {
													echo '<option value="'.$s->TcNombre.'">'.$s->TcNombre.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="nivelFormacion">Niveles:</label>
										<?php echo $p->nivel ?>
										<select class="chosen-choices" name="nivelFormacion" id="nivelFormacion" multiple>
											<?php
												$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
												$query = $db->getQuery(true);
												$query = 'SELECT * FROM smbrujul_produccion.niveleseducativospais';
												$db->setQuery($query);
												$niveles = $db->loadObjectList();
												foreach ($niveles as $n) {
													echo '<option value="'.$n->NvNombre.'">'.$n->NvNombre.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="ciudadFormacion">Ciudades:</label>
										<?php echo $p->ciudad ?>
										<select class="chosen-choices" name="ciudadFormacion" id="ciudadFormacion" multiple>
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
									<div class="span5">
										<label for="areaFormacion">Áreas:</label>
										<?php echo $p->area ?>
										<select class="chosen-choices" name="areaFormacion" id="areaFormacion" multiple>
											<?php
												$db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
												$query = $db->getQuery(true);
												$query = 'SELECT * FROM smbrujul_produccion.areas';
												$db->setQuery($query);
												$areas = $db->loadObjectList();
												foreach ($areas as $a) {
													echo '<option value="'.$a->AeNombre.'">'.$a->AeNombre.'</option>';
												}
											?>
										</select>
									</div>
									<div class="span5">
										<label for="rolFormacion">Rol:</label>
										<?php echo $p->rol ?>
										<select class="chosen-choices" name="rolFormacion" id="rolFormacion" multiple>
											<?php
												$query = $db->getQuery(true);
												$query = 'SELECT rolescontacto.RcId, rolescontacto.RcNombre FROM smbrujul_produccion.rolescontacto WHERE rolescontacto.RcId IN ("C", "P", "R") ORDER BY rolescontacto.RcNombre ';
												$db->setQuery($query);
												$roles = $db->loadObjectList();
												foreach ($roles as $r) {
													echo '<option value="'.$r->RcNombre.'">'.$r->RcNombre.'</option>';
												}
											?>
										</select>
									</div>

									<div class="span5">
										<label for="proyectoFormacion">Proyectos:</label>
										<?php echo $p->proyecto ?>
										<select class="chosen-choices" name="proyectoFormacion" id="proyectoFormacion" multiple>
											<?php
												$query = $db->getQuery(true);
												$query = 'SELECT agrupaciones.AcNombre, agrupaciones.AcId FROM smbrujul_produccion.productos INNER JOIN smbrujul_produccion.agrupaciones ON productos.PcAgrupacion = agrupaciones.AcId WHERE productos.PcId IN (7504, 7417, 7480, 7551, 9129, 10215, 13013, 7492, 1980, 13406, 12982, 13079, 8940, 13022, 13072, 2014, 7545, 6010, 13036, 7486, 13060, 7515, 8931, 13066, 2016, 12936, 12960,4098, 6049, 1921, 8858, 8995, 8905, 5920, 12997, 12924, 6061, 13017, 8934, 13048, 7467, 12985) ORDER BY agrupaciones.AcNombre';
												$db->setQuery($query);
												$proyectos = $db->loadObjectList();
												foreach ($proyectos as $pr) {
													echo '<option value="'.$pr->AcNombre.'">'.$pr->AcNombre.'</option>';
												}
											?>

										</select>
									</div>								
								</div>
								<div class="span5"></div>
								<div class="span10">
					  					<div id="btn_guardarFormacion" class="btn btn-primary">
											<i class="icon-bookmark icon-white"></i> Guardar Formacion
										</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
		}
	}
}else{ ?>

	<div class="alert alert-error">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Permiso denegado! </strong> Área restringida
	</div>
	<?php

};

?>

<script type="text/javascript">

jQuery(document).ready(function(){

	var tipo = jQuery('#publicoFormacion').val();
		if(tipo === '1'){
			jQuery('#segmentacion').slideUp();
			jQuery('.segmentacion').slideUp();
		}

	jQuery('#publicoFormacion').change(function(){
		var tipo = jQuery('#publicoFormacion').val();
		if(tipo === '1'){
			jQuery('#segmentacion').slideUp();
			jQuery('.segmentacion').slideUp();
		}else{
			jQuery('.segmentacion').slideDown();
			jQuery('#segmentacion').slideDown();
		}
	});

	jQuery("#contenidoFormacion").wysiwyg()

	jQuery(".chosen-choices").chosen();
	var imagen1, imagen2;
	var settings1 = {
	    url: "<?php echo JURI::base(); ?>subirImagen.php",
	    formData: {
	    	"tipo":"formacion",
	    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
	    },
		onSuccess:function(files,data,xhr){
	       console.log(jQuery(this));
	       imagen1=data;
	       jQuery("#imagenFormacion1").attr("src","<?php echo JURI::base(); ?>"+data);
	       jQuery("#imagenFormacion1").fadeIn();
	    },
	    deleteCallback: function(data,pd){
		    for(var i=0;i<data.length;i++){
		        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
		        function(resp, textStatus, jqXHR){
		            jQuery("#imagenFormacion1").fadeOut();
		            alert("Archivo borrado");  
		        });
		    }      
		    pd.statusbar.hide(); //You choice to hide/not.
		}
	}
	var settings2 = {
	    url: "<?php echo JURI::base(); ?>subirImagen.php",
	    formData: {
	    	"tipo":"formacion",
	    	"fecha":<?php echo '"'.$fecha=date(Ymd).'"'; ?>
	    },
		onSuccess:function(files,data,xhr){
	       console.log(jQuery(this));
	       imagen2=data;
	       jQuery("#imagenFormacion2").attr("src","<?php echo JURI::base(); ?>"+data);
	       jQuery("#imagenFormacion2").fadeIn();
	    },
	    deleteCallback: function(data,pd){
		    for(var i=0;i<data.length;i++){
		        jQuery.post("<?php echo JURI::base(); ?>borrarImagen.php",{op:"delete",name:data[i],fecha:<?php echo '"'.$fecha=date(Ymd).'"'; ?>},
		        function(resp, textStatus, jqXHR){
		            //Show Message  
		            jQuery("#imagenFormacion2").fadeOut();
		            alert("Archivo borrado");  
		        });
		    }      
		    pd.statusbar.hide(); //You choice to hide/not.
		}

	}
	
	var uploadObj1 = jQuery("#multiplefileuploader1").uploadFile(settings1);
	var uploadObj2 = jQuery("#multiplefileuploader2").uploadFile(settings2);

	jQuery("#btn_guardarFormacion").click(function(){
					jQuery.ajax({
						type: "POST",
						url: "index.php?option=com_functions&task=guardarFormacion",
						data: { 
							id: <?php echo $idFormacion; ?>,
							titulo: jQuery("#tituloFormacion").val(),
							disponibilidad: jQuery("#disponibilidadFormacion").val(),
							publico: jQuery("#publicoFormacion").val(),
							fuente: jQuery("#fuenteFormacion").val(),
							preview: jQuery("#previewFormacion").val(),
							contenido: jQuery("#contenidoFormacion").html(),
							imagen_grande: imagen1,
							imagen_pequeña: imagen2,
							delegacion: jQuery("#delegacionFormacion").val(),
							tipoInstitucion: jQuery("#tipoFormacion").val(),
							segmento: jQuery("#segmentoFormacion").val(),
							nivel: jQuery("#nivelFormacion").val(),
							ciudad: jQuery("#ciudadFormacion").val(),
							area: jQuery("#areaFormacion").val(),
							rol: jQuery("#rolFormacion").val(),
							proyecto: jQuery("#proyectoFormacion").val()
						},
						success: function( response ) {
							if( response ){
								alert("Tu formación se ha modificado correctamente");
								location.assign("index.php?option=com_somosmaestros&view=formacions&Itemid=406");
							};
						}
					});
			});
});
	
function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = jQuery('[title=Font]').siblings('.dropdown-menu');
      jQuery.each(fonts, function (idx, fontName) {
          fontTarget.append(jQuery('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      jQuery('a[title]').tooltip({container:'body'});
    	jQuery('.dropdown-menu input').click(function() {return false;})
		    .change(function () {jQuery(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';jQuery(this).change();});

      jQuery('[data-role=magic-overlay]').each(function () { 
        var overlay = jQuery(this), target = jQuery(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = jQuery('#contenidoFormacion').offset();
        jQuery('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+jQuery('#contenidoFormacion').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};

    function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		jQuery('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	jQuery('#contenidoFormacion').wysiwyg({ fileUploadError: showErrorAlert} );
	window.prettyPrint && prettyPrint();

</script>