<?php
// horarios.php — horario de un curso, elegido con un formulario GET

require __DIR__ . '/funciones.php';
require __DIR__ . '/datos.php';             // trae $horarios y $modulos

// 1) Leer el curso que vino en la URL: horarios.php?curso=4-1
//    ?? '' → si no vino, queda vacío (sin Warning) · limpiar() saca espacios
$curso = limpiar($_GET['curso'] ?? '');

// 2) Lista blanca: solo vale si es una de las claves de $horarios
//    cualquier otra cosa (inventada, vacía, con código) se descarta
$valido = array_key_exists($curso, $horarios);

// el título de la pestaña cambia según el curso (operador ternario)
$titulo = $valido ? 'Horario de ' . $horarios[$curso]['nombre'] : 'Horarios';
require __DIR__ . '/includes/header.php';
?>
<h1>Horarios por curso</h1>

<!-- method="get": el curso viaja en la URL, así el link se puede guardar o compartir -->
<form class="tarjeta filtro" action="horarios.php" method="get">
    <label for="curso">Curso</label>
    <!-- name="curso" es la clave que después lee $_GET['curso'] -->
    <select id="curso" name="curso">
        <option value="">Elegí un curso</option>
        <?php foreach ($horarios as $clave => $info): ?>
            <!-- selected deja marcado el curso que se está viendo -->
            <option value="<?= e($clave) ?>"<?= $clave === $curso ? ' selected' : '' ?>><?= e($info['nombre']) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="boton" type="submit">Ver horario</button>
</form>

<?php if ($curso === ''): ?>
    <!-- todavía no eligió nada -->
    <p class="aviso">Elegí un curso para ver su horario.</p>
<?php elseif (!$valido): ?>
    <!-- vino algo que no está en la lista blanca; e() lo muestra como texto -->
    <p class="aviso aviso--error">El curso «<?= e($curso) ?>» no existe.</p>
<?php else: ?>
    <section class="tarjeta">
        <h2><?= e($horarios[$curso]['nombre']) ?> · turno mañana</h2>
        <!-- en el celular la tabla se desplaza de costado en vez de romper la página -->
        <div class="tabla-scroll">
            <table class="horario">
                <thead>
                    <tr>
                        <th scope="col">Hora</th>
                        <?php foreach ($horarios[$curso]['dias'] as $dia => $materias): ?>
                            <!-- una columna por día: se usa solo la clave ($dia) -->
                            <th scope="col"><?= e($dia) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($modulos); $i++): ?>
                        <!-- for: una fila por módulo; $i = 0, 1, 2, 3 -->
                        <tr>
                            <th scope="row"><?= e($modulos[$i]) ?></th>
                            <?php foreach ($horarios[$curso]['dias'] as $materias): ?>
                                <!-- de cada día, la materia del módulo $i (o una raya si falta) -->
                                <td><?= e($materias[$i] ?? '—') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
