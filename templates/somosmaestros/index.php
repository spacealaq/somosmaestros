<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$registro   = $app->input->getCmd('registro', '');
$sitename = $app->getCfg('sitename');

//echo getcwd();
// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
$doc->addScript('templates/somosmaestros/js/jquery.bxslider.min.js');
$doc->addScript('templates/' .$this->template. '/js/list.js');
$doc->addScript('templates/' .$this->template. '/js/list.pagination.js');
$doc->addScript('templates/' .$this->template. '/js/template.js');

// Add Stylesheets
$doc->addStyleSheet('templates/'.$this->template.'/css/awesome.css');
   $doc->addStyleSheet('templates/somosmaestros/css/jquery.bxslider.css');
$doc->addStyleSheet('templates/'.$this->template.'/css/content.css');
$doc->addStyleSheet('templates/'.$this->template.'/css/template.css');

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', true, $this->direction);

// Add current user information
$user = JFactory::getUser();
$session =& JFactory::getSession();

if ($option == "com_functions"){
	// Set the MIME type for JSON output.
	$doc->setMimeEncoding('application/json');

?>
<jdoc:include type="component" />
<?php }else{ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
	<![endif]-->
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
?>">
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '107313009612031',
      xfbml      : true,
      version    : 'v2.3'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
	<div id="header">
		<div class="container">
			<div class="row">
				<div class="span3" id="logo">
					<h1>SomosMaestros SM Colombia</h1>
					<a href="<?php echo JURI::base(); ?>"><img src="images/logo.png" alt="Logo SomosMaestros"></a>
				</div>
				<div class="span6 offset3" id="cuenta">
					<jdoc:include type="modules" name="loginSm" style="none" />
				</div>
			</div>
		</div>
	</div>
	<?php if ($registro == 'ok' && $session->get('logueado') == false) { ?>
	<div id="menuPrincipal">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="alert alert-success">
						<p>Tu cuenta se ha creado correctamente, ahora puedes ingresar usando tu cédula y contraseña</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if($this->countModules('sliderPublicoSM') && !$session->get('logueado') ){ ?>
	<div id="sliderPrincipal">
		<div class="container">
			<div class="row">
				<div class="span12">
					<jdoc:include type="modules" name="sliderPublicoSM" style="none" />
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if($this->countModules('sliderInternoSM') && $session->get('logueado')  && $view != 'funcionarios'){ ?>
	<div id="fraseSitio">
		<div class="container">
			<div class="row">
				<div class="span12">
					<jdoc:include type="modules" name="sliderInternoSM" style="none" />
				</div>
			</div>
		</div>
	</div>

	<?php } // || !$user->guest ?>
	
	<?php if ($session->get('logueado')) { ?>
	<div id="menuPrincipal">
		<div class="container">
			<div class="row">
				<div class="span12">
					<jdoc:include type="modules" name="menuPrincipal" style="none" />
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div id="articulosHome">
		<div class="container">
			<?php if($this->countModules('rutaSM')){ ?>
			<div class="row">
				<div class="span12">
					<jdoc:include type="modules" name="rutaSM" style="none" />
				</div>
			</div>
			<?php } ?>
			<div class="row">

				<?php if($this->countModules('categoriasSM') && $view != "listarcategoriasblogs" && $view != "articulo"){ ?>
				<div class="span2" id="cajaIzquierda">
					<jdoc:include type="modules" name="categoriasSM" style="none" />
				</div>
				<div <?php if(($option == "com_somosmaestros" && $view == "articulo") || ($option == "com_somosmaestros" && $view == "blog")){ echo 'class="span10"'; }else{ echo 'class="span8"';} ?>>
					<?php if ($session->get('logueado')) { ?>
						<jdoc:include type="message" />
						<jdoc:include type="component" />
					<?php }else{ ?>
					    <!--<div class="alert alert-error">
					    Lo sentimos, debes iniciar sesión para ver esta información
					    </div>-->
					    <div class="limitado">
						    <jdoc:include type="message" />
							<jdoc:include type="component" />
						</div>
					<?php } ?>
					<?php if(($view == "article" || $view == "item") && $session->get('logueado')){ ?>
					<jdoc:include type="modules" name="articulosDestacados" style="xhtml" />
					<?php } ?>
				</div>
				<?php }else if($this->countModules('homeartSM')){ 
					if ($session->get('logueado')) { ?>
						<div class="span4">
							<jdoc:include type="modules" name="artdesSM" />
						</div>
						<div class="span8">
							<div class="row">
								<div class="span4"><jdoc:include type="modules" name="blgdesSM" /></div>
								<div class="span4"><jdoc:include type="modules" name="fordesSM" /></div>
							</div>
							<div class="row-fluid tresColumnas">
								<div class="span4"><jdoc:include type="modules" name="agndesSM" /></div>
								<div class="span4"><jdoc:include type="modules" name="Pre2desSM" /></div>
								<div class="span4"><jdoc:include type="modules" name="Pre1desSM" /></div>
							</div>
						</div>
						
					<?php }else{ ?>
						<div class="span6 cajasInicio" id="cajaArticulos">
							<jdoc:include type="modules" name="homeartSM" style="none" />
						</div>
						<div class="span6 cajasInicio" id="cajaEntradas">
							<jdoc:include type="modules" name="homeblogSM" style="none" />
						</div>

					<?php } ?>
				<?php }else if($this->countModules('agenda') && $view == "category" && $layout == "blog"){ ?>
				<div class="span1"></div>
				<div class="span10">
					<jdoc:include type="modules" name="agenda" style="xhtml" />
				</div>
				<div class="span1"></div>
				<?php }else{ ?>
				<div class="span12">
					<?php if ($session->get('logueado') || $view == "recuperarcontrasena") { ?>
						<jdoc:include type="message" />
						<jdoc:include type="component" />
					<?php }else{ ?>
					    <!--<div class="alert alert-error">
					    Lo sentimos, debes iniciar sesión para ver esta información
					    </div>-->
					    <div class="limitado">
						    <jdoc:include type="message" />
							<jdoc:include type="component" />
						</div>
					<?php } ?>
					<?php if($view == "item" && $session->get('logueado')){ ?>
					<jdoc:include type="modules" name="blogDestacados" style="xhtml" />
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="span12">
					<jdoc:include type="modules" name="footerSM" style="none" />
				</div> 
			</div>
		</div>
	</div>
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>


<?php if($session->get('logueado')){ ?>
<script type="text/javascript">
	var j= jQuery.noConflict();
	j(window).load(function() {
		j.ajax({
			type: "GET",
			url: "index.php?option=com_functions&task=saveLog",
			data: { 
				cedula: <?php echo $session->get('cedula');?>,
				vista: '<?php echo $doc->getTitle();?>',
			},
			success: function( response ) {
				if( response ){
					//alert("OK");
				};
			}
		});
	});
</script>
<?php } ?>


<?php } ?>