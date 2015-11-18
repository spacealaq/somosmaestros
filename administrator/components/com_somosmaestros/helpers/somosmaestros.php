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

/**
 * Somosmaestros helper.
 */
class SomosmaestrosHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_PREMIOS'),
			'index.php?option=com_somosmaestros&view=premios',
			$vName == 'premios'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CAPAAS'),
			'index.php?option=com_somosmaestros&view=capaas',
			$vName == 'capaas'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_TIPOINSTITUCIONESS'),
			'index.php?option=com_somosmaestros&view=tipoinstitucioness',
			$vName == 'tipoinstitucioness'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_ARTICULOS'),
			'index.php?option=com_somosmaestros&view=articulos',
			$vName == 'articulos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CATEGORIASARTICULOS'),
			'index.php?option=com_somosmaestros&view=categoriasarticulos',
			$vName == 'categoriasarticulos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_BLOGS'),
			'index.php?option=com_somosmaestros&view=blogs',
			$vName == 'blogs'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CATEGORIASBLOG'),
			'index.php?option=com_somosmaestros&view=categoriasblog',
			$vName == 'categoriasblog'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_AGENDAS'),
			'index.php?option=com_somosmaestros&view=agendas',
			$vName == 'agendas'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CATEGORIASAGENDA'),
			'index.php?option=com_somosmaestros&view=categoriasagenda',
			$vName == 'categoriasagenda'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_FORMACIONS'),
			'index.php?option=com_somosmaestros&view=formacions',
			$vName == 'formacions'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_SLIDERPUBLICOS'),
			'index.php?option=com_somosmaestros&view=sliderpublicos',
			$vName == 'sliderpublicos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_SLIDERSINTERNOS'),
			'index.php?option=com_somosmaestros&view=slidersinternos',
			$vName == 'slidersinternos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_ASISTENTESAGENDAS'),
			'index.php?option=com_somosmaestros&view=asistentesagendas',
			$vName == 'asistentesagendas'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_ASISTENTESFORMACIONS'),
			'index.php?option=com_somosmaestros&view=asistentesformacions',
			$vName == 'asistentesformacions'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_COMENTARIOSBLOGS'),
			'index.php?option=com_somosmaestros&view=comentariosblogs',
			$vName == 'comentariosblogs'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_VIDEOS'),
			'index.php?option=com_somosmaestros&view=videos',
			$vName == 'videos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_SMPERSONAS'),
			'index.php?option=com_somosmaestros&view=smpersonas',
			$vName == 'smpersonas'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_SMREGISTROS'),
			'index.php?option=com_somosmaestros&view=smregistros',
			$vName == 'smregistros'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_SMACTUALIZACIONES'),
			'index.php?option=com_somosmaestros&view=smactualizaciones',
			$vName == 'smactualizaciones'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_LOGS'),
			'index.php?option=com_somosmaestros&view=logs',
			$vName == 'logs'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CAMPANABLOGS'),
			'index.php?option=com_somosmaestros&view=campanablogs',
			$vName == 'campanablogs'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CAMPANAPERFILS'),
			'index.php?option=com_somosmaestros&view=campanaperfils',
			$vName == 'campanaperfils'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_SMBRUJULAS'),
			'index.php?option=com_somosmaestros&view=smbrujulas',
			$vName == 'smbrujulas'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_MIPERFILS'),
			'index.php?option=com_somosmaestros&view=miperfils',
			$vName == 'miperfils'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_RECUPERARCONTRASENAS'),
			'index.php?option=com_somosmaestros&view=recuperarcontrasenas',
			$vName == 'recuperarcontrasenas'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_REGISTRARS'),
			'index.php?option=com_somosmaestros&view=registrars',
			$vName == 'registrars'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_ADMINISTRADORES'),
			'index.php?option=com_somosmaestros&view=administradores',
			$vName == 'administradores'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARCAMPAA'),
			'index.php?option=com_somosmaestros&view=crearcampaa',
			$vName == 'crearcampaa'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARARTICULOS'),
			'index.php?option=com_somosmaestros&view=creararticulos',
			$vName == 'creararticulos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARCATEGORIAARTICULOS'),
			'index.php?option=com_somosmaestros&view=crearcategoriaarticulos',
			$vName == 'crearcategoriaarticulos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARBLOGS'),
			'index.php?option=com_somosmaestros&view=crearblogs',
			$vName == 'crearblogs'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARCATEGORIABLOGS'),
			'index.php?option=com_somosmaestros&view=crearcategoriablogs',
			$vName == 'crearcategoriablogs'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARFORMACION'),
			'index.php?option=com_somosmaestros&view=crearformacion',
			$vName == 'crearformacion'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARAGENDA'),
			'index.php?option=com_somosmaestros&view=crearagenda',
			$vName == 'crearagenda'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARCATEGORIAAGENDA'),
			'index.php?option=com_somosmaestros&view=crearcategoriaagenda',
			$vName == 'crearcategoriaagenda'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARSLIDERPUBLICO'),
			'index.php?option=com_somosmaestros&view=crearsliderpublico',
			$vName == 'crearsliderpublico'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARSLIDERINTERNO'),
			'index.php?option=com_somosmaestros&view=crearsliderinterno',
			$vName == 'crearsliderinterno'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CREARPREMIOS'),
			'index.php?option=com_somosmaestros&view=crearpremios',
			$vName == 'crearpremios'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_FUNCIONARIOS'),
			'index.php?option=com_somosmaestros&view=funcionarios',
			$vName == 'funcionarios'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_EVENTOS'),
			'index.php?option=com_somosmaestros&view=eventos',
			$vName == 'eventos'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SOMOSMAESTROS_TITLE_CAMPANAS'),
			'index.php?option=com_somosmaestros&view=campanas',
			$vName == 'campanas'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_somosmaestros';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
