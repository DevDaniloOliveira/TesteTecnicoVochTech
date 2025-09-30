<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Livewire\Reports;

class ReportExport implements FromCollection, WithHeadings
{
    public function __construct(public array $filters) {}
    
    public function collection()
    {
        $employees = (new Reports())->getEmployeesQuery($this->filters)->get();
        
        return $employees->map(function ($employee) {
            return [
                'name' => $employee->name,
                'email' => $employee->email,
                'cpf' => formatCpf($employee->cpf), // Formata CPF
                'unit' => $employee->unit->fantasy_name,
                'flag' => $employee->unit->flag->name,
                'economic_group' => $employee->unit->flag->economicGroup->name,
                'created_at' => $employee->created_at->format('d/m/Y H:i'),
            ];
        });
    }
    
    public function headings(): array
    {
        return [
            'Nome',
            'Email',
            'CPF', 
            'Unidade',
            'Bandeira',
            'Grupo Econômico',
            'Data de Cadastro'
        ];
    }
}