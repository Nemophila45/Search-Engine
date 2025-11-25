<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\View\View;

class VisitorNoteController extends Controller
{
    /**
     * Halaman publik berisi daftar lampiran rekam medis.
     */
    public function index(): View
    {
        $records = MedicalRecord::query()
            ->with('patient')
            ->whereNotNull('attachment_path')
            ->orderByDesc('tanggal_kunjungan')
            ->paginate(12);

        return view('visitor-notes.index', [
            'records' => $records,
        ]);
    }
}
