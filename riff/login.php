<?php
session_start();
require('php/functions.php');
$id = 0;
if (!empty($_POST['btnIng'])) {

    $legajo = $_POST['legajo1'];
    $pass = $_POST['pass'];
    $id = validar_login($legajo, $pass);
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
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="plugins/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->

</head>

<body class="text-center">
    <form class="form-signin" role="form" method="POST">
      <img class="mb-4" src="images/logo.png" alt="" width="150" height="150">
      <h1 class="h3 mb-3 font-weight-normal">INGRESO</h1>
      <!-- <label for="inputEmail" class="sr-only">Email address</label> -->
      <input type="text" id="user" name = "legajo1" class="form-control" placeholder="Legajo" required minlength="6" maxlength="6" autofocus>
      <!-- <label for="inputPassword" class="sr-only">Password</label> -->
      <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña" maxlength="8" required>
      
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnIng" value="INGRESAR" id="submit">Ingresar</button><br><br><br>
      <a href="#" name="btnClave" id="link_reset_pass" >Reset password</a>
      
      <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
    </form>
    <script>
      document.getElementById('link_reset_pass').addEventListener('click', function (e) {
    
    e.preventDefault();
    var legajo = document.getElementById('user').value
    if(legajo==""){

        Swal.fire({
            title: 'Complete legajo',
            icon: 'error',
        })
        return 0

    }
    Swal.fire({
        icon: 'warning',
        text: 'La contraseña se reseteará y será su dni',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            const xhr = new XMLHttpRequest();
            const url = 'http://127.0.0.1:5000/olvida_clave/' + legajo;
            xhr.open('PUT', url);
            xhr.setRequestHeader("Accept", "application/json");
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.send();
            console.log(xhr)
            xhr.onreadystatechange = function () {
                
                if (xhr.readyState === 4 && xhr.status == 200) {
                    
                    Swal.fire({
                        title: 'Contraseña reseteada!',
                        icon: 'success',
                    })
                }
                else{
                    Swal.fire({
                        title: 'Legajo inexistente',
                        icon: 'error',
                    })
                    return 0
                }

            };

        }

    })
});
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="plugins/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/main.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>