<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('pages.user.transactions');
        }

        $custId = Auth::user()->user_id;

        $transactions = Transactions::with('car')
            ->where('cust_id', $custId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.user.transactions', compact('transactions'));
    }
}