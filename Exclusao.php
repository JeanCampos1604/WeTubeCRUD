<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logoWhite.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>WeTube - Exclusão do Usuário</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">
                <img src="img/logoWhite.png" alt="" width="45" height="34" class="d-inline-block align-text-center">
                WeTube
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="btn btn-primary" href="Consulta.php" role="button">Retornar para Consultas</a>
    </nav>
    <br>
<hr>

<div class="container box boxPrincipal max-width">
        <h1 class="display-3">Usuário excluído com sucesso!</h1>
        <hr>
    </div>

    <div class="container box boxEdicao">

</body>
</html>

<?php

if (!isset($_POST["idUser"])) {
    echo "Selecione o usuário a ser excluído!";
} else {
    include("Connection.php");

    $id = $_POST["idUser"];

    try {

        $comandoSQL = $pdo->prepare('SELECT arquivoFoto FROM users WHERE id = :id');
        $comandoSQL->bindParam(':id', $id);
        $comandoSQL->execute();
        $row = $comandoSQL->fetch();
        $arquivoFoto = $row["arquivoFoto"];

        $comandoSQL = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $comandoSQL->bindParam(':id', $id);
        $comandoSQL->execute();

        if ($arquivoFoto != null) {
            unlink($arquivoFoto);
        }

        echo "O usuário de Id $id foi removido!";

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

?>