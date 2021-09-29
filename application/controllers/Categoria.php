<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Categoria extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Categoria_model');
        require_once  APPPATH.'controllers/PDF_MC_Table.php';
    } 


    function index()
    {
        $data['categoria'] = $this->Categoria_model->getAllCategoria();      
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
            
            $categoria_id = $this->Categoria_model->addCategoria($params);
            redirect(base_url().'categoria/index');
        }
        else
        {            
            $this->load->view('layout/header');
            $this->load->view('categorias/add');
            $this->load->view('layout/footer');
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

                $this->Categoria_model->updateCategoria($idcategoria,$params);            

                redirect(base_url().'categoria/index');
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
		$this->form_validation->set_rules('nombre','Nombre','required|max_length[50]|alpha');
		$this->form_validation->set_rules('descripcion','Descripcion','max_length[200]');
    }

    public function reporteCategoria()
    {
        $data = $this->Categoria_model->getCategoriasReporte();     
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
        $this->pdf->Cell(160,10,utf8_decode('LISTA DE CATEGORÍAS'),0,0,'C');

        $this->pdf->Ln(10);

        $this->pdf->Cell(10,5,utf8_decode("No."),'TBLR',0,'L',1);
        $this->pdf->Cell(60,5,utf8_decode("NOMBRE CATEGORÍA"),'TBLR',0,'L',1);
        $this->pdf->Cell(110,5,utf8_decode("DESCRIPCIÓN"),'TBLR',0,'L',1);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','',12);
        $indice=1;
        foreach ($data as $row) {
            $this->pdf->Cell(10,5,utf8_decode($indice),'TBLR',0,'L',1);
            $this->pdf->Cell(60,5,utf8_decode($row->nombre),'TBLR',0,'L',1);
            $this->pdf->Cell(110,5,utf8_decode($row->descripcion),'TBLR',0,'L',1);
            $this->pdf->Ln(5);
            $indice++;
        }

        $this->pdf->Output("listacategoria.pdf","I");
    }
    
}
