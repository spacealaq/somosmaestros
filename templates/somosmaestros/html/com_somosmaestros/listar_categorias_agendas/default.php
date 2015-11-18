<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addScript('templates/somosmaestros/js/jquery.bxslider.min.js');
$doc->addStyleSheet('templates/somosmaestros/css/jquery.bxslider.css');


jimport('joomla.application.component.model');
$modeloCategorias = JModelLegacy::getInstance( 'Categoriasagenda', 'SomosmaestrosModel' );
$categorias = $modeloCategorias->getItems();

?>

<div class="row" id="contenidoAgendas">
	<div class="span10 offset1">
		<?php
		foreach ($categorias as $cat) { ?>
			<h3 style="background-color:#<?php echo $cat->color; ?>;
		  background-image:url(<?php echo $cat->imagen; ?>);
		  background-position:-2px 50%;
		  background-repeat:no-repeat;
		  color:#<?php echo $cat->color; ?>;
		  height:27px;
		  text-indent:25px;
		  text-transform:uppercase;">
				<span style="
				background:none 0 0 repeat scroll #FFFFFF;
		  		display:block;
		  		margin-left:25px;
		  		position:relative;
		  		top: -3px;
		  		width:<?php echo $cat->ancho;?>px;"><?php echo $cat->categoria; ?></span>
			</h3>
			
			<?php
			$modeloAgendas = JModelLegacy::getInstance( 'Agendas', 'SomosmaestrosModel' );
			$modeloAgendas->setState('filter.categoria', (int)$cat->id);
			$agendas = $modeloAgendas->getItems();
			echo '<ul id="sliderAgenda-'.$cat->id.'" class="sliderAgenda">';
			foreach ($agendas as $age) { ?>
				<li class="contenedorAgenda" >
					<div class="imagenAgenda">
						<img src="<?php echo $age->imagen_pequena; ?>">
						
					</div>
					<div class="infoAgenda">
						<div class="tituloAgenda">
							<?php echo substr($age->titulo, 0, 60); ?>
						</div>
						<div class="textoAgenda">
							<?php 
								echo substr($age->preview, 0, 120) . '...';
							?>
						</div>
						<div class="botonAgenda">
							<a href="<?php echo JRoute::_('index.php?option=com_somosmaestros&view=agenda&id='.(int) $age->id); ?>">
							<span class="cajaLeerMas" style="color: #000;">
								<i class="fa fa-caret-right"></i>
							</span>
								<span style="color: #000;">Leer Más</span>
							</a>
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					</div>
					
				</li> 
			<?php
			}
			echo '</ul>';
			?>
			<script type="text/javascript">

			jQuery('#sliderAgenda-<?php echo $cat->id; ?>').bxSlider({
			  minSlides: 3,
			  maxSlides: 3,
			  slideWidth: 315,
			  slideMargin: 10,
			  moveSlides:1,
			  infiniteLoop:false
			});
			</script>

			<?php
		}

		?>
	</div>
</div>



