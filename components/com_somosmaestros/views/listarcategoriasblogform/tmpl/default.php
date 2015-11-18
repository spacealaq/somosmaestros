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
            jQuery('#form-listarcategoriasblog').submit(function(event) {
                
            });

            
        });
    } else {
        jQuery(document).ready(function() {
            jQuery('#form-listarcategoriasblog').submit(function(event) {
                
            });

            
        });
    }
</script>

<div class="listarcategoriasblog-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-listarcategoriasblog" action="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=listarcategoriasblog.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
        
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=listarcategoriasblogform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_somosmaestros" />
        <input type="hidden" name="task" value="listarcategoriasblogform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
