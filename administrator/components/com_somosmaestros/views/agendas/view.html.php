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
class SomosmaestrosViewAgendas extends JViewLegacy {

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

        SomosmaestrosHelper::addSubmenu('agendas');

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

        JToolBarHelper::title(JText::_('COM_SOMOSMAESTROS_TITLE_AGENDAS'), 'agendas.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/agenda';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('agenda.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('agenda.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('agendas.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('agendas.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'agendas.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('agendas.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('agendas.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'agendas.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('agendas.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_somosmaestros');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_somosmaestros&view=agendas');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);
                                                
        //Filter for the field categoria;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_somosmaestros.agenda', 'agenda');

        $field = $form->getField('categoria');

        $query = $form->getFieldAttribute('filter_categoria','query');
        $translate = $form->getFieldAttribute('filter_categoria','translate');
        $key = $form->getFieldAttribute('filter_categoria','key_field');
        $value = $form->getFieldAttribute('filter_categoria','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Categoria',
            'filter_categoria',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.categoria')),
            true
        );
    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.titulo' => JText::_('COM_SOMOSMAESTROS_AGENDAS_TITULO'),
		'a.categoria' => JText::_('COM_SOMOSMAESTROS_AGENDAS_CATEGORIA'),
		'a.publico' => JText::_('COM_SOMOSMAESTROS_AGENDAS_PUBLICO'),
		'a.destacado' => JText::_('COM_SOMOSMAESTROS_AGENDAS_DESTACADO'),
		'a.delegacion' => JText::_('COM_SOMOSMAESTROS_AGENDAS_DELEGACION'),
		'a.tipo_institucion' => JText::_('COM_SOMOSMAESTROS_AGENDAS_TIPO_INSTITUCION'),
		'a.segmento' => JText::_('COM_SOMOSMAESTROS_AGENDAS_SEGMENTO'),
		'a.nivel' => JText::_('COM_SOMOSMAESTROS_AGENDAS_NIVEL'),
		'a.ciudad' => JText::_('COM_SOMOSMAESTROS_AGENDAS_CIUDAD'),
		'a.area' => JText::_('COM_SOMOSMAESTROS_AGENDAS_AREA'),
		'a.rol' => JText::_('COM_SOMOSMAESTROS_AGENDAS_ROL'),
		'a.proyecto' => JText::_('COM_SOMOSMAESTROS_AGENDAS_PROYECTO'),
		'a.asistentes' => JText::_('COM_SOMOSMAESTROS_AGENDAS_ASISTENTES'),
		'a.disponibilidad' => JText::_('COM_SOMOSMAESTROS_AGENDAS_DISPONIBILIDAD'),
		'a.fuente' => JText::_('COM_SOMOSMAESTROS_AGENDAS_FUENTE'),
		);
	}

}
