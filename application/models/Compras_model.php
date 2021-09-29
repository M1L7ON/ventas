<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
class Compras_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function getDetalleIngreso($idingreso)
    {
        $this->db->select('di.idingreso, di.idarticulo,di.cantidad,di.precio_compra, di.precio_venta, a.codigo, a.nombre');
        $this->db->from('detalle_ingreso di');
        $this->db->join('articulo a','a.idarticulo = di.idarticulo');
        $this->db->Where('di.idingreso',$idingreso); 
        return $this->db->get()->result_array();
    }
    
    function getIngreso($idingreso)
    {
        return $this->db->get_where('ingreso',array('idingreso'=>$idingreso))->row_array();
    }

    function getPrecioVenta($idarticulo)
    {
        $this->db->SELECT('idingreso,idarticulo,cantidad,precio_compra,precio_venta');
        $this->db->FROM('detalle_ingreso');
        $this->db->WHERE('idarticulo',$idarticulo);
        $this->db->ORDER_BY('iddetalle_ingreso','desc');
        $this->db->LIMIT(1);
        return $this->db->get()->row_array();
        //return $this->db->get_where('detalle_ingreso',array('idarticulo'=>$idarticulo))->row_array();
    }

    function getAllComprasCount()
    {
        $this->db->from('ingreso');
        return $this->db->count_all_results();
    }
        

    function getAllCompras()
    {
        $this->db->order_by('idingreso', 'desc');       
        return $this->db->get('ingreso')->result_array();
    }
        

    function addCompras($paramsdatosIngreso)
    {
        
        $this->db->insert('ingreso',$paramsdatosIngreso);
        return $this->db->insert_id(); 
    }

    function addDetalleIngreso($datosDetalleIngreso)
    {
        $this->db->insert('detalle_ingreso',$datosDetalleIngreso);
        return $this->db->insert_id(); 
    }
    

    function anularCompra($idingreso,$params)
    {
        $this->db->where('idingreso',$idingreso);
        $this->db->update('ingreso',$params);
        $this->db->where('idingreso',$idingreso);
        $this->db->update('detalle_ingreso',$params);
    }
    
    function cambiarEstado($idingreso,$params)
    {
        $this->db->where('iddetalle_ingreso',$idingreso);
        return $this->db->update('detalle_ingreso',$params);
    }

    function getNotaDeVenta($idingreso)
    {
        return $this->db->get_where('ingreso',array('idingreso'=>$idingreso))->row_array();
    }

    function generarReporte($de,$hasta)
    {
       $this->db->select('i.idingreso,i.idproveedor,i.idusuario,i.serie_comprobante,i.num_comprobante,i.fecha_hora,i.total_compra');
        $this->db->from('ingreso i');
        $this->db->where('fecha_hora >=',$de);
        $this->db->where('fecha_hora <=',$hasta);
        
        return $this->db->get()->result_array();
    }
    
}
