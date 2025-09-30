<?php

namespace App\Livewire;

use App\Models\EconomicGroup;
use App\Models\Flag;
use App\Rules\CnpjValidation;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class FlagForm extends Component
{
    public $showModal;
    public $flagId;
    public $name;
    public $cnpj;
    public $economic_group_id;
    public $groups;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'cnpj' => [
                'nullable',
                new CnpjValidation,
                Rule::unique('flags')->ignore($this->flagId)
            ],
            'economic_group_id' => 'required|exists:economic_groups,id'
        ];
    }

    public function mount()
    {
        $this->groups = EconomicGroup::all();
    }

    #[On('open-modal')]
    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset(['flagId', 'name', 'cnpj', 'economic_group_id']);
        $this->showModal = true;
        if ($id) {
            $flag = Flag::findOrFail($id);
            $this->flagId = $flag->id;
            $this->name = $flag->name;
            $this->cnpj = $flag->cnpj;
            $this->economic_group_id = $flag->economic_group_id;
        }
    }

    public function save()
    {
        $this->validate();

        Flag::updateOrCreate(
            ['id' => $this->flagId],
            $this->only(['name', 'cnpj', 'economic_group_id'])
        );
        $this->dispatch('notify', type: 'success', message: 'Bandeira salva com sucesso!');
        $this->showModal = false;
        $this->dispatch('refresh-table');
    }
    public function render()
    {
        return view('livewire.flag-form');
    }
}
