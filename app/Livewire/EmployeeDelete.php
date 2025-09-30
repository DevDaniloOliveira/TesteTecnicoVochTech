<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Attributes\On;
use Livewire\Component;

class EmployeeDelete extends Component
{
    public $showModalDelete = false;
    public $employeeToDelete;

    #[On('open-delete-modal')]
    public function openDeleteModal($id)
    {
        $this->employeeToDelete = Employee::find($id);
        $this->showModalDelete = true;
    }

    public function confirmDelete()
    {
        try {
            $this->employeeToDelete->delete();
            $this->dispatch('notify', type: 'success', message: 'Colaborador excluído com sucesso!');
            $this->showModalDelete = false;
            $this->dispatch('refresh-table');
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Erro ao excluir colaborador.');
        }
    }

    public function render()
    {
        return view('livewire.employee-delete');
    }
}
