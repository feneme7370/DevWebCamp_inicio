<fieldset class="formulario__fielset">
    <legend class="formulario__legend">Informacion evento</legend>
    
    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre del evento</label>
        <input 
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre del evento"
            value="<?php echo $eventos->nombre; ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripcion del evento</label>
        <textarea
            rows="5"
            class="formulario__input"
            id="descripcion"
            name="descripcion"
            placeholder="Descripcion del evento"
        ><?php echo $eventos->descripcion; ?></textarea>
    </div>

    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Categoria del evento</label>
        <select name="categoria_id" id="categoria" class="formulario__select">
            <option value="">- Seleccionar -</option>
            
            <?php foreach($categorias as $categoria){ ?>
                <option <?php echo ($eventos->categoria_id === $categoria->id) ? 'selected' : ''; ?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
            <?php } ?>
        
        </select>
    </div>

    <div class="formulario__campo">
        <label for="dia" class="formulario__label">Selecciona el dia</label>
        
        <div class="formulario__radio">
            <?php foreach($dias as $dia){ ?>
                <div>
                    <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre; ?></label>
                    <input 
                        type="radio" 
                        id="<?php echo strtolower($dia->nombre); ?>"
                        name="dia"
                        value="<?php echo $dia->id; ?>"
                        <?php echo ($eventos->dia_id === $dia->id) ? 'checked' : ''; ?>
                    >
                </div>
            <?php } ?>
        </div>
    </div>

    <input type="hidden" name="dia_id" value="<?php echo $eventos->dia_id; ?>">

    <div id="horas" class="formulario__campo">
        <label for="" class="formulario__label">Seleccionar hora</label>
            <ul id="horasUl" class="horas">
                <?php foreach($horas as $hora){ ?>
                    <li data-hora-id="<?php echo $hora->id; ?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora; ?></li>
                <?php } ?>
            </ul>

            <input type="hidden" name="hora_id" value="<?php echo $eventos->hora_id; ?>">
    </div>

</fieldset>

<fieldset class="formulario__fielset">
    <legend class="formulario__legend">Informacion Extra</legend>

    <div class="formulario__campo">
        <label for="ponentes" class="formulario__label">Buscar Ponente</label>
        <input 
            type="text"
            class="formulario__input"
            id="ponentes"
            placeholder="Buscar ponente"
        >

        <ul class="listado-ponentes" id="listado-ponentes"></ul>
        <input type="hidden" name="ponente_id" value="<?php echo $eventos->ponente_id;?>">
    </div>

    <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Lugares disponibles</label>
        <input 
            type="number"
            min="1"
            class="formulario__input"
            id="disponibles"
            name="disponibles"
            placeholder="Ej. 20"
            value="<?php echo $eventos->disponibles; ?>"
        >
    </div>

</fieldset>