<?php
defined('_JEXEC') or die;
?>

<ul id="bxslider">
	<?php 
		foreach ($listadoSliderInt as $sliderInt) {
	?>
		<li><a <?php if(!$sliderPub->link){ ?> <?php } else {?> target="_blank" href="<?php echo $sliderInt->link ?>" <?php } ?>/><img width="100%" src="<?php echo $sliderInt->imagen_interno; ?>" <?php if($sliderInt->titulo && $sliderInt->descripcion){ ?>title="<?php echo $sliderInt->titulo; ?><br/><?php echo $sliderInt->descripcion; ?>" <?php } ?>></a></li>
	<?php
		}
	 ?>		
</ul>
