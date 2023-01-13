<?php
$host = 'localhost';
$dbname = 'ticket';
$user = 'root';
$password = '';

// koneksi ke database mysql
$conn = new mysqli($host, $user, $password, $dbname);

if (!$conn) {
    echo "\nKoneksi ke database gagal, silahkan cek kembali konfigurasi database";
    exit;
}
