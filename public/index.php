<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Formulario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-4">

  <!-- Contenedor principal -->
  <div class="max-w-7xl mx-auto space-y-8">

    <!-- Fila con formulario y lista de usuarios -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

      <!-- Formulario de creación de usuario -->
      <div class="bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Formulario de usuario</h2>
        <form id="userForm">
          <label class="block text-sm font-medium text-gray-700">Email:</label>
          <input type="email" name="email" required class="w-full border p-2 rounded mb-2">

          <label class="block text-sm font-medium text-gray-700">Nombre:</label>
          <input type="text" name="name" required class="w-full border p-2 rounded mb-2">

          <label class="block text-sm font-medium text-gray-700">Teléfono:</label>
          <input type="text" name="phone" class="w-full border p-2 rounded mb-2">

          <label class="block text-sm font-medium text-gray-700">Lenguaje:</label>
          <input type="text" name="language" class="w-full border p-2 rounded mb-4">

          <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>




          <div class="max-w-md mx-auto mt-5 p-3 bg-white rounded-2xl shadow-md">
            <label for="userSelect" class="block text-sm font-medium text-gray-700 mb-2">
              Selecciona un usuario:
            </label>

            <select id="userSelect" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
              <option value="">Ninguno</option>
            </select>

            
            <div class="mb-4">
              <label for="clientName" class="block text-sm font-medium text-gray-700 mb-1">
                Nombre del Cliente:
              </label>
              <input type="text" id="clientName" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ingrese el nombre del cliente" required>
            </div>

            <button onclick="generarReporte()"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 mb-2">
              Generar PDF
            </button>

            <button onclick="guardarPDF()"
              class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200">
              Guardar PDF
            </button>

          </div>


        </form>


        <div id="response" class="mt-4 text-green-600">




        </div>
      </div>

      <!-- Lista de usuarios -->
      <div class="bg-white p-6 shadow-lg rounded-lg">
        <h3 class="text-lg font-bold mb-4">Lista de usuarios:</h3>
        <ul id="userList" class="space-y-4">
          <!-- Lista dinámica de usuarios se mostrará aquí -->
        </ul>
      </div>

    </div>

  </div>

  <!-- MODAL para Editar -->
  <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded w-full max-w-md shadow-lg">
      <h2 class="text-xl font-bold mb-4">Editar Usuario</h2>
      <form id="editForm">
        <input type="hidden" name="id" id="editId">

        <label>Email:</label>
        <input type="email" name="email" id="editEmail" class="w-full p-2 border rounded mb-2" required>

        <label>Nombre:</label>
        <input type="text" name="name" id="editName" class="w-full p-2 border rounded mb-2" required>

        <label>Teléfono:</label>
        <input type="text" name="phone" id="editPhone" class="w-full p-2 border rounded mb-2">

        <label>Lenguaje:</label>
        <input type="text" name="language" id="editLanguage" class="w-full p-2 border rounded mb-4">

        <div class="flex justify-between">
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Actualizar</button>
          <button type="button" onclick="closeModal()" class="text-red-600 hover:underline">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <script src="script.js"></script>
</body>

</html>