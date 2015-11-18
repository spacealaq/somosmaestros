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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_somosmaestros');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_somosmaestros')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_VIDEO_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_VIDEO_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_VIDEO_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_VIDEO_URL'); ?></th>
			<td><?php echo $this->item->url; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_VIDEO_IMAGEN'); ?></th>
			<td><?php echo $this->item->imagen; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_VIDEO_TITULO'); ?></th>
			<td><?php echo $this->item->titulo; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=video.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_SOMOSMAESTROS_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_somosmaestros')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=video.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_SOMOSMAESTROS_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_SOMOSMAESTROS_ITEM_NOT_LOADED');
endif;
?>
