<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\BidPlaced;

class BidController extends Controller
{
    // Admin view - list all bids
    public function index()
    {
        $bids = Bid::with(['product', 'user'])->latest()->get();
        return view('admin.bids.index', compact('bids'));
    }

    // Bidder places bid
    public function store(Request $request, Product $product)
    {
        $highest = $product->bids()->max('amount') ?? $product->starting_bid;

        $request->validate([
            'amount' => 'required|numeric|min:' . ($highest + 1),
        ]);

        // Check if this user already placed a bid
        $bid = Bid::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ],
            [
                'amount' => $request->amount
            ]
        );

        // Broadcast event
        broadcast(new BidPlaced($bid))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => 'Bid placed successfully!',
            'bid' => $bid
        ]);
    }

    // Fetch bids for live updates (AJAX polling)
    public function fetch(Product $product)
    {
        $bids = $product->bids()->with('user')->latest()->get();
        return response()->json($bids);
    }
}
