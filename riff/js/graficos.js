let char1, char2, char3;

function ver_graficos() {

    if(char1){
        char1.destroy();
    }
    if(char2){
        char2.destroy();
    }
    if(char3){
        char3.destroy();
    }
    
   var fechainicial = document.getElementById("desde_fecha").value;
   var fechafinal = document.getElementById("hasta_fecha").value;

   if(fechafinal==""){
       fechafinal=Date();
   }
   

   if(Date.parse(fechafinal) < Date.parse(fechainicial)) {

    Swal.fire({
        title: 'La fecha final no puede ser anterior a la fecha inicial',
        icon: 'error',
    })
    return 0

    

   }
   var d = Date.parse(fechafinal) - Date.parse(fechainicial);
   var dias = Math.round(d/(1000*3600*24));

    

    const xhr = new XMLHttpRequest();
    const url = "http://127.0.0.1:5000/eventos";
    xhr.open('GET', url);
    xhr.send();
    
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            grafTorta(xhr, dias-1);
            grafBarra(xhr, dias-1);



        }
    }
    const xhr2 = new XMLHttpRequest();
    const url2 = "http://127.0.0.1:5000/ordenes";
    xhr2.open('GET', url2);
    xhr2.send();
    
    xhr2.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            grafTorta2(xhr2, dias-1);



        }
    }


    

}

function grafTorta(xhr, days) {


    var pend = 0
    var canc = 0
    var curs = 0
    var solu = 0

    const json = JSON.parse(xhr.responseText);
    const hoy = Date.now();
    const tiempo = new Date(hoy - (days * 24 * 3600 * 1000));
   
    json.forEach(e => {

        var cadena = e.fecha_creacion
        var dia = parseInt(cadena.substr(0, 2), 10);
        var mes = parseInt(cadena.substr(3, 2), 10);
        var anio = parseInt(cadena.substr(6, 4), 10);
        var fecha_num = new Date(anio + 2000, mes-1, dia);
       
        if (fecha_num > tiempo) {

            switch (e.desc_estado) {
                case "Pendiente":
                    
                    pend++;
                    break;
                case "Cursando":
                    curs++;
                    break;
                case "Solucionado":
                    solu++;
                    break;
                case "Cancelado":
                    canc++;
                    break;
            }

        }

        //console.log(pend)

    });

    let miCanvas = document.getElementById("torta");
    char1 = new Chart(miCanvas, {
        type: 'pie',
        data: {
            labels: ['Pendiente', 'Cursando', 'Solucionado', 'Cancelado'],
            datasets: [{

                data: [pend, curs, solu, canc],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ]

            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Eventos por tipo a ' + (days+1) + ' dias',
                    font: {
                        size: 16
                    }
                }
            },
            responsive: false
        }
    })

}

function grafBarra(xhr, days) {

    const json = JSON.parse(xhr.responseText);
    const hoy = Date.now();
    const tiempo = new Date(hoy - (days * 24 * 3600 * 1000));
    var fechas = getDates(tiempo, hoy);
    var fechas_string = [];
    fechas.forEach(f => {
        f = getFormattedDate(f);
        fechas_string.push(f);
    })
    var pendientes = [];
    fechas_string.forEach(f => {
        var pendi = 0;
        json.forEach(e => {
            
            var fecha_creacion = e.fecha_creacion;
            
            if (f == fecha_creacion) {
                pendi++;
            }
        })
        pendientes.push(pendi);
    })
    let miCanvas = document.getElementById("barra");
    var colores = [];
    for(var i=0;i<fechas_string.length;i++){

        var color = 'rgba('+getRandomArbitrary(0,255)+','+getRandomArbitrary(0,255)+','+getRandomArbitrary(0,255)+',0.2)';
        colores.push(color);

    }
    char2 = new Chart(miCanvas, {
        type: 'bar',
        data: {
            labels: fechas_string,
            datasets: [{
                label: 'Eventos',
                data: pendientes,
                backgroundColor: 'red',
                borderColor: colores
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Creación de eventos por día',
                    font: {
                        size: 16
                    }
                }
            },
            responsive: false,
            
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        steps: 1,
                        stepSize: 6,
                        max: 10 //max value for the chart is 60
                        }
                    
                }]
            
            
                        
        }
    })

}

function grafTorta2(xhr, days) {

    const json = JSON.parse(xhr.responseText);
    const hoy = Date.now();
    const tiempo = new Date(hoy - (days * 24 * 3600 * 1000));
    var tecnicos = []
   
    json.forEach(e => {

        var cadena = e.fecha_creacion
        var dia = parseInt(cadena.substr(0, 2), 10);
        var mes = parseInt(cadena.substr(3, 2), 10);
        var anio = parseInt(cadena.substr(6, 4), 10);
        var fecha_num = new Date(anio + 2000, mes-1, dia);

       
        if (fecha_num > tiempo) {

            if(e.estado=="Solucionado"){

                tecnicos.push(e.legajo_tecnico)

            }

        }

        //console.log(pend)

    });

    var repetidos = {};
    tecnicos.forEach(function(leg){
        repetidos[leg] = (repetidos[leg] || 0) + 1;
      });
    console.log(repetidos);
    var legajos = Object.keys(repetidos);
    var cant = Object.values(repetidos);
    var colores = []
    for(var i=0;i<legajos.length;i++){

        var color = 'rgba('+getRandomArbitrary(0,255)+','+getRandomArbitrary(0,255)+','+getRandomArbitrary(0,255)+',0.2)';
        colores.push(color);

    }


    let miCanvas = document.getElementById("polar_area");
    char3 = new Chart(miCanvas, {
        type: 'pie',
        data: {
            labels: legajos,
            datasets: [{

                data: cant,
                backgroundColor: colores

            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Eventos solucionados por técnico a ' + (days+1) + ' dias',
                    font: {
                        size: 16
                    }
                }
            },
            responsive: false
        }
    })

}

function getRandomArbitrary(min, max) {
    return Math.round(Math.random() * (max - min) + min);
  }

Date.prototype.addDays = function (days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

function getDates(startDate, stopDate) {
    var dateArray = new Array();
    var currentDate = startDate;
    while (currentDate <= stopDate) {
        dateArray.push(new Date(currentDate));
        currentDate = currentDate.addDays(1);
    }
    return dateArray;
}

function getFormattedDate(date) {
    let year = date.getFullYear().toString().substr(2,2);
    let month = (1 + date.getMonth()).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');

    return day + '-' + month + '-' + year;
}

