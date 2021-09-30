<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function getDetalleVentas($idventa)
    {
        $this->db->select('di.idventa, di.idarticulo,di.cantidad,di.descuento, di.precio_venta, a.codigo, a.nombre');
        $this->db->from('detalle_venta di');
        $this->db->join('articulo a','a.idarticulo = di.idarticulo');
        $this->db->Where('di.idventa',$idventa); 
        return $this->db->get()->result_array();
    }
    
    function getVentas($idventa)
    {
        return $this->db->get_where('venta',array('idventa'=>$idventa))->row_array();
    }

    function getAllVentasCount()
    {
        $this->db->from('venta');
        return $this->db->count_all_results();
    }
        

    function getAllVentas()
    {
        $this->db->order_by('idventa', 'desc');       
        return $this->db->get('venta')->result_array();
    }
        

    function addVentas($paramsdatosVenta)
    {
        
        $this->db->insert('venta',$paramsdatosVenta);
        return $this->db->insert_id(); 
    }

    function addDetalleVentas($datosDetalleVenta)
    {
        $this->db->insert('detalle_venta',$datosDetalleVenta);
        return $this->db->insert_id(); 
    }
    

    function anularVenta($idventa,$params)
    {
        $this->db->where('idventa',$idventa);
        $this->db->update('venta',$params);
        $this->db->where('idventa',$idventa);
        $this->db->update('detalle_venta',$params);
    }
    
    function cambiarEstado($idVentas,$params)
    {
        $this->db->where('iddetalle_venta',$idVentas);
        return $this->db->update('detalle_venta',$params);
    }

    function getNotaDeVenta($idventa)
    {
        return $this->db->get_where('venta',array('idventa'=>$idventa))->row_array();
    }

    function generarReporte($de,$hasta)
    {
       $this->db->select('idventa,idcliente,idusuario,serie_comprobante,num_comprobante,fecha_hora,total_venta');
        $this->db->from('venta');
        $this->db->where('fecha_hora >=',$de);
        $this->db->where('fecha_hora <=',$hasta);
        
        return $this->db->get()->result_array();
    }
}
