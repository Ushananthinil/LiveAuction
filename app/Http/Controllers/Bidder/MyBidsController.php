<?php

namespace App\Http\Controllers\Bidder;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class MyBidsController extends Controller
{
    public function index()
    {
        $bids = Bid::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bidder.mybids.index', compact('bids'));
    }
}
