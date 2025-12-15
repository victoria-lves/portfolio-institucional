<?php
session_start();
include 'conexao.php';

// 1. Segurança: Verifica se está logado
if (!isset($_SESSION['id_professor'])) {
    header("Location: login.php");
    exit;
}

$id_prof = $_SESSION['id_professor'];

// 2. Recebe os dados de texto
$nome = $_POST['nome'];
$bio = $_POST['bio'];
$formacao = $_POST['formacao'];
$disciplina = $_POST['disciplina'];
$gabinete = $_POST['gabinete'];
$atendimento = $_POST['atendimento']; // Novo campo
$email = $_POST['email'];
$lattes = $_POST['lattes']; // Novo campo
$linkedin = $_POST['linkedin']; // Novo campo

// 3. Lógica de Upload da Foto
// Primeiro, vamos preparar a parte inicial da Query SQL
$sql = "UPDATE professor SET nome=?, bio=?, formacao=?, disciplina=?, gabinete=?, atendimento=?, email=?, lattes=?, linkedin=?";
$types = "sssssssss";
$params = [&$nome, &$bio, &$formacao, &$disciplina, &$gabinete, &$atendimento, &$email, &$lattes, &$linkedin];

// Verifica se um arquivo foi enviado e se não houve erro
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {

    $arquivo = $_FILES['foto_perfil'];

    // Pasta onde as fotos serão salvas (Crie essa pasta no seu projeto!)
    $pasta = "img/professores/";

    // Se a pasta não existir, tenta criar (opcional, mas recomendado criar manualmente antes)
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    // Pega a extensão do arquivo (jpg, png, etc)
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

    // Validação básica de extensão
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($extensao, $extensoes_permitidas)) {
        // Gera um nome único para não sobrescrever fotos de outros (ex: 1_time.jpg)
        $novo_nome = $id_prof . "_" . time() . "." . $extensao;
        $caminho_final = $pasta . $novo_nome;

        // Move o arquivo da pasta temporária para a pasta do site
        if (move_uploaded_file($arquivo['tmp_name'], $caminho_final)) {
            // Se o upload deu certo, adicionamos o campo 'pfp' na query SQL
            $sql .= ", pfp=?";
            $types .= "s";
            $params[] = &$caminho_final;
        }
    }
}

// Finaliza a Query
$sql .= " WHERE id=?";
$types .= "i";
$params[] = &$id_prof;

// 4. Executa a atualização no Banco
if ($stmt = $conn->prepare($sql)) {
    // Truque para usar call_user_func_array com bind_param dinâmico
    $bind_names[] = $types;
    for ($i = 0; $i < count($params); $i++) {
        $bind_names[] = &$params[$i];
    }

    call_user_func_array(array($stmt, 'bind_param'), $bind_names);

    if ($stmt->execute()) {
        // Sucesso: Redireciona de volta para a edição ou dashboard
        header("Location: criar_perfil.php?status=sucesso");
    } else {
        echo "Erro ao salvar no banco: " . $stmt->error;
    }
} else {
    echo "Erro na preparação da query: " . $conn->error;
}
?>