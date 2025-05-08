<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/altaDocente.css') }}">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="alta-panel">
                <h3 class="alta-title">Dar Alta Docente</h3>
                <p class="alta-subtitle">Complete el siguiente formulario para dar de alta a un docente en el sistema.</p>

                @if ($errors->any())
                    <div class="alta-alert alta-alert-error">
                        <div class="alta-alert-content">
                            <p class="alta-alert-message">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <strong>ERROR:</strong>
                            </p>
                            <ul class="alta-error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('alta_docente.store') }}" class="alta-form">
                    @csrf
                    
                    <div class="alta-form-group">
                        <label for="dni" class="alta-label">
                            <i class="fas fa-id-card mr-1"></i> DNI:
                        </label>
                        <input type="text" name="dni" id="dni" 
                            class="alta-input @error('dni') alta-input-error @enderror" 
                            required placeholder="Ej: 12345678A">
                    </div>

                    <div class="alta-form-group">
                        <label for="email" class="alta-label">
                            <i class="fas fa-envelope mr-1"></i> Correo Electrónico:
                        </label>
                        <input type="email" name="email" id="email" 
                            class="alta-input @error('email') alta-input-error @enderror" 
                            required placeholder="docente@ejemplo.com">
                    </div>

                    <div class="alta-form-group">
                        <label for="nombre" class="alta-label">
                            <i class="fas fa-user mr-1"></i> Nombre:
                        </label>
                        <input type="text" name="nombre" id="nombre" 
                            class="alta-input @error('nombre') alta-input-error @enderror" 
                            required placeholder="Nombre del docente">
                    </div>

                    <div class="alta-form-group">
                        <label for="apellido" class="alta-label">
                            <i class="fas fa-user-tag mr-1"></i> Apellido:
                        </label>
                        <input type="text" name="apellido" id="apellido" 
                            class="alta-input @error('apellido') alta-input-error @enderror" 
                            required placeholder="Apellido del docente">
                    </div>
                    
                    <input type="hidden" name="id_centro" value="{{ $centro->id_centro }}">

                    <div class="alta-form-actions">
                        <a href="{{ route('dashboard') }}" class="alta-button alta-button-secondary">
                            <i class="fas fa-arrow-left mr-2"></i> Volver al panel
                        </a>
                        <button type="submit" class="alta-button alta-button-primary">
                            <i class="fas fa-user-plus mr-2"></i> Guardar docente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Script para autocompletar los campos nombre y apellido -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dniInput = document.getElementById('dni');
            const nombreInput = document.getElementById('nombre');
            const apellidoInput = document.getElementById('apellido');

            // Autocompletar
            dniInput.addEventListener('blur', () => {
                const dni = dniInput.value.trim();
                if (!dni) return;

                fetch(`/comprobar-docente/${dni}`)
                    .then(response => response.ok ? response.json() : Promise.reject())
                    .then(data => {
                        if (data.existe) {
                            nombreInput.value = data.nombre;
                            apellidoInput.value = data.apellido;
                            nombreInput.readOnly = true;
                            apellidoInput.readOnly = true;
                            if (data.nombre && data.apellido) {
                                alert(`Datos autocompletados: ${data.nombre} ${data.apellido}`);
                            }
                        } else {
                            [nombreInput, apellidoInput].forEach(input => {
                                input.value = '';
                                input.readOnly = false;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        [nombreInput, apellidoInput].forEach(input => input.readOnly = false);
                    });
            });
        });
    </script>
</x-app-layout>