<?php

namespace App\Jobs;

use App\Exports\ReportExport;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public array $filters,
        public User $user
    ) {}

    public function handle(): string
    {
        $fileName = 'colaboradores-' . now()->format('d-m-Y-H-i') . '.xlsx';
        $filePath = storage_path('app/exports/' . $fileName);
        
        Excel::store(new ReportExport($this->filters), 'exports/' . $fileName);
        
        return $filePath;
    }
}