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
	            <li class="breadcrumb-item active" aria-current="page">Modificar Usuario</li>
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
    		<?php echo form_open('usuario/edit',array("class"=>"forms-sample","enctype"=>"multipart/form-data")); ?>
    				<div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nombre</label>
                      <div class="col-sm-5">
                      	<input type="hidden" class="form-control" name="idUsuario" id="idUsuario" value="<?php echo $usuario['idUsuario'];?>">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre Completo" value="<?php echo $usuario['nombre'];?>">
                        <span class="text-danger"><?php echo form_error('nombre');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">CI</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="ci" placeholder="CI" value="<?php echo $usuario['ci'];?>">
                        <span class="text-danger"><?php echo form_error('ci');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Dirección</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="direccion" placeholder="Dirección" value="<?php echo $usuario['direccion'];?>">
                        <span class="text-danger"><?php echo form_error('direccion');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Telefono</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="telefono" placeholder="Telefono" value="<?php echo $usuario['telefono'];?>">
                        <span class="text-danger"><?php echo form_error('telefono');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-3">
                        <input type="hidden" class="form-control" name="cargo" placeholder="Cargo" value="<?php echo $usuario['cargo'];?>">
                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $usuario['email'];?>">
                        <span class="text-danger"><?php echo form_error('email');?></span>
                      </div>
                    </div>
    				<div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Usuario</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="login" placeholder="Nombre Usuario" value="<?php echo $usuario['login'];?>" readonly>
                        <span class="text-danger"><?php echo form_error('login');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Contraseña</label>
                      <div class="col-sm-2">
                        <input type="password" class="form-control" name="clave" placeholder="Contraseña" value="">
                        <input type="hidden" class="form-control" name="rol" value="<?php echo $usuario['rol'];?>">
                        <span class="text-danger"><?php echo form_error('clave');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Foto</label>
                      <div class="input-group col-sm-6">
                        <input type="hidden" class="form-control" name="foto1" value="<?php echo $usuario['foto'];?>">
                        <input type="file" class="form-control-file" name="archivo" id="archivo">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <a href="<?php echo base_url().'welcome'; ?>" class="btn btn-light">Cancelar</a>
    		<?php echo form_close(); ?>
      	</div>
    </div>
  </div> <!-- content wrapper -->
