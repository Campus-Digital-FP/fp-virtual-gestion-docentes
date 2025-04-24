<x-app-layout>
 <div class="py-12">
     <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="panel-container">
             <h3 class="text-2xl font-bold text-center">Dar Alta Docente</h3>
             <p class="text-center">Complete el siguiente formulario para dar de alta a un docente.</p>

             <!-- Formulario para alta docente -->
             <form method="POST" action="{{ route('alta_docente.store') }}">
                 @csrf
                 <div class="mt-4">
                     <label for="dni" class="block text-sm font-medium text-gray-700">DNI:</label>
                     <input type="text" name="dni" id="dni" class="mt-1 block w-full @error('dni') border-red-500 @enderror" required>
                     @error('dni')
                         <span class="text-red-500 text-sm">{{ $message }}</span>
                     @enderror
                 </div>

                 <div class="mt-4">
                     <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
                     <input type="email" name="email" id="email" class="mt-1 block w-full @error('email') border-red-500 @enderror" required>
                     @error('email')
                         <span class="text-red-500 text-sm">{{ $message }}</span>
                     @enderror
                 </div>

                 <div class="mt-4">
                     <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                     <input type="text" name="nombre" id="nombre" class="mt-1 block w-full @error('nombre') border-red-500 @enderror" required>
                     @error('nombre')
                         <span class="text-red-500 text-sm">{{ $message }}</span>
                     @enderror
                 </div>

                 <div class="mt-4">
                     <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido:</label>
                     <input type="text" name="apellido" id="apellido" class="mt-1 block w-full @error('apellido') border-red-500 @enderror" required>
                     @error('apellido')
                         <span class="text-red-500 text-sm">{{ $message }}</span>
                     @enderror
                 </div>

                 <div class="flex justify-center mt-4">
                     <button type="submit" class="border border-black text-black py-2 px-4 rounded-lg text-center transition-all duration-300 hover:scale-105 hover:opacity-90 hover:bg-gray-100">
                         Dar de Alta
                     </button>
                 </div>
                 <div class="flex justify-end mt-4">
                     <a href="{{ route('dashboard') }}" class="border border-black text-black py-2 px-4 rounded-lg text-center transition-all duration-300 hover:scale-105 hover:opacity-90 hover:bg-gray-100">
                         Volver 
                     </a>
                 </div>
             </form>
             
         </div>
     </div>
 </div>

</x-app-layout>
