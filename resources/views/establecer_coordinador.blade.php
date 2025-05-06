<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/establecerCoordinador.css') }}">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="coordinador-panel">
                <h3 class="coordinador-title">Establecer Coordinador/es</h3>
                <p class="coordinador-subtitle">Complete el siguiente formulario para establecer o borrar un coordinador.</p>

                <!-- Formulario -->
                <form method="POST" action="{{ route('establecer_coordinador.store') }}" class="coordinador-form">
                    @if(session('success'))
                        <div class="coordinador-alert coordinador-alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="coordinador-alert coordinador-alert-error">
                            <strong><i class="fas fa-exclamation-circle mr-2"></i>Error:</strong>
                            <ul class="coordinador-error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @csrf

                    <div class="coordinador-form-group">
                        <label for="id_ciclo" class="coordinador-label">
                            <i class="fas fa-graduation-cap mr-1"></i> Seleccionar Ciclo:
                        </label>
                        <select name="id_ciclo" id="id_ciclo" required class="coordinador-select @error('id_ciclo') coordinador-input-error @enderror">
                            <option value="">-- Selecciona un ciclo --</option>
                            @foreach ($ciclos as $ciclo)
                                <option value="{{ $ciclo->id_ciclo }}">{{ $ciclo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="coordinador-form-group">
                        <label for="dni" class="coordinador-label">
                            <i class="fas fa-user-tie mr-1"></i> Seleccionar Coordinador:
                        </label>
                        <select name="dni" id="dni" required class="coordinador-select @error('dni') coordinador-input-error @enderror">
                            <option value="">-- Selecciona un docente --</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->dni }}">{{ $docente->nombre }} {{ $docente->apellido }} - {{ $docente->dni }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="coordinador-checkbox-group">
                        <input type="hidden" name="es_tutor" value="0">
                        <input type="checkbox" name="es_tutor" id="es_tutor" value="1" class="coordinador-checkbox">
                        <label for="es_tutor" class="coordinador-checkbox-label">
                            <i class="fas fa-chalkboard-teacher mr-1"></i> También es tutor
                        </label>
                    </div>

                    <div class="coordinador-form-actions">
                        <button type="submit" class="coordinador-button coordinador-button-primary">
                            <i class="fas fa-user-plus mr-2"></i> Establecer
                        </button>
                    </div>
                </form>

                <!-- Tabla de coordinadores actuales -->
                <h4 class="coordinador-table-title">
                    <i class="fas fa-list-ol mr-2"></i> Listado de Coordinadores Actuales
                </h4>

                <div class="coordinador-table-container" 
                    x-data="{ 
                        search: '', 
                        count: {{ count($coordinadores) }},
                        async updateCount() {
                            await this.$nextTick(); 
                            this.count = Array.from(this.$refs.tableBody.querySelectorAll('tr')).filter(tr => {
                                return tr.style.display !== 'none';
                            }).length;
                        }
                    }"
                    x-init="updateCount(); $watch('search', () => updateCount())"
                    x-ref="tableContainer"
                >
                    <!-- Buscador Mejorado -->
                    <div class="coordinador-search-container">
                        <div class="coordinador-search-box">
                            <i class="fas fa-search coordinador-search-icon"></i>
                            <input
                                x-model="search"
                                type="text"
                                placeholder="Buscar coordinadores..."
                                class="coordinador-search-input"
                                @keyup.escape="search = ''"
                            />
                            <button 
                                x-show="search.length > 0"
                                @click="search = ''"
                                class="coordinador-search-clear"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div x-show="search.length > 0" class="coordinador-search-count">
                            Mostrando <span x-text="count"></span> de {{ count($coordinadores) }} coordinadores
                        </div>

                    </div>

                    <table class="coordinador-table">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ route('establecer_coordinador.index', ['sort' => 'nombre']) }}">
                                        <i class="fas fa-user mr-1"></i> Nombre
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('establecer_coordinador.index', ['sort' => 'apellido']) }}">
                                        <i class="fas fa-user-tag mr-1"></i> Apellidos
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('establecer_coordinador.index', ['sort' => 'ciclo']) }}">
                                        <i class="fas fa-graduation-cap mr-1"></i> Ciclo
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('establecer_coordinador.index', ['sort' => 'dni']) }}">
                                        <i class="fas fa-id-card mr-1"></i> DNI
                                    </a>
                                </th>
                                <th><i class="fas fa-cog mr-1"></i> Acción</th>
                            </tr>
                        </thead>
                        <tbody x-ref="tableBody">
                            @forelse($coordinadores as $coordinador)
                                <tr x-data="{ showModal: false }"
                                x-show="
                                (
                                    '{{ strtolower($coordinador->docente->nombre . ' ' . $coordinador->docente->apellido . ' ' . $coordinador->ciclo->nombre . ' ' . $coordinador->dni) }}'
                                ).includes(search.toLowerCase())
                                ">
                                    <td>{{ $coordinador->docente->nombre ?? 'No encontrado' }}</td>
                                    <td>{{ $coordinador->docente->apellido ?? 'No encontrado' }}</td>
                                    <td>{{ $coordinador->ciclo->nombre }}</td>
                                    <td class="uppercase">{{ $coordinador->dni }}</td>
                                    <td>
                                        <button @click="showModal = true" class="coordinador-button-tiny coordinador-button-danger">
                                            <i class="fas fa-trash-alt mr-1"></i> Borrar
                                        </button>

                                        <!-- Modal -->
                                        <div x-show="showModal" class="coordinador-modal">
                                            <div class="coordinador-modal-content">
                                                <h2 class="coordinador-modal-title">
                                                    <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>
                                                    Confirmar eliminación
                                                </h2>
                                                <p class="coordinador-modal-text">
                                                    ¿Estás seguro de que quieres borrar a
                                                    <b>{{ $coordinador->docente->nombre }} {{ $coordinador->docente->apellido }}</b>
                                                    del ciclo <b>{{ $coordinador->ciclo->nombre }}</b>?
                                                </p>
                                                <div class="coordinador-modal-actions">
                                                    <button @click="showModal = false" class="coordinador-button coordinador-button-secondary">
                                                        <i class="fas fa-times mr-1"></i> Cancelar
                                                    </button>
                                                    <form method="POST" action="{{ route('establecer_coordinador.destroy', $coordinador->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="coordinador-button coordinador-button-danger">
                                                            <i class="fas fa-check mr-1"></i> Sí, borrar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="coordinador-table-empty">
                                        <i class="fas fa-info-circle mr-2"></i> No hay coordinadores registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Botón Volver -->
                <div class="coordinador-back-button">
                    <a href="{{ route('dashboard') }}" class="coordinador-button coordinador-button-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al panel
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
