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

if($user->get('id') ){ 

jimport('joomla.application.component.model');
$modeloUsuarios = JModelLegacy::getInstance( 'Smpersonas', 'SomosmaestrosModel' );
$usariosSM = $modeloUsuarios->getItems();
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
                        <div class="span2 offset8">
                            <a href="index.php?option=com_somosmaestros&view=smpersonas&layout=agregarusuario" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar Usuario</a>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="span10">
                            <table class="table table-striped table-hover" id="tablaContenido">
                               <thead>
                                        <th class='left'>
                                        <?php echo JHtml::_('grid.sort',  'COM_SOMOSMAESTROS_SMPERSONAS_NOMBRE', 'a.nombre', $listDirn, $listOrder); ?>
                                        </th>
                                        <th class='left'>
                                        <?php echo JHtml::_('grid.sort',  'COM_SOMOSMAESTROS_SMPERSONAS_PERFIL', 'a.perfil', $listDirn, $listOrder); ?>
                                        </th>
                                        <th class='left'>
                                        <?php echo JHtml::_('grid.sort',  'COM_SOMOSMAESTROS_SMPERSONAS_USUARIO', 'a.usuario', $listDirn, $listOrder); ?>
                                        </th>
                                        <th></th>

                            </tr>
                            </thead>
                            <?php foreach ($usariosSM as $user) {
                                echo '<tr>';
                                echo '<td>'.$user->nombre.'</td>';
                                echo '<td>'.$user->perfil.'</td>';
                                echo '<td>'.$user->usuario.'</td>';
                            ?>
                                <td>
                                    <a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=smpersonas&layout=editarusuario&id='.(int) $user->id); ?>"  class="btn btn-warning">
                                        <i class="icon-edit icon-white"></i>
                                    </a>
                                    <a href="javascript: borrarUsuario(<?php echo $user->id; ?>);"  class="btn btn-danger">
                                        <i class="icon-remove icon-white"></i>
                                    </a>
                                </td>
                                <?php
                                echo '</tr>';
                            } ?>
                            </table>
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
function borrarUsuario(id){
                if(confirm("¿Está seguro de eliminar este usuario?")){
                    jQuery.ajax({
                        type: "GET",
                        url: "index.php?option=com_functions&task=eliminarUsuarioSM",
                        data: { id: id }
                    }).done(function( respBorrar ) {
                        if(respBorrar){
                            alert("El usuario ha sido eliminado correctamente");
                            location.reload(); 
                        }
                    });
                };
            }
</script>


