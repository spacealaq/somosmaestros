<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Search.content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_somosmaestros/router.php';

/**
 * Content search plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  Search.content
 * @since       1.6
 */
class PlgSearchSomosmaestros extends JPlugin {

    /**
     * Determine areas searchable by this plugin.
     *
     * @return  array  An array of search areas.
     *
     * @since   1.6
     */
    public function onContentSearchAreas() {
        static $areas = array(
            'somosmaestros' => 'Somosmaestros'
        );

        return $areas;
    }

    /**
     * Search content (articles).
     * The SQL must return the following fields that are used in a common display
     * routine: href, title, section, created, text, browsernav.
     *
     * @param   string  $text      Target search string.
     * @param   string  $phrase    Matching option (possible values: exact|any|all).  Default is "any".
     * @param   string  $ordering  Ordering option (possible values: newest|oldest|popular|alpha|category).  Default is "newest".
     * @param   mixed   $areas     An array if the search it to be restricted to areas or null to search all areas.
     *
     * @return  array  Search results.
     *
     * @since   1.6
     */
    public function onContentSearch($text, $phrase = '', $ordering = '', $areas = null) {
        $db = JFactory::getDbo();

        if (is_array($areas)) {
            if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
                return array();
            }
        }

        $limit = $this->params->def('search_limit', 50);

        $text = trim($text);

        if ($text == '') {
            return array();
        }

        $rows = array();

        
//Search Premios.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.premio LIKE ' . $text;
$wheres2[] = 'a.puntos LIKE ' . $text;
$wheres2[] = 'a.imagen LIKE ' . $text;
$wheres2[] = 'a.destacado LIKE ' . $text;
$wheres2[] = 'a.cantidad LIKE ' . $text;
$wheres2[] = 'a.rol LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.premio LIKE ' . $word;
$wheres2[] = 'a.puntos LIKE ' . $word;
$wheres2[] = 'a.imagen LIKE ' . $word;
$wheres2[] = 'a.destacado LIKE ' . $word;
$wheres2[] = 'a.cantidad LIKE ' . $word;
$wheres2[] = 'a.rol LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'premio AS title',
                        '"" AS created',
                        'premio AS text',
                        '"Premio" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_premios AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=premio&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Tipo Instituciones.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.tipo LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.tipo LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'tipo AS title',
                        '"" AS created',
                        'tipo AS text',
                        '"Tipo Institucion" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_tipo_institucion AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=tipoinstituciones&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Articulos.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.titulo LIKE ' . $text;
$wheres2[] = 'somosmaestros_categorias_articulos.categoria LIKE ' . $text;
$wheres2[] = 'a.destacado LIKE ' . $text;
$wheres2[] = 'a.publico LIKE ' . $text;
$wheres2[] = 'a.delegacion LIKE ' . $text;
$wheres2[] = 'a.tipo_institucion LIKE ' . $text;
$wheres2[] = 'a.segmento LIKE ' . $text;
$wheres2[] = 'a.nivel LIKE ' . $text;
$wheres2[] = 'a.ciudad LIKE ' . $text;
$wheres2[] = 'a.area LIKE ' . $text;
$wheres2[] = 'a.rol LIKE ' . $text;
$wheres2[] = 'a.proyecto LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.titulo LIKE ' . $word;
$wheres2[] = 'somosmaestros_categorias_articulos.categoria LIKE ' . $word;
$wheres2[] = 'a.destacado LIKE ' . $word;
$wheres2[] = 'a.publico LIKE ' . $word;
$wheres2[] = 'a.delegacion LIKE ' . $word;
$wheres2[] = 'a.tipo_institucion LIKE ' . $word;
$wheres2[] = 'a.segmento LIKE ' . $word;
$wheres2[] = 'a.nivel LIKE ' . $word;
$wheres2[] = 'a.ciudad LIKE ' . $word;
$wheres2[] = 'a.area LIKE ' . $word;
$wheres2[] = 'a.rol LIKE ' . $word;
$wheres2[] = 'a.proyecto LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'titulo AS title',
                        '"" AS created',
                        'titulo AS text',
                        '"Articulo" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_articulos AS a')
            ->innerJoin('`#__somosmaestros_categorias_articulos` AS somosmaestros_categorias_articulos ON somosmaestros_categorias_articulos.id = a.categoria')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=articulo&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Categorias Articulos.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.categoria LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.categoria LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'categoria AS title',
                        '"" AS created',
                        'categoria AS text',
                        '"Categoria Articulo" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_categorias_articulos AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=categoriaarticulo&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Blogs.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.titulo LIKE ' . $text;
$wheres2[] = 'somosmaestros_categorias_blog.categoria LIKE ' . $text;
$wheres2[] = 'a.destacado LIKE ' . $text;
$wheres2[] = 'a.publico LIKE ' . $text;
$wheres2[] = 'a.delegacion LIKE ' . $text;
$wheres2[] = 'a.tipo_institucion LIKE ' . $text;
$wheres2[] = 'a.segmento LIKE ' . $text;
$wheres2[] = 'a.nivel LIKE ' . $text;
$wheres2[] = 'a.ciudad LIKE ' . $text;
$wheres2[] = 'a.area LIKE ' . $text;
$wheres2[] = 'a.rol LIKE ' . $text;
$wheres2[] = 'a.proyecto LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.titulo LIKE ' . $word;
$wheres2[] = 'somosmaestros_categorias_blog.categoria LIKE ' . $word;
$wheres2[] = 'a.destacado LIKE ' . $word;
$wheres2[] = 'a.publico LIKE ' . $word;
$wheres2[] = 'a.delegacion LIKE ' . $word;
$wheres2[] = 'a.tipo_institucion LIKE ' . $word;
$wheres2[] = 'a.segmento LIKE ' . $word;
$wheres2[] = 'a.nivel LIKE ' . $word;
$wheres2[] = 'a.ciudad LIKE ' . $word;
$wheres2[] = 'a.area LIKE ' . $word;
$wheres2[] = 'a.rol LIKE ' . $word;
$wheres2[] = 'a.proyecto LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'titulo AS title',
                        '"" AS created',
                        'titulo AS text',
                        '"Blog" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_blogs AS a')
            ->innerJoin('`#__somosmaestros_categorias_blog` AS somosmaestros_categorias_blog ON somosmaestros_categorias_blog.id = a.categoria')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=blog&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Categorias Blog.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.categoria LIKE ' . $text;
$wheres2[] = 'a.descripcion LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.categoria LIKE ' . $word;
$wheres2[] = 'a.descripcion LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'categoria AS title',
                        '"" AS created',
                        'categoria AS text',
                        '"Categoria Blog" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_categorias_blog AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=categoriablog&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Agenda.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.titulo LIKE ' . $text;
$wheres2[] = 'somosmaestros_categorias_agenda.categoria LIKE ' . $text;
$wheres2[] = 'a.publico LIKE ' . $text;
$wheres2[] = 'a.destacado LIKE ' . $text;
$wheres2[] = 'a.delegacion LIKE ' . $text;
$wheres2[] = 'a.tipo_institucion LIKE ' . $text;
$wheres2[] = 'a.segmento LIKE ' . $text;
$wheres2[] = 'a.nivel LIKE ' . $text;
$wheres2[] = 'a.ciudad LIKE ' . $text;
$wheres2[] = 'a.area LIKE ' . $text;
$wheres2[] = 'a.rol LIKE ' . $text;
$wheres2[] = 'a.proyecto LIKE ' . $text;
$wheres2[] = 'a.asistentes LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.titulo LIKE ' . $word;
$wheres2[] = 'somosmaestros_categorias_agenda.categoria LIKE ' . $word;
$wheres2[] = 'a.publico LIKE ' . $word;
$wheres2[] = 'a.destacado LIKE ' . $word;
$wheres2[] = 'a.delegacion LIKE ' . $word;
$wheres2[] = 'a.tipo_institucion LIKE ' . $word;
$wheres2[] = 'a.segmento LIKE ' . $word;
$wheres2[] = 'a.nivel LIKE ' . $word;
$wheres2[] = 'a.ciudad LIKE ' . $word;
$wheres2[] = 'a.area LIKE ' . $word;
$wheres2[] = 'a.rol LIKE ' . $word;
$wheres2[] = 'a.proyecto LIKE ' . $word;
$wheres2[] = 'a.asistentes LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'titulo AS title',
                        '"" AS created',
                        'titulo AS text',
                        '"Agenda" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_agenda AS a')
            ->innerJoin('`#__somosmaestros_categorias_agenda` AS somosmaestros_categorias_agenda ON somosmaestros_categorias_agenda.id = a.categoria')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=agenda&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Categorias Agenda.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.categoria LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.categoria LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'categoria AS title',
                        '"" AS created',
                        'categoria AS text',
                        '"Categoria Agenda" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_categorias_agenda AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=categoriaagenda&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Formacion.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.titulo LIKE ' . $text;
$wheres2[] = 'a.destacado LIKE ' . $text;
$wheres2[] = 'a.delegacion LIKE ' . $text;
$wheres2[] = 'a.tipo_institucion LIKE ' . $text;
$wheres2[] = 'a.segmento LIKE ' . $text;
$wheres2[] = 'a.nivel LIKE ' . $text;
$wheres2[] = 'a.ciudad LIKE ' . $text;
$wheres2[] = 'a.area LIKE ' . $text;
$wheres2[] = 'a.rol LIKE ' . $text;
$wheres2[] = 'a.proyecto LIKE ' . $text;
$wheres2[] = 'a.publico LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.titulo LIKE ' . $word;
$wheres2[] = 'a.destacado LIKE ' . $word;
$wheres2[] = 'a.delegacion LIKE ' . $word;
$wheres2[] = 'a.tipo_institucion LIKE ' . $word;
$wheres2[] = 'a.segmento LIKE ' . $word;
$wheres2[] = 'a.nivel LIKE ' . $word;
$wheres2[] = 'a.ciudad LIKE ' . $word;
$wheres2[] = 'a.area LIKE ' . $word;
$wheres2[] = 'a.rol LIKE ' . $word;
$wheres2[] = 'a.proyecto LIKE ' . $word;
$wheres2[] = 'a.publico LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'titulo AS title',
                        '"" AS created',
                        'titulo AS text',
                        '"Formacion" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_formacion AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=formacion&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Sliders Publicos.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.titulo LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.titulo LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'titulo AS title',
                        '"" AS created',
                        'titulo AS text',
                        '"Slider Publico" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_slider_publico AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=sliderpublico&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Sliders Internos.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.titulo LIKE ' . $text;
$wheres2[] = 'a.delegacion LIKE ' . $text;
$wheres2[] = 'a.tipo_institucion LIKE ' . $text;
$wheres2[] = 'a.segmento LIKE ' . $text;
$wheres2[] = 'a.nivel LIKE ' . $text;
$wheres2[] = 'a.ciudad LIKE ' . $text;
$wheres2[] = 'a.area LIKE ' . $text;
$wheres2[] = 'a.rol LIKE ' . $text;
$wheres2[] = 'a.proyecto LIKE ' . $text;
$wheres2[] = 'a.publico LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.titulo LIKE ' . $word;
$wheres2[] = 'a.delegacion LIKE ' . $word;
$wheres2[] = 'a.tipo_institucion LIKE ' . $word;
$wheres2[] = 'a.segmento LIKE ' . $word;
$wheres2[] = 'a.nivel LIKE ' . $word;
$wheres2[] = 'a.ciudad LIKE ' . $word;
$wheres2[] = 'a.area LIKE ' . $word;
$wheres2[] = 'a.rol LIKE ' . $word;
$wheres2[] = 'a.proyecto LIKE ' . $word;
$wheres2[] = 'a.publico LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'titulo AS title',
                        '"" AS created',
                        'titulo AS text',
                        '"Slider Interno" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_slider_interno AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=sliderinterno&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Asistentes Agendas.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.cedula LIKE ' . $text;
$wheres2[] = 'somosmaestros_agenda.titulo LIKE ' . $text;
$wheres2[] = 'a.fecha LIKE ' . $text;
$wheres2[] = 'a.asistio LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.cedula LIKE ' . $word;
$wheres2[] = 'somosmaestros_agenda.titulo LIKE ' . $word;
$wheres2[] = 'a.fecha LIKE ' . $word;
$wheres2[] = 'a.asistio LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'id AS title',
                        '"" AS created',
                        'id AS text',
                        '"Asistentes Agenda" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_asistentes_agenda AS a')
            ->innerJoin('`#__somosmaestros_agenda` AS somosmaestros_agenda ON somosmaestros_agenda.id = a.agenda')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=asistentesagenda&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Asistentes Formacion.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.cedula LIKE ' . $text;
$wheres2[] = 'somosmaestros_formacion.titulo LIKE ' . $text;
$wheres2[] = 'a.fecha LIKE ' . $text;
$wheres2[] = 'a.asistio LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.cedula LIKE ' . $word;
$wheres2[] = 'somosmaestros_formacion.titulo LIKE ' . $word;
$wheres2[] = 'a.fecha LIKE ' . $word;
$wheres2[] = 'a.asistio LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'id AS title',
                        '"" AS created',
                        'id AS text',
                        '"Asistentes Formacion" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_asistentes_formacion AS a')
            ->innerJoin('`#__somosmaestros_formacion` AS somosmaestros_formacion ON somosmaestros_formacion.id = a.formacion')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=asistentesformacion&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Comentarios Blogs.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.cedula LIKE ' . $text;
$wheres2[] = 'somosmaestros_blogs.titulo LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.cedula LIKE ' . $word;
$wheres2[] = 'somosmaestros_blogs.titulo LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'comentario AS title',
                        '"" AS created',
                        'comentario AS text',
                        '"Comentario Blog" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_comentarios_blog AS a')
            ->innerJoin('`#__somosmaestros_blogs` AS somosmaestros_blogs ON somosmaestros_blogs.id = a.blog')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=comentarioblog&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Sm Personas.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.nombre LIKE ' . $text;
$wheres2[] = 'a.usuario LIKE ' . $text;
$wheres2[] = 'a.perfil LIKE ' . $text;
$wheres2[] = 'a.password LIKE ' . $text;
$wheres2[] = 'a.delegacion LIKE ' . $text;
$wheres2[] = 'a.ciudad LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.nombre LIKE ' . $word;
$wheres2[] = 'a.usuario LIKE ' . $word;
$wheres2[] = 'a.perfil LIKE ' . $word;
$wheres2[] = 'a.password LIKE ' . $word;
$wheres2[] = 'a.delegacion LIKE ' . $word;
$wheres2[] = 'a.ciudad LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'nombre AS title',
                        '"" AS created',
                        'nombre AS text',
                        '"Sm Persona" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_sm_personas AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=smpersona&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Campana Blogs.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.cedula LIKE ' . $text;
$wheres2[] = 'somosmaestros_blogs.titulo LIKE ' . $text;
$wheres2[] = 'a.fecha LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.cedula LIKE ' . $word;
$wheres2[] = 'somosmaestros_blogs.titulo LIKE ' . $word;
$wheres2[] = 'a.fecha LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'campana AS title',
                        '"" AS created',
                        'campana AS text',
                        '"Campana Blog" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_campana_blog AS a')
            ->innerJoin('`#__somosmaestros_blogs` AS somosmaestros_blogs ON somosmaestros_blogs.id = a.blog')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=campanablog&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Campana Perfil.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.cedula LIKE ' . $text;
$wheres2[] = 'a.fecha LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.cedula LIKE ' . $word;
$wheres2[] = 'a.fecha LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'campana AS title',
                        '"" AS created',
                        'campana AS text',
                        '"Campana Perfil" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__somosmaestros_campana_perfil AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_somosmaestros&view=campanaperfil&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}

        return $rows;
    }

}
