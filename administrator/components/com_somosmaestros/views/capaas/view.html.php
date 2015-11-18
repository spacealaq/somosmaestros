<?php

/**
 * @version     1.0.0
 * @package     com_somosmaestros
 * @copyright   Copyright (C) 2015. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Daniel Gustavo Álvarez Gaitán <info@danielalvarez.com.co> - http://danielalvarez.com.co
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Somosmaestros.
 */
class SomosmaestrosViewCapaas extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        SomosmaestrosHelper::addSubmenu('capaas');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/somosmaestros.php';

        $state = $this->get('State');
        $canDo = SomosmaestrosHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_SOMOSMAESTROS_TITLE_CAPAAS'), 'capaas.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/capaa';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('capaa.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('capaa.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('capaas.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('capaas.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'capaas.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('capaas.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('capaas.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'capaas.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('capaas.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_somosmaestros');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_somosmaestros&view=capaas');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

		//Filter for the field tipo
		$select_label = JText::sprintf('COM_SOMOSMAESTROS_FILTER_SELECT_LABEL', 'Tipo');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "1";
		$options[0]->text = "Formación";
		$options[1] = new stdClass();
		$options[1]->value = "2";
		$options[1]->text = "Blog";
		$options[2] = new stdClass();
		$options[2]->value = "3";
		$options[2]->text = "Perfil";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_tipo',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.tipo'), true)
		);

			//Filter for the field fecha_inicio
		$this->extra_sidebar .= '<div class="other-filters">';
			$this->extra_sidebar .= '<small><label for="filter_from_fecha_inicio">'. JText::sprintf('COM_SOMOSMAESTROS_FROM_FILTER', 'Fecha Inicio') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.fecha_inicio.from'), 'filter_from_fecha_inicio', 'filter_from_fecha_inicio', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange' => 'this.form.submit();'));
			$this->extra_sidebar .= '<small><label for="filter_to_fecha_inicio">'. JText::sprintf('COM_SOMOSMAESTROS_TO_FILTER', 'Fecha Inicio') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.fecha_inicio.to'), 'filter_to_fecha_inicio', 'filter_to_fecha_inicio', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange'=> 'this.form.submit();'));
		$this->extra_sidebar .= '</div>';
			$this->extra_sidebar .= '<hr class="hr-condensed">';

			//Filter for the field fecha_fin
		$this->extra_sidebar .= '<div class="other-filters">';
			$this->extra_sidebar .= '<small><label for="filter_from_fecha_fin">'. JText::sprintf('COM_SOMOSMAESTROS_FROM_FILTER', 'Fecha Fin') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.fecha_fin.from'), 'filter_from_fecha_fin', 'filter_from_fecha_fin', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange' => 'this.form.submit();'));
			$this->extra_sidebar .= '<small><label for="filter_to_fecha_fin">'. JText::sprintf('COM_SOMOSMAESTROS_TO_FILTER', 'Fecha Fin') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.fecha_fin.to'), 'filter_to_fecha_fin', 'filter_to_fecha_fin', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange'=> 'this.form.submit();'));
		$this->extra_sidebar .= '</div>';
			$this->extra_sidebar .= '<hr class="hr-condensed">';

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.tipo' => JText::_('COM_SOMOSMAESTROS_CAPAAS_TIPO'),
		'a.fecha_inicio' => JText::_('COM_SOMOSMAESTROS_CAPAAS_FECHA_INICIO'),
		'a.fecha_fin' => JText::_('COM_SOMOSMAESTROS_CAPAAS_FECHA_FIN'),
		'a.ciudad' => JText::_('COM_SOMOSMAESTROS_CAPAAS_CIUDAD'),
		'a.puntos' => JText::_('COM_SOMOSMAESTROS_CAPAAS_PUNTOS'),
		'a.idtipopuntos' => JText::_('COM_SOMOSMAESTROS_CAPAAS_IDTIPOPUNTOS'),
		'a.nombre' => JText::_('COM_SOMOSMAESTROS_CAPAAS_NOMBRE'),
		);
	}

}
