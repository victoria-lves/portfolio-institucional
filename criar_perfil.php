<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['professor_id'])) {
    die("Erro: Perfil de professor não encontrado para este usuário. Contate o suporte.");
}

$id_prof = $_SESSION['professor_id'];

// Busca dados atuais
$stmt = $conn->prepare("SELECT * FROM professor WHERE id = ?");
$stmt->bind_param("i", $id_prof);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
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
                <input type="text" name="nome" value="<?php echo $p['nome']; ?>" required>
            </div>

            <div class="input-group mb-3">
                <label>Bio / Resumo</label>
                <textarea name="bio" rows="4"><?php echo $p['bio']; ?></textarea>
            </div>

            <div class="two-cols">
                <div class="input-group">
                    <label>Formação</label>
                    <input type="text" name="formacao" value="<?php echo $p['formacao']; ?>">
                </div>
                <div class="input-group">
                    <label>Disciplinas</label>
                    <input type="text" name="disciplina" value="<?php echo $p['disciplina']; ?>">
                </div>
            </div>

            <div class="input-group mb-3">
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

            <div class="input-group mb-3">
                <label>Email de Contato (Público)</label>
                <input type="email" name="email" value="<?php echo $p['email']; ?>">
            </div>

            <div class="input-group mb-3">
                <label>Foto de Perfil</label>
                <?php if ($p['pfp'])
                    echo "<img src='{$p['pfp']}' style='width:50px; height:50px; object-fit:cover; border-radius:50%; margin-bottom:5px;'>"; ?>
                <input type="file" name="foto_perfil">
            </div>

            <div class="button-group">
                <a href="dashboard.php" class="btn-secondary"
                    style="padding:10px; text-decoration:none; color:white;">Cancelar</a>
                <button type="submit" class="btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</body>

</html>