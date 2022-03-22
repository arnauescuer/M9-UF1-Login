<?php

    use PHPMailer\PHPMailer\PHPMailer;
    require_once "register.php";
    //$correu=$_SESSION["email"];
    require 'vendor/autoload.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg error
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $codi=$hash;
    //Credencials del compte GMAIL
    $mail->Username = '';
    $mail->Password = '7632S@2122';

    //Dades del correu electrònic
    $mail->SetFrom('support@eduhacks.com','Support');
    $mail->Subject = 'Correu de Confirmaccio';
    $mail->MsgHTML( '<title>Active your account Now!</title></head>'.
	'<body><img src="https://media3.giphy.com/media/3kK6buLfWXNNSHLObM/giphy.gif?cid=790b7611cfa283cc98cc1e89866581b78a1e11b3cbfd2b4f&rid=giphy.gif&ct=s" height="250px" width="250px" width="500" height="600">'.
	'<p>Benvingut a Eduhacks!!!! Fes click en el seguent enllaç per verificar la compte creada</p>'.
	'<a href="http://localhost/EJCRISMAS/mailCheckAccount.php?codi='.$codi.'&mail='.$email.'" target="_blank" title="Link de Verificacio" rel="nofollow">Link de Verificacio</a>'.
	'</body>');

    // 

    //Destinatari
    $address =$email;
    $mail->AddAddress($address, 'Test');

    //Enviament
    $result = $mail->Send();
    if(!$result){
        echo 'Error: ' . $mail->ErrorInfo;
    }else{
        
    }
