<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logoWhite.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>WeTube - Consulta</title>
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
        <h1 class="display-3">Consulta de Usuários</h1>
        <hr>
    </div>

    <div class="container box boxFormulario">
<div>
    <form method="post">
        Id:<br>
        <input type="text" size="10" name="id">
        <input type="submit" class="btn btn-primary" value="Consultar">
        <hr>
    </form>
</div>

</body>
</html>

<?php

     if ($_SERVER["REQUEST_METHOD"] === 'POST') {

         include("Connection.php");

         if (isset($_POST["id"]) && (trim($_POST["id"]) != "")) {
             $id = $_POST["id"];
             $comandoSQL = $pdo->prepare("select * from users where id= :id");
             $comandoSQL->bindParam(':id', $id);
         } else {
             $comandoSQL = $pdo->prepare("select * from users order by id");
         }

         try {

            $comandoSQL->execute();

             echo "<form method='post'>";
             echo "<table class='table table-bordered table-dark' border='1px'>";
             echo "<tr>\n";
             echo "<th></th>\n";
             echo "<th>Id</th>\n";
             echo "<th>Nome</th>\n";
             echo "<th>E-mail</th>\n";
             echo "<th>Foto</th>\n";
             echo "</tr>\n";

             $filename = fopen('usuários.txt', 'w');

             while ($row = $comandoSQL->fetch()) {
                $filename = fopen('usuários.txt', 'a');

                 echo "<tr>\n";
                 echo "<td><input type='radio' name='idUser' 
                           value='" . $row['id'] . "'>\n";
                 echo "<td>" . $row['id'] . "</td>\n";

                 fwrite($filename, 'Id: ');
                 fwrite($filename, $row['id']);

                 echo "<td>" . $row['username'] . "</td>\n";

                 fwrite($filename, '/ Nome: ');
                 fwrite($filename, $row['username']);

                 echo "<td>" . $row['email'] . "</td>\n";

                 fwrite($filename, '/ E-mail: ');
                 fwrite($filename, $row['email']);

                 fwrite($filename, "\r\n");
                 fclose($filename);
                 if ($row["arquivoFoto"] == null) {
                    echo "<td align='center'>-</td>";
                } else {
                    echo "<td align='center'><img src=".$row['arquivoFoto'] . " width='50px' height='50px'></td>\n";
                }
                 echo "</tr>\n";
             }

             echo "</table>\n    
             Arquivo txt criado com as informações dos usuários
             <br><br>\n
             <button type='submit' class='btn btn-primary' formaction='Exclusao.php'>Excluir Usuário</button>\n
             <button type='submit'  class='btn btn-primary' formaction='Edicao.php'>Editar Usuário</button>\n    

             </form>";

         } catch (PDOException $e) {
             echo 'Error: ' . $e->getMessage();
         }
     }
?>