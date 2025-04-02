<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Links del Proyecto</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Lista de links configurados para este funnel.</p>
        </div>
        <a href="{{ route('projects.links.create', $project) }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
            Agregar Link
        </a>
    </div>
    <div class="border-t border-gray-200">
        <ul role="list" class="divide-y divide-gray-200" id="sortable-links">
            @foreach($project->links()->orderBy('position')->get() as $link)
            <li class="relative bg-white py-5 px-4 hover:bg-gray-50 flex items-center" data-id="{{ $link->id }}">
                <div class="cursor-move mr-4 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                    </svg>
                </div>
                <div class="flex-grow min-w-0">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-indigo-600 truncate flex-shrink">
                            <a href="{{ $link->url }}" target="_blank" class="hover:underline">{{ $link->url }}</a>
                        </div>
                        <div class="ml-2 flex-shrink-0 flex">
                            @if($link->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Activo
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Inactivo
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2 flex justify-between">
                        <div class="sm:flex">
                            <div class="mr-6 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $link->responsible ?: 'Sin responsable' }}
                            </div>
                            <div class="mt-2 sm:mt-0 mr-6 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $link->current_clicks }}/{{ $link->click_limit }}
                                @if($project->currentRound)
                                <span class="ml-2 text-xs text-gray-400">(Ronda: {{ $link->clicks()->where('round_id', $project->currentRound->id)->count() }})</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('projects.links.edit', [$project, $link]) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            <form action="{{ route('projects.links.destroy', [$project, $link]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que quieres eliminar este link?')">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('sortable-links');
        var sortable = new Sortable(el, {
            animation: 150,
            ghostClass: 'bg-gray-100',
            onEnd: function(evt) {
                var positions = [];
                el.querySelectorAll('li').forEach(function(item, index) {
                    positions.push(item.dataset.id);
                });

                fetch('{{ route("projects.links.update-positions", $project) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        positions: positions
                    })
                });
            }
        });
    });
</script>
@endpush
