<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!$hasCompany)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin Empresa Asociada</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Necesitas estar asociado a una empresa para ver las estadísticas del panel de control.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Actualizar Perfil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    {{-- Total Projects --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-500 bg-opacity-75">
                                    <svg class="h-8 w-8 text-white" viewBox="0 0 28 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.2 9.08889C18.2 11.5373 16.3196 13.5222 14 13.5222C11.6804 13.5222 9.79999 11.5373 9.79999 9.08889C9.79999 6.64043 11.6804 4.65556 14 4.65556C16.3196 4.65556 18.2 6.64043 18.2 9.08889Z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <div class="text-gray-500 dark:text-gray-400 text-sm">Total Proyectos</div>
                                    <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_projects'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Links --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <div class="text-gray-500 dark:text-gray-400 text-sm">Total Enlaces</div>
                                    <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_links'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Active Links --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <div class="text-gray-500 dark:text-gray-400 text-sm">Enlaces Activos</div>
                                    <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['active_links'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Clicks Chart --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Clics Últimos 7 Días</h3>
                    <div id="clicks-chart"></div>
                </div>
            @endif
        </div>
    </div>

    @if ($hasCompany)
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: [{
                    name: 'Clics',
                    data: @json($clicks)
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: @json($dates),
                    labels: {
                        style: {
                            colors: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                        }
                    }
                },
                tooltip: {
                    theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                },
                grid: {
                    borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
                },
                theme: {
                    mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                }
            };

            var chart = new ApexCharts(document.querySelector("#clicks-chart"), options);
            chart.render();
        });
    </script>
    @endpush
    @endif
</x-app-layout>
