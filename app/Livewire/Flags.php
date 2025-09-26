<?php

namespace App\Livewire;

use App\Models\EconomicGroup;
use App\Models\Flag;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Flags extends Component
{
    use WithPagination;

    public $search = '';
    public $economicGroupId = '';

    #[On('refresh-table')]
    public function render()
    {
        $flags = Flag::with('economicGroup')
            ->when($this->economicGroupId, function ($query) {
                $query->where('economic_group_id', $this->economicGroupId);
            })
            ->where('name', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        $groups = EconomicGroup::all(); // Para o filtro
        return view('livewire.flags', compact('flags','groups'));
    }
}
