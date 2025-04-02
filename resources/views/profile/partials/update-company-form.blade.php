<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información de la Compañía') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Actualiza el nombre de tu compañía.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateCompany') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="company_name" :value="__('Nombre de la Compañía')" />
            <x-text-input id="company_name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $company->name)" required autofocus autocomplete="organization" :disabled="!Auth::user()->isCompanyOwner()"/>
            <x-input-error class="mt-2" :messages="$errors->updateCompany->get('name')" />
        </div>

        {{-- Solo mostrar botón si es el dueño --}}
        @if(Auth::user()->isCompanyOwner())
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                @if (session('status') === 'company-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Guardado.') }}</p>
                @endif
            </div>
        @else
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Solo el propietario de la compañía puede actualizar esta información.') }}
            </p>
        @endif
    </form>
</section>
