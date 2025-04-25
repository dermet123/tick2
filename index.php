<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio - Sistema de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-blue-200 min-h-screen flex items-center justify-center">

  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Sistema de Usuarios</h1>

    <button 
      onclick="cargarFormulario()" 
      class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
      Crear Usuario
    </button>

    <div id="contenedorFormulario" class="mt-8 text-left"></div>
  </div>

  <script>
    function cargarFormulario() {
  window.location.href = 'public';
}

  </script>

</body>
</html>
