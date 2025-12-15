<?php
session_start();

// 1. Verificação de Segurança (O Porteiro)
// Se NÃO existir a variável de sessão 'id_professor', o usuário não está logado.
if (!isset($_SESSION['id_professor'])) {
    // Redireciona imediatamente para o login
    header("Location: login.php");

    // Mata o script aqui para garantir que nenhum HTML abaixo seja carregado
    exit;
}

include 'conexao.php';

if (!isset($_SESSION['id_professor'])) {
    die("Erro: Perfil de professor não encontrado para este usuário. Contate o suporte.");
}

$id_prof = $_SESSION['id_professor'];

// Busca dados atuais
$stmt = $conn->prepare("SELECT * FROM professor WHERE id = ?");
$stmt->bind_param("i", $id_prof);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();

// Se por algum motivo o ID na sessão não existir no banco (erro raro de integridade)
if (!$p) {
    session_destroy(); // Limpa a sessão bugada
    header("Location: login.php"); // Manda logar de novo
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style-criar-perfil.css">
</head>

<body>
    <div class="form-container">
        <h1>Editar Meus Dados</h1>
        <form action="salvar_perfil.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">

            <div class="input-group mb-3">
                <label>Nome Completo</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($p['nome']); ?>" required>
            </div>

            <div class="input-group mb-3">
                <label>Bio / Resumo</label>
                <textarea name="bio" rows="4"><?php echo htmlspecialchars($p['bio']); ?></textarea>
            </div>

            <div class="two-cols">
                <div class="input-group">
                    <label>Formação</label>
                    <input type="text" name="formacao" value="<?php echo htmlspecialchars($p['formacao']); ?>">
                </div>
                <div class="input-group">
                    <label>Disciplinas</label>
                    <input type="text" name="disciplina" value="<?php echo htmlspecialchars($p['disciplina']); ?>">
                </div>
            </div>

            <div class="two-cols">
                <div class="input-group">
                    <label>Gabinete</label>
                    <select name="gabinete">
                        <option value="">Selecione...</option>
                        <?php
                        $opcoes = ['Administração', 'Humanas', 'Informática', 'Linguagens', 'Matemática', 'Metalurgia', 'Naturezas'];
                        foreach ($opcoes as $opt) {
                            $sel = ($p['gabinete'] == $opt) ? 'selected' : '';
                            echo "<option value='$opt' $sel>$opt</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label>Horário de Atendimento</label>
                    <input type="text" name="atendimento" value="<?php echo htmlspecialchars($p['atendimento']); ?>"
                        placeholder="Ex: Terças e Quintas, 14h às 16h">
                </div>
            </div>

            <div class="input-group mb-3">
                <label>Email de Contato (Público)</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($p['email']); ?>">
            </div>

            <div class="two-cols">
                <div class="input-group">
                    <label>Link do Lattes</label>
                    <input type="url" name="lattes" value="<?php echo htmlspecialchars($p['lattes']); ?>"
                        placeholder="http://lattes.cnpq.br/...">
                </div>
                <div class="input-group">
                    <label>Link do LinkedIn</label>
                    <input type="url" name="linkedin" value="<?php echo htmlspecialchars($p['linkedin']); ?>"
                        placeholder="https://linkedin.com/in/...">
                </div>
            </div>

            <div class="input-group mb-3">
                <label>Foto de Perfil</label>
                <?php if ($p['pfp'])
                    echo "<img src='{$p['pfp']}' style='width:50px; height:50px; object-fit:cover; border-radius:50%; margin-bottom:5px; border: 2px solid #ddd;'>"; ?>
                <input type="file" name="foto_perfil">
            </div>

            <div class="button-group">
                <a href="dashboard.php" class="btn-secondary"
                    style="padding:10px; text-decoration:none; color:white; background-color: #6c757d; border-radius: 5px;">Cancelar</a>
                <button type="submit" class="btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</body>

</html>