<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="sm:flex sm:items-center mb-8">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-bold text-gray-900">Nuevo Proyecto</h1>
                <p class="mt-3 text-lg text-gray-700">Crea un nuevo proyecto para gestionar tus links y rondas.</p>
            </div>
        </div>

        <form action="{{ route('projects.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="bg-white shadow-lg sm:rounded-lg sm:p-8">
                <div class="md:grid md:grid-cols-3 md:gap-8">
                    <div class="md:col-span-1">
                        <h3 class="text-xl font-bold text-gray-900">Información del Proyecto</h3>
                        <p class="mt-3 text-lg text-gray-700">
                            Esta información se utilizará para identificar y gestionar tu proyecto.
                        </p>
                    </div>

                    <div class="mt-6 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="name" class="block text-lg font-medium text-gray-900">Nombre</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-lg border-gray-300 rounded-lg"
                                    required>
                                @error('name')
                                    <p class="mt-2 text-base text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="slug" class="block text-lg font-medium text-gray-900">Slug</label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-lg border-gray-300 rounded-lg"
                                    required>
                                @error('slug')
                                    <p class="mt-2 text-base text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-gray-50 rounded-lg p-5">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="infinite_rounds" id="infinite_rounds" value="1"
                                                {{ old('infinite_rounds') ? 'checked' : '' }}
                                                class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <label for="infinite_rounds" class="ml-3 block text-lg font-medium text-gray-700">
                                                Rondas Infinitas
                                            </label>
                                        </div>
                                        <p class="mt-2 text-lg text-gray-700">Marcar esta opción permitirá que el proyecto continúe con nuevas rondas automáticamente.</p>
                                        @error('infinite_rounds')
                                            <p class="mt-2 text-base text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-5">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                                {{ old('is_active', true) ? 'checked' : '' }}
                                                class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <label for="is_active" class="ml-3 block text-lg font-medium text-gray-700">
                                                Proyecto Activo
                                            </label>
                                        </div>
                                        <p class="mt-2 text-lg text-gray-700">Un proyecto inactivo no registrará clicks en sus links.</p>
                                        @error('is_active')
                                            <p class="mt-2 text-base text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('projects.index') }}" 
                    class="px-6 py-2.5 border border-gray-300 shadow-sm text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-2.5 border border-transparent shadow-sm text-lg font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Crear Proyecto
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
