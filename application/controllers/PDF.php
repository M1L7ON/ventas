<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/fpdf/Fpdf.php';
class PDF extends FPDF
{

	function Header()
	{
		$this->SetFont('Arial','B',15);
		$this->Cell(0,10,utf8_decode("UNIDAD EDUCATIVA DEL EJÉRCITO"),1,0,'C');
		$this->Cell(0,10,utf8_decode("COCHABAMBA - BOLIVIA"),1,0,'C');
		$this->Ln(20);
	}

	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(-15,10,utf8_decode('Página ') . $this->PageNo(),0,0,'C');
	}
}
