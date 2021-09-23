<?php
 
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
    

    function get_all_categoria_count()
    {
        $this->db->from('categoria');
        return $this->db->count_all_results();
    }
        

    function get_all_categoria()
    {
        $this->db->order_by('idcategoria', 'desc');       
        //$this->db->where('condicion', '1');  
        return $this->db->get('categoria')->result_array();
    }
        

    function add_Categoria($params)
    {
        $this->db->insert('categoria',$params);
        return $this->db->insert_id();
    }
    

    function update_Categoria($idcategoria,$params)
    {
        $this->db->where('idcategoria',$idcategoria);
        return $this->db->update('categoria',$params);
    }
    
    function cambiarEstado($idcategoria,$params)
    {
        $this->db->where('idcategoria',$idcategoria);
        return $this->db->update('categoria',$params);
    }
}
