<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        Bienvenido
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo base_url().'welcome'; ?>">Inicio</a></li>
	            <li class="breadcrumb-item"><a href="<?php echo base_url().'usuario'; ?>">Lista Usuarios</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Nuevo Usuario</li>
            </ol>
      </nav>
    </div>
    <div class="row grid-margin">
      	<div class="col-12">
          <?php
          if (!empty($mensaje)) {
          ?>
            <div class="alert alert-danger">
             El nombre se usuario se encuentra registrado
           </div>
          <?php } ?>
    		  <?php echo form_open('usuario/add',array("class"=>"forms-sample","enctype"=>"multipart/form-data")); ?>
    				<div class="form-group row">
                    <label for="nombre" class="col-sm-3 col-form-label">Nombre Completo</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="nombre" value="<?php echo $this->input->post('nombre'); ?>">
                        <span class="text-danger"><?php echo form_error('nombre');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="ci" class="col-sm-3 col-form-label">CI</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="ci" value="<?php echo $this->input->post('ci'); ?>">
                        <span class="text-danger"><?php echo form_error('ci');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="direccion" class="col-sm-3 col-form-label">Dirección</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="direccion" value="<?php echo $this->input->post('direccion'); ?>">
                        <span class="text-danger"><?php echo form_error('direccion');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="telefono" class="col-sm-3 col-form-label">Telefono</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="telefono" value="<?php echo $this->input->post('telefono'); ?>">
                        <span class="text-danger"><?php echo form_error('telefono');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-3">
                        <input type="email" class="form-control" name="email" value="<?php echo $this->input->post('email'); ?>">
                        <span class="text-danger"><?php echo form_error('email');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="cargo" class="col-sm-3 col-form-label">Cargo</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="cargo">
                        <span class="text-danger"><?php echo form_error('cargo');?></span>
                      </div>
                    </div>
    				<div class="form-group row">
                    <label for="login" class="col-sm-3 col-form-label">Usuario</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="login" value="<?php echo $this->input->post('login'); ?>">
                        <span class="text-danger"><?php echo form_error('login');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="clave" class="col-sm-3 col-form-label">Contraseña</label>
                      <div class="col-sm-2">
                        <input type="password" class="form-control" name="clave" value="<?php echo $this->input->post('clave'); ?>">
                        <span class="text-danger"><?php echo form_error('clave');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="rol" class="col-sm-3 col-form-label">Rol</label>
                      <div class="col-sm-3">
                        <select id="rol" name="rol" class="js-example-basic-single w-100">
                            <option value="Administrador">Administrador</option>
                            <option value="Vendedor">Vendedor</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Foto</label>
                      <div class="input-group col-sm-6">
                        <input type="file" class="form-control-file" name="archivo" id="archivo">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <a href="<?php echo site_url('usuario'); ?>" class="btn btn-light">Cancelar</a>
    		<?php echo form_close(); ?>
      	</div>
    </div>
  </div> <!-- content wrapper -->