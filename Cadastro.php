<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logoWhite.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>WeTube - Cadastro</title>

    <style>
        #sucess {
            color: green;
            font-weight: bold;
        }

        #error {
            color: red;
            font-weight: bold;
        }

        #warning {
            color: orange;
            font-weight: bold;
        }
    </style>


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
    </nav>
    <br>

    <div class="container box boxPrincipal max-width">
        <h1 class="display-3">Cadastrar</h1>
        <hr>
    </div>

    <div class="container box boxFormulario">

        <form method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="form-group col-md-6 col-sm-12">
                    <label>Email:</label>
                    <input type="text" class="form-control form-control-sm" placeholder="" name="email" required>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label>Senha:</label>
                    <input type="password" class="form-control form-control-sm" placeholder="" name="senha" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 col-sm-12">
                    <label>Nome:</label>
                    <input type="text" class="form-control" placeholder="" name="nome" required>
                </div>
            </div>
            <div class="form-group">
                <label for="file">Foto:</label> <br>
                <input type="file" class="form-control-file" name="foto" accept="image/gif, image/png, image/jpeg">
            </div>
            <br>
            <button type="submit" class="btn btn-primary" value="Cadastrar" name="cadastrar" >Cadastrar</button>
        </form>

<?php

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    include("Connection.php");

    define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

    try {
        $email = $_POST["email"];
        $nome = $_POST["nome"];
        $senha = $_POST["senha"];

        $foto = $_FILES['foto'];
        $nomeFoto = $foto['name'];
        $tipoFoto = $foto['type'];
        $tamanhoFoto = $foto['size'];

        if ((trim($nome) == "") || (trim($senha) == "") || (trim($email) == "")) {
            echo "<span id='warning'>Todos os campos são obrigatórios!</span>";
        } else if (($nomeFoto != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $tipoFoto))) {
            echo "<span id='error'>Isso não é uma imagem válida</span>";
        } else if ($tamanhoFoto > TAMANHO_MAXIMO) {
            echo "<span id='error'>A imagem deve possuir no máximo 2 MB</span>";
        } else {
            $comandoSQL = $pdo->prepare("select * from users where id = :id");
            $comandoSQL->bindParam(':id', $id);
            $comandoSQL->execute();

            $rows = $comandoSQL->rowCount();

            if ($rows <= 0) {

                $uploaddir = 'upload/fotos/';

                $info = new SplFileInfo($nomeFoto);
                $extensaoArq = $info->getExtension();
                $novoNomeFoto = $id . "." . $extensaoArq;

                if (($nomeFoto != "") && (move_uploaded_file($_FILES['foto']['tmp_name'], $uploaddir . $novoNomeFoto))) {
                    $uploadfile = $uploaddir . $novoNomeFoto; 
                } else {
                    $uploadfile = null;
                    echo "Sem upload de imagem.<br>";
                }

                $comandoSQL = $pdo->prepare("insert into users (email, username, password, arquivoFoto) values(:email, :nome, :senha, :arquivoFoto)");
                $comandoSQL->bindParam(':email', $email);
                $comandoSQL->bindParam(':nome', $nome);
                $comandoSQL->bindParam(':senha', $senha);
                $comandoSQL->bindParam(':arquivoFoto', $uploadfile);
                $comandoSQL->execute();

                echo "<span id='sucess'>Usuário Cadastrado!</span><br><br>";

               // echo "<button type='submit' class='btn btn-primary' action='envioEmail.php'> Clique aqui para receber um e-mail de confirmação</button>\n";
            } else {
                echo "<span id='error'>Id já existente!</span>";
            }
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

</div>

</body>

</html>