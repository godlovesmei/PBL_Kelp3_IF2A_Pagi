<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Tampilkan semua gallery berdasarkan mobil dan tipe
    public function index(Request $request)
    {
        $carId = $request->query('car_id');
        $type = $request->query('type');
        $car = Car::findOrFail($carId);

        $galleries = $car->galleries()->where('type', $type)->get();

        $eksteriorImages = $car->galleries()->where('type', 'eksterior')->get()
    ->map(function($g) {
        return [
            'url' => asset('storage/galleries/' . $g->image_path),
            'caption' => $g->caption ?? '',
        ];
    });
$interiorImages = $car->galleries()->where('type', 'interior')->get()
    ->map(function($g) {
        return [
            'url' => asset('storage/galleries/' . $g->image_path),
            'caption' => $g->caption ?? '',
        ];
    });

return view('pages.dealer.gallery-index', compact('car', 'type', 'galleries', 'eksteriorImages', 'interiorImages'));
    }

    // Form tambah gambar
    public function create(Request $request)
    {
        $car = Car::findOrFail($request->query('car_id'));
        $type = $request->query('type');

        return view('pages.dealer.gallery-create', compact('car', 'type'));
    }

    // Simpan gambar baru
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'type' => 'required|in:eksterior,interior',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
            $filename = basename($path);

            Gallery::create([
                'car_id' => $request->car_id,
                'type' => $request->type,
                'image_path' => $filename,
                'caption' => $request->caption,
            ]);

            return redirect()->route('dealer.gallery.index', [
                'car_id' => $request->car_id,
                'type' => $request->type,
            ])->with('success', 'Image added successfully!');
        }

        return back()->withErrors(['image' => 'Image upload failed.']);
    }

    // Form edit gambar
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $car = $gallery->car;

        return view('pages.dealer.gallery-edit', [
            'gallery' => $gallery,
            'car' => $car,
            'type' => $gallery->type,
        ]);
    }

    // Update gambar
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'caption' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ganti gambar jika di-upload ulang
        if ($request->hasFile('image')) {
            // Hapus file lama
            if ($gallery->image_path && Storage::disk('public')->exists('galleries/' . $gallery->image_path)) {
                Storage::disk('public')->delete('galleries/' . $gallery->image_path);
            }

            // Simpan file baru
            $path = $request->file('image')->store('galleries', 'public');
            $gallery->image_path = basename($path);
        }

        $gallery->caption = $request->caption;
        $gallery->save();

        return redirect()->route('dealer.gallery.index', [
            'car_id' => $gallery->car_id,
            'type' => $gallery->type,
        ])->with('success', 'Image updated successfully!');
    }

    // Hapus gambar
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $car_id = $gallery->car_id;
        $type = $gallery->type;

        if ($gallery->image_path && Storage::disk('public')->exists('galleries/' . $gallery->image_path)) {
            Storage::disk('public')->delete('galleries/' . $gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('dealer.gallery.index', [
            'car_id' => $car_id,
            'type' => $type,
        ])->with('success', 'Image deleted.');
    }
}
