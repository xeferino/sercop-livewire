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
                                    <div class="rounded-md bg-green-50 p-4 msg_succes hidden">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                            <!-- Heroicon name: solid/x-circle -->
                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-green-800">
                                                    Procedimiento registrado exitosamente.
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="number" class="block text-sm font-medium text-gray-700">Numero Sercop</label>
                                            <input type="text" name="number" autocomplete="number" value="{{ old('number') }}" class="number_input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md border-gray-300">
                                            <span class="text-red-500 text-xs italic number_span"></span>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="year" class="block text-sm font-medium text-gray-700">A&ntilde;o</label>
                                            <select name="year" id="year" class="year_input mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                                            <span class="text-red-500 text-xs italic year_span"></span>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="type" class="block text-sm font-medium text-gray-700 ">Tipo de procedimiento</label>
                                            <select onchange="typeProcedure()" name="type" id="type" class="type_input mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Seleccione::.</option>
                                                @foreach ($types as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == Request::get('procedure') ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-red-500 text-xs italic type_span"></span>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="department" class="block text-sm font-medium text-gray-700">Departamento</label>
                                            <select name="department" id="department" class="department_input mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Seleccione::.</option>
                                                @foreach ($departments as $item)
                                                    <option value="{{ $item->id }}" {{ old('department') ==  $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-red-500 text-xs italic department_span"></span>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                                            <select name="status" id="status" class="status_input mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">.::Selecciona el tipo de procedimiento::.</option>
                                                <option value="Pendiente" {{ old('status') ==  'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="Completado" {{ old('status') ==  'Completado' ? 'selected' : '' }}>Completado</option>
                                            </select>
                                            <span class="text-red-500 text-xs italic status_span"></span>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="created_at" class="block text-sm font-medium text-gray-700">Fecha creacion</label>
                                            <input type="text" name="created_at" autocomplete="created_at" value="{{ now() }}" readonly class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('created_at') ? ' border-red-500' : 'border-gray-300' }}">
                                        </div>
                                    </div>
                                    <div class="grid py-3 grid-cols-1 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Descripci&oacute;n</label>
                                            <textarea name="description" id="description" autocomplete="given-description" class="description_input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md border-gray-300"></textarea>
                                            <span class="text-red-500 text-xs italic description_span"></span>
                                        </div>
                                    </div>
                                    <br>                               <!-- This example requires Tailwind CSS v2.0+ -->
                                    <div id="structure"></div>
                                    <div class=" px-4 py-3 text-right sm:px-6">
                                        <button type="submit" id="store" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Guardar Procedimiento
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

        //window.addEventListener('load', ()=>{
            const form_procedure = document.getElementById("procedure-store");

            form_procedure.addEventListener("submit", function (event) {
                event.preventDefault();
                let data = new FormData(form_procedure);

                axios({
                method:'post',
                url:'{{ route('admin.procedures.store') }}',
                data:data,
                headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'multipart/form-data'
                        }
            })
            .then((res)=>{
                if(res.data.success){
                    form_procedure.reset();
                    document.querySelector('.msg_succes').classList.remove('hidden');
                    setTimeout(function() { location.href = res.data.url }, 3000);
                }
            })
            .catch((err) => {
                if (err.response) {
                        if (err.response.status === 422 || err.response.status === 500 ) {
                            if (err.response.data.errors.number[0]) {
                                document.querySelector('.number_input').classList.add('border-red-500');
                                document.querySelector('.number_input').classList.remove('border-gray-300');
                                document.querySelector('.number_span').innerHTML = err.response.data.errors.number[0];
                            }

                            if (err.response.data.errors.year[0]) {
                                document.querySelector('.year_input').classList.add('border-red-500');
                                document.querySelector('.year_input').classList.remove('border-gray-300');
                                document.querySelector('.year_span').innerHTML = err.response.data.errors.year[0];
                            }

                            if (err.response.data.errors.department[0]) {
                                document.querySelector('.department_input').classList.add('border-red-500');
                                document.querySelector('.department_input').classList.remove('border-gray-300');
                                document.querySelector('.department_span').innerHTML = err.response.data.errors.department[0];
                            }

                            if (err.response.data.errors.status[0]) {
                                document.querySelector('.status_input').classList.add('border-red-500');
                                document.querySelector('.status_input').classList.remove('border-gray-300');
                                document.querySelector('.status_span').innerHTML = err.response.data.errors.status[0];
                            }

                            /* if (err.response.data.errors.description[0]) {
                                document.querySelector('.description_input').classList.add('border-red-500');
                                document.querySelector('.description_input').classList.remove('border-gray-300');
                                document.querySelector('.description_span').innerHTML = err.response.data.errors.description[0];
                            } */

                            if (err.response.data.errors.type[0]) {
                                document.querySelector('.type_input').classList.add('border-red-500');
                                document.querySelector('.type_input').classList.remove('border-gray-300');
                                document.querySelector('.type_span').innerHTML = err.response.data.errors.type[0];
                            }
                        } else {

                        }
                    } else {

                    }
                });
            });
        //});



        function typeProcedure(){
            if(procedure.value == '' || procedure.value == null){
                document.querySelector('.type_input').classList.add('border-red-500');
                document.querySelector('.type_input').classList.remove('border-gray-300');
                document.querySelector('.type_span').innerHTML = 'Seleccione un tipo de procedimiento';
                structure.innerHTML = '';
            }else{
                document.querySelector('.type_input').classList.remove('border-red-500');
                document.querySelector('.type_input').classList.add('border-gray-300');
                document.querySelector('.type_span').innerHTML = '';
                axios.post('{{ route('admin.procedures.type') }}', {
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
                                if (error.response.data.errors.name) {
                                    $('#name').addClass("is-invalid");
                                    $('.name').text('' + error.response.data.errors.name + '');
                                }
                                const frase = document.getElementById('frase');
                                const fulltext = frase.textContent;
                                const html = frase.innerHTML;
                            } else {

                            }
                        } else {

                        }
                });
            }
        }
    </script>
</x-app-layout>
