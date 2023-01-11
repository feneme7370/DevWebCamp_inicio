<main class="registro">
    <h2 class="pagina__heading"><?php echo $titulo; ?></h2>
    <p class="pagina__descripcion">Tu boleto, puedes almacenarlo o compartirlo en redes sociales</p>

    <div class="boleto-virtual">
        <div class="boleto boleto--<?php echo strtolower($registro->paquete->nombre); ?> boleto--acceso ">
            <div class="boleto__contenido">
                <h2 class="boleto__logo">&#60;DevWebCamp /></h2>
                <p class="boleto__plan"><?php echo $registro->paquete->nombre; ?></p>
                <p class="boleto__nombre"><?php echo $registro->usuario->nombre ." ". $registro->usuario->apellido; ?></p>

                <p class="boleto__codigo"><?php echo '#' . $registro->token; ?></p>
            </div>
        </div>
    </div>

</main>
<!-- http://127.0.0.1:3000/boleto?id=5c015ce5 -->