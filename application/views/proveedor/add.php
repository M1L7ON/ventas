<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        Bienvenido
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo site_url('welcome'); ?>">Inicio</a></li>
	            <li class="breadcrumb-item"><a href="<?php echo site_url('cliente'); ?>">Lista Proveedores</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Nuevo Proveedor</li>
            </ol>
      </nav>
    </div>
    <div class="row grid-margin">
      	<div class="col-12">
          <?php
          if (!empty($mensaje)) {
          ?>
            <div class="alert alert-danger">
             El cliente se encuentra registrado
           </div>
          <?php } ?>
    		  <?php echo form_open(base_url().'proveedor/guardarDB',array("class"=>"forms-sample","enctype"=>"multipart/form-data")); ?>
    				        <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nombre Completo</label>
                      <div class="col-sm-4">
                        <input type="hidden" class="form-control" name="tipo_persona" value="Proveedor">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre Completo">
                        <span class="text-danger"><?php echo form_error('nombre');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">CI</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="num_documento" placeholder="Ci">
                        <span class="text-danger"><?php echo form_error('num_documento');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Dirección</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="direccion" placeholder="Dirección">
                        <span class="text-danger"><?php echo form_error('direccion');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Telefono</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="telefono" placeholder="Telefono">
                        <span class="text-danger"><?php echo form_error('telefono');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-5">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <span class="text-danger"><?php echo form_error('email');?></span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <a href="<?php echo site_url('categoria'); ?>" class="btn btn-light">Cancelar</a>
    		<?php echo form_close(); ?>
      	</div>
    </div>
  </div> <!-- content wrapper -->