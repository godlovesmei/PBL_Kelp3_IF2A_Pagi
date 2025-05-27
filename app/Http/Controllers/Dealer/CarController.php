<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarColor;

class CarController extends Controller
{
    // Display car list
    public function index()
    {
        $cars = Car::all();
        $totalCars = $cars->count();

        return view('pages.dealer.index', compact('cars', 'totalCars'));
    }

    // Display dashboard
    public function dashboard()
    {
        $totalCars = Car::count();

        return view('pages.dealer.dashboard', compact('totalCars'));
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
                'image_path' => $imageName,
            ]);
        }

        return redirect()->route('pages.dealer.index')->with('success', 'Car successfully added!');
    }

    // Show form to edit a car
    public function edit(Car $car)
    {
        return view('pages.dealer.edit', compact('car'));
    }

    // Update car details
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'image' => $car->image, // Save new or existing image
        ]);

        $car->colors()->delete();

        $colors = is_array($request->color) ? $request->color : explode(',', $request->color);
        foreach ($colors as $color) {
            $car->colors()->create([
                'color_name' => trim($color),
                'image_path' => $car->image,
            ]);
        }

        return redirect()->route('pages.dealer.index')->with('success', 'Car successfully updated!');
    }

    // Delete a car
    public function destroy(Car $car)
    {
        if ($car->image && file_exists(public_path('images/' . $car->image))) {
            unlink(public_path('images/' . $car->image));
        }

        $car->delete();
        return redirect()->route('pages.dealer.index')->with('success', 'Car successfully deleted!');
    }
}