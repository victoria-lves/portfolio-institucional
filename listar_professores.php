<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Professores</title>
    <link rel="stylesheet" href="css/style-editar-perfil.css"> 
    <style>
        .container-lista { max-width: 900px; margin: 50px auto; padding: 20px; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; }
        .btn-novo { display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; }
        .btn-editar { color: #007bff; text-decoration: none; font-weight: bold; }
        .btn-excluir { color: #dc3545; text-decoration: none; margin-left: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container-lista">
        <h1>Professores Cadastrados</h1>
        <a href="criar_perfil.php" class="btn-novo">+ Novo Professor</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Gabinete</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM professor";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['gabinete'] . "</td>";
                        echo "<td>
                                <a href='criar_perfil.php?id=" . $row['id'] . "' class='btn-editar'>Editar</a>
                                <a href='excluir.php?tipo=professor&id=" . $row['id'] . "' class='btn-excluir' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum professor cadastrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <a href="index.html">Voltar para Home</a> </div>
</body>
</html>