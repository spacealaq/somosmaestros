<?php
defined('_JEXEC') or die;
$tipo = $params->get("tipo");
$color = $params->get("color_sombra");
$titulo = $params->get("titulo");
$imagen = $params->get("imagen");
$texto = $params->get("texto");
$padding = $params->get("padding");
$paddingTexto = $params->get("paddingTexto");
$cantidad = $params->get("cantidadTexto");
$orden = $params->get("orden");
$doc = JFactory::getDocument();


$db = JFactory::getDbo();
$query = $db->getQuery(true);



$doc = JFactory::getDocument();
$doc->addStyleSheet('templates/somosmaestros/css/jquery.fancybox.css');
$doc->addScript('templates/somosmaestros/js/jquery.fancybox.js');
$doc->addScript('templates/somosmaestros/js/helpers/jquery.fancybox-media.js');

if($tipo == 3){
	
	$db = JFactory::getDBO();
	$query='SELECT * FROM #__somosmaestros_formacion WHERE publico = 1 AND destacado = 1 LIMIT 1';
	$db->setQuery($query);
	$formacion = $db->loadObjectList();

	foreach ($formacion as $f) {
?>


	<div class="cajaHome" style="padding:<?php echo $padding; ?>px;border-radius:10px;box-shadow:4px 4px 7px -1px <?php echo $color; ?>">
		<?php if($titulo == "1"){ ?>
			<h4><?php echo $f->titulo; ?></h4>
		<?php } ?>
		<?php if($imagen == "1"){
				$mini = $f->imagen_pequena;
				echo '<img src="'.$mini.'" class="imagenUsHome" />';
		} ?>
		<?php if($texto == "1"){ ?>
			<?php echo '<div class="introHome" style="padding:'.$paddingTexto.'px;">'.strip_tags(substr($f->contenido,0,$cantidad)).'</div>'; ?>
		<?php } ?>
		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=formacion&id='.(int) $f->id); ?>" class="btn btn-primary btnMasHome">Más información</a>
	</div>
	<? } ?>


<?php }

if($tipo == 6){

		$db = JFactory::getDBO();
		$query='SELECT * FROM #__somosmaestros_video WHERE state = 1 LIMIT 1';
		$db->setQuery($query);
		$video = $db->loadObjectList();
		
		foreach ($video as $v) {
	?>


	<div class="cajaHome" style="padding:<?php echo $padding; ?>px;border-radius:10px;box-shadow:4px 4px 7px -1px <?php echo $color; ?>">
		<?php if($titulo == "1"){ ?>
			<h4><?php echo $v->titulo; ?></h4>
		<?php } ?>
		<?php if($imagen == "1"){
			echo '<img src="'.$v->imagen.'" class="imagenUsHome" />';
		} ?>
		<a id="fancybox-media" href="http://www.youtube.com/watch?v=<?php echo $v->url; ?>" class="btn btn-primary btnMasHome">Ver Video</a>
	</div>
	<? } 
} 
?>

<script type="text/javascript">

jQuery(document).ready(function($){

	jQuery("#fancybox-media").fancybox({
			openEffect : 'none',
			closeEffect : 'none',
			prevEffect : 'none',
			nextEffect : 'none',

			arrows : false,
			helpers : {
				media : {},
				buttons : {}
			}
		});

});
</script>
<?php
if($tipo == 1){
	
	$db = JFactory::getDBO();
	$query='SELECT * FROM #__somosmaestros_articulos WHERE publico = 1 AND destacado = 1 LIMIT 1';
	$db->setQuery($query);
	$articulos = $db->loadObjectList();

	foreach ($articulos as $a) {
	
?>
	<div class="cajaHome" style="padding:<?php echo $padding; ?>px;border-radius:10px;box-shadow:4px 4px 7px -1px <?php echo $color; ?>">
		<?php if($titulo == "1"){ ?>
			<h4><?php echo $a->titulo; ?></h4>
		<?php } ?>
		<?php if($imagen == "1"){
			$mini = $a->imagen_pequena;
			echo '<img src="'.$mini.'" class="imagenUsHome" />';
		} ?>
		<?php if($texto == "1"){ ?>
			<?php echo '<div class="introHome" style="padding:'.$paddingTexto.'px;">'.substr($a->preview,0,$cantidad).'</div>'; ?>
		<?php } ?>
		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=articulo&id='.(int) $a->id); ?>" class="btn btn-primary btnMasHome">Más información</a>
	</div>
	<? } ?>
	
<?php }

if($tipo == 4){
	$db = JFactory::getDBO();
	$query='SELECT * FROM #__somosmaestros_agenda WHERE publico = 1 AND destacado = 1 LIMIT 1';
	$db->setQuery($query);
	$agenda = $db->loadObjectList();
	
	foreach ($agenda as $ag) {
	?>

	<div class="cajaHome" style="padding:<?php echo $padding; ?>px;border-radius:10px;box-shadow:4px 4px 7px -1px <?php echo $color; ?>">
		<?php if($titulo == "1"){ ?>
				<h4><?php echo $ag->titulo; ?></h4>
		<?php } ?>
		<?php if($imagen == "1"){
				$mini = $ag->imagen_pequena;
				echo '<img src="'.$mini.'" class="imagenUsHome" />';
		} ?>
		<?php if($texto == "1"){ ?>
			<?php echo '<div class="introHome" style="padding:'.$paddingTexto.'px;">'.strip_tags(substr($ag->contenido,0,$cantidad)).'</div>'; ?>
		<?php } ?>
		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=agenda&id='.(int) $ag->id); ?>" class="btn btn-primary btnMasHome">Más información</a>
	</div>
	<? } ?>


<?php } 
if($tipo == 5){
	$db = JFactory::getDBO();
	$query='SELECT * FROM #__somosmaestros_premios WHERE destacado = 1 LIMIT 1';
	$db->setQuery($query);
	$premios = $db->loadObjectList();
	/*$query->select($db->quoteName(array('premio', 'descripcion', 'imagen')));
	$query->from($db->quoteName('#__somosmaestros_premios'));
	$query->where($db->quoteName('destacado') . ' = 1 AND  '.$db->quoteName('state').' = 1');
	$query->order('id ASC');
	$db->setQuery($query);
	$articulos = $db->loadObjectList();*/
	//print_r($articulos);
	
	foreach ($premios as $p) {
?>


	<div class="cajaHome" style="padding:<?php echo $padding; ?>px;border-radius:10px;box-shadow:4px 4px 7px -1px <?php echo $color; ?>">
		<?php if($titulo == "1"){ ?>
			<h4><?php echo $p->premio; ?></h4>
		<?php } ?>
		<?php if($imagen == "1"){
			echo '<img src="'.$p->imagen.'" class="imagenUsHome" />';
		} ?>
		<?php if($texto == "1"){ ?>
			<?php echo '<div class="introHome" style="padding:'.$paddingTexto.'px;">'.substr($p->descripcion,0,$cantidad).'</div>'; ?>
		<?php } ?>
		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=premio&id='.(int) $p->id); ?>" class="btn btn-primary btnMasHome">Más información</a>
	</div>

	<? } ?>
<?php }

if($tipo == 2) {

	$db = JFactory::getDBO();
	$query='SELECT * FROM #__somosmaestros_blogs WHERE publico = 1 AND destacado = 1 LIMIT 1';
	$db->setQuery($query);
	$blogs = $db->loadObjectList();

	foreach ($blogs as $b) {

?>


	<div class="cajaHome" style="padding:<?php echo $padding; ?>px;border-radius:10px;box-shadow:4px 4px 7px -1px <?php echo $color; ?>">
		<?php if($titulo == "1"){ ?>
			<h4><?php echo $b->titulo; ?></h4>
		<?php } ?>
		<?php if($imagen == "1"){
			$mini = $b->imagen_pequena;
			echo '<img src="'.$mini.'" class="imagenUsHome" />';

		} ?>
		<?php if($texto == "1"){ ?>
			<?php echo '<div class="introHome" style="padding:'.$paddingTexto.'px;">'.substr($b->preview,0,$cantidad).'</div>'; ?>
		<?php } ?>
		<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=blog&id='.(int) $b->id); ?>" class="btn btn-primary btnMasHome">Más información</a>
	</div>
	<? } ?>

<?php } ?> 