<?php

/**
 * @version     1.0.0
 * @package     com_somosmaestros
 * @copyright   Copyright (C) 2015. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Daniel Gustavo Álvarez Gaitán <info@danielalvarez.com.co> - http://danielalvarez.com.co
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Somosmaestros records.
 */
class SomosmaestrosModelAgendas extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'titulo', 'a.titulo',
                'contenido', 'a.contenido',
                'imagen_grande', 'a.imagen_grande',
                'imagen_pequena', 'a.imagen_pequena',
                'categoria', 'a.categoria',
                'publico', 'a.publico',
                'destacado', 'a.destacado',
                'delegacion', 'a.delegacion',
                'tipo_institucion', 'a.tipo_institucion',
                'segmento', 'a.segmento',
                'nivel', 'a.nivel',
                'ciudad', 'a.ciudad',
                'area', 'a.area',
                'rol', 'a.rol',
                'proyecto', 'a.proyecto',
                'asistentes', 'a.asistentes',
                'disponibilidad', 'a.disponibilidad',
                'fuente', 'a.fuente',
                'preview', 'a.preview',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering categoria
		$this->setState('filter.categoria', $app->getUserStateFromRequest($this->context.'.filter.categoria', 'filter_categoria', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_somosmaestros');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.titulo', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__somosmaestros_agenda` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Join over the foreign key 'categoria'
		$query->select('#__somosmaestros_categorias_agenda_1879791.categoria AS categoriasagenda_categoria_1879791');
		$query->join('LEFT', '#__somosmaestros_categorias_agenda AS #__somosmaestros_categorias_agenda_1879791 ON #__somosmaestros_categorias_agenda_1879791.id = a.categoria');

        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.titulo LIKE '.$search.'  OR  a.categoria LIKE '.$search.'  OR  a.publico LIKE '.$search.'  OR  a.destacado LIKE '.$search.'  OR  a.delegacion LIKE '.$search.'  OR  a.tipo_institucion LIKE '.$search.'  OR  a.segmento LIKE '.$search.'  OR  a.nivel LIKE '.$search.'  OR  a.ciudad LIKE '.$search.'  OR  a.area LIKE '.$search.'  OR  a.rol LIKE '.$search.'  OR  a.proyecto LIKE '.$search.'  OR  a.asistentes LIKE '.$search.' )');
            }
        }

        

		//Filtering categoria
		$filter_categoria = $this->state->get("filter.categoria");
		if ($filter_categoria) {
			$query->where("a.categoria = '".$db->escape($filter_categoria)."'");
		}


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
		foreach ($items as $oneItem) {

			if (isset($oneItem->categoria)) {
				$values = explode(',', $oneItem->categoria);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('categoria'))
							->from('`#__somosmaestros_categorias_agenda`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->categoria;
					}
				}

			$oneItem->categoria = !empty($textValue) ? implode(', ', $textValue) : $oneItem->categoria;

			}
		}
        return $items;
    }

}
