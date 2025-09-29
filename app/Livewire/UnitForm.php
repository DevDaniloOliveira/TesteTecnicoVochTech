<?php

namespace App\Livewire;

use App\Models\Unit;
use App\Models\Flag;
use App\Rules\CnpjValidation;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class UnitForm extends Component
{
    public $showModal;
    public $unitId;
    public $fantasy_name;
    public $social_reason;
    public $cnpj;
    public $flag_id;
    public $flags;

    protected function rules()
    {
        return [
            'fantasy_name' => 'required|min:3|max:255',
            'social_reason' => 'required|min:3|max:255',
            'cnpj' => [
                'nullable',
                new CnpjValidation,
                Rule::unique('units')->ignore($this->unitId)
            ],
            'flag_id' => 'required|exists:flags,id'
        ];
    }

    public function mount()
    {
        $this->flags = Flag::with('economicGroup')
            ->orderBy('name')
            ->get()
            ->map(function($flag){
                return [
                    'id' => $flag->id,
                    'name' => $flag->name . ' - ' . ($flag->economicGroup->name ?? '-')
                ];
            });
    }

    #[On('open-modal')]
    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset(['unitId', 'fantasy_name', 'social_reason', 'cnpj', 'flag_id']);
        $this->showModal = true;
        if ($id) {
            $unit = Unit::findOrFail($id);
            $this->unitId = $unit->id;
            $this->fantasy_name = $unit->fantasy_name;
            $this->social_reason = $unit->social_reason;
            $this->cnpj = $unit->cnpj;
            $this->flag_id = $unit->flag_id;
        }
    }

    public function save()
    {
        $this->validate();

        Unit::updateOrCreate(
            ['id' => $this->unitId],
            $this->only(['fantasy_name', 'social_reason', 'cnpj', 'flag_id'])
        );

        $this->showModal = false;
        $this->dispatch('refresh-table');
    }

    public function render()
    {
        return view('livewire.unit-form');
    }
}
