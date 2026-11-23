<?php
// especialidades.php — las especialidades y sus materias por año

require __DIR__ . '/funciones.php';
require __DIR__ . '/datos.php';             // trae el array $especialidades

$titulo = 'Especialidades';
require __DIR__ . '/includes/header.php';
?>
<h1>Especialidades</h1>
<p class="bajada">Materias de cada año (datos de ejemplo)</p>

<?php foreach ($especialidades as $clave => $esp): ?>
    <!-- vuelta de afuera: una especialidad por vez; $clave = 'basico' o 'programacion' -->
    <section class="tarjeta especialidad" id="<?= e($clave) ?>">
        <h2><?= e($esp['nombre']) ?></h2>
        <p><?= e($esp['descripcion']) ?></p>

        <div class="anios">
            <?php foreach ($esp['materias'] as $anio => $lista): ?>
                <!-- vuelta del medio: un año por vez; $anio = 1, 2, 3… y $lista = sus materias -->
                <div class="anio">
                    <!-- las llaves: sin ellas PHP tomaría el ° como parte del nombre de la variable -->
                    <h3><?= "{$anio}° año" ?></h3>
                    <ul>
                        <?php foreach ($lista as $materia): ?>
                            <!-- vuelta de adentro: una materia por vez -->
                            <li><?= e($materia) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endforeach; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
