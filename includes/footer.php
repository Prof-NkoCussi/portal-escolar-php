<?php
// includes/footer.php — cierre común: pie y fin del HTML
// Cierra el <main> que abrió header.php
?>
</main>
<footer class="pie">
    <p>C.T.P. "Olga B. de Arko" · Ushuaia</p>
    <!-- date('Y') pone el año solo: no hay que cambiarlo cada enero -->
    <p>Proyecto de práctica · <?= date('Y') ?></p>
</footer>
<!-- el botón Imprimir de Secretaría; en las otras páginas no hace nada -->
<script src="js/imprimir.js"></script>
</body>
</html>
