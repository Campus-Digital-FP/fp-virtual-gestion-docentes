<section class="max-w-4xl mx-auto">
    <header class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800">
            {{ __('Actualizar Credenciales') }}
        </h2>

        <p class="mt-2 text-base text-gray-600">
            {{ __('Gestiona tu dirección de correo electrónico y contraseña para mantener tu cuenta segura.') }}
        </p>
    </header>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <!-- Sección para actualizar email -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-700 mb-4">{{ __('Cambiar Correo Electrónico') }}</h3>
            
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="email" :value="__('Nuevo Correo Electrónico')" />
                    <x-text-input 
                        id="email" 
                        name="email" 
                        type="email" 
                        class="mt-1 block w-full" 
                        :value="old('email', $user->email)" 
                        required 
                        autocomplete="email"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button class="px-4 py-2">
                        {{ __('Actualizar Email') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Sección para actualizar contraseña -->
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">{{ __('Cambiar Contraseña') }}</h3>
            
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" />
                    <x-text-input 
                        id="update_password_current_password" 
                        name="current_password" 
                        type="password" 
                        class="mt-1 block w-full" 
                        autocomplete="current-password" 
                    />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" />
                    <x-text-input 
                        id="update_password_password" 
                        name="password" 
                        type="password" 
                        class="mt-1 block w-full" 
                        autocomplete="new-password" 
                    />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input 
                        id="update_password_password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        class="mt-1 block w-full" 
                        autocomplete="new-password" 
                    />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex justify-end items-center gap-4">
                    <x-primary-button class="px-4 py-2">
                        {{ __('Actualizar Contraseña') }}
                    </x-primary-button>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-600"
                        >{{ __('Contraseña actualizada.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>