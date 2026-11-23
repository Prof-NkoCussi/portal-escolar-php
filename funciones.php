<?php
// funciones.php — funciones que usan todas las páginas del portal

// PHP no toma la zona horaria de Linux: se la decimos acá, una sola vez
date_default_timezone_set('America/Argentina/Ushuaia');

// e() = "escapar": todo lo que se muestra en la página pasa por acá
// htmlspecialchars convierte < > & " ' en texto, así nadie mete HTML (XSS)
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// limpiar(): prepara un dato que llegó de un formulario
function limpiar(mixed $valor): string
{
    // si no es texto (alguien mandó algo raro, como un array), devuelve vacío
    if (!is_string($valor)) {
        return '';
    }
    // trim saca los espacios del principio y del final
    return trim($valor);
}

// validar_dni(): true si son 7 u 8 dígitos y nada más
function validar_dni(string $dni): bool
{
    // ^ inicio, \d dígito, {7,8} cuántos, $ fin
    return preg_match('/^\d{7,8}$/', $dni) === 1;
}

// fecha_larga(): la fecha de hoy en castellano, por ejemplo "23 de noviembre de 2026"
function fecha_larga(): string
{
    // la clave arranca en 1; las siguientes suben solas (2, 3…)
    $meses = [1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
              'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
    // date('j') = día sin cero · date('n') = mes sin cero · (int) lo pasa a número
    return date('j') . ' de ' . $meses[(int) date('n')] . ' de ' . date('Y');
}

// fecha_corta(): pasa '2026-11-27' (formato de MySQL) a '27/11/2026'
function fecha_corta(string $iso): string
{
    // strtotime() convierte el texto en un timestamp (segundos desde 1970)
    // y date() le da formato a ese momento, en vez de usar "ahora"
    return date('d/m/Y', strtotime($iso));
}

// es_actual(): marca en el menú la página que se está viendo
function es_actual(string $archivo): string
{
    // SCRIPT_NAME es '/portal/index.php'; basename() deja solo 'index.php'
    // si coincide, devuelve el atributo que usan el CSS y los lectores de pantalla
    return basename($_SERVER['SCRIPT_NAME']) === $archivo ? ' aria-current="page"' : '';
}

// siguiente_numero(): da el próximo número de constancia y lo deja guardado
// Devuelve 0 si no pudo guardar (por ejemplo, Apache sin permiso en almacen/)
function siguiente_numero(string $archivo): int
{
    // si el archivo existe, se lee el último número; si no, se arranca de 0
    $ultimo = is_file($archivo) ? (int) file_get_contents($archivo) : 0;
    $nuevo = $ultimo + 1;
    // LOCK_EX: nadie más escribe el archivo mientras guardamos
    if (file_put_contents($archivo, (string) $nuevo, LOCK_EX) === false) {
        return 0;
    }
    return $nuevo;
}
