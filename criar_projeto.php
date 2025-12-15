<?php
session_start();
include 'conexao.php';

// 1. Segurança: Verifica se está logado
if (!isset($_SESSION['id_professor'])) {
    header("Location: login.php");
    exit;
}

$id_logado = $_SESSION['id_professor'];
$id = $_GET['id'] ?? null;
$proj = [];
$professores_vinculados = [];

// 2. Se for Edição, busca os dados
if ($id) {
    // Busca dados do projeto
    $stmt = $conn->prepare("SELECT * FROM projeto WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $proj = $stmt->get_result()->fetch_assoc();

    // Busca os professores que já estão nesse projeto (tabela de ligação)
    $stmt_link = $conn->prepare("SELECT id_professor FROM professor_projeto WHERE id_projeto = ?");
    $stmt_link->bind_param("i", $id);
    $stmt_link->execute();
    $res_link = $stmt_link->get_result();

    while ($row = $res_link->fetch_assoc()) {
        $professores_vinculados[] = $row['id_professor'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Editar Projeto' : 'Novo Projeto'; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .card-header-custom {
            background-color: #e8f5e9;
            color: #006400;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .info-box {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-success mb-0">
                    <i class="fa-solid fa-folder-plus"></i> <?php echo $id ? 'Editar Projeto' : 'Novo Projeto'; ?>
                </h2>
                <a href="dashboard.php" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i>
                    Voltar</a>
            </div>

            <form action="salvar_projeto.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $proj['id'] ?? ''; ?>">

                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header card-header-custom">Informações Principais</div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Título do Projeto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="titulo"
                                value="<?php echo htmlspecialchars($proj['titulo'] ?? ''); ?>" required
                                placeholder="Ex: Desenvolvimento de Liga Metálica...">
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Professores Participantes <span
                                        class="text-danger">*</span></label>
                                <div class="info-box">
                                    <small><i class="fa-solid fa-circle-info"></i> Segure a tecla <strong>CTRL</strong>
                                        (ou Command no Mac) para selecionar mais de um professor.</small>
                                </div>
                                <select class="form-select" name="professores[]" multiple required
                                    style="height: 180px;">
                                    <?php
                                    // Busca todos os professores para preencher a lista
                                    $sql_all = "SELECT id, nome FROM professor ORDER BY nome ASC";
                                    $res_all = $conn->query($sql_all);

                                    while ($p = $res_all->fetch_assoc()) {
                                        $selected = '';

                                        // Cenário 1: Edição - Verifica se o ID está no array de vinculados
                                        if ($id && in_array($p['id'], $professores_vinculados)) {
                                            $selected = 'selected';
                                        }
                                        // Cenário 2: Novo Projeto - Seleciona automaticamente o usuário logado
                                        elseif (!$id && $p['id'] == $id_logado) {
                                            $selected = 'selected';
                                        }

                                        echo "<option value='{$p['id']}' $selected>{$p['nome']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Área de Conhecimento</label>
                                <input type="text" class="form-control" name="area_conhecimento"
                                    value="<?php echo htmlspecialchars($proj['area_conhecimento'] ?? ''); ?>" required
                                    placeholder="Ex: Informática, Metalurgia...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agência Financiadora</label>
                                <input type="text" class="form-control" name="agencia_financiadora"
                                    value="<?php echo htmlspecialchars($proj['agencia_financiadora'] ?? ''); ?>"
                                    placeholder="Ex: CNPq, Fapemig (Opcional)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header card-header-custom">Detalhes do Projeto</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Descrição Resumida</label>
                            <textarea class="form-control" name="descricao" rows="4" required
                                placeholder="Resumo do que se trata o projeto..."><?php echo htmlspecialchars($proj['descricao'] ?? ''); ?></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Data de Início</label>
                                <input type="date" class="form-control" name="data_inicio"
                                    value="<?php echo $proj['data_inicio'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <?php
                                    $st = $proj['status'] ?? '';
                                    $opts = ['Em andamento', 'Concluído', 'Pausado'];
                                    foreach ($opts as $o) {
                                        $sel = ($st == $o) ? 'selected' : '';
                                        echo "<option value='$o' $sel>$o</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Objetivos</label>
                                <textarea class="form-control" name="objetivos"
                                    rows="3"><?php echo htmlspecialchars($proj['objetivos'] ?? ''); ?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Resultados (Esperados ou Finais)</label>
                                <textarea class="form-control" name="resultados"
                                    rows="3"><?php echo htmlspecialchars($proj['resultados'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="dashboard.php" class="btn btn-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn btn-success px-4 fw-bold">
                        <i class="fa-solid fa-save"></i> <?php echo $id ? 'Salvar Alterações' : 'Cadastrar Projeto'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>