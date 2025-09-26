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
            
            session()->flash('success', 'Grupo excluído com sucesso!');
            $this->showModalDelete = false;
            $this->dispatch('refresh-table');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir grupo.');
        }
    }
    
    public function render()
    {
        return view('livewire.economic-group-delete');
    }
}
