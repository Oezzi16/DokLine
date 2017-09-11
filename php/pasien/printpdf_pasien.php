<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php');

$query = "SELECT a.id,a.nama, a.alamat FROM pasien a, login b WHERE a.id=b.user AND b.status=1 ORDER BY id";
$sql=mysql_query($query);
$data=array();
while ($row=mysql_fetch_assoc($sql)) {
	array_push($data, $row);
}

#setting judul laporan
$judul = "DOKLINE";
$laporan="DATA PASIEN AKTIF";
$telp="TELP: 0837772xx";
$garis ="--------------------------------------------------------";
$header = array(
	array("label"=>"ID PASIEN", "length"=>30, "align"=>"L"),
	array("label"=>"NAMA", "length"=>60, "align"=>"L"),
	array("label"=>"ALAMAT", "length"=>100, "align"=>"L"),
);
require_once ("fpdf/fpdf.php");
$pdf=new FPDF();
$pdf->AddPage();
#atur margin kiri atas kanan bawah
$pdf->SetMargins(12,1,1,1);
#atur jenis hurufnya
$pdf->SetFont('Arial','B','16');
#tampilkan judul laporan
$pdf->Cell(0,10,$judul,'0',2,'C');
#tampilkan telp
$pdf->Cell(0,1,$telp,'0',2,'C');
#tampilkan nama laporan
$pdf->Cell(0,10,$laporan,'0',2,'C');
#tampilkan garis
$pdf->Cell(0,10,$garis,'0',1,'C');
#buar header table

$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(128,0,0);
foreach ($header as $kolom) {
	$pdf->Cell($kolom['length'], 6, $kolom['label'],1, '0', $kolom['align'], true);
}

$pdf->Ln();
#tampilkan data table nya

$pdf->SetMargins(12,1,1,1);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$fill=false;
foreach ($data as $baris) {
	$i=0;
	foreach ($baris as $cell) {
		$pdf->Cell($header[$i]['length'], 5, $cell,1,'0', $kolom['align'], $fill);
		$i++;
	}
	$fill= !$fill;
	$pdf->Ln();
}
#output pdf
ob_end_clean();
$pdf->output();




?>