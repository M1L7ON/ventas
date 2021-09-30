<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Producto extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Producto_model');
        $this->load->model('Categoria_model');
        require_once  APPPATH.'controllers/PDF_MC_Table.php';
    } 

    function index()
    {
        $data['producto'] = $this->Producto_model->getAllProducto();
        $this->load->view('layout/header');
        $this->load->view('producto/index',$data);
        $this->load->view('layout/footer');
    }

    function insert()
    {
        $data['categoria'] = $this->Categoria_model->getAllCategoria();    
        $this->load->view('layout/header');
        $this->load->view('producto/add',$data);
        $this->load->view('layout/footer');
    }

    function editar($idproducto)
    {
    	$data['producto'] = $this->Producto_model->getProducto($idproducto);
        $data['categoria'] = $this->Categoria_model->getAllCategoria();    
    	$this->load->view('layout/header');
        $this->load->view('producto/edit',$data);
        $this->load->view('layout/footer');
    }

    function guardarDB()
    {   
        $this->formValidation();

		if($this->form_validation->run())     
        {   
            if ($this->Producto_model->getCodigo($this->input->post('codigo'))==0) {
                $params = $this->datos();
            
                $producto_id = $this->Producto_model->addProducto($params);
                redirect(base_url().'producto');
            }else{
                $data['categoria'] = $this->Categoria_model->getAllCategoria(); 
                $data['mensaje'] = 'El código de producto se encuentra registrado';
                $this->load->view('layout/header');
                $this->load->view('producto/add',$data);
                $this->load->view('layout/footer');
            }
        }
        else
        {            
            $data['categoria'] = $this->Categoria_model->getAllCategoria();    
            $this->load->view('layout/header');
            $this->load->view('producto/add',$data);
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

                $this->Producto_model->updateProducto($idproducto,$params);            
                redirect(base_url().'producto');
            }
            else
            {
                $data['producto'] = $this->Producto_model->getProducto($idproducto);
                $data['categoria'] = $this->Categoria_model->getAllCategoria();    
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
            redirect(base_url().'producto');
    }

    function datos()
    {
        $foto = '';
        $foto1 = $this->input->post('archivo1');

        if ($foto1=='') {
            if (!empty($_FILES['archivo']['name'])) {
                $foto = $this->subirImagen();
            }else{
                $foto='sinfoto.jpg';
            }
        }else{
            if (!empty($_FILES['archivo']['name'])) {
                $foto = $this->subirImagen();
            }else{
                $foto = $foto1;
            }
        }
        $params = array(
                    'idcategoria' => $this->input->post('idcategoria'),
                    'codigo' => $this->input->post('codigo'),
                    'nombre' => $this->input->post('nombre'),
                    'stock' => $this->input->post('stock'),
                    'descuento' => $this->input->post('descuento'),
                    'descripcion' => $this->input->post('descripcion'),
                    'imagen' => $foto,
                );
        return $params;
    }

    public function formValidation()
    {
      	$this->load->library('form_validation');
        $this->form_validation->set_rules('codigo','Código','max_length[15]|alpha_numeric');
		$this->form_validation->set_rules('nombre','Nombre','required|max_length[45]');
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
    
    public function reporteProducto()
    {
        $data = $this->Producto_model->getProductoReporte();     
        $this->pdf = new \FPDF();
        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(300,300,300);
        $this->pdf->SetXY(31, 11);
        $logo = base_url()."fotos/logo.png";
        $this->pdf->Image($logo, 15, 5, 25, 23);
        $this->pdf->SetFont('Arial','B',8);
        $this->pdf->Cell(5);
        $this->pdf->Cell(160,3,utf8_decode('SYSTEM SOLUTIONS'),0,0,'R');
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Ln(15);
        $this->pdf->Cell(30);
        $this->pdf->Cell(120,10,utf8_decode('LISTA DE PRODUCTOS'),0,0,'C');

        $this->pdf->Ln(10);

        $this->pdf->Cell(10,5,utf8_decode("No."),'TBLR',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode("NOMBRE PRODUCTO"),'TBLR',0,'L',1);
        $this->pdf->Cell(30,5,utf8_decode("CÓDIGO"),'TBLR',0,'L',1);
        $this->pdf->Cell(20,5,utf8_decode("STOCK"),'TBLR',0,'L',1);
        $this->pdf->Cell(70,5,utf8_decode("DESCRIPCIÓN"),'TBLR',0,'L',1);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','',12);
        $indice=1;
        foreach ($data as $row) {
            $this->pdf->Cell(10,5,utf8_decode($indice),'TBLR',0,'L',1);
            $this->pdf->Cell(50,5,utf8_decode($row->nombre),'TBLR',0,'L',1);
            $this->pdf->Cell(30,5,utf8_decode($row->codigo),'TBLR',0,'L',1);
            $this->pdf->Cell(20,5,utf8_decode($row->stock),'TBLR',0,'L',1);
            $this->pdf->Cell(70,5,utf8_decode($row->descripcion),'TBLR',0,'L',1);
            
            $this->pdf->Ln(5);
            $indice++;
        }

        $this->pdf->Output("listaproductos.pdf","I");
    }

    public function alphaSpace($str)
    {

        if (preg_match('/^[A-Za-záéíóú ]+$/i', $str))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('address', 'El campo {field} solo puede contener caracteres alfabéticos . y/o #  .');
            return FALSE;
        }
    }
}