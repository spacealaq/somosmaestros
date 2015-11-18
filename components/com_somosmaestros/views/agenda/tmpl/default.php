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
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_TITULO'); ?></th>
			<td><?php echo $this->item->titulo; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_CONTENIDO'); ?></th>
			<td><?php echo $this->item->contenido; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_IMAGEN_GRANDE'); ?></th>
			<td><?php echo $this->item->imagen_grande; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_IMAGEN_PEQUENA'); ?></th>
			<td><?php echo $this->item->imagen_pequena; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_CATEGORIA'); ?></th>
			<td><?php echo $this->item->categoria; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_PUBLICO'); ?></th>
			<td><?php echo $this->item->publico; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_DESTACADO'); ?></th>
			<td><?php echo $this->item->destacado; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_DELEGACION'); ?></th>
			<td><?php echo $this->item->delegacion; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_TIPO_INSTITUCION'); ?></th>
			<td><?php echo $this->item->tipo_institucion; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_SEGMENTO'); ?></th>
			<td><?php echo $this->item->segmento; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_NIVEL'); ?></th>
			<td><?php echo $this->item->nivel; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_CIUDAD'); ?></th>
			<td><?php echo $this->item->ciudad; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_AREA'); ?></th>
			<td><?php echo $this->item->area; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_ROL'); ?></th>
			<td><?php echo $this->item->rol; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_PROYECTO'); ?></th>
			<td><?php echo $this->item->proyecto; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_ASISTENTES'); ?></th>
			<td><?php echo $this->item->asistentes; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_DISPONIBILIDAD'); ?></th>
			<td><?php echo $this->item->disponibilidad; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_FUENTE'); ?></th>
			<td><?php echo $this->item->fuente; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_SOMOSMAESTROS_FORM_LBL_AGENDA_PREVIEW'); ?></th>
			<td><?php echo $this->item->preview; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=agenda.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_SOMOSMAESTROS_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_somosmaestros')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_somosmaestros&task=agenda.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_SOMOSMAESTROS_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_SOMOSMAESTROS_ITEM_NOT_LOADED');
endif;
?>
