<?php
$flag4=0;

$hash=$_GET['codi'];
$correu=$_GET['mail'];

require_once('connecta_db_persistent.php');
    
$sql6 = "SELECT * FROM users WHERE activationCode='$hash'  and  mail='$correu' ";
$consulta2 = $db->query($sql6);

if($consulta2->rowCount()>0)
{
 echo $flag4;   
    $date = date('y-m-d h:i:s');
    echo $date;
    echo $hash;
    echo $correu;
    $sql2 = "UPDATE users SET activationDate ='$date' , active =1 , activationCode=NULL WHERE  mail='$correu'";
     $consulta = $db->query($sql2);
    header('Location: ./index.php?activated=1');
    exit;
}else{
    header('Location: ./index.php?activated=0');
    exit;
    
}

     





?>