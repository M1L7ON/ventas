<?php
 
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
    

    function get_all_Producto_count()
    {
        $this->db->from('articulo');
        return $this->db->count_all_results();
    }
        

    function get_all_Producto()
    {
        $this->db->order_by('idarticulo', 'desc');       
        //$this->db->where('condicion', '1');  
        return $this->db->get('articulo')->result_array();
    }
        

    function add_Producto($params)
    {
        $this->db->insert('articulo',$params);
        return $this->db->insert_id();
    }
    

    function update_Producto($idarticulo,$params)
    {
        $this->db->where('idarticulo',$idarticulo);
        return $this->db->update('articulo',$params);
    }
    
    function cambiarEstado($idarticulo,$params)
    {
        $this->db->where('idarticulo',$idarticulo);
        return $this->db->update('articulo',$params);
    }
}
