<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        Bienvenido
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo site_url('welcome'); ?>">Inicio</a></li>
	            <li class="breadcrumb-item"><a href="<?php echo site_url('usuario'); ?>">Lista Usuarios</a></li>
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
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nombre</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre Completo">
                        <span class="text-danger"><?php echo form_error('nombre');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">CI</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="ci" placeholder="CI">
                        <span class="text-danger"><?php echo form_error('ci');?></span>
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
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="telefono" placeholder="Telefono">
                        <span class="text-danger"><?php echo form_error('telefono');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-3">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <span class="text-danger"><?php echo form_error('email');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Cargo</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="cargo" placeholder="Cargo">
                        <span class="text-danger"><?php echo form_error('cargo');?></span>
                      </div>
                    </div>
    				<div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Usuario</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="login" placeholder="Nombre Usuario">
                        <span class="text-danger"><?php echo form_error('login');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Contraseña</label>
                      <div class="col-sm-2">
                        <input type="password" class="form-control" name="clave" placeholder="Contraseña">
                        <span class="text-danger"><?php echo form_error('clave');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Rol</label>
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