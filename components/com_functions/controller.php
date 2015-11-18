<?php

/**
 * @version     1.0.0
 * @package     com_functions
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Daniel Gustavo Álvarez Gaitán <info@danielalvarez.com.co> - http://danielalvarez.com.co
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class FunctionsController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/functions.php';

        $view = JFactory::getApplication()->input->getCmd('view', '');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }
    public function obtenerCiudades(){
        require_once 'templates/somosmaestros/code/SMBrujula.php';
        $db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
        $departamento = $_GET['departamento'];
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('CiId','CiNombre')));
        $query->from($db->quoteName('ciudades'));
        $query->where($db->quoteName('CiDepartamento') . ' = '. $db->quote($departamento));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $ciudades = $db->loadObjectList();
        echo json_encode( $ciudades );
    }
    public function obtenerInstituciones(){
        $ciudad = $_GET['ciudad'];
        $localidades = $this->obtenerLocalidades($ciudad);
        $barrios_localidad = array();
        foreach ($localidades as $l) {
            array_push($barrios_localidad,$this->obtenerBarrios($l->LoId));
        }
        $instituciones = array();
        foreach ($barrios_localidad as $bl) {
            foreach ($bl as $bli) {
                foreach($this->obtenerInstitucionesBarrio($bli->BaId) as $if){
                    array_push($instituciones, $if);
                }
            }
        }
        
        echo json_encode($instituciones);
    }
    protected function obtenerLocalidades($ciudad){
        require_once 'templates/somosmaestros/code/SMBrujula.php';
        $db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('LoId','LoNombre')));
        $query->from($db->quoteName('localidades'));
        $query->where($db->quoteName('LoCiudad') . ' = '. $db->quote($ciudad));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $localidades = $db->loadObjectList();
        return $localidades;
    }
    protected function obtenerBarrios($localidad){
        require_once 'templates/somosmaestros/code/SMBrujula.php';
        $db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('BaId','BaNombre')));
        $query->from($db->quoteName('barrios'));
        $query->where($db->quoteName('BaLocalidad') . ' = '. $db->quote($localidad));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $barrios = $db->loadObjectList();
        return $barrios;
    }
    protected function obtenerInstitucionesBarrio($barrio){
        require_once 'templates/somosmaestros/code/SMBrujula.php';
        $db = JDatabaseDriver::getInstance( SMBrujula::getConexion() );
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('IeId','IeNombre')));
        $query->from($db->quoteName('institucioneseducativas'));
        $query->where($db->quoteName('IeBarrio') . ' = '. $db->quote($barrio));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $instituciones = $db->loadObjectList();
        return $instituciones;
    }
    public function obtenerPublicaciones(){
        $tipo = $_GET['tipo'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        if($tipo == '1'){
            $query = 'SELECT id, title FROM #__content WHERE catid = 19 AND state = 1';
        }elseif ($tipo == '2') {
            $query = 'SELECT id, title  FROM #__k2_items WHERE published = 1';
        }elseif ($tipo == '3') {
            $query = 'SELECT id, title FROM #__content WHERE (catid = 22 OR catid = 23 OR catid = 24) AND state = 1';
        }

        $db->setQuery($query);
        $results = $db->loadObjectList();
        echo json_encode($results);
    }

    /* VIDEO */

    public function guardarVideo(){
        $video = new stdClass();
        $video->state = 1; 
        $video->id=$_GET['id'];
        $video->titulo=$_GET["titulo"];  
        $video->url=$_GET["link"];        
        $video->imagen=$_GET['imagen'][0];     
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_video', $video, 'id');
        echo json_encode($result);
    }


    /* ARTÍCULO */

    public function crearArticulo(){
        $articulo = new stdClass();
        $articulo->state = 1;
        $articulo->titulo=$_POST["titulo"]; 
        $articulo->publico=$_POST["publico"];   
        $articulo->categoria=$_POST['categoria'];
        $articulo->preview=$_POST["preview"];   
        $articulo->fuente=$_POST["fuente"];   
        $articulo->contenido=$_POST["contenido"];      
        $articulo->imagen_grande=$_POST['imagen_grande'][0];
        $articulo->imagen_pequena=$_POST['imagen_pequeña'][0]; 
        $articulo->delegacion=implode(",",$_POST['delegacion']);
        $articulo->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $articulo->segmento=implode(",",$_POST['segmento']);
        $articulo->nivel=implode(",",$_POST['nivel']);
        $articulo->ciudad=implode(",",$_POST['ciudad']);
        $articulo->area=implode(",",$_POST['area']);
        $articulo->rol=implode(",",$_POST['rol']);
        $articulo->proyecto=implode(",",$_POST['proyecto']);      
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_articulos', $articulo);
        echo json_encode($result);
    }

    public function guardarArticulo(){
        $articulo = new stdClass();
        $articulo->state = 1; 
        $articulo->id=$_POST['id'];
        $articulo->titulo=$_POST["titulo"]; 
        $articulo->publico=$_POST["publico"];   
        $articulo->categoria=$_POST['categoria']; 
        $articulo->preview=$_POST["preview"];   
        $articulo->fuente=$_POST["fuente"];      
        $articulo->contenido=$_POST["contenido"];      
        $articulo->imagen_grande=$_POST['imagen_grande'][0];
        $articulo->imagen_pequena=$_POST['imagen_pequeña'][0];    
        $articulo->delegacion=implode(",",$_POST['delegacion']);
        $articulo->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $articulo->segmento=implode(",",$_POST['segmento']);
        $articulo->nivel=implode(",",$_POST['nivel']);
        $articulo->ciudad=implode(",",$_POST['ciudad']);
        $articulo->area=implode(",",$_POST['area']);
        $articulo->rol=implode(",",$_POST['rol']);
        $articulo->proyecto=implode(",",$_POST['proyecto']);      
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_articulos', $articulo, 'id');
        echo json_encode($result);
    }

    public function eliminarArticulo(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_articulos'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

    /* BLOG */

    public function crearBlog(){
        $blog = new stdClass();
        $blog->state = 1;
        $blog->titulo=$_POST["titulo"];  
        $blog->publico=$_POST["publico"];  
        $blog->categoria=$_POST['categoria'];
        $blog->preview=$_POST["preview"];   
        $blog->fuente=$_POST["fuente"];   
        $blog->contenido=$_POST["contenido"];      
        $blog->imagen_grande=$_POST['imagen_grande'][0];
        $blog->imagen_pequena=$_POST['imagen_pequeña'][0]; 
        $blog->delegacion=implode(",",$_POST['delegacion']);
        $blog->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $blog->segmento=implode(",",$_POST['segmento']);
        $blog->nivel=implode(",",$_POST['nivel']);
        $blog->ciudad=implode(",",$_POST['ciudad']);
        $blog->area=implode(",",$_POST['area']);
        $blog->rol=implode(",",$_POST['rol']);
        $blog->proyecto=implode(",",$_POST['proyecto']);      
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_blogs', $blog);
        echo json_encode($result);
    }

    public function guardarBlog(){
        $blog = new stdClass();
        $blog->state = 1; 
        $blog->id=$_POST['id'];
        $blog->titulo=$_POST["titulo"]; 
        $blog->publico=$_POST["publico"];  
        $blog->categoria=$_POST['categoria']; 
        $blog->preview=$_POST["preview"];   
        $blog->fuente=$_POST["fuente"];      
        $blog->contenido=$_POST["contenido"];      
        $blog->imagen_grande=$_POST['imagen_grande'][0];
        $blog->imagen_pequena=$_POST['imagen_pequeña'][0];    
        $blog->delegacion=implode(",",$_POST['delegacion']);
        $blog->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $blog->segmento=implode(",",$_POST['segmento']);
        $blog->nivel=implode(",",$_POST['nivel']);
        $blog->ciudad=implode(",",$_POST['ciudad']);
        $blog->area=implode(",",$_POST['area']);
        $blog->rol=implode(",",$_POST['rol']);
        $blog->proyecto=implode(",",$_POST['proyecto']);      
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_blogs', $blog, 'id');
        echo json_encode($result);
    }

    public function eliminarBlog(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_blogs'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }


    public function comentarioBlog() {
        $blog = new stdClass();
        $blog->state = 1; 
        $blog->cedula=$_GET['cedula']; 
        $blog->nombre=$_GET['nombre']; 
        $blog->blog=$_GET['blog']; 
        $blog->comentario=urldecode($_GET['comentario']);  
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_comentarios_blog', $blog);  
        echo json_encode($result);    
    }

     /* AGENDA CULTURAL */

    public function crearAgenda(){
        $agenda = new stdClass();
        $agenda->state = 1;
        $agenda->titulo=$_POST["titulo"];  
        $agenda->disponibilidad=$_POST["disponibilidad"];  
        $agenda->publico=$_POST["publico"];   
        $agenda->preview=$_POST["preview"];  
        $agenda->fuente=$_POST["fuente"];  
        $agenda->categoria=implode(",",$_POST['categoria']);
        $agenda->contenido=$_POST["contenido"];      
        $agenda->imagen_grande=$_POST['imagen_grande'][0];
        $agenda->imagen_pequena=$_POST['imagen_pequeña'][0]; 
        $agenda->delegacion=implode(",",$_POST['delegacion']);
        $agenda->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $agenda->segmento=implode(",",$_POST['segmento']);
        $agenda->nivel=implode(",",$_POST['nivel']);
        $agenda->ciudad=implode(",",$_POST['ciudad']);
        $agenda->area=implode(",",$_POST['area']);
        $agenda->rol=implode(",",$_POST['rol']);
        $agenda->proyecto=implode(",",$_POST['proyecto']);      
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_agenda', $agenda);
        echo json_encode($result);
    }

    public function guardarAgenda(){
        $agenda = new stdClass();
        $agenda->state = 1; 
        $agenda->id=$_POST['id'];
        $agenda->titulo=$_POST["titulo"]; 
        $agenda->disponibilidad=$_POST["disponibilidad"];  
        $agenda->publico=$_POST["publico"];  
        $agenda->fuente=$_POST["fuente"];
        $agenda->preview=$_POST["preview"];  
        $agenda->categoria=implode(",",$_POST['categoria']);    
        $agenda->contenido=$_POST["contenido"];      
        $agenda->imagen_grande=$_POST['imagen_grande'][0];
        $agenda->imagen_pequena=$_POST['imagen_pequeña'][0];    
        $agenda->delegacion=implode(",",$_POST['delegacion']);
        $agenda->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $agenda->segmento=implode(",",$_POST['segmento']);
        $agenda->nivel=implode(",",$_POST['nivel']);
        $agenda->ciudad=implode(",",$_POST['ciudad']);
        $agenda->area=implode(",",$_POST['area']);
        $agenda->rol=implode(",",$_POST['rol']);
        $agenda->proyecto=implode(",",$_POST['proyecto']);      
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_agenda', $agenda, 'id');
        echo json_encode($result);
    }

    public function eliminarAgenda(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_agenda'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

    /* FORMACIÓN */

    public function crearFormacion(){
        $formacion = new stdClass();
        $formacion->state = 1;
        $formacion->titulo=$_POST["titulo"];
        $formacion->disponibilidad=$_POST["disponibilidad"];  
        $formacion->fuente=$_POST["fuente"];   
        $formacion->publico=$_POST["publico"];
        $formacion->preview=$_POST["preview"];  
        $formacion->contenido=$_POST["contenido"];      
        $formacion->imagen_grande=$_POST['imagen_grande'][0];
        $formacion->imagen_pequena=$_POST['imagen_pequeña'][0]; 
        $formacion->delegacion=implode(",",$_POST['delegacion']);
        $formacion->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $formacion->segmento=implode(",",$_POST['segmento']);
        $formacion->nivel=implode(",",$_POST['nivel']);
        $formacion->ciudad=implode(",",$_POST['ciudad']);
        $formacion->area=implode(",",$_POST['area']);
        $formacion->rol=implode(",",$_POST['rol']);
        $formacion->proyecto=implode(",",$_POST['proyecto']);      
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_formacion', $formacion);
        echo json_encode($result);
    }

    public function guardarFormacion(){
        $formacion = new stdClass();
        $formacion->state = 1; 
        $formacion->id=$_POST['id'];
        $formacion->titulo=$_POST["titulo"];
        $formacion->disponibilidad=$_POST["disponibilidad"];  
        $formacion->publico=$_POST["publico"];
        $formacion->preview=$_POST["preview"];  
        $formacion->contenido=$_POST["contenido"];      
        $formacion->imagen_grande=$_POST['imagen_grande'][0];
        $formacion->imagen_pequena=$_POST['imagen_pequeña'][0];    
        $formacion->delegacion=implode(",",$_POST['delegacion']);
        $formacion->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $formacion->segmento=implode(",",$_POST['segmento']);
        $formacion->nivel=implode(",",$_POST['nivel']);
        $formacion->ciudad=implode(",",$_POST['ciudad']);
        $formacion->area=implode(",",$_POST['area']);
        $formacion->rol=implode(",",$_POST['rol']);
        $formacion->proyecto=implode(",",$_POST['proyecto']);      
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_formacion', $formacion, 'id');
        echo json_encode($result);
    }

    public function eliminarFormacion(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_formacion'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }


    /* CATEGORÍAS ARTÍCULO */

    public function crearCategoriaArticulo(){
        $categoria = new stdClass();
        $categoria->state = 1;
        $categoria->categoria = $_GET['categoria'];
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_categorias_articulos', $categoria);
        echo json_encode($result);
    }
    public function guardarCategoriaArticulo(){
        $categoria = new stdClass();
        $categoria->state = 1;        
        $categoria->id = $_GET['id'];
        $categoria->categoria = $_GET['categoria'];        
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_categorias_articulos', $categoria, 'id');
        echo json_encode($result);
    }
    public function eliminarCategoriaArticulo(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_categorias_articulos'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

     /* CATEGORÍAS BLOG */

    public function crearCategoriaBlog(){
        $categoria = new stdClass();
        $categoria->state = 1;
        $categoria->categoria=$_GET['categoria'];
        $categoria->descripcion=$_GET['descripcion'];
        $categoria->imagen=$_GET['imagen'][0];
        $categoria->icono=$_GET['icono'][0];
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_categorias_blog', $categoria);
        echo json_encode($result);
    }
    public function guardarCategoriaBlog(){
        $categoria = new stdClass();
        $categoria->state = 1;        
        $categoria->id = $_GET['id'];
        $categoria->categoria = $_GET['categoria'];  
        $categoria->descripcion = $_GET['descripcion']; 
        $categoria->imagen=$_GET['imagen'][0];
        $categoria->icono=$_GET['icono'][0];     
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_categorias_blog', $categoria, 'id');
        echo json_encode($result);
    }
    public function eliminarCategoriaBlog(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_categorias_blog'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

     /* CATEGORÍAS AGENDA */

    public function crearCategoriaAgenda(){
        $categoria = new stdClass();
        $categoria->state = 1;
        $categoria->categoria = $_GET['categoria'];
        $categoria->imagen=$_GET['imagen'][0];
        $categoria->color = $_GET['color'];
        $categoria->ancho = $_GET['ancho'];
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_categorias_agenda', $categoria);
        echo json_encode($result);
    }
    public function guardarCategoriaAgenda(){
        $categoria = new stdClass();
        $categoria->state = 1;        
        $categoria->id = $_GET['id'];
        $categoria->categoria = $_GET['categoria']; 
        $categoria->imagen=$_GET['imagen'][0];
        $categoria->color = $_GET['color']; 
        $categoria->ancho = $_GET['ancho'];      
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_categorias_agenda', $categoria, 'id');
        echo json_encode($result);
    }
    public function eliminarCategoriaAgenda(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_categorias_agenda'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

    /* DESTACADOS */
    public function destacarBlog(){
        $blog = new stdClass();
        $blog->state = 1;        
        $blog->id = $_GET['id'];
        $blog->destacado = $_GET['destacado'];        
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_blogs', $blog, 'id');
        echo json_encode($result);
    }
    public function destacarArticulo(){
        $articulo = new stdClass();
        $articulo->state = 1;        
        $articulo->id = $_GET['id'];
        $articulo->destacado = $_GET['destacado'];        
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_articulos', $articulo, 'id');
        echo json_encode($result);
    }
    public function destacarAgenda(){
        $agenda = new stdClass();
        $agenda->state = 1;        
        $agenda->id = $_GET['id'];
        $agenda->destacado = $_GET['destacado'];        
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_agenda', $agenda, 'id');
        echo json_encode($result);
    }
    public function destacarFormacion(){
        $formacion = new stdClass();
        $formacion->state = 1;        
        $formacion->id = $_GET['id'];
        $formacion->destacado = $_GET['destacado'];        
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_formacion', $formacion, 'id');
        echo json_encode($result);
    }
    public function destacarPremio(){
        $premio = new stdClass();
        $premio->state = 1;        
        $premio->id = $_GET['id'];
        $premio->destacado = $_GET['destacado'];        
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_premios', $premio, 'id');
        echo json_encode($result);
    }

    /* SLIDER PÚBLICO */

    public function crearSliderPublico(){
        $sliderpublico = new stdClass();
        $sliderpublico->state = 1;
        $sliderpublico->titulo=$_GET['titulo'];
        $sliderpublico->link=$_GET['link'];
        $sliderpublico->descripcion=$_GET['descripcion'];
        $sliderpublico->imagen_publico=$_GET['imagen'][0];
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_slider_publico', $sliderpublico);
        echo json_encode($result);
    }

    public function guardarSliderPublico(){
        $sliderpublico = new stdClass();
        $sliderpublico->state = 1;        
        $sliderpublico->id = $_GET['id'];
        $sliderpublico->titulo=$_GET['titulo'];
        $sliderpublico->link=$_GET['link'];
        $sliderpublico->descripcion=$_GET['descripcion'];
        $sliderpublico->imagen_publico=$_GET['imagen'][0];        
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_slider_publico', $sliderpublico, 'id');
        echo json_encode($result);
    }

    public function eliminarSliderPublico(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_slider_publico'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

    /* SLIDER INTERNO */

    public function crearSliderInterno(){
        $sliderinterno = new stdClass();
        $sliderinterno->state = 1;
        $sliderinterno->titulo=$_POST['titulo'];
        $sliderinterno->link=$_POST['link'];
        $sliderinterno->publico=$_POST['publico'];
        $sliderinterno->descripcion=$_POST['descripcion'];
        $sliderinterno->imagen_interno=$_POST['imagen'][0];
        $sliderinterno->delegacion=implode(",",$_POST['delegacion']);
        $sliderinterno->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $sliderinterno->segmento=implode(",",$_POST['segmento']);
        $sliderinterno->nivel=implode(",",$_POST['nivel']);
        $sliderinterno->ciudad=implode(",",$_POST['ciudad']);
        $sliderinterno->area=implode(",",$_POST['area']);
        $sliderinterno->rol=implode(",",$_POST['rol']);
        $sliderinterno->proyecto=implode(",",$_POST['proyecto']); 
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_slider_interno', $sliderinterno);
        echo json_encode($result);
    }

    public function guardarSliderInterno(){
        $sliderinterno = new stdClass();
        $sliderinterno->state = 1;        
        $sliderinterno->id = $_POST['id'];
        $sliderinterno->titulo=$_POST['titulo'];
        $sliderinterno->link=$_POST['link'];
        $sliderinterno->publico=$_POST['publico'];
        $sliderinterno->descripcion=$_POST['descripcion'];
        $sliderinterno->imagen_interno=$_POST['imagen'][0];      
        $sliderinterno->delegacion=implode(",",$_POST['delegacion']);
        $sliderinterno->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $sliderinterno->segmento=implode(",",$_POST['segmento']);
        $sliderinterno->nivel=implode(",",$_POST['nivel']);
        $sliderinterno->ciudad=implode(",",$_POST['ciudad']);
        $sliderinterno->area=implode(",",$_POST['area']);
        $sliderinterno->rol=implode(",",$_POST['rol']);
        $sliderinterno->proyecto=implode(",",$_POST['proyecto']);   
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_slider_interno', $sliderinterno, 'id');
        echo json_encode($result);
    }
        
    public function eliminarSliderInterno(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_slider_interno'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

    /* CAMPAÑAS */

    public function obtenerPublicacionesCampanas(){
        $tipo = $_GET['tipo'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        if($tipo == '1'){
            $query = 'SELECT id, titulo FROM #__somosmaestros_formacion WHERE state = 1';
        }elseif ($tipo == '2') {
            $query = 'SELECT id, titulo FROM #__somosmaestros_blogs WHERE state = 1';
        }elseif ($tipo == '3') {
            $query = 'SELECT id, titulo FROM #__somosmaestros_agenda WHERE state = 1';
        }

        $db->setQuery($query);
        $results = $db->loadObjectList();
        echo json_encode($results);
    }

    public function crearCampana(){
        $campana = new stdClass();
        $campana->state = 1;  
        $campana->nombre=$_POST['nombre'];      
        $campana->tipo=$_POST['tipo'];
        $campana->fecha_inicio=$_POST['fechaInicio'];
        $campana->fecha_fin=$_POST['fechaFin'];  
        $campana->delegacion=implode(",",$_POST['delegacion']);
        $campana->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $campana->segmento=implode(",",$_POST['segmento']);
        $campana->nivel=implode(",",$_POST['nivel']);
        $campana->ciudad=implode(",",$_POST['ciudad']);
        $campana->area=implode(",",$_POST['area']);
        $campana->rol=implode(",",$_POST['rol']);
        $campana->proyecto=implode(",",$_POST['proyecto']);       
        $campana->publicacion=$_POST['publicacion'];
        $campana->puntos=$_POST['puntos'];
        $campana->meta=$_POST['meta'];   
        $campana->meta_reservas=$_POST['meta_reservas'];   
        require_once 'templates/somosmaestros/code/SMBrujula.php';
        $db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );        
        $tipoPunto = new stdClass();
        $tipoPunto->idtipopuntos=null;
        $tipoPunto->nombretipopuntos='Asistencia a formación';
        $tipoPunto->puntostipopuntos=$_POST['puntos'];
        $resultBrujula = $db2->insertObject('mkTipoPuntos', $tipoPunto);
        $idInsertado = $db2->insertid();
        $campana->idtipopuntos=$idInsertado;
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_capanas', $campana);
        echo json_encode($result);
    }

    public function guardarCampana(){
        $campana = new stdClass();
        $campana->state = 1;        
        $campana->id = $_POST['id'];
        $campana->nombre=$_POST['nombre'];   
        $campana->tipo=$_POST['tipo'];
        $campana->fecha_inicio=$_POST['fechaInicio'];
        $campana->fecha_fin=$_POST['fechaFin'];  
        $campana->delegacion=implode(",",$_POST['delegacion']);
        $campana->tipo_institucion=implode(",",$_POST['tipoInstitucion']);
        $campana->segmento=implode(",",$_POST['segmento']);
        $campana->nivel=implode(",",$_POST['nivel']);
        $campana->ciudad=implode(",",$_POST['ciudad']);
        $campana->area=implode(",",$_POST['area']);
        $campana->rol=implode(",",$_POST['rol']);
        $campana->proyecto=implode(",",$_POST['proyecto']);       
        $campana->publicacion=$_POST['publicacion'];
        $campana->puntos=$_POST['puntos'];
        $campana->meta=$_POST['meta'];   
        $campana->meta_reservas=$_POST['meta_reservas']; 
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_capanas', $campana, 'id');
        echo json_encode($result);
    }

    public function eliminarCampana(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_capanas'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

    /* PREMIOS */

    public function crearPremio(){
        $premio = new stdClass();
        $premio->state = 1;
        $premio->premio=$_GET['premio'];
        $premio->puntos=$_GET['puntos'];
        $premio->cantidad=$_GET['cantidad'];
        $premio->descripcion=$_GET['descripcion'];
        $premio->imagen=$_GET['imagen'][0];
        $premio->rol=implode(",",$_GET['rol']);
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_premios', $premio);
        echo json_encode($result);
    }

    public function guardarPremio(){
        $premio = new stdClass();
        $premio->state = 1;
        $premio->id = $_GET['id'];
        $premio->premio=$_GET['premio'];
        $premio->puntos=$_GET['puntos'];
        $premio->cantidad=$_GET['cantidad'];
        $premio->descripcion=$_GET['descripcion'];
        $premio->imagen=$_GET['imagen'][0];
        $premio->rol=implode(",",$_GET['rol']);
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_premios', $premio, 'id');
        echo json_encode($result);
    }

    public function eliminarPremio(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_premios'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }


    /* AGENDAS - FORMACIÓN -> CAMPAÑAS */

    public function asistirAgenda(){
        $cc = $_GET['cedula'];
        $agenda = $_GET['agenda'];
        $fecha = date("Y-m-d H:i:s");
        
        $asistencia = new stdClass();
        $asistencia->state = 1;
        $asistencia->cedula=$cc;
        $asistencia->agenda=$agenda;
        $asistencia->fecha=$fecha;
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_asistentes_agenda', $asistencia);
        if($result) {
            $actual = $this->obtenerAsistentesAgenda($agenda);
            $nuevo = $actual + 1;
            $this->sumarAsistenteAgenda($agenda,$nuevo);
            $this->crearQRAgenda($cc, $agenda);
        }
        echo json_encode($result);
    }
    protected function obtenerAsistentesAgenda($agenda){
        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('asistentes')));
        $query->from($db->quoteName('#__somosmaestros_agenda'));
        $query->where($db->quoteName('id') . ' = '. $agenda);
        $db->setQuery($query);
        $result = $db->loadResult();
        return (int)$result; 
    }
    protected function sumarAsistenteAgenda($id, $asistentes){
        $agenda = new stdClass();
        $agenda->state = 1;
        $agenda->id = $id;
        $agenda->asistentes=$asistentes;
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_agenda', $agenda, 'id');
        
    }
    public function crearQRAgenda($cc, $agenda, $mail){
        $mailer = JFactory::getMailer();

        //$mailer->addRecipient('daniel07079@gmail.com');
        $mailer->addRecipient('jose.duarte@emeraldstudio.co');
         
        $mailer->setSender('daniel.alvarez@esda.co');
        $mailer->setSubject('Inscripción exitosa - somosSMaestros');
        $body   = '<h2>Tu inscripción se ha realizado correctamente</h2>'
            . '<div>Este en un mensaje de confirmación para la inscripción al evento de somoSMaestros</div>'
            . '<p>Presenta el siguiente código en la entrada del evento para redimir tus puntos</p>'
            . '<p style="center"><img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.urlencode('http://somosmaestros.co/index.php?option=com_functions&task=confirmarAsistenteAgenda&cedula='.$cc.'&agenda='.$agenda).'" alt="QR"/></p>'
            . '<div>Este mensaje ha sido generado automáticamente, por favor no lo respondas</div>';
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        // Optionally add embedded image
        //$mailer->AddEmbeddedImage( JPATH_COMPONENT.'/assets/logo128.jpg', 'logo_id', 'logo.jpg', 'base64', 'image/jpeg' );
        $send = $mailer->Send();
        if ( $send !== true ) {
            echo 'Error sending email: ' . $send->__toString();
        } else {
            return true;
        }
    }
    public function confirmarAsistenteAgenda(){
        $cc = $_GET['cedula'];
        $agenda = $_GET['agenda'];
        

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
         
        // Fields to update.
        $fields = array(
            $db->quoteName('asistio') . ' = 1'
        );
         
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('cedula') . ' = ' .$cc, 
            $db->quoteName('agenda') . ' = ' .$agenda
        );
         
        $query->update($db->quoteName('#__somosmaestros_asistentes_agenda'))->set($fields)->where($conditions);
         
        $db->setQuery($query);
        //echo $query;
        $result = $db->execute();
        if($result){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }


    public function asistirFormacion(){
        $cc = $_GET['cedula'];
        $formacion = $_GET['formacion'];
        $mail = $_GET['correo'];
        $fecha = date("Y-m-d H:i:s");
        
        $asistencia = new stdClass();
        $asistencia->state = 1;
        $asistencia->cedula=$cc;
        $asistencia->formacion=$formacion;
        $asistencia->fecha=$fecha;
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_asistentes_formacion', $asistencia);
        if($result) {
            $actual = $this->obtenerAsistentesFormacion($formacion);
            $nuevo = $actual + 1;
            $this->sumarAsistenteFormacion($formacion,$nuevo);
            $this->crearQRFormacion($cc, $formacion, $mail);
        }
        echo json_encode($result);
    }

    public function asistenteFormacion(){
        $cc = $_GET['cedula'];
        $formacion = $_GET['formacion'];
        $mail = $_GET['correo'];
        $fecha = date("Y-m-d H:i:s");
        
        $asistencia = new stdClass();
        $asistencia->state = 1;
        $asistencia->cedula=$cc;
        $asistencia->formacion=$formacion;
        $asistencia->fecha=$fecha;
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_asistentes_formacion', $asistencia);
        if($result) {
            $actual = $this->obtenerAsistentesFormacion($formacion);
            $nuevo = $actual + 1;
            $this->sumarAsistenteFormacion($formacion,$nuevo);
            $this->crearQRFormacion($cc, $formacion, $mail);
        }
        echo json_encode($result);
    }
    protected function obtenerAsistentesFormacion($formacion){
        // Get a db connection.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('asistentes')));
        $query->from($db->quoteName('#__somosmaestros_formacion'));
        $query->where($db->quoteName('id') . ' = '. $formacion.' AND state = 1');
        $db->setQuery($query);
        $result = $db->loadResult();
        return (int)$result; 
    }
    protected function sumarAsistenteFormacion($id, $asistentes){
        $formacion = new stdClass();
        $formacion->state = 1;
        $formacion->id = $id;
        $formacion->asistentes=$asistentes;
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_formacion', $formacion, 'id');
        
    }
    public function crearQRFormacion($cc, $formacion, $mail){
        $mailer = JFactory::getMailer();

        $mailer->addRecipient('somosmaestros@grupo-sm.com');
        $mailer->addRecipient($mail);
         
        $mailer->setSender('somosmaestros@grupo-sm.com');
        $mailer->setSubject('Inscripción exitosa - somosSMaestros');
        $body   = '<h2>Tu inscripción se ha realizado correctamente - Ref: '.$cc.'</h2>'
            . '<div>Este en un mensaje de confirmación para la inscripción al evento de somoSMaestros</div>'
            . '<p>Presenta el siguiente código en la entrada del evento para redimir tus puntos</p>'
            . '<p style="center"><img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.urlencode('http://somosmaestros.co/index.php?option=com_functions&task=confirmarAsistenteFormacion&cedula='.$cc.'&formacion='.$formacion).'" alt="QR"/></p>'
            . '<div>Este mensaje ha sido generado automáticamente, por favor no lo respondas</div>';
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        // Optionally add embedded image
        //$mailer->AddEmbeddedImage( JPATH_COMPONENT.'/assets/logo128.jpg', 'logo_id', 'logo.jpg', 'base64', 'image/jpeg' );
        $send = $mailer->Send();
        if ( $send !== true ) {
            echo 'Error sending email: ' . $send->__toString();
        } else {
            return true;
        }
    }
    public function confirmarAsistenteFormacion(){

        $session =& JFactory::getSession();
        if($session->get('logueado')){
            $cc = $_GET['cedula'];
            $formacion = $_GET['formacion'];
            

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
             
            // Fields to update.
            $fields = array(
                $db->quoteName('asistio') . ' = 1'
            );
             
            // Conditions for which records should be updated.
            $conditions = array(
                $db->quoteName('cedula') . ' = ' .$cc, 
                $db->quoteName('formacion') . ' = ' .$formacion
            );
             
            $query->update($db->quoteName('#__somosmaestros_asistentes_formacion'))->set($fields)->where($conditions);
             
            $db->setQuery($query);
            //echo $query;
            $result = $db->execute();
            if($result){
                echo json_encode(true);
                //Si hay campaña de tipo Formación se otorgan puntos
                $campana = $this->validarCampanaFormacion($formacion);
                if($campana){
                    //Aquí se asignarán los puntos                
                    require_once 'templates/somosmaestros/code/SMBrujula.php';
                    $db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );        
                    $puntos = new stdClass();
                    $puntos->idtipopuntos = $campana->idtipopuntos;
                    $puntos->cantidadpuntos = $campana->puntos;
                    $puntos->documentopuntos = $cc;
                    $resultBrujula = $db2->insertObject('mkPuntos', $puntos);
                }
            }else{
                echo json_encode(false);
            }

            JHtml::_('behavior.keepalive');
        }else{
            $respuesta = array('estado' => 0, 'mensaje' => 'No tienes acceso a esta función' );
            echo json_encode($respuesta);
        }
        
    }
    protected function validarCampanaFormacion($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('puntos', 'idtipopuntos')));
        $query->from($db->quoteName('#__somosmaestros_capanas'));
        $query->where($db->quoteName('tipo') . ' = 1 AND '. $db->quoteName('publicacion').' = '.$id);
        $query->order('ordering ASC');
         
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $result = $db->loadObject();
        return $result;
    }



    /* CAMPAÑA BLOG */

    protected function validarCampanaBlog($blog, $campana){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('puntos', 'idtipopuntos')));
        $query->from($db->quoteName('#__somosmaestros_capanas'));
        $query->where($db->quoteName('tipo') . ' = 2 AND '. $db->quoteName('campana').' = '.$campana AND $db->quoteName('publicacion').' = '.$blog);
        $query->order('ordering ASC');
         
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $result = $db->loadObject();
        return $result;
    }

    public function campanaBlog(){
        $cc = $_GET['cedula'];
        $nombre = $_GET['nombre'];
        $Idblog = $_GET['blog'];
        $IdCampana = $_GET['campana'];
        $comentario=urldecode($_GET['comentario']);  
        

        $blog = new stdClass();
        $blog->state = 1; 
        $blog->cc; 
        $blog->nombre; 
        $blog->Idblog; 
        $blog->comentario;  
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_comentarios_blog', $blog);  


        $blog = new stdClass();
        $blog->state = 1; 
        $blog->cc; 
        $blog->Idblog; ; 
        $blog->IdCampana; 
        $blog->fecha = date("Y-m-d H:i:s"); 
        $result2 = JFactory::getDbo()->insertObject('#__somosmaestros_campana_blog', $blog);  

        if($result2){
            echo json_encode(true);
            //Si hay campaña de tipo Formación se otorgan puntos
            $blogC = $this->validarCampanaBlog($IdCampana,$Idblog);
            if($blogC){
                //Aquí se asignarán los puntos                
                require_once 'templates/somosmaestros/code/SMBrujula.php';
                $db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );        
                $puntos = new stdClass();
                $puntos->idtipopuntos = $blogC->idtipopuntos;
                $puntos->cantidadpuntos = $blogC->puntos;
                $puntos->documentopuntos = $cc;
                $resultBrujula = $db2->insertObject('mkPuntos', $puntos);
            }
        }else{
            echo json_encode(false);
        }
    }

    /* CAMPAÑA PERFIL */

    protected function validarCampanaPerfil($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('puntos', 'idtipopuntos')));
        $query->from($db->quoteName('#__somosmaestros_capanas'));
        $query->where($db->quoteName('tipo') . ' = 3'.$db->quoteName('campana').' = '.$id.'');
        $query->order('ordering ASC');
         
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $result = $db->loadObject();
        return $result;
    }

    public function campanaPerfil(){

        $cc = $_GET['cedula'];
        $IdCampana = $_GET['campana'];
        
        $usuario = new stdClass();
        $usuario->state = 1;
        $usuario->cc;
        $usuario->nombres=$_POST['nombres'];
        $usuario->apellidos=$_POST['apellidos'];
        $usuario->telefono=$_POST['telefono'];
        $usuario->correo=$_POST['email'];
        $usuario->ciudad=$_POST['ciudad'];
        $usuario->departamento=$_POST['departamentos'];
        $usuario->institucion=$_POST['institucion'];
        $usuario->genero=$_POST['genero'];
        $usuario->fecha=$_POST['fecha_nacimiento'];
        $usuario->observaciones=$_POST['observaciones'];
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_sm_actualizacion', $usuario);   


        $perfil = new stdClass();
        $perfil->state = 1; 
        $perfil->cc; 
        $perfil->IdCampana; 
        $perfil->fecha = date("Y-m-d H:i:s"); 
        $result2 = JFactory::getDbo()->insertObject('#__somosmaestros_campana_perfil', $perfil);  

        if($result2){
            echo json_encode(true);
            //Si hay campaña de tipo Formación se otorgan puntos
            $perfilC = $this->validarCampanaPerfil($IdCampana);
            if($perfilC){
                //Aquí se asignarán los puntos                
                require_once 'templates/somosmaestros/code/SMBrujula.php';
                $db2 = JDatabaseDriver::getInstance( SMBrujula::getConexion() );        
                $puntos = new stdClass();
                $puntos->idtipopuntos = $perfilC->idtipopuntos;
                $puntos->cantidadpuntos = $perfilC->puntos;
                $puntos->documentopuntos = $cc;
                $resultBrujula = $db2->insertObject('mkPuntos', $puntos);
            }
        }else{
            echo json_encode(false);
        }
    }


    /* USUARIOS SM */

    public function crearUsuarioSM(){
        $usuario = new stdClass();
        $usuario->state = 1;
        $usuario->nombre = $_GET['nombre'];
        $usuario->usuario = $_GET['usuario'];
        $usuario->perfil = $_GET['perfil'];
        $usuario->password = $_GET['password'];
        $usuario->delegacion = $_GET['delegacion'];
        $usuario->ciudad = $_GET['ciudad'];
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_sm_personas', $usuario);
        echo json_encode($result);
    }
    public function guardarUsuarioSM(){ 
        $usuario = new stdClass();
        $usuario->state = 1;
        $usuario->id = $_GET['id'];
        $usuario->nombre = $_GET['nombre'];
        $usuario->usuario = $_GET['usuario'];
        $usuario->perfil = $_GET['perfil'];
        $usuario->password = $_GET['password'];
        $usuario->delegacion = $_GET['delegacion'];
        $usuario->ciudad = $_GET['ciudad'];       
        $result = JFactory::getDbo()->updateObject('#__somosmaestros_sm_personas', $usuario, 'id');
        echo json_encode($result);
    }
    public function eliminarUsuarioSM(){
        $id = $_GET['id'];
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);         

        $conditions = array(
            $db->quoteName('id') . ' = '.$id, 
        );

        $query->delete($db->quoteName('#__somosmaestros_sm_personas'));
        $query->where($conditions);
         
        $db->setQuery($query);
        $result = $db->execute();
        echo json_encode($result);
    }

    public function saveLog(){        
        $log = new stdClass();
        $log->state = 1;
        $dateNow = date("m.d.y");   
        $timeNow = date("H:i:s");   
        $log->date = $dateNow;
        $log->time = $timeNow;
        $log->cedula = $_GET['cedula'];
        $log->vista = $_GET['vista'];
        $result = JFactory::getDbo()->insertObject('#__somosmaestros_logs', $log);
        echo json_encode($result);
    }



    /* Mailing Nuevos usuarios - Cambio de Datos */

    public function solicitudRegistro(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__somosmaestros_sm_registro'));
        $query->where($db->quoteName('state') . ' = 1');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $result = $db->loadObjectList();

        print_r($result);

    }

    public function solicitudActualizacion(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__somosmaestros_sm_actualizacion'));
        $query->where($db->quoteName('state') . ' = 1');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $result = $db->loadObjectList();

        print_r($result);
    }

    public function solicitudFuncionario(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__somosmaestros_sm_brujula'));
        $query->where($db->quoteName('state') . ' = 1');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $result = $db->loadObjectList();
/*
        $mensajeFuncionario=

        '<table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;margin:0 10px;padding:0; background-color:#FAFAFA" width="80%">
            <tbody>'
                foreach ($result as $r) {
               '<tr align="left" style="vertical-align:top;text-align:left;width:100%;padding:0">
                    <td valign="top" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell;font-size:12px;color:#585858;line-height:15px;padding:15px">
                        Cédula:
                    </td>
                    <td valign="top" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;font-size:12px;color:#585858;line-height:15px;padding:15px">
                        '.$r->cedula.'
                    </td>
                </tr>

                '}'                
            </tbody>
        </table>';

        $correoAdministrador = $this->enviarCorreo('jose.duarte@emeraldstudio.co', 'Somos Maestros','Solicitud de Funcionario - Actualizar Datos',$mensajeFuncionario);
    
*/
    }

     protected function enviarCorreo($para, $nombrePara, $titulo, $mensaje){
        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        date_default_timezone_set('America/Bogota');
        
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $sender = array(
            $config->get( 'config.mailfrom' ),
            $config->get( 'config.fromname' ) );
        $mailer->setSender($sender);

        $mailer->addRecipient($para);

        $body = '
            <html>
            <head>
              <title>'.$titulo.'</title>
            </head>
            <body>
                <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;margin:0 10px;padding:0">
                    <tbody>
                        <tr align="left" style="vertical-align:top;text-align:left;width:100%;padding:0; background-color:#E0001C">
                            <td><br></td>
                        </tr>
                    </tbody>
                </table>
                <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;margin:0 10px;padding:0">
                    <tbody>
                        <tr align="left" style="vertical-align:top;text-align:left;width:100%;padding:0">
                            <td width="127" valign="top" align="left" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;padding:15px 0">
                                <img height="50" align="left" style="outline:none;text-decoration:none;float:left;clear:both;display:block" src="http://somosmaestros.co/images/logo.png">
                            </td>
                            <td valign="top" align="right" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;font-size:11px;color:#999999;line-height:15px;text-transform:uppercase;padding:30px">
                                <span>'.date("F j, Y, g:i a").'</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;margin:0 10px;padding:0; background-color:#FAFAFA">
                    <tbody>
                        <tr align="left" style="vertical-align:top;text-align:left;width:100%;padding:0; ">
                            <td valign="top" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell;font-size:18px;color:#585858;line-height:18px;padding:15px">
                                '.$titulo.'
                            </td>
                        </tr>
                    </tbody>
                </table>
                '.$mensaje.'
                <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;margin:0 10px;padding:0">
                    <tbody>
                        <tr align="left" style="vertical-align:top;text-align:left;width:100%;padding:0; background-color:#DEDFDF">
                            <td valign="top" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell;font-size:11px;color:#ffffff;line-height:11px;padding:5px">
                                Somos Maestros - 2015. Todos los derechos reservados
                            </td>
                        </tr>
                    </tbody>
                </table>
            </body>
            </html> 
            ';

        

        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setSubject($titulo);
        $mailer->setBody($body);

        $send = $mailer->Send();
        return $send;
    }
}
