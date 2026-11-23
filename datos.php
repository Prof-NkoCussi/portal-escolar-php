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

// Especialidades: array de arrays de arrays (tres niveles)
// especialidad → sus datos → materias por año → lista de materias
$especialidades = [
    'basico' => [                                   // la clave sirve de id en la página
        'nombre'      => 'Ciclo Básico Técnico',
        'descripcion' => 'Formación común de 1° a 3° año, con talleres para conocer cada área.',
        'materias'    => [
            1 => ['Matemática', 'Lengua y Literatura', 'Taller de Tecnología'],   // año => materias
            2 => ['Matemática', 'Física', 'Taller de Electricidad'],
            3 => ['Matemática', 'Química', 'Taller de Informática'],
        ],
    ],
    'programacion' => [
        'nombre'      => 'Técnico en Programación',
        'descripcion' => 'Ciclo superior de 4° a 7° año: desarrollo de software, bases de datos y redes.',
        'materias'    => [
            4 => ['Programación I', 'Software I', 'Hardware I'],
            5 => ['Programación II', 'Base de Datos I', 'Redes I'],
            6 => ['Programación III', 'Base de Datos II', 'Redes II'],
            7 => ['Programación IV', 'Taller de Ingeniería', 'Práctica Profesionalizante'],
        ],
    ],
];

// Módulos del turno mañana (horas cátedra de 40 minutos)
$modulos = ['07:45 a 08:25', '08:25 a 09:05', '09:15 a 09:55', '09:55 a 10:35'];

// Horarios: curso → nombre y días → materias de cada módulo, en orden
// La clave ('4-1') es lo que viaja en la URL: horarios.php?curso=4-1
$horarios = [
    '4-1' => [
        'nombre' => '4° 1ª',
        'dias'   => [
            'Lunes'     => ['Programación I', 'Programación I', 'Matemática', 'Lengua'],
            'Martes'    => ['Software I', 'Software I', 'Inglés', 'Matemática'],
            'Miércoles' => ['Hardware I', 'Hardware I', 'Lengua', 'Educación Física'],
            'Jueves'    => ['Programación I', 'Matemática', 'Software I', 'Inglés'],
            'Viernes'   => ['Hardware I', 'Lengua', 'Programación I', 'Programación I'],
        ],
    ],
    '5-1' => [
        'nombre' => '5° 1ª',
        'dias'   => [
            'Lunes'     => ['Base de Datos I', 'Base de Datos I', 'Inglés', 'Matemática'],
            'Martes'    => ['Programación II', 'Programación II', 'Redes I', 'Redes I'],
            'Miércoles' => ['Matemática', 'Lengua', 'Base de Datos I', 'Inglés'],
            'Jueves'    => ['Redes I', 'Redes I', 'Programación II', 'Lengua'],
            'Viernes'   => ['Programación II', 'Matemática', 'Base de Datos I', 'Educación Física'],
        ],
    ],
    '7-1' => [
        'nombre' => '7° 1ª',
        'dias'   => [
            'Lunes'     => ['Programación IV', 'Programación IV', 'Inglés', 'Inglés'],
            'Martes'    => ['Taller de Ingeniería', 'Taller de Ingeniería', 'Matemática', 'Lengua'],
            'Miércoles' => ['Práctica Profesionalizante', 'Práctica Profesionalizante', 'Práctica Profesionalizante', 'Práctica Profesionalizante'],
            'Jueves'    => ['Programación IV', 'Taller de Ingeniería', 'Matemática', 'Lengua'],
            'Viernes'   => ['Programación IV', 'Programación IV', 'Taller de Ingeniería', 'Educación Física'],
        ],
    ],
];
