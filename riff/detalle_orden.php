<?php
session_start();
if (empty($_SESSION['nombre'])) {
    header('Location: login.php');
    exit;
}
require('php/functions.php');
//print_r($_POST);
if(!empty($_POST['cambio_estado'])){

    update_evento($_POST['id_evento'],$_POST['cambio_estado']);
    post_tarea($_POST['id_orden'],$_POST['id_tarea1'],$_POST['id_tarea2'],$_POST['id_tarea3'],$_POST['id_tarea4']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de orden</title>
    <!-- <link rel="stylesheet" href="css/estilos-principacss"> -->
    <link rel="stylesheet" href="plugins/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css/estilos.css">



</head>

<body>
    <nav>
        <div class="nav-wrapper blue lighten-4 z-depth-4">
            <div class="col s12">
                <a href="lista_ordenes.php" class="breadcrumb black-text" style="padding-left:10px;">Ordenes de reparacion</a>
                <a href="lista_ordenes.php" class="breadcrumb black-text">Lista de Ordenes</a>
                <a href="#" class="breadcrumb black-text">Detalle de orden</a>

            </div>
        </div>
    </nav>

    <div class="section blue lighten-4 z-depth-4">


        <ul id="menu-side">
            <li style="display:flex; align-items:center; flex-direction:column;">


                <img src="images/logo.png" style="height: 150px; width: 150px; margin-bottom:10px; ">

                <h6 style="font-weight: bold;"><?php echo $_SESSION['nombre']; ?></h6>
                <h6 style="font-weight: bold;"><?php echo $_SESSION['legajo']; ?></h6>



            </li>
            <hr>
            <li><i class="material-icons">event</i><a href="principal.php">EVENTOS</a></li>
            <li><i class="material-icons">handyman</i><a href="lista_ordenes.php">ORD DE REPARACION</a></li>
            <li><i class="material-icons">assessment</i><a href="estadisticas.php">ESTADISTICAS</a></li>

            <li><i class="material-icons">list</i><a href="abm_rep.php">ABM COD DE REPARACION</a></li>
            <li><i class="material-icons">list</i><a href="abm_eve.php">ABM COD DE EVENTOS</a></li>
            <li><i class="material-icons">list</i><a href="abm_user.php">ABM USUARIOS</a></li>

            <li><i class="material-icons">manage_accounts</i><a href="config_user.php">CONFIGURAR USUARIO</a></li>
            <li><i class="material-icons">logout</i><a href="login.php">CERRAR SESIÓN</a></li>
        </ul>
    </div>

    <?php

    $id_orden = $_POST['id_orden'];
    $json2 = get_orden($id_orden);


    ?>

    <div class="contenido">
        <div class="row">
            <div class="input-field col s2">
                <input disabled value="<?php echo $json2['id_orden']; ?>" id="id_ord" type="text" class="validate">
                <label for="disabled">ID ORDEN</label>
            </div>
            <div class="input-field col s2">
                <input disabled value="<?php echo $json2['fecha_creacion']; ?>" id="fec_creac" type="text" class="validate">
                <label for="disabled">FECHA DE CREACION</label>
            </div>
            <div class="input-field col s2">
                <input disabled value="<?php echo $json2['legajo_tecnico']; ?>" id="legajo" type="text" class="validate">
                <label for="disabled">TECNICO DE ORDEN</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s2">
                <input disabled value="<?php echo $json2["id_evento"]; ?>" id="id_event" type="text" class="validate">
                <label for="disabled">ID EVENTO ASOCIADO</label>
            </div>
            <div class="input-field col s2">
                <input disabled value="<?php echo $json2['desc_estado']; ?>" id="estado" type="text" class="validate">
                <label for="disabled">ESTADO</label>
            </div>
            <div class="input-field col s2">
                <input disabled value="<?php echo $json2['fecha_resolucion']; ?>" id="fec_res" type="text" class="validate">
                <label for="disabled">FECHA DE RESOLUCION</label>
            </div>
            <div class="input-field col s2">
                <a id="ver_evento" onclick="ver_evento()" class="waves-effect waves-light btn-small">
                    VER EVENTO ASOCIADO
                </a>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s1">
                <a id="agregar_tarea1" onclick="agregar_tarea1()" class="waves-effect waves-light btn-small">
                    (+) TAREA
                </a>
            </div>
            <div class="input-field col s1">
                <a id="agregar_tarea1" onclick="eliminar_tarea1()" class="waves-effect waves-light btn-small">
                    (-) TAREA
                </a>
            </div>

            <div class="input-field col s2" id="insert_cod_1" style="display: none;">
                <select id="tarea1">
                    <option value="-" disabled selected>Tarea</option>
                    
                    <?php $tareas = get_tareas();
                    for ($i = 0; $i < count($tareas); $i++) { ?>
                        
                        <option value="<?= $tareas[$i]['cod_resolucion'] ?>"><?= $tareas[$i]['desc_codigo'] ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>
        <div class="row">
            <div class="input-field col s1">
                <a id="agregar_tarea2" onclick="agregar_tarea2()" class="waves-effect waves-light btn-small">
                    (+) TAREA
                </a>
            </div>
            <div class="input-field col s1">
                <a id="agregar_tarea2" onclick="eliminar_tarea2()" class="waves-effect waves-light btn-small">
                    (-) TAREA
                </a>
            </div>

            <div class="input-field col s2" id="insert_cod_2" style="display: none;">
                <select id="tarea2">
                    <option value="-" disabled selected>Tarea</option>
                    <?php $tareas = get_tareas();
                    for ($i = 0; $i < count($tareas); $i++) { ?>
                        <option value="<?= $tareas[$i]['cod_resolucion'] ?>"><?= $tareas[$i]['desc_codigo'] ?></option>
                    <?php } ?>
                </select>
            </div>



        </div>
        <div class="row">
        <div class="input-field col s1">
                <a id="agregar_tarea3" onclick="agregar_tarea3()" class="waves-effect waves-light btn-small">
                    (+) TAREA
                </a>
            </div>
            <div class="input-field col s1">
                <a id="agregar_tarea3" onclick="eliminar_tarea3()" class="waves-effect waves-light btn-small">
                    (-) TAREA
                </a>
            </div>

            <div class="input-field col s2" id="insert_cod_3" style="display: none;">
                <select id="tarea3">
                    <option value="-" disabled selected>Tarea</option>
                    <?php $tareas = get_tareas();
                    for ($i = 0; $i < count($tareas); $i++) { ?>
                        <option value="<?= $tareas[$i]['cod_resolucion'] ?>"><?= $tareas[$i]['desc_codigo'] ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>
        <div class="row">
        <div class="input-field col s1">
                <a id="agregar_tarea4" onclick="agregar_tarea4()" class="waves-effect waves-light btn-small">
                    (+) TAREA
                </a>
            </div>
            <div class="input-field col s1">
                <a id="agregar_tarea4" onclick="eliminar_tarea4()" class="waves-effect waves-light btn-small">
                    (-) TAREA
                </a>
            </div>

            <div class="input-field col s2" id="insert_cod_4" style="display: none;">
                <select id="tarea4">
                    <option value="-" disabled selected>Tarea</option>
                    <?php $tareas = get_tareas();
                    for ($i = 0; $i < count($tareas); $i++) { ?>
                        <option value="<?= $tareas[$i]['cod_resolucion'] ?>"><?= $tareas[$i]['desc_codigo'] ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>

        <div class="row">


        </div>
        <div class="row">

        </div>

        <div class="row">

            <a id="ver_evento" onclick="finalizar()" class="waves-effect waves-light btn-small col s4">
                GUARDAR Y FINALIZAR
            </a>


        </div>







    </div>
    <form method="POST" id="form_ev" action="detalle_evento.php">
        <input type="hidden" name="id_evento" id="inp_evento" value="caca">
    </form>
    <form method="POST" id="form_ord">
        <input type="hidden" name="cambio_estado" id="cambio_estado" value="3">
        <input type="hidden" name="id_evento" id="inp_eve" value="">
        <input type="hidden" name="id_orden" id="inp_ord" value="">
        <input type="hidden" name="id_tarea1" id="inp_tarea1" value="-">
        <input type="hidden" name="id_tarea2" id="inp_tarea2" value="-">
        <input type="hidden" name="id_tarea3" id="inp_tarea3" value="-">
        <input type="hidden" name="id_tarea4" id="inp_tarea4" value="-">
        

    </form>
    <?php

    
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="plugins/sweetalert2.all.min.js"></script>
    <script src="js/main.js" charset="utf-8"></script>
</body>

</html>