<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Relatórios') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="mb-4 text-gray-900">
                    <h2 class="text-lg font-semibold mb-2">Filtros</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Grupo Econômico -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Grupo Econômico</label>
                        <select wire:model.live="filters.economic_group_id" class="w-full border rounded p-2">
                            <option value="">Todos os Grupos</option>
                            @foreach ($economicGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bandeira -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Bandeira</label>
                        <select wire:model.live="filters.flag_id" class="w-full border rounded p-2"
                            {{ !$filters['economic_group_id'] ? 'disabled' : '' }}>
                            <option value="">Todas as Bandeiras</option>
                            @foreach ($flags as $flag)
                                <option value="{{ $flag->id }}">{{ $flag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Unidade -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Unidade</label>
                        <select wire:model.live="filters.unit_id" class="w-full border rounded p-2"
                            {{ !$filters['flag_id'] ? 'disabled' : '' }}>
                            <option value="">Todas as Unidades</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->fantasy_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Busca -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Buscar</label>
                        <input type="text" wire:model.live="filters.search" placeholder="Nome, Email ou CPF"
                            class="w-full border rounded p-2">
                    </div>
                </div>
            </div>

            <!-- Resultados -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold">Resultados</h2>
                        <span class="text-sm text-gray-600">
                            {{ $employees->total() }} colaborador(es) encontrado(s)
                        </span>
                    </div>
                </div>

                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">Nome</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">CPF</th>
                            <th class="px-4 py-3 text-left">Unidade</th>
                            <th class="px-4 py-3 text-left">Bandeira</th>
                            <th class="px-4 py-3 text-left">Grupo</th>
                            <th class="px-4 py-3 text-left">Data Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $employee->name }}</td>
                                <td class="px-4 py-3">{{ $employee->email }}</td>
                                <td class="px-4 py-3">{{ formatCpf($employee->cpf) }}</td>
                                <td class="px-4 py-3">{{ $employee->unit->fantasy_name }}</td>
                                <td class="px-4 py-3">{{ $employee->unit->flag->name }}</td>
                                <td class="px-4 py-3">{{ $employee->unit->flag->economicGroup->name }}</td>
                                <td class="px-4 py-3">{{ $employee->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginação -->
                <div class="p-4 border-t flex justify-between">
                    <div class="flex justify-between">
                        {{ $employees->links() }}
                    </div>
                    <button wire:click="export" wire:loading.attr="disabled"
                        class="bg-green-500 text-white px-4 py-2 rounded">
                        <span wire:loading.remove>📤 Exportar</span>
                        <span wire:loading>⏳ Processando...</span>
                    </button>
                </div>

                <div class="end p-4 border-t">
                    @foreach ($this->recentExports as $export)
                        <a href="{{ $export['url'] }}" class="block text-blue-600 hover:underline mb-1">
                            📥 {{ $export['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
