<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Proveedor_model');
    } 


    function index()
    {
        $data['cliente'] = $this->Proveedor_model->get_allcliente();

        $this->load->view('layout/header');
        $this->load->view('proveedor/index',$data);
        $this->load->view('layout/footer');
    }

    function insert()
    {
        $this->load->view('layout/header');
        $this->load->view('proveedor/add');
        $this->load->view('layout/footer');
    }

    function editar($idcliente)
    {
    	$data['cliente'] = $this->Proveedor_model->getcliente($idcliente);
    	$this->load->view('layout/header');
        $this->load->view('proveedor/edit',$data);
        $this->load->view('layout/footer');
    }

    function guardarDB()
    {   
        $this->formValidation();
		if($this->form_validation->run())     
        {   
            $params = $this->datos();
            
            $cliente_id = $this->Proveedor_model->addcliente($params);
            $data['cliente'] = $this->Proveedor_model->get_allcliente();
            $this->load->view('layout/header');
            $this->load->view('proveedor/index',$data);
            $this->load->view('layout/footer');
        }
        else
        {            
            $this->load->view('layout/header');
            $this->load->view('proveedor/add');
            $this->load->view('layout/footer');
        }
    }  


    function editarDB()
    {   
    		$idcliente = $this->input->post('idcliente');
        
        	$this->formValidation();
			if($this->form_validation->run())     
            {   
                $params = $this->datos();

                $this->Proveedor_model->updatecliente($idcliente,$params);            
                $data['cliente'] = $this->Proveedor_model->get_allcliente();
                $this->load->view('layout/header');
                $this->load->view('proveedor/index',$data);
                $this->load->view('layout/footer');
            }
            else
            {
                $data['cliente'] = $this->Proveedor_model->getcliente($idcliente);
		    	$this->load->view('layout/header');
		        $this->load->view('proveedor/edit',$data);
		        $this->load->view('layout/footer');
            }
        
    } 

    function datos()
    {
        $params = array(
                    'tipo_persona' => $this->input->post('tipo_persona'),
                    'nombre' => $this->input->post('nombre'),
                    'num_documento' => $this->input->post('num_documento'),
                    'direccion' => $this->input->post('direccion'),
                    'telefono' => $this->input->post('telefono'),
                    'email' => $this->input->post('email'),
                );
        return $params;
    }

    function cambiarEstado($idcliente,$activo)
    {
   			$params = array(
					'condicion' => $activo,
           	);

            $this->Proveedor_model->cambiarEstado($idcliente,$params);
            $data['cliente'] = $this->Proveedor_model->get_allcliente();
            $this->load->view('layout/header');
            $this->load->view('proveedor/index',$data);
            $this->load->view('layout/footer');
    }

    public function formValidation()
    {
      	$this->load->library('form_validation');
		$this->form_validation->set_rules('nombre','Nombre','required|max_length[50]');
		$this->form_validation->set_rules('num_documento','Ci','max_length[15]');
        $this->form_validation->set_rules('direccion','Dirección','max_length[200]');
        $this->form_validation->set_rules('telefono','Telefono','max_length[15]|numeric');
        $this->form_validation->set_rules('email','email','max_length[50]');
    }
    
}