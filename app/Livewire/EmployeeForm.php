<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Unit;
use App\Rules\CpfValidation;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EmployeeForm extends Component
{
    public $showModal;
    public $employeeId;
    public $name;
    public $email;
    public $cpf;
    public $unit_id;
    public $units;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'cpf' => [
                'required',
                new CpfValidation,
                Rule::unique('employees')->ignore($this->employeeId)
            ],
            'unit_id' => 'required|exists:units,id'
        ];
    }

    public function mount()
    {
        $this->units = Unit::orderBy('fantasy_name')->get();
    }

    #[On('open-modal')]
    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset(['employeeId', 'name', 'email', 'cpf', 'unit_id']);
        $this->showModal = true;
        if ($id) {
            $employee = Employee::findOrFail($id);
            $this->employeeId = $employee->id;
            $this->name = $employee->name;
            $this->email = $employee->email;
            $this->cpf = $employee->cpf;
            $this->unit_id = $employee->unit_id;
        }
    }

    public function save()
    {
        $this->validate();

        Employee::updateOrCreate(
            ['id' => $this->employeeId],
            $this->only(['name', 'email', 'cpf', 'unit_id'])
        );

        $this->showModal = false;
        $this->dispatch('refresh-table');
    }

    public function render()
    {
        return view('livewire.employee-form');
    }
}
