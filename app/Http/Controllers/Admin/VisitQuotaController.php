<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VisitQuota;

class VisitQuotaController extends Controller
{
    public function index()
    {
        $quotas = VisitQuota::orderBy('date', 'desc')->paginate(20);
        return view('admin.quotas.index', compact('quotas'));
    }

    public function create()
    {
        return view('admin.quotas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:visit_quotas,date',
            'max_quota' => 'required|integer|min:1',
            'is_blocked' => 'boolean',
        ]);

        $validated['used_quota'] = 0;
        
        VisitQuota::create($validated);
        return redirect()->route('admin.quotas.index')->with('success', 'Kuota berhasil ditambahkan.');
    }

    public function edit(VisitQuota $quota)
    {
        return view('admin.quotas.edit', compact('quota'));
    }

    public function update(Request $request, VisitQuota $quota)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:visit_quotas,date,'.$quota->id,
            'max_quota' => 'required|integer|min:'.$quota->used_quota,
            'is_blocked' => 'boolean',
        ]);

        if(!$request->has('is_blocked')) {
            $validated['is_blocked'] = 0;
        }

        $quota->update($validated);
        return redirect()->route('admin.quotas.index')->with('success', 'Kuota berhasil diperbarui.');
    }

    public function destroy(VisitQuota $quota)
    {
        if ($quota->used_quota > 0) {
            return back()->with('error', 'Tidak dapat menghapus kuota karena sudah ada tiket yang dipesan pada tanggal ini.');
        }
        $quota->delete();
        return redirect()->route('admin.quotas.index')->with('success', 'Kuota berhasil dihapus.');
    }
}
