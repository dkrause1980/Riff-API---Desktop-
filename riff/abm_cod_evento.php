<?php
session_start();
require('php/functions.php');
$cargado = false;

if (empty($_SESSION['nombre'])) {
    header('Location: login.php');
    exit;
}

if (!is_null($_POST['codigo'])) {
    post_cod_e($_POST);
    
    $_POST = array();
} else {
    $cargado = false;
}
if (isset($_POST['codigo2'])) {
    if ($_POST['activo2']=="0") {

        //print_r($_POST);
        del_cod_e($_POST);
        $_POST = array();
    } else {
        
        $cargado = true;
        $json_data = cargar_cod_e($_POST['codigo2']);
    }
}
if(isset($_POST['codigo3'])){
    //print_r($_POST);
   put_cod_e($_POST);
   $_POST = array();
}


?>
<!DOCTYPE html>

<head>
    <title>C&oacute;digos de Eventos</title>

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
        <div class="nav-wrapper blue lighten-4" >
            <div class="col s12">
                <a href="#!" class="breadcrumb black-text" style="padding-left:20px;">ABM</a>
                <a href="#!" class="breadcrumb black-text">C&Oacute;DIGOS DE EVENTOS</a>
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
            
                <div class="row">
                    <div class="input-field col s1 tooltipped" data-position="bottom" data-tooltip="Sólo 3 números">
                        <input id="cod_evento" type="number" class="validate" required value="<?php if ($cargado == true) {
                                                                                            echo $json_data['codigo'];
                                                                                        } ?>" <?php if ($cargado == true) {
                                                                                                    echo "disabled";
                                                                                                } ?>>
                        <label for="cod_evento">Código de evento</label>
                    </div>
                    <div class="input-field col s9">
                        <input id="descripcion" required value="<?php if ($cargado == true) {
                                                            echo $json_data['descripcion'];
                                                        } ?>" type="text" class="validate">
                        <label for="descripcion">Descripción</label>
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
                        <button id="bt_agregar_cod" <?php if ($cargado == true) {
                                                    echo "disabled";
                                                } ?> onclick="agregar_cod()" class="waves-effect waves-light btn-small">
                            AGREGAR
                        </button>
                    </div>
                    <div class="col s1" style="margin-top: 20px;">
                        <button id="bt_modificar_cod" <?php if ($cargado != true) {
                                                        echo "disabled";
                                                    } ?> onclick="modificar_cod()" class="waves-effect waves-light btn-small">
                            GUARDAR
                        </button>
                    </div>
                    <div class="col s1" style="margin-top: 20px;">
                        <button id="nuevo_cod" onclick="blanquear_cod()" class="waves-effect waves-light btn-small">
                            NUEVO
                        </button>
                    </div>
                </div>



            
        </div>
        <table class="highlight centered" id="tabla_cod_e">
            <?php $json = get_cod_events();?>

            <thead>
                
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>ACTIVO</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                
            </thead>
            <tbody>
            <?php
                for ($i = 0; $i < count($json); $i++) { ?>
                <tr>
                    <td><?=$json[$i]['codigo'];?></td>
                    <td><?=$json[$i]['descripcion'];?></td>
                    <td><?=$json[$i]['activo'];?></td>
                    <td><a href="#" id="modif"><span class="material-icons">edit</span></td>
                    <td><a href="#" id="borrar"><span class="material-icons">delete</span></td>
                </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

    <form id="cargar_eve" method="POST" action="abm_cod_evento.php">

        <input id="codigo1" type="hidden" name="codigo">
        <input id="descripcion1" type="hidden" name="descripcion">
        <input type="hidden" id="activo1" name="activo">

    </form>

    <form id="modif_eve" method="POST" action="abm_cod_evento.php">
        <input id="codigo2" type="hidden" name="codigo2">
        <input id="activo2" type="hidden" name="activo2">
    </form>

    <form id="cargar_modif_eve" method="POST" action="abm_cod_evento.php">

        <input id="codigo3" type="hidden" name="codigo3">
        <input id="descripcion3" type="hidden" name="descripcion">
        <input type="hidden" id="activo3" name="activo">

    </form>


    <script>
    window.onload = function(){
    TableSorter.makeSortable(document.getElementById("tabla_cod_e"));
    };
  </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="plugins/sweetalert2.all.min.js"></script>
    <script src="js/main.js" charset="utf-8"></script>
</body>

</html>