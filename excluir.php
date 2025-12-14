<?php
include 'conexao.php';

// Recebe o tipo (se é 'professor' ou 'projeto') e o ID pela URL
$tipo = $_GET['tipo'] ?? '';
$id = $_GET['id'] ?? 0;

if ($id) {
    if ($tipo == 'professor') {
        // Exclui Professor
        $stmt = $conn->prepare("DELETE FROM professor WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Se deu certo, volta para a lista de professores
            header("Location: listar_professores.php");
            exit();
        } else {
            echo "Erro ao excluir professor: " . $stmt->error;
        }

    } elseif ($tipo == 'projeto') {
        // Exclui Projeto
        $stmt = $conn->prepare("DELETE FROM projeto WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Se deu certo, volta para a lista de projetos
            header("Location: listar_projetos.php");
            exit();
        } else {
            echo "Erro ao excluir projeto: " . $stmt->error;
        }
    }
} else {
    echo "ID inválido. <br><a href='menu-principal.php'>Voltar ao Menu</a>";
}
?>