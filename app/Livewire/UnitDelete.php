<?php

namespace App\Livewire;

use App\Models\Unit;
use Livewire\Attributes\On;
use Livewire\Component;

class UnitDelete extends Component
{
    public $showModalDelete = false;
    public $unitToDelete;

    #[On('open-delete-modal')]
    public function openDeleteModal($id)
    {
        $this->unitToDelete = Unit::find($id);
        $this->showModalDelete = true;
    }

    public function confirmDelete()
    {
        try {
            $this->unitToDelete->delete();
            session()->flash('success', 'Unidade excluída com sucesso!');
            $this->showModalDelete = false;
            $this->dispatch('refresh-table');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir unidade.');
        }
    }

    public function render()
    {
        return view('livewire.unit-delete');
    }
}
