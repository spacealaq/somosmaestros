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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_somosmaestros/assets/css/somosmaestros.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
	js('input:hidden.categoria').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('categoriahidden')){
			js('#jform_categoria option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_categoria").trigger("liszt:updated");
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'articulo.cancel') {
            Joomla.submitform(task, document.getElementById('articulo-form'));
        }
        else {
            
            if (task != 'articulo.cancel' && document.formvalidator.isValid(document.id('articulo-form'))) {
                
                Joomla.submitform(task, document.getElementById('articulo-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_somosmaestros&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="articulo-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SOMOSMAESTROS_TITLE_ARTICULO', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('titulo'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('titulo'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('contenido'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('contenido'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('imagen_grande'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('imagen_grande'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('imagen_pequena'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('imagen_pequena'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('categoria'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('categoria'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->categoria as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="categoria" name="jform[categoriahidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('destacado'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('destacado'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('publico'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('publico'); ?></div>
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
				<div class="control-label"><?php echo $this->form->getLabel('fuente'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('fuente'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('preview'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('preview'); ?></div>
			</div>


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>