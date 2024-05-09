<?php

$server = 'localhost';
$username = 'root';
$password = '';
$nama_database = 'dbsiswa';

$db = mysqli_connect($server,$username,$password,$nama_database);

if(!$db) {
    echo('Gagal terhubung dengan database '.mysqli_connect_error());
}
?>