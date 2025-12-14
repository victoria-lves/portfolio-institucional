<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Projetos</title>
    <link rel="stylesheet" href="css/style-criar-projeto.css">
    <style>
        .container-lista { max-width: 900px; margin: 50px auto; padding: 20px; background: #fff; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        .btn-acao { margin-right: 5px; text-decoration: none; font-weight: bold; }
        .editar { color: #007bff; }
        .excluir { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container-lista">
        <h1>Projetos</h1>
        <a href="criar_projeto.php" style="padding: 10px; background: #0056b3; color: white; text-decoration: none; border-radius: 4px;">+ Novo Projeto</a>
        
        <table>
            <tr><th>ID</th><th>Título</th><th>Status</th><th>Autor</th><th>Ações</th></tr>
            <?php
            $result = $conn->query("SELECT * FROM projeto");
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['titulo']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['autor']}</td>
                        <td>
                            <a href='criar_projeto.php?id={$row['id']}' class='btn-acao editar'>Editar</a>
                            <a href='excluir.php?tipo=projeto&id={$row['id']}' class='btn-acao excluir' onclick='return confirm(\"Apagar projeto?\")'>Excluir</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>