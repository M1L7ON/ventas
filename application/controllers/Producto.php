<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Producto extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Producto_model');
        $this->load->model('Categoria_model');
    } 

    function index()
    {
        $data['producto'] = $this->Producto_model->get_all_Producto();
        $this->load->view('layout/header');
        $this->load->view('producto/index',$data);
        $this->load->view('layout/footer');
    }

    function insert()
    {
        $data['categoria'] = $this->Categoria_model->get_all_categoria();    
        $this->load->view('layout/header');
        $this->load->view('producto/add',$data);
        $this->load->view('layout/footer');
    }

    function editar($idproducto)
    {
    	$data['producto'] = $this->Producto_model->getProducto($idproducto);
    	$this->load->view('layout/header');
        $this->load->view('producto/edit',$data);
        $this->load->view('layout/footer');
    }

    function guardarDB()
    {   
        $this->formValidation();
		if($this->form_validation->run())     
        {   
            $params = $this->datos();
            
            $producto_id = $this->Producto_model->add_Producto($params);
            $data['producto'] = $this->Producto_model->get_all_Producto();
            $this->load->view('layout/header');
            $this->load->view('producto/index',$data);
            $this->load->view('layout/footer');
        }
        else
        {            
            $this->load->view('layout/header');
            $this->load->view('producto/add');
            $this->load->view('layout/footer');
        }
    }  


    function editarDB()
    {   
    		$idproducto = $this->input->post('idproducto');
        
        	$this->formValidation();
			if($this->form_validation->run())     
            {   
                $params = $this->datos();

                $this->Producto_model->update_Producto($idproducto,$params);            
                $data['producto'] = $this->Producto_model->get_all_Producto();
                $this->load->view('layout/header');
                $this->load->view('producto/index',$data);
                $this->load->view('layout/footer');
            }
            else
            {
                $data['producto'] = $this->Producto_model->getProducto($idproducto);
		    	$this->load->view('layout/header');
		        $this->load->view('producto/edit',$data);
		        $this->load->view('layout/footer');
            }
        
    } 

    function cambiarEstado($idproducto,$activo)
    {
            $params = array(
                    'condicion' => $activo,
            );

            $this->Producto_model->cambiarEstado($idproducto,$params);
            $data['producto'] = $this->Producto_model->get_all_Producto();
            $this->load->view('layout/header');
            $this->load->view('producto/index',$data);
            $this->load->view('layout/footer');
    }

    function datos()
    {
        $params = array(
                    'idcategoria' => $this->input->post('idcategoria'),
                    'codigo' => $this->input->post('codigo'),
                    'nombre' => $this->input->post('nombre'),
                    'stock' => $this->input->post('stock'),
                    'descuento' => $this->input->post('descuento'),
                    'descripcion' => $this->input->post('descripcion'),
                    'imagen' => $this->subirImagen(),
                );
        return $params;
    }

    public function formValidation()
    {
      	$this->load->library('form_validation');
        $this->form_validation->set_rules('codigo','Código','max_length[15]');
		$this->form_validation->set_rules('nombre','Nombre','required|max_length[50]');
        $this->form_validation->set_rules('stock','Stock','max_length[7]|numeric');
        $this->form_validation->set_rules('descuento','Descuento','max_length[7]|numeric');
        $this->form_validation->set_rules('descripcion','Descripción','max_length[250]');
    }

    public function subirImagen(){
        $config['upload_path'] = './fotos/productos/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['max_width'] = '2024';
        $config['max_height'] = '2008';

        $this->load->library('upload',$config);

        if (!$this->upload->do_upload("archivo")) {
            $data['uploadError'] = $this->upload->display_errors();
            echo $this->upload->display_errors();
            //return;
            return "sinfoto.jpg";
        } else {

            $file_info = $this->upload->data();
            $imagen = $file_info['file_name'];
            $data['imagen'] = $imagen;
            
            return $imagen;
        }
    }
    
}