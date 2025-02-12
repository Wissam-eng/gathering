<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\newsletter;

class newsletterExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return newsletter::select('email', 'created_at')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['Email', 'Registered At'];
    }

    public function map($row): array
    {
        return [
            $row->email,
            $row->created_at->format('Y-m-d H:i:s') // تنسيق التاريخ بطريقة واضحة
        ];
    }
}
