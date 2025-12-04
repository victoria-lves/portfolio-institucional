<?php
//parâmetros de conexão com BD
    $servername = "localhost"; //nome ou endereço ip do server
    $username = "root"; //nome do usuário do bd
    $password = ""; //senha de acesso ao server do bd
    $dbname = "meu_banco_de_dados"; //nome do bd

    //cria um objeto de conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    //checa a conexão
    if($conn->connect_error){
        die("Falha na conexão: " . $conn->connect_error);
    }
?>