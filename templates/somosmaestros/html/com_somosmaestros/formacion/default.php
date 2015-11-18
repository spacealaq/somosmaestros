<?php defined('_JEXEC') or die; 

$app    = JFactory::getApplication();
$pathway = $app->getPathway();
$pathway->addItem($this->item->titulo);

$session =& JFactory::getSession();
$cc = $session->get('cedula');
$correo = $session->get('correo');
//$cc = '2024494634';

$doc = JFactory::getDocument();
$doc->setTitle($this->item->titulo);

// Get a db connection.
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('id')));
$query->from($db->quoteName('#__somosmaestros_asistentes_formacion'));
$query->where($db->quoteName('formacion') . ' = '. $this->item->id. ' AND '.$db->quoteName('cedula').' = '.$cc);
 
// Reset the query using our newly populated query object.
$db->setQuery($query);
 
// Load the results as a list of stdClass objects (see later for more options on retrieving data).
$results = $db->loadObjectList();

$aparece = sizeof($results);

//echo $aparece;

$doc->addScript('templates/somosmaestros/js/template.js');

$doc->addStyleSheet('templates/somosmaestros/css/template.css');


?>
<div class="row">
    <div class="span2">
        <a id="volverInterno" class="btn" href="javascript:history.back()"><i class="icon-chevron-left"></i> Volver</a>
    </div>
	<div class="span8">
		<h1><?php echo $this->item->titulo; ?></h1>
		<div id="puestosDisponibles">Puestos disponibles: <span><?php echo ((int)$this->item->disponibilidad - (int)$this->item->asistentes); ?></span> de <?php echo (int)$this->item->disponibilidad; ?></div>

		<img id="img_formacion" src="<?php echo $this->item->imagen_grande; ?>">
		<div class="textoFull_blog">
			<?php 
			 echo $this->item->contenido; 
			 echo '<h5>Fuente: <a href="'.$this->item->fuente.'" target="_blank">'.$this->item->fuente.'</a></h5>';
			?>
		</div>
	</div>
	<div class="span2">
		<?php 

		if ( (int)$this->item->asistentes < (int)$this->item->disponibilidad && $aparece == 0){ ?>

			<div class="botonAsistir btn btn-primary btn-large pull-right"><i class="fa fa-check-circle"></i> Asistiré</div>
		<?php }elseif ($aparece > 0) { ?>
			<div class="alert alert-success">
				Asistencia confirmada <i class="fa fa-check-circle"></i>
			</div>
		<?php } ?>
		
	</div>
</div>


<script type="text/javascript">
jQuery('.botonAsistir').click(function(){
	if(confirm('¿Realmente deseas asistir a este evento?')){
		jQuery.ajax({
			type: "GET",
			url: "index.php?option=com_functions&task=asistirFormacion",
			data: { 
				cedula: '<?php echo $cc; ?>',
				formacion: '<?php echo $this->item->id; ?>',
				correo: '<?php echo $correo; ?>'
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


