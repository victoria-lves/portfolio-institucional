<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Segurança: garante que o usuário só edita o próprio perfil
    if ($_POST['id'] != $_SESSION['professor_id']) {
        die("Acesso não autorizado.");
    }

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $bio = $_POST['bio'];
    $formacao = $_POST['formacao'];
    $disciplina = $_POST['disciplina'];
    $email = $_POST['email'];
    $gabinete = $_POST['gabinete'];

    // Upload de Imagem
    $sql_img = "";
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $novo_nome = "prof_" . $id . "_" . uniqid() . "." . $ext;
        if(move_uploaded_file($_FILES['foto_perfil']['tmp_name'], "uploads/" . $novo_nome)){
            $caminho_foto = "uploads/" . $novo_nome;
            // Atualiza o SQL para incluir a foto
            $stmt = $conn->prepare("UPDATE professor SET nome=?, bio=?, formacao=?, disciplina=?, email=?, gabinete=?, pfp=? WHERE id=?");
            $stmt->bind_param("sssssssi", $nome, $bio, $formacao, $disciplina, $email, $gabinete, $caminho_foto, $id);
        }
    } else {
        // Sem atualizar foto
        $stmt = $conn->prepare("UPDATE professor SET nome=?, bio=?, formacao=?, disciplina=?, email=?, gabinete=? WHERE id=?");
        $stmt->bind_param("ssssssi", $nome, $bio, $formacao, $disciplina, $email, $gabinete, $id);
    }

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}
?>