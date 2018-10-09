<?php
$conn = new mysqli('localhost', 'gdarmame_suro', 'sayasuka001', 'gdarmame_bot');
if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    }
    //  $datetime = date('Ymd-His');
    $nama=$_POST['n_file'];
    $kat=$_POST['kategori'];


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
 $sheet->setCellValue("B1", "Kategori");
 $sheet->setCellValue("C1", "Deskripsi Produk");
 $sheet->setCellValue("D1", "Harga (Dalam Rupiah)");
 $sheet->setCellValue("E1", "Berat (Dalam Gram)");
 $sheet->setCellValue("F1", "Pemesanan Minimum");
 $sheet->setCellValue("G1", "Status");
 $sheet->setCellValue("H1", "Jumlah Stok");
 $sheet->setCellValue("I1", "Etalase");
 $sheet->setCellValue("J1", "Preorder");
 $sheet->setCellValue("K1", "Waktu Proses Preorder");
 $sheet->setCellValue("L1", "Kondisi");
 $sheet->setCellValue("M1", "Gambar 1");
 $sheet->setCellValue("N1", "Gambar 2");
 $sheet->setCellValue("O1", "Gambar 3");
 $sheet->setCellValue("P1", "Gambar 4");
 $sheet->setCellValue("Q1", "Gambar 5");
 $sheet->setCellValue("R1", "URL Video Produk 1");
 $sheet->setCellValue("S1", "URL Video Produk 2");
 $sheet->setCellValue("T1", "URL Video Produk 3");

 
 
 $data = mysqli_query($conn,"select * from data");
 $i = 2;
while( $r = mysqli_fetch_array($data) ){
    $hrg=intval($r['harga_barang']);
    switch($hrg){
        case($hrg<=50000):
            $hrg=$hrg+10000;
            break;
        case ($hrg<=100000):
            $hrg=$hrg+15000;
            break;
        case($hrg<=200000):
            $hrg=$hrg+20000;
            break;
        case($hrg<=300000):
            $hrg=$hrg+30000;
            break;
        default:
            $hrg=$hrg+50000;
            break;
    }
   $sheet->setCellValue( "A" . $i, $r['nama_barang'] );
   $sheet->setCellValue( "B" . $i, $kat );
   $sheet->setCellValue( "C" . $i, $r['detail'] );
   $sheet->setCellValue( "D" . $i,  );
   $sheet->setCellValue( "E" . $i, $r['berat'] );
   $sheet->setCellValue( "F" . $i, '1' );
   $sheet->setCellValue( "G" . $i, $r['status'] );
   $sheet->setCellValue( "H" . $i, $r['stok'] );
   $sheet->setCellValue( "I" . $i, 'bahan' );
   $sheet->setCellValue( "J" . $i, '' );
   $sheet->setCellValue( "L" . $i, 'baru' );
   $sheet->setCellValue( "M" . $i, $r['url_1'] );
   $sheet->setCellValue( "N" . $i, $r['url_2'] );
   $sheet->setCellValue( "O" . $i, $r['url_3'] );
   $sheet->setCellValue( "P" . $i, $r['url_4'] );
   $sheet->setCellValue( "Q" . $i, $r['url5'] );
   $sheet->setCellValue( "R" . $i, '');
   $sheet->setCellValue( "S" . $i, '' );
   $sheet->setCellValue( "T" . $i, '' );
   $i++;
}
 $conn->close();
 
 $writer = new PHPExcel_Writer_Excel2007($excel);
 $writer->save("./tokopedia/$nama.xlsx");
 
 
?>
Your File in : <a href="./tokopedia/<?php echo $nama;?>.xlsx">Here</a>