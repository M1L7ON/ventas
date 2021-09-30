<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Producto_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    

    function getProducto($idarticulo)
    {
        return $this->db->get_where('articulo',array('idarticulo'=>$idarticulo))->row_array();
    }
    
    function getCodigo($codigo)
    {
        return $this->db->get_where('articulo',array('codigo'=>$codigo))->row_array();
    }

    function getAllProductoCount()
    {
        $this->db->from('articulo');
        return $this->db->count_all_results();
    }
        

    function getAllProducto()
    {
        $this->db->order_by('idarticulo', 'desc');       
        return $this->db->get('articulo')->result_array();
    }
        

    function addProducto($params)
    {
        $this->db->insert('articulo',$params);
        return $this->db->insert_id();
    }
    

    function updateProducto($idarticulo,$params)
    {
        $this->db->where('idarticulo',$idarticulo);
        return $this->db->update('articulo',$params);
    }
    
    function cambiarEstado($idarticulo,$params)
    {
        $this->db->where('idarticulo',$idarticulo);
        return $this->db->update('articulo',$params);
    }

    public function getProductoReporte(){
        $this->db->select('idarticulo,idcategoria, codigo, nombre, stock, descuento, descripcion');
        $this->db->from('articulo');
        $this->db->order_by('nombre','asc');

        $r = $this->db->get();
        return $r->result();
    }
}
