<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
        <div class="pull-right">
                    <a href="<?php echo base_url(); ?>ventas/insert" class="btn btn-success"><span class="fa fa-plus-circle" aria-hidden="true"></span> Nueva Venta</a> 
                    <a href="<?php echo base_url();?>ventas/reporteVentas" target="_blank" class="btn btn-info">
                    <span class="fa fa-print" aria-hidden="true"></span> Imprimir Lista</a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'welcome'; ?>">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lista Ventas</li>
            </ol>
        </nav>
    </div>

    <div class="row grid-margin">
      <div class="col-12">
        <div class="row">
                <br>
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Serie</th>
                            <th>Número</th>
                            <th>Fecha</th>
                            <th>Total Venta</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; 
                        $codeIgniterInstace = &get_instance();
                        $codeIgniterInstace->load->model('Producto_model');
                        foreach ($ventas  as $row) { 
                        ?>
                        <tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo $row['serie_comprobante']; ?></td>
                            <td><?php echo $row['num_comprobante']; ?></td>
                            <td><?php echo date_format(date_create($row['fecha_hora']),"d/m/Y"); ?></td>
                            <td><?php echo $row['total_venta']; ?></td>
                            <td>
                                <?php 
                                if ($row['condicion']==1) {
                                ?>
                                <span class='badge badge-success badge-pill'>Activo</span>
                                <?php
                                    }else{
                                ?>
                                <span class="badge badge-warning badge-pill">Cancelado</span>
                                <?php 
                                }
                                ?>
                                    
                            </td>
                            <td>
                                <span class="pull-right">
                                  <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Acciones
                                    <span class="caret"></span>
                                    </button>
                                     <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                         <li>
                                            <a href="<?php echo base_url().'ventas/notaDeVenta/'.$row['idventa']; ?>"
                                                title="Imprimir Nota de Venta" target="_blank">
                                                &nbsp <i style="color:#555;" class="fa fa-print"></i> Imprimir Nota de Venta
                                             </a>
                                         </li>
                                         <li>
                                             <a href="<?php echo base_url().'ventas/anularCompra/'.$row['idventa']; ?>"
                                                title="Cancelar Compra" onClick="">
                                                &nbsp <i style="color:#555;" class="fa fa-edit"></i> Anular Compra
                                             </a>
                                         </li>
                                     </ul>
                                  </div>
                            </span>
                            </td>                           
                        </tr>                       
                        <?php $i++; } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
      </div>
    </div>
  </div> <!-- content wrapper -->
