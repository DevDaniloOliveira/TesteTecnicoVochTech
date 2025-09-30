<?php

namespace App\Livewire;

use App\Models\EconomicGroup;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class EconomicGroups extends Component
{
    use WithPagination;

    public $search = '';

    #[On('refresh-table')]
    public function render()
    {
        $groups = EconomicGroup::where('name', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.economic-groups', compact('groups'));
    }

}
