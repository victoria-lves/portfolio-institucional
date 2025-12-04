<?php
//parâmetros de conexão com BD
    $servername = "localhost"; //nome ou endereço ip do server
    $username = "root"; //nome do usuário do bd
    $password = ""; //senha de acesso ao server do bd
    $dbname = "meu_banco_de_dados"; //nome do bd

    //cria um objeto de conexão
    $conn = @new mysqli($servername, $username, $password, $dbname);

    //checa a conexão
    if($conn->connect_error){
        die("Falha na conexão: " . $conn->connect_error);
    }

    if ($conn-> connect_error){
        error_log("Erro na conexão MySQL: " . $conn->connect_error);
        die("Desculpe, tivemos um problema técnico. Tente novamente mais tarde.");    
    }

    //define o charset para aceitar acentos (UTF-8)
    if($conn->set_charset("utf8mb4")){
        error_log("Erro ao carregar o set de caracteres utf8mb4: " . $conn->error);
        exit();
    }

?>