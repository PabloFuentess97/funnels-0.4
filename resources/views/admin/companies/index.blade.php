<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Companies') }}
            </h2>
            <a href="{{ route('admin.companies.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Create Company') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if($companies->isEmpty())
                        <p>{{ __('No companies found.') }}</p>
                    @else
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Name') }}
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Owner') }}
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            {{ __('Created At') }}
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            <span class="sr-only">{{ __('Actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $company)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <a href="{{ route('admin.companies.show', $company) }}" class="hover:underline">
                                                {{ $company->name }}
                                            </a>
                                        </th>
                                        <td class="py-4 px-6">
                                            {{ $company->owner ? $company->owner->name : __('No owner') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $company->created_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            {{-- Actions (Edit, Delete) --}}
                                            <a href="{{ route('admin.companies.edit', $company) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">{{ __('Edit') }}</a>
                                            {{-- Add Delete button later with confirmation --}}
                                            {{-- <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('Delete') }}</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination Links --}}
                        <div class="mt-4">
                            {{ $companies->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
