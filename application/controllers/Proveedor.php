<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase Proveedor Controller
 *
 * @autor Moises Patzi
 * @version 1.0
 */
class Proveedor extends CI_Controller{

    /**
     * Constructor Proveedor
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('Proveedor_model');
        require_once  APPPATH.'controllers/PDF_MC_Table.php';
    } 

    /**
     * index Envia a la vista header,index y footer.
     */
    function index()
    {
        $data['cliente'] = $this->Proveedor_model->getAllCliente();

        $this->load->view('layout/header');
        $this->load->view('proveedor/index',$data);
        $this->load->view('layout/footer');
    }

    /**
     * Insert inicia la vista header add y footer para prooveedor.
     */
    function insert()
    {
        $this->load->view('layout/header');
        $this->load->view('proveedor/add');
        $this->load->view('layout/footer');
    }

    function editar($idcliente)
    {
    	$data['cliente'] = $this->Proveedor_model->getProveedor($idcliente);
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
            
            $cliente_id = $this->Proveedor_model->addCliente($params);
            redirect(base_url().'proveedor');
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
    		$idcliente = $this->input->post('idpersona');
        
        	$this->formValidation();
			if($this->form_validation->run())     
            {   
                $params = $this->datos();

                $this->Proveedor_model->updateCliente($idcliente,$params);            
                redirect(base_url().'proveedor');
            }
            else
            {
                $data['cliente'] = $this->Proveedor_model->getCliente($idcliente);
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
            redirect(base_url().'proveedor');
    }

    public function formValidation()
    {
      	$this->load->library('form_validation');
		$this->form_validation->set_rules('nombre','Nombre','required|max_length[50]|callback_alpha_space');
		$this->form_validation->set_rules('num_documento','Ci','max_length[15]');
        $this->form_validation->set_rules('direccion','Dirección','max_length[200]|callback_address');
        $this->form_validation->set_rules('telefono','Telefono','max_length[15]|numeric');
        $this->form_validation->set_rules('email','email','max_length[50]|valid_email');
    }

    public function reporteProveedor()
    {
        $data = $this->Proveedor_model->getProveedorReporte();     
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
        $this->pdf->Cell(120,10,utf8_decode('LISTA DE PROVEEDORES'),0,0,'C');

        $this->pdf->Ln(10);

        $this->pdf->Cell(10,5,utf8_decode("No."),'TBLR',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode("NOMBRE PROVEEDOR"),'TBLR',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode("DIRECCIÓN"),'TBLR',0,'L',1);
        $this->pdf->Cell(25,5,utf8_decode("TELEFONO"),'TBLR',0,'L',1);
        $this->pdf->Cell(45,5,utf8_decode("EMAIL"),'TBLR',0,'L',1);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','',12);
        $indice=1;
        foreach ($data as $row) {
            $this->pdf->Cell(10,5,utf8_decode($indice),'TBLR',0,'L',1);
            $this->pdf->Cell(50,5,utf8_decode($row->nombre),'TBLR',0,'L',1);
            $this->pdf->Cell(50,5,utf8_decode($row->direccion),'TBLR',0,'L',1);
            $this->pdf->Cell(25,5,utf8_decode($row->telefono),'TBLR',0,'L',1);
            $this->pdf->Cell(45,5,utf8_decode($row->email),'TBLR',0,'L',1);
            
            $this->pdf->Ln(5);
            $indice++;
        }

        $this->pdf->Output("listaclientes.pdf","I");
    }

    public function address($str)
    {

        if (preg_match('/^[A-Z0-9áéíóú.# ]+$/i', $str))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('address', 'El campo {field} solo puede contener caracteres alfabéticos . y/o #  .');
            return FALSE;
        }
    }
    
    public function alpha_space($str)
    {

        if (preg_match('/^[A-Záéíóú ]+$/i', $str))
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