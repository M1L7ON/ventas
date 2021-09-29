<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    

    function getCategoria($idcategoria)
    {
        return $this->db->get_where('categoria',array('idcategoria'=>$idcategoria))->row_array();
    }
    

    function getAllCategoriaCount()
    {
        $this->db->from('categoria');
        return $this->db->count_all_results();
    }
        

    function getAllCategoria()
    {
        $this->db->order_by('idcategoria', 'desc');       
        $this->db->where('condicion', '1');  
        return $this->db->get('categoria')->result_array();
    }
        

    function addCategoria($params)
    {
        $this->db->insert('categoria',$params);
        return $this->db->insert_id();
    }
    

    function updateCategoria($idcategoria,$params)
    {
        $this->db->where('idcategoria',$idcategoria);
        return $this->db->update('categoria',$params);
    }
    
    function cambiarEstado($idcategoria,$params)
    {
        $this->db->where('idcategoria',$idcategoria);
        return $this->db->update('categoria',$params);
    }

    public function getCategoriasReporte(){
        $this->db->select('idcategoria, nombre, descripcion');
        $this->db->from('categoria');
        $this->db->order_by('nombre','asc');

        $r = $this->db->get();
        return $r->result();
    }
}
