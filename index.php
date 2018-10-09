<?php
error_reporting(1);
include 'get_all.php';
if (!isset($_POST['tombol'])){
?>
<html>
    <form action="index.php" method="post">
        url :
        <input type="text" name="url" placeholder="url kategori"><br>
        <input type="submit" name="tombol" value="go" >
    </form>
</html>
<?php
echo '<p><a href="p_tokped.php"><button>Tokopedia</button></a></p>';
echo '<p><a href="p_bl.php"><button>Bkalapak</button></a></p>';
}else{
    ambil_link($_POST['url']);
}
?>