<?php
defined('_JEXEC') or die;
?>

<ul id="bxslider">
	<?php 
		foreach ($listadoSliderPub as $sliderPub) {
	?>
		<li><a <?php if(!$sliderPub->link){ ?> <?php } else {?> target="_blank"  href="<?php echo $sliderPub->link ?>" <?php } ?>/><img width="100%" src="<?php echo $sliderPub->imagen_publico; ?>" <?php if($sliderPub->titulo && $sliderPub->descripcion){ ?>title="<?php echo $sliderPub->titulo; ?><br/><?php echo $sliderPub->descripcion; ?>" <?php } ?>/></a></li>
	<?php
		}
	 ?>		
</ul>
