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
                            <form action="{{ route('admin.procedures.store') }}" method="POST" enctype="multipart/form-data" id="procedure-store">
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
                                                        if( old('year') == $i){
                                                            echo "<option value='".$i."' selected>".$i."</option>";
                                                        }else{
                                                            echo "<option value='".$i."'>".$i."</option>";
                                                        }
                                                    }
                                                @endphp
                                            </select>
                                            @error('year')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="type" class="block text-sm font-medium text-gray-700 ">Tipo de procedimiento</label>
                                            <select onchange="typeProcedure()" name="type" id="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 proced bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Seleccione::.</option>
                                                @foreach ($types as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == Request::get('procedure') ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-red-500 text-xs italic type hidden">Seleccione un tipo de procedimiento</span>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="department" class="block text-sm font-medium text-gray-700">Departamento</label>
                                            <select name="department" id="department" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('department') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Seleccione::.</option>
                                                @foreach ($departments as $item)
                                                    <option value="{{ $item->id }}" {{ old('department') ==  $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('department')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="department" class="block text-sm font-medium text-gray-700">Estado</label>
                                            <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('status') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Seleccione::.</option>
                                                <option value="R" {{ old('status') ==  'R' ? 'selected' : '' }}>R</option>
                                            </select>
                                            @error("status")
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="created_at" class="block text-sm font-medium text-gray-700">Fecha creacion</label>
                                            <input type="text" name="created_at" autocomplete="created_at" value="{{ now() }}" readonly class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('created_at') ? ' border-red-500' : 'border-gray-300' }}">
                                            @error('created_at')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid py-3 grid-cols-1 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Descripci&oacute;n</label>
                                            <textarea name="description" id="description" autocomplete="given-description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('description') ? ' border-red-500' : 'border-gray-300' }}"></textarea>
                                                @error('description')
                                                    <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <br>
                                    @error('type')                               <!-- This example requires Tailwind CSS v2.0+ -->
                                        <div class="bg-white px-4 sm:px-6 text-red-500">
                                            <div class="rounded-md bg-red-50 p-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                    <!-- Heroicon name: solid/x-circle -->
                                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-red-800">
                                                            {{ $message }}
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @enderror
                                    @error('document')                               <!-- This example requires Tailwind CSS v2.0+ -->
                                        <div class="bg-white px-4 sm:px-6 text-red-500">
                                            <div class="rounded-md bg-red-50 p-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                    <!-- Heroicon name: solid/x-circle -->
                                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-red-800">
                                                            {{ $message }}
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @enderror

                                    @error('file_format')                               <!-- This example requires Tailwind CSS v2.0+ -->
                                        <div class="bg-white px-4 sm:px-6 text-red-500">
                                            <div class="rounded-md bg-red-50 p-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                    <!-- Heroicon name: solid/x-circle -->
                                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-red-800">
                                                          {{ $message }}
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @enderror
                                    <br>                               <!-- This example requires Tailwind CSS v2.0+ -->
                                    @if (Request::get('procedure')!=NULL)
                                       @include('livewire.procedures.structure', ['data' => $procedures])
                                    @endif
                                    {{-- <div id="structure"></div> --}}
                                    <div class=" px-4 py-3 text-right sm:px-6">
                                        <button type="submit" id="store" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Registrar
                                        </button>
                                        <a href="{{ route('admin.procedures.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-red-500">
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var procedure = document.getElementById('type');
        var structure = document.getElementById('structure');
        var type = document.getElementsByClassName("type")[0];
        var proced = document.getElementsByClassName("proced")[0];
        function typeProcedure(){
            window.location="{{url()->current()}}"+"?procedure="+procedure.value;
        }

        /* function typeProcedure(){
            if(procedure.value == '' || procedure.value == null){
                proced.classList.add('border-red-500');
                proced.classList.remove('border-gray-300');
                type.classList.add('flex');
                type.classList.remove('hidden');
                structure.innerHTML = '';
            }else{
                type.classList.add('hidden');
                type.classList.remove('flex');
                proced.classList.remove('border-red-500');
                proced.classList.add('border-gray-300');
                //document.getElementById('store').disabled = false;

                axios.post('', {
                    id:procedure.value,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    if(response.data.success){
                        structure.innerHTML = response.data.view;
                    }
                }).catch(error => {
                        if (error.response) {
                            if (error.response.status === 422 || error.response.status === 500 ) {

                            } else {

                            }
                        } else {

                        }
                });
            }
        } */
    </script>
</x-app-layout>
