<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Recupera tu acceso a DevWebCamp</p>

    <form action="" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email"
                class="formulario__input"
                placeholder="tu email"
                id="email"
                name="email"
            >
        </div>

        <input type="submit" class="formulario__submit" value="enviar instrucciones">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">Ya tienes una cuenta? inicia sesion</a>
        <a href="/registro" class="acciones__enlace">Aun no tinenes cuenta? obtener una</a>
    </div>
</main>