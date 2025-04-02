<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">
                Proyectos
            </h1>
            <a href="{{ route('projects.create') }}"
               class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Nuevo Proyecto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($projects as $project)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-semibold mb-2">
                                <a href="{{ route('projects.show', $project) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                    {{ $project->name }}
                                </a>
                            </h3>
                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1 mb-4">
                                <p>Enlaces Activos: {{ $project->links()->where('is_active', true)->count() }}</p>
                                <p>
                                    Ronda Actual: 
                                    @if($project->currentRound)
                                        Ronda #{{ $project->currentRound->round_number }}
                                    @else
                                        Sin ronda activa
                                    @endif
                                </p>
                                <p>
                                    Estado: 
                                    @if($project->is_active)
                                        <span class="inline-flex rounded-full bg-green-100 dark:bg-green-900 px-2 text-xs font-semibold leading-5 text-green-800 dark:text-green-100">
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 dark:bg-red-900 px-2 text-xs font-semibold leading-5 text-red-800 dark:text-red-100">
                                            Inactivo
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="flex justify-end space-x-3 text-sm">
                                <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">Editar</a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200" onclick="return confirm('¿Estás seguro?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 sm:col-span-2 md:col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            No hay proyectos creados aún.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</x-app-layout>
