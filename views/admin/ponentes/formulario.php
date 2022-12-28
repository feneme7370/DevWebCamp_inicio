<fieldset class="formulario__fielset">
    <legend class="formulario__legend">Informacion personal</legend>
    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input 
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="nombre ponente"
            value="<?php echo $ponente->nombre ?? ''; ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="apellido" class="formulario__label">Apellido</label>
        <input 
            type="text"
            class="formulario__input"
            id="apellido"
            name="apellido"
            placeholder="apellido ponente"
            value="<?php echo $ponente->apellido ?? ''; ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="ciudad" class="formulario__label">Ciudad</label>
        <input 
            type="text"
            class="formulario__input"
            id="ciudad"
            name="ciudad"
            placeholder="ciudad ponente"
            value="<?php echo $ponente->ciudad ?? ''; ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="pais" class="formulario__label">Pais</label>
        <input 
            type="text"
            class="formulario__input"
            id="pais"
            name="pais"
            placeholder="pais ponente"
            value="<?php echo $ponente->pais ?? ''; ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="imagen" class="formulario__label">Imagen</label>
        <input 
            type="file"
            class="formulario__input formulario__input--file"
            id="imagen"
            name="imagen"
        >
    </div>

    <?php if(isset($ponente->imagen_actual)){ ?>
        <p class="formulario__texto">Imagen Actual</p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $ponente->imagen . '.webp'; ?>" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $ponente->imagen . '.png'; ?>" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/speakers/' . $ponente->imagen . '.png'; ?>" alt="Imagen Ponente">
            </picture>
        </div>
    <?php } ?>
</fieldset>

<fieldset class="formulario__fielset">
    <legend class="formulario__legend">Informacion extra</legend>
    <div class="formulario__campo">
        <label for="pais" class="formulario__label">Areas de experiencia (separar por coma)</label>
        <input 
            type="text"
            class="formulario__input"
            id="tags_input"
            placeholder="Ej. Node.js, PHP, JavaScript, Laravel"
        >
    </div>
    <div id="tags" class="formulario__listado"></div>
    <input type="hidden" name="tags" value="<?php echo $ponente->tags ?? ''; ?>">
</fieldset>

<fieldset class="formulario__fielset">
    <legend class="formulario__legend">Redes sociales</legend>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-facebook"></i>
            </div>
            <input 
                type="text"
                class="formulario__input--sociales"
                name="redes[facebook]"
                placeholder="facebook"
                value="<?php echo $redes->facebook ?? ''; ?>"
            >
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-twitter"></i>
            </div>
            <input 
                type="text"
                class="formulario__input--sociales"
                name="redes[twitter]"
                placeholder="twitter"
                value="<?php echo $redes->twitter ?? ''; ?>"
            >
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input 
                type="text"
                class="formulario__input--sociales"
                name="redes[youtube]"
                placeholder="youtube"
                value="<?php echo $redes->youtube ?? ''; ?>"
            >
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-instagram"></i>
            </div>
            <input 
                type="text"
                class="formulario__input--sociales"
                name="redes[instagram]"
                placeholder="instagram"
                value="<?php echo $redes->instagram ?? ''; ?>"
            >
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-tiktok"></i>
            </div>
            <input 
                type="text"
                class="formulario__input--sociales"
                name="redes[tiktok]"
                placeholder="tiktok"
                value="<?php echo $redes->tiktok ?? ''; ?>"
            >
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-github"></i>
            </div>
            <input 
                type="text"
                class="formulario__input--sociales"
                name="redes[github]"
                placeholder="github"
                value="<?php echo $redes->github ?? ''; ?>"
            >
        </div>
    </div>
</fieldset>
