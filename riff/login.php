<?php
session_start();
require('php/functions.php');
$id = 0;
if (!empty($_POST['btnIng'])){
    
    $legajo = $_POST['legajo1'];
    $pass = $_POST['pass'];
    $id = validar_login($legajo,$pass);
    tipo_error($id);
    
    
    
}
if (!empty($_POST['cambiar'])){
    $legajo = $_POST['legajo'];
    $pass = $_POST['passv'];
    $passn = $_POST['passn'];
    $id = change_pass($legajo,$pass,$passn);
    tipo_error($id);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riff-Login</title>
    <link rel="stylesheet" href="plugins/sweetalert2.min.css">
    <link rel="stylesheet" href="css/estilos2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container">
        
            <form role="form" class="form" method="POST">
                <h2>INGRESO</h2>
                <input id="user" type="text" name="legajo1" class="input" minlength="6" maxlength="6"
                            placeholder="LEGAJO" required>
                
                <input id="pass" type="password" name="pass" class="input" data-type="password" maxlength="8"
                            placeholder="PASSWORD" required>
                <input type="submit" name="btnIng" value="INGRESAR" id="submit" >
                
            </form>
            
            <div class="side">
                <img src="/riff/images/logo.png" alt="IMAGEN">
            </div>
        
    </div>
    
</body>

</html>