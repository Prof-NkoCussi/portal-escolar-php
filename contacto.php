<?php
// contacto.php — formulario de contacto con POST y validación del lado del servidor

require __DIR__ . '/funciones.php';

// Lista blanca de asuntos: lo que llega tiene que ser una de estas claves
$asuntos = [
    'inscripciones' => 'Inscripciones',
    'constancias'   => 'Constancias',
    'otro'          => 'Otro tema',
];

// Valores iniciales: el formulario arranca vacío y sin errores
$datos   = ['nombre' => '', 'email' => '', 'asunto' => '', 'mensaje' => ''];
$errores = [];          // campo => mensaje de error
$enviado = false;       // pasa a true cuando todo está bien

// ¿Llegó el formulario? La primera vez la página se pide con GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Leer y limpiar cada campo; ?? '' por si alguno no vino
    foreach ($datos as $campo => $vacio) {
        $datos[$campo] = limpiar($_POST[$campo] ?? '');
    }

    // 2) Validar: cada regla que no se cumple agrega un error con la clave del campo
    if ($datos['nombre'] === '') {
        $errores['nombre'] = 'Escribí tu nombre.';
    } elseif (mb_strlen($datos['nombre']) > 80) {
        $errores['nombre'] = 'El nombre es muy largo (máximo 80 letras).';
    }
    // filter_var revisa que tenga forma de email (algo@algo.algo)
    if (filter_var($datos['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errores['email'] = 'El email no es válido.';
    }
    if (!array_key_exists($datos['asunto'], $asuntos)) {
        $errores['asunto'] = 'Elegí un asunto de la lista.';
    }
    // mb_strlen cuenta letras: una ñ o una tilde cuentan 1, no 2
    if (mb_strlen($datos['mensaje']) < 10) {
        $errores['mensaje'] = 'El mensaje es muy corto (mínimo 10 letras).';
    } elseif (mb_strlen($datos['mensaje']) > 1000) {
        $errores['mensaje'] = 'El mensaje es muy largo (máximo 1000 letras).';
    }

    // 3) Si no se juntó ningún error, el mensaje se da por recibido
    $enviado = count($errores) === 0;
}

$titulo = 'Contacto';
require __DIR__ . '/includes/header.php';
?>
<h1>Contacto</h1>

<?php if ($enviado): ?>
    <!-- todo bien: se muestra lo recibido, siempre escapado con e() -->
    <section class="tarjeta">
        <p class="aviso aviso--ok">¡Gracias, <?= e($datos['nombre']) ?>! Recibimos tu mensaje.</p>
        <dl class="resumen">
            <dt>Asunto</dt>
            <dd><?= e($asuntos[$datos['asunto']]) ?></dd>
            <dt>Te respondemos a</dt>
            <dd><?= e($datos['email']) ?></dd>
            <dt>Mensaje</dt>
            <!-- nl2br pasa los Enter a <br>; va DESPUÉS de e() para que el <br> no se escape -->
            <dd><?= nl2br(e($datos['mensaje'])) ?></dd>
        </dl>
        <p><a href="contacto.php">Enviar otro mensaje</a></p>
    </section>
<?php else: ?>
    <?php if (count($errores) > 0): ?>
        <!-- hubo errores: se avisa arriba y en cada campo -->
        <p class="aviso aviso--error">Revisá <?= count($errores) ?> campo(s) marcado(s) en rojo.</p>
    <?php endif; ?>

    <!-- method="post": los datos viajan en el cuerpo del pedido, no en la URL -->
    <!-- required, type="email", minlength: ayudan en el navegador, pero NO reemplazan la validación de PHP -->
    <form class="tarjeta formulario" action="contacto.php" method="post">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <!-- value con e(): si hubo error, el dato vuelve escrito y no hay que tipearlo de nuevo -->
            <input id="nombre" name="nombre" type="text" maxlength="80" required
                   value="<?= e($datos['nombre']) ?>"<?= isset($errores['nombre']) ? ' aria-invalid="true"' : '' ?>>
            <?php if (isset($errores['nombre'])): ?>
                <p class="campo__error"><?= e($errores['nombre']) ?></p>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required
                   value="<?= e($datos['email']) ?>"<?= isset($errores['email']) ? ' aria-invalid="true"' : '' ?>>
            <?php if (isset($errores['email'])): ?>
                <p class="campo__error"><?= e($errores['email']) ?></p>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="asunto">Asunto</label>
            <select id="asunto" name="asunto" required<?= isset($errores['asunto']) ? ' aria-invalid="true"' : '' ?>>
                <option value="">Elegí un asunto</option>
                <?php foreach ($asuntos as $clave => $nombre): ?>
                    <option value="<?= e($clave) ?>"<?= $clave === $datos['asunto'] ? ' selected' : '' ?>><?= e($nombre) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['asunto'])): ?>
                <p class="campo__error"><?= e($errores['asunto']) ?></p>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="mensaje">Mensaje</label>
            <!-- el textarea no tiene value: el texto va entre las etiquetas -->
            <textarea id="mensaje" name="mensaje" rows="5" minlength="10" maxlength="1000" required<?= isset($errores['mensaje']) ? ' aria-invalid="true"' : '' ?>><?= e($datos['mensaje']) ?></textarea>
            <?php if (isset($errores['mensaje'])): ?>
                <p class="campo__error"><?= e($errores['mensaje']) ?></p>
            <?php endif; ?>
        </div>

        <button class="boton" type="submit">Enviar</button>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
