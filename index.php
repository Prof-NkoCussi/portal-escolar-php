<?php
// index.php — Inicio: las novedades del colegio

// require trae otro archivo; si no lo encuentra, corta con error
// __DIR__ = la carpeta de este archivo (así la ruta nunca falla)
require __DIR__ . '/funciones.php';
require __DIR__ . '/datos.php';             // trae el array $novedades

$titulo = 'Inicio';                         // lo usa header.php en el <title>
require __DIR__ . '/includes/header.php';   // <head>, marca y menú
?>
<h1>Novedades</h1>
<!-- fecha_larga() da la fecha en castellano · count() cuenta las novedades -->
<p class="bajada">Hoy es <?= e(fecha_larga()) ?> · <?= count($novedades) ?> novedades publicadas</p>

<?php if (count($novedades) === 0): ?>
    <!-- si el array está vacío, se avisa en vez de dejar la página en blanco -->
    <p class="tarjeta">Por ahora no hay novedades.</p>
<?php else: ?>
    <div class="grilla">
        <?php foreach ($novedades as $n): ?>
            <!-- una tarjeta por novedad: el mismo HTML, otros datos en cada vuelta -->
            <article class="tarjeta novedad">
                <p class="novedad__meta">
                    <span class="etiqueta"><?= e($n['categoria']) ?></span>
                    <!-- <time> marca una fecha; datetime la guarda en formato de máquina -->
                    <time datetime="<?= e($n['fecha']) ?>"><?= e(fecha_corta($n['fecha'])) ?></time>
                </p>
                <h2><?= e($n['titulo']) ?></h2>
                <p><?= e($n['texto']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; // pie y cierre del HTML ?>
