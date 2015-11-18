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


$idAgenda = JRequest::getVar('id');

if($user->get('id') ){ 

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('id', 'cedula', 'fecha', 'asistio')));
$query->from($db->quoteName('#__somosmaestros_asistentes_agenda'));
$query->where($db->quoteName('agenda') . ' = '. $idAgenda);
$db->setQuery($query);
$agendasCampañas = $db->loadObjectList();$db->setQuery($query);
$agendasCampañas = $db->loadObjectList();
?>
    <div class="row">
        <div class="span12">
            <div class="row">
                <div class="span2">
                    <?php
                        jimport('joomla.application.module.helper');
                        // this is where you want to load your module position
                        $modules = JModuleHelper::getModules('loginJoomla');
                        foreach($modules as $module){
                            echo JModuleHelper::renderModule($module);
                        } 
                    ?>
                    <div id="menuAdministradores">
                    <?php
                        jimport('joomla.application.module.helper');
                        // this is where you want to load your module position
                        $modules2 = JModuleHelper::getModules('menuAdmin');
                        foreach($modules2 as $module2){
                            echo JModuleHelper::renderModule($module2);
                        } 
                    ?>
                    </div>
                </div>
                <div class="span10">
                    <div class="row"> 
                        <div class="span2">
                            <a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a>
                        </div>
                        <div class="span10">
                            <table class="table table-striped table-hover" id="tablaContenido">
                                <tr>
                                    <td>Id</td>
                                    <td>Cédula</td>
                                    <td>Fecha</td>
                                    <td>Asistió</td>
                                    <td></td>
                                </tr>
                            <?php foreach ($agendasCampañas as $ag) {
                                echo '<tr>';
                                echo '<td>'.$ag->id.'</td>';
                                echo '<td>'.$ag->cedula.'</td>';
                                echo '<td>'.$ag->fecha.'</td>';
                                ?>
                                <td>
                                    <a href="javascript: asistioAgenda(<?php echo $idAgenda;?>,<?php echo $ag->cedula;?>);"
                                      class="<?php if($ag->asistio == true){echo 'btn btn-success';} else {echo 'btn btn-danger';}?>">
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
function asistioAgenda(id,cc){
    jQuery.ajax({
        type: "GET",
        url: "index.php?option=com_functions&task=confirmarAsistenteAgenda",
        data: { 
            agenda: id, 
            cedula: cc
        }
    }).done(function( respBorrar ) {
        if(respBorrar){
            alert("Asistencia Confirmada");
            location.reload(); 
        }
    });
}
</script>

