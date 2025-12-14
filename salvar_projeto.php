<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $descricao = $_POST['descricao'];
    $area = $_POST['area_conhecimento'];
    $data_inicio = $_POST['data_inicio'];
    $status = $_POST['status'];
    $agencia = $_POST['agencia_financiadora'];
    $objetivos = $_POST['objetivos'];
    $resultados = $_POST['resultados'];

    if ($id) {
        // UPDATE
        $sql = "UPDATE projeto SET titulo=?, autor=?, descricao=?, area_conhecimento=?, data_inicio=?, status=?, agencia_financiadora=?, objetivos=?, resultados=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $titulo, $autor, $descricao, $area, $data_inicio, $status, $agencia, $objetivos, $resultados, $id);
    } else {
        // INSERT
        $sql = "INSERT INTO projeto (titulo, autor, descricao, area_conhecimento, data_inicio, status, agencia_financiadora, objetivos, resultados) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $titulo, $autor, $descricao, $area, $data_inicio, $status, $agencia, $objetivos, $resultados);
    }

    if ($stmt->execute()) {
        header("Location: listar_projetos.php");
    } else {
        echo "Erro ao salvar projeto: " . $stmt->error;
    }
}
?>