
// obtener valor de la tabla al seleccionar detalles
$(document).ready(function () {
    $('#tabla_eventos').on('click', '#guardar_bt', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        console.log(filaactual);
        var id_evento = filaactual.find("td:eq(0)").text();
        console.log(id_evento);
        document.getElementById("evento").value = id_evento;
        document.getElementById("formu").submit();

    });
});

// obtengo id orden en tabla ordenes
/* $(document).ready(function () {
    $('#tabla_ordenes').on('click', '#guardar_bt', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        console.log(filaactual);
        var id_ord = filaactual.find("td").eq(0).text();
        console.log(id_ord);
        //document.getElementById("orden").value = id_ord;
        //document.getElementById("formu_orden").submit();

    });
}); */

// obtengo id evento en tabla orden

$(document).ready(function () {
    $('#tabla_ordenes').on('click', '#ver_evento', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        //console.log(filaactual); 
        var id_evento = filaactual.find("td:eq(3)").find("a").text();
        //console.log(id_evento); 
        document.getElementById("evento").value = id_evento;
        console.log(document.getElementById("evento").value);
        document.getElementById("formu").submit();

    });
});

//obtener estado y tecnico del evento y enviar por post
function enviar_estado() {
    var select = document.getElementById("estado");
    var estado = select.options[select.selectedIndex].value;
    document.getElementById("inp_estado").value = estado;
    var sel = document.getElementById("tec");
    var tecnico = sel.options[sel.selectedIndex].value;
    document.getElementById("inp_tecnico").value = tecnico;
    var sel2 = document.getElementById("id_event");
    var ev = sel2.value;
    document.getElementById("inp_evento").value = ev;
    console.log(tecnico, estado, ev);
    if (estado == 2) {
        Swal.fire({

            icon: 'warning',
            text: 'Se creará una orden de reparación y no se puede deshacer',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                if (tecnico == '') {
                    Swal.fire({
                        title: 'Ingrese técnico',
                        icon: 'error',
                    })
                } else {


                    Swal.fire({
                        title: 'Se creó orden!',
                        icon: 'success',
                    })
                    setTimeout(function () {

                        document.getElementById("form_est").submit();
                    }, 2000)




                }
            }
        })

    } else if (estado == 4) {
        Swal.fire({
            icon: 'warning',
            text: 'El estado del evento pasará a cancelado y no se puede deshacer',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {


                Swal.fire({
                    title: 'Evento cancelado!',
                    icon: 'success',
                })
                setTimeout(function () {
                    document.getElementById("form_est").submit();
                }, 2000)


            }
        })


    }

}




document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
});

// Inicializo menu para boton info

document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(elems);
});


// VER EVENTO ASOCIADO

function ver_evento() {
    var id_evento = document.getElementById("id_event").value;
    document.getElementById("inp_evento").value = id_evento;
    document.getElementById("form_ev").submit();

}


// AGREGAR TAREAS EN LA ORDEN DE REPARACION
/* 


function agregar_tarea1() {

    document.getElementById("insert_cod_1").style.display = "block";
}
function agregar_tarea2() {

    document.getElementById("insert_cod_2").style.display = "block";

}
function agregar_tarea3() {

    document.getElementById("insert_cod_3").style.display = "block";

}
function agregar_tarea4() {

    document.getElementById("insert_cod_4").style.display = "block";

}

function eliminar_tarea1() {

    var selec = document.getElementById("tarea1");
    selec.options[selec.selectedIndex].value = "";

    console.log(selec.options[selec.selectedIndex].value);
    document.getElementById("insert_cod_1").style.display = "none";
}
function eliminar_tarea2() {

    var selec = document.getElementById("tarea2");
    selec.options[selec.selectedIndex].value = "";

    console.log(selec.options[selec.selectedIndex].value);
    document.getElementById("insert_cod_2").style.display = "none";

}
function eliminar_tarea3() {
    var selec = document.getElementById("tarea3");
    selec.options[selec.selectedIndex].value = "";

    console.log(selec.options[selec.selectedIndex].value);

    document.getElementById("insert_cod_3").style.display = "none";

}
function eliminar_tarea4() {
    var selec = document.getElementById("tarea4");
    selec.options[selec.selectedIndex].value = "";

    console.log(selec.options[selec.selectedIndex].value);

    document.getElementById("insert_cod_4").style.display = "none";

}
 */


$(document).ready(function () {

    $('#tabla_ordenes').on('click', '#enabled', function (e) {
        e.preventDefault();
        console.log('clicked')
        var id_orden = e.target.id.slice(3)
        var selec_estado = document.getElementById("estado" + id_orden)
        var estado = selec_estado.options[selec_estado.selectedIndex].value
        var filaactual = $(this).closest("tr");
        console.log(filaactual);
        var id_evento = filaactual.find("td:eq(3)").find("a").text();

        if (estado == '4') {

            Swal.fire({
                icon: 'warning',
                text: 'La orden se cancelará y no podrá deshacerse',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Orden cancelada!',
                        icon: 'success',
                    })
                    setTimeout(function () {

                        document.getElementById("inp_evento").value = id_evento;
                        document.getElementById("inp_estado").value = "4"
                        console.log(id_evento)
                        document.getElementById("formu_orden").submit()
                    }, 2000)



                }

            })

        } else if (estado == '3') {
            let tareas = []
            var cant_tareas = 0;
            var contador = 1
            for (var i = 0; i < 4; i++) {

                var element = document.getElementById("tarea" + contador + id_orden)
                var t = element.options[element.selectedIndex].value
                if (t == '-') {
                    cant_tareas++
                }
                contador++
                tareas.push(t)

            }
            if (cant_tareas == 4) {

                Swal.fire({
                    title: 'Ingrese tarea/s',
                    icon: 'error',
                })

            } else {
                console.log(cant_tareas)
                Swal.fire({
                    title: 'Se guardó la orden!',
                    icon: 'success',
                })
                setTimeout(function () {
                    console.log(id_evento)
                    document.getElementById("inp_cr1").value = tareas[0];
                    document.getElementById("inp_cr2").value = tareas[1];
                    document.getElementById("inp_cr3").value = tareas[2];
                    document.getElementById("inp_cr4").value = tareas[3];
                    console.log(id_orden, " ", id_evento, " ", tareas[0], " ", tareas[1], " ", tareas[2], " ", tareas[3])
                    document.getElementById("inp_evento").value = id_evento;
                    document.getElementById("inp_orden").value = id_orden;
                    document.getElementById("inp_estado").value = '3';

                    document.getElementById("formu_orden").submit();
                    // var orden = document.getElementById("id_ord").value;
                    // envio_tareas(orden,campos[1],campos[2],campos[3],campos[4]);



                }, 2000)

            }
        }



    })
})






function envio_tareas(id_orden, cod_resol1, cod_resol2, cod_resol3, cod_resol4) {

    var url = "http://127.0.0.1:5000/insert_cod_orden"
    var data = {
        'id_orden': id_orden,
        'cod_resolucion': {
            '1': cod_resol1,
            '2': cod_resol2,
            '3': cod_resol3,
            '4': cod_resol4
        }
    }

    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-type': 'application/JSON'

        }
    }).then(res => res.json())
        .catch(error => console.error('Error:', error))
        .then(response => console.log('Success', response));


}

//inicializador date picker
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems);
});

//   // Or with jQuery

//   $(document).ready(function(){
//     $('.datepicker').datepicker();
//   });

// agregar usuario

function agregar() {

    var legajo = document.getElementById("legajo");
    var dni = document.getElementById("dni");
    var nombre = document.getElementById("nombre");
    var apellido = document.getElementById("apellido");
    var fecha_nac = document.getElementById("fecha_nac");
    var nivel = document.getElementById("nivel");
    var calle = document.getElementById("calle");
    var altura = document.getElementById("altura");
    var piso = document.getElementById("piso");
    var depto = document.getElementById("depto");
    var tel_pers = document.getElementById("tel_pers");
    var tel_lab = document.getElementById("tel_lab");
    var email = document.getElementById("email");
    var fecha_ing = document.getElementById("fecha_ing");
    var activo = document.getElementById("activo");

    if (legajo.value.length != 6) {
        Swal.fire({
            title: 'Revise legajo',
            icon: 'warning',
            text: 'La longitud del legajo debe ser igual a 6'
        });

        return 0
    } else {
        const Http = new XMLHttpRequest();
        const url = 'http://127.0.0.1:5000/users/' + legajo.value;
        Http.open('GET', url);
        Http.send();
        Http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (Http.response.length !== 3) {
                    Swal.fire({
                        title: 'Legajo existente',
                        icon: 'warning',
                        text: 'El legajo ya existe'
                    });
                    return 0
                }

            }
        }
    }
    if (dni.value.length < 6 || dni.value.length > 8) {
        Swal.fire({
            title: 'Revise dni',
            icon: 'warning',
            text: 'La longitud debe ser mayor a 5 y menor a 9'
        });
        dni.focus()
        return 0
    }
    if (nombre.value.length < 2) {
        Swal.fire({
            title: 'Revise nombre',
            icon: 'warning',
            text: 'La longitud del nombre debe ser mayor a 2'
        });
        nombre.focus()
        return 0
    }
    if (apellido.value.length < 2) {
        Swal.fire({
            title: 'Revise apellido',
            icon: 'warning',
            text: 'La longitud del apellido debe ser mayor a 2'
        });
        apellido.focus()
        return 0
    }
    var hoy = new Date();
    var miFechaNac = new Date(fecha_nac.value);
    const validarMiFecha = f => {
        if (f.getFullYear() > hoy.getFullYear()) {
            return 0
        }
        else if (f.getFullYear() == hoy.getFullYear() && (f.getMonth() > hoy.getMonth())) {
            return 0
        }
        else if (f.getFullYear() == hoy.getFullYear() && (f.getMonth() == hoy.getMonth()) && (f.getDate() > hoy.getDate())) {
            return 0
        }
        else return 1
    }

    if (fecha_nac.value === "" || validarMiFecha(miFechaNac) == 0) {

        Swal.fire({
            title: 'Agregue fecha de nacimiento válida',
            icon: 'warning',
        });
        fecha_nac.focus()
        return 0
    }
    if (nivel.options[nivel.selectedIndex].value == "") {
        Swal.fire({
            title: 'Agregue nivel',
            icon: 'warning',
        });
        nivel.focus()
        return 0
    }
    if (calle.value.length < 2) {
        Swal.fire({
            title: 'Revise calle',
            icon: 'warning',
            text: 'La longitud del campo calle debe ser mayor a 2'
        });
        calle.focus()
        return 0
    }
    if (altura.value.length == "") {
        Swal.fire({
            title: 'Revise este altura',
            icon: 'warning',
        });
        altura.focus()
        return 0
    }
    if (tel_pers.value.length < 10) {
        Swal.fire({
            title: 'Revise teléfono personal',
            icon: 'warning',
        });
        tel_pers.focus()
        return 0
    }
    if (tel_lab.value.length == "") {
        Swal.fire({
            title: 'Revise teléfono laboral',
            icon: 'warning',
        });
        tel_lab.focus()
        return 0
    }
    if (email.value.length == "") {
        Swal.fire({
            title: 'Revise email',
            icon: 'warning',
        });
        email.focus()
        return 0
    }
    var miFechaIng = new Date(fecha_ing.value);
    if (fecha_ing.value.length == "" || validarMiFecha(miFechaIng) == 0) {
        Swal.fire({
            title: 'Revise fecha de ingreso',
            icon: 'warning',
        });
        fecha_ing.focus()
        return 0
    }
    if (activo.options[activo.selectedIndex].value == "") {
        Swal.fire({
            title: 'Revise activo',
            icon: 'warning',
        });
        activo.focus()
        return 0
    }

    Swal.fire({
        title: 'Se guardó el nuevo usuario!',
        icon: 'success',
    })
    setTimeout(function () {

        document.getElementById("legajo1").value = legajo.value;
        document.getElementById("dni1").value = dni.value;
        document.getElementById("nombre1").value = nombre.value;
        document.getElementById("apellido1").value = apellido.value;
        document.getElementById("fecha_nac1").value = fecha_nac.value;
        document.getElementById("nivel1").value = nivel.options[nivel.selectedIndex].value;
        document.getElementById("calle1").value = calle.value;
        document.getElementById("altura1").value = altura.value;
        if (piso.value != null) {
            document.getElementById("piso1").value = piso.value;
        } else {
            document.getElementById("piso1").value = "-";
        }
        if (depto.value != null) {
            document.getElementById("depto1").value = depto.value;
        } else {
            document.getElementById("depto1").value = "-";
        }
        document.getElementById("tel_pers1").value = tel_pers.value;
        document.getElementById("tel_lab1").value = tel_lab.value;
        document.getElementById("email1").value = email.value;
        document.getElementById("fecha_ing1").value = fecha_ing.value;
        document.getElementById("activo1").value = activo.options[activo.selectedIndex].value;

        document.getElementById("cargar_user").submit();


    }, 2000)
}
//FUNCION QUE CARGA EL USER DESDE LA TABLA DE USERS
$(document).ready(function () {
    $('#tabla_usuario').on('click', '#modif', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        //console.log(filaactual); 
        var legajo = filaactual.find("td:eq(0)").text();
        //console.log(id_evento); 
        document.getElementById("legajo2").value = legajo;
        document.getElementById("modif_user").submit();


    });
});

// BUSCA EL BOTON ELIMINAR SEGUN LA FILA Y DESACTIVA EL USER

$(document).ready(function () {
    $('#tabla_usuario').on('click', '#borrar', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        //console.log(filaactual); 
        var legajo = filaactual.find("td:eq(0)").text();
        //console.log(id_evento); 
        document.getElementById("legajo2").value = legajo;
        document.getElementById("activo2").value = "0";
        Swal.fire({
            title: 'Se desactivó el usuario!',
            icon: 'success',
        })
        setTimeout(function () {

            document.getElementById("modif_user").submit();

        }, 2000)


    });
});

//FUNCION QUE ENVIA USUARIO MODIFICADO

function modificar() {

    var legajo = document.getElementById("legajo");
    var dni = document.getElementById("dni");
    var nombre = document.getElementById("nombre");
    var apellido = document.getElementById("apellido");
    var fecha_nac = document.getElementById("fecha_nac");
    var nivel = document.getElementById("nivel");
    var calle = document.getElementById("calle");
    var altura = document.getElementById("altura");
    var piso = document.getElementById("piso");
    var depto = document.getElementById("depto");
    var tel_pers = document.getElementById("tel_pers");
    var tel_lab = document.getElementById("tel_lab");
    var email = document.getElementById("email");
    var fecha_ing = document.getElementById("fecha_ing");
    var activo = document.getElementById("activo");

    if (legajo.value.trim().length != 6) {
        Swal.fire({
            title: 'Revise legajo',
            icon: 'warning',
            text: 'La longitud del legajo debe ser igual a 6'
        });
        $("#legajo").focus()
        return 0
    }
    if (dni.value.trim().length < 6 || dni.value.trim().length > 8) {
        Swal.fire({
            title: 'Revise dni',
            icon: 'warning',
            text: 'La longitud debe ser mayor a 5 y menor a 9'
        });
        dni.focus()
        return 0
    }
    if (nombre.value.trim().length < 2) {
        Swal.fire({
            title: 'Revise nombre',
            icon: 'warning',
            text: 'La longitud del nombre debe ser mayor a 2'
        });
        nombre.focus()
        return 0
    }
    if (apellido.value.trim().length < 2) {
        Swal.fire({
            title: 'Revise apellido',
            icon: 'warning',
            text: 'La longitud del apellido debe ser mayor a 2'
        });
        apellido.focus()
        return 0
    }
    var hoy = new Date();
    var miFechaNac = new Date(fecha_nac.value);
    const validarMiFecha = f => {
        if (f.getFullYear() > hoy.getFullYear()) {
            return 0
        }
        else if (f.getFullYear() == hoy.getFullYear() && (f.getMonth() > hoy.getMonth())) {
            return 0
        }
        else if (f.getFullYear() == hoy.getFullYear() && (f.getMonth() == hoy.getMonth()) && (f.getDate() > hoy.getDate())) {
            return 0
        }
        else return 1
    }

    if (fecha_nac.value === "" || validarMiFecha(miFechaNac) == 0) {

        Swal.fire({
            title: 'Agregue fecha de nacimiento válida',
            icon: 'warning',
        });
        fecha_nac.focus()
        return 0
    }
    if (nivel.options[nivel.selectedIndex].value == "") {
        Swal.fire({
            title: 'Agregue nivel',
            icon: 'warning',
        });
        nivel.focus()
        return 0
    }
    if (calle.value.length < 2) {
        Swal.fire({
            title: 'Revise calle',
            icon: 'warning',
            text: 'La longitud del campo calle debe ser mayor a 2'
        });
        calle.focus()
        return 0
    }
    if (altura.value.length == "") {
        Swal.fire({
            title: 'Revise este altura',
            icon: 'warning',
        });
        altura.focus()
        return 0
    }
    if (tel_pers.value.length < 10) {
        Swal.fire({
            title: 'Revise teléfono personal',
            icon: 'warning',
        });
        tel_pers.focus()
        return 0
    }
    if (tel_lab.value.length == "") {
        Swal.fire({
            title: 'Revise teléfono laboral',
            icon: 'warning',
        });
        tel_lab.focus()
        return 0
    }
    if (email.value.length == "") {
        Swal.fire({
            title: 'Revise email',
            icon: 'warning',
        });
        email.focus()
        return 0
    }
    var miFechaIng = new Date(fecha_ing.value);
    if (fecha_ing.value.length == "" || validarMiFecha(miFechaIng) == 0) {
        Swal.fire({
            title: 'Revise fecha de ingreso',
            icon: 'warning',
        });
        fecha_ing.focus()
        return 0
    }
    if (activo.options[activo.selectedIndex].value == "") {
        Swal.fire({
            title: 'Revise activo',
            icon: 'warning',
        });
        activo.focus()
        return 0
    }

    Swal.fire({
        title: 'Se modificó el usuario!',
        icon: 'success',
    })
    setTimeout(function () {

        document.getElementById("legajo3").value = legajo.value;
        document.getElementById("dni3").value = dni.value;
        document.getElementById("nombre3").value = nombre.value;
        document.getElementById("apellido3").value = apellido.value;
        document.getElementById("fecha_nac3").value = fecha_nac.value;
        document.getElementById("nivel3").value = nivel.options[nivel.selectedIndex].value;
        document.getElementById("calle3").value = calle.value;
        document.getElementById("altura3").value = altura.value;
        if (piso.value != null) {
            document.getElementById("piso3").value = piso.value;
        } else {
            document.getElementById("piso3").value = "-";
        }
        if (depto.value != null) {
            document.getElementById("depto3").value = depto.value;
        } else {
            document.getElementById("depto3").value = "-";
        }
        document.getElementById("tel_pers3").value = tel_pers.value;
        document.getElementById("tel_lab3").value = tel_lab.value;
        document.getElementById("email3").value = email.value;
        document.getElementById("fecha_ing3").value = fecha_ing.value;
        document.getElementById("activo3").value = activo.options[activo.selectedIndex].value;

        document.getElementById("cargar_modif_user").submit();


    }, 2000)
}

function blanquear() {
    $("input").each(function (i) {
        var elem = $(this)
        elem.val("")
    })
    $("#bt_agregar").removeAttr("disabled")
    $("#bt_modificar").prop("disabled", true)
    $("#legajo").prop("disabled", false)
}

function agregar_cod() {

    var codigo = document.getElementById("cod_evento");
    var descrip = document.getElementById("descripcion");
    var activo = document.getElementById("activo");

    if (codigo.value.trim().length != 3) {
        Swal.fire({
            title: 'Revise código',
            icon: 'warning',
            text: 'La longitud del código debe ser igual a 3'
        });
        return 0
    } else {
        const Http = new XMLHttpRequest();
        const url = 'http://127.0.0.1:5000/codigos_eventos/' + codigo.value.trim();
        Http.open('GET', url);
        Http.send();
        Http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (Http.response.length !== 3) {
                    Swal.fire({
                        title: 'Código existente',
                        icon: 'warning',
                        text: 'El código ya existe'
                    });
                    return 0
                }

            }
        }
    }

    if (descrip.value.length < 6 || descrip.value.length > 99) {
        Swal.fire({
            title: 'Revise descripcion',
            icon: 'warning',
            text: 'La longitud debe ser mayor a 5 y menor a 100 caracteres'
        });
        return 0
    }
    if (activo.options[activo.selectedIndex].value == "") {
        Swal.fire({
            title: 'Revise activo',
            icon: 'warning',
        });
        return 0
    }

    Swal.fire({
        title: 'Se guardó el nuevo código!',
        icon: 'success',
    })
    setTimeout(function () {

        document.getElementById("codigo1").value = codigo.value.trim()
        document.getElementById("descripcion1").value = descrip.value
        document.getElementById("activo1").value = activo.options[activo.selectedIndex].value

        document.getElementById("cargar_eve").submit();


    }, 2000)
}

//FUNCION QUE CARGA EL CODIGO DE EVENTO DESDE LA TABLA DE CODIGOS
$(document).ready(function () {
    $('#tabla_cod_e').on('click', '#modif', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        //console.log(filaactual); 
        var codigo = filaactual.find("td:eq(0)").text();
        //console.log(id_evento); 
        document.getElementById("codigo2").value = codigo;
        document.getElementById("modif_eve").submit();


    });
});

//FUNCION QUE ENVIA CODIGO DE EVENTO MODIFICADO

function modificar_cod() {

    var codigo = document.getElementById("cod_evento");
    var descripcion = document.getElementById("descripcion");
    var activo = document.getElementById("activo");


    if (descripcion.value.trim().length < 6 || descripcion.value.trim().length > 98) {
        Swal.fire({
            title: 'Revise descripcion',
            icon: 'warning',
            text: 'La longitud debe ser mayor a 5 y menor a 100'
        });
        return 0
    }
    if (activo.options[activo.selectedIndex].value == "") {
        Swal.fire({
            title: 'Revise activo',
            icon: 'warning',
        });
        activo.focus()
        return 0
    }

    Swal.fire({
        title: 'Se modificó el código!',
        icon: 'success',
    })
    setTimeout(function () {

        document.getElementById("codigo3").value = codigo.value;
        document.getElementById("descripcion3").value = descripcion.value;
        document.getElementById("activo3").value = activo.options[activo.selectedIndex].value;

        document.getElementById("cargar_modif_eve").submit();


    }, 2000)
}

function blanquear_cod() {
    $("input").each(function (i) {
        var elem = $(this)
        elem.val("")
    })
    $("#bt_agregar_cod").removeAttr("disabled")
    $("#bt_modificar_cod").prop("disabled", true)
    $("#cod_evento").prop("disabled", false)
}

// BUSCA EL BOTON ELIMINAR SEGUN LA FILA Y DESACTIVA EL CODIGO


$(document).ready(function () {
    $('#tabla_cod_e').on('click', '#borrar', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        //console.log(filaactual); 
        var codigo = filaactual.find("td:eq(0)").text();
        //console.log(id_evento); 
        document.getElementById("codigo2").value = codigo;
        document.getElementById("activo2").value = "0";
        Swal.fire({
            title: 'Se desactivó el codigo!',
            icon: 'success',
        })
        setTimeout(function () {

            document.getElementById("modif_eve").submit();

        }, 2000)


    });
});

//CODIGOS DE REPARACION

function agregar_cod_rep() {

    var codigo = document.getElementById("cod_rep");
    var descrip = document.getElementById("descripcion");
    var activo = document.getElementById("activo");

    if (codigo.value.trim().length != 3) {
        Swal.fire({
            title: 'Revise código',
            icon: 'warning',
            text: 'La longitud del código debe ser igual a 3'
        });
        return 0
    } else {
        const Http = new XMLHttpRequest();
        const url = 'http://127.0.0.1:5000/tareas/' + codigo.value.trim();
        Http.open('GET', url);
        Http.send();
        Http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (Http.response.length !== 3) {
                    Swal.fire({
                        title: 'Código existente',
                        icon: 'warning',
                        text: 'El código ya existe'
                    });
                    return 0
                }

            }
        }
    }

    if (descrip.value.length < 6 || descrip.value.length > 99) {
        Swal.fire({
            title: 'Revise descripcion',
            icon: 'warning',
            text: 'La longitud debe ser mayor a 5 y menor a 100 caracteres'
        });
        return 0
    }
    if (activo.options[activo.selectedIndex].value == "") {
        Swal.fire({
            title: 'Revise activo',
            icon: 'warning',
        });
        return 0
    }

    Swal.fire({
        title: 'Se guardó el nuevo código!',
        icon: 'success',
    })
    setTimeout(function () {

        document.getElementById("codigo1").value = codigo.value.trim()
        document.getElementById("descripcion1").value = descrip.value
        document.getElementById("activo1").value = activo.options[activo.selectedIndex].value

        document.getElementById("cargar_rep").submit();


    }, 2000)
}

//FUNCION QUE CARGA EL CODIGO DE reparacion DESDE LA TABLA DE CODIGOS
$(document).ready(function () {
    $('#tabla_cod_rep').on('click', '#modif', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        //console.log(filaactual); 
        var codigo = filaactual.find("td:eq(0)").text();
        //console.log(id_evento);
        if (codigo == "-") {
            return 0;
        }
        document.getElementById("codigo2").value = codigo;
        document.getElementById("modif_rep").submit();


    });
});

//FUNCION QUE ENVIA CODIGO DE EVENTO MODIFICADO

function modificar_cod_rep() {

    var codigo = document.getElementById("cod_rep");
    var descripcion = document.getElementById("descripcion");
    var activo = document.getElementById("activo");


    if (descripcion.value.trim().length < 6 || descripcion.value.trim().length > 98) {
        Swal.fire({
            title: 'Revise descripcion',
            icon: 'warning',
            text: 'La longitud debe ser mayor a 5 y menor a 100'
        });
        return 0
    }
    if (activo.options[activo.selectedIndex].value == "") {
        Swal.fire({
            title: 'Revise activo',
            icon: 'warning',
        });
        activo.focus()
        return 0
    }

    Swal.fire({
        title: 'Se modificó el código!',
        icon: 'success',
    })
    setTimeout(function () {

        document.getElementById("codigo3").value = codigo.value;
        document.getElementById("descripcion3").value = descripcion.value;
        document.getElementById("activo3").value = activo.options[activo.selectedIndex].value;

        document.getElementById("cargar_modif_rep").submit();


    }, 2000)
}

function blanquear_cod_rep() {
    $("input").each(function (i) {
        var elem = $(this)
        elem.val("")
    })
    $("#bt_agregar_cod_rep").removeAttr("disabled")
    $("#bt_modificar_cod_rep").prop("disabled", true)
    $("#cod_rep").prop("disabled", false)
}

// BUSCA EL BOTON ELIMINAR SEGUN LA FILA Y DESACTIVA EL CODIGO


$(document).ready(function () {
    $('#tabla_cod_rep').on('click', '#borrar', function (e) {
        e.preventDefault();
        var filaactual = $(this).closest("tr");
        //console.log(filaactual); 
        var codigo = filaactual.find("td:eq(0)").text();
        //console.log(id_evento);
        if (codigo == "-") {
            return 0;
        }
        document.getElementById("codigo2").value = codigo;
        document.getElementById("activo2").value = "0";
        Swal.fire({
            title: 'Se desactivó el codigo!',
            icon: 'success',
        })
        setTimeout(function () {

            document.getElementById("modif_rep").submit();

        }, 2000)


    });
});

// CAMBIAR CONTRASEÑA

function cambiar_cont() {
    var legajo = document.getElementById("legajo").value;
    var contActual = document.getElementById("pass_actual").value;
    if (contActual === "") {
        Swal.fire({
            title: 'Completar contraseña actual',
            icon: 'error',
        })
        return 0
    } else {
        const Http = new XMLHttpRequest();
        const url = 'http://127.0.0.1:5000/login/' + legajo;
        Http.open('GET', url);
        Http.send();
        Http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                const json = JSON.parse(Http.responseText);
                if (json.contrasenia != contActual) {

                    Swal.fire({
                        title: 'Verificar contraseña actual',
                        icon: 'error',
                    })
                    return 0

                } else {
                    var contNueva = document.getElementById("pass_nuevo").value;
                    var repContNueva = document.getElementById("pass_nuevo_r").value;
                    if (contNueva.trim() == "" || contNueva.trim().length < 4 || contNueva.trim().length > 8) {

                        Swal.fire({
                            title: 'La contraseña nueva debe tener entre 4 y 8 caracteres',
                            icon: 'error',
                        })
                        return 0

                    } else {
                        if (contNueva != repContNueva) {

                            Swal.fire({
                                title: 'Las contraseñas no coinciden',
                                icon: 'error',
                            })
                            return 0

                        } else {

                            const xhr = new XMLHttpRequest();
                            const url = 'http://127.0.0.1:5000/login/' + legajo;
                            xhr.open('PATCH', url);
                            xhr.setRequestHeader("Accept", "application/json");
                            xhr.setRequestHeader("Content-Type", "application/json");

                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4) {
                                    console.log(xhr.status);
                                    console.log(xhr.responseText);

                                }
                            };

                            const params = {
                                contrasenia: contNueva.trim()
                            }
                            xhr.send(JSON.stringify(params));
                            Swal.fire({
                                title: 'Cambio de contraseña exitoso',
                                icon: 'success',
                            })
                            setTimeout(function () {

                                location.reload();

                            }, 2000)

                            return 0

                        }
                    }

                }
            }
        }
    }
}




/**
 * mini jQuery plugin based on the answer by Nick Grealy
 * 
 * https://stackoverflow.com/a/19947532/4241030
 */
 /* (function($){
	$.fn.extend({
        makeSortable: function(){
            var MyTable = this;

            var getCellValue = function (row, index){ 
                return $(row).children('td').eq(index).text();
            };
            
            MyTable.find('th').click(function(){
                var table = $(this).parents('table').eq(0);
            
                // Sort by the given filter
                var rows = table.find('tr:gt(0)').toArray().sort(function(a, b) {
                    var index = $(this).index();
                    var valA = getCellValue(a, index), valB = getCellValue(b, index);
            
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
                });
            
                this.asc = !this.asc;
            
                if (!this.asc){
                    rows = rows.reverse();
                }
            
                for (var i = 0; i < rows.length; i++){
                    table.append(rows[i]);
                }
            });
        }
    });
})(jQuery);

$(function(){
	$("#tabla_eventos").makeSortable();
});
 */

/**
 * Modified and more readable version of the answer by Paul S. to sort a table with ASC and DESC order
 * with the <thead> and <tbody> structure easily.
 * 
 * https://stackoverflow.com/a/14268260/4241030
 */
 var TableSorter = {
    makeSortable: function(table){
        // Store context of this in the object
        var _this = this;
        var th = table.tHead, i;
        th && (th = th.rows[0]) && (th = th.cells);

        if (th){
            i = th.length;
        }else{
            return; // if no `<thead>` then do nothing
        }

        // Loop through every <th> inside the header
        while (--i >= 0) (function (i) {
            var dir = 1;

            // Append click listener to sort
            th[i].addEventListener('click', function () {
                _this._sort(table, i, (dir = 1 - dir));
            });
        }(i));
    },
    _sort: function (table, col, reverse) {
        var tb = table.tBodies[0], // use `<tbody>` to ignore `<thead>` and `<tfoot>` rows
        tr = Array.prototype.slice.call(tb.rows, 0), // put rows into array
        i;

        reverse = -((+reverse) || -1);

        // Sort rows
        tr = tr.sort(function (a, b) {
            // `-1 *` if want opposite order
            return reverse * (
                // Using `.textContent.trim()` for test
                a.cells[col].textContent.trim().localeCompare(
                    b.cells[col].textContent.trim()
                )
            );
        });

        for(i = 0; i < tr.length; ++i){
            // Append rows in new order
            tb.appendChild(tr[i]);
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems);
  });







