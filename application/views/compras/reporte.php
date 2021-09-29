<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'welcome'; ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url().'compras'; ?>">Lista Compras</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte Compras</li>
            </ol>
      </nav>
    </div>
    <div class="row grid-margin">
      <div class="col-12 grid-margin">
        <div class="card">
                <div class="card-body">
                  <?php
                  if (!empty($mensaje)) {
                  ?>
                  <div class="alert alert-danger">
                   <?php echo $mensaje; ?>
                  </div>
                  <?php } ?>
                  <h4 class="card-title">Reporte de Compras</h4>
                  <form enctype="multipart/form-data" action="<?php echo base_url().'compras/generarReporte'?>" method="POST" target="_blank">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">De:</label>
                          <div class="col-sm-9">
                            <input type="date" id="date" name="de" value="">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Hasta:</label>
                          <div class="col-sm-9">
                              <input type="date" name="hasta" id="date" name="de" value="">
                          </div>
                        </div>
                      </div>
                    </div>                   
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Generar Reporte</button>
                            <a href="<?php echo base_url().'compras'; ?>" class="btn btn-light">Cancelar</a>
                          </div>
                          </div>
                  </form>
                </div>
              </div>
      </div>
    </div>
  </div> <!-- content wrapper -->
