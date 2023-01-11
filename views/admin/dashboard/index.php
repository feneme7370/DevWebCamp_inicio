<h1><?php echo $titulo; ?></h1>

<div class="bloques">
    <div class="bloques__grid">
        <div class="bloque">
            <h3 class="bloque__heading">Ultimos registros</h3>
            <?php foreach($registros as $registro){ ?>
                <div class="bloque__contenido">
                    <div class="bloque__texto">
                        <?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="bloque">
            <h3 class="bloque__heading">Ingresos</h3>
            <p class="bloque__texto--cantidad">$ <?php echo $ingresos; ?></p>
        </div>
        <div class="bloque">
            <h3 class="bloque__heading">Eventos con menos lugares</h3>
            <?php foreach($menos_lugares as $evento){ ?>
                <div class="bloque__contenido">
                    <div class="bloque__texto">
                        <?php echo $evento->nombre . " - " . $evento->disponibles . " Disponibles"; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="bloque">
            <h3 class="bloque__heading">Eventos con mas lugares</h3>
            <?php foreach($mas_lugares as $evento){ ?>
                <div class="bloque__contenido">
                    <div class="bloque__texto">
                        <?php echo $evento->nombre . " - " . $evento->disponibles . " Disponibles"; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>