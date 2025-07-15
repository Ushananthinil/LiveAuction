<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class AuctionController extends Controller
{

public function show(Product $product)
{
    $product->load('bids.user');
    $highestBid = $product->bids()->max('amount') ?? $product->starting_bid;
    return view('auction.show', compact('product', 'highestBid'));
}


}
