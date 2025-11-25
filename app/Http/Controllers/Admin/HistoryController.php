<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HistoryController extends Controller
{
    /**
     * Tampilkan daftar aktivitas terbaru.
     */
    public function index(): View
    {
        $logs = ActivityLog::query()
            ->with('user')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.history.index', [
            'logs' => $logs,
        ]);
    }

    /**
     * Bersihkan seluruh log aktivitas.
     */
    public function destroy(): RedirectResponse
    {
        ActivityLog::truncate();

        return redirect()
            ->route('admin.history.index')
            ->with('status', 'History aktivitas berhasil dibersihkan.');
    }
}
