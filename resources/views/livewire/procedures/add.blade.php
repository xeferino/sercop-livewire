<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Procedimiento') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10  sm:mt-0">
                <div class="grid grid-cols-1 md:grid-cols-1 pb-8">
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <form action="{{ route('admin.roles.store') }}" method="POST">
                                @csrf
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="number" class="block text-sm font-medium text-gray-700">Numero Sercop</label>
                                            <input type="text" name="number" autocomplete="number" value="{{ old('number') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('number') ? ' border-red-500' : 'border-gray-300' }}">
                                            @error('number')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="year" class="block text-sm font-medium text-gray-700">A&ntilde;o</label>
                                            <select name="year" id="year" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('year') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Seleccione::.</option>
                                                @php
                                                    for($i=2020;$i<=date("Y"); $i++)
                                                    {
                                                        echo "<option value='".$i."'>".$i."</option>";
                                                    }
                                                @endphp
                                            </select>
                                            @error('year')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="type" class="block text-sm font-medium text-gray-700">Tipo de procedimiento</label>
                                            <select name="type" id="type" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('type') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Seleccione::.</option>
                                                @foreach ($types as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="department" class="block text-sm font-medium text-gray-700">Departamento</label>
                                            <select name="department" id="department" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('department') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Seleccione::.</option>
                                                @foreach ($departments as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('department')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                   {{--  <div class="px-4 py-3 text-right sm:px-6">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Registrar
                                        </button>
                                        <a href="{{ route('admin.roles.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-red-500">
                                            Cancelar
                                        </a>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
