<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Categoria extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Categoria_model');
    } 


    function index()
    {
        $data['categoria'] = $this->Categoria_model->get_all_categoria();      
        $this->load->view('layout/header');
        $this->load->view('categorias/index',$data);
        $this->load->view('layout/footer');
    }

    function insert()
    {
        $this->load->view('layout/header');
        $this->load->view('categorias/add');
        $this->load->view('layout/footer');
    }

    function editar($idcategoria)
    {
    	$data['categoria'] = $this->Categoria_model->getCategoria($idcategoria);
    	$this->load->view('layout/header');
        $this->load->view('categorias/edit',$data);
        $this->load->view('layout/footer');
    }

    function guardarDB()
    {   
        $this->formValidation();
		if($this->form_validation->run())     
        {   
            $params = array(
				'nombre' => $this->input->post('nombre'),
				'descripcion' => $this->input->post('descripcion'),
            );
            
            $categoria_id = $this->Categoria_model->add_categoria($params);
            redirect('categoria/index');
        }
        else
        {            
            $data['_view'] = 'categoria/add';
            $this->load->view('layouts/main',$data);
        }
    }  


    function editarDB()
    {   
    		$idcategoria = $this->input->post('idcategoria');
        
        	$this->formValidation();
			if($this->form_validation->run())     
            {   
                $params = array(
					'nombre' => $this->input->post('nombre'),
					'descripcion' => $this->input->post('descripcion'),
            	);

                $this->Categoria_model->update_categoria($idcategoria,$params);            

                redirect('categoria/index');
            }
            else
            {
                $data['categoria'] = $this->Categoria_model->getCategoria($idcategoria);
		    	$this->load->view('layout/header');
		        $this->load->view('categorias/edit',$data);
		        $this->load->view('layout/footer');
            }
        
    } 


    function cambiarEstado($idcategoria,$activo)
    {
   			$params = array(
					'condicion' => $activo,
           	);

            $this->Categoria_model->cambiarEstado($idcategoria,$params);
            redirect('categoria/index');
    }

    public function formValidation()
    {
      	$this->load->library('form_validation');
		$this->form_validation->set_rules('nombre','Nombre','required|max_length[50]');
		$this->form_validation->set_rules('descripcion','Descripcion','max_length[200]');
    }
    
}
