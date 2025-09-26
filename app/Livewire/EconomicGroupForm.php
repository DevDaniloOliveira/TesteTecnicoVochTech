<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EconomicGroup;
use App\Rules\CnpjValidation;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class EconomicGroupForm extends Component
{
    public $showModal;
    public $groupId;
    public $name;
    public $cnpj;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'cnpj' => [
                'nullable',
                new CnpjValidation,
                Rule::unique('economic_groups')->ignore($this->groupId)
            ],
        ];
    }

    #[On('open-modal')]
    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset(['groupId', 'name', 'cnpj']);
        $this->showModal = true;
        if ($id) {
            $group = EconomicGroup::findOrFail($id);
            $this->groupId = $group->id;
            $this->name = $group->name;
            $this->cnpj = $group->cnpj;
        }
    }

    public function save()
    {
        $this->validate();

        EconomicGroup::updateOrCreate(
            ['id' => $this->groupId],
            $this->only(['name', 'cnpj'])
        );

        $this->showModal = false;
        $this->dispatch('refresh-table');
    }

    public function render()
    {
        return view('livewire.economic-group-form');
    }
}
