<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        $criterias = Criteria::with('subCriterias')->get();
        return view('admin.kriteria.index', compact('criterias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'tipe' => 'required|in:benefit,cost',
            'deskripsi' => 'nullable|string',
            'skala_min' => 'required|integer',
            'skala_max' => 'required|integer',
        ]);

        Criteria::create($validated);
        return redirect()->back()->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $criteria = Criteria::findOrFail($id);
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'tipe' => 'required|in:benefit,cost',
            'deskripsi' => 'nullable|string',
            'skala_min' => 'required|integer',
            'skala_max' => 'required|integer',
        ]);

        $criteria->update($validated);
        return redirect()->back()->with('success', 'Kriteria berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $criteria = Criteria::findOrFail($id);
        $criteria->delete();
        return redirect()->back()->with('success', 'Kriteria berhasil dihapus!');
    }
}
