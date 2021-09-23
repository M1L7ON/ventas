<?php
 
class Proveedor_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    

    function getCliente($idcliente)
    {
        return $this->db->get_where('persona',array('idpersona'=>$idpersona))->row_array();
    }
    

    function get_allcliente_count()
    {
        $this->db->from('persona');
        return $this->db->count_all_results();
    }
        

    function get_allcliente()
    {
        $this->db->order_by('idpersona', 'desc');       
        $this->db->where('tipo_persona', 'Proveedor');  
        return $this->db->get('persona')->result_array();
    }
        

    function addcliente($params)
    {
        $this->db->insert('persona',$params);
        return $this->db->insert_id();
    }
    

    function updatecliente($idcliente,$params)
    {
        $this->db->where('idpersona',$idcliente);
        return $this->db->update('persona',$params);
    }
    
    function cambiarEstado($idcliente,$params)
    {
        $this->db->where('idpersona',$idcliente);
        return $this->db->update('persona',$params);
    }
}


