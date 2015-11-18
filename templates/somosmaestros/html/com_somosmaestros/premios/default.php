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
$modeloPremios = JModelLegacy::getInstance( 'Premios', 'SomosmaestrosModel' );
$listadoPremios = $modeloPremios->getItems();

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
					</div>
						<div class="span2 offset8">
							<a href="index.php?option=com_somosmaestros&view=crearpremios&Itemid=817" class="btn btn-primary"><i class="fa fa-plus"></i> Crear premio</a>
						</div>
					</div>
					<div class="row"> 
						<div class="span10">
							<table class="table table-striped table-hover" id="tablaContenido">
								<tr>
									<td>Id</td>
									<td>Premio</td>
									<td>Puntos</td>
									<td>Inventario</td>
									<td></td>
									<td></td>
								</tr>
							<?php foreach ($listadoPremios as $pre) {
								echo '<tr>';
									echo '<td>'.$pre->id.'</td>';
									echo '<td>'.$pre->premio.'</td>';
									echo '<td>'.$pre->puntos.'</td>';	
									echo '<td>'.$pre->cantidad.'</td>';	
								?>
									<td>
								 		<input  class="btn btn-info" id="editar" type="submit"  value="Generar Informe - Excel" />
										<a href="javascript: destacarPremio(<?php echo $pre->id;?>,<?php echo $pre->destacado;?>);"  class="<?php if($pre->destacado != 0){echo 'btn btn-info';} else {echo 'btn btn-danger';}?>">
						  					<i class="icon-star icon-white"></i>
										</a>
									</td>
									<td>
							    		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=premios&layout=editarpremio&id='.(int) $pre->id); ?>"  class="btn btn-info">
						  					<i class="icon-eye-open icon-white"></i>
										</a>
										<a href="javascript: borrarPremio(<?php echo $pre->id; ?>);"  class="btn btn-danger">
						  					<i class="icon-remove icon-white"></i>
										</a>
								<?php
									echo '</td>';
									} 
								?>
								</tr>
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
	function borrarPremio(id){
				if(confirm("¿Está seguro de borrar este premio?")){
					jQuery.ajax({
						type: "GET",
				url: "index.php?option=com_functions&task=eliminarPremio",
						data: { id: id }
					}).done(function( respBorrar ) {
						if(respBorrar){
							alert("Su premio ha sido eliminado correctamente");
							location.reload(); 
						}
					});
				};
			}

	function destacarPremio(id,d){
		var des;
		if(d == 0){
			des = 1;
		} else {
			des = 0;
		}
		jQuery.ajax({
			type: "GET",
			url: "index.php?option=com_functions&task=destacarPremio",
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