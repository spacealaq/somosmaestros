<?php
defined('_JEXEC') or die;
?>

<div class="moduletable">
	<h3>Blog</h3>
	<div id="giantcontent-98" class="giantcontent type-joomla layout-blog clearfix">
		<div id="gc-blog-98" class="gc-blog">
			<?php
				foreach ($listaBlogsPub as $blg) {
			?>
					<div class="gc-item">
						<div class="clipBlog">	
							<?php
							$cat=$blg->categoria;
							$db = JFactory::getDBO();
							$query='SELECT * FROM #__somosmaestros_categorias_blog WHERE id ='.(int)$cat;
							$db->setQuery($query);
							$i = $db->loadObjectList();
							?>
							<img src="<?php echo $i[0]->icono; ?>" />
						</div>
						<div class="gc-info clearfix paddingBlog">
							<div class="gc-title">
								<a><?php echo $blg->titulo; ?></a>
							</div>
							<div class="gc-info-top"></div>
							<div class="gc-image imagenDerecha">
								<a><img style="max-height: 190px; width:100%;"  src="<?php echo $blg->imagen_pequena; ?>" /></a>
							</div>
							<div class="gc-intro paddingBlog">
								<?php echo substr($blg->preview,0,250).'...'; ?>
							</div>
							<div class="clearfix"></div>
							<div class="gc-info-bottom">
								<span class="gc-readmore">
									<span class="cajaLeerMas"><i class="fa fa-caret-right"></i></span>							
									<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=blog&id='.(int) $blg->id); ?>" class=""><span>Más Información</a></span>
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