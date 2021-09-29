<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase Cliente_model
 *
 * @autor Oscar Perez
 * @autor Oscar Lopez
 * @version 1.0
 */
class Cliente_model extends CI_Model
{
    /**
     * Cliente_model constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * GetCliente.
     * @param $idcliente Id del Cliente.
     * @return row_array con datos de un cliente.
     */
    function getCliente($idcliente)
    {
        return $this->db->get_where('persona',array('idpersona'=>$idcliente))->row_array();
    }

    /**
     * GetAllClienteCount.
     * @return entero Cantidad de clientes.
     */
    function getAllClienteCount()
    {
        $this->db->from('persona');
        return $this->db->count_all_results();
    }

    /**
     * GetAllCliente.
     * @return result_array con datos de varios clientes.
     */
    function getAllCliente()
    {
        $this->db->order_by('idpersona', 'desc');       
        $this->db->where('tipo_persona', 'Cliente');  
        return $this->db->get('persona')->result_array();
    }

    /**
     * AddCliente.
     * @param $params Datos de los campos de la base de datos y su valor a guardar.
     * @return Id del ultimos cliente guardado.
     */
    function addCliente($params)
    {
        $this->db->insert('persona',$params);
        return $this->db->insert_id();
    }

    /**
     * AddCliente
     * @param $idcliente Id del cliente.
     * @param $params Datos de los campos de la base de datos y su valor a modificar.
     * @return Id del cliente modificado
     */
    function updateCliente($idcliente,$params)
    {
        $this->db->where('idpersona',$idcliente);
        return $this->db->update('persona',$params);
    }

    /**
     * @param $idcliente Id del cliente.
     * @param $params condicion 1 o 0.
     * @return bool.
     */
    function cambiarEstado($idcliente,$params)
    {
        $this->db->where('idpersona',$idcliente);
        return $this->db->update('persona',$params);
    }

    /**
     * getClientesReporte.
     * @return result con idpersona, nombre, direccion, telefono, email.
     */
    public function getClientesReporte(){
        $this->db->select('idpersona, nombre, direccion, telefono, email');
        $this->db->from('persona');
        $this->db->Where('tipo_persona','Cliente');
        $this->db->order_by('nombre','asc');

        $r = $this->db->get();
        return $r->result();
    }
}
