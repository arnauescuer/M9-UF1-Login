<?php

$flag=0;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usuario=$_POST['Username'];
    $email=$_POST['email'];
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $password=$_POST['password'];
    $passwordverify=$_POST['passwordverify'];
    
    if($password===$passwordverify){
        $hashpass = password_hash($password, PASSWORD_DEFAULT);
        require_once('connecta_db_persistent.php');
        //MOSTRAR SI LAS CONTRASEÑAS NO COINCIDEN
    
        $sql6 = "SELECT * FROM users WHERE username='$usuario'  or mail='$email' ";
        $consulta2 = $db->query($sql6);
        
        if($consulta2->rowCount()>0){
          $flag=1;
            echo "El usuari ya existeix";
        }else{
          $sql4 = "SELECT * FROM users";
          $consulta= $db->query($sql4);
          $rowid= $consulta->rowCount();
          $rowid = $rowid+1;
          echo $rowid;
          $date = date('y-m-d h:i:s');
          $sql3 = " INSERT INTO users (iduser,mail,username,passHash,userFirstName,userLastName,creationDate,removeDate,lastSignIn,active) VALUES ('$rowid', '$email', '$usuario','$hashpass','$firstname','$lastname','$date','$date','$date','1')";
          $consulta = $db->query($sql3);
          header('Location: ./index.php');  
        }

    }else{
      $flag=2;
    }
  
  }
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="./css2.css">
  <title>Formulario Registro</title>
</head>
<body>
    <div class="loginBox"><img class="user" src="https://media3.giphy.com/media/3kK6buLfWXNNSHLObM/giphy.gif?cid=790b7611cfa283cc98cc1e89866581b78a1e11b3cbfd2b4f&rid=giphy.gif&ct=s" height="250px" width="250px">
            <form action="register.php" method="post">
            <?php

                  if ($flag==1)
                  {
                    echo "<h3>Usuari o Email</h3>" ;
                    echo "<h3>Incorrectes</h3>" ;
                  }
                  if ($flag==2)
                  {
                    echo "<h3>Contraseña</h3>" ;
                    echo "<h3>Incorrectes</h3>" ;
                  }
                  ?>
                <div class="inputBox"> <input id="uname" type="text" name="Username" placeholder="Username" required> <input id="email" type="email" name="email" placeholder="Email" required > <input id="firstname" type="text" name="firstname" placeholder="First Name"> <input id="lastname" type="text" name="lastname" placeholder="Last Name"> <input id="password" type="password" name="password" placeholder="Password" required ><input id="passwordverify" type="password" name="passwordverify" placeholder="Verify Password" required></div> <input type="submit" name="" value="Login">
            </form>
            <div class="text-center">
            <a href="./register.php">Sign-Up</a>
            </div>
        </div>
            </form>
</body>
</html>
