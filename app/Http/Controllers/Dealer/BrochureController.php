<?php

namespace App\Http\Controllers\Dealer;

use App\Models\Brochure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrochureController extends Controller
{
    // Fungsi helper untuk validasi akses brosur sesuai dealer login
    protected function authorizeBrochure($id)
    {
        $dealer = auth()->user()->dealer;

        if (!$dealer) {
            abort(403, 'Dealer not found');
        }

        return $dealer->brochures()->where('id', $id)->firstOrFail();
    }


    public function index(Request $request)
    {
        $search = $request->input('search');
        $dealer = auth()->user()->dealer;

        if (!$dealer) {
            abort(403, 'Dealer not found');
        }

        $brochures = $dealer->brochures()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        $brochures->appends(['search' => $search]);

        return view('pages.dealer.brochure-index', compact('brochures'));
    }


    public function create()
    {
        return view('pages.dealer.brochure-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'month' => 'required|string|max:20',
            'year' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'pdf_path' => 'required|file|mimes:pdf|max:5120',
            'image_path' => 'nullable|image|max:5120',
        ]);

        $dealer = auth()->user()->dealer;

        $pdfFile = $request->file('pdf_path');
        $pdfPath = $pdfFile->store('brochures/pdf', 'public');
        $pdfSize = round($pdfFile->getSize() / 1024 / 1024, 2);

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('brochures/images', 'public');
        }

        $dealer->brochures()->create([
            'title' => $request->title,
            'month' => $request->month,
            'year' => $request->year,
            'pdf_path' => $pdfPath,
            'image_path' => $imagePath,
            'size' => $pdfSize,
        ]);

        return redirect()->route('pages.dealer.brochure.index')->with('success', 'Brochure added successfully!');
    }

    public function edit($id)
    {
        $brochure = $this->authorizeBrochure($id);

        return view('pages.dealer.brochure-edit', compact('brochure'));
    }

    public function update(Request $request, $id)
    {
        $brochure = $this->authorizeBrochure($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'month' => 'required|string|max:20',
            'year' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'pdf_path' => 'nullable|file|mimes:pdf|max:5120',
            'image_path' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('pdf_path')) {
            if ($brochure->pdf_path) {
                Storage::disk('public')->delete($brochure->pdf_path);
            }
            $pdfFile = $request->file('pdf_path');
            $brochure->pdf_path = $pdfFile->store('brochures/pdf', 'public');
            $brochure->size = round($pdfFile->getSize() / 1024 / 1024, 2);
        }

        if ($request->hasFile('image_path')) {
            if ($brochure->image_path) {
                Storage::disk('public')->delete($brochure->image_path);
            }
            $brochure->image_path = $request->file('image_path')->store('brochures/images', 'public');
        }

        $brochure->title = $request->title;
        $brochure->month = $request->month;
        $brochure->year = $request->year;
        $brochure->save();

        return redirect()->route('pages.dealer.brochure.index')->with('success', 'Brochure updated successfully.');
    }

    public function destroy($id)
    {
        $brochure = $this->authorizeBrochure($id);

        if ($brochure->pdf_path) {
            Storage::disk('public')->delete($brochure->pdf_path);
        }

        if ($brochure->image_path) {
            Storage::disk('public')->delete($brochure->image_path);
        }

        $brochure->delete();

        return redirect()->route('pages.dealer.brochure.index')->with('success', 'Brochure deleted successfully.');
    }
}
