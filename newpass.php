<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $correu=$_POST['recorreu'];
        $respass1=$_POST['respass1'];
        $respass2=$_POST['respass2'];
          if($respass1===$respass2){

              $hashpass = password_hash($respass1, PASSWORD_DEFAULT);
              require_once('connecta_db_persistent.php');
              $sql6 = "SELECT * FROM users WHERE  mail='$correu' ";
              $consulta2 = $db->query($sql6);

             if($consulta2->rowCount()>0){
                $aleatorio=rand(0,1000);
                $hash = hash('sha256',$aleatorio);
                $sql3 = "UPDATE users  SET passHash = '$hashpass' WHERE mail='$correu' ";
                $consulta = $db->query($sql3);
                include('resetPasswordMail.php');
                header('Location: ./index.php');  
             }
        }else{
            echo "No entra";
            //la contrasenya no coincide passwordreset0 y mostrar el popup
        }
    }
?>