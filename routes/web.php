<?php

use Illuminate\Support\Facades\Route;
use App\Models\Doctor;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Surat;

Route::get('/', function () {
    return view('welcome');
});

Route::get('doctors/export-pdf', function () {

    $doctors = Doctor::all();

    $pdf = Pdf::loadView('pdf.doctors', [
        'doctors' => $doctors
    ])->setPaper('a4', 'landscape');

    return $pdf->download('doctors.pdf');
})->name('doctors.export-pdf');

Route::get('/surat/{record}/print', function (Surat $record) {
    $pdf = Pdf::loadView('pdf.surat', [
        'data' => $record
    ]);
    return $pdf->stream('Surat-Sakit.pdf');
})->name('surat.print');

