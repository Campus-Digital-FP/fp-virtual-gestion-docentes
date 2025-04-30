<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="panel-container">
                <h3 class="text-2xl font-bold text-center">Establecer Tutor/es</h3>
                <p class="text-center">Complete el siguiente formulario para establecer o borrar un Tutor.</p>

                <!-- Mensajes de éxito -->
                @if(session('success'))
                    <div class="bg-green-500 border-l-4 border-green-500 text-black px-6 py-4 rounded-lg mb-6">
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Mostrar errores generales -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        <strong>Error:</strong>
                        <ul class="list-disc ml-6 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario -->
                <form method="POST" action="{{ route('establecer_tutor.store') }}">
                    @csrf

                    <!-- Seleccionar Ciclo -->
                    <div class="mt-4">
                        <label for="id_ciclo" class="block text-sm font-medium text-gray-700">Seleccionar Ciclo:</label>
                        <select name="id_ciclo" id="id_ciclo" required class="mt-1 block w-full @error('id_ciclo') border-red-500 @enderror">
                            <option value="">-- Selecciona un ciclo --</option>
                            @foreach ($ciclos as $ciclo)
                                <option value="{{ $ciclo->id_ciclo }}">{{ $ciclo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Docentes -->
                    <div class="mt-4">
                        <label for="dni" class="block text-sm font-medium text-gray-700">Seleccionar Coordinador:</label>

                        <select name="dni" id="dni" required class="mt-1 block w-full @error('dni') border-red-500 @enderror">
                        <option value="">-- Selecciona un docente --</option>
                        @foreach ($docentes as $docente)
                            <option value="{{ $docente->dni }}">{{ $docente->nombre }} {{ $docente->apellido }} - {{ $docente->dni }}</option>
                        @endforeach
                    </select>
                    </div>
                    
                    <!-- Botones -->
                    <div class="flex justify-end gap-4 mt-6">
                        <button type="submit" class="border border-black text-black py-2 px-4 rounded-lg text-center transition-all duration-300 hover:scale-105 hover:opacity-90 hover:bg-gray-100">
                            Establecer
                        </button>
                    </div>
                </form>
                <br>
                <!-- Tabla de tutores actuales -->
                <h4 class="text-xl font-semibold text-gray-800 mt-10 mb-6 text-center">Listado de Tutores Actuales</h4>
                <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="min-w-full table-auto text-sm mx-auto">
                        <thead class="bg-gray-100 ">
                            <tr>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Nombre</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Apellidos</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Ciclo</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">DNI</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Acción</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tutores as $tutor)
                            <tr class="hover:bg-gray-50 transition" x-data="{ showModal: false }">
                                <td class="px-6 py-4 border-b">{{ $tutor->docente->nombre ?? 'No encontrado' }}</td>
                                <td class="px-6 py-4 border-b">{{ $tutor->docente->apellido ?? 'No encontrado' }}</td>
                                <td class="px-6 py-4 border-b">{{ $tutor->ciclo->nombre }}</td>
                                <td class="px-6 py-4 border-b">{{ $tutor->dni }}</td>
                                <td class="px-6 py-4 border-b">
                                    <button
                                        @click="showModal = true"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                                    >
                                        Borrar
                                    </button>

                                    <!-- Modal -->
                                    <div
                                        x-show="showModal"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                    >
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                            <h2 class="text-lg mb-4">¿Estás seguro de que quieres borrar a <b>{{ $tutor->docente->nombre }} {{ $tutor->docente->apellido }} </b>del ciclo <b>{{ $tutor->ciclo->nombre }}</b>?</h2>
                                            <div class="flex justify-end gap-4">
                                                <button
                                                    @click="showModal = false"
                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                                                >
                                                    Cancelar
                                                </button>
                                                <form method="POST" action="{{ route('tutor.destroy', $tutor->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Sí, borrar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">No hay tutores registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Botón Volver -->
                <div class="flex justify-end mt-4">
                    <a href="{{ route('dashboard') }}" class="border border-black text-black py-2 px-4 rounded-lg text-center transition-all duration-300 hover:scale-105 hover:opacity-90 hover:bg-gray-100">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
