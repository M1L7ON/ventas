<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Proveedor_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    

    function getProveedor($idpersona)
    {
        $this->db->where('idpersona', $idpersona);
        return $this->db->get('persona')->row_array();
    }
    

    function getAllClienteCount()
    {
        $this->db->from('persona');
        return $this->db->count_all_results();
    }
        

    function getAllCliente()
    {
        $this->db->order_by('idpersona', 'desc');       
        $this->db->where('tipo_persona', 'Proveedor');  
        return $this->db->get('persona')->result_array();
    }
        

    function addCliente($params)
    {
        $this->db->insert('persona',$params);
        return $this->db->insert_id();
    }
    

    function updateCliente($idcliente,$params)
    {
        $this->db->where('idpersona',$idcliente);
        return $this->db->update('persona',$params);
    }
    
    function cambiarEstado($idcliente,$params)
    {
        $this->db->where('idpersona',$idcliente);
        return $this->db->update('persona',$params);
    }

    public function getProveedorReporte(){
        $this->db->select('idpersona, nombre, direccion, telefono, email');
        $this->db->from('persona');
        $this->db->Where('tipo_persona','Proveedor');
        $this->db->order_by('nombre','asc');

        $r = $this->db->get();
        return $r->result();
    }
}


