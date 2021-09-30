<?php 
$codeiingniterinstance = &get_instance();
$codeiingniterinstance->load->model('Producto_model');
$totalproductos = $codeiingniterinstance->Producto_model->getAllProductoCount();
$codeiingniterinstance->load->model('Proveedor_model');
$totalproveedores = $codeiingniterinstance->Proveedor_model->getAllClienteCount();
$codeiingniterinstance->load->model('Cliente_model');
$totalclientes = $codeiingniterinstance->Cliente_model->getAllClienteCount();
$codeiingniterinstance->load->model('Compras_model');
$totalcompras = $codeiingniterinstance->Compras_model->getAllComprasCount();
$codeiingniterinstance->load->model('Ventas_model');
$totalventas = $codeiingniterinstance->Ventas_model->getAllVentasCount();
?>


<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        Bienvenido
      </h3>
    </div>
    <div class="row grid-margin">
      <div class="col-12">
                      <div class="card card-statistics">
                <div class="card-body">
                  <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fa fa-keyboard mr-2"></i>
                          Productos
                        </p>
                        <h2><a href="<?php echo base_url();?>producto"><?php echo $totalproductos;?></a> </h2>
                        
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fas fa fa-address-card mr-2"></i>
                          Proveedores
                        </p>
                        <h2><a href="<?php echo base_url();?>proveedor"><?php echo $totalproveedores;?></a> </h2>

                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fas far fa-address-card mr-2"></i>
                          Clientes
                        </p>
                        <h2><a href="<?php echo base_url();?>cliente"><?php echo $totalclientes;?></a> </h2>
                        
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fas fa-plus-square mr-2"></i>
                          Compras
                        </p>
                        <h2><a href="<?php echo base_url();?>compras"><?php echo $totalcompras;?></a> </h2>
                        
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fas fa-chart-line mr-2"></i>
                          Ventas
                        </p>
                        <h2><a href="<?php echo base_url();?>ventas"><?php echo $totalventas;?></a> </h2>
                      </div>
                  </div>
                </div>
              </div>        
      </div>
    </div>
  </div> <!-- content wrapper -->