<?php
session_start();
require('php/functions.php');
$cargado = false;

if (empty($_SESSION['nombre'])) {
    header('Location: login.php');
    exit;
}
//print_r($_POST);
if (isset($_POST['legajo'])) {
    post_user($_POST);
    $_POST = array();
} else {
    $cargado = false;
}

if (isset($_POST['legajo2'])) {
    if ($_POST['activo2']=="0") {

        //print_r($_POST);
        del_user($_POST);
        $_POST = array();
    } else {
        
        $cargado = true;
        $json_data = cargar_user($_POST['legajo2']);
    }
}
if (isset($_POST['legajo3'])) {
    //print_r($_POST);
    put_user($_POST);
    $_POST = array();
}


?>
<!DOCTYPE html>

<head>
    <title>ABM USUARIOS</title>

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
                <a href="#!" class="breadcrumb black-text" style="padding-left:20px;">ABM</a>
                <a href="#!" class="breadcrumb black-text">USUARIOS</a>
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
            <!-- <form class="col s12" method="POST"> -->
            <div class="row">
                <div class="input-field col s1 tooltipped" data-position="bottom" data-tooltip="Sólo 6 números">
                    <input id="legajo" type="number" value="<?php if ($cargado == true) {
                                                                echo $json_data['legajo'];
                                                            } ?>" required name="legajo" class="validate" maxlength="6" minlength="6" <?php if ($cargado == true) {
                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                } ?>>
                    <label for="legajo">Legajo</label>
                </div>
                <div class="input-field col s1">
                    <input id="dni" type="number" name="dni" value="<?php if ($cargado == true) {
                                                                        echo $json_data['dni'];
                                                                    } ?>" required class="validate" maxlength="8" minlength="6">
                    <label for="dni">Doc de identidad</label>
                </div>
                <div class="input-field col s3">
                    <input id="nombre" type="text" name="nombre" required class="validate" value="<?php if ($cargado == true) {
                                                                                                echo $json_data['nombre'];
                                                                                            } ?>" maxlength="100" minlength="2">
                    <label for="nombre">Nombre</label>
                </div>
                <div class="input-field col s3">
                    <input id="apellido" type="text" name="apellido" required value="<?php if ($cargado == true) {
                                                                                echo $json_data['apellido'];
                                                                            } ?>" class="validate" maxlength="100" minlength="2">
                    <label for="apellido">Apellido</label>
                </div>
                <div class="input-field col s2">
                    <input type="date" id="fecha_nac" name="fecha_nac" required value="<?php if ($cargado == true) {
                                                                                    echo $json_data['fecha_nac'];
                                                                                } ?>" class="validate">
                    <label for="fecha_nac">Fecha de nacimiento</label>
                </div>
                <div class="input-field col s1 tooltipped"  data-position="bottom" data-tooltip="(1)Técnico Administrativo - (2)Técnico de calle" >
                    <select id="nivel" name="nivel" required>
                        <option value="" disabled selected>Nivel</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>

                </div>

            </div>
            <div class="row">

                <div class="input-field col s3">
                    <input id="calle" type="text" required name="calle" value="<?php if ($cargado == true) {
                                                                            echo $json_data['calle'];
                                                                        } ?>" class="validate" maxlength="100" minlength="2">
                    <label for="calle">Calle</label>
                </div>
                <div class="input-field col s1">
                    <input id="altura" type="text" required name="altura" value="<?php if ($cargado == true) {
                                                                            echo $json_data['altura'];
                                                                        } ?>" class="validate" maxlength="10" minlength="1">
                    <label for="altura">Altura</label>
                </div>
                <div class="input-field col s1">
                    <input id="piso" type="text" value="<?php if ($cargado == true) {
                                                            echo $json_data['piso'];
                                                        } ?>" name="piso">
                    <label for="piso">Piso</label>
                </div>
                <div class="input-field col s1">
                    <input id="depto" type="text" value="<?php if ($cargado == true) {
                                                                echo $json_data['depto'];
                                                            } ?>" name="depto">
                    <label for="depto">Departamento</label>
                </div>
                <div class="input-field col s1">
                    <input id="tel_pers" type="text" required name="tel_pers" value="<?php if ($cargado == true) {
                                                                                echo $json_data['tel_pers'];
                                                                            } ?>" class="validate" maxlength="10">
                    <label for="tel_pers">Teléfono particular</label>
                </div>
                <div class="input-field col s1">
                    <input id="tel_lab" type="text" required name="tel_lab" value="<?php if ($cargado == true) {
                                                                                echo $json_data['tel_lab'];
                                                                            } ?>" class="validate" maxlength="10">
                    <label for="tel_lab">Teléfono Laboral</label>
                </div>
                <div class="input-field col s3">
                    <input type="email" id="email" required name="email" value="<?php if ($cargado == true) {
                                                                            echo $json_data['email'];
                                                                        } ?>" class="validate" maxlength="100">
                    <label for="email">Correo electrónico</label>
                </div>
                
            </div>
            <div class="row">
                <div class="input-field col s2">
                    <input type="date" name="fecha_ing" required id="fecha_ing" value="<?php if ($cargado == true) {
                                                                                    echo $json_data['fecha_ing'];
                                                                                } ?>" class="validate">
                    <label for="fecha_ing">Fecha de ingreso</label>
                </div>
                <div class="input-field col s1">
                    <select id="activo" name="activo" required>
                        <option value="" disabled selected>Activo</option>
                        <option value=1>SI</option>
                        <option value=0>NO</option>
                    </select>

                </div>
            </div>
            <div class="row">
                <div class="col s1" style="margin-top: 20px;">
                    <button id="bt_agregar" <?php if ($cargado == true) {
                                                echo "disabled";
                                            } ?> onclick="agregar()" class="waves-effect waves-light btn-small">
                        AGREGAR
                    </button>
                </div>
                <div class="col s1" style="margin-top: 20px;">
                    <button id="bt_modificar" <?php if ($cargado != true) {
                                                    echo "disabled";
                                                } ?> onclick="modificar()" class="waves-effect waves-light btn-small">
                        GUARDAR
                    </button>
                </div>
                <div class="col s1" style="margin-top: 20px;">
                    <button id="nuevo" onclick="blanquear()" class="waves-effect waves-light btn-small">
                        NUEVO
                    </button>
                </div>
            </div>

            <!-- </form> -->
        </div>
        <table class="highlight centered" id="tabla_usuario">

            <?php
            $json = get_users();
            ?>

            <thead>
                
                    <th>LEGAJO</th>
                    <th>DNI</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>

                    <th>NIVEL</th>
                    <th>ACTIVO</th>
                    <th>TEL PART</th>
                    <th>TEL LAB</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($json); $i++) { ?>
                    <tr>
                        <td><?= $json[$i]['legajo']; ?></td>
                        <td><?= $json[$i]['dni']; ?></td>
                        <td><?= $json[$i]['nombre']; ?></td>
                        <td><?= $json[$i]['apellido']; ?></td>
                        <td><?= $json[$i]['nivel']; ?></td>
                        <td><?= $json[$i]['activo']; ?></td>
                        <td><?= $json[$i]['tel_pers']; ?></td>
                        <td><?= $json[$i]['tel_lab']; ?></td>
                        <td><a href="#" id="modif"><span class="material-icons">edit</span></td>
                        <td><a href="#" id="borrar"><span class="material-icons">delete</span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <form id="cargar_user" method="POST" action="abm_usuario.php">

        <input id="legajo1" type="hidden" name="legajo">
        <input id="dni1" type="hidden" name="dni">
        <input id="nombre1" type="hidden" name="nombre">
        <input id="apellido1" type="hidden" name="apellido">
        <input type="hidden" id="fecha_nac1" name="fecha_nac">
        <input type="hidden" id="nivel1" name="nivel">
        <input id="calle1" type="hidden" name="calle">
        <input id="altura1" type="hidden" name="altura">
        <input id="piso1" type="hidden" name="piso">
        <input id="depto1" type="hidden" name="depto">
        <input id="tel_pers1" type="hidden" name="tel_pers">
        <input id="tel_lab1" type="hidden" name="tel_lab">
        <input type="hidden" id="email1" name="email">
        <input type="hidden" name="fecha_ing" id="fecha_ing1">
        <input type="hidden" id="activo1" name="activo">

    </form>

    <form id="modif_user" method="POST" action="abm_usuario.php">
        <input id="legajo2" type="hidden" name="legajo2">
        <input id="activo2" type="hidden" name="activo2">
    </form>

    <form id="cargar_modif_user" method="POST" action="abm_usuario.php">

        <input id="legajo3" type="hidden" name="legajo3">
        <input id="dni3" type="hidden" name="dni">
        <input id="nombre3" type="hidden" name="nombre">
        <input id="apellido3" type="hidden" name="apellido">
        <input type="hidden" id="fecha_nac3" name="fecha_nac">
        <input type="hidden" id="nivel3" name="nivel">
        <input id="calle3" type="hidden" name="calle">
        <input id="altura3" type="hidden" name="altura">
        <input id="piso3" type="hidden" name="piso">
        <input id="depto3" type="hidden" name="depto">
        <input id="tel_pers3" type="hidden" name="tel_pers">
        <input id="tel_lab3" type="hidden" name="tel_lab">
        <input type="hidden" id="email3" name="email">
        <input type="hidden" name="fecha_ing" id="fecha_ing3">
        <input type="hidden" id="activo3" name="activo">

    </form>



    <script>
    window.onload = function(){
    TableSorter.makeSortable(document.getElementById("tabla_usuario"));
    };
  </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="plugins/sweetalert2.all.min.js"></script>
    <script src="js/main.js" charset="utf-8"></script>
</body>

</html>