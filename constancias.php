<?php
// constancias.php — Secretaría: modelo de constancia docente para imprimir
// Junta todo lo del día: POST, validación, switch, date(), número correlativo e impresión

require __DIR__ . '/funciones.php';

// Lista de tipos para el <select> (el switch de abajo decide el texto de cada uno)
$tipos = [
    'servicio' => 'De servicio',
    'horario'  => 'De horario',
    'jornada'  => 'De asistencia a jornada',
];

$datos   = ['apellido' => '', 'nombre' => '', 'dni' => '', 'tipo' => '', 'ante' => ''];
$errores = [];
$constancia = null;     // queda en null hasta que haya una constancia lista para mostrar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Leer y limpiar
    foreach ($datos as $campo => $vacio) {
        $datos[$campo] = limpiar($_POST[$campo] ?? '');
    }

    // 2) Validar
    if ($datos['apellido'] === '' || mb_strlen($datos['apellido']) > 60) {
        $errores['apellido'] = 'Escribí el apellido (hasta 60 letras).';
    }
    if ($datos['nombre'] === '' || mb_strlen($datos['nombre']) > 60) {
        $errores['nombre'] = 'Escribí el nombre (hasta 60 letras).';
    }
    if (!validar_dni($datos['dni'])) {
        $errores['dni'] = 'El DNI tiene que tener 7 u 8 números, sin puntos.';
    }
    if (mb_strlen($datos['ante']) > 80) {
        $errores['ante'] = 'Máximo 80 letras.';
    }

    // 3) switch: el texto depende del tipo; default atrapa cualquier valor inventado
    switch ($datos['tipo']) {
        case 'servicio':
            $tituloConstancia = 'Constancia de servicio';
            $cuerpo = 'presta servicios como docente en este establecimiento';
            break;
        case 'horario':
            $tituloConstancia = 'Constancia de horario';
            $cuerpo = 'cumple funciones en este establecimiento según el horario registrado en Secretaría';
            break;
        case 'jornada':
            $tituloConstancia = 'Constancia de asistencia a jornada';
            $cuerpo = 'asistió a la jornada institucional realizada en este establecimiento en el día de la fecha';
            break;
        default:
            $errores['tipo'] = 'Elegí un tipo de constancia de la lista.';
    }

    // 4) Solo si todo está bien se gasta un número (un intento con errores no lo consume)
    if (count($errores) === 0) {
        $n = siguiente_numero(__DIR__ . '/almacen/contador.txt');
        if ($n === 0) {
            $errores['general'] = 'No se pudo generar el número de constancia. Revisar los permisos de la carpeta almacen/.';
        } else {
            $constancia = [
                // str_pad completa con ceros a la izquierda: 7 → 0007
                'numero'  => str_pad((string) $n, 4, '0', STR_PAD_LEFT) . '/' . date('Y'),
                'titulo'  => $tituloConstancia,
                'cuerpo'  => $cuerpo,
                // mb_strtoupper pasa a mayúsculas respetando tildes y ñ
                'persona' => mb_strtoupper($datos['apellido']) . ', ' . $datos['nombre'],
                // number_format pone los puntos de miles: 28456123 → 28.456.123
                'dni'     => number_format((int) $datos['dni'], 0, ',', '.'),
                // si no completó "ante", va la fórmula de siempre
                'ante'    => $datos['ante'] !== '' ? $datos['ante'] : 'quien corresponda',
                'emitida' => date('d/m/Y H:i'),       // la pone el servidor, no el formulario
            ];
        }
    }
}

$titulo = 'Secretaría · Constancias';
require __DIR__ . '/includes/header.php';
?>
<!-- no-imprimir: el título de la página no sale en el papel, solo la constancia -->
<h1 class="no-imprimir">Secretaría · Constancias docentes</h1>

<?php if ($constancia !== null): ?>
    <!-- la constancia: todo lo que vino del usuario pasa por e() -->
    <article class="constancia">
        <p class="constancia__num">Constancia N.º <?= e($constancia['numero']) ?></p>
        <p class="constancia__escuela">C.T.P. "Olga B. de Arko" · Ushuaia</p>
        <h2 class="constancia__titulo"><?= e($constancia['titulo']) ?></h2>
        <p>Se deja constancia de que <strong><?= e($constancia['persona']) ?></strong>, DNI <?= e($constancia['dni']) ?>, <?= e($constancia['cuerpo']) ?>.</p>
        <p>A pedido de la persona interesada y para ser presentada ante <strong><?= e($constancia['ante']) ?></strong>, se extiende la presente en Ushuaia, el <?= e(fecha_larga()) ?>.</p>
        <p class="constancia__pie">Emitida el <?= e($constancia['emitida']) ?> · Modelo de práctica, sin firma ni sello.</p>
    </article>

    <!-- no-imprimir: los botones no salen en el papel -->
    <p class="acciones no-imprimir">
        <button class="boton" type="button" data-imprimir>Imprimir</button>
        <a href="constancias.php">Nueva constancia</a>
    </p>
<?php else: ?>
    <?php if (count($errores) > 0): ?>
        <p class="aviso aviso--error"><?= isset($errores['general']) ? e($errores['general']) : 'Revisá los campos marcados en rojo.' ?></p>
    <?php endif; ?>

    <form class="tarjeta formulario" action="constancias.php" method="post">
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input id="apellido" name="apellido" maxlength="60" required
                   value="<?= e($datos['apellido']) ?>"<?= isset($errores['apellido']) ? ' aria-invalid="true"' : '' ?>>
            <?php if (isset($errores['apellido'])): ?><p class="campo__error"><?= e($errores['apellido']) ?></p><?php endif; ?>
        </div>

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" maxlength="60" required
                   value="<?= e($datos['nombre']) ?>"<?= isset($errores['nombre']) ? ' aria-invalid="true"' : '' ?>>
            <?php if (isset($errores['nombre'])): ?><p class="campo__error"><?= e($errores['nombre']) ?></p><?php endif; ?>
        </div>

        <div class="campo">
            <label for="dni">DNI (sin puntos)</label>
            <!-- inputmode="numeric": en el celular abre el teclado de números -->
            <input id="dni" name="dni" inputmode="numeric" maxlength="8" required
                   value="<?= e($datos['dni']) ?>"<?= isset($errores['dni']) ? ' aria-invalid="true"' : '' ?>>
            <?php if (isset($errores['dni'])): ?><p class="campo__error"><?= e($errores['dni']) ?></p><?php endif; ?>
        </div>

        <div class="campo">
            <label for="tipo">Tipo de constancia</label>
            <select id="tipo" name="tipo" required<?= isset($errores['tipo']) ? ' aria-invalid="true"' : '' ?>>
                <option value="">Elegí un tipo</option>
                <?php foreach ($tipos as $clave => $nombre): ?>
                    <option value="<?= e($clave) ?>"<?= $clave === $datos['tipo'] ? ' selected' : '' ?>><?= e($nombre) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['tipo'])): ?><p class="campo__error"><?= e($errores['tipo']) ?></p><?php endif; ?>
        </div>

        <div class="campo">
            <label for="ante">Para ser presentada ante (opcional)</label>
            <input id="ante" name="ante" maxlength="80" placeholder="quien corresponda"
                   value="<?= e($datos['ante']) ?>"<?= isset($errores['ante']) ? ' aria-invalid="true"' : '' ?>>
            <?php if (isset($errores['ante'])): ?><p class="campo__error"><?= e($errores['ante']) ?></p><?php endif; ?>
        </div>

        <button class="boton" type="submit">Generar constancia</button>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
