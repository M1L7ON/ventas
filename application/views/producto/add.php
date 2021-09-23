<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        Bienvenido
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo site_url('welcome'); ?>">Inicio</a></li>
	            <li class="breadcrumb-item"><a href="<?php echo site_url('cliente'); ?>">Lista Clientes</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Nuevo Cliente</li>
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
    		  <?php echo form_open(base_url().'producto/guardarDB',array("class"=>"forms-sample","enctype"=>"multipart/form-data")); ?>
    				        <div class="form-group row">
                    <label for="idcategoria" class="col-sm-3 col-form-label">Categoría</label>
                      <div class="col-sm-4">
                        <select id="idcategoria" name="idcategoria" class="js-example-basic-single w-100">
                            <?php foreach ($categoria as $row) { ?>
                                <option value="<?php echo $row['idcategoria']; ?>"><?php echo $row['nombre']; ?></option>
                            <?php } ?>  
                        </select>
                        <span class="text-danger"><?php echo form_error('idcategoria');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="codigo" class="col-sm-3 col-form-label">Código</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="codigo" placeholder="Código">
                        <span class="text-danger"><?php echo form_error('codigo');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="nombre" class="col-sm-3 col-form-label">Nombre del producto</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre del producto">
                        <span class="text-danger"><?php echo form_error('nombre');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="descripcion" placeholder="Descripción">
                        <span class="text-danger"><?php echo form_error('descripcion');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="stock" class="col-sm-3 col-form-label">Stock</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="stock" placeholder="Stock">
                        <span class="text-danger"><?php echo form_error('stock');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="descuento" class="col-sm-3 col-form-label">Descuento</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="descuento" placeholder="Descuento">
                        <span class="text-danger"><?php echo form_error('descuento');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="archivo" class="col-sm-3 col-form-label">Foto</label>
                      <div class="col-sm-5">
                        <input type="file" class="form-control-file" name="archivo" id="archivo">
                        <span class="text-danger"><?php echo form_error('archivo');?></span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <a href="<?php echo site_url('categoria'); ?>" class="btn btn-light">Cancelar</a>
    		<?php echo form_close(); ?>
      	</div>
    </div>
  </div> <!-- content wrapper -->