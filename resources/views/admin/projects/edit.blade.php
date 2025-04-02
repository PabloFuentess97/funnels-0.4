<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Project') }}: {{ $project->name }}
            </h2>
             <a href="{{ route('admin.companies.show', $project->company_id) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                 &larr; {{ __('Back to Company') }}: {{ $project->company->name ?? 'N/A' }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Project Details Form --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Project Details') }}</h3>
                    <form method="POST" action="{{ route('admin.projects.update', $project) }}">
                        @csrf
                        @method('PUT')

                        <!-- Project Name -->
                        <div>
                            <x-input-label for="name" :value="__('Project Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $project->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Active Status -->
                        <div class="mt-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="is_active" value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Project is Active') }}</span>
                            </label>
                            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            {{-- Botón Borrar (se añadirá después) --}}
                            {{-- <x-danger-button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-project-deletion')">{{ __('Delete Project') }}</x-danger-button> --}}

                            <div class="flex-grow"></div> {{-- Empuja los botones a la derecha --}}

                             <a href="{{ route('admin.companies.show', $project->company_id) }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Project') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Links Management Section --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                 <div class="max-w-full">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Project Links') }}</h3>
                    {{-- TODO: Add button to create new link? --}}
                    
                    @if ($project->links->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">{{ __('This project does not have any links yet.') }}</p>
                    @else
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">{{ __('URL') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Clicks') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Limit') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Status') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Responsible') }}</th>
                                        <th scope="col" class="py-3 px-6">{{ __('Position') }}</th>
                                        <th scope="col" class="py-3 px-6"><span class="sr-only">{{ __('Actions') }}</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->links->sortBy('position') as $link) {{-- Ordenar por posición --}}
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6">
                                            <a href="{{ $link->url }}" target="_blank" title="{{ $link->url }}" class="hover:underline text-blue-600 dark:text-blue-400">
                                                {{ Str::limit($link->url, 50) }} {{-- Limitar para que no sea muy largo --}}
                                            </a>
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $link->current_clicks ?? 0 }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $link->click_limit ?? '∞' }} {{-- Mostrar infinito si es null/0? --}}
                                        </td>
                                         <td class="py-4 px-6">
                                            @if ($link->is_active) 
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">{{ __('Active') }}</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">{{ __('Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $link->responsible ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $link->position ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6 text-right space-x-2">
                                            {{-- Enlace a edición del link --}}
                                            <a href="{{ route('admin.links.edit', $link) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('Edit') }}</a>
                                            {{-- Botón Borrar Link (requiere modal) --}}
                                            <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-link-deletion-{{ $link->id }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('Delete') }}</button>
                                        </td>
                                    </tr>
                                    {{-- Modal de confirmación de borrado para este link --}}
                                    <x-modal name="confirm-link-deletion-{{ $link->id }}" focusable>
                                        <form method="post" action="{{ route('admin.links.destroy', $link) }}" class="p-6">
                                            @csrf
                                            @method('delete')

                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Are you sure you want to delete this link?</h2>
                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">URL: {{ $link->url }}</p>

                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>
                                                <x-danger-button class="ml-3">
                                                    {{ __('Delete Link') }}
                                                </x-danger-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Confirm Delete Modal (Añadir después) --}}
            {{-- <x-modal name="confirm-project-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('admin.projects.destroy', $project) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Are you sure you want to delete this project?</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Once deleted, all of its resources and data will be permanently removed.</p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-danger-button class="ml-3">
                            {{ __('Delete Project') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal> --}}

        </div>
    </div>
</x-app-layout>
