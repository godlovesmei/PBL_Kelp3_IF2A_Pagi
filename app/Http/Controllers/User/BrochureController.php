<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brochure;

class BrochureController extends Controller
{
   public function index()
{
    $brochures = Brochure::all()->sortByDesc(function ($item) {
        $monthNumber = date_parse($item->month)['month'] ?? 0;
        return sprintf('%04d%02d', $item->year, $monthNumber);
    })->values(); // <- tambahkan values() jika ingin reindex

    return view('pages.brochure', compact('brochures'));
}
}
