<x-guest-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <div class="w-full max-w-md space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <!-- Encabezado -->
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-bold text-gray-900 flex items-center justify-center">
                <i class="fas fa-right-to-bracket text-blue-500 text-2xl mr-2"></i>
                Acceso al Sistema
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Introduce tus credenciales para continuar
            </p>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Nombre de usuario -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1 items-center">
                    <i class="fas fa-user text-gray-500 mr-2"></i>
                    Nombre de usuario
                </label>
                <input id="nombre" name="nombre" type="text" required autofocus value="{{ old('nombre') }}"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nombre') bg-red-50 @enderror"
                       placeholder="Tu nombre de usuario">
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1  items-center">
                    <i class="fas fa-lock text-gray-500 mr-2"></i>
                    Contraseña
                </label>
                <input id="password" name="password" type="password" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password')  bg-red-50 @enderror"
                       placeholder="Tu contraseña">
                @error('password')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Recordar sesión y olvidé contraseña -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                        Recordar sesión
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500">
                        <i class="fas fa-question-circle mr-1"></i> ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <!-- Botón de acceso -->
            <div>
                <button type="submit"
                        class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Acceder
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
