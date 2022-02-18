<?php
    require_once('connecta_db_persistent.php');
    use PHPMailer\PHPMailer\PHPMailer;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $correo=$_POST['reEmail'];

          $date = date('y-m-d h:i:s');
          //  Ponemos el camp de active sea = 0
          $aleatorio=rand(0,1000);
          $hash = hash('sha256',$aleatorio);
          $sql3 = " UPDATE  users  SET resetPassExpiry = '$date' ,  resetPassCode='$hash'  WHERE  mail='$correo' ";
          $consulta = $db->query($sql3);

    }
    //$correu=$_SESSION["email"];   
    require 'vendor/autoload.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg error
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
     $codi=$hash;
    //Credencials del compte GMAIL
    $mail->Username = 'adria.herrerosl@educem.net';
    $mail->Password = '7632S@2122';
    //Destinatari
    $address =$correo;
    $mail->AddAddress($address, 'Test');

    //Dades del correu electrònic
    $mail->SetFrom('support@eduhacks.com','Support');
    $mail->Subject = 'Correu Canvi Contrasenya';
    $mail->MsgHTML( '<title>Canvia la contraseña ya</title></head>'.
	'<body><img src="https://media3.giphy.com/media/3kK6buLfWXNNSHLObM/giphy.gif?cid=790b7611cfa283cc98cc1e89866581b78a1e11b3cbfd2b4f&rid=giphy.gif&ct=s" height="250px" width="250px" width="500" height="600">'.
	'<p>Benvingut a Eduhacks!!!! Fes click en el seguent enllaç per modificar la contraseña</p>'.
	'<a href="http://localhost/EJCRISMAS/resetPassword.php?codi='.$codi.'&mail='.$correo.'" target="_blank" title="Link de Verificacio" rel="nofollow">I want to Reset My Password</a>'.
	'</body>');

    //Enviament
    $result = $mail->Send();
    if(!$result){
        echo 'Error: ' . $mail->ErrorInfo;
    }else{
        echo "Correu enviat";
        
    }