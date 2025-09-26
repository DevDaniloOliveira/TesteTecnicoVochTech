<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Grupos Econômicos') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex justify-between py-2">
                    <input type="text" wire:model.live="search" placeholder="Buscar grupo..." class="border p-2 mb-4">
                    <button type="button" wire:click="$dispatch('open-modal')" class="px-4 bg-green-400 rounded">
                            Criar
                    </button>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ formatCnpj($group->cnpj) }}</td>
                            <td>
                                <button wire:click="$dispatch('open-modal',{id:{{ $group->id }}})" class="bg-yellow-500 px-2 py-1 text-white rounded">Editar</button>
                            </td>
                            <td>
                                <button wire:click="$dispatch('open-delete-modal',{id:{{ $group->id }}})" class="bg-red-500 px-2 py-1 text-white rounded">Deletar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $groups->links() }} {{-- Paginação --}}

            </div>
        </div>
    </div>
    @livewire('economic-group-form')
    @livewire('economic-group-delete')
</div>