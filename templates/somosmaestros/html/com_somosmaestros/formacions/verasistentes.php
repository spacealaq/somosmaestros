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

if($user->get('id') ){ 

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('id', 'cedula', 'fecha', 'asistio')));
$query->from($db->quoteName('#__somosmaestros_asistentes_formacion'));
$query->where($db->quoteName('formacion') . ' = '. $idFormacion.' AND state = 1');
$db->setQuery($query);
$formacionCampañas = $db->loadObjectList();$db->setQuery($query);
$formacionCampañas = $db->loadObjectList();


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
                        <div class="span10">
                            <a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a>
                            <h5>Carga Masiva</h5>
                            <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                Elegir Archivo formato CSV: <br />
                                <input class="btn btn-info" name="csv" type="file" id="csv" />
                                <input class="btn btn-info" type="submit" name="Submit" value="Submit" />
                            </form>
                            <?php
                            if($_GET['import']){
                                 if($_GET['import']=="1"){
                                  echo '<div class="alert alert-success">La importación se realizó corectamente</div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="span2 offset8">
                            <a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=formacions&layout=agregarasistente&Itemid=406&id='.(int)$idFormacion); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar Asistente</a>
                        </div>
                        <div class="span10">
                            <table class="table table-striped table-hover" id="tablaContenido">
                                <tr>
                                    <td>Nombre</td>
                                    <td>Cédula</td>
                                    <td>Fecha</td>
                                    <td>Asistió</td>
                                    <td></td>
                                </tr>
                            <?php foreach ($formacionCampañas as $frm) {

                                require_once 'templates/somosmaestros/code/SMBrujula.php';
                                $db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
                                $query2 = $db2->getQuery(true);
                                $query2 = 'SELECT CONCAT_WS(" ",personas.PeNombres,personas.PePrimerApellido,personas.PeSegundoApellido) AS contacto FROM personas WHERE personas.PeIdentificacion ='.$frm->cedula;
                                $db2->setQuery($query2);
                                $usuario = $db2->loadObject();
                                echo '<tr>';
                                echo '<td>'.$usuario->contacto.'</td>';
                                echo '<td>'.$frm->cedula.'</td>';
                                echo '<td>'.$frm->fecha.'</td>';
                                ?>
                                <td>
                                    <a href="javascript: asistioFormacion(<?php echo $idFormacion;?>,<?php echo $frm->cedula;?>);"
                                      class="<?php if($frm->asistio == true){echo 'btn btn-success';} else {echo 'btn btn-danger';}?>">
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
function asistioFormacion(id,cc){
    jQuery.ajax({
        type: "GET",
        url: "index.php?option=com_functions&task=confirmarAsistenteFormacion",
        data: { 
            formacion: id, 
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

<?php 

setlocale(LC_ALL, "es_ES.UTF-8");
if ($_FILES[csv][size] > 0) {
    $db = JFactory::getDbo();
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");
    $hoy = date("Y-m-d H:i:s"); 
    $query='INSERT INTO `#__somosmaestros_asistentes_formacion` (`id`, `state`, `cedula`,`formacion`,`fecha`,`asistio`) VALUES';
    $total = 1;
    $fila = 1;
    if (($gestor = fopen($file, "r")) !== FALSE) {
     while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
        $total++;
     }
     fclose($gestor);


     //Hacer la validación de si existe la campaña aquí
     //$existe = false

     //Aquí debería ir el código que tienes en el controller
     
     //Si existe entonces $existe = true;


     //Descomenta esto pequeño
     /*
    if ($existe == true){
        $query2='INSERT INTO `la_tabla_de_brujula` (`id`, `state`, `cedula`,`formacion`,`fecha`,`asistio`) VALUES';   

    }*/
 }
 if (($gestor = fopen($file, "r")) !== FALSE) {
     while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
         $numero = count($datos);
         
         if($fila != 1){
          if($fila == ($total-1)){
            //Esto también
           /*if ($existe == true){
                $query2 .= '(null, 1, "'.$datos[0].'", "'.$datos[1].'","'.$hoy.'","'.$datos[2].'")';
           }*/
           $query .= '(null, 1, "'.$datos[0].'", "'.$datos[1].'","'.$hoy.'","'.$datos[2].'")';// Si es el último registro, lo deja sin , al fina
          }else{
            // Y Esto también
            /*if ($existe == true){
                $query2 .= '(null, 1, "'.$datos[0].'", "'.$datos[1].'","'.$hoy.'","'.$datos[2].'"),';
           }*/
           $query .= '(null, 1, "'.$datos[0].'", "'.$datos[1].'","'.$hoy.'","'.$datos[2].'"),';// Si no es el último entonces va poniendo la , 
          }
          
         } 
         



         $fila++; 
     }
     

     fclose($gestor);
 }
    //
    //echo $query;
    $db->setQuery($query);
    $res = $db->query();

    //AQUI DEBES EJECUTAR EL QUERY EN BRUJULA, como está en las dos lineas anteriores
    header('Location: index.php?option=com_somosmaestros&view=formacions&layout=verasistentes&id='.$idFormacion.'&Itemid=406&import='.$res);
}


?>