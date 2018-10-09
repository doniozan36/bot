<table border="1">
 <tr>
 <th>NO</th>
 <th>SKU</th>
 <th>NAMA BARANG</th>
 <th>HARGA BARANG</th>
 <th>BERAT</th>
 <th>GARANSI</th>
 <th>DESKRIPSI</th>
 <th>GAMBAR 1</th>
 <th>GAMBAR 2</th>
 <th>GAMBAR 3</th>
 <th>GAMBAR 4</th>
 <th>GAMBAR 5</th>
 </tr>
 <?php
 //koneksi ke database
 $conn = new mysqli('localhost', 'gdarmame_suro', 'sayasuka001', 'gdarmame_bot');
 if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
     }
    $no = 1;
	$data = mysqli_query($conn,"select * from data");
	while($d = mysqli_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $d['sku']; ?></td>
			<td><?php echo $d['nama_barang']; ?></td>
			<td><?php echo $d['harga_barang']; ?></td>
			<td><?php echo $d['berat']; ?></td>
			<td><?php echo $d['garansi']; ?></td>
			<td><?php echo $d['detail']; ?></td>
			<td><?php echo $d['url_1']; ?></td>
			<td><?php echo $d['url_2']; ?></td>
			<td><?php echo $d['url_3']; ?></td>
			<td><?php echo $d['url_4']; ?></td>
			<td><?php echo $d['url5']; ?></td>
		</tr>
		<?php 
		$no++;
	}
 ?>
</table>