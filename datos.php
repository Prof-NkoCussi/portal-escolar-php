<?php
// datos.php — datos de ejemplo del portal (todos ficticios)
// Hasta que haya base de datos, la información vive en arrays

// Novedades: un array de arrays; cada novedad es una "ficha" con 4 campos
// Van de la más nueva a la más vieja: el foreach las muestra en este orden
$novedades = [
    [
        'fecha'     => '2026-11-27',          // año-mes-día, el formato de MySQL
        'categoria' => 'Institucional',
        'titulo'    => 'Muestra anual de proyectos',
        'texto'     => 'Los cursos de 7° año presentan sus proyectos integradores en el SUM, de 9 a 12 h.',
    ],
    [
        'fecha'     => '2026-11-20',
        'categoria' => 'Inscripciones',
        'titulo'    => 'Inscripción 2027',
        'texto'     => 'Abierta en Secretaría de lunes a viernes, de 8 a 13 h. Traer DNI del estudiante.',
    ],
    [
        'fecha'     => '2026-11-16',
        'categoria' => 'Talleres',
        'titulo'    => 'Taller de cableado estructurado',
        'texto'     => 'Para 4° año de Programación: armado y prueba de cables de red en el laboratorio.',
    ],
    [
        'fecha'     => '2026-11-10',
        'categoria' => 'Exámenes',
        'titulo'    => 'Mesas de diciembre',
        'texto'     => 'El cronograma de mesas de examen ya está publicado en la cartelera de cada curso.',
    ],
];
