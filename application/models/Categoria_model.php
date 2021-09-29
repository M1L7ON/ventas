<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Categoria_model.
 *
 * @author Ronald Torrez
 * @version 1.0
 */
class Categoria_model extends CI_Model
{
    /**
     * Constructor de la clase.
     */
    function __construct()
    {
        parent::__construct();
    }
    
     /**
     * getCategoria.
     * 
     * @param idcategoria recibe el id de la categoria.
     * @return row_array Con los datos de categoria.
     */
    function getCategoria($idcategoria)
    {
        return $this->db->get_where('categoria',array('idcategoria'=>$idcategoria))->row_array();
    }
    
    /**
     * getAllCategoriaCount
     * 
     * @return entero con la cantidad total de registros.
     */
    function getAllCategoriaCount()
    {
        $this->db->from('categoria');
        return $this->db->count_all_results();
    }
        
    /**
     * getAllCategoria.
     * 
     * @return result_array Con los datos de vairas categorias.
     */
    function getAllCategoria()
    {
        $this->db->order_by('idcategoria', 'desc');       
        $this->db->where('condicion', '1');  
        return $this->db->get('categoria')->result_array();
    }
        
    /**
     * addCategoria.
     * @param params los parametros de insert nombre,descripcion.
     * @return entero con el id de la ultima categoria registrada.
     */
    function addCategoria($params)
    {
        $this->db->insert('categoria',$params);
        return $this->db->insert_id();
    }
    
    /**
     * updateCategoria.
     * @param params los parametros de edición nombre,descripcion.
     * @return entero con el id de la ultima categoria registrada.
     */
    function updateCategoria($idcategoria,$params)
    {
        $this->db->where('idcategoria',$idcategoria);
        return $this->db->update('categoria',$params);
    }
    
    /**
     * cambiarEstado.
     * @param idcategoria los parametros de edición nombre,descripcion.
     * @param params los parametros de edición nombre,descripcion.
     * @return entero con el id de la ultima categoria registrada.
     */
    function cambiarEstado($idcategoria,$params)
    {
        $this->db->where('idcategoria',$idcategoria);
        return $this->db->update('categoria',$params);
    }

    /**
     * getCategoriasReporte.
     * 
     * @return result con idcategoria, nombre, descripcion.
     */
    public function getCategoriasReporte(){
        $this->db->select('idcategoria, nombre, descripcion');
        $this->db->from('categoria');
        $this->db->order_by('nombre','asc');

        $r = $this->db->get();
        return $r->result();
    }
}
