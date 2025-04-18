<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarColor;

class CarController extends Controller
{
    // Menampilkan daftar mobil
    public function index()
    {
    $cars = Car::all();
    $total_mobil = $cars->count(); // ini sudah benar

    return view('dealer.mobil', compact('cars', 'total_mobil'));
    }
    public function dashboard()
    {
        $totalMobil = Car::count();

    return view('dealer.dashboard', compact('totalMobil'));
    }
    // Menampilkan form untuk menambah mobil
    public function create()
    {
        return view('dealer.mobil-create');
    }

    // Menyimpan data mobil baru
    public function store(Request $request)
{
    $request->validate([
        'brand' => 'required|string',
        'model' => 'required|string',
        'year' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'category' => 'required|string',
        'specifications' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'color' => 'required',
    ]);

    $image = $request->file('image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('images'), $imageName);

    $car = Car::create([
        'brand' => $request->brand,
        'model' => $request->model,
        'year' => $request->year,
        'image' => $imageName,
        'category' => $request->category,
        'specifications' => $request->specifications,
        'price' => $request->price,
        'stock' => $request->stock,
    ]);

    $colors = is_array($request->color) ? $request->color : explode(',', $request->color);
    foreach ($colors as $color) {
        $car->colors()->create([
            'color_name' => trim($color),
            'image_path' => $imageName
        ]);
    }

    return redirect()->route('dealer.mobil')->with('success', 'Mobil berhasil ditambahkan!');
}

    // Menampilkan form edit mobil
    public function edit(Car $car)
    {
        return view('dealer.mobil-edit', compact('car'));
    }

    // Memperbarui data mobil
    public function update(Request $request, Car $car)
{
    $request->validate([
        'brand' => 'required|string',
        'model' => 'required|string',
        'year' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category' => 'required|string',
        'specifications' => 'required|string',
        'color' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
    ]);

    if ($request->hasFile('image')) {
        if ($car->image && file_exists(public_path('images/' . $car->image))) {
            unlink(public_path('images/' . $car->image));
        }

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $car->image = $imageName;
    }

    $car->update([
        'brand' => $request->brand,
        'model' => $request->model,
        'year' => $request->year,
        'category' => $request->category,
        'specifications' => $request->specifications,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $car->image // simpan image baru atau lama
    ]);

    // Hapus warna lama
    $car->colors()->delete();

    // Tambah warna baru
    $colors = is_array($request->color) ? $request->color : explode(',', $request->color);
    foreach ($colors as $color) {
        $car->colors()->create([
            'color_name' => trim($color),
            'image_path' => $car->image
        ]);
    }

    return redirect()->route('dealer.mobil')->with('success', 'Mobil berhasil diperbarui!');
}
    // Menampilkan form tambah warna
    public function tambahWarna(Car $car)
    {
        return view('dealer.mobil-tambah-warna', compact('car'));
    }

    // Menyimpan warna tambahan
    public function simpanWarna(Request $request, Car $car)
    {
        $request->validate([
            'color_name' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        $car->colors()->create([
            'color_name' => $request->color_name,
            'image_path' => $imageName
        ]);

        return back()->with('success', 'Warna berhasil ditambahkan!');
    }

    // Menghapus mobil
    public function destroy(Car $car)
    {
        if ($car->image && file_exists(public_path('images/' . $car->image))) {
            unlink(public_path('images/' . $car->image));
        }

        $car->delete();
        return redirect()->route('dealer.mobil')->with('success', 'Mobil berhasil dihapus!');
    }

    // Opsional: Menghapus warna tertentu
    public function hapusWarna($id)
    {
        $color = CarColor::findOrFail($id);

        if ($color->image_path && file_exists(public_path('images/' . $color->image_path))) {
            unlink(public_path('images/' . $color->image_path));
        }

        $color->delete();

        return back()->with('success', 'Warna berhasil dihapus!');
    }
    
}
