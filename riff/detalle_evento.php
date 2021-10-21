<?php
session_start();
if(empty($_SESSION['nombre'])){
  header('Location: login.php');
  exit;
}
require('php/functions.php');
if(($_POST['estado'])=='2'&& isset($_POST['tecnico'])){
  update_evento($_POST['id_evento'],$_POST['estado']);

  

}else if(($_POST['estado'])=='4'){
  update_evento($_POST['id_evento'],$_POST['estado']);

  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de evento</title>
     <!-- <link rel="stylesheet" href="css/estilos-principacss"> -->
     <link rel="stylesheet" href="plugins/sweetalert2.min.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    

    
</head>
<body>
    <?php 
    $id_event = $_POST['id_evento'];
    $json2 = get_evento($id_event); 
    ?>
    
    <div class="section blue lighten-4">
    
    <a class="btn-floating pulse" href="principal.php" style="margin:10px;"><i class="material-icons">arrow_back</i></a>
    
  
    <h5 style="margin-left: 560px; display:inline-block; margin: top 10px;">Detalle Evento</h5>
    <div class="row" >

        <div class="row">
        
        <div class="input-field col s3">
          <input disabled value="<?php echo $json2['id_evento'];?>" id="id_event" type="text" class="validate">
          <label for="disabled">ID EVENTO</label>
        </div>

        <div class="input-field col s3">
          <input disabled value="<?php echo $json2['calle'];?>" id="calle" type="text" class="validate">
          <label for="disabled">CALLE</label>
        </div>
        <div class="map" id="map" style="border: 1px solid #ccc;height: 500px; left:690px; position:absolute; width:600px;"></div>
        <input type="hidden" id="lat" value="<?=$json2['latitud']?>">
        <input type="hidden" id="log" value="<?=$json2['longitud']?>">
        </div>
        <div class="row">
        <div class="input-field col s3">
          <input disabled value="<?php echo $json2['fecha_creacion'];?>" id="fecha" type="text" class="validate">
          <label for="disabled">FECHA</label>
        </div>

        <div class="input-field col s3">
          <input disabled value="<?php echo $json2['altura'];?>" id="altura" type="text" class="validate">
          <label for="disabled">ALTURA</label>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s3">
          <input disabled value="<?php echo $json2['legajo_tecnico'];?>" id="tecni" type="text" class="validate">
          <label for="disabled">TECNICO</label>
        </div>

        <div class="input-field col s3">
          <input disabled value="<?php if ($json2['piso']!=''){echo $json2['piso'];}else{echo'-';};?>" id="piso" type="text" class="validate">
          <label for="disabled">PISO</label>
        </div>
        </div>
        
        <div class="row">
        <div class="input-field col s3">
          <input disabled value="<?php echo $json2['desc_falla'];?>" id="tipo" type="text" class="validate">
          <label for="disabled">TIPO DE EVENTO</label>
        </div>

        <div class="input-field col s3">
          <input disabled value="<?php if ($json2['depto']!=''){echo $json2['depto'];}else{echo'-';};?>" id="depto" type="text" class="validate">
          <label for="disabled">DEPARTAMENTO</label>
        </div>
        
        
        </div>
        <div class="row">
        <div class="input-field col s3">
        
        <select id="estado">
            <option value="" disabled selected><?php echo $json2['desc_estado'];?></option>
            <?php if($json2['desc_estado']=='Cursando'){?>
              <option value="4">Cancelado</option>
            <?php } else if($json2['desc_estado']=='Pendiente'){?>
            <option value="2">Cursar</option>
            <option value="4">Cancelar</option><?php }
            else {?>
            
            <?php } ?>
            
        </select>
        <label>ESTADO</label>
        </div>

        <div class="input-field col s3">
        <select id="tec">
            <option value="" disabled selected>Técnico reparador</option>
            <?php $tecnicos=get_tecnicos();
            for($i=0;$i<count($tecnicos);$i++){?>
            <option value="<?=$tecnicos[$i]['legajo']?>"><?=$tecnicos[$i]['legajo']?></option>
            <?php } ?>
        </select>
        <label>TECNICO REPARADOR</label>
        </div>
        
        
        </div>
        <div class="row">
        <div class="input-field col s6">
          <input disabled value="<?php echo $json2['comentario'];?>" id="coment" type="text" class="validate">
          <label for="disabled">COMENTARIO</label>
        </div>
        <div class="col s3">
            <a id="enviar_estado" onclick="enviar_estado()" class="waves-effect waves-light btn-small">
              CAMBIAR ESTADO
            </a>
        </div>
        
        </div>

        </div>
      
    </div>
    </div>
  <form  method="POST" id="form_est">
    <input type="hidden" name="estado" id="inp_estado" >
    <input type="hidden" name="tecnico" id="inp_tecnico" >
    <input type="hidden" name="id_evento" id="inp_evento" >
  </form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/main.js" charset="utf-8"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMOQyhUAPQCqoxu2L9Wf0syEFi5h5JKSs&callback=initMap" async defer></script>
<script src="plugins/sweetalert2.all.min.js"></script>
<script>
		
    var map;
  	function initMap() {
      var lati = parseFloat(document.getElementById('lat').value);
      var log = parseFloat(document.getElementById('log').value);
      map = new google.maps.Map(document.getElementById('map'), {
		  center: {lat: lati , lng: log},
      zoom: 13,
      });
      var marker = new google.maps.Marker({
      position: {lat: lati, lng: log},
      map: map,
	    title: 'Ubicación de evento'
      });
    }

      
	</script>

</body>
</html>