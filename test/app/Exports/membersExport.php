<?php

namespace App\Exports;

use App\Models\registerIn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class membersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return registerIn::select(
            'register_as',
            'first_name',
            'last_name',
            'email',
            'phone',
            'company',
            'job_title',
            'city',
            'created_at'
        )->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['Register As', 'First Name', 'Last Name', 'Email', 'Phone', 'Company', 'Job Title', 'City', 'Registered At'];
    }

    public function map($row): array
    {
        return [
            $row->register_as,
            $row->first_name,
            $row->last_name,
            $row->email,
            $row->phone,
            $row->company,
            $row->job_title,
            $row->city,
            $row->created_at->format('Y-m-d H:i:s'), // تنسيق التاريخ
        ];
    }
}
