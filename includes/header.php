<?php
// includes/header.php — cabecera común: <head>, marca del colegio y menú
// Cada página lo trae con require, después de definir $titulo
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="utf-8">
    <!-- en el celular, que use el ancho real de la pantalla -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- $titulo lo definió la página que hizo el require -->
    <title><?= e($titulo) ?> · Portal C.T.P. "Olga B. de Arko"</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header class="cabecera">
    <div class="cabecera__marca">
        <!-- aria-hidden: la sigla es decoración, el nombre ya está al lado -->
        <span class="cabecera__sigla" aria-hidden="true">CTP</span>
        <div>
            <strong>C.T.P. "Olga B. de Arko"</strong>
            <span>Ushuaia · Tierra del Fuego</span>
        </div>
    </div>
    <!-- es_actual() agrega aria-current="page" al enlace de la página abierta -->
    <nav class="menu" aria-label="Menú principal">
        <a href="index.php"<?= es_actual('index.php') ?>>Inicio</a>
        <a href="especialidades.php"<?= es_actual('especialidades.php') ?>>Especialidades</a>
        <a href="horarios.php"<?= es_actual('horarios.php') ?>>Horarios</a>
        <a href="contacto.php"<?= es_actual('contacto.php') ?>>Contacto</a>
        <a href="constancias.php"<?= es_actual('constancias.php') ?>>Secretaría</a>
    </nav>
</header>
<main class="contenido">
