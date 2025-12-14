<?php
include 'conexao.php';
$id = $_GET['id'] ?? null;
$proj = [];

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM projeto WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $proj = $stmt->get_result()->fetch_assoc();
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
        body { background-color: #f0f2f5; }
        .form-container { max-width: 900px; margin: 40px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center text-primary">
                <i class="fa-solid fa-folder-open"></i> <?php echo $id ? 'Editar Projeto' : 'Novo Projeto Acadêmico'; ?>
            </h2>
            
            <form action="salvar_projeto.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $proj['id'] ?? ''; ?>">

                <div class="card mb-4 border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Informações Essenciais</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Título do Projeto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="titulo" value="<?php echo $proj['titulo'] ?? ''; ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Professor Responsável <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="autor" value="<?php echo $proj['autor'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Área de Conhecimento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="area_conhecimento" value="<?php echo $proj['area_conhecimento'] ?? ''; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição Detalhada</label>
                            <textarea class="form-control" name="descricao" rows="5" required><?php echo $proj['descricao'] ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Data de Início</label>
                        <input type="date" class="form-control" name="data_inicio" value="<?php echo $proj['data_inicio'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Atual</label>
                        <select class="form-select" name="status" required>
                            <?php
                            $st = $proj['status'] ?? '';
                            $opts = ['Em andamento', 'Concluído', 'Pausado'];
                            foreach($opts as $o) {
                                $sel = ($st == $o) ? 'selected' : '';
                                echo "<option value='$o' $sel>$o</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Agência Financiadora</label>
                    <input type="text" class="form-control" name="agencia_financiadora" value="<?php echo $proj['agencia_financiadora'] ?? ''; ?>" placeholder="Ex: CNPq, Fapemig...">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Objetivos</label>
                        <textarea class="form-control" name="objetivos" rows="3"><?php echo $proj['objetivos'] ?? ''; ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Resultados Esperados/Alcançados</label>
                        <textarea class="form-control" name="resultados" rows="3"><?php echo $proj['resultados'] ?? ''; ?></textarea>
                    </div>
                </div>
                
                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="listar_projetos.php" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <?php echo $id ? 'Salvar Alterações' : 'Cadastrar Projeto'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>