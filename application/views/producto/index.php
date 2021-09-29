<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
        <div class="pull-right">
                    <a href="<?php echo base_url(); ?>producto/insert" class="btn btn-success">Nuevo Producto</a> 
                    <a href="<?php echo base_url();?>producto/reporteProducto" target="_blank" class="btn btn-info">
                    <span class="fa fa-print" aria-hidden="true"></span> Imprimir Lista</a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'welcome'; ?>">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lista Productos</li>
            </ol>
        </nav>
    </div>

    <div class="row grid-margin">

      <div class="col-12">
        
        <div class="row">
                
                <br>
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>En stock</th>
                            <th>Descuento</th>
                            <th>Foto</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; foreach ($producto  as $row) { ?>
                        <tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo $row['codigo']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td><?php echo $row['descuento']; ?></td>
                            <td><img src="<?php echo base_url().'fotos/productos/'.$row['imagen'];?>"></td>
                            
                            <td>
                                <?php 
                                if ($row['condicion']==1) {
                                ?>
                                <span class='badge badge-success badge-pill'>Activo</span>
                                <?php
                                    }else{
                                ?>
                                <span class="badge badge-warning badge-pill">Inactivo</span>
                                <?php 
                                }
                                ?>
                            </td>
                            <td>
                                <span class="pull-right">
                                  <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Acciones
                                    <span class="caret"></span>
                                    </button>
                                     <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                         <li>
                                             <a href="<?php echo base_url().'producto/editar/'.$row['idarticulo']; ?>"
                                                title="Modificar informacion" onClick="">
                                                &nbsp <i style="color:#555;" class="fa fa-edit"></i> Modificar
                                             </a>
                                         </li>
                                         <li>
                                            <?php 
                                            if ($row['condicion']==1) {
                                            ?>
                                            <a href="<?php echo base_url().'producto/cambiarEstado/'.$row['idarticulo'].'/0'; ?>" >
                                                &nbsp <i style="color:red;" class="fa fa-exclamation-triangle"></i> Inactivo
                                            </a>
                                            <?php
                                                }else{
                                            ?>
                                            <a href="<?php echo base_url().'producto/cambiarEstado/'.$row['idarticulo'].'/1'; ?>" >
                                                &nbsp <i style="color:red;" class="fa fa-exclamation-triangle"></i> Activo
                                            </a>
                                            <?php 
                                            }

                                            ?>
                                         </li>
                                     </ul>
                                  </div>
                            </span>
                            </td>                           
                        </tr>                       
                        <?php $i++; } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

      </div>
    </div>
  </div> <!-- content wrapper -->
