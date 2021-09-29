<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'welcome'; ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url().'compras'; ?>">Lista Comprar productos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Comprar productos</li>
            </ol>
      </nav>
    </div>
    <div class="row grid-margin">
      <div class="col-12 grid-margin">
        <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Compra de productos</h4>
                  <form enctype="multipart/form-data" action="<?php echo base_url().'compras/guardarDB'?>" method="POST">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Proveedor</label>
                          <div class="col-sm-9">
                            <select id="idproveedor" name="idproveedor" class="js-example-basic-single w-100">
                            <?php foreach ($proveedor as $row) { ?>
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
                          <span class="text-danger"><?php echo form_error('fecha_hora');?></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nota de compra</label>
                          <div class="col-sm-9">
                            <input type="text" name="tipo_comprobante" class="form-control" value="Nota de compra" readonly />
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
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; foreach ($producto  as $row) { ?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td> 
                              <input type="hidden" name="idarticulo[]" value="<?php echo $row['idarticulo']; ?>" >
                              <input type="number" name="cantidad[]" id="cantidad[]" value="<?php echo 0; ?>" >
                            </td>
                            <td>
                              <input type="number" name="precio_compra[]" id="precio_compra[]" step="0.01" value="<?php echo 0.00; ?>" >
                            </td>
                            <td> 
                            <input type="number" name="precio_venta[]" id="precio_venta[]" step="0.01" value="<?php echo 0.00; ?>" >                                   
                            </td>
                        </tr>                       
                        <?php $i++; } ?>
                      </tbody>
                    </table>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                          <a href="<?php echo base_url().'compras'; ?>" class="btn btn-light">Cancelar</a>
                          </div>
                  </form>
                </div>
              </div>
      </div>
    </div>
  </div> <!-- content wrapper -->

