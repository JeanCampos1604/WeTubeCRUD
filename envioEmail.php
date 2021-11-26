<?php

	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require 'vendor/autoload.php';

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
	    //Server settings	    
	    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
	    echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
	    $mail->isSMTP(); //Send using SMTP
	    $mail->Host       = 'smtp.gmail.com'; //smtp.example.com - Set the SMTP server to send through
	    $mail->SMTPAuth   = true; //Enable SMTP authentication
	    $mail->Username   = 'wetubecorp@gmail.com'; //SMTP username
	    $mail->Password   = 'SenhaSuperSecreta1234'; //SMTP password

	    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	    //$mail->Port       = 587; 

	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
	    $mail->Port       = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	    //Recipients
		
		$email = $_POST["email"];
		$nome = $_POST["nome"];
		$id = $_POST["id"];
	    $mail->setFrom('wetubecorp@gmail.com', 'Webtube Corporation');
	    $mail->addAddress($email, 'Joe User'); //Add a recipient
	    //$mail->addAddress('ellen@example.com'); //Name is optional
	    //$mail->addReplyTo('info@example.com', 'Simone');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name
	    //Content
	    $mail->isHTML(true); //Set email format to HTML
	    $mail->Subject = 'Sua Conta foi criado com sucesso!';
	    $mail->Body    = 'Seja bem vindo(a), ao melhor serviço de Streaming já criado! 
		<br> O Wetube tem seus vídeos, memes e filmes favoritos na palma de sua mão!
		<br> Antes de começarmos, poderia conferir seus dados?
		Nome:$nome <br> E-mail:$email <br> Id:$id <br> Caso tenha algum problema'; 

	    $mail->send();
	    echo 'Mensagem enviada!';
	} catch (Exception $e) {
	    echo "Não foi possível enviar a mensagem! Erro: {$mail->ErrorInfo}";
	}

?>