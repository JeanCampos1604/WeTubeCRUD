<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logoWhite.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>WeTube - Alteração de Usuário</title>
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
        <h1 class="display-3">Usuário editado com sucesso!</h1>
        <hr>
    </div>

    <div class="container box boxEdicao">

</body>
</html>

<?php

    include("Connection.php");
    define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

    $uploaddir = 'upload/fotos/';

    $id = $_POST['id'];
    $novoNome = $_POST['nome'];
    $novoEmail = $_POST['email'];

    $novaFoto = $_FILES['foto'];
    $nomeFoto = $novaFoto['name'];
    $tipoFoto = $novaFoto['type'];
    $tamanhoFoto = $novaFoto['size'];

    $info = new SplFileInfo($nomeFoto);
    $extensaoArq = $info->getExtension();
    $novoNomeFoto = $id . "." . $extensaoArq;

    if ( ($nomeFoto != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $tipoFoto)) ) {
        echo "<span id='error'>Isso não é uma imagem válida</span>";
   
       } else if ( ($nomeFoto != "") && ($tamanhoFoto > TAMANHO_MAXIMO) ) { 
           echo "<span id='error'>A imagem deve possuir no máximo 2 MB</span>";
       } else if (($nomeFoto != "") && (move_uploaded_file($_FILES['foto']['tmp_name'], $uploaddir . $novoNomeFoto))) {
           $uploadfile = $uploaddir . $novoNomeFoto; // caminho/nome da imagem
   
           $comandoSQL = $pdo->prepare('UPDATE users SET username = :novoNome, email = :novoEmail, arquivoFoto = :novaFoto WHERE id = :id');
           $comandoSQL->bindParam(':novoNome', $novoNome);
           $comandoSQL->bindParam(':novoEmail', $novoEmail);
           $comandoSQL->bindParam(':novaFoto', $uploadfile);
           $comandoSQL->bindParam(':id', $id);
   
       } else {
           //senão mantem a foto anterior, não fazendo update do campo arquivoFoto
           $comandoSQL = $pdo->prepare('UPDATE users SET username = :novoNome, email = :novoEmail WHERE id = :id');
           $comandoSQL->bindParam(':novoNome', $novoNome);
           $comandoSQL->bindParam(':novoEmail', $novoEmail);
           $comandoSQL->bindParam(':id', $id);
       }

    try {
        $comandoSQL->execute();

        echo "Os dados do user de id $id foram alterados!";

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

?>