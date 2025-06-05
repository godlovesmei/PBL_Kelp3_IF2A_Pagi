<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brochure;

class BrochureController extends Controller
{
    public function index()
    {
        $brochures = Brochure::latest()->get();
        return view('pages.brochure', compact('brochures'));
    }
}
