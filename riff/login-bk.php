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

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/estilos.css?v=<?php echo time();?>" type="text/css">
    
</head>

<body oncontextmenu='return false' class='snippet-body'>
    
    <div class="row">
        <div class="col-md-6 mx-auto p-0">
            <div class="card">
                <div class="login-box">
                    <div class="login-snip"> <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label
                            for="tab-1" class="tab">Login</label> <input id="tab-2" type="radio" name="tab"
                            class="sign-up"><label for="tab-2" class="tab">Cambiar Pass</label>
                        <div class="login-space">
                            <form role="form" method="POST">
                            <div class="login">
                                <div class="group"> <label for="user" class="label">Legajo</label> <input id="user"
                                        type="text" name = "legajo1" class="input" minlength="6" maxlength="6" placeholder="Ingresar legajo sin u" required> </div>
                                <div class="group"> <label for="pass" class="label">Password</label> <input id="pass"
                                        type="password" name="pass" class="input" data-type="password" maxlength="8"
                                        placeholder="Ingresar Password" required> </div>
                                <!--<div class="group"> <input id="check" type="checkbox" class="check" checked> <label
                                        for="check"><span class="icon"></span> Keep me Signed in</label> </div>-->
                                <div class="group"> <input type="submit" class="button" name="btnIng" value="Ingresar"> </div>
                                
                                <div class="hr"></div>
                                <!-- <div class="foot"><h2 class="warning"></h2></div> -->
                            </div>
                            </form>
                            <form role="form" method="POST">
                            <div class="sign-up-form">
                                <div class="group"> <label for="user" class="label">Legajo</label> <input id="user"
                                        type="text" class="input" minlength="6" maxlength="6" placeholder="Legajo" name="legajo" required> </div>
                                <div class="group"> <label for="pass" class="label">Password anterior</label> <input id="pass"
                                        type="password" class="input" data-type="password"
                                        placeholder="Password actual" name="passv" required maxlength="8"> </div>
                                <div class="group"> <label for="pass" class="label">Password nuevo</label> <input
                                        id="pass" type="password" class="input" data-type="password"
                                        placeholder="Nuevo password" name="passn" required maxlength="8"> </div>
                                <div class="group"> <label for="pass" class="label">Repetir Password</label> <input
                                        id="pass" type="password" name="passnr" class="input" data-type="password" placeholder="Repetir Nuevo Password"
                                        required maxlength="8">
                                </div>
                                <div class="group"> <input type="submit" name="cambiar" class="button" value="Cambiar"> </div>
                                <div class="group"></div>
                                <div class="hr"></div>
                                <!-- <div class="foot"> <label for="tab-1">Olvid&oacute; su contrase&ntilde;a?</label> </div> -->
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap/js/jquery-3.6.0.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>


</body>