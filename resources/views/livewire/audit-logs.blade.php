<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Log de Auditoria') }}
    </h2>
</x-slot>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Filtros Básicos -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="mb-4 text-gray-900">
                        <h2 class="text-lg font-semibold mb-2">Filtros</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select wire:model.live="filters.event" class="border rounded p-2">
                            <option value="">Todos os Eventos</option>
                            <option value="created">Criado</option>
                            <option value="updated">Atualizado</option>
                            <option value="deleted">Excluído</option>
                        </select>

                        <input type="date" wire:model.live="filters.start_date" class="border rounded p-2"
                            placeholder="Data Início">
                        <input type="date" wire:model.live="filters.end_date" class="border rounded p-2"
                            placeholder="Data Fim">
                    </div>
                </div>

                <!-- Tabela de Logs -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">Data/Hora</th>
                                <th class="px-4 py-3 text-left">Usuário</th>
                                <th class="px-4 py-3 text-left">Ação</th>
                                <th class="px-4 py-3 text-left">Model</th>
                                <th class="px-4 py-3 text-left">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $log->user->name ?? 'Sistema' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span @class([
                                            'px-2 py-1 rounded text-xs',
                                            'bg-green-100 text-green-800' => $log->event === 'created',
                                            'bg-blue-100 text-blue-800' => $log->event === 'updated',
                                            'bg-red-100 text-red-800' => $log->event === 'deleted',
                                        ])>
                                            {{ $log->event }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ class_basename($log->auditable_type) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $log->auditable_id }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="p-4 border-t">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
