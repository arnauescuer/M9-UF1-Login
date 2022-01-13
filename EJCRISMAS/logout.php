<?php
session_destroy();
setcookie("usuari", null, time() - 60*60*24); 
header('Location: ./index.php');
 
