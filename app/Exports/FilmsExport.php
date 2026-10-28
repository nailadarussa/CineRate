<?php

namespace App\Exports;

use App\Models\Film;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FilmsExport implements FromView, ShouldAutoSize, WithStyles
{
    public function view(): View
    {
        // Kita ambil semua data film
        return view('admin.films.export_excel', [
            'films' => Film::all()
        ]);
    }

    // Biar Header Tebal (Bold)
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}