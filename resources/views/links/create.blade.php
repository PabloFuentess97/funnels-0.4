<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Nuevo Link</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Agrega un nuevo link al proyecto.
                    </p>

                    <form action="{{ route('projects.links.store', $project) }}" method="POST" class="mt-6">
                        @csrf

                        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                            <div class="md:grid md:grid-cols-3 md:gap-6">
                                <div class="md:col-span-1">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Información del Link</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Configura el link y sus límites de clicks.
                                    </p>
                                </div>

                                <div class="mt-5 md:mt-0 md:col-span-2">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6">
                                            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                                            <input type="url" name="url" id="url" value="{{ old('url') }}"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                required>
                                            @error('url')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6">
                                            <label for="responsible" class="block text-sm font-medium text-gray-700">Responsable</label>
                                            <input type="text" name="responsible" id="responsible" value="{{ old('responsible') }}"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <p class="mt-2 text-sm text-gray-500">
                                                La persona responsable de gestionar este link.
                                            </p>
                                            @error('responsible')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="click_limit" class="block text-sm font-medium text-gray-700">Límite de Clicks</label>
                                            <input type="number" name="click_limit" id="click_limit" value="{{ old('click_limit', 1) }}"
                                                min="1"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                required>
                                            @error('click_limit')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="position" class="block text-sm font-medium text-gray-700">Posición</label>
                                            <input type="number" name="position" id="position" value="{{ old('position', 0) }}"
                                                min="0"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                required>
                                            @error('position')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6">
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                                        {{ old('is_active', true) ? 'checked' : '' }}
                                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="is_active" class="font-medium text-gray-700">Link Activo</label>
                                                    <p class="text-gray-500">Un link inactivo no registrará clicks.</p>
                                                </div>
                                            </div>
                                            @error('is_active')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('projects.show', $project) }}"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Crear Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
