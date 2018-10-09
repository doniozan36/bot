<?php
$conn = new mysqli('localhost', 'gdarmame_suro', 'sayasuka001', 'gdarmame_bot');
if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    }
    //  $datetime = date('Ymd-His');
    $nama=$_POST['n_file'];
    $asuransi=$_POST['asuransi'];
    $kurir=$_POST['kurir'];


include "PHPExcel/Classes/PHPExcel.php";
include "PHPExcel/Classes/PHPExcel/Writer/Excel2007.php";
 
$excel = new PHPExcel;
 
$excel->getProperties()->setCreator("unknow");
$excel->getProperties()->setLastModifiedBy("unknow");
$excel->getProperties()->setTitle("data produk");
$excel->removeSheetByIndex(0);
 
 
$sheet = $excel->createSheet();
$sheet->setTitle('sheet_1');
 $sheet->setCellValue("A1", "Nama Produk");
 $sheet->setCellValue("B1", "Stok(Minimum 1)");
 $sheet->setCellValue("C1", "Berat (gram)");
 $sheet->setCellValue("D1", "Harga (Rupiah)");
 $sheet->setCellValue("E1", "Kondisi(Baru/Bekas)");
 $sheet->setCellValue("F1", "Deskripsi");
 $sheet->setCellValue("G1", "Wajib Asuransi?(Ya/Tidak)");
 $sheet->setCellValue("H1", "Jasa Pengiriman (gunakan vertical bar | sebagai pemisah jasa ");
 $sheet->setCellValue("I1", "URL Gambar 1");
 $sheet->setCellValue("J1", "URL Gambar 2");
 $sheet->setCellValue("K1", "URL Gambar 3");
 $sheet->setCellValue("L1", "URL Gambar 4");
 $sheet->setCellValue("M1", "URL Gambar 5");

 
 
 $data = mysqli_query($conn,"select * from data where stok>=1");
 $i = 2;
while( $r = mysqli_fetch_array($data) ){
   $sheet->setCellValue( "A" . $i, $r['nama_barang'] );
   $sheet->setCellValue( "B" . $i, $i, $r['stok'] );
   $sheet->setCellValue( "C" . $i, $r['berat'] );
   $sheet->setCellValue( "D" . $i, $r['harga_barang'] );
   $sheet->setCellValue( "E" . $i, 'baru' );
   $sheet->setCellValue( "F" . $i, $r['detail'] );
   $sheet->setCellValue( "G" . $i, $asuransi );
   $sheet->setCellValue( "H" . $i, $kurir);
   $sheet->setCellValue( "I" . $i, $r['url_1']);
   $sheet->setCellValue( "J" . $i, $r['url_2'] );
   $sheet->setCellValue( "K" . $i, $r['url_3'] );
   $sheet->setCellValue( "L" .  $i, $r['url_4']);
   $sheet->setCellValue( "M" . $i, $r['url5'] );
   $i++;
}
 $conn->close();
 
 $writer = new PHPExcel_Writer_Excel2007($excel);
 $writer->save("./bukalapak/$nama.xlsx");
 
 
?>
Your File in : <a href="./bukalapak/<?php echo $nama;?>.xlsx">Here</a>