<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Unit;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Employees extends Component
{
    use WithPagination;
    
    public $search = '';
    public $unitId = '';
    public $units = [];
    
    public function mount()
    {
        $this->units = cache()->remember('units.select.all',3600, function(){
            return Unit::with('flag')
            ->select('id','fantasy_name','flag_id')
            ->orderBy('fantasy_name')
            ->get();
        });
    }

    #[On('refresh-table')]
    public function render()
    {
        $employees = Employee::with('unit')
            ->when($this->unitId, function ($query) {
                $query->where('unit_id', $this->unitId);
            })
            ->where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->orWhere('cpf', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.employees',compact('employees'));
    }
}
