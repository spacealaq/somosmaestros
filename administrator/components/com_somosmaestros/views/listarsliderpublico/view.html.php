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
class SomosmaestrosViewListarsliderpublico extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        
        

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        SomosmaestrosHelper::addSubmenu('listarsliderpublico');

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

        JToolBarHelper::title(JText::_('COM_SOMOSMAESTROS_TITLE_LISTARSLIDERPUBLICO'), 'listarsliderpublico.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/listar_slider_publico';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('listar_slider_publico.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('listar_slider_publico.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('listarsliderpublico.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('listarsliderpublico.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'listarsliderpublico.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('listarsliderpublico.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('listarsliderpublico.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'listarsliderpublico.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('listarsliderpublico.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_somosmaestros');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_somosmaestros&view=listarsliderpublico');

        $this->extra_sidebar = '';
        //
    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.titulo' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_TITULO'),
		'a.delegacion' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_DELEGACION'),
		'a.tipo_institucion' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_TIPO_INSTITUCION'),
		'a.segmento' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_SEGMENTO'),
		'a.nivel' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_NIVEL'),
		'a.ciudad' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_CIUDAD'),
		'a.area' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_AREA'),
		'a.rol' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_ROL'),
		'a.proyecto' => JText::_('COM_SOMOSMAESTROS_SLIDERSINTERNOS_PROYECTO'),
		);
	}

}
