<button id="miBoton">Abrir modal</button>
<div id="miModal" style="display:none;">
  <h2>Este es mi modal</h2>
  <p>Aquí puedes agregar cualquier contenido que desees mostrar en el modal.</p>
</div>
<script>
  // Obtener el botón y el modal
  var boton = document.getElementById("miBoton");
  var modal = document.getElementById("miModal");

  // Cuando se hace clic en el botón, mostrar el modal
  boton.addEventListener("click", function() {
    modal.style.display = "block";
  });
</script>
