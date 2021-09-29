<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Compras_model');
        $this->load->model('Proveedor_model');
        $this->load->model('Producto_model');
        require_once  APPPATH.'controllers/PDF_MC_Table.php';
    } 

    function index()
    {
        $data['compras'] = $this->Compras_model->getAllCompras();

        $this->load->view('layout/header');
        $this->load->view('compras/index',$data);
        $this->load->view('layout/footer');
    }

    function insert()
    {
    	$data['proveedor'] = $this->Proveedor_model->getAllCliente();
    	$data['producto'] = $this->Producto_model->getAllProducto();
    	$data['numero'] = $this->Compras_model->getAllComprasCount();
        $this->load->view('layout/header');
        $this->load->view('compras/add',$data);
        $this->load->view('layout/footer');
    }

    function editar($idcliente)
    {
    	$data['cliente'] = $this->Compras_model->getCliente($idcliente);
    	$this->load->view('layout/header');
        $this->load->view('compras/edit',$data);
        $this->load->view('layout/footer');
    }

    function reporteFechas()
    {
        $this->load->view('layout/header');
        $this->load->view('compras/reporte');
        $this->load->view('layout/footer');
    }

    function guardarDB()
    {   
        $this->formValidation();
		if($this->form_validation->run())     
        {   
            $cantidad = $this->input->post('cantidad');
            $precio_compra = $this->input->post('precio_compra');
            $precio_venta = $this->input->post('precio_venta');
            $idarticulo = $this->input->post('idarticulo');
            $paramsDatosIngreso = $this->datosIngreso();
           
            $idingreso = $this->Compras_model->addCompras($paramsDatosIngreso);
            for($i = 0; $i < sizeof($cantidad); $i++) {
                if ($cantidad[$i]>0 && $precio_compra[$i]>0 && $precio_venta[$i]>0) {
                    echo $idarticulo[$i].'<br>';
                    $paramsDatosDetalleIngreso = array(
                        'idingreso' => $idingreso,
                        'idarticulo' => $idarticulo[$i],
                        'cantidad' => $precio_compra[$i],
                        'precio_compra' => $precio_compra[$i],
                        'precio_venta' => $precio_venta[$i],
                    );
                    $id = $this->Compras_model->addDetalleIngreso($paramsDatosDetalleIngreso);
                }    
            }
            
            redirect(base_url().'compras');
        }
        else
        {            
            $data['proveedor'] = $this->Proveedor_model->getAllCliente();
            $data['producto'] = $this->Producto_model->getAllProducto();
            $data['numero'] = $this->Compras_model->getAllComprasCount();
            $this->load->view('layout/header');
            $this->load->view('compras/add',$data);
            $this->load->view('layout/footer');
        }
    }  

    function anularCompra($anularCompra)
    {   
        $parametrosAnular = array(
                    'condicion' => 0,
        );
        $this->Compras_model->anularCompra($anularCompra,$parametrosAnular);
        redirect(base_url().'compras');
    } 

    function datosIngreso()
    {
        $cantidad = $this->input->post('cantidad');
        $precio_compra = $this->input->post('precio_compra');
        $total_compra = 0;
        for($i = 0; $i < sizeof($cantidad); $i++){
            $total_compra += $cantidad[$i] * $precio_compra[$i];
        }
        $params = array(
                    'idproveedor' => $this->input->post('idproveedor'),
                    'idusuario' => $this->session->userdata('s_idUsuario'),
                    'fecha_hora' => date_format(date_create($this->input->post('fecha_hora')),"Y/m/d"),
                    'tipo_comprobante' => $this->input->post('tipo_comprobante'),
                    'serie_comprobante' => $this->input->post('serie_comprobante'),
                    'num_comprobante' => $this->input->post('num_comprobante'),
                    'total_compra' => $total_compra,
                );
        return $params;
    }

    function datosDetalleIngreso()
    {
        $params = array(
                    'idingreso' => 0,
                    'idarticulo' => $this->input->post('idarticulo'),
                    'cantidad' => $this->input->post('cantidad'),
                    'precio_compra' => $this->input->post('precio_compra'),
                    'precio_venta' => $this->input->post('precio_venta'),
                );
        return $params;
    }

    function cambiarEstado($idcliente,$activo)
    {
   			$params = array(
					'condicion' => $activo,
           	);

            $this->Compras_model->cambiarEstado($idcliente,$params);
            $data['cliente'] = $this->Compras_model->get_allcliente();
            $this->load->view('layout/header');
            $this->load->view('compras/index',$data);
            $this->load->view('layout/footer');
    }

    public function formValidation()
    {
      	$this->load->library('form_validation');
		$this->form_validation->set_rules('fecha_hora','Fecha','required');
		$this->form_validation->set_rules('tipo_comprobante','Nota de venta','required');
        $this->form_validation->set_rules('serie_comprobante','Serie','required');
        $this->form_validation->set_rules('num_comprobante','Número de comprobante','required');
    }

    public function notaDeVenta($idingreso)
    {
        $data = $this->Compras_model->getNotaDeVenta($idingreso); 
        $proveedor = $this->Proveedor_model->getProveedor($data['idproveedor']);
        $compra = $this->Compras_model->getIngreso($data['idingreso']);
        $this->pdf = new PDF_MC_Table();
        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();
        $logo      = base_url()."fotos/logo.png";
        $anulado   = base_url()."fotos/anulado.png";
        $empresa   = utf8_decode('SYSTEM SOLUTIONS');
        $documento = "N.I.T.: 3728236018";
        $direccion = utf8_decode("Dirección: Calle Venezuela # 389");
        $telefono  = utf8_decode("Número de Telefono: 4390035");
        $email     = "Email: systemsoluction@msn.com";
        $x1        = 30;
        $y1        = 8;
        $this->pdf->Image($logo, 3, 5, 25, 23);
        if ($data['condicion']==0) {
            $this->pdf->Image($anulado, 60, 35, 90,90);
        }
        ///////////////////////// datos de la empresa ////////////////////////////////
        $this->pdf->SetXY($x1, $y1);
        $this->pdf->SetFont('Arial', 'B', 12);
        $length = $this->pdf->GetStringWidth($empresa);
        $this->pdf->Cell($length, 2, $empresa);
        ///////
        $this->pdf->SetXY($x1, $y1 + 4);
        $this->pdf->SetFont('Arial', '', 10);
        $length = $this->pdf->GetStringWidth($documento);
        $this->pdf->Cell($length, 2, $documento);
        ///////
        $this->pdf->SetXY($x1, $y1 + 8);
        $this->pdf->SetFont('Arial', '', 10);
        $length = $this->pdf->GetStringWidth($telefono);
        $this->pdf->Cell($length, 2, $email);
        ///////
        $this->pdf->SetXY($x1, $y1 + 12);
        $this->pdf->SetFont('Arial', '', 10);
        $length = $this->pdf->GetStringWidth($email);
        $this->pdf->Cell($length, 2, $telefono);
        ///////
        $this->pdf->SetXY($x1, $y1 + 16);
        $this->pdf->SetFont('Arial', '', 10);
        $length = $this->pdf->GetStringWidth($direccion);
        $this->pdf->Cell($length, 2, $direccion);
        ///////////////////////// fin datos de la empresa //////////////////////////////
        ///////////////////////// datos del proveedor //////////////////////////////////
        //Obtenemos los datos de la cabecera de la venta actual
        $r1   = 10;
        $r2   = $r1 + 68;
        $y1   = 40;
        $this->pdf->SetXY($r1, $y1);
        $this->pdf->SetFont("Arial", "B", 10);
        $this->pdf->MultiCell(60, 4, "Proveedor");
        $this->pdf->SetXY($r1, $y1 + 5);
        $this->pdf->SetFont("Arial", "", 10);

        $this->pdf->MultiCell(150, 4, utf8_decode($proveedor['nombre']));
        $this->pdf->SetXY($r1, $y1 + 10);
        $this->pdf->MultiCell(150, 4, utf8_decode("Dirección: ").utf8_decode($proveedor['direccion']));
        $this->pdf->SetXY($r1, $y1 + 15);
        $this->pdf->MultiCell(150, 4, "NIT: " . utf8_decode($proveedor['num_documento']));
        $this->pdf->SetXY($r1, $y1 + 20);
        $this->pdf->MultiCell(150, 4, "Email: " . utf8_decode($proveedor['email']));
        $this->pdf->SetXY($r1, $y1 + 25);
        $this->pdf->MultiCell(150, 4, "Telefono: " . $proveedor['telefono']);
        ///////////////////////// fin datos del proveedor //////////////////////////////
        ///////////////////////// Inicio recibo y fecha  //////////////////////////////
        $r1 = 220 - 90;
        $r2 = $r1 + 68;
        $y1 = 6;
        $y2 = $y1 + 2;
        $this->pdf->SetFillColor(72, 209, 204);
        $this->pdf->SetXY($r1 + 1, $y1 + 5);
        $this->pdf->Cell($r2 - $r1 - 1, 5, 'NOTA DE COMPRA '.$compra['serie_comprobante'].'-'.$compra['num_comprobante'], 1, 2, "C");
        $this->pdf->Ln(5);
        $this->pdf->SetXY($r1 + 1, $y1 + 11);
        $originalDate = $compra['fecha_hora'];
        $newDate = date("d/m/Y", strtotime($originalDate));
        $this->pdf->Cell($r2 - $r1 - 1, 5, 'Fecha: '.$newDate, 0, 0, "C");
        ///////////////////////// Fin recibo y fecha //////////////////////////////
        $this->pdf->Ln(55);
        
        //Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
        $this->pdf->SetFillColor(232, 232, 232);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(10, 6, utf8_decode('Nº'), 1, 0, 'L', 1);
        $this->pdf->Cell(25, 6, utf8_decode('Código'), 1, 0, 'L', 1);
        $this->pdf->Cell(75, 6, utf8_decode('Descripción'), 1, 0, 'L', 1);
        $this->pdf->Cell(20, 6, utf8_decode('Cantidad'), 1, 0, 'L', 1);
        $this->pdf->Cell(30, 6, 'Precio Compra', 1, 0, 'L', 1);
        $this->pdf->Cell(25, 6, utf8_decode('Sub Total'), 1, 0, 'L', 1);

        $this->pdf->Ln(6);
        //Comenzamos a crear las filas de los registros según la consulta mysql
        $detalle = $this->Compras_model->getDetalleIngreso($data['idingreso']);
        
        //Table with rows and columns
        $this->pdf->SetWidths(array(10, 25, 75, 20, 30, 25));
        //Obtenemos todos los detalles de la venta actual
        $numero = 1;
        $total  = 0;
        foreach($detalle as $row) {
            $codigo        = $row['codigo'];
            $articulo      = $row['nombre'];
            $cantidad      = $row['cantidad'];
            $precio_compra = $row['precio_compra'];
            $subtotal      = $row['precio_compra'];
            $total += $precio_compra;
            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Row(array(utf8_decode($numero), utf8_decode($codigo), utf8_decode($articulo), $cantidad, $precio_compra, $subtotal));
            $numero = $numero + 1;
        }
        $this->pdf->Ln(1);
        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $con_letra = strtoupper($formatterES->format($compra['total_compra']).' bolivianos');
        $this->pdf->Ln(5);
        $this->pdf->SetFillColor(255, 255, 255);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(128, 6, utf8_decode('Importe Total: ' . '---' . $con_letra . '---'), 1, 0, 'L', 1);
        $this->pdf->Cell(1, 6, utf8_decode(''), 0, 0, 'L', 1);
        $this->pdf->Cell(1, 6, utf8_decode(''), 0, 0, 'L', 1);
        $this->pdf->Cell(30, 6, 'Total a pagar ', 1, 0, 'L', 1);
        $this->pdf->Cell(25, 6, utf8_decode($compra['total_compra']) . ' Bs.', 1, 0, 'L', 1);
        $this->pdf->Output("notadeventa.pdf","I");
        ///////////////////////// datos de la empresa ////////////////////////////////
    }

    public function reporteCompras()
    {
        $data = $this->Compras_model->getAllCompras();
        //$producto = $this->Producto_model->getProducto($data['id']);  
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
        $this->pdf->Cell(120,10,utf8_decode('LISTA DE COMPRAS'),0,0,'C');

        $this->pdf->Ln(10);

        $this->pdf->Cell(10,5,utf8_decode("No."),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode("SERIE"),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode("NÚMERO"),'TBLR',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode("FECHA"),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode("TOTAL COMPRA"),'TBLR',0,'C',1);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','',12);
        $indice=1;
        $montoTotal = 0;
        foreach ($data as $row) {
            $this->pdf->Cell(10,5,utf8_decode($indice),'TBLR',0,'L',0);
            $this->pdf->Cell(40,5,utf8_decode($row['serie_comprobante']),'TBLR',0,'L',0);
            $this->pdf->Cell(40,5,utf8_decode($row['num_comprobante']),'TBLR',0,'L',0);
            $this->pdf->Cell(50,5,utf8_decode($row['fecha_hora']),'TBLR',0,'L',1);
            $this->pdf->Cell(40,5,utf8_decode($row['total_compra']),'TBLR',0,'C',1);
            $this->pdf->Ln(5);
            $montoTotal += $row['total_compra']; 
            $indice++;
        }
        $this->pdf->Ln(5);
        $this->pdf->Cell(10,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode('Total General'),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode($montoTotal.' Bs.'),'TBLR',0,'C',1);

        $this->pdf->Output("listacompras.pdf","I");
    }

    public function generarReporte()
    {
        $de = $this->input->post('de');
        $hasta = $this->input->post('hasta');
        if ($de>$hasta) {
            $data['mensaje'] = "La fecha de no puede ser mayor a la fecha hasta";
            $this->load->view('layout/header');
            $this->load->view('compras/reporte',$data);
            $this->load->view('layout/footer');
        }else{
        $data = $this->Compras_model->generarReporte($de,$hasta);
        
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
        $this->pdf->Cell(120,10,utf8_decode('LISTA DE COMPRAS DEL '.$de.' AL '.$hasta),0,0,'C');

        $this->pdf->Ln(10);

        $this->pdf->Cell(10,5,utf8_decode("No."),'TBLR',0,'L',1);
        $this->pdf->Cell(80,5,utf8_decode("NOTA DE COMPRA"),'TBLR',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode("FECHA"),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode("TOTAL COMPRA"),'TBLR',0,'C',1);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','',12);
        $indice=1;
        $montoTotal = 0;
        foreach ($data as $row) {
            $this->pdf->Cell(10,5,utf8_decode($indice),'TBLR',0,'L',0);
            $this->pdf->Cell(80,5,utf8_decode($row['serie_comprobante'].'-'.$row['num_comprobante']),'TBLR',0,'L',0);
            $this->pdf->Cell(50,5,utf8_decode($row['fecha_hora']),'TBLR',0,'L',1);
            $this->pdf->Cell(40,5,utf8_decode($row['total_compra']),'TBLR',0,'C',1);
            $this->pdf->Ln(5);
            $montoTotal += $row['total_compra']; 
            $indice++;
        }
        $this->pdf->Ln(5);
        $this->pdf->Cell(10,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode('Total General'),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode($montoTotal.' Bs.'),'TBLR',0,'C',1);

        $this->pdf->Output("comprasfechas.pdf","I");
        }
    }

 }
