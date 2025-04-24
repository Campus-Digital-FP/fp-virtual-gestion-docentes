
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @endpush

    

  
    <x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('alta_docente_correcto'))
                <div class="bg-green-500 text-black p-4 rounded-lg mb-4">
                    {{ session('alta_docente_correcto') }}
                </div>
            @endif
            <div class="panel-container">
                <h3 class="text-2xl font-bold text-center">Bienvenido al Panel de Usuario</h3>
                <p class="text-center">Aquí podrás gestionar tu actividad.</p>

                <div class="panel-buttons">
                    <a href="{{ route('alta_docente') }}" class="">Dar alta docente</a>
                    <a href="{{ route('establecer_coordinador.index') }}">Establecer coordinador/es</a>
                    <a href="{{ route('establecer_tutor.index') }}">Establecer tutor/es</a>
                    <a href="{{ route('dashboard') }}">Establecer docencia</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
