<?php

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

    if (!empty($nombre)) {

        if ($clave == ($pass)) {

            if ($nivel!='1'){

                $id = 7;
            }
            else{
                
            $_SESSION['nombre'] = $nombre;
            $_SESSION['nivel'] = $nivel;
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

function change_pass($legajo,$pass,$passn){
    
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
    
}
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
    return $cod_response;

}
?>