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
$modeloArticulos = JModelLegacy::getInstance( 'Articulos', 'SomosmaestrosModel' );
$listadoArticulos = $modeloArticulos->getItems();

require_once 'templates/somosmaestros/code/SMBrujula.php';

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
							<a href="index.php?option=com_somosmaestros&view=creararticulos&Itemid=392" class="btn btn-primary"><i class="fa fa-plus"></i> Crear Artículo</a>
						</div>
					</div>
					<div class="row"> 
						<div class="span10">
							<table class="table table-striped table-hover" id="tablaContenido">
								<tr>
									<td>Id</td>
									<td>Título</td>
									<td>Categoria</td>
									<td>Público</td>
									<td>Destacado</td>
									<td></td>
								</tr>
							<?php foreach ($listadoArticulos as $art) {
								echo '<tr>';
								echo '<td>'.$art->id.'</td>';
								echo '<td>'.$art->titulo.'</td>';
								echo '<td>'.$art->categoria.'</td>';
								if($art->publico != 0){echo '<td>SI</td>';} else {echo '<td>NO</td>';}
								?>
								<td>
									<a href="javascript: destacarArticulo(<?php echo $art->id;?>,<?php echo $art->destacado;?>);"  class="<?php if($art->destacado != 0){echo 'btn btn-info';} else {echo 'btn btn-danger';}?>">
					  					<i class="icon-star icon-white"></i>
									</a>
								</td>
								<td>
						    		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=articulos&layout=editararticulos&id='.(int) $art->id); ?>"  class="btn btn-warning">
					  					<i class="icon-edit icon-white"></i>
									</a>
									<a href="javascript: borrarArticulo(<?php echo $art->id; ?>);"  class="btn btn-danger">
					  					<i class="icon-remove icon-white"></i>
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
function borrarArticulo(id){
				if(confirm("¿Está seguro de borrar este artículo?")){
					jQuery.ajax({
						type: "GET",
				url: "index.php?option=com_functions&task=eliminarArticulo",
						data: { id: id }
					}).done(function( respBorrar ) {
						if(respBorrar){
							alert("Su artículo ha sido eliminado correctamente");
							location.reload(); 
						}
					});
				};
			}

function destacarArticulo(id,d){
	var des;
	if(d == 0){
		des = 1;
	} else {
		des = 0;
	}
	jQuery.ajax({
		type: "GET",
		url: "index.php?option=com_functions&task=destacarArticulo",
		data: { 
			id: id, 
			destacado: des}
	}).done(function( respBorrar ) {
		if(respBorrar){
			alert("Cambio realizado");
			location.reload(); 
		}
	});
}
</script>


