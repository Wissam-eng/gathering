<?php
namespace App\Exports;

use App\Models\contactus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactUsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return contactus::select('name', 'mobile', 'email', 'goal', 'created_at')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Phone', 'Email', 'Goal', 'Registered At'];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->mobile,
            $row->email,
            $row->goal,
            $row->created_at->format('Y-m-d H:i:s'), // تنسيق التاريخ
        ];
    }
}
