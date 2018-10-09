<?php 
error_reporting(1);
include 'db.php';
function dua($string, $tagname,$end) {
    $pattern = "/<$tagname?.*>(.*)<\/$end>/";
    preg_match_all($pattern, $string, $matches);
    return $matches;
}
function getTextBetweenTags($string, $tagname) {
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match_all($pattern, $string, $matches);
    return $matches;
}
$sku_fix="";
function ambil($url){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        preg_match_all("!https://www.jakartanotebook.com/images/products/[^\s]*?.jpg!",$output,$hasil);
        $images = array_values(array_unique($hasil[0]));
        $nama_barang=dua($output,'span itemprop="name"','span');
        $sku=getTextBetweenTags($output,'dd');
        $harga=dua($output,'span itemprop="price"','span');
        $kata = trim(preg_replace('/\s\s+/', ' ', $output));
        $stok=dua($kata,'div class="product-list__stock product-list__stock--ready"','div');
        $deskripsi=dua($output,'table class="stdTable noBorder"','table');
    
        $nama_barang_fix=strip_tags($nama_barang[0][1]);
        $harga_fix=$harga[1][0];
        $harga_fix=str_replace('.','',$harga_fix,$i);
        $sku_fix=strip_tags($sku[0][0]);
        $berat_sm = strip_tags($sku[0][1]);
        $pt_brt=strpos($berat_sm,'kg');
        $pt_br=substr($berat_sm,0,$pt_brt);
        $berat= $pt_br*1000;
        $garansi = strip_tags($sku[0][2]);
        // echo "nama barang = ".$nama_barang_fix."<br>";
        // echo "harga barang = ".$harga_fix."<br>";
        // echo "SKU barang = ".$sku_fix."<br>";
        // echo "Berat = ".$berat."<br>";
        // echo "Garansi barang = ".$garansi."<br>";
        $pertamaa=strpos($output,'COD');
        $kata=substr($output,$pertamaa+3);
        $kata=strip_tags($kata);
        $penggal=trim(preg_replace('/\s\s\s+/', ' ', $kata));
        $keduaa=strpos($penggal,"Toko");
        $hasill=substr($penggal,0,$keduaa);
        // echo "<br>";
        // echo "Stok barang :";
        //echo $hasill;
        $status="";
        if (strpos($hasill, 'Stok tersedia') !== false) {
            $status="tersedia";
            if(strpos($hasill, 'Sisa') !== false){
                $pt_hasul=strpos($hasill, 'Sisa');
                $hasul=substr($hasill,$pt_hasul+4);
                $hasill=intval($hasul);
            }else{
                $hasill=30;
            }
            
        }else{
            $hasill="";
            $status= "Stok kosong";
        }
        $pertamaa_desc=strpos($output,'Overview of');
        $kata_desc=substr($output,$pertamaa_desc);
        $kata_desc=strip_tags($kata_desc);
        $penggal_desc=trim(preg_replace('/\s\s\s+/', ' ', $kata_desc));
        if(strpos($penggal_desc,"Package Contents")!=false){
            $keduaa_desc=strpos($penggal_desc,"Package Contents");
        }else if(strpos($penggal_desc,"Photos of")!=false){
            $keduaa_desc=strpos($penggal_desc,"Photos of");
        }
        $hasill_desc=substr($penggal_desc,0,$keduaa_desc);
        //print_r($hasill_desc);
        // echo "<br>";
        // echo "Link Foto";
        // echo "<br>";
        // for ($i = 0; $i < 5; $i++) {
        // echo $images[$i].'<br />';
        // echo "</div>";
        // }
        
        
        $conn = new mysqli('localhost', 'gdarmame_suro', 'sayasuka001', 'gdarmame_bot');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
         }
        $sql="INSERT INTO data VALUES('$sku_fix','$nama_barang_fix','$harga_fix','$berat','$garansi','$hasill_desc','$images[0]','$images[1]','$images[2]','$images[3]','$images[4]','$hasill','$status')";
        if (mysqli_query($conn, $sql)) {
            //echo "New record created successfully";
         } else {
            echo "Error: " . $sql . "" . mysqli_error($conn);
         }
         $conn->close();
        
        
        //echo $queryw;
        curl_close($ch);
    }
function ambil_link($url){
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch); 
    $saya=strpos($output,'<div class="product-list-wrapper">');
    $potong=substr($output,$saya);
    $potong=strip_tags($potong,"<a>");
    $sayaa=dua($potong,'a href="','a');
    $sayaa = array_values(array_unique($sayaa[0]));
    $tes=array();
    
    $pt=strpos($output,'<div class="resultCount">');
    $ptg=substr($output,$pt);
    $pt2=strpos($ptg,'<div class="categorySorting  showPerPage">');
    $ptg2=substr($ptg,0,$pt2-1);
    $has=strip_tags($ptg2);
    $hitung_a=strpos($has,'results');
    $hitung_b=substr($has,0,$hitung_a);
    
    $a=explode("=",$url,-1);
    $b=explode("&",$a[1],2);
    
    $n=intval($b[0]);
    if($hitung_b>=$n){
        $ulang=$n*2;
    }else{
        $ulang=$hitung_b*2;
    }
    for($i=0;$i<$ulang;$i++){
        $awal=strpos($sayaa[$i],"href");
        $ahir=strpos($sayaa[$i],"title");
       $tes[$i] = substr($sayaa[$i],$awal+6,$ahir-11);
    }
    $tes=array_values(array_unique($tes));
    for($z=0;$z<count($tes);$z++){
        ambil($tes[$z]);
        //echo $queryw;
        //echo $sku_fix;
        echo "<h1>ini adalah produk ke - ".($z+1)."</h1>";
    }
    curl_close($ch);
}
// ambil_link('https://www.jakartanotebook.com/mainan?show=60&sort=name&price=&sku=&ready=');
?>