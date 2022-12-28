(function(){

const tagsInput = document.querySelector('#tags_input')

if(tagsInput){
    //
    const tagsDiv = document.querySelector('#tags');
    const tagsInputHidden = document.querySelector('[name="tags"]');
    //arreglo vacio para llenar luego
    let tags = [];

    //recuperar input oculto
    if(tagsInputHidden.value !== ''){
        tags = tagsInputHidden.value.split(',');
        mostrarTags();
    }

    //escuchar los cambios en el input
    tagsInput.addEventListener('keypress', guardarTag);

/* ============================ GUARDAR TAGS ============================ */
function guardarTag(e){
    //si presiona coma
        if(e.keyCode === 44){
            //validar si no hay nada
            if(e.target.value.trim() === '' || e.target.value < 1){
                return;
            }
            //que no escriba la coma
            e.preventDefault();
            //copiar arreglo y agregar nuevo valor
            tags = [...tags, e.target.value.trim()]
            //limpiar input
            tagsInput.value = '';

            mostrarTags();
            console.log(tags);
        }
    }
    
/* ============================ MOSTRAR TAGS ============================ */
function mostrarTags(){
    tagsDiv.textContent = '';
    tags.forEach(tag =>{
        const etiqueta = document.createElement('LI');
        etiqueta.classList.add('formulario__tag');
        etiqueta.textContent = tag;
        etiqueta.ondblclick = eliminarTag;
        tagsDiv.appendChild(etiqueta);
    })
    actualizarInputHidden();
}

/* ============================ ELIMINAR TAGS ============================ */
function eliminarTag(e) {
    e.target.remove()
    tags = tags.filter(tag => tag !== e.target.textContent)
    actualizarInputHidden();
}
/* ============================ ALMACENAR TAGS ============================ */
function actualizarInputHidden() {
    tagsInputHidden.value = tags.toString();
 }
}
})();