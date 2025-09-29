<?php

namespace App\Livewire;

use App\Models\Flag;
use Livewire\Attributes\On;
use Livewire\Component;

class FlagDelete extends Component
{
    public $showModalDelete = false;
    public $flagToDelete;

    #[On('open-delete-modal')]
    public function openDeleteModal($id)
    {
        $this->flagToDelete = Flag::find($id);
        $this->showModalDelete = true;
    }

    public function confirmDelete()
    {
        try {
            $this->flagToDelete->delete();
            
            session()->flash('success', 'Bandeira excluída com sucesso!');
            $this->showModalDelete = false;
            $this->dispatch('refresh-table');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir bandeira.');
        }
    }
    
    public function render()
    {
        return view('livewire.flag-delete');
    }
}
