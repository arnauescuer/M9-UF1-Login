<?php
$hash=$_GET['codi'];
$correu=$_GET['mail'];

require_once('connecta_db_persistent.php');
    
$sql6 = "SELECT * FROM users WHERE resetPassCode='$hash'  and  mail='$correu' ";
$consulta2 = $db->query($sql6);

if($consulta2->rowCount()>0)
{
    $date = date('y-m-d h:i:s');
    // echo $date;
    // echo $hash;
    // echo $correu;

    $sql2 = "SELECT  resetPassExpiry from users WHERE  mail='$correu'";
    $consulta = $db->query($sql2);
    
    $sql3 = "SELECT DATEDIFF(minute , resetPassExpiry, '$date') from users where mail='$correu'";
    $tiempo = $db->query($sql3);
    echo $tiempo;
    if($tiempo <=1)
    {
         echo "hola";
    }else{
        echo "Ha pasat el temps";

    }
    //mirar si ha pasat mes de 30m i dir que no funciona sino funciona

    //pillar con un select los minutos que hemos introducido anteriormente , si no supera 30m  muestre un formulario para poner la contraseña y luego hacer un insert con esa contraseña.
    // Una vez hecho un redirect habra que enviar un correo diciendo que se ha canviado la contraseña

    
    // //con un if mirar si ha superado mas de 30 m , da error sino hacer un insert de la contraseña

    // $sql2 = "UPDATE users SET activationDate ='$date' , active =1 , activationCode=NULL WHERE  mail='$correu'";
    // $consulta = $db->query($sql2);
    // header('Location: ./index.php');
    // echo '<div class="jumbotron">
    //         <h1 class="display-4">Cuenta Activada</h1>
    //         <p class="lead">Tu cuenta ha sido activada!!!! Bienvenido a EduHacks.</p>
    //         <hr class="my-4">
    //         <a class="btn btn-primary btn-lg" href="#" role="button">Come On</a>
    //     </div>'; 
    
}else{
    echo "Link Caducat o erroni";
}

