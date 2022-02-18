<?php


if (isset($_COOKIE["PHPSESSID"])!=NULL) {
    session_start();
    if(isset($_SESSION["usuari"])){
        header('Location: ./home.php');
    }else{
        include 'logout.php';
    }
}else {
        $error=0;
        $modalActivation=3;
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $usuario=$_POST['Username'];
            $Password=$_POST['Password'];
             require_once('connecta_db_persistent.php');
            try{
                $sql = "SELECT * FROM users WHERE (username='$usuario' or mail='$usuario') and active=1";
                $consulta = $db->query($sql);
                 if($consulta->rowCount()>0){
                        foreach ($consulta as $fila) {
                                 $clave=$fila['passHash'];
                                 $idusuari=$fila['iduser'];
                                }
                            if(password_verify($Password,$clave))
                            {
                                  $date = date('y-m-d h:i:s');
                                  $sql2 = "UPDATE users SET lastSignIn='$date' WHERE username='$usuario'  or mail='$usuario'";
                                  $consulta = $db->query($sql2);
                                session_start();
                                $_SESSION["usuari"] = $usuario;
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
            }else if($_SERVER["REQUEST_METHOD"] == "GET"){
              if(isset($_GET["activated"]) && $_GET["activated"]=='1'){
                $modalActivation=1;
              }else if(isset($_GET["activated"]) && $_GET["activated"]=='0'){
                $modalActivation=0;
                
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
            </form> <a data-toggle="modal" data-target="#exampleModal" id="forgot">Forget Password<br> </a>
            <div class="text-center">
            <a href="./register.php">Sign-Up</a>
            </div>
        </div>
<!-- Modal -->
<?php
             if ($modalActivation==1)
             {
              echo '<div class="modal-content" style="margin-top:18%; width:50%; margin-left:auto; margin-right:auto;">
                    <div class="modal-header">
                      <h5 class="modal-title">CUENTA ACTIVADA</h5>
                    </div>
                    <div class="modal-body">
                      <p>Tu cuenta ha sido activada. BIENVENIDO A EDUHACKS!!!</p>
                    </div>
                    <div class="modal-footer">
                      <a class="btn btn-success btn-lg btn-block" href="index.php" role="button">Volver al inicio</a>
                    </div>
              </div>';
             }else if ($modalActivation==0){
              echo '<div class="modal-content" style="margin-top:18%; width:50%; margin-left:auto; margin-right:auto;">
                    <div class="modal-header">
                      <h5 class="modal-title">CUENTA NO ACTIVADA</h5>
                    </div>
                    <div class="modal-body">
                      <p>Lo sentimos, tu cuenta no ha sido activada</p>
                    </div>
                    <div class="modal-footer">
                      <a class="btn btn-danger btn-lg btn-block" href="register.php" role="button">Volver al registro</a>
                    </div>
              </div>';
             }
  ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">RECUPERA TU CONTRASENYA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="resetPasswordSend.php" method="post">
      <div class="modal-body">
            <input id="uname" type="email" name="reEmail" placeholder="Escribe tu Correo para resetear tu contraseña" size="55" > 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Send Reset Password</button>
        </form> 
      </div>
    </div>
  </div>
</div>
    </body>
</html>


