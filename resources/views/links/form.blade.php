@csrf
<div class="space-y-6">
    <div>
        <label for="url" class="block text-sm font-medium text-gray-700">URL del Link</label>
        <div class="mt-1">
            <input type="url" name="url" id="url" value="{{ old('url', $link->url ?? '') }}"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                required placeholder="https://ejemplo.com">
        </div>
        @error('url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="responsible" class="block text-sm font-medium text-gray-700">Responsable</label>
        <div class="mt-1">
            <input type="text" name="responsible" id="responsible" value="{{ old('responsible', $link->responsible ?? '') }}"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                placeholder="Nombre del responsable">
        </div>
        @error('responsible')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="click_limit" class="block text-sm font-medium text-gray-700">Límite de Clicks</label>
        <div class="mt-1">
            <input type="number" name="click_limit" id="click_limit" value="{{ old('click_limit', $link->click_limit ?? 100) }}"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                required min="1">
        </div>
        @error('click_limit')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="relative flex items-start">
        <div class="flex items-center h-5">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                {{ old('is_active', $link->is_active ?? true) ? 'checked' : '' }}
                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
        </div>
        <div class="ml-3 text-sm">
            <label for="is_active" class="font-medium text-gray-700">Link Activo</label>
            <p class="text-gray-500">Desmarcar para pausar temporalmente este link.</p>
        </div>
    </div>
</div>

<div class="mt-6">
    <button type="submit"
        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        {{ isset($link) ? 'Actualizar Link' : 'Crear Link' }}
    </button>
    <a href="{{ route('projects.show', $project) }}"
        class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Cancelar
    </a>
</div>
