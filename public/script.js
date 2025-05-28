document.getElementById('userForm').addEventListener('submit', async function (e) {
    e.preventDefault();
  
    const formData = new FormData(this);
  
    const response = await fetch('../api/users.php', {
      method: 'POST',
      body: formData
    });
  
    const result = await response.text();
    document.getElementById('response').textContent = result;
  
    // Limpia el formulario
    this.reset();
  
    // Cargar usuarios
    loadUsers();
  });
  
  async function loadUsers() {
    const res = await fetch('../api/list.php');
    const users = await res.json();
    const list = document.getElementById('userList');
    list.innerHTML = '';
  
    users.forEach(user => {
      list.innerHTML += `<li><strong>${user.name}</strong> (${user.email}) - ${user.phone} - ${user.language}</li>`;
    });
  }
  
  // Carga usuarios al inicio
  loadUsers();
  

// Cargar lista con botones de editar y eliminar
async function loadUsers() {
    const res = await fetch('../api/list.php');
    const users = await res.json();
    const list = document.getElementById('userList');
    list.innerHTML = '';
  
    users.forEach(user => {
      list.innerHTML += `
        <li class="bg-gray-100 p-3 rounded flex justify-between items-center">
          <div>
            <strong>${user.name}</strong> (${user.email})<br>
            ${user.phone} - ${user.language}
          </div>
          <div class="space-x-2">
            <button onclick="openEdit(${user.id}, '${user.email}', '${user.name}', '${user.phone}', '${user.language}')" class="text-blue-600 hover:underline">Editar</button>
            <button onclick="deleteUser(${user.id})" class="text-red-600 hover:underline">Eliminar</button>
          </div>
        </li>
      `;
    });
  }
  
  // Mostrar modal con datos del usuario
  function openEdit(id, email, name, phone, language) {
    document.getElementById('editId').value = id;
    document.getElementById('editEmail').value = email;
    document.getElementById('editName').value = name;
    document.getElementById('editPhone').value = phone;
    document.getElementById('editLanguage').value = language;
  
    document.getElementById('editModal').classList.remove('hidden');
  }
  
  // Cerrar modal
  function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
  }
  
  // Submit del formulario de edición
  document.getElementById('editForm').addEventListener('submit', async function (e) {
    e.preventDefault();
  
    const formData = new FormData(this);
  
    const res = await fetch('../api/edit.php', {
      method: 'POST',
      body: formData
    });
  
    const msg = await res.text();
    document.getElementById('response').textContent = msg;
    closeModal();
    loadUsers();
  });
  
  // Eliminar usuario
  async function deleteUser(id) {
    if (!confirm('¿Deseas eliminar este usuario?')) return;
  
    const res = await fetch(`../api/delete.php?id=${id}`);
    const msg = await res.text();
    document.getElementById('response').textContent = msg;
    loadUsers();
  }

  function renderUserList(users) {
    const userList = document.getElementById("userList");
    userList.innerHTML = "";
    users.forEach(user => {
      const li = document.createElement("li");
      li.className = "border rounded p-3 flex justify-between items-center";
  
      li.innerHTML = `
        <div>
          <p><strong>${user.name}</strong> (${user.email})</p>
          <p><small>Tel: ${user.phone} | Lenguaje: ${user.language}</small></p>
        </div>
        <div class="space-x-2">
          <button onclick="editUser(${user.id})" class="bg-yellow-400 text-white px-2 py-1 rounded">Editar</button>
          <button onclick="deleteUser(${user.id})" class="bg-red-600 text-white px-2 py-1 rounded">Eliminar</button>
          <button onclick="generarReporte(${user.id})" class="bg-green-600 text-white px-2 py-1 rounded">Generar Reporte</button>
        </div>
      `;
      userList.appendChild(li);
    });
  }

  

    document.addEventListener('DOMContentLoaded', function () {
      fetch('../api/list.php') // tu archivo PHP que devuelve los usuarios en JSON
        .then(response => response.json())
        .then(data => {
          const select = document.getElementById('userSelect');
          data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name; // o user.name si ese es el campo correcto
            select.appendChild(option);
          });
        });
    });

    function generarReporte() {
      const userId = document.getElementById('userSelect').value;
      const clientName = document.getElementById('clientName').value;
      
      console.log('ID de usuario:', userId);
      console.log('Nombre del cliente:', clientName);
      
      if (userId && clientName) {
        const url = `../generatePDF.php?id=${userId}&client_name=${encodeURIComponent(clientName)}`;
        console.log('URL generada:', url);
        window.open(url, '_blank');
      } else {
        alert("Por favor completa todos los campos requeridos");
      }
    }

    function guardarPDF() {
      const userId = document.getElementById('userSelect').value;
      const clientSelect = document.getElementById('clientSelect');
      const clientName = clientSelect.value;
  
      if (userId && clientName) {
        window.location.href = `../guardar_pdf.php?id=${userId}&client_name=${encodeURIComponent(clientName)}&action=save`;
      } else {
        alert("Por favor selecciona un usuario y un cliente");
      }
    }
  

