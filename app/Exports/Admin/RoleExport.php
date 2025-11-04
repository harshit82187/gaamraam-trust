<?php

namespace App\Exports\Admin;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RoleExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data->values();
    }

    public function collection()
    {
        return $this->data->map(function ($item, $index) {
            $modules = collect(json_decode($item->module ?? '[]'))
                ->map(function ($mod) {
                    return ucwords(str_replace('_', ' ', $mod));
                })
                ->implode(', ');

            return [
                $index + 1, // SL No
                $item->name ?? 'N/A',
                $modules ?: 'N/A',
                optional($item->created_at)->format('d-m-Y') ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SL',
            'Role Name',
            'Module Name',
            'Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => '000000']]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 90,
            'D' => 11,
        ];
    }
}
