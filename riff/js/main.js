/* const btnToggle = document.querySelector('.toggle-btn');
btnToggle.addEventListener('click',function(){
    document.getElementById('sidebar').classList.toggle('active');
});


const obtDetail = document.querySelector('#guardar_bt');
obtDetail.addEventListener('click',function(){
    let str = `http://127.0.0.1:5000/eventos`;
    const evento = new XMLHttpRequest();
    evento.open('GET',str,true);
    evento.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){

            console.log(this.responseText);

        }
    }

}) */



// movimiento de la tabla
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
  });

// obtener valor de la tabla al seleccionar detalles
$(document).ready(function() {
    $('#tabla_eventos').on('click', '#guardar_bt', function(e) {
        e.preventDefault(); 
        var filaactual = $(this).closest("tr"); 
        var id_evento = filaactual.find("td:eq(0)").text();
        console.log(id_evento); 
        document.getElementById("evento").value = id_evento;
        document.getElementById("formu").submit();
        
    });
});

/* $(document).ready(function(){
    $('#estado').change(function(){
        
        if($(this).val()==="1"){
            $('#tec').prop('disabled',false);
        }else{
            $('#tec').prop('disabled','disabled');
        }
    })
})
 */
//obtener estado y tecnico del evento y enviar por post
function enviar_estado(){
    var select = document.getElementById("estado");
    var estado = select.options[select.selectedIndex].value;
    document.getElementById("inp_estado").value = estado;
    var sel = document.getElementById("tec");
    var tecnico = sel.options[sel.selectedIndex].value;
    document.getElementById("inp_tecnico").value = tecnico;
    var sel2 = document.getElementById("id_event");
    var ev = sel2.value;
    document.getElementById("inp_evento").value = ev;
    console.log(tecnico,estado,ev);
    if(estado==2){
        Swal.fire({
            
            icon: 'warning',
            text: 'Se creará una orden de reparación y no se puede deshacer',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result)=>{
            if(result.isConfirmed){
                if(tecnico==''){
                    Swal.fire({
                        title:'Ingrese técnico',
                        icon: 'error',
                    })
                }else{
                    
                    
                    Swal.fire({
                        title:'Se creó orden!',
                        icon: 'success',
                    })
                    setTimeout(function(){
                        document.getElementById("form_est").submit();
                    },2000)
                    
                    
                    

                }
            }
        })
        
    }else if(estado==4){
        Swal.fire({
            icon: 'warning',
            text: 'El estado del evento pasará a cancelado y no se puede deshacer',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result)=>{
            if(result.isConfirmed){
                
                
                Swal.fire({
                    title:'Evento cancelado!',
                    icon: 'success',
                })
                setTimeout(function(){
                    document.getElementById("form_est").submit();
                },2000)
                

            }
        })
        
        
    }
   
}




document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
  });


/* const obtDetail = document.querySelector('#guardar_bt');
obtDetail.addEventListener('click',function(){
    fetch('http://127.0.0.1:5000/eventos')
      .then(response => response.json())
      .then(json => console.log(json)) */
    /* let str = 'js/prueba.json';
    const evento = new XMLHttpRequest();
    evento.open('GET',str,true);
    evento.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){

            console.log(this.responseText);

        }
        else{
            console.log(this.status);
        } */
    





