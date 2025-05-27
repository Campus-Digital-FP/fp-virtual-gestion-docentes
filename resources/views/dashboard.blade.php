<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('alta_docente_correcto'))
                <div class="alert-success">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('alta_docente_correcto') }}
                </div>
            @endif
            
            <div class="panel-container">
                <div class="panel-header">
                    <h3 class="alta-title">Panel de Gestión Docente</h3>
                    <p class="alta-subtitle">Bienvenido {{ Auth::user()->nombre }} aquí podrás gestionar tu actividad.</p>
                </div>

                <div class="panel-buttons">
                    <a href="{{ route('alta_docente') }}" class="panel-button">
                        <i class="fas fa-user-plus icon-alineado"></i>
                        Dar alta docente
                    </a>
                    <a href="{{ route('establecer_coordinador.index') }}" class="panel-button">
                        <i class="fas fa-user-tie icon-alineado"></i>
                        Establecer coordinador/es
                    </a>
                    <a href="{{ route('establecer_tutor.index') }}" class="panel-button">
                        <i class="fas fa-chalkboard-teacher icon-alineado"></i>
                        Establecer tutor/es
                    </a>
                    <a href="{{ route('establecer_docencia.index') }}" class="panel-button">
                        <i class="fas fa-book icon-alineado"></i>
                        Establecer docencia
                    </a>
                    <a href="{{ route('docentes.index') }}" class="panel-button">
                       <i class="fa-solid fa-trash icon-alineado"></i>
                       Baja Docente
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>