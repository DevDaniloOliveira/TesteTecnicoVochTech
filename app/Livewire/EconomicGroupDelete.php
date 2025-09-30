<?php

namespace App\Livewire;

use App\Models\EconomicGroup;
use Livewire\Attributes\On;
use Livewire\Component;

class EconomicGroupDelete extends Component
{
    public $showModalDelete = false;
    public $groupToDelete;

    #[On('open-delete-modal')]
    public function openDeleteModal($id)
    {
        $this->groupToDelete = EconomicGroup::find($id);
        $this->showModalDelete = true;
    }

    public function confirmDelete()
    {
        try {
            $this->groupToDelete->delete();
            $this->dispatch('notify', type: 'success', message: 'Grupo excluído com sucesso!');
            $this->showModalDelete = false;
            $this->dispatch('refresh-table');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Erro ao excluir grupo.');
        }
    }
    
    public function render()
    {
        return view('livewire.economic-group-delete');
    }
}
