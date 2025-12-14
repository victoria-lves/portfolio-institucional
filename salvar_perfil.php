<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletando dados com proteção contra campos vazios
    $id = $_POST['id'] ?? null;
    $nome = $_POST['nome'] ?? '';
    $bio = $_POST['bio'] ?? ''; // Certifique-se que no HTML o name="bio"
    $formacao = $_POST['formacao'] ?? '';
    $disciplina = $_POST['disciplina'] ?? '';
    $email = $_POST['email'] ?? '';
    $lattes = $_POST['lattes'] ?? '';
    $linkedin = $_POST['linkedin'] ?? '';
    $gabinete = $_POST['gabinete'] ?? '';
    $atendimento = $_POST['atendimento'] ?? '';

    // Lógica da Imagem
    $caminho_foto = null;
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $novo_nome = uniqid() . "." . $ext;
        // Certifique-se que a pasta 'uploads/' existe!
        $caminho_foto = "uploads/" . $novo_nome;
        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho_foto);
    }

    if ($id) {
        // --- ATUALIZAR (UPDATE) ---
        $sql = "UPDATE professor SET nome=?, bio=?, disciplina=?, formacao=?, atendimento=?, email=?, lattes=?, linkedin=?, gabinete=?";

        if ($caminho_foto) {
            $sql .= ", pfp=?";
        }
        $sql .= " WHERE id=?";

        $stmt = $conn->prepare($sql);

        // --- DEBUG DE ERRO ---
        if (!$stmt) {
            die("Erro no SQL (UPDATE): " . $conn->error);
        }

        if ($caminho_foto) {
            $stmt->bind_param("ssssssssssi", $nome, $bio, $disciplina, $formacao, $atendimento, $email, $lattes, $linkedin, $gabinete, $caminho_foto, $id);
        } else {
            $stmt->bind_param("sssssssssi", $nome, $bio, $disciplina, $formacao, $atendimento, $email, $lattes, $linkedin, $gabinete, $id);
        }

    } else {
        // --- CRIAR NOVO (INSERT) ---
        $sql = "INSERT INTO professor (nome, bio, disciplina, formacao, atendimento, email, lattes, linkedin, gabinete, pfp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        // --- DEBUG DE ERRO ---
        if (!$stmt) {
            // Isso vai mostrar na tela exatamente qual coluna ou tabela está faltando
            die("Erro no SQL (INSERT): " . $conn->error);
        }

        // Se passar daqui, o prepare funcionou
        $stmt->bind_param("ssssssssss", $nome, $bio, $disciplina, $formacao, $atendimento, $email, $lattes, $linkedin, $gabinete, $caminho_foto);
    }

    if ($stmt->execute()) {
        header("Location: listar_professores.php");
    } else {
        echo "Erro ao salvar: " . $stmt->error;
    }
}
?>