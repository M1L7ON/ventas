<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ventas</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendors/iconfonts/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="" /> 
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href=""><img src="<?php echo base_url().'/fotos/logo.png'?>" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index-2.html"><img src="images/logo-mini.svg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="<?php echo base_url().'fotos/usuarios/'.$this->session->userdata('s_foto'); ?>" alt="Perfil"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="<?php echo base_url();?>usuario/perfil/<?php echo $this->session->userdata('s_idUsuario'); ?>">
                <i class="fas fa-cog text-primary"></i>
                Ajustes 
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo base_url().'usuario/cerrar_sesion' ?>" class="dropdown-item">
                <i class="fas fa-power-off text-primary"></i>
                Salir
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="profile-image">
                <img src="<?php echo base_url().'fotos/usuarios/'.$this->session->userdata('s_foto'); ?>" alt="image"/>
              </div>
              <div class="profile-name">
                <p class="name">
                  <?php echo $this->session->userdata('s_nombre'); ?> 
                </p>
                <p class="designation">
                  <?php echo $this->session->userdata('s_rol'); ?> 
                </p>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php base_url();?>welcome">
              <i class="fa fa-home menu-icon"></i>
              <span class="menu-title">Inicio</span>
            </a>
          </li>
          <?php 
            if ($this->session->userdata('s_rol')=='Administrador') {
          ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
              <i class="fab fa-trello menu-icon"></i>
              <span class="menu-title">Almacen</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="page-layouts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="<?php echo base_url();?>categoria">Categorías</a></li>
                <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="<?php echo base_url();?>producto">Productos</a></li>
              </ul>
            </div>
          </li>
          <?php } ?>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts" aria-expanded="false" aria-controls="sidebar-layouts">
              <i class="fas fa-columns menu-icon"></i>
              <span class="menu-title">Compras</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="sidebar-layouts">
              <ul class="nav flex-column sub-menu">
                <?php 
                  if ($this->session->userdata('s_rol')=='Administrador') {
                ?>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>proveedor">Proveedores</a></li>
                <?php } ?>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>compras">Compras</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="fa fa-strikethrough menu-icon"></i>
              <span class="menu-title">Ventas</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <?php 
                  if ($this->session->userdata('s_rol')=='Administrador') {
                ?>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>cliente">Clientes</a></li>
                 <?php } ?>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>ventas">Ventas</a></li>
              </ul>
              </div>
          </li>
          <?php 
            if ($this->session->userdata('s_rol')=='Administrador') {
          ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
              <i class="fa fa-users menu-icon"></i>
              <span class="menu-title">Usuarios</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-advanced">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>usuario/index">Lista Usuarios</a></li>
              </ul>
            </div>
          </li>
          <?php  } ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url();?>compras/reporteFechas">
              <i class="far fa-file-alt menu-icon"></i>
              <span class="menu-title">Reporte Compras</span>
            </a>
          </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url();?>ventas/reporteFechas">
              <i class="far fa-file-alt menu-icon"></i>
              <span class="menu-title">Reporte Ventas</span>
            </a>
          </li>
        </ul>
      </nav>