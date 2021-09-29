<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        Bienvenido
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo base_url().'welcome'; ?>">Inicio</a></li>
	            <li class="breadcrumb-item"><a href="<?php echo base_url().'proveedor'; ?>">Lista Proveedores</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Editar Proveedor</li>
            </ol>
      </nav>
    </div>
    <div class="row grid-margin">
      	<div class="col-12">
          <?php
          if (!empty($mensaje)) {
          ?>
            <div class="alert alert-danger">
             El proveedor NO se encuentra registrado
           </div>
          <?php } ?>
    		  <?php echo form_open(base_url().'proveedor/editarDB',array("class"=>"forms-sample","enctype"=>"multipart/form-data")); ?>
    				        <div class="form-group row">
                    <label for="nombre" class="col-sm-3 col-form-label">Nombre Completo</label>
                      <div class="col-sm-4">
                        <input type="hidden" class="form-control" name="idpersona" value="<?php echo $cliente['idpersona']; ?>">
                        <input type="hidden" class="form-control" name="tipo_persona" value="<?php echo $cliente['tipo_persona']; ?>">
                        <input type="text" class="form-control" name="nombre" value="<?php echo $cliente['nombre']; ?>">
                        <span class="text-danger"><?php echo form_error('nombre');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="num_documento" class="col-sm-3 col-form-label">CI</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="num_documento" value="<?php echo $cliente['num_documento']; ?>">
                        <span class="text-danger"><?php echo form_error('num_documento');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="direccion" class="col-sm-3 col-form-label">Dirección</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="direccion" value="<?php echo $cliente['direccion']; ?>">
                        <span class="text-danger"><?php echo form_error('direccion');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="telefono" class="col-sm-3 col-form-label">Telefono</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="telefono" value="<?php echo $cliente['telefono']; ?>">
                        <span class="text-danger"><?php echo form_error('telefono');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-5">
                        <input type="email" class="form-control" name="email" value="<?php echo $cliente['email']; ?>">
                        <span class="text-danger"><?php echo form_error('email');?></span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <a href="<?php echo base_url().'proveedor'; ?>" class="btn btn-light">Cancelar</a>
    		<?php echo form_close(); ?>
      	</div>
    </div>
  </div> <!-- content wrapper -->