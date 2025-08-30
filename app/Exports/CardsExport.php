<?php

namespace App\Exports;

use App\Models\Card;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CardsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Card::with(['employee', 'cardTemplate'])->get();
    }

    public function headings(): array
    {
        return [
            'Nº Série',
            'Colaborador',
            'Departamento',
            'Template',
            'Data Emissão',
            'Data Expiração',
            'Status',
            'Verificações'
        ];
    }

    public function map($card): array
    {
        return [
            $card->serial_number,
            $card->employee->name,
            $card->employee->department,
            $card->cardTemplate->name,
            $card->issued_date->format('d/m/Y'),
            $card->expiry_date->format('d/m/Y'),
            $card->status,
            $card->verificationLogs->count()
        ];
    }
}
