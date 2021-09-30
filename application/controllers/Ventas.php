<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ventas_model');
        $this->load->model('Cliente_model');
        $this->load->model('Producto_model');
        $this->load->model('Ventas_model');
        require_once  APPPATH.'controllers/PDF_MC_Table.php';
    } 

    function index()
    {
        $data['ventas'] = $this->Ventas_model->getAllVentas();

        $this->load->view('layout/header');
        $this->load->view('Ventas/index',$data);
        $this->load->view('layout/footer');
    }

    function insert()
    {
    	$data['cliente'] = $this->Cliente_model->getAllCliente();
    	$data['producto'] = $this->Producto_model->getAllProducto();
    	$data['numero'] = $this->Ventas_model->getAllVentasCount();
        $this->load->view('layout/header');
        $this->load->view('Ventas/add',$data);
        $this->load->view('layout/footer');
    }

    function editar($idcliente)
    {
    	$data['cliente'] = $this->Ventas_model->getCliente($idcliente);
    	$this->load->view('layout/header');
        $this->load->view('Ventas/edit',$data);
        $this->load->view('layout/footer');
    }

    function reporteFechas()
    {
        $this->load->view('layout/header');
        $this->load->view('ventas/reporte');
        $this->load->view('layout/footer');
    }

    function guardarDB()
    {   
        $this->formValidation();
		if($this->form_validation->run())     
        {   
            $cantidad = $this->input->post('cantidad');
            $precio_venta = $this->input->post('precio_venta');
            $descuento = $this->input->post('descuento');
            $idarticulo = $this->input->post('idarticulo');
            $paramsdatosVentas = $this->datosVentas();
           
            $idventa = $this->Ventas_model->addVentas($paramsdatosVentas);
            for($i = 0; $i < sizeof($cantidad); $i++) {
                if ($cantidad[$i]>0 && $precio_venta[$i]>0) {
                    echo $idarticulo[$i].'<br>';
                    $paramsDatosDetalleIngreso = array(
                        'idventa' => $idventa,
                        'idarticulo' => $idarticulo[$i],
                        'cantidad' => $cantidad[$i],
                        'descuento' => $descuento[$i],
                        'precio_venta' => $precio_venta[$i],
                    );
                    $id = $this->Ventas_model->addDetalleVentas($paramsDatosDetalleIngreso);
                }    
            }
            
            redirect(base_url().'Ventas');
        }
        else
        {            
            $data['cliente'] = $this->Cliente_model->getAllCliente();
            $data['producto'] = $this->Producto_model->getAllProducto();
            $data['numero'] = $this->Ventas_model->getAllVentasCount();
            $this->load->view('layout/header');
            $this->load->view('Ventas/add',$data);
            $this->load->view('layout/footer');
        }
    }  


    function anularVentas($anularVentas)
    {   
        $parametrosAnular = array(
                    'condicion' => 0,
        );
        $this->Ventas_model->anularVentas($anularVentas,$parametrosAnular);
        redirect(base_url().'Ventas');
    } 

    function datosVentas()
    {
        $cantidad = $this->input->post('cantidad');
        $precio_venta = $this->input->post('precio_venta');
        $descuento = $this->input->post('descuento');
        $total_venta = 0;
        for($i = 0; $i < sizeof($cantidad); $i++){
            $total_venta += ($cantidad[$i] * $precio_venta[$i]) - $descuento[$i] ;
        }
        $params = array(
                    'idcliente' => $this->input->post('idcliente'),
                    'idusuario' => $this->session->userdata('s_idUsuario'),
                    'fecha_hora' => date_format(date_create($this->input->post('fecha_hora')),"Y/m/d"),
                    'tipo_comprobante' => $this->input->post('tipo_comprobante'),
                    'serie_comprobante' => $this->input->post('serie_comprobante'),
                    'num_comprobante' => $this->input->post('num_comprobante'),
                    'total_venta' => $total_venta,
                );
        return $params;
    }

    function cambiarEstado($idcliente,$activo)
    {
   			$params = array(
					'condicion' => $activo,
           	);

            $this->Ventas_model->cambiarEstado($idcliente,$params);
            $data['cliente'] = $this->Ventas_model->get_allcliente();
            $this->load->view('layout/header');
            $this->load->view('Ventas/index',$data);
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

    public function notaDeVenta($idventa)
    {
        $data = $this->Ventas_model->getNotaDeVenta($idventa); 
        $cliente = $this->Cliente_model->getCliente($data['idcliente']);
        $ventas = $this->Ventas_model->getVentas($data['idventa']);
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
        ///////////////////////// datos del cliente //////////////////////////////////
        //Obtenemos los datos de la cabecera de la venta actual
        $r1   = 10;
        $r2   = $r1 + 68;
        $y1   = 40;
        $this->pdf->SetXY($r1, $y1);
        $this->pdf->SetFont("Arial", "B", 10);
        $this->pdf->MultiCell(60, 4, "cliente");
        $this->pdf->SetXY($r1, $y1 + 5);
        $this->pdf->SetFont("Arial", "", 10);

        $this->pdf->MultiCell(150, 4, utf8_decode($cliente['nombre']));
        $this->pdf->SetXY($r1, $y1 + 10);
        $this->pdf->MultiCell(150, 4, utf8_decode("Dirección: ").utf8_decode($cliente['direccion']));
        $this->pdf->SetXY($r1, $y1 + 15);
        $this->pdf->MultiCell(150, 4, "NIT: " . utf8_decode($cliente['num_documento']));
        $this->pdf->SetXY($r1, $y1 + 20);
        $this->pdf->MultiCell(150, 4, "Email: " . utf8_decode($cliente['email']));
        $this->pdf->SetXY($r1, $y1 + 25);
        $this->pdf->MultiCell(150, 4, "Telefono: " . $cliente['telefono']);
        ///////////////////////// fin datos del cliente //////////////////////////////
        ///////////////////////// Inicio recibo y fecha  //////////////////////////////
        $r1 = 220 - 90;
        $r2 = $r1 + 68;
        $y1 = 6;
        $y2 = $y1 + 2;
        $this->pdf->SetFillColor(72, 209, 204);
        $this->pdf->SetXY($r1 + 1, $y1 + 5);
        $this->pdf->Cell($r2 - $r1 - 1, 5, 'NOTA DE Ventas '.$ventas['serie_comprobante'].'-'.$ventas['num_comprobante'], 1, 2, "C");
        $this->pdf->Ln(5);
        $this->pdf->SetXY($r1 + 1, $y1 + 11);
        $originalDate = $ventas['fecha_hora'];
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
        $this->pdf->Cell(30, 6, 'Precio Ventas', 1, 0, 'L', 1);
        $this->pdf->Cell(25, 6, utf8_decode('Sub Total'), 1, 0, 'L', 1);

        $this->pdf->Ln(6);
        //Comenzamos a crear las filas de los registros según la consulta mysql
        $detalle = $this->Ventas_model->getDetalleVentas($data['idventa']);
        
        //Table with rows and columns
        $this->pdf->SetWidths(array(10, 25, 75, 20, 30, 25));
        //Obtenemos todos los detalles de la venta actual
        $numero = 1;
        $total  = 0;
        foreach($detalle as $row) {
            $codigo        = $row['codigo'];
            $articulo      = $row['nombre'];
            $cantidad      = $row['cantidad'];
            $precio_venta  = $row['precio_venta'];
            $subtotal      = $row['precio_venta'];
            $total += $precio_venta;
            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Row(array(utf8_decode($numero), utf8_decode($codigo), utf8_decode($articulo), $cantidad, $precio_venta, $subtotal));
            $numero = $numero + 1;
        }
        $this->pdf->Ln(1);
        //Convertimos el total en letras
        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $con_letra = strtoupper($formatterES->format($ventas['total_venta']).' bolivianos');
        $this->pdf->Ln(5);
        $this->pdf->SetFillColor(255, 255, 255);
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->Cell(128, 6, utf8_decode('Importe Total: ' . '---' . $con_letra . '---'), 1, 0, 'L', 1);
        $this->pdf->Cell(1, 6, utf8_decode(''), 0, 0, 'L', 1);
        $this->pdf->Cell(1, 6, utf8_decode(''), 0, 0, 'L', 1);
        $this->pdf->Cell(30, 6, 'Total a pagar ', 1, 0, 'L', 1);
        $this->pdf->Cell(25, 6, utf8_decode($ventas['total_venta']) . ' Bs.', 1, 0, 'L', 1);
        $this->pdf->Output("notadeventa.pdf","I");
        ///////////////////////// datos de la empresa ////////////////////////////////
    }

    public function reporteVentas()
    {
        $data = $this->Ventas_model->getAllVentas();
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
        $this->pdf->Cell(120,10,utf8_decode('LISTA DE VENTAS'),0,0,'C');

        $this->pdf->Ln(10);

        $this->pdf->Cell(10,5,utf8_decode("No."),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode("SERIE"),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode("NÚMERO"),'TBLR',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode("FECHA"),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode("TOTAL VENTA"),'TBLR',0,'C',1);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','',12);
        $indice=1;
        $montoTotal = 0;
        foreach ($data as $row) {
            $this->pdf->Cell(10,5,utf8_decode($indice),'TBLR',0,'L',0);
            $this->pdf->Cell(40,5,utf8_decode($row['serie_comprobante']),'TBLR',0,'L',0);
            $this->pdf->Cell(40,5,utf8_decode($row['num_comprobante']),'TBLR',0,'L',0);
            $this->pdf->Cell(50,5,utf8_decode($row['fecha_hora']),'TBLR',0,'L',1);
            $this->pdf->Cell(40,5,utf8_decode($row['total_venta']),'TBLR',0,'C',1);
            $this->pdf->Ln(5);
            $montoTotal += $row['total_venta']; 
            $indice++;
        }
        $this->pdf->Ln(5);
        $this->pdf->Cell(10,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode(''),'',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode('Total General'),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode($montoTotal.' Bs.'),'TBLR',0,'C',1);

        $this->pdf->Output("listaventas.pdf","I");
    }

    public function generarReporte()
    {
        $de = $this->input->post('de');
        $hasta = $this->input->post('hasta');
        if ($de>$hasta) {
            $data['mensaje'] = "La fecha de no puede ser mayor a la fecha hasta";
            $this->load->view('layout/header');
            $this->load->view('ventas/reporte',$data);
            $this->load->view('layout/footer');
        }else{
        $data = $this->Ventas_model->generarReporte($de,$hasta);
        
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
        $this->pdf->Cell(120,10,utf8_decode('LISTA DE VENTAS DEL '.$de.' AL '.$hasta),0,0,'C');

        $this->pdf->Ln(10);

        $this->pdf->Cell(10,5,utf8_decode("No."),'TBLR',0,'L',1);
        $this->pdf->Cell(80,5,utf8_decode("NOTA DE VENTA"),'TBLR',0,'L',1);
        $this->pdf->Cell(50,5,utf8_decode("FECHA"),'TBLR',0,'L',1);
        $this->pdf->Cell(40,5,utf8_decode("TOTAL VENTA"),'TBLR',0,'C',1);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','',12);
        $indice=1;
        $montoTotal = 0;
        foreach ($data as $row) {
            $this->pdf->Cell(10,5,utf8_decode($indice),'TBLR',0,'L',0);
            $this->pdf->Cell(80,5,utf8_decode($row['serie_comprobante'].'-'.$row['num_comprobante']),'TBLR',0,'L',0);
            $this->pdf->Cell(50,5,utf8_decode($row['fecha_hora']),'TBLR',0,'L',1);
            $this->pdf->Cell(40,5,utf8_decode($row['total_venta']),'TBLR',0,'C',1);
            $this->pdf->Ln(5);
            $montoTotal += $row['total_venta']; 
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
