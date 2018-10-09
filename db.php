<?php 

session_start(); // Digunakan untuk memulai session

$host = "localhost"; // nama host anda
$user = "gdarmame_suro"; // username dari host anda
$pass = "sayasuka001"; //password dari host anda
$db   = "gdarmame_bot"; // nama database yang anda miliki

$koneksi = mysqli_connect("localhost",$user,$pass,"gdarmame_bot");

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>