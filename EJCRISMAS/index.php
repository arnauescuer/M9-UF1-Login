<?php
if (isset($_COOKIE["usuari"]) !=NULL) {
    // session_start();
    // if(session_status() === PHP_SESSION_ACTIVE)
    // {
    
    // }
    header('Location: ./home.php');  
}else {
        $error=0;
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $usuario=$_POST['Username'];
            $Password=$_POST['Password'];
             require_once('connecta_db_persistent.php');
            try{
                $sql = "SELECT * FROM users WHERE username='$usuario'  or mail='$usuario' and active = 1";
                $consulta = $db->query($sql);
                 if($consulta->rowCount()>0){
                        foreach ($consulta as $fila) {
                                 $clave=$fila['passHash'];
                                 $idusuari=$fila['iduser'];
                                }
                            if(password_verify($Password,$clave))
                            {
                                  $date = date('y-m-d h:i:s');
                                  $sql2 = "UPDATE users SET lastSignIn='$date' WHERE username='$usuario'  or mail='$usuario' and active = 1 ";
                                  $consulta = $db->query($sql2);
                                session_start();
                                $_SESSION["usuari"] = $usuario;
                                setcookie("usuari", $usuario, time() + 60*60*24);
                                 header('Location: ./home.php');  
                            } else{
                                $error=1;
                            }
                     }else {
                        $error=1;
                     }
                }catch(PDOException $e){
                echo 'Error amb la BDs: ' . $e->getMessage();
                }
            }
        }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>EduHacks</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <link rel="stylesheet" type="text/css" href="./css2.css">
    </head>
    <body>

            <div class="loginBox"> <img class="user" src="https://media3.giphy.com/media/3kK6buLfWXNNSHLObM/giphy.gif?cid=790b7611cfa283cc98cc1e89866581b78a1e11b3cbfd2b4f&rid=giphy.gif&ct=s" height="250px" width="250px">
            <?php

             if ($error==1)
             {
                echo "<h3>Usuari o Contraseña</h3>" ;
                echo "<h3>Incorrectes</h3>" ;
             }else {
               echo "<h3>Sign in here</h3>" ;
             }
            ?>
            <form action="index.php" method="post">
                <div class="inputBox"> <input id="uname" type="text" name="Username" placeholder="Username"> <input id="pass" type="password" name="Password" placeholder="Password"> </div> <input type="submit" name="" value="Login">
            </form> <a href="#">Forget Password<br> </a>
            <div class="text-center">
            <a href="./register.php">Sign-Up</a>
            </div>
        </div>
    </body>
</html>


