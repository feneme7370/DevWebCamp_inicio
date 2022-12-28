<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Coloca tu nuevo password de DevWebCamp</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php if($token_valido){ ?>

        
        <form method="POST" class="formulario">
            <div class="formulario__campo">
                <label for="password" class="formulario__label">Password</label>
                <input 
                type="password"
                class="formulario__input"
                placeholder="tu password"
                id="password"
                name="password"
                >
            </div>
            
            <input type="submit" class="formulario__submit" value="enviar instrucciones">
        </form>
        
    <?php } ?>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">Ya tienes una cuenta? inicia sesion</a>
        <a href="/registro" class="acciones__enlace">Aun no tinenes cuenta? obtener una</a>
    </div>
</main>