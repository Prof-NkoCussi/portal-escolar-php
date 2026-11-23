<?php
// index.php — Inicio del portal

// require trae otro archivo; si no lo encuentra, corta con error
// __DIR__ = la carpeta de este archivo (así la ruta nunca falla)
require __DIR__ . '/funciones.php';

$titulo = 'Inicio';                         // lo usa header.php en el <title>
require __DIR__ . '/includes/header.php';   // <head>, marca y menú
?>
<h1>Portal del C.T.P. "Olga B. de Arko"</h1>

<section class="tarjeta">
    <!-- fecha_larga() devuelve la fecha en castellano; e() la escapa al mostrarla -->
    <p>Hoy es <?= e(fecha_larga()) ?>.</p>
    <p>Las novedades se cargan en el próximo paso.</p>
</section>

<?php require __DIR__ . '/includes/footer.php'; // pie y cierre del HTML ?>
