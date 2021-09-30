<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase Cliente_model
 *
 * @autor Oscar Perez
 * @version 1.0
 */
class Compras_model extends CI_Model
{
    /**
     * Compras_model constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * GetDetalleIngreso.
     * @param $idingreso Id del la compra.
     * @return result_array con di.idingreso, di.idarticulo,di.cantidad,di.precio_compra, di.precio_venta.
     */
    function getDetalleIngreso($idingreso)
    {
        $this->db->select('di.idingreso, di.idarticulo,di.cantidad,di.precio_compra, di.precio_venta, a.codigo, a.nombre');
        $this->db->from('detalle_ingreso di');
        $this->db->join('articulo a','a.idarticulo = di.idarticulo');
        $this->db->Where('di.idingreso',$idingreso); 
        return $this->db->get()->result_array();
    }

    /**
     * GetIngreso.
     * @param $$idingreso Id de la compra.
     * @return row_array con datos de un cliente.
     */
    function getIngreso($idingreso)
    {
        return $this->db->get_where('ingreso',array('idingreso'=>$idingreso))->row_array();
    }

    /**
     * GetPrecioVenta
     * @param $idarticulo id del Producto
     * @return row_array con precio_venta
     */
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

    /**
     * getAllComprasCount.
     * @return entero Cantidad de compras.
     */
    function getAllComprasCount()
    {
        $this->db->from('ingreso');
        return $this->db->count_all_results();
    }

    /**
     * getAllCompras.
     * @return result_array con datos de varias compras.
     */
    function getAllCompras()
    {
        $this->db->order_by('idingreso', 'desc');       
        return $this->db->get('ingreso')->result_array();
    }

    /**
     * AddCliente.
     * @param $paramsdatosIngreso Datos de los campos de la base de datos y su valor a guardar.
     * @return Id del ultima compra guardada.
     */
    function addCompras($paramsdatosIngreso)
    {
        
        $this->db->insert('ingreso',$paramsdatosIngreso);
        return $this->db->insert_id(); 
    }

    /**
     * AddDetalleIngreso.
     * @param $datosDetalleIngreso Datos de los campos de la base de datos y su valor a guardar..
     * @return Id del ultima registro guardado.
     */
    function addDetalleIngreso($datosDetalleIngreso)
    {
        $this->db->insert('detalle_ingreso',$datosDetalleIngreso);
        return $this->db->insert_id(); 
    }

    /**
     * AnularCompra
     * @param $idingreso
     * @param $params
     */
    function anularCompra($idingreso,$params)
    {
        $this->db->where('idingreso',$idingreso);
        $this->db->update('ingreso',$params);
        $this->db->where('idingreso',$idingreso);
        $this->db->update('detalle_ingreso',$params);
    }

    /**
     * GetNotaDeVenta
     * @param $idingreso
     * @return mixed
     */
    function getNotaDeVenta($idingreso)
    {
        return $this->db->get_where('ingreso',array('idingreso'=>$idingreso))->row_array();
    }

    /**
     * @param $de Fecha
     * @param $hasta Fecha
     * @return result array con i.idingreso,i.idproveedor,i.idusuario,i.serie_comprobante,i.num_comprobante,i.fecha_hora,i.total_compra
     */
    function generarReporte($de,$hasta)
    {
       $this->db->select('i.idingreso,i.idproveedor,i.idusuario,i.serie_comprobante,i.num_comprobante,i.fecha_hora,i.total_compra');
        $this->db->from('ingreso i');
        $this->db->where('fecha_hora >=',$de);
        $this->db->where('fecha_hora <=',$hasta);
        
        return $this->db->get()->result_array();
    }
    
}
