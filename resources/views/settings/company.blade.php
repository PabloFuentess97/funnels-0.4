<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mt-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la Compañía</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Actualiza la información de tu compañía.
                    </p>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('settings.company.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <!-- Logo -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Logo</label>
                                    <div class="mt-1 flex items-center">
                                        <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="h-12 w-12 rounded-full object-cover">
                                        <input type="file" name="logo" accept="image/*" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        @if($company->logo_path)
                                            <button type="button" onclick="document.getElementById('remove-logo-form').submit()" class="ml-3 text-sm text-red-600 hover:text-red-500">
                                                Eliminar
                                            </button>
                                        @endif
                                    </div>
                                    @error('logo')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nombre de la Compañía -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Compañía</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Website -->
                                <div>
                                    <label for="website_url" class="block text-sm font-medium text-gray-700">Sitio Web</label>
                                    <input type="url" name="website_url" id="website_url" value="{{ old('website_url', $company->website_url) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="https://">
                                </div>

                                <!-- Descripción -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea name="description" id="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $company->description) }}</textarea>
                                </div>

                                <!-- Información de Contacto -->
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Información de Contacto</h4>
                                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                        <div>
                                            <label for="contact_email" class="block text-sm font-medium text-gray-700">Email de Contacto</label>
                                            <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $company->contact_email) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                            <input type="text" name="phone" id="phone" value="{{ old('phone', $company->phone) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <div class="col-span-full">
                                            <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                                            <input type="text" name="address" id="address" value="{{ old('address', $company->address) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario oculto para eliminar logo -->
    <form id="remove-logo-form" action="{{ route('settings.company.remove-logo') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>
