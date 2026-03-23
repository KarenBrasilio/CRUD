<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Captura o parâmetro "id" enviado pela URL
 * e valida se ele é um número inteiro válido.
 *
 * Exemplo de URL:
 * edit.php?id=3
 */
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

/**
 * Se o ID não for válido, o script é interrompido.
 */
if (!$id) {
    die("ID inválido.");
}

/**
 * Obtém a conexão com o banco de dados.
 */
$pdo = Connect::getInstance();

/**
 * Prepara a consulta SQL para buscar apenas um usuário
 * com o ID informado.
 *
 * LIMIT 1 reforça que apenas um registro será retornado.
 */
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

/**
 * Executa a consulta, passando o valor do ID.
 */
$stmt->execute([":id" => $id]);

/**
 * Busca o primeiro registro encontrado.
 * Como o ID é único, esperamos apenas um usuário.
 */
$user = $stmt->fetch();

/**
 * Se nenhum aluno for encontrado, interrompe a execução.
 */
if (!$user) {
    die("Aluno não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Editar aluno</title>
</head>

<body>
    <div class="form-container">
        <h1>Editar aluno</h1>

        <!--
        Formulário responsável por enviar os dados atualizados
        para o arquivo update.php.
    -->
        <form action="update.php" method="post">
            <!--
            Campo oculto que envia o ID do aluno.
            Ele é necessário para que o update.php saiba
            qual registro deve ser atualizado.
        -->
            <input type="hidden" name="id" value="<?= $user["id"] ?>">


            <div class="input-group">
                <label>Nome:</label><br>
                <input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required>
            </div>


            <div class="input-group">
                <label>E-mail:</label><br>
                <input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
            </div>


            <div class="input-group">
                <label>Curso:</label><br>
                <input type="text" name="document" value="<?= htmlspecialchars($user["document"]) ?>" required>
            </div>

            <button type="submit" class="btn-cadastrar">Atualizar</button>
        </form>

        <p><a href="index.php">Voltar</a></p>
    </div>

    <img src="https://cliply.co/wp-content/uploads/2021/08/472108170_THANK_YOU_STICKER_400px.gif" alt="gatinho" width="600" class="gatinho">


</body>

</html>