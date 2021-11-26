<?php

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cpf = $_POST["cpf"];
        $cep = $_POST["cep"];


    } else {
        $nome = "";
        $email = "";
        $cpf = "";
        $cep = "";          
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logoWhite.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logoWhite.png">
    <link rel="manifest" href="/site.webmanifest">
    <script src="https://api.hgbrasil.com/weather?woeid=452041"></script>
    <title>WeTube - PLUS</title>

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
        <h1 class="display-3">Venha ser Plus!</h1>
        <h4>Por apenas R$4,99 mensais</h4>
        <br>
        <h6>Vantagens: <br> - Nenhuma :) <br> - Nenhuma 2 <br> - Nenhuma 3</h6>
        <hr>

        <br>
        <h2 class="display-5">Gerar boleto:</h2>

    </div> 

    <div class="container box boxFormulario"> <!--inicio container form-->

        <form method="post"  enctype="multipart/form-data">

            <div class="row">
                <div class="form-group col-md-6 col-sm-12">
                    <label>Nome:</label>
                    <input type="text" class="form-control" placeholder="" name="nome" value="<?php echo $nome; ?>">
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label>CPF:</label>
                    <input type="text" class="form-control" placeholder="" name="cpf" value="<?php echo $cpf; ?>">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6 sm-12">
                    <label>E-mail:</label>
                    <input type="text" class="form-control form-control-sm" placeholder="" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group col-md-6 sm-12">
                    <label>Cep:</label>
                    <input type="text" class="form-control form-control-sm" placeholder="" name="cep" value="<?php echo $cep; ?>">
                </div>
                ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
                <button class="btn btn-primary" type="submit" value="Buscar">Buscar Cep</button>
            </div>
            
            <br>
            <!-- <button type="submit" class="btn btn-primary" value="Cadastrar" name="cadastrar" >Cadastrar</button>

            <button type='submit' class="btn btn-primary" formaction='envioEmail.php'>Deseja receber um e-mail de confirmação?</button>;  -->

<?php

/* esse if permite fazer o post sem action no form, executando o php da mesma página */

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $cep = $_POST["cep"];
    $link = "https://viacep.com.br/ws/$cep/json/";

    $ch = curl_init($link);

    //setando opções da biblioteca
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //indica que espero um retorno
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //p/ não precisar validar https

    $response = curl_exec($ch);

    curl_close($ch);

    $dados = json_decode($response, true); //tranforma o resultado json em um array

    //print_r($dados);

    $rua = $dados["logradouro"];
    $bairro = $dados["bairro"];
    $localidade = $dados["localidade"];
    $uf = $dados["uf"];

    echo  "<br>
    <div class='row'>\n
        <div class='form-group col-md-6 col-sm-12'>\n
            <label>Rua:</label>\n
            <input type='text' class='form-control form-control-sm' placeholder='' name='rua' value='$rua'>\n
        </div>\n
        <div class='form-group col-md-6 col-sm-12'>\n
            <label>Bairro:</label>\n
            <input type='text' class='form-control form-control-sm' placeholder='' name='bairro' value='$bairro'>\n
        </div>\n
    </div>\n";

    echo  "
    <div class='row'>\n
        <div class='form-group col-md-6 col-sm-12'>\n
            <label>Cidade:</label>\n
            <input type='text' class='form-control form-control-sm' placeholder=''name='localidade' value='$localidade'>\n
        </div>\n
        <div class='form-group col-md-6 col-sm-12'>\n
            <label>Estado:</label>\n
            <input type='text' class='form-control form-control-sm' placeholder='' name='uf' value='$uf'>\n
        </div>\n
    </div>
    </form>
    ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
    <form action='./boleto.php' method='get'  enctype='multipart/form-data'>\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
        <input type='hidden' name='nome' value='$nome'>
        <input type='hidden' name='cpf' value='$cpf'>
        <input type='hidden' name='rua' value='$rua'>
        <input type='hidden' name='cep' value='$cep'>
        <input type='hidden' name='localidade' value='$localidade'>
        <input type='hidden' name='uf' value='$uf'>
        <div class='row'>⠀⠀⠀
            <button class='btn btn-primary' type='submit' >Gerar Boleto</button>
        </div>
        
    </form>\n
    </div>\n <!--fim container form-->";
    
}
?>
    </body>
</html>