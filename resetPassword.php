<?php
$hash=$_GET['codi'];
$correu=$_GET['mail'];

require_once('connecta_db_persistent.php');
    
$sql6 = "SELECT * FROM users WHERE resetPassCode='$hash'  and  mail='$correu' and resetPassExpiry>=now()";
$consulta2 = $db->query($sql6);

if($consulta2->rowCount()>0)
{
    
   
    // $sql2 = "UPDATE users SET resetPassExpiry=addtime(now(),3000) WHERE  mail='$correu'";
    // $consulta4 = $db->query($sql2);
    //header("location: ./index.php?passwordreset=1"."&rescorreu=".$_GET['mail']."");
    header('Location: ./index.php?passwordreset=1&correo='.$correu); //tenemos que poner el & 
    exit;
}else{
    echo "Link Caducat o erroni";
    header('Location: ./index.php?passwordreset=0');
    exit;
}

