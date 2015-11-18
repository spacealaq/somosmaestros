<?php
/**
 * @version     1.0.0
 * @package     com_somosmaestros
 * @copyright   Copyright (C) 2015. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Daniel Gustavo Álvarez Gaitán <info@danielalvarez.com.co> - http://danielalvarez.com.co
 */
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_somosmaestros', JPATH_ADMINISTRATOR);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/components/com_somosmaestros/assets/js/form.js');


?>
</style>
<script type="text/javascript">
    if (jQuery === 'undefined') {
        document.addEventListener("DOMContentLoaded", function(event) { 
            jQuery('#form-sliderinterno').submit(function(event) {
                
            });

            
        });
    } else {
        jQuery(document).ready(function() {
            jQuery('#form-sliderinterno').submit(function(event) {
                
            });

            
        });
    }
</script>

<div class="sliderinterno-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-sliderinterno" action="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=sliderinterno.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
        
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('titulo'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('titulo'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('descripcion'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('descripcion'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('imagen_interno'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('imagen_interno'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('delegacion'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('delegacion'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('tipo_institucion'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('tipo_institucion'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('segmento'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('segmento'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('nivel'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('nivel'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('ciudad'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('ciudad'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('area'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('area'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('rol'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('rol'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('proyecto'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('proyecto'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('publico'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('publico'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('link'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('link'); ?></div>
	</div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=sliderinternoform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_somosmaestros" />
        <input type="hidden" name="task" value="sliderinternoform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
