<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Notificaciones</h1>
                    <p class="mt-2 text-sm text-gray-700">Lista de todas tus notificaciones.</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            Marcar todas como leídas
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <div class="divide-y divide-gray-200 bg-white" id="notifications-container">
                                @include('notifications.partials.notification-list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($notifications->hasMorePages())
                <div class="flex justify-center mt-4" id="load-more-container">
                    <button type="button" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
                            id="load-more-button"
                            data-next-page="{{ $notifications->currentPage() + 1 }}">
                        <span>Cargar más</span>
                        <span class="hidden ml-2" id="loading-spinner">
                            <svg class="animate-spin h-5 w-5 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('notifications-container');
            const loadMoreButton = document.getElementById('load-more-button');
            const loadingSpinner = document.getElementById('loading-spinner');
            const loadMoreContainer = document.getElementById('load-more-container');

            if (loadMoreButton) {
                loadMoreButton.addEventListener('click', async function() {
                    const nextPage = this.dataset.nextPage;
                    loadingSpinner.classList.remove('hidden');
                    loadMoreButton.disabled = true;

                    try {
                        const response = await fetch(`/notifications?page=${nextPage}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const html = await response.text();
                        
                        // Agregar las nuevas notificaciones
                        container.insertAdjacentHTML('beforeend', html);
                        
                        // Actualizar o eliminar el botón según si hay más páginas
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const hasMore = doc.querySelectorAll('.p-4').length === 10;
                        
                        if (hasMore) {
                            loadMoreButton.dataset.nextPage = parseInt(nextPage) + 1;
                        } else {
                            loadMoreContainer.remove();
                        }
                    } catch (error) {
                        console.error('Error cargando más notificaciones:', error);
                    } finally {
                        loadingSpinner.classList.add('hidden');
                        loadMoreButton.disabled = false;
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
