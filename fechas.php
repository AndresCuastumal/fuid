<!DOCTYPE html>
<html>
<head>
  <title>Limitar fecha final</title>
  <script>
    function limitarFechaFinal() {
      var fechaInicial = document.getElementById("fechaInicial").value;
      var fechaFinalInput = document.getElementById("fechaFinal");
      
      fechaFinalInput.min = fechaInicial;
      fechaFinalInput.value = fechaInicial; // Establecer el valor predeterminado
      
      fechaFinalInput.disabled = false; // Habilitar el campo
      
      // Opcional: deshabilitar fechas anteriores en el calendario
      var fechaMinima = new Date(fechaInicial);
      fechaMinima.setDate(fechaMinima.getDate() + 1); // Siguiente día
      
      var minYear = fechaMinima.getFullYear();
      var minMonth = String(fechaMinima.getMonth() + 1).padStart(2, "0");
      var minDay = String(fechaMinima.getDate()).padStart(2, "0");
      
      fechaFinalInput.setAttribute("min", minYear + "-" + minMonth + "-" + minDay);
    }
  </script>
</head>
<body>
  <h1>Seleccionar fechas</h1>
  <label for="fechaInicial">Fecha inicial:</label>
  <input type="date" id="fechaInicial" onchange="limitarFechaFinal()">
  <br>
  <label for="fechaFinal">Fecha final:</label>
  <input type="date" id="fechaFinal" disabled>
</body>
</html>
