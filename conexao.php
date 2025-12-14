<?php
$servername = "localhost";
$username = "root";
$password = "root"; // Coloque sua senha do MySQL aqui, se houver
$dbname = "perfil";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Garante que acentos e cedilhas funcionem corretamente
$conn->set_charset("utf8mb4");
?>