// js/imprimir.js — el único JavaScript del portal
// Busca el botón que tiene el atributo data-imprimir
const boton = document.querySelector('[data-imprimir]');
// Si está en esta página, al hacer clic abre el diálogo de impresión del navegador
if (boton) {
    boton.addEventListener('click', () => window.print());
}
