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
            jQuery('#form-comentarioblog').submit(function(event) {
                
            });

            
			jQuery('input:hidden.blog').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('bloghidden')){
					jQuery('#jform_blog option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_blog").trigger("liszt:updated");
        });
    } else {
        jQuery(document).ready(function() {
            jQuery('#form-comentarioblog').submit(function(event) {
                
            });

            
			jQuery('input:hidden.blog').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('bloghidden')){
					jQuery('#jform_blog option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_blog").trigger("liszt:updated");
        });
    }
</script>

<div class="comentarioblog-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-comentarioblog" action="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=comentarioblog.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
        
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
		<div class="control-label"><?php echo $this->form->getLabel('comentario'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('comentario'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('cedula'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('cedula'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('blog'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('blog'); ?></div>
	</div>
	<?php foreach((array)$this->item->blog as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="blog" name="jform[bloghidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('nombre'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('nombre'); ?></div>
	</div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=comentarioblogform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_somosmaestros" />
        <input type="hidden" name="task" value="comentarioblogform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
