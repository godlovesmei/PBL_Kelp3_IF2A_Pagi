<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarColor;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // Display car list for the logged-in dealer
    public function index(Request $request)
{
    $query = Car::where('dealer_id', Auth::user()->user_id);

    // Filter berdasarkan kategori jika ada
    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    // Fitur pencarian
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('car_code', 'like', "%{$search}%");
        });
    }

    // Sorting (default: terbaru)
    $sort = $request->input('sort', 'desc');
    $query->orderBy('created_at', $sort);

    // Hitung total mobil
    $totalCars = $query->count();

    // Pagination
    $cars = $query->paginate(12);

    return view('pages.dealer.index', compact('cars', 'totalCars'));
}


    // Display dealer dashboard
    public function dashboard()
    {
        $totalCars = Car::where('dealer_id', Auth::user()->user_id)->count();

        $totalOrders = Order::whereHas('car', function ($query) {
            $query->where('dealer_id', Auth::user()->user_id);
        })->count();

        return view('pages.dealer.dashboard', compact('totalCars', 'totalOrders'));
    }

    // Show form to add a new car
    public function create()
    {
        return view('pages.dealer.create');
    }

    // Store a new car
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
        'colors' => 'required|array',
        'colors.*.color_name' => 'required|string',
        'colors.*.hex' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
        'colors.*.alt_hex' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
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
        'dealer_id' => Auth::user()->user_id,
    ]);

    foreach ($request->colors as $colorData) {
        $car->colors()->create([
            'color_name' => trim($colorData['color_name']),
            'hex' => $colorData['hex'],
            'alt_hex' => $colorData['alt_hex'],
            'image_path' => $imageName,
        ]);
    }

    return redirect()->route('pages.dealer.index')->with('success', 'Car successfully added!');
}


    // Show form to edit a car
    public function edit(Car $car)
    {
        if ($car->dealer_id !== Auth::user()->user_id) {
            abort(403);
        }

        return view('pages.dealer.edit', compact('car'));
    }

    // Update car details
public function update(Request $request, Car $car)
{
    if ($car->dealer_id !== Auth::user()->user_id) {
        abort(403);
    }

    $request->validate([
        'brand' => 'required|string',
        'model' => 'required|string',
        'year' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'category' => 'required|string',
        'specifications' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'colors' => 'required|array',
        'colors.*.color_name' => 'required|string',
        'colors.*.hex' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
        'colors.*.alt_hex' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
    ]);

    if ($request->hasFile('image')) {
        if ($car->image && file_exists(public_path('images/' . $car->image))) {
            unlink(public_path('images/' . $car->image));
        }

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $car->image = $imageName;
    } else {
        $imageName = $car->image; // keep existing
    }

    $car->update([
        'brand' => $request->brand,
        'model' => $request->model,
        'year' => $request->year,
        'category' => $request->category,
        'specifications' => $request->specifications,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $imageName,
    ]);

    // Delete old colors and recreate
    $car->colors()->delete();

    foreach ($request->colors as $colorData) {
        $car->colors()->create([
            'color_name' => trim($colorData['color_name']),
            'hex' => $colorData['hex'],
            'alt_hex' => $colorData['alt_hex'],
            'image_path' => $imageName,
        ]);
    }

    return redirect()->route('pages.dealer.index')->with('success', 'Car successfully updated!');
}

    // Delete a car
    public function destroy(Car $car)
    {
        if ($car->dealer_id !== Auth::user()->user_id) {
            abort(403);
        }

        if ($car->image && file_exists(public_path('images/' . $car->image))) {
            unlink(public_path('images/' . $car->image));
        }

        $car->delete();
        return redirect()->route('pages.dealer.index')->with('success', 'Car successfully deleted!');
    }
}
