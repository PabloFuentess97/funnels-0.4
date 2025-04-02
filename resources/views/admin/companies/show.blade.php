<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Company Details') }}: {{ $company->name }}
            </h2>
            <a href="{{ route('admin.companies.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                 &larr; {{ __('Back to Companies List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Company Info Card --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Company Information') }}</h3>
                    <dl class="mt-4 space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Name') }}</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $company->name }}</dd>
                        </div>
                         <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Owner') }}</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $company->owner ? $company->owner->name : __('No owner assigned') }}
                                @if($company->owner) ({{ $company->owner->email }}) @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created') }}</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $company->created_at->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>
                    <div class="mt-6">
                         <a href="{{ route('admin.companies.edit', $company) }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Edit Company') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Project Summary Card --}}
             <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                 <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Project Summary') }}</h3>
                    <dl class="mt-4 space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-green-500 dark:text-green-400">{{ __('Active Projects') }}</dt>
                            <dd class="text-sm font-semibold text-green-600 dark:text-green-300">{{ $activeProjectsCount }}</dd>
                        </div>
                         <div class="flex justify-between">
                            <dt class="text-sm font-medium text-red-500 dark:text-red-400">{{ __('Inactive Projects') }}</dt>
                            <dd class="text-sm font-semibold text-red-600 dark:text-red-300">{{ $inactiveProjectsCount }}</dd>
                        </div>
                        <div class="flex justify-between border-t pt-2 mt-2 border-gray-200 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Projects') }}</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $totalProjectsCount }}</dd>
                        </div>
                    </dl>
                    {{-- Placeholder for future project list/management --}}
                    <div class="mt-6">
                        {{-- <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Manage Projects &rarr;</a> --}}
                         <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Project listing and management will be added here.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Projects List Card --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Projects') }}</h3>
                
                @if ($company->projects->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">{{ __('This company does not have any projects yet.') }}</p>
                @else
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">{{ __('Name') }}</th>
                                    <th scope="col" class="py-3 px-6">{{ __('Status') }}</th>
                                    <th scope="col" class="py-3 px-6">{{ __('Created At') }}</th>
                                    <th scope="col" class="py-3 px-6"><span class="sr-only">{{ __('Actions') }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($company->projects as $project)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{-- Enlace potencial a detalles del proyecto si fuera necesario --}}
                                        {{ $project->name }} 
                                    </th>
                                    <td class="py-4 px-6">
                                        @if ($project->is_active) {{-- Asumiendo campo 'is_active' --}}
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">{{ __('Active') }}</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $project->created_at->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        {{-- Enlace a la edición del proyecto (lo implementaremos a continuación) --}}
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('Edit') }}</a>
                                        {{-- Aquí irían otras acciones como 'Delete', 'View Details', etc. --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
