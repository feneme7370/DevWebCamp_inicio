<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Inicia sesion de DevWebCamp</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <form method="POST" action="/login" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email"
                class="formulario__input"
                placeholder="tu email"
                id="email"
                name="email"
                autofocus
            >
        </div>
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

        <input type="submit" class="formulario__submit" value="iniciar sesion">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">Aun no tinenes cuenta? obtener una</a>
        <a href="/olvide" class="acciones__enlace">Olvide mi password</a>
    </div>
</main>