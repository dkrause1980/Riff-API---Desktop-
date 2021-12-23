<?php

const URL = "http://127.0.0.1:5000/";
$enviado = false;

function login($legajo,$pass){
    $id=0;
    $url = "http://127.0.0.1:5000/log/" . ($legajo);
    $json_data = json_encode(array("contrasenia" => $pass));
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: Comprobando usuario',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));
    $resultado = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if(curl_errno($ch)){
        return $id=3;
    }else{
        $decode = json_decode($resultado,true);
        if(!empty($decode)){

            if($decode["nivel"]!=1){
                return $id=7;
            }else{

                $_SESSION['nombre'] = $decode["nombre"];
                $_SESSION['legajo'] = $decode["legajo"];

                header('Location:principal.php');
                exit;

            }

        }else{

            return $id=6;

        }
    }

}
function validar_login($legajo, $pass)
{
    $id = 0;
    $url = "http://127.0.0.1:5000/login/" . ($legajo);
    $json = file_get_contents($url);
    
    $json_data = json_decode($json, true);
    $nombre = $json_data["nombre"];
    $clave = $json_data["contrasenia"];
    $nivel = $json_data["nivel"];
    $leg = $json_data["legajo"];
    $act = $json_data["activo"];
   

    if (!empty($nombre)) {

        if ($clave == ($pass)) {

            if ($nivel!='1' || $act==0){

                $id = 7;
            }
            else{
                
            $_SESSION['nombre'] = $nombre;
            $_SESSION['nivel'] = $nivel;
            $_SESSION['legajo'] = $leg;

            header('Location:principal.php');
            exit;


            $id = 8;
            }
        
        } else {

            $id = 1;
        }
    } else {

        $id = 2;
    }
    return $id;
}

/* function change_pass($legajo,$pass,$passn){
    
        $id = 0;
        $url = "http://127.0.0.1:5000/login/" . ($legajo);
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        $nombre = $json_data["nombre"];
        $clave = $json_data["contrasenia"];
    
        if (!empty($nombre)) {
    
            if ($clave == ($pass)) {
    
                if ($_POST['passnr'] == $passn) {
    
                    
                    $url = "http://127.0.0.1:5000/cambiarc/" . ($legajo);
                    $json_data = json_encode(array(["contrasenia" => $passn]));
                    $ch = curl_init($url);
                    curl_setopt_array($ch, array(
                        CURLOPT_CUSTOMREQUEST => "PUT",
                        CURLOPT_POSTFIELDS => $json_data,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Content-Lenght: ' . strlen($json_data),
                            'Message: Cambiando clave',
                        ),
                        CURLOPT_RETURNTRANSFER => true,
                    ));
                    $resultado = curl_exec($ch);
                    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($cod_response == 200) {

                        echo "Listo";

                    } else {

                        $id = 3;
                    }
                } else {
                    $id = 4;
                }
            } else {
    
                $id = 5;
            }
        } else {
    
            $id = 6;
        }

        return $id;
    
} */
function tipo_error($id){
    switch ($id){

        case 1:
            echo "<script>alert('Error de auetnticación');</script>";
                
            
            break;
        case 2:
            echo "<script>alert('Usuario no registrado');</script>";
            break;
        case 3:
            echo "<script>alert('Error de servidor. Reintente más tarde');</script>";
            break;
        case 4:
            echo "<script>alert('Las contraseñas no coinciden');</script>";
            break;
        case 5:
            echo "<script>alert('Contraseña anterior no válida');</script>";
            break;
        case 6:
            echo "<script>alert('Usuario y contraseña no coinciden')</script>";
            break;
        case 7:
            echo "<script>alert('Usuario no autorizado');</script>";
            break;


    }
}

function get_events(){

    $url = "http://127.0.0.1:5000/eventos";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;

}

function get_tecnicos(){
    $url = "http://127.0.0.1:5000/tecnicos";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;
}

function get_evento($id_evento){
    
    $url = "http://127.0.0.1:5000/eventos/".($id_evento);
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;

}
function update_evento($id_evento,$estado){

    $url = "http://127.0.0.1:5000/eventos/".($id_evento);

    $json_data = json_encode(array("id_estado" => $estado));
    
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: Cambiando estado',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));
    $resultado = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $cod_response;

}

function post_ord($id_evento,$legajo){

    

    $fields = array('id_evento' => $id_evento, 'tecnico' => $legajo);
    $json_data = json_encode($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URL."insert_orden");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data );
    // NO OLVIDAR HEADERS SINO API CANCELA EL REQUEST
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                            'Content-Lenght: ' . strlen($json_data),
                                            'Message: Nueva orden',));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    return $cod_response;


}

function get_ordenes(){

    $url = URL."ordenes";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;

}

function get_orden($id_orden){
    
    $url = URL."ordenes/".($id_orden);
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;

}

function get_tareas_activas(){

    $url = URL."tareas_activas";
    $json = file_get_contents($url);
    
    $json_data = json_decode($json, true);
    
    return $json_data;

}



function post_tarea($id_orden,$tarea1,$tarea2,$tarea3,$tarea4){
    
    $tar1 = strval($tarea1);
    $tar2 = strval($tarea2);
    $tar3 = strval($tarea3);
    $tar4 = strval($tarea4);
    
    $fields = array('cr1'=> $tar1,'cr2' => $tar2,'cr3' => $tar3,'cr4' => $tar4);
    $json_data = json_encode($fields);
    $url = URL."ordenes/".($id_orden);
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: update orden',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));
    $resultado = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $cod_response;

}
//$post = array();
function post_user($post){

    $legajo = $post['legajo'];
    $fecha_ing = date_create($post['fecha_ing']);
    $post['fecha_ing']=date_format($fecha_ing,"Y-m-d");
    $fecha_nac = date_create($post['fecha_nac']);
    $post['fecha_nac']=date_format($fecha_nac,"Y-m-d");
    $post['activo']=intval($post['activo']);

    $json_data = json_encode($post);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URL."tecnicos/".$legajo);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data );
    // NO OLVIDAR HEADERS SINO API CANCELA EL REQUEST
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                            'Content-Lenght: ' . strlen($json_data),
                                            'Message: Nuevo user',));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;




    // "dni":"32331527",
    // "nombre":"Martin",
    // "apellido":"Campos",
    // "fecha_nac":"1980-12-31",
    // "fecha_ing":"1990-12-31",
    // "tel_pers":"3492605040",
    // "email":"mcampos@teco.com",
    // "nivel":"2",
    // "activo":1,
    // "tel_lab":"3492609080",
    // "calle":"San Martin",
    // "altura":"1220",
    // "piso":"",
    // "depto":""

    
        // "legajo":"606061",
        // "dni":"32323232",
        // "nombre":"Marcos",
        // "apellido":"Parola",
        // "fecha_nac":"2020-02-06",
        // "nivel":"1",
        // "calle":"Sarmiento",
        // "altura":"123",
        // "piso":"",
        // "depto":"",
        // "tel_pers":"3496646464",
        // "tel_lab":"3492626164",
        // "email":"asdasd@aasd.com",
        // "fecha_ing":"2020-02-06",
        // "activo":"1"
    
}

function get_users(){

    $url = URL."users";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;

}
function cargar_user($legajo){

    $url = URL."users/".$legajo;
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    $fecha_ing = date_create($json_data['fecha_ing']);
    $json_data['fecha_ing']=date_format($fecha_ing,"Y-m-d");
    $fecha_nac = date_create($json_data['fecha_nac']);
    $json_data['fecha_nac']=date_format($fecha_nac,"Y-m-d");
    return $json_data;

}

function put_user($post){

    $legajo = $post['legajo3'];
    $fecha_ing = date_create($post['fecha_ing']);
    $post['fecha_ing']=date_format($fecha_ing,"Y-m-d");
    $fecha_nac = date_create($post['fecha_nac']);
    $post['fecha_nac']=date_format($fecha_nac,"Y-m-d");
    $post['activo']=intval($post['activo']);
    $url = URL."tecnicos/".$legajo;
    $json_data = json_encode($post);
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: update tecnico',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));

    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;
}

function del_user($post){

    $legajo = $post['legajo2'];
    $post['activo2']=intval($post['activo2']);
    $url = URL."tecnicos/".$legajo;
    $json_data = json_encode($post);
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: desactiva tecnico',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));

    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;
}

function get_cod_events(){

    $url = URL."codigos_eventos";

    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    
    return $json_data;

}

function post_cod_e($post){

    $codigo = $post['codigo'];
    $post['activo']=intval($post['activo']);

    $json_data2 = json_encode($post);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URL."codigos_eventos/".$codigo);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data2 );
    // NO OLVIDAR HEADERS SINO API CANCELA EL REQUEST
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                            'Content-Lenght: ' . strlen($json_data2),
                                            'Message: Nuevo user',));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;
}

function cargar_cod_e($codigo){

    $url = URL."codigos_eventos/".$codigo;
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;

}

function put_cod_e($post){

    $codigo = $post['codigo3'];
    $post['activo']=intval($post['activo']);
    $url = URL."codigos_eventos/".$codigo;
    $json_data = json_encode($post);
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: update tecnico',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));

    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;
}

function del_cod_e($post){

    $codigo = $post['codigo2'];
    $post['activo2']=intval($post['activo2']);
    $url = URL."codigos_eventos/".$codigo;
    $json_data = json_encode($post);
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: desactiva tecnico',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));

    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;
}

//codigos de reparacion
function get_cod_rep(){

    $url = URL."tareas";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;

}

function post_cod_rep($post){

    $codigo = $post['codigo'];
    $post['activo']=intval($post['activo']);

    $json_data2 = json_encode($post);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URL."tareas/".$codigo);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data2 );
    // NO OLVIDAR HEADERS SINO API CANCELA EL REQUEST
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                            'Content-Lenght: ' . strlen($json_data2),
                                            'Message: Nuevo user',));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;
}

function cargar_cod_rep($codigo){

    $url = URL."tareas/".$codigo;
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    return $json_data;

}

function put_cod_rep($post){

    $codigo = $post['codigo3'];
    $post['activo']=intval($post['activo']);
    $url = URL."tareas/".$codigo;
    $json_data = json_encode($post);
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: update tecnico',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));

    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;
}

function del_cod_rep($post){

    $codigo = $post['codigo2'];
    $post['activo2']=intval($post['activo2']);
    $url = URL."tareas/".$codigo;
    $json_data = json_encode($post);
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Lenght: ' . strlen($json_data),
            'Message: desactiva tecnico',
        ),
        CURLOPT_RETURNTRANSFER => true,
    ));

    
    $data = curl_exec($ch);
    $cod_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    
    return $cod_response;
}




?>