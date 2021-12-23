<?php
session_start();
require('php/functions.php');

if (empty($_SESSION['nombre'])) {
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>

<head>
  <title>Eventos</title>

  
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
  <div class="nav-wrapper blue lighten-4" style="left: 248px;">
      <div class="col s12">
        <a href="#!" class="breadcrumb black-text" style="padding-left:10px;">Eventos</a>
        <a href="#!" class="breadcrumb black-text">Lista de Eventos</a>
      </div>
    </div>
  </nav>

  <div class="section blue lighten-4" style="z-index: 100;">
      

    <ul id="menu-side" >
      <li style="display:flex; align-items:center; flex-direction:column;">
        

          <img src="images/logo.png" style="height: 150px; width: 150px; margin-bottom:10px; ">
          
          <h6 style="font-weight: bold;"><?php echo $_SESSION['nombre'];?></h6>
          <h6 style="font-weight: bold;"><?php echo $_SESSION['legajo'];?></h6>
          

        
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
  <table class="highlight centered" id="tabla_eventos">

    <thead>
      
        <th >ID</th>
        <th>FECHA</th>
        <th>TECNICO</th>
        <th>CALLE</th>
        <th>ALTURA</th>
        <th>TIPO</th>
        <th>ESTADO</th>
        <th>DETALLES</th>
      
    </thead>
    <tbody>
      <?php
      $json = get_events();
      for ($i = 0; $i < count($json); $i++) { ?>
        <tr>
          <td><?php echo $json[$i]["id_evento"]; ?> </td>
          <td>
            <?php echo $json[$i]["fecha_creacion"]; ?>
          </td>
          <td>
            <?php echo $json[$i]["legajo_tecnico"]; ?>
          </td>
          <td>
            <?php echo $json[$i]["calle"]; ?>
          </td>
          <td>
            <?php echo $json[$i]["altura"]; ?>
          </td>
          <td>
            <?php echo $json[$i]["desc_falla"]; ?>
          </td>
          <td>
            <?php echo $json[$i]["desc_estado"]; ?>
          </td>
          <td><a href="#" class="boton" id="guardar_bt"><span class="material-icons">
                info
              </span></a></td>
        </tr>
      <?php } ?>

    </tbody>
  </table>
</div>

  <form action="detalle_evento.php" method="post" id="formu">
    <input type="hidden" name="id_evento" id="evento" value="hola">
  </form>

  <script>
    window.onload = function(){
    TableSorter.makeSortable(document.getElementById("tabla_eventos"));
    };
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="js/main.js" charset="utf-8"></script>
</body>

</html>