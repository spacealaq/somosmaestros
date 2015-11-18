<?php defined('_JEXEC') or die;

$app    = JFactory::getApplication();
$pathway = $app->getPathway();
$pathway->addItem($this->item->titulo);

$session =& JFactory::getSession();
$cc = $session->get('cedula');
//$cc = '2024494634';

$doc = JFactory::getDocument();
$doc->setTitle($this->item->titulo);
/*
// Get a db connection.
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('id')));
$query->from($db->quoteName('#__somosmaestros_asistentes_agenda'));
$query->where($db->quoteName('agenda') . ' = '. $this->item->id. ' AND '.$db->quoteName('cedula').' = '.$cc);
 
// Reset the query using our newly populated query object.
$db->setQuery($query);
 
// Load the results as a list of stdClass objects (see later for more options on retrieving data).
$results = $db->loadObjectList();

$aparece = sizeof($results);

//echo $aparece;
*/

?>
<div class="row">
	<div class="offset2 span8">
		<h1>
			<div class="row">
				<div id="redes" class="span8">
					<span class='st_facebook_large' displayText='Facebook'></span>
					<span class='st_twitter_large' displayText='Tweet'></span>
					<span class='st_email_large' displayText='Email'></span>
					<a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a><br/>
				</div>
			</div>
		</h1>
		<div class="row">
			<div class="textoFull_blog span8">
				<div class="span8">
					<h2 class="tituloAgendaInterno"><?php echo $this->item->titulo; ?></h2>
					<!--<div id="puestosDisponibles">Puestos disponibles: <span><?php echo ((int)$this->item->disponibilidad - (int)$this->item->asistentes); ?></span> de <?php echo (int)$this->item->disponibilidad; ?></div>-->
				</div>
				<div class="span2">
					<?php 
	/*
					if ( (int)$this->item->asistentes < (int)$this->item->disponibilidad && $aparece == 0){ ?>

						<div class="botonAsistir btn btn-primary btn-large pull-right"><i class="fa fa-check-circle"></i> Asistiré</div>
					<?php }elseif ($aparece > 0) { ?>
						<div class="alert alert-success">
							Asistencia confirmada <i class="fa fa-check-circle"></i>
						</div>
					<?php } */?>
					
				</div>
			</div>
		</div>
		
		<img class="imagenFull" src="<?php echo $this->item->imagen_grande; ?>">
		<div class="textoAgendaInterno">
			<?php 
			echo $this->item->contenido;
			 echo '<h5>Fuente: <a href="'.$this->item->fuente.'" target="_blank">'.$this->item->fuente.'</a></h5>';
			 ?>
		</div>
		

	</div>
</div>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "0a5fbb5b-480e-4963-a198-8a1c87113b4a", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

<script type="text/javascript">

jQuery('.botonAsistir').click(function(){
	if(confirm('¿Realmente deseas asistir a este evento?')){
		jQuery.ajax({
			type: "GET",
			url: "index.php?option=com_functions&task=asistirAgenda",
			data: { 
				cedula: '<?php echo $cc; ?>',
				agenda: '<?php echo $this->item->id; ?>',
			},
			success: function( response ) {
				if( response ){
					alert("Has confirmado tu asistencia correctamente");
					location.reload();
				};
			}
		});
	}
});
</script>


