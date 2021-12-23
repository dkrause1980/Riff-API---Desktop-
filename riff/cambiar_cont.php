<?php
session_start();
require('php/functions.php');
$cargado = false;

if (empty($_SESSION['nombre'])) {
    header('Location: login.php');
    exit;
}



?>
<!DOCTYPE html>

<head>
    <title>CAMBIAR CONTRASE&Nacute;A</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="css/estilos-principacss"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <nav>
        <div class="nav-wrapper blue lighten-4">
            <div class="col s12">
                <a href="#!" class="breadcrumb black-text" style="padding-left:20px;">USUARIO</a>
                <a href="#!" class="breadcrumb black-text">CONFIGURAR USUARIO</a>
            </div>
        </div>
    </nav>

    <div class="section blue lighten-4" style="z-index: 100;">


        <ul id="menu-side">
            <li style="display:flex; align-items:center; flex-direction:column;">


                <img src="images/logo.png" style="height: 150px; width: 150px; margin-bottom:10px; ">

                <h6 style="font-weight: bold;"><?php echo $_SESSION['nombre']; ?></h6>
                <h6 style="font-weight: bold;"><?php echo $_SESSION['legajo']; ?></h6>



            </li>
            <hr>
            <li><i class="material-icons">event</i><a href="principal.php">EVENTOS</a></li>
            <li><i class="material-icons">handyman</i><a href="lista_ordenes.php">ORD DE REPARACION</a></li>
            <li><i class="material-icons">assessment</i><a href="estadistica.php">ESTADISTICAS</a></li>

            <li><i class="material-icons">list</i><a href="abm_cod_rep.php">ABM COD DE REPARACION</a></li>
            <li><i class="material-icons">list</i><a href="abm_cod_evento.php">ABM COD DE EVENTOS</a></li>
            <li><i class="material-icons">list</i><a href="abm_usuario.php">ABM USUARIOS</a></li>

            <li><i class="material-icons">manage_accounts</i><a href="cambiar_cont.php">CONFIGURAR USUARIO</a></li>
            <li><i class="material-icons">logout</i><a href="login.php">CERRAR SESIÓN</a></li>
        </ul>
    </div>

    <div class="contenido">

        

            <div class="row">
                <div class="input-field col s2">
                    <input type="text" class="validate" id="legajo" disabled value="<?= $_SESSION['legajo']; ?>">
                    <label for="legajo">Legajo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s2">
                    <input type="password" class="validate" id="pass_actual" required minlength="4" maxlength="8">
                    <label for="pass_actual">Contraseña actual</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s2">
                    <input type="password" class="validate" id="pass_nuevo" required minlength="4" maxlength="8">
                    <label for="pass_nuevo">Contraseña nueva</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s2">
                    <input type="password" class="validate" id="pass_nuevo_r" minlength="4" maxlength="8">
                    <label for="pass_nuevo_r">Repetir contraseña nueva</label>
                </div>
            </div>
            <div class="row">
                <div class="col s2" style="margin-top: 20px;">
                    <button id="bt_cambiar_cont" onclick="cambiar_cont()" class="waves-effect waves-light btn-small">
                        CAMBIAR
                    </button>
                </div>
            </div>

        




    </div>










    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="plugins/sweetalert2.all.min.js"></script>
    <script src="js/main.js" charset="utf-8"></script>
</body>

</html>