<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="panel-container">
                <h3 class="text-2xl font-bold text-center">Dar Alta Docente</h3>
                <p class="text-center">Complete el siguiente formulario para dar de alta a un docente.</p>

                <!-- Mostrar errores generales -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        <strong>Error:</strong>
                        <ul class="list-disc ml-6 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario para alta docente -->
                <form method="POST" action="{{ route('alta_docente.store') }}">
                    @csrf
                    <div class="mt-4">
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI:</label>
                        <input type="text" name="dni" id="dni" class="mt-1 block w-full @error('dni') border-red-500 @enderror" required>
                    </div>

                     <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full @error('email') border-red-500 @enderror"  required>
                    </div>

                    <div class="mt-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="mt-1 block w-full @error('nombre') border-red-500 @enderror" required>
                    </div>

                    <div class="mt-4">
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido:</label>
                        <input type="text" name="apellido" id="apellido" class="mt-1 block w-full @error('apellido') border-red-500 @enderror" required>
                    </div>
                    
                    <!-- Campo oculto para el id_centro -->
                    <input type="hidden" name="id_centro" value="{{ $centro->id_centro }}">

                    <div class="flex justify-center mt-4">
                        <button type="submit" class="border border-black text-black py-2 px-4 rounded-lg text-center transition-all duration-300 hover:scale-105 hover:opacity-90 hover:bg-gray-100">
                            Dar de Alta
                        </button>
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('dashboard') }}" class="border border-black text-black py-2 px-4 rounded-lg text-center transition-all duration-300 hover:scale-105 hover:opacity-90 hover:bg-gray-100">
                            Volver 
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dniInput = document.getElementById('dni');
            const nombreInput = document.getElementById('nombre');
            const apellidoInput = document.getElementById('apellido');

            // Asegurarse de que el DNI no tenga caracteres especiales
            dniInput.addEventListener('input', () => {
                let dni = dniInput.value;

                // Eliminar todo lo que no sea número o letra
                dni = dni.replace(/[^a-zA-Z0-9]/g, '');
                dniInput.value = dni;
            });

            //Completa los campos nombre y apellido si existe el dni 
            dniInput.addEventListener('blur', () => {
                const dni = dniInput.value.trim();

                if (dni === '') return;

                fetch(`/comprobar-docente/${dni}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.existe) {
                            nombreInput.value = data.nombre;
                            apellidoInput.value = data.apellido;

                            nombreInput.readOnly = true;
                            apellidoInput.readOnly = true;
                        } else {
                            nombreInput.value = '';
                            apellidoInput.value = '';

                            nombreInput.readOnly = false;
                            apellidoInput.readOnly = false;
                        }
                    })
                    .catch(error => console.error('Error en la petición AJAX:', error));
            });
        });
    </script>
</x-app-layout>
