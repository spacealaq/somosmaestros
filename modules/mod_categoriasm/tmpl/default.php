<?php
defined('_JEXEC') or die;
$doc = JFactory::getDocument();




if($tipo == 1){
	
	jimport('joomla.application.component.model');
	$modeloCatArticulos = JModelLegacy::getInstance( 'Categoriasarticulos', 'SomosmaestrosModel' );
	$CatArticulos = $modeloCatArticulos->getItems();
	//print_r($CatArticulos);

?>

<div class="moduletable">
	<ul class="nav menu">
		<?php 
			foreach ($CatArticulos as $a) {
		?>
			<li><a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=listararticulos&Itemid=101&categoria='.(int) $a->id); ?>"><?php echo $a->categoria; ?></a></li>
		<?php
		}
		?>
	</ul>
</div>

<?php }

if($tipo == 2){
	
	jimport('joomla.application.component.model');
	$modeloCatBlog = JModelLegacy::getInstance( 'Categoriasblog', 'SomosmaestrosModel' );
	$CatBlog = $modeloCatBlog->getItems();
	//print_r($CatBlog);

?>

<div class="moduletable">
	<ul class="nav menu">
		<?php 
			foreach ($CatBlog as $b) {
		?>
			<li><a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=listar_blogs&Itemid=199&categoria='.(int) $b->id); ?>"><?php echo $b->categoria; ?></a></li>
		<?php
		}
		?>
	</ul>
</div>

<?php }