<section class="section">
    <article class="panel">
        <h1>Error de aplicacion</h1>
        <p><?= e($errorMessage ?? 'Ocurrio un error inesperado.') ?></p>
        <p>Si es un error de MySQL, importa <code>database/schema.sql</code> y revisa <code>config/database.php</code>.</p>
    </article>
</section>
