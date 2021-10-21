<?php
session_start();
require('php/functions.php');

if(empty($_SESSION['nombre'])){
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>

<head>
  <title>Principal</title>

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="css/estilos-principacss"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
      body{
        margin: 5px;
      }
    </style>
  </head>

<body>
 
  <div class="section blue lighten-4" >
    <a href="#" class="sidenav-trigger btn-floating pulse" data-target="menu-side" style="position: fixed;">
      <i class="material-icons">menu</i>
    </a>
  
  <ul id="menu-side" class="sidenav">
    <li >
      <div class="user-view" style="padding-left: 60px;">
      
        <img src="images/logo.png" style="height: 150px; width: 150px;" >
      
    </div>
  </li>
    <li><a href="#!"><i class="material-icons">event</i>EVENTOS</a></li>
    <li><a href="#!"><i class="material-icons">handyman</i>ORD DE REPARACION</a></li>
    <li><a href="#!"><i class="material-icons">assessment</i>ESTADISTICAS</a></li>
    
    <li><a href="#!"><i class="material-icons">list</i>ABM COD DE REPARACION</a></li>
    <li><a href="#!"><i class="material-icons">list</i>ABM COD DE EVENTOS</a></li>
    <li><a href="#!"><i class="material-icons">list</i>ABM USUARIOS</a></li>
    
    <li><a href="#!"><i class="material-icons">manage_accounts</i>CONFIGURAR USUARIO</a></li>
    <li><a href="login.php"><i class="material-icons">logout</i>CERRAR SESIÓN</a></li>
  </ul>
  
  
       
  
    <table class="highlight centered" id="tabla_eventos">
      <h5 class="center-align">LISTA DE EVENTOS</h5>
      <thead>
        <tr>
          <th>ID</th>
          <th>FECHA</th>
          <th>TECNICO</th>
          <th>CALLE</th>
          <th>ALTURA</th>
          <th>TIPO</th>
          <th>ESTADO</th>
          <th>DETALLES</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $json = get_events();
        for ($i=0;$i<count($json);$i++){?>
        <tr>
          <td><?php echo $json[$i]["id_evento"];?> </td>
          <td>
            <?php echo $json[$i]["fecha_creacion"];?>
          </td>
          <td>
            <?php echo $json[$i]["legajo_tecnico"];?>
          </td>
          <td>
            <?php echo $json[$i]["calle"];?>
          </td>
          <td>
            <?php echo $json[$i]["altura"];?>
          </td>
          <td>
            <?php echo $json[$i]["desc_falla"];?>
          </td>
          <td>
            <?php echo $json[$i]["desc_estado"];?>
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
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="js/main.js" charset="utf-8"></script>
</body>