(function(){
    
    //seleccionar horas
    const horas = document.querySelector('#horasUl');

    if(horas){
        
        //seleccionar categoria conferencia o workshops
        const categoria = document.querySelector('[name="categoria_id"]');
        //seleccionar viernes o sabado
        const dias = document.querySelectorAll('[name="dia"]');
        
        //es el input oculto a llenar
        const inputHiddenDia = document.querySelector('[name="dia_id"]');
        const inputHiddenHora = document.querySelector('[name="hora_id"]');
        
        //agrego eventos a categoria y dias, y escuchar cambios
        categoria.addEventListener('change', terminoBusqueda);
        dias.forEach( dia => dia.addEventListener('change', terminoBusqueda))
        
        //objeto a llenar con los datos
        let busqueda = {
            categoria_id : categoria.value || '',
            dia : inputHiddenDia.value || ''
        }

        if(!Object.values(busqueda).includes('')){
            //la otra forma es como en ponentes.js ()=>
            async function iniciarApp() {
                await buscarEventos();
            
                const id = inputHiddenHora.value;
                //resaltar hora actual
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);
                horaSeleccionada.classList.remove('horas__hora--deshabilitada');
                horaSeleccionada.classList.add('horas__hora--seleccionada');

                horaSeleccionada.onclick = seleccionarHora;
            }
            iniciarApp();
        
        }
        //console.log(busqueda);
        
    /* ============================ AGREGAR DATOS AL OBJETO ============================ */
        //agrega el valor la categoria o dia 
        function terminoBusqueda(e){
            //llenar el objeto con datos a consultar
            busqueda[e.target.name] = e.target.value;
            
            //reiniciar campos ocultos y seleccion de horas, para al hacer click se refresque para cada dia
            inputHiddenHora.value = '';
            inputHiddenDia.value = '';
            
            //Deshabilitar hora previa
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia){
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }
            
            //evitar consulta innecesaria hasta que este completo el objeto
            if(Object.values(busqueda).includes('')){
                return;
            }
            
            buscarEventos();
        }
        
        /* ============================ CONSULTAR DATOS API ============================ */
        async function buscarEventos(){
            const {dia, categoria_id} = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;

            const resultado = await fetch(url);
            const eventos = await resultado.json();
            
            //traer de la db los eventos disponibles para ese dia y categoria
            obtenerHorasDisponibles(eventos);
        }

        /* ============================ SELECCIONAR HORAS DISPONIBLES ============================ */
        function obtenerHorasDisponibles(eventos) {
            //Comprobar elementos ya tomados y quitar la variable deshabilitado
            
            //retorna un nodelist, no un array, con todas las horas que existen
            const listadoHoras = document.querySelectorAll('#horas li');
            listadoHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'));

            //de los eventos traidos de la db, solo dejamos un array con los de hora_id
            const horasTomadas = eventos.map(evento => evento.hora_id);

            //conversion de nodelist a array
            const listadoHorasArray = Array.from(listadoHoras);

            //filtrar todos los que no trae eventos.map, osea los disponibles
            const resultado = listadoHorasArray.filter( li => !horasTomadas.includes(li.dataset.horaId));
            
            //quitar clase de deshabilitada a las disponibles
            resultado.forEach(li => li.classList.remove('horas__hora--deshabilitada'));

            //seleccionar las horas solo que esten disponibles
            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
            //asociar evento click solo a las disponibles
            horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora));
        }
        
        /* ============================ AGREGAR DATASET.ID AL INPUT ============================ */
        function seleccionarHora(e) {

            //Deshabilitar hora previa
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia){
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }
     
            //Agregar clase de seleccionado
            e.target.classList.add('horas__hora--seleccionada');

            //agregar hora y dia para el formulario
            inputHiddenHora.value = e.target.dataset.horaId; 
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        }
    }



})();