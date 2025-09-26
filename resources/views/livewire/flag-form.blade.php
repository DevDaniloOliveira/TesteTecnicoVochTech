<div>
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                <h2 class="text-xl font-bold mb-4">
                    {{ $flagId ? 'Editar Bandeira' : 'Nova Bandeira' }}
                </h2>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nome</label>
                        <input type="text" wire:model.defer="name" 
                               class="w-full border p-2 rounded">
                        @error('name') 
                            <span class="text-red-600 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">CNPJ</label>
                        <input type="text" wire:model="cnpj"
                        x-mask="99.999.999/9999-99"
                        placeholder="00.000.000/0000-00" 
                               class="w-full border p-2 rounded">
                        @error('cnpj') 
                            <span class="text-red-600 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Grupo Econômico</label>
                        <select wire:model="economic_group_id" class="w-full border p-2 rounded">
                            <option value="">Selecione um grupo</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error('economic_group_id') 
                            <span class="text-red-600 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)"
                                class="px-4 py-2 bg-gray-400 text-white rounded">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
