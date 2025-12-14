<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;
$p = []; 

// READ: Se tem ID, busca os dados
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM professor WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $p = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Editar Perfil' : 'Novo Perfil'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; }
        .form-container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .img-preview { width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #dee2e6; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center text-primary">
                <i class="fa-solid fa-user-tie"></i> <?php echo $id ? 'Editar Perfil' : 'Cadastrar Professor'; ?>
            </h2>

            <form action="salvar_perfil.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $p['id'] ?? ''; ?>">

                <h5 class="text-secondary border-bottom pb-2 mb-3">Informações Gerais</h5>
                
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $p['nome'] ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Bio / Descrição</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo $p['bio'] ?? ''; ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="formacao" class="form-label">Formação</label>
                        <input type="text" class="form-control" name="formacao" value="<?php echo $p['formacao'] ?? ''; ?>" placeholder="Ex: Doutor em Física">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="disciplina" class="form-label">Disciplina</label>
                        <input type="text" class="form-control" name="disciplina" value="<?php echo $p['disciplina'] ?? ''; ?>" placeholder="Ex: Cálculo I">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Foto de Perfil</label>
                    <?php if(!empty($p['pfp'])): ?>
                        <img src="<?php echo $p['pfp']; ?>" alt="Foto Atual" class="img-preview">
                    <?php endif; ?>
                    <input type="file" class="form-control" name="foto_perfil" accept="image/*">
                </div>

                <h5 class="text-secondary border-bottom pb-2 mb-3 mt-4">Contato e Localização</h5>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" value="<?php echo $p['email'] ?? ''; ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Link do Lattes</label>
                        <input type="url" class="form-control" name="lattes" value="<?php echo $p['lattes'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Link do LinkedIn</label>
                        <input type="url" class="form-control" name="linkedin" value="<?php echo $p['linkedin'] ?? ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gabinete" class="form-label">Gabinete / Área</label>
                        <select class="form-select" name="gabinete" required>
                            <option value="" disabled selected>Selecione...</option>
                            <?php 
                                $gab = $p['gabinete'] ?? ''; 
                                $opcoes = ['Administração', 'Humanas', 'Informática', 'Linguagens', 'Matemática', 'Metalurgia', 'Naturezas'];
                                foreach($opcoes as $opt) {
                                    $selected = ($gab == $opt) ? 'selected' : '';
                                    echo "<option value='$opt' $selected>$opt</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Horários de Atendimento</label>
                        <input type="text" class="form-control" name="atendimento" value="<?php echo $p['atendimento'] ?? ''; ?>" placeholder="Ex: Seg e Qua 14h-16h">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="listar_professores.php" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa-solid fa-save"></i> <?php echo $id ? 'Salvar Alterações' : 'Cadastrar'; ?>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>