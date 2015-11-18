<?php
defined('_JEXEC') or die;
?>

<div class="moduletable">
	<h3>Artículos</h3>
	<div id="giantcontent-90" class="giantcontent type-joomla layout-blog clearfix">
		<div id="gc-blog-90" class="gc-blog">
			<?php
				foreach ($listaArticulosPub as $art) {
			?>
					<div class="gc-item">
						<div class="gc-info clearfix">
							<div class="gc-title">
								<a><?php echo $art->titulo; ?></a>
							</div>
							<div class="gc-info-top"></div>
							<div class="gc-image">
								<a><img style="max-height: 190px; width:100%;" src="<?php echo $art->imagen_pequena; ?>" /></a>
							</div>
							<div class="gc-intro">
								<?php echo substr($art->preview,0,250).'...'; ?>
							</div>
							<div class="clearfix"></div>
							<div class="gc-info-bottom">
								<span class="gc-readmore">
									<span class="cajaLeerMas"><i class="fa fa-caret-right"></i></span>							
									<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=articulo&id='.(int) $art->id); ?>" class=""><span>Más Información</a></span>
								</span>	
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
			<?php		
				}
			?>
		</div>
	</div>
</div>