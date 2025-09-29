<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Unidades') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex justify-between py-2">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" wire:model.live="search" placeholder="Buscar unidades..." 
                                class="w-full p-2 border rounded">
                        </div>
                        <div>
                            <select wire:model.live="flagId" class="w-full p-2 border rounded">
                                <option value="">Todas as Bandeiras</option>
                                @foreach($flags as $flag)
                                    <option value="{{ $flag['id'] }}">{{ $flag['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" wire:click="$dispatch('open-modal')" class="px-4 bg-green-400 rounded">
                            Criar
                    </button>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th>ID</th>
                            <th>Nome Fantasia</th>
                            <th>Razão Social</th>
                            <th>CNPJ</th>
                            <th>Bandeira</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                        <tr>
                            <td>{{ $unit->id }}</td>
                            <td>{{ $unit->fantasy_name }}</td>
                            <td>{{ $unit->social_reason }}</td>
                            <td>{{ formatCnpj($unit->cnpj) }}</td>
                            <td>{{ $unit->flag->name ?? '-' }}</td>
                            <td>
                                <button wire:click="$dispatch('open-modal',{id:{{ $unit->id }}})" class="bg-yellow-500 px-2 py-1 text-white rounded">Editar</button>
                            </td>
                            <td>
                                <button wire:click="$dispatch('open-delete-modal',{id:{{ $unit->id }}})" class="bg-red-500 px-2 py-1 text-white rounded">Deletar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $units->links() }} {{-- Paginação --}}

            </div>
        </div>
    </div>
    @livewire('unit-form')
    @livewire('unit-delete')
