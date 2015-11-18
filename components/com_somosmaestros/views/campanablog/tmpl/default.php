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


?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_CAMPANABLOG_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_CAMPANABLOG_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_CAMPANABLOG_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_CAMPANABLOG_CEDULA'); ?></th>
			<td><?php echo $this->item->cedula; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_CAMPANABLOG_BLOG'); ?></th>
			<td><?php echo $this->item->blog; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_CAMPANABLOG_FECHA'); ?></th>
			<td><?php echo $this->item->fecha; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_CAMPANABLOG_CAMPANA'); ?></th>
			<td><?php echo $this->item->campana; ?></td>
</tr>

        </table>
    </div>
    
    <?php
else:
    echo JText::_('COM_SOMOSMAESTROS_ITEM_NOT_LOADED');
endif;
?>
