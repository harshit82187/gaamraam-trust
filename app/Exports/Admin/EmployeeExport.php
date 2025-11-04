<?php

namespace App\Exports\Admin;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class EmployeeExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data->values();
    }

    public function collection()
    {
        return $this->data->where('id', '!=', 1)->values()->map(function ($item, $index) {
            $roleName = optional($item->role)->name ?? 'N/A';
            $accessModules = collect(json_decode(optional($item->role)->module ?? '[]'))
                        ->map(function ($mod) {
                            return ucwords(str_replace('_', ' ', $mod));
                        })
                        ->implode(', ');

            return [
                $index + 1, 
                $item->name ?? 'N/A',
                $item->mobile_no ?? 'N/A',
                $item->email ?? 'N/A',
                $roleName,
                $accessModules ?: 'N/A',
                optional($item->created_at)->format('d-m-Y') ?? 'N/A',
                $item->status == 1 ? 'Active' : 'In-Active',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SL',
            'Employee Name',
            'Mobile No',
            'Email',
            'Role',
            'Access',
            'Date Of joining',
            'Status'

        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], 
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2a2f5b'], 
            ],
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 30,
            'C' => 20,
            'D' => 30,
            'E' => 25,
            'F' => 90,
            'G' => 11,
            'H' => 11,
        ];
    }
}
