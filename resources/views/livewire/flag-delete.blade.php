<div>
    @if($showModalDelete)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                <h2 class="text-xl font-bold mb-4 text-red-600">
                    Excluir Bandeira
                </h2>

                <div class="mb-4">
                    <p class="text-gray-700">
                        Tem certeza que deseja excluir a bandeira 
                        <strong>"{{ $flagToDelete->name ?? '' }}"</strong>?
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Esta ação não pode ser desfeita.
                    </p>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="$set('showModalDelete', false)"
                            class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                        Cancelar
                    </button>
                    <button type="button" wire:click="confirmDelete"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Confirmar Exclusão
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>