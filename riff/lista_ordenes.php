<?php
session_start();
require('php/functions.php');

if (empty($_SESSION['nombre'])) {
  header('Location: login.php');
  exit;
}
if(isset($_POST['name_estado'])){
  if($_POST['name_estado']=='4'){
    update_evento($_POST['name_evento'],$_POST['name_estado']);
  }else if($_POST['name_estado']=='3'){
    update_evento($_POST['name_evento'],$_POST['name_estado']);
    post_tarea($_POST['name_orden'],$_POST['cr1'],$_POST['cr2'],$_POST['cr3'],$_POST['cr4']);

  }
}
?>
<!DOCTYPE html>

<head>
  <title>&Oacute;rdenes</title>

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
        <a href="#!" class="breadcrumb black-text" style="padding-left:20px;">Ordenes de reparacion</a>
        <a href="#!" class="breadcrumb black-text">Lista de Ordenes</a>
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
    <table class="highlight centered bordered" id="tabla_ordenes">

      <thead>
        
          <th>ID ORDEN</th>
          <th>FECHA CREACION</th>
          <th>TECNICO ASIG</th>
          <th>EVENTO ASOCIADO</th>
          <th>ESTADO</th>
          <th>FECHA DE RESOLUCION</th>
          <th>TAREA 1</th>
          <th>TAREA 2</th>
          <th>TAREA 3</th>
          <th>TAREA 4</th>
          <th>DETALLES</th>
        
      </thead>
      <tbody>
        <?php
        $json = get_ordenes();
        $codigos = get_tareas_activas();
        
        for ($i = 0; $i < count($json); $i++) { ?>
          <tr>
            <td><?php echo $json[$i]["id_orden"]; ?> </td>
            <td>
              <?php echo $json[$i]["fecha_creacion"]; ?>
            </td>
            <td>
              <?php echo $json[$i]["legajo_tecnico"]; ?>
            </td>
            <td>
              <a href="#" id="ver_evento" class="blue-text text-darken-2"><?php echo $json[$i]["id_evento"]; ?></a>
              
            </td>
            <td>
              <?php
              if($json[$i]['estado']=='Solucionado' || $json[$i]['estado']=='Cancelado'){ 
                echo $json[$i]["estado"];}
              else {?>
                <select id="<?php echo 'estado'.$json[$i]["id_orden"]; ?>">
                    <option value="2" selected>Cursando</option>
                    <option value="3">Solucionado</option>
                    <option value="4">Cancelado</option>
                    
                </select>
              <?php } ?>
            </td>
            <td>
              <?php echo $json[$i]["fecha_resolucion"]; ?>
            </td>
            <td>
            <?php
              if($json[$i]['estado']=='Solucionado' || $json[$i]['estado']=='Cancelado'){ 
                echo $json[$i]["cod_resolucion1"];}
              else {?>
                <select id="<?='tarea1'.$json[$i]['id_orden'];?>">
                <option value="-" selected>-</option>  
                <?php foreach($codigos as $t){?>
                    <option value="<?=$t['cod_resolucion'];?>"><?=$t['cod_resolucion'];?></option><?php } ?>
                </select>
              <?php } ?>
            </td>
            <td>
            <?php
              if($json[$i]['estado']=='Solucionado' || $json[$i]['estado']=='Cancelado'){ 
                echo $json[$i]["cod_resolucion2"];}
              else {?>
                <select id="<?='tarea2'.$json[$i]['id_orden'];?>">
                <option value="-" selected>-</option>  
                <?php foreach($codigos as $t){?>
                    <option value="<?=$t['cod_resolucion'];?>"><?=$t['cod_resolucion'];?></option><?php } ?>
                </select>
              <?php } ?>
            </td>
            <td>
            <?php
              if($json[$i]['estado']=='Solucionado' || $json[$i]['estado']=='Cancelado'){ 
                echo $json[$i]["cod_resolucion3"];}
              else {?>
                <select id="<?='tarea3'.$json[$i]['id_orden'];?>">
                <option value="-" selected>-</option>  
                <?php foreach($codigos as $t){?>
                    <option value="<?=$t['cod_resolucion'];?>"><?=$t['cod_resolucion'];?></option><?php } ?>
                </select>
              <?php } ?>
            </td>
            <td>
            <?php
              if($json[$i]['estado']=='Solucionado' || $json[$i]['estado']=='Cancelado'){ 
                echo $json[$i]["cod_resolucion4"];}
              else {?>
                <select id="<?='tarea4'.$json[$i]['id_orden'];?>">
                <option value="-" selected>-</option>  
                <?php foreach($codigos as $t){?>
                    <option value="<?=$t['cod_resolucion'];?>"><?=$t['cod_resolucion'];?></option><?php } ?>
                </select>
              <?php } ?>
            </td>

            <td><a href="#" id="<?php
              if($json[$i]['estado']=='Solucionado' || $json[$i]['estado']=='Cancelado'){ 
                echo 'disabled';}else{echo 'enabled';}?>"><span id="<?='btn'.$json[$i]['id_orden'];?>" class="material-icons">
                save
              </span></a>
            </td>
          </tr>
        <?php } ?>

      </tbody>
    </table>
  </div>

  <form method="post" id="formu_orden">
    <input type="hidden" name="name_orden" id="inp_orden" >
    <input type="hidden" name="name_evento" id="inp_evento" >
    <input type="hidden" name="name_estado" id="inp_estado">
    <input type="hidden" name="cr1" id="inp_cr1">
    <input type="hidden" name="cr2" id="inp_cr2">
    <input type="hidden" name="cr3" id="inp_cr3">
    <input type="hidden" name="cr4" id="inp_cr4">
    
  </form>

  <form action="detalle_evento.php" method="post" id="formu">
    <input type="hidden" name="id_evento" id="evento" value="hola">
  </form>


  <script>
    window.onload = function(){
    TableSorter.makeSortable(document.getElementById("tabla_ordenes"));
    };
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="plugins/sweetalert2.all.min.js"></script>
  <script src="js/main.js" charset="utf-8"></script>
</body>

</html>