<?php
session_start();
if (empty($_SESSION['username'])){
    header('location:../index.php');    
} else {
    include "../conn.php";
require('../fpdf17/fpdf.php');
require('../conn.php');

$result=mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama ASC") or die(mysql_error());

$column_kode = "";
$column_nama = "";
$column_jenis = "";
$column_harga = "";
$column_stok = "";


//For each row, add the field to the corresponding column
while($row = mysqli_fetch_array($result))
{
    $kode = $row["kode"];
    $nama = $row["nama"];
    $jenis = $row["jenis"];
    $harga = $row["harga"];
    $stok = $row["stok"];
    

    $column_kode = $column_kode.$kode."\n";
    $column_nama = $column_nama.$nama."\n";
    $column_jenis = $column_jenis.$jenis."\n";
    $column_harga = $column_harga.$harga."\n";
    $column_stok = $column_stok.$stok."\n";

            
//mysql_close();

//Create a new PDF file
$pdf = new FPDF('P','mm',array(210,297)); //L For Landscape / P For Portrait
$pdf->AddPage();

$pdf->Image('../img/logo2.png',10,10,-175);
//$pdf->Image('../images/BBRI.png',190,10,-200);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(80);
$pdf->Cell(30,10,'DATA STOK BARANG',0,0,'C');
$pdf->Ln();
$pdf->Cell(80);
$pdf->Cell(30,10,'Nurun Nisa',0,0,'C');
$pdf->Ln();

}
//Fields Name position
$Y_Fields_Name_position = 30;

//First create each Field Name
//Gray color filling each Field Name box
$pdf->SetFillColor(110,180,230);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',10);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(5);
$pdf->Cell(25,8,'Kode',1,0,'C',1);
$pdf->SetX(30);
$pdf->Cell(40,8,'Nama',1,0,'C',1);
$pdf->SetX(70);
$pdf->Cell(85,8,'Jenis',1,0,'C',1);
$pdf->SetX(155);
$pdf->Cell(30,8,'Harga',1,0,'C',1);
$pdf->SetX(185);
$pdf->Cell(20,8,'Stock',1,0,'C',1);
$pdf->Ln();

//Table position, under Fields Name
$Y_Table_Position = 38;

//Now show the columns
$pdf->SetFont('Arial','',9);

$pdf->SetY($Y_Table_Position);
$pdf->SetX(5);
$pdf->MultiCell(25,6,$column_kode,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(30);
$pdf->MultiCell(40,6,$column_nama,1,'L');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(70);
$pdf->MultiCell(85,6,$column_jenis,1,'L');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(155);
$pdf->MultiCell(30,6,$column_harga,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(185);
$pdf->MultiCell(20,6,$column_stok,1,'C');

$pdf->Output();
}
?>
