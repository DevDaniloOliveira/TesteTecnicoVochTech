<?php

namespace App\Livewire;

use App\Models\Flag;
use App\Models\Unit;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Units extends Component
{
    use WithPagination;
    public $search = '';
    public $flagId = '';
    public $flags = [];

    public function mount()
    {
        $this->flags = cache()->remember('flags.select.all',3600, function(){
            return Flag::with('economicGroup')
            ->select('id','name','economic_group_id')
            ->orderBy('name')
            ->get()
            ->map(function($flag){
                return [
                    'id' => $flag->id,
                    'name' => "{$flag->name} - {$flag->economicGroup->name}"
                ];
            });
        });
    }

    #[On('refresh-table')]
    public function render()
    {
        $units = Unit::with('flag')
            ->when($this->flagId, function ($query) {
                $query->where('flag_id', $this->flagId);
            })
            ->where('fantasy_name', 'like', "%{$this->search}%")
            ->orWhere('social_reason', 'like', "%{$this->search}%")
            ->orWhere('cnpj', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.units',compact('units'));
    }
}
