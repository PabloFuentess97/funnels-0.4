<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información del Plan y Facturación') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ver los detalles de tu plan de suscripción actual.') }}
        </p>
    </header>

    <div class="mt-6 space-y-4">
        @if ($subscription && $plan)
            <div>
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('Plan Actual') }}</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $plan->name }} (${{ number_format($plan->price, 2) }}/{{ __('mes') }})</p>
            </div>

            <div>
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('Estado') }}</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 capitalize">{{ $subscription->status === 'active' ? __('Activo') : __('Inactivo') }}</p>
            </div>

            @if ($subscription->renews_at)
                <div>
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('Próxima Facturación') }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $subscription->renews_at ? __('Se renovará el ') . $subscription->renews_at->format('F j, Y') : __('Plan finaliza el ') . $subscription->ends_at->format('F j, Y') }}</p>
                </div>
            @endif

            @if ($subscription->ends_at)
                <div>
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('Plan Finaliza el') }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $subscription->ends_at->format('F j, Y') }}</p>
                </div>
            @endif

             <div>
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('Límites del Plan') }}</h3>
                <ul class="mt-1 list-disc list-inside text-sm text-gray-600 dark:text-gray-400">
                    <li>{{ $plan->project_limit ?? 'Ilimitado' }} {{ __('Proyectos') }}</li>
                    <li>{{ $plan->link_limit ?? 'Ilimitado' }} {{ __('Enlaces por Proyecto') }}</li>
                    <li>{{ $plan->user_limit ?? 'Ilimitado' }} {{ __('Usuarios por Compañía') }}</li>
                </ul>
            </div>

             {{-- Aquí podrías añadir botones para cambiar de plan, cancelar, ver historial de facturas, etc. --}}
             {{-- <div class="mt-6">
                 <x-secondary-button>{{ __('Cambiar Plan') }}</x-secondary-button>
                 <x-danger-button>{{ __('Cancelar Suscripción') }}</x-danger-button>
             </div> --}}
        @else
             <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                 {{ __('No se encontró ninguna suscripción activa.') }}
                 {{-- Aquí podrías añadir un enlace para elegir un plan --}}
             </p>
        @endif
    </div>

</section>
