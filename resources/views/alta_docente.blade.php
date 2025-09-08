<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/altaDocente.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Toast Notification Container -->
            <div id="toast-notification" class="hidden fixed top-5 right-5 z-50">
                <div class="animate__animated animate__fadeInRight bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg max-w-xs">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p id="toast-message" class="text-sm font-medium"></p>
                        </div>
                        <button onclick="hideToast()" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8">
                            <span class="sr-only">Close</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

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
                            <i class="fas fa-envelope mr-1"></i> Correo Electrónico (NO USAR el de @fpvirtualaragon.es):
                        </label>
                        <input type="email" name="email" id="email" 
                            class="alta-input @error('email') alta-input-error @enderror" 
                            required placeholder="docente@ejemplo.com">
                    </div>

                    <div class="alta-form-group">
                        <label for="nombre" class="alta-label">
                            <i class="fas fa-user mr-1"></i> Nombre:
                        </label>
                        <div class="input-wrapper">
                            <input type="text" name="nombre" id="nombre" 
                                class="alta-input @error('nombre') alta-input-error @enderror" 
                                required placeholder="Nombre del docente">
                            <i id="toggle-nombre" class="fa-solid fa-lock toggle-icon" title="Editar" style="display: none;"></i>
                        </div>
                    </div>

                    <div class="alta-form-group">
                        <label for="apellido" class="alta-label">
                            <i class="fas fa-user-tag mr-1"></i> Apellido:
                        </label>
                        <div class="input-wrapper">
                            <input type="text" name="apellido" id="apellido" 
                                class="alta-input @error('apellido') alta-input-error @enderror" 
                                required placeholder="Apellido del docente">
                            <i id="toggle-apellido" class="fa-solid fa-lock toggle-icon" title="Editar" style="display: none;"></i>
                        </div>
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
            const toggleNombre = document.getElementById('toggle-nombre');
            const toggleApellido = document.getElementById('toggle-apellido');

            function setLockIcon(input, icon) {
                if (input.readOnly) {
                    icon.classList.remove('fa-unlock');
                    icon.classList.add('fa-lock');
                } else {
                    icon.classList.remove('fa-lock');
                    icon.classList.add('fa-unlock');
                }
            }

            function showToast(message) {
                const toast = document.getElementById('toast-notification');
                const toastMessage = document.getElementById('toast-message');
                
                toastMessage.textContent = message;
                toast.classList.remove('hidden');
                toast.classList.add('animate__fadeInRight');
                
                // Auto-hide after 5 seconds
                setTimeout(hideToast, 5000);
            }

            function hideToast() {
                const toast = document.getElementById('toast-notification');
                toast.classList.remove('animate__fadeInRight');
                toast.classList.add('animate__fadeOutRight');
                
                // Wait for animation to complete before hiding
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.classList.remove('animate__fadeOutRight');
                }, 300);
            }

            toggleNombre.addEventListener('click', () => {
                nombreInput.readOnly = !nombreInput.readOnly;
                setLockIcon(nombreInput, toggleNombre);
            });

            toggleApellido.addEventListener('click', () => {
                apellidoInput.readOnly = !apellidoInput.readOnly;
                setLockIcon(apellidoInput, toggleApellido);
            });

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
                            setLockIcon(nombreInput, toggleNombre);
                            setLockIcon(apellidoInput, toggleApellido);

                            toggleNombre.style.display = 'inline';
                            toggleApellido.style.display = 'inline';

                            // Mostrar notificación bonita en lugar de alert
                            showToast(`Datos autocompletados: ${data.nombre} ${data.apellido}`);
                        } else {
                            [nombreInput, apellidoInput].forEach(input => {
                                input.value = '';
                                input.readOnly = false;
                            });

                            toggleNombre.style.display = 'none';
                            toggleApellido.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        [nombreInput, apellidoInput].forEach(input => input.readOnly = false);
                        toggleNombre.style.display = 'none';
                        toggleApellido.style.display = 'none';
                    });
            });
        });
    </script>
</x-app-layout>