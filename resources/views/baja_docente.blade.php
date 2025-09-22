<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/establecerCoordinadorTutorDocencia.css') }}">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="panel">
                <h3 class="title">Dar de baja a docentes</h3>
                <p class="subtitle">Busca un docente y confirma su baja del centro.</p>

                @php
                    function rolesConY($roles) {
                        $count = count($roles);
                        if ($count === 0) return '';
                        if ($count === 1) return $roles[0];
                        return implode(', ', array_slice($roles, 0, -1)) . ' y ' . $roles[$count - 1];
                    }
                @endphp
                
                @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-error">
                            <strong><i class="fas fa-exclamation-circle mr-2"></i>Error:</strong>
                            <ul class="error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                <!-- Buscador y Tabla -->
                <div class="table-container"
                    x-data="{ search: '', count: {{ count($docentes) }},
                        async updateCount() {
                            await this.$nextTick();
                            this.count = Array.from(this.$refs.tableBody.querySelectorAll('tr')).filter(tr => tr.style.display !== 'none').length;
                        }
                    }"
                    x-init="updateCount(); $watch('search', () => updateCount())"
                    x-ref="tableContainer"
                >
                    <div class="search-container">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input x-model="search" type="text" placeholder="Buscar docentes..." class="search-input" @keyup.escape="search = ''" />
                            <button x-show="search.length > 0" @click="search = ''" class="search-clear">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div x-show="search.length > 0" class="search-count">
                            Mostrando <span x-text="count"></span> de {{ count($docentes) }} docentes
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user mr-1"></i> Nombre</th>
                                <th><i class="fas fa-user-tag mr-1"></i> Apellido</th>
                                <th><i class="fas fa-id-card mr-1"></i> DNI</th>
                                <th><i class="fas fa-cog mr-1"></i> Acción</th>
                            </tr>
                        </thead>
                        <tbody x-ref="tableBody">
                            @forelse($docentes as $docente)
                                <tr x-data="{ showModal: false }"
                                    x-show="'{{ strtolower($docente->nombre . ' ' . $docente->apellido . ' ' . $docente->dni) }}'.includes(search.toLowerCase())">
                                    <td>{{ $docente->nombre }}</td>
                                    <td>{{ $docente->apellido }}</td>
                                    <td class="uppercase">{{ $docente->dni }}</td>
                                    <td>
                                        @if($docente->de_baja)
                                        <button class="button-tiny button-warning" disabled title="El docente ya está de baja">
                                            De baja
                                        </button>
                                        @else
                                        <button @click="showModal = true"  class="button-tiny button-danger">
                                            <i class="fas fa-trash-alt mr-1"></i>
                                        </button>
                                        @endif

                                        <!-- Modal -->
                                        <div x-show="showModal" class="modal">
                                            <div class="modal-content">
                                                <h2 class="modal-title">
                                                    <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>
                                                    Confirmar baja
                                                </h2>
                                                <p class="modal-text">
                                                    @php
                                                        $roles = [];
                                                        if ($docente->es_tutor) $roles[] = 'Tutor';
                                                        if ($docente->es_coordinador) $roles[] = 'Coordinador';
                                                        if ($docente->tiene_docencia) $roles[] = 'Docente';
                                                    @endphp

                                                    El docente <b>{{ $docente->nombre }} {{ $docente->apellido }}</b> (DNI: <b class="uppercase">{{ $docente->dni }}</b>)
                                                    @if(count($roles) > 0)
                                                        es actualmente <b>{{ rolesConY($roles) }}</b> en este centro.
                                                        <br><br>¿Estás seguro de que deseas darlo de baja? Esta acción eliminará todas sus asignaciones.
                                                    @else
                                                        no tiene roles activos asignados.
                                                        <br><br>¿Estás seguro de que deseas darlo de baja?
                                                    @endif

                                                    
                                                </p>

                                                <div class="modal-actions">
                                                    <button @click="showModal = false" class="button button-secondary">
                                                        <i class="fas fa-times mr-1"></i> Cancelar
                                                    </button>
                                                    <form method="POST" action="{{ route('docentes.destroy', $docente->dni) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="button button-danger">
                                                            <i class="fas fa-trash-alt mr-1"></i> Sí, dar de baja
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="table-empty">
                                        <i class="fas fa-info-circle mr-2"></i> No hay docentes registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Botón Volver -->
                <div class="back-button mt-4">
                    <a href="{{ route('dashboard') }}" class="button button-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al panel
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
