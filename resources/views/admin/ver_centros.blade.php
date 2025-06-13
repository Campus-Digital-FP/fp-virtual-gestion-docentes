@extends('layouts.app-admin')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/establecerCoordinadorTutorDocencia.css') }}">
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('centroModal', () => ({
                showModal: false,
                centroInfo: {},
                isLoading: false,
                error: null,
                loadCentroInfo(centroId, cicloId = null) {
                    this.isLoading = true;
                    this.error = null;
                    let url = `/admin/centros/${centroId}/info`;
                    if (cicloId) {
                        url += `?ciclo=${cicloId}`;
                    }
                    
                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
                        const contentType = response.headers.get("content-type");
                        if (!contentType.includes("application/json")) throw new Error("Respuesta no JSON.");
                        return response.json();
                    })
                    .then(data => {
                        this.centroInfo = data;
                        this.showModal = true;
                    })
                    .catch(error => {
                        console.error('Error al cargar la información del centro:', error);
                        this.error = error.message;
                        alert("No se pudo cargar la información del centro.");
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
                }
            }));
        });
    </script>
    @endpush

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="panel">
                <h3 class="title">Gestión de Centros</h3>
                <p class="subtitle">Listado completo de centros y ciclos registrados en el sistema.</p>
                <div class="text-right mb-4">
                    <a href="{{ route('admin.docentes.export.csv') }}" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-file-csv mr-2"></i>
                        Exportar centros a CSV
                    </a>
                </div>
                <!-- Tabla de centros -->
                <div class="table-container" 
                    x-data="{ 
                        search: '', 
                        count: {{ $centrosCiclos ? count($centrosCiclos) : 0 }},
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
                    <!-- Buscador -->
                    <div class="search-container">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input
                                x-model="search"
                                type="text"
                                placeholder="Buscar centros o ciclos..."
                                class="search-input"
                                @keyup.escape="search = ''"
                            />
                            <button 
                                x-show="search.length > 0"
                                @click="search = ''"
                                class="search-clear"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div x-show="search.length > 0" class="search-count">
                            Mostrando <span x-text="count"></span> de {{ count($centrosCiclos) }} registros
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ route('admin.centros', ['sort' => 'id_centro']) }}">
                                        <i class="fas fa-id-card-alt mr-1"></i> Código Centro
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('admin.centros', ['sort' => 'nombre']) }}">
                                        <i class="fas fa-school mr-1"></i> Centro
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('admin.centros', ['sort' => 'ciclo']) }}">
                                        <i class="fas fa-graduation-cap mr-1"></i> Ciclo
                                    </a>
                                </th>
                                <th>
                                    <i class="fas fa-info-circle mr-1"></i> Más Info
                                </th>
                            </tr>
                        </thead>
                        <tbody x-ref="tableBody">
                            @forelse($centrosCiclos as $centroCiclo)
                                <tr x-show="
                                (
                                    '{{ strtolower($centroCiclo->id_centro . ' ' . $centroCiclo->nombre_centro . ' ' . $centroCiclo->nombre_ciclo) }}'
                                ).includes(search.toLowerCase())
                                ">
                                    <td>{{ $centroCiclo->id_centro }}</td>
                                    <td>{{ $centroCiclo->nombre_centro }}</td>
                                    <td>{{ $centroCiclo->nombre_ciclo }}</td>
                                    <td>
                                        <button 
                                            @click="$dispatch('open-modal', { centroId: '{{ $centroCiclo->id_centro }}', cicloId: '{{ $centroCiclo->id_ciclo }}' })" 
                                            class="button-tiny button-primary"
                                        >
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="table-empty">
                                        <i class="fas fa-info-circle mr-2"></i> No hay centros registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modal de información del centro -->
                <div x-data="{
                    centroInfo: {},
                    showModal: false,
                    isLoading: false,
                    errorMessage: '',
                    loadCentroInfo(centroId, cicloId) {
                        this.showModal = true;
                        this.isLoading = true;
                        this.errorMessage = '';
                        
                        fetch(`/admin/centros/${centroId}/info?ciclo=${cicloId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            }
                        })
                        .then(async response => {
                            if (!response.ok) {
                                const errorData = await response.json().catch(() => ({}));
                                throw new Error(errorData.message || 'Error al cargar los datos');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) throw new Error(data.error);
                            this.centroInfo = data;
                            this.isLoading = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.errorMessage = error.message || 'Error al cargar la información del centro/ciclo';
                            this.isLoading = false;
                        });
                    }
                }"  x-show="showModal" 
                    x-cloak @click.away="showModal = false"
                    @open-modal.window="loadCentroInfo($event.detail.centroId, $event.detail.cicloId)" 
                    x-transition.opacity
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true"
                    x-bind:aria-hidden="!showModal">
                    
                    <!-- Contenedor principal -->
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden relative">
                        <!-- Header -->
                        <div class="flex justify-between items-center bg-indigo-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white">
                                <i class="fas fa-school mr-2"></i> Información del Centro/Ciclo
                            </h2>
                            <button @click="showModal = false" class="text-white hover:text-gray-200 transition-colors"
                                aria-label="Cerrar modal">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>

                        <!-- Contenido -->
                        <div class="overflow-y-auto flex-1 px-6 py-4 space-y-6">
                            <!-- Estado de carga -->
                            <div x-show="isLoading" class="flex justify-center items-center py-12">
                                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-600"></div>
                            </div>
                            
                            <!-- Mensaje de error -->
                            <div x-show="errorMessage" class="bg-red-50 border-l-4 border-red-500 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700" x-text="errorMessage"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Datos del centro y ciclo -->
                            <template x-if="!isLoading && !errorMessage && Object.keys(centroInfo).length > 0">
                                <div class="space-y-6">
                                    <!-- Tarjeta de información principal -->
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Información del Centro -->
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800 mb-3 pb-2 border-b border-gray-300 flex items-center">
                                                    <i class="fas fa-school mr-2 text-indigo-600"></i>
                                                    Centro Educativo
                                                </h3>
                                                <div class="space-y-2">
                                                    <p><span class="font-medium text-gray-700">Código:</span> 
                                                        <span class="text-gray-600 font-mono" x-text="centroInfo.centro.id_centro"></span>
                                                    </p>
                                                    <p><span class="font-medium text-gray-700">Nombre:</span> 
                                                        <span class="text-gray-600" x-text="centroInfo.centro.nombre"></span>
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <!-- Información del Ciclo -->
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800 mb-3 pb-2 border-b border-gray-300 flex items-center">
                                                    <i class="fas fa-graduation-cap mr-2 text-indigo-600"></i>
                                                    Ciclo Formativo
                                                </h3>
                                                <div class="space-y-2">
                                                    <p><span class="font-medium text-gray-700">Código:</span> 
                                                        <span class="text-gray-600 font-mono" x-text="centroInfo.ciclo.id_ciclo"></span>
                                                    </p>
                                                    <p><span class="font-medium text-gray-700">Nombre:</span> 
                                                        <span class="text-gray-600" x-text="centroInfo.ciclo.nombre"></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Responsables del ciclo -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Tutor del ciclo -->
                                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-3 pb-2 border-b border-blue-300 flex items-center">
                                                <i class="fas fa-chalkboard-teacher mr-2 text-blue-600"></i>
                                                Tutor del Ciclo
                                            </h3>
                                            <template x-if="centroInfo.tutor">
                                                <div class="space-y-2">
                                                    <p><span class="font-medium text-gray-700">Nombre:</span> 
                                                        <span class="text-gray-600" x-text="centroInfo.tutor.nombre + ' ' + centroInfo.tutor.apellido"></span>
                                                    </p>
                                                    <p><span class="font-medium text-gray-700">DNI:</span> 
                                                        <span class="text-gray-600 font-mono uppercase" x-text="centroInfo.tutor.dni"></span>
                                                    </p>
                                                    <p><span class="font-medium text-gray-700">Email:</span> 
                                                        <a :href="'mailto:' + centroInfo.tutor.email" class="text-blue-600 hover:underline" x-text="centroInfo.tutor.email"></a>
                                                    </p>
                                                </div>
                                            </template>
                                            <template x-if="!centroInfo.tutor">
                                                <p class="text-gray-500 italic">No hay tutor asignado a este ciclo</p>
                                            </template>
                                        </div>
                                        
                                        <!-- Coordinador del ciclo -->
                                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-3 pb-2 border-b border-purple-300 flex items-center">
                                                <i class="fas fa-user-tie mr-2 text-purple-600"></i>
                                                Coordinador del Ciclo
                                            </h3>
                                            <template x-if="centroInfo.coordinador">
                                                <div class="space-y-2">
                                                    <p><span class="font-medium text-gray-700">Nombre:</span> 
                                                        <span class="text-gray-600" x-text="centroInfo.coordinador.nombre + ' ' + centroInfo.coordinador.apellido"></span>
                                                    </p>
                                                    <p><span class="font-medium text-gray-700">DNI:</span> 
                                                        <span class="text-gray-600 font-mono uppercase" x-text="centroInfo.coordinador.dni"></span>
                                                    </p>
                                                    <p><span class="font-medium text-gray-700">Email:</span> 
                                                        <a :href="'mailto:' + centroInfo.coordinador.email" class="text-purple-600 hover:underline" x-text="centroInfo.coordinador.email"></a>
                                                    </p>
                                                </div>
                                            </template>
                                            <template x-if="!centroInfo.coordinador">
                                                <p class="text-gray-500 italic">No hay coordinador asignado a este ciclo</p>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Módulos del ciclo -->
                                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                                <i class="fas fa-book-open mr-2 text-indigo-600"></i>
                                                Módulos del Ciclo
                                                <span class="ml-auto text-sm font-normal text-gray-500">
                                                    <span x-text="centroInfo.ciclo.modulos.length === 1 
                                                        ? '1 módulo' 
                                                        : centroInfo.ciclo.modulos.length + ' módulos'">
                                                    </span>
                                                </span>
                                            </h3>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    <template x-for="modulo in centroInfo.ciclo.modulos" :key="modulo.id_modulo">
                                                        <tr>
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600" x-text="modulo.id_modulo"></td>
                                                            <td class="px-4 py-3 text-sm text-gray-600" x-text="modulo.nombre"></td>
                                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                                <template x-if="modulo.docente">
                                                                    <span x-text="modulo.docente.nombre + ' ' + modulo.docente.apellido"></span>
                                                                </template>
                                                                <template x-if="!modulo.docente">
                                                                    <span class="text-gray-400 italic">Sin asignar</span>
                                                                </template>
                                                            </td>
                                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                                <template x-if="modulo.docente">
                                                                    <a :href="'mailto:' + modulo.docente.email" class="text-indigo-600 hover:underline" x-text="modulo.docente.email"></a>
                                                                </template>
                                                                <template x-if="!modulo.docente">
                                                                    <span class="text-gray-400 italic">-</span>
                                                                </template>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Footer -->
                        <div class="flex justify-end bg-gray-100 px-6 py-4 border-t">
                            <button @click="showModal = false"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors flex items-center">
                                <i class="fas fa-times mr-2"></i> Cerrar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botón Volver -->
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center text-sm font-semibold text-black hover:text-gray-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al panel
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection