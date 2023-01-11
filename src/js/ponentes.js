(function(){

    const ponentesInput = document.querySelector('#ponentes');

    if(ponentesInput){
        let ponentes = [];
        let ponentesFiltrados = [];

        const listadoPonentes = document.querySelector('#listado-ponentes');
        const ponenteHidden = document.querySelector('[name="ponente_id"]');
        obtenerPonentes();

        ponentesInput.addEventListener('input', buscarPonentes)

        //mostrar el ponente en editar evento
        if(ponenteHidden.value){
            (async () => {
                const ponente = await obtenerPonente(ponenteHidden.value);

                //insertar en el html
                const ponenteDOM = document.createElement('LI');
                ponenteDOM.classList.add('listado-ponente', 'listado-ponente--seleccionado')
                ponenteDOM.textContent = `${ponente.nombre} ${ponente.apellido}`;

                listadoPonentes.appendChild(ponenteDOM);
            })();
        }
    
        async function obtenerPonentes(){
            const url = `/api/ponentes`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            formatearPonentes(resultado);
        }

        async function obtenerPonente(id){
            const url = `/api/ponente?id=${id}`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            return resultado;
        }

        function formatearPonentes(arrayPonentes = []){
            ponentes = arrayPonentes.map( ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            })
            
        }

        function buscarPonentes(e){
            const busqueda = e.target.value;

            if(busqueda.length > 3){
                const expresion = new RegExp(busqueda, "i");
                ponentesFiltrados = ponentes.filter(ponente => {
                    if(ponente.nombre.toLowerCase().search(expresion) != -1){
                        return ponente;
                    }
                })
            }else{
                ponentesFiltrados = [];
            }

            mostrarPonentes();
        }
        function mostrarPonentes(){
            //listadoPonentes.innerHTML  = '';
            while(listadoPonentes.firstChild){
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }

            if(ponentesFiltrados.length > 0){
                ponentesFiltrados.forEach(ponente => {
                    const ponenteHTML = document.createElement('LI');
                    ponenteHTML.classList.add('listado-ponentes__ponente');
                    ponenteHTML.textContent = ponente.nombre;
                    ponenteHTML.dataset.ponenteId = ponente.id;
                    ponenteHTML.onclick = seleccionarPonente;
    
                    listadoPonentes.appendChild(ponenteHTML);
                })
            }else{
                const noResultados = document.createElement('P');
                noResultados.classList.add('listado-ponentes__no-resultado');
                noResultados.textContent = 'No hay resultados';

                listadoPonentes.appendChild(noResultados);
            }
        }

        function seleccionarPonente(e){
            const ponente = e.target;

            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--seleccionado');
            if(ponentePrevio){
                ponentePrevio.classList.remove('listado-ponentes__ponente--seleccionado');
            }
            ponente.classList.add('listado-ponentes__ponente--seleccionado');
            ponenteHidden.value = ponente.dataset.ponenteId;
        }
    }
    

})();