<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Employee::with('cards')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Nº Identificação',
            'Departamento',
            'Cargo',
            'Email',
            'Telefone',
            'Status',
            'Cartões Emitidos',
            'Data Criação'
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->name,
            $employee->identification_number,
            $employee->department,
            $employee->position,
            $employee->email,
            $employee->phone,
            $employee->status,
            $employee->cards->count(),
            $employee->created_at->format('d/m/Y')
        ];
    }
}
