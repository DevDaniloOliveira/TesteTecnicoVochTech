<?php

namespace App\Livewire;

use App\Jobs\ExportReportJob;
use Livewire\Component;
use App\Models\Employee;
use App\Models\EconomicGroup;
use App\Models\Flag;
use App\Models\Unit;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Reports extends Component
{
    use WithPagination;

    public $filters = [
        'economic_group_id' => '',
        'flag_id' => '',
        'unit_id' => '',
        'search' => ''
    ];

    public $economicGroups = [];
    public $flags = [];
    public $units = [];

    public function mount()
    {
        $this->economicGroups = EconomicGroup::orderBy('name')->get();
        $this->loadFlags();
        $this->loadUnits();
    }

    public function loadFlags()
    {
        $this->flags = Flag::when($this->filters['economic_group_id'], function ($query) {
            $query->where('economic_group_id', $this->filters['economic_group_id']);
        })->orderBy('name')->get();

        $this->filters['flag_id'] = ''; // Reset flag quando grupo muda
        $this->loadUnits();
    }

    public function loadUnits()
    {
        $this->units = Unit::when($this->filters['flag_id'], function ($query) {
            $query->where('flag_id', $this->filters['flag_id']);
        })->orderBy('fantasy_name')->get();

        $this->filters['unit_id'] = ''; // Reset unit quando flag muda
    }

    public function updatedFilters($value, $key)
    {
        if ($key === 'economic_group_id') {
            $this->loadFlags();
        }

        if ($key === 'flag_id') {
            $this->loadUnits();
        }

        $this->resetPage();
    }

    public function export()
    {
        ExportReportJob::dispatch($this->filters, auth()->user());

        $this->dispatch('notify', type: 'info', message: 'Exportação iniciada. O arquivo será processado em background.');
    }

    public function getRecentExportsProperty()
    {
        $files = Storage::files('exports');

        return collect($files)
            ->filter(fn($file) => str_contains($file, 'colaboradores-'))
            ->sortDesc()
            ->take(5)
            ->map(fn($file) => [
                'name' => basename($file),
                'url' => route('exports.download', basename($file)),
                'date' => Storage::lastModified($file)
            ]);
    }

    public function getEmployeesQuery()
    {
        return Employee::with(['unit.flag.economicGroup'])
            ->when($this->filters['economic_group_id'], function ($query) {
                $query->whereHas('unit.flag', function ($q) {
                    $q->where('economic_group_id', $this->filters['economic_group_id']);
                });
            })
            ->when($this->filters['flag_id'], function ($query) {
                $query->whereHas('unit', function ($q) {
                    $q->where('flag_id', $this->filters['flag_id']);
                });
            })
            ->when($this->filters['unit_id'], function ($query) {
                $query->where('unit_id', $this->filters['unit_id']);
            })
            ->when($this->filters['search'], function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->filters['search']}%")
                        ->orWhere('email', 'like', "%{$this->filters['search']}%")
                        ->orWhere('cpf', 'like', "%{$this->filters['search']}%");
                });
            })
            ->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $employees = $this->getEmployeesQuery()->paginate(10);

        return view('livewire.reports', compact('employees'));
    }
}
