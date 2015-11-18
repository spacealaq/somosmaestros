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


$idFormacion = JRequest::getVar('id');

$doc = JFactory::getDocument();

$doc->addScript('templates/somosmaestros/js/list.js');
$doc->addScript('templates/somosmaestros/js/template.js');

$doc->addStyleSheet('templates/somosmaestros/css/awesome.css');
$doc->addStyleSheet('templates/somosmaestros/css/template.css');



$session =& JFactory::getSession();
$user = JFactory::getUser();


$idFormacion = JRequest::getVar('id');

if($user->get('id') ){ 

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
                            <form id="formCrearAsistente" class="row form-crear">
                                <div class="span10">
                                    <label for="cedulaAsistente">Cédula:</label>
                                    <input name="cedulaAsistente" id="cedulaAsistente" type="text">
                                </div>  
                                <div class="span10">
                                    <label for="correoAsistente">Correo:</label>
                                    <input name="correoAsistente" id="correoAsistente" type="text">
                                </div>
                                <div class="span10">
                                    <div id="btn_asistente" class="btn btn-primary">
                                        <i class="icon-bookmark icon-white"></i> Agregar Asistente
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
        jQuery("#btn_asistente").click(function(){
                jQuery.ajax({
                type: "GET",
                url: "index.php?option=com_functions&task=asistenteFormacion",
                data: { 
                    cedula: jQuery("#cedulaAsistente").val(),
                    formacion: '<?php echo $idFormacion; ?>',
                    correo: jQuery("#correoAsistente").val(),
                },
                success: function( response ) {
                    if( response ){
                        alert("El asistente ha sido agregado correctamente");
                        location.assign("http://somosmaestros.co/index.php?option=com_somosmaestros&view=formacions&Itemid=406");
                    };
                }
            });
        });
    });
</script>