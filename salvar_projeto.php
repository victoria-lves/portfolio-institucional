<?php
session_start();
include 'conexao.php';

// 1. Segurança
if (!isset($_SESSION['id_professor'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recebe os dados do formulário
    $id = $_POST['id']; // Se tiver ID, é edição. Se não, é novo.
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $area = $_POST['area_conhecimento'];
    $data_inicio = $_POST['data_inicio'];
    $status = $_POST['status'];
    $agencia = $_POST['agencia_financiadora'];
    $objetivos = $_POST['objetivos'];
    $resultados = $_POST['resultados'];

    // Array com os IDs dos professores selecionados (ex: [1, 5, 8])
    $professores_ids = $_POST['professores'] ?? [];

    // --- PASSO 1: Gerar a string de nomes para o campo 'autor' (Retrocompatibilidade) ---
    // Isso garante que suas outras páginas que leem o campo texto 'autor' continuem funcionando.
    $nomes_autores = [];
    if (!empty($professores_ids)) {
        // Transforma o array em uma lista separada por vírgula para o SQL (ex: 1,5,8)
        $ids_string = implode(",", array_map('intval', $professores_ids));
        $res_nomes = $conn->query("SELECT nome FROM professor WHERE id IN ($ids_string) ORDER BY nome ASC");
        while ($row = $res_nomes->fetch_assoc()) {
            $nomes_autores[] = $row['nome'];
        }
    }
    // Cria uma string: "Prof. A, Prof. B"
    $autor_texto = implode(", ", $nomes_autores);


    // --- PASSO 2: Salvar ou Atualizar o Projeto na tabela Principal ---

    $stmt = null;
    $id_projeto_final = null;

    if ($id) {
        // === UPDATE (Edição) ===
        $sql = "UPDATE projeto SET titulo=?, autor=?, descricao=?, area_conhecimento=?, data_inicio=?, status=?, agencia_financiadora=?, objetivos=?, resultados=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $titulo, $autor_texto, $descricao, $area, $data_inicio, $status, $agencia, $objetivos, $resultados, $id);

        if ($stmt->execute()) {
            $id_projeto_final = $id;

            // Limpa os vínculos antigos para recriar (maneira mais fácil de atualizar N:N)
            $conn->query("DELETE FROM professor_projeto WHERE id_projeto = $id_projeto_final");
        }
    } else {
        // === INSERT (Novo) ===
        $sql = "INSERT INTO projeto (titulo, autor, descricao, area_conhecimento, data_inicio, status, agencia_financiadora, objetivos, resultados) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $titulo, $autor_texto, $descricao, $area, $data_inicio, $status, $agencia, $objetivos, $resultados);

        if ($stmt->execute()) {
            $id_projeto_final = $conn->insert_id;
        }
    }

    // --- PASSO 3: Salvar os Vínculos na Tabela Intermediária ---

    if ($id_projeto_final && !empty($professores_ids)) {
        $stmt_link = $conn->prepare("INSERT INTO professor_projeto (id_projeto, id_professor) VALUES (?, ?)");

        foreach ($professores_ids as $id_prof) {
            $stmt_link->bind_param("ii", $id_projeto_final, $id_prof);
            $stmt_link->execute();
        }

        // Redireciona com sucesso
        header("Location: dashboard.php?status=sucesso");
        exit;
    } else {
        echo "Erro ao salvar: " . $conn->error;
    }
}
?>