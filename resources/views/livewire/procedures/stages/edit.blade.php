<div class="mt-10  sm:mt-0">
    <div class="grid grid-cols-1 md:grid-cols-1 pb-8">
      <div class="mt-5 md:mt-0 md:col-span-2">
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Etapa</label>
                    <input type="text" wire:model="name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('name') ? ' border-red-500' : 'border-gray-300' }}">
                        @error('name')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="short_name" class="block text-sm font-medium text-gray-700">Nombre Corto</label>
                        <input type="text" wire:model="short_name" autocomplete="given-short_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('short_name') ? ' border-red-500' : 'border-gray-300' }}">
                            @error('short_name')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="type_procedure_id" class="block text-sm font-medium text-gray-700">Procedimientos</label>
                        <select wire:model="type_procedure_id" multiple class="mt-1 block w-full py-2 px-3 border {{ $errors->has('type_procedure_id') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @foreach ($types as $item)
                                <option value="{{ $item->id }}" {{ (in_array($item->id, $procedures->pluck('id')->toArray())) ? "selected='selected'" : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('type_procedure_id')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button wire:click="update()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Editar
                    </button>
                    <button wire:click="create()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-red-500">
                        Cancelar
                    </button>
                </div>
          </div>
      </div>
    </div>
</div>
