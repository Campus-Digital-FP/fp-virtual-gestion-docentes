<x-app-layout>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
           <!-- Toast de notificación -->
            <div id="toast-notification" class="fixed top-10 left-1/2 transform -translate-x-1/2 z-50 border-l-4 text-gray-800 shadow-lg rounded p-4 flex items-start gap-4 max-w-md w-full hidden animate__animated">
                <i id="toast-icon" class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                <div>
                    <p id="toast-message" class="text-sm font-semibold"></p>
                </div>
            </div>

           

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            
        </div>
    </div>
    
     @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let msg = @json(session('status'));

                switch (msg) {
                    case 'profile-updated':
                        showToast('Correo electrónico actualizado correctamente.', 'success');
                        break;
                    case 'password-updated':
                        showToast('Contraseña actualizada correctamente.', 'success');
                        break;
                    case 'invalid-password':
                        showToast('La contraseña actual no es válida.', 'error');
                        break;
                    default:
                        showToast(msg, 'success'); // Mensaje por defecto si no está mapeado
                }
            });
        </script>
    @endif
        {{-- Errores globales (formulario principal) --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let errors = @json($errors->all());
                errors.forEach(msg => showToast(msg, 'error'));
            });
        </script>
    @endif

    {{-- Errores del formulario de contraseña --}}
    @if ($errors->updatePassword && $errors->updatePassword->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let errors = @json($errors->updatePassword->all());
                errors.forEach(msg => showToast(msg, 'error'));
            });
        </script>
    @endif

    {{-- Errores del formulario de eliminación de usuario --}}
    @if ($errors->userDeletion && $errors->userDeletion->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let errors = @json($errors->userDeletion->all());
                errors.forEach(msg => showToast(msg, 'error'));
            });
        </script>
    @endif



    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast-notification');
            const toastMessage = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');

            toastMessage.textContent = message;

            // Limpiar clases anteriores
            toast.classList.remove('border-green-500', 'border-red-500', 'bg-green-100', 'bg-red-100');

            if (type === 'success') {
                toast.classList.add('border-green-500', 'bg-green-100');
                toastIcon.className = 'fas fa-check-circle text-green-500 text-xl mt-1';
            } else if (type === 'error') {
                toast.classList.add('border-red-500', 'bg-red-100');
                toastIcon.className = 'fas fa-times-circle text-red-500 text-xl mt-1';
            }

            toast.classList.remove('hidden');
            toast.classList.add('animate__fadeInDown');

            // Ocultar después de 4 segundos
            setTimeout(() => {
                toast.classList.remove('animate__fadeInDown');
                toast.classList.add('animate__fadeOutUp');
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.classList.remove('animate__fadeOutUp');
                }, 300);
            }, 4000);
        }

    </script>

</x-app-layout>
