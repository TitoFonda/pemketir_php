<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbName = "db_pemketir";
$conn = mysqli_connect ($host, $user, $pass);

if(!$conn){
    die("Koneksi MySql Gagal!!<br>".mysqli_connect_error());
}
echo "Koneksi MySql Berhasil!!<br>";

$sql = mysqli_select_db($conn,$dbName);
if(!$sql){
    die("Koneksi Database Gagal!!".mysqli_error($conn));
}
echo("Koneksi Database Berhasil!!");
?>