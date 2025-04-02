<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Proyecto</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                <div class="mt-1">
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $project->slug) }}"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fallback_url" class="block text-sm font-medium text-gray-700">URL de Retorno (cuando el proyecto está pausado)</label>
                                <div class="mt-1">
                                    <input type="url" name="fallback_url" id="fallback_url" value="{{ old('fallback_url', $project->fallback_url) }}"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="https://ejemplo.com">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Los usuarios serán redirigidos a esta URL cuando el proyecto esté pausado. Dejar en blanco para mostrar la página de pausa predeterminada.</p>
                                @error('fallback_url')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                        {{ old('is_active', $project->is_active) ? 'checked' : '' }}
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_active" class="font-medium text-gray-700">Proyecto Activo</label>
                                    <p class="text-gray-500">Desmarcar para pausar temporalmente el proyecto.</p>
                                </div>
                            </div>

                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="infinite_rounds" id="infinite_rounds" value="1"
                                        {{ old('infinite_rounds', $project->infinite_rounds) ? 'checked' : '' }}
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="infinite_rounds" class="font-medium text-gray-700">Rondas Infinitas</label>
                                    <p class="text-gray-500">Crear automáticamente nuevas rondas cuando se completen todas.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Guardar Cambios
                            </button>
                            <a href="{{ route('projects.show', $project) }}"
                                class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
