<?php
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
        $sku_fix=strip_tags($sku[0][0]);
        $berat = strip_tags($sku[0][1]);
        $garansi = strip_tags($sku[0][2]);
        echo "nama barang = ".$nama_barang_fix."<br>";
        echo "harga barang = ".$harga_fix."<br>";
        echo "SKU barang = ".$sku_fix."<br>";
        echo "Berat = ".$berat."<br>";
        echo "Garansi barang = ".$garansi."<br>";
        $pertamaa=strpos($output,'Online');
        $kata=substr($output,$pertamaa);
        $kata=strip_tags($kata);
        $penggal=trim(preg_replace('/\s\s\s+/', ' ', $kata));
        $keduaa=strpos($penggal,"Toko");
        $hasill=substr($penggal,0,$keduaa);
        echo "<br>";
        echo "Stok barang :";
        //echo $hasill;
        if (strpos($hasill, 'Stok tersedia') !== false) {
            if(strpos($hasill, 'Sisa') !== false){
                echo $hasill;
            }else{
                echo $hasill." 30";
            }
            
        }else{
            echo "Stok kosong";
        }
        echo "<br>";
        echo "<br>";
        echo "Deskripsi Produk";
        echo "<br>";
        $pertamaa_desc=strpos($output,'Overview of');
        $kata_desc=substr($output,$pertamaa_desc);
        $kata_desc=strip_tags($kata_desc);
        $penggal_desc=trim(preg_replace('/\s\s\s+/', ' ', $kata_desc));
        $keduaa_desc=strpos($penggal_desc,"Package Contents");
        $hasill_desc=substr($penggal_desc,0,$keduaa_desc);
        print_r($hasill_desc);
        echo "<br>";
        echo "Link Foto";
        echo "<br>";
        for ($i = 0; $i < 5; $i++) {
        echo $images[$i].'<br />';
        echo "</div>";
        }
        curl_close($ch);
    }
//if (!isset($_POST['tombol'])){
// <html>
//     <form action="index.php" method="post">
//         <input type="text" name="url">
//         <input type="submit" name="tombol" value="go" >
//     </form>
// </html>
// <?php
// }else{
     ambil("https://www.jakartanotebook.com/keyboard");
// }
?>