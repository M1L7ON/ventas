<div class="main-panel">

  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        Bienvenido
      </h3>
      <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="<?php echo base_url().'welcome'; ?>">Inicio</a></li>
	            <li class="breadcrumb-item"><a href="<?php echo base_url().'categoria'; ?>">Lista Categorías</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Editar Categoría</li>
            </ol>
      </nav>
    </div>
    <div class="row grid-margin">
      	<div class="col-12">
          <?php
          if (!empty($mensaje)) {
          ?>
            <div class="alert alert-danger">
             La categoría No se encuentra registrada
           </div>
          <?php } ?>
    		  <?php echo form_open(base_url().'categoria/editarDB',array("class"=>"forms-sample","enctype"=>"multipart/form-data")); ?>
    				<div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nombre</label>
                      <div class="col-sm-4">
                        <input type="hidden" class="form-control" name="idcategoria" value="<?php echo $categoria['idcategoria']; ?>">
                        <input type="text" class="form-control" name="nombre" value="<?php echo $categoria['nombre']; ?>">
                        <span class="text-danger"><?php echo form_error('nombre');?></span>
                      </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Descripción Categoría</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="descripcion" value="<?php echo $categoria['descripcion']; ?>">
                        <span class="text-danger"><?php echo form_error('descripcion');?></span>
                      </div>
                    </div>


                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <a href="<?php echo site_url('categoria'); ?>" class="btn btn-light">Cancelar</a>
    		<?php echo form_close(); ?>
      	</div>
    </div>
  </div> <!-- content wrapper -->