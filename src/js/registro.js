import Swal from 'sweetalert2'

(function(){
    let eventos = [];
    const resumen = document.querySelector('#registro-resumen');

    if (resumen) {
        
        const evemtoBoton = document.querySelectorAll('.evento__agregar');
    
        evemtoBoton.forEach( boton => {
            boton.addEventListener('click', seleccionarEvento)
        })

        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit', submitFormulario);

        mostrarEventos();
    
        function seleccionarEvento(e){
    
            if(eventos.length < 5){
                eventos = [...eventos, {
                    id: e.target.dataset.id,
                    
                    //seleccionar elemento padre y de ahi buscar abajo el titulo
                    titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }] 
                //desabilitar evento
                e.target.disabled = true;
                
                mostrarEventos();
            }else{
                Swal.fire({
                    title : 'error',
                    text : 'Solo se permiten hasta 5 opciones',
                    icon :  'error',
                    confirmButtonText : 'Ok' 
                })
            }
    
        }
    
        function mostrarEventos() {
            //limpiar html
            limpiarEventos();
    
            if(eventos.length > 0){
                eventos.forEach( evento => {
                    const eventoDOM = document.createElement('DIV');
                    eventoDOM.classList.add('registro__evento');
    
                    const botonEliminar = document.createElement('BUTTON');
                    botonEliminar.classList.add('registro__eliminar');
                    botonEliminar.innerHTML = `<div><i class="fa-solid fa-trash"></i> Borrar</div>`;
                    botonEliminar.onclick = function(){
                        eliminarEvento(evento.id);
                    }
    
                    const titulo = document.createElement('H3');
                    titulo.classList.add('registro__nombre');
                    titulo.textContent = evento.titulo;
                    
                    eventoDOM.appendChild(titulo);
                    eventoDOM.appendChild(botonEliminar);
                    resumen.appendChild(eventoDOM);
                })
            }else{
                const noRegistro = document.createElement('P');
                noRegistro.textContent = 'Elige hasta un maximo de 5 eventos';
                noRegistro.classList.add('registro__texto');
                resumen.appendChild(noRegistro);
            }
        }
    
        function eliminarEvento(id){
            eventos = eventos.filter( evento => evento.id !== id);
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            mostrarEventos();
        }
    
        function limpiarEventos(){
            while(resumen.firstChild){
                resumen.removeChild(resumen.firstChild);
            }
        }

        async function submitFormulario(e){
            e.preventDefault();

            //validar regalo
            const regaloId = document.querySelector('#regalo').value;
            const eventosId = eventos.map( evento => evento.id);

            if(eventosId.length === 0 || regaloId === ''){
                Swal.fire({
                    title : 'error',
                    text : 'Debe seleccionar al menos un evento y un regalo',
                    icon :  'error',
                    confirmButtonText : 'Ok' 
                })
                return;
            }

            //formData con los datos a enviar
            const datos = new FormData();
            datos.append('eventos', eventosId);
            datos.append('regalo_id', regaloId);

            const url = '/finalizar-registro/conferencias';
            const respuesta = await fetch(url, {
                method : 'POST',
                body : datos
            })

            const resultado = await respuesta.json();
            
            if(resultado.resultado){
                Swal.fire(
                    'registro exitoso',
                    'Tus conferencias se han almacenada y tu registro fue exitoso',
                    'success'
                ).then( () => location.href = `/boleto?id=${resultado.token}`)
            }else{
                Swal.fire({
                    title : 'error',
                    text : 'Hubo un error',
                    icon :  'error',
                    confirmButtonText : 'Ok' 
                }).then(location.reload())
            }
            
            
        }
    }

})();