<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

#[Layout('layouts.app')]
class AuditLogs extends Component
{
    use WithPagination;

    public $filters = [
        'user_id' => '',
        'event' => '',
        'auditable_type' => '',
        'start_date' => '',
        'end_date' => ''
    ];

    public function render()
    {
        $logs = Audit::with('user')
            ->when($this->filters['user_id'], function($query) {
                $query->where('user_id', $this->filters['user_id']);
            })
            ->when($this->filters['event'], function($query) {
                $query->where('event', $this->filters['event']);
            })
            ->when($this->filters['auditable_type'], function($query) {
                $query->where('auditable_type', $this->filters['auditable_type']);
            })
            ->when($this->filters['start_date'], function($query) {
                $query->whereDate('created_at', '>=', $this->filters['start_date']);
            })
            ->when($this->filters['end_date'], function($query) {
                $query->whereDate('created_at', '<=', $this->filters['end_date']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.audit-logs', compact('logs'));
    }
}