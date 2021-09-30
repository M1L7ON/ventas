<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'welcome'; ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url().'ventas'; ?>">Lista Vender productos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vender productos</li>
            </ol>
      </nav>
    </div>
    <div class="row grid-margin">
      <div class="col-12 grid-margin">
        <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Vender productos</h4>
                  <form enctype="multipart/form-data" action="<?php echo base_url().'ventas/guardarDB'?>" method="POST">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Cliente</label>
                          <div class="col-sm-9">
                            <select id="idcliente" name="idcliente" class="js-example-basic-single w-100">
                            <?php foreach ($cliente as $row) { ?>
                                <option value="<?php echo $row['idpersona']; ?>"><?php echo $row['nombre']; ?></option>
                            <?php } ?>  
                        </select>
                        <span class="text-danger"><?php echo form_error('idproveedor');?></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Fecha</label>
                          <div class="col-sm-9">
                            <div id="datepicker-popup" class="input-group date datepicker">
                            <input type="text" name="fecha_hora" class="form-control">
                            <span class="input-group-addon input-group-append border-left">
                              <span class="far fa-calendar input-group-text"></span>
                            </span>
                            </div>
                            <span class="text-danger"><?php echo form_error('fecha_hora');?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nota de venta</label>
                          <div class="col-sm-9">
                            <input type="text" name="tipo_comprobante" class="form-control" value="Nota de venta" readonly />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Serie</label>
                          <div class="col-sm-4">
                            <input type="text" name="serie_comprobante" class="form-control" value="SYSSOL-V" readonly />
                          </div>
                          <label class="col-sm-2 col-form-label">Número</label>
                          <div class="col-sm-4">
                            <input type="text" name="num_comprobante" class="form-control" value="<?php echo $numero + 1000; ?>" readonly /> 
                          </div>
                        </div>
                      </div>
                    </div>              
                 
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Venta</th>
                            <th>Precio Descuento</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $codeIgniterInstace = &get_instance();
                        $codeIgniterInstace->load->model('Compras_model');
                        
                        $i = 1; 
                        foreach ($producto  as $row) {
                          $precio = $codeIgniterInstace->Compras_model->getPrecioVenta($row['idarticulo']);
                        ?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td> 
                              <input type="hidden" name="idarticulo[]" value="<?php echo $row['idarticulo']; ?>" >
                              <input type="number" name="cantidad[]" id="cantidad[]" value="<?php echo 0; ?>" >
                            </td>
                            <td>
                              <input type="number" name="precio_venta[]" id="precio_venta[]" step="0.01" value="<?php echo $precio['precio_venta']; ?>" readonly>
                            </td>
                            <td> 
                            <input type="number" name="descuento[]" id="descuento[]" step="0.01" value="<?php echo $row['descuento']; ?>" readonly>                                   
                            </td>
                        </tr>                       
                        <?php $i++; } ?>
                      </tbody>
                    </table>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <a href="<?php echo base_url().'ventas'; ?>" class="btn btn-light">Cancelar</a>
                          </div>
                  </form>
                </div>
              </div>
      </div>
    </div>
  </div> <!-- content wrapper -->

