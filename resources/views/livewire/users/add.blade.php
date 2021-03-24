<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Usuario') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10  sm:mt-0">
                <div class="grid grid-cols-1 md:grid-cols-1 pb-8">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" name="name" autocomplete="name" value="{{ old('name') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('name') ? ' border-red-500' : 'border-gray-300' }}">
                                    @error('name')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="surname" class="block text-sm font-medium text-gray-700">Apellido</label>
                                    <input type="text" name="surname" autocomplete="surname" value="{{ old('surname') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('surname') ? ' border-red-500' : 'border-gray-300' }}">
                                    @error('surname')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="text" name="email" autocomplete="email" value="{{ old('email') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('email') ? ' border-red-500' : 'border-gray-300' }}">
                                    @error('email')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="department_id" class="block text-sm font-medium text-gray-700">Departamento</label>
                                    <select name="department_id" class="outline-none text-gray-500 text-sm rounded-md w-full {{ $errors->has('department_id') ? ' border-red-500' : 'border-gray-300' }}">
                                        <option value="">.::Seleccione::.</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Contrase&ntilde;a</label>
                                    <input type="password" name="password" autocomplete="password" value="{{ old('password') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('password') ? ' border-red-500' : 'border-gray-300' }}">
                                    @error('password')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="cpassword" class="block text-sm font-medium text-gray-700">Repetir Contrase&ntilde;a</label>
                                    <input type="password" name="cpassword" autocomplete="cpassword" value="{{ old('cpassword') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('cpassword') ? ' border-red-500' : 'border-gray-300' }}">
                                    @error('cpassword')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="role" class="block text-sm font-medium text-gray-700">Roles</label>
                                    <select name="role" class="outline-none text-gray-500 text-sm rounded-md w-full {{ $errors->has('role') ? ' border-red-500' : 'border-gray-300' }}">
                                        <option value="">.::Seleccione::.</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div class="col-span-6 sm:col-span-3">
                                    <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar</label>
                                    <input type="file" name="avatar" autocomplete="avatar" value="{{ old('avatar') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('avatar') ? ' border-red-500' : 'border-gray-300' }}">
                                    @error('avatar')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                            </div>

                            <div class="px-4 py-3 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Registrar
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-red-500">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
