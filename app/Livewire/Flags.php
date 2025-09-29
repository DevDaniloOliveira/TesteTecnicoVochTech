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
    public $groups = [];

    public function mount()
    {
        $this->groups = cache()->remember('economic-groups.select.all',3600, function(){
            return EconomicGroup::select('id','name')
            ->orderBy('name')
            ->get();
        });
    }

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

        return view('livewire.flags', compact('flags'));
    }
}
