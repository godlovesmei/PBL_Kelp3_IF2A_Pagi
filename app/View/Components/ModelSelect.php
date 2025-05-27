<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class ModelSelect extends Component
{
    public $categories;
    public $models;
    public $selected;
    public $selectedCategory;

    /**
     * Create a new component instance.
     */
    public function __construct($selected = null, $selectedCategory = null)
    {
        // Ambil daftar kategori unik (non null)
        $this->categories = DB::table('cars')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->values();

        // Ambil daftar model unik per kategori (group by category dan model)
        $this->models = DB::table('cars')
            ->select('id', 'category', 'model')
            ->whereNotNull('category')
            ->groupBy('category', 'model', 'id')
            ->orderBy('category')
            ->orderBy('model')
            ->get();

        $this->selected = $selected;
        $this->selectedCategory = $selectedCategory;
    }

    public function render()
    {
        return view('components.model-select');
    }
}
