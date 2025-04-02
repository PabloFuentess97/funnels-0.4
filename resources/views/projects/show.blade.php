<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900">{{ $project->name }}</h1>
                    <span class="ml-3">
                        @if($project->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Activo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Inactivo
                            </span>
                        @endif
                    </span>
                </div>
                <div class="mt-2 text-sm text-gray-700">
                    <p>URL del Funnel: 
                        <span class="font-mono bg-gray-100 px-2 py-1 rounded">
                            {{ route('funnel.redirect', $project->slug) }}
                        </span>
                        <button onclick="navigator.clipboard.writeText('{{ route('funnel.redirect', $project->slug) }}')"
                                class="ml-2 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Copiar
                        </button>
                    </p>
                    <p class="mt-1">
                        Rondas: {{ $project->infinite_rounds ? 'Infinitas' : 'Limitadas' }}
                    </p>
                </div>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-3">
                <a href="{{ route('projects.edit', $project) }}"
                   class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Editar Proyecto
                </a>
                <a href="{{ route('projects.links.create', $project) }}"
                   class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Nuevo Link
                </a>
            </div>
        </div>

        <!-- Ronda Actual -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Ronda Actual
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Estado de la ronda actual y opciones disponibles.
                </p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                @if($project->currentRound)
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Ronda #{{ $project->currentRound->round_number }}</p>
                            <p class="mt-1 text-sm text-gray-900">
                                Estado: 
                                @if($project->currentRound->is_completed)
                                    <span class="text-green-600">Completada</span>
                                @else
                                    <span class="text-blue-600">En progreso</span>
                                @endif
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Iniciada: {{ $project->currentRound->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <form action="{{ route('rounds.store') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" name="round_number" value="{{ $project->currentRound->round_number + 1 }}">
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Nueva Ronda
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-500">No hay una ronda activa</p>
                        <form action="{{ route('rounds.store') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" name="round_number" value="1">
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Iniciar Primera Ronda
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Links -->
        @include('links.list')

        <!-- Historial de Rondas -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Historial de Rondas
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Registro de todas las rondas realizadas en este proyecto.
                </p>
            </div>
            <div class="border-t border-gray-200">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($rounds as $round)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($round->is_completed)
                                            <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </span>
                                        @else
                                            <span class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">
                                            Ronda #{{ $round->round_number }}
                                            @if($round->id === $project->currentRound?->id)
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Actual
                                                </span>
                                            @endif
                                        </h4>
                                        <div class="mt-1">
                                            <p class="text-sm text-gray-500">
                                                Iniciada: {{ $round->created_at->format('d/m/Y H:i') }}
                                                @if($round->is_completed)
                                                    <span class="mx-1">•</span>
                                                    Completada: {{ $round->updated_at->format('d/m/Y H:i') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $round->is_completed ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $round->is_completed ? 'Completada' : 'En progreso' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $round->clicks()->count() }} clicks
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-5 sm:px-6 text-center text-sm text-gray-500">
                            No hay rondas registradas aún.
                        </li>
                    @endforelse
                </ul>
                @if($rounds->hasPages())
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                @if($rounds->onFirstPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-50">
                                        Anterior
                                    </span>
                                @else
                                    <a href="{{ $rounds->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Anterior
                                    </a>
                                @endif
                                
                                @if($rounds->hasMorePages())
                                    <a href="{{ $rounds->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Siguiente
                                    </a>
                                @else
                                    <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-50">
                                        Siguiente
                                    </span>
                                @endif
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Mostrando
                                        <span class="font-medium">{{ $rounds->firstItem() }}</span>
                                        a
                                        <span class="font-medium">{{ $rounds->lastItem() }}</span>
                                        de
                                        <span class="font-medium">{{ $rounds->total() }}</span>
                                        rondas
                                    </p>
                                </div>
                                <div>
                                    {{ $rounds->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
